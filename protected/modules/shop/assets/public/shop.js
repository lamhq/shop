/*
 * javascript for shop module
 */
app = Object.assign(app, {
	setupMainMenu: function () {
		$('#menu .dropdown-menu').each(function() {
			var menu = $('#menu').offset();
			var dropdown = $(this).parent().offset();

			var i = (dropdown.left + $(this).outerWidth()) 
			- (menu.left + $('#menu').outerWidth());

			$(this).toggleClass('right-align', i > 0);
		});
	},

	setupProductList: function() {
		$('.product-toolbar select').change(function () {
			location.href = this.value;
		});
	},

	setupProductDetailPage: function() {
		$('.thumbnails a').magnificPopup({
			type:'image',
			gallery:{ enabled:true }
		});

		app.setupAddToCartForm();
	},

	removeCartItem: function(id) {
		return app.ajax({
			url: app.baseUrl+'/shop/cart/remove',
			type: 'post',
			data: { key: id, _csrf: $('meta[name=csrf-token]').attr('content') },
			dataType: 'json'
		});
	},

	setupAddToCartButton: function () {
		$(document).on('click', '.btn-cart', function () {
			var $button = $(this);
			var prodId = $button.data('product');
			var csrf = $button.find('input[name=_csrf]').val();
			app.ajax({
				url: app.baseUrl+'/shop/cart/add',
				type: 'post',
				data: { productId: prodId, qty: 1, _csrf: csrf },
				dataType: 'json',
				beforeSend: function() {
					$button.button('loading');
				},
				complete: function() {
					$button.button('reset');
				}
			})
			.done(function (json, textStatus, jqXHR) {
				if (json.redirect) {
					location = json.redirect;
				}
				app.showSuccess(json.message);
				app.loadCartDropdown();
			});
		});
	},

	setupAddToCartForm: function() {
		var $cartForm = $('.cart-section');
		$cartForm.on('submit', '.add-cart-form', function(e) {
			e.preventDefault();
			var $form = $(this);
			var $button = $form.find('button[type=submit]');
			app.ajax({
				url: $form.attr('action'),
				type: 'post',
				data: $form.serializeArray(),
				dataType: 'json',
				beforeSend: function() {
					$button.button('loading');
				},
				complete: function() {
					$button.button('reset');
				}
			})
			.done(function (json, textStatus, jqXHR) {
				if (json.redirect) {
					location = json.redirect;
				}

				if (json.success) {
					app.showSuccess(json.message);
				}
				$cartForm.html(json.cartForm);
				app.loadCartDropdown();
			});
		});
	},

	loadCartDropdown: function() {
		return app.load($('#cart'), {
			url: app.baseUrl+'/shop/checkout/dropdown',
		});
	},

	setupCartDropdown: function() {
		// remove cart item when clicking button remove
		$(document).on('click', '.cart-dropdown .btn-remove', function() {
			var id = $(this).data('item');
			var $button = $('#cart > button');
			$button.button('loading');
			app.removeCartItem(id)
			.done(function () {
				$button.button('reset');
				if ($('body').hasClass('cart-index')) {
					location.reload();
				} else {
					app.loadCartDropdown();
				}
			});
		});
	},

	setupCartPage: function() {
		// remove cart item when clicking button remove
		$('.cart-table .btn-remove').click(function() {
			var id = $(this).data('item');
			app.removeCartItem(id)
			.done(function () { location.reload(); });
		});

		app.setupCheckoutSection();
	},

	setupCheckoutSection: function() {
		$(function() {
			app.loadShippingSection()
				.always(app.loadPaymentSection)
				.always(app.loadReviewSection);
		});

		var lockSubmit = function () {
			$('.btn-order').button('loading');
		};

		var unlockSubmit = function () {
			$('.btn-order').button('reset');
		};

		var saveFormData = function (data) {
			return app.ajax({
				url: app.baseUrl+'/shop/checkout/save-data',
				type: 'post',
				data: data
			});
		};

		// reload payment section, review section on shipping change
		// var onShippingChange = function () {
			// lockSubmit();
			// saveFormData($('#shipping-section form').serializeArray())
			// .always(app.loadPaymentSection)
			// .always(app.loadReviewSection)
			// .always(unlockSubmit);
		// };
		// $('#shipping-section').on('select2:select', 'select', onShippingChange);
		// $('#shipping-section').on('change', 'input,#checkoutform-shippingaddressid', onShippingChange);

		// reload review section on payment change
		// var onPaymentChange = function () {
			// lockSubmit();
			// saveFormData($('#payment-section form').serializeArray())
			// .always(app.loadReviewSection)
			// .always(unlockSubmit);
		// };
		// $('#payment-section').on('change', 'input[type=radio],textarea', onPaymentChange);

		// save order when clicking place order button
		$(document).on('click', '.btn-order', function () {
			var data = $('#shipping-section form').serializeArray();
			data = data.concat($('#payment-section form').serializeArray());

			lockSubmit();
			saveFormData(data)
			.done(function () {
				return app.ajax({
					url: app.baseUrl+'/shop/checkout/place-order',
					type: 'post',
					dataType: 'json'
				});
			})
			.done(function (json) {
				if (json.redirect) {
					location = json.redirect;
				}

				if (!json.success) {
					$('#shipping-section').html(json.shipping);
					$('#payment-section').html(json.payment);
					$('#review-section').html(json.review);
					app.setupShipping();
				}
			})
			.always(unlockSubmit);
		});
	},

	loadShippingSection: function() {
		return app.load($('#shipping-section'), {
			url: app.baseUrl+'/shop/checkout/shipping',
			type: 'get'
		})
		.done(app.setupShipping);
	},

	setupShipping: function() {
		// if register account checkbox available, it must be guest checkout
		if ($('#checkoutform-register').length) {
			app.setupShippingGuest();
		} else {
			app.setupShippingLogged();
		}
	},

	setupShippingGuest: function() {
		app.setupAddressControls();

		// show register section if user check register checkbox
		var updateRegisterSection = function() {
			$('.registration-section')
				.toggle($('#checkoutform-register').prop('checked'));
		};
		$('#checkoutform-register').on('change', updateRegisterSection);
		updateRegisterSection();

		$('.field-address-name').hide();
		$('#checkoutform-name').change(function () {
			$('#address-name').val(this.value);
		});
	},

	setupShippingLogged: function() {
		app.setupAddressControls();

		// show address form when user select to add new address (logged checkout)
		var updateAddressSection = function() {
			$('#address-exist,#address-new').hide();
			$('.address-type:checked').closest('.radio').next().show();
			if ($('.address-type').length==0)
				$('#address-new').show();
		};
		$('.address-type').click(updateAddressSection);
		updateAddressSection();
	},

	setupAddressControls: function () {
		// update options of a select control
		var setDropdownItems = function ($dropdown, items) {
			var $option = $dropdown.find('option:first');
			$dropdown.empty();
			$dropdown.append($option);
			$(items).each(function() {
				var $option = $('<option></option>');
				$option.val(this.value);
				$option.text(this.label);
				$dropdown.append($option);
			});
			$dropdown.trigger('change');
		};

		// reload + reset district dropdown when changing city
		$('.city').change(function () {
			var city = this.value;
			if (city=='') return;
			$.ajax({
				url: app.baseUrl+'/shop/default/districts',
				type: 'get',
				data: { city: city },
				dataType: 'json'
			})
			.done(function (json, textStatus, jqXHR) {
				if (typeof json === 'object') {
					setDropdownItems($('.district'), json.districts);
				}
			});
		});

		// reload + reset ward dropdown when changing district
		$('.district').change(function () {
			var district = this.value;
			if (district=='') return;
			$.ajax({
				url: app.baseUrl+'/shop/default/wards',
				type: 'get',
				data: { district: district },
				dataType: 'json'
			})
			.done(function (json, textStatus, jqXHR) {
				if (typeof json === 'object') {
					setDropdownItems($('.ward'), json.wards);
				}
			});
		});

		$('.select2').select2({
			theme: "bootstrap",
			width: 'resolve'
		});
	},

	loadPaymentSection: function() {
		return app.load($('#payment-section'), {
			url: app.baseUrl+'/shop/checkout/payment',
			type: 'get'
		});
	},

	loadReviewSection: function() {
		return app.load($('#review-section'), {
			url: app.baseUrl+'/shop/checkout/review',
			type: 'get'
		});
	},

	setupSearchPage: function() {
		var updateFormState = function () {
			$('#insubcategory').prop('disabled', $('#categoryid').val()=='');
		}
		$('#categoryid').change(updateFormState);
		updateFormState();
	}
});
