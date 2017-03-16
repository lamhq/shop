/*
 * javascript for shop module
 */
app = Object.assign(app, {

	setupProductList: function() {
		$('.product-toolbar select').change(function () {
			location.href = this.value;
		});
	},

	setupAddToCartButton: function () {
		$(document).on('click', '.btn-cart', function () {
			var $button = $(this);
			var prodId = $button.data('product');
			var csrf = $button.find('input[name=_csrf]').val();
			$.ajax({
				url: app.baseUrl+'/shop/cart/add',
				type: 'post',
				data: { productId: prodId, qty: 1, _csrf: csrf },
				dataType: 'json',
				beforeSend: function() {
					$button.button('loading');
				},
				complete: function() {
					$button.button('reset');
				},
				success: function(json) {
					if (json.redirect) {
						location = json.redirect;
					}

					app.showSuccess(json.message);
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});
	},

	setupProductDetailPage: function() {
		$('.thumbnails a').magnificPopup({
			type:'image',
			gallery:{ enabled:true }
		});

		app.setupCartForm();
	},

	setupCartForm: function() {
		var $cartForm = $('.cart-section');
		$cartForm.on('submit', '.add-cart-form', function(e) {
			e.preventDefault();
			var $form = $(this);
			var $button = $form.find('button[type=submit]');
			$.ajax({
				url: $form.attr('action'),
				type: 'post',
				data: $form.serializeArray(),
				dataType: 'json',
				beforeSend: function() {
					$button.button('loading');
				},
				complete: function() {
					$button.button('reset');
				},
				success: function(json) {
					if (json.redirect) {
						location = json.redirect;
					}

					$cartForm.html(json.cartForm);
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});
	},

	setupCartPage: function() {
		$('.btn-remove').click(function() {
			var id = $(this).data('item');
			$.ajax({
				url: app.baseUrl+'/shop/cart/remove',
				type: 'post',
				data: 'key=' + id,
				dataType: 'json',
				success: function(json) {
					location.reload();
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});

		});
	},

	setupCheckoutPage: function() {
		app.loadShippingSection();
	},

	loadShippingSection: function() {
		var $section = $('#collapse-shipping-address').closest('.panel');
		$section.find('.panel-body')
			.load(app.baseUrl+'/shop/checkout/shipping', app.setupShippingSection);
		$section.find('.panel-title')
			.wrapInner('<a href="#collapse-shipping-address" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle" aria-expanded="true"></a>');
		$section.find('.panel-title a')
			.append('<i class="fa fa-caret-down"></i>')
			.trigger('click');
	},

	setupShippingSection: function() {
		// show register section if user check register checkbox
		var updateRegisterSection = function() {
			$('.registration-section').toggle($('#checkoutform-register').prop('checked'));
		};
		$('#checkoutform-register').on('change', updateRegisterSection);
		updateRegisterSection();

		// send form data to server when clicking submit button
		$('#shippingForm').on('submit', function(e) {
			e.preventDefault();
			var $form = $(this);
			var $button = $form.find('button[type=submit]');
			$.ajax({
				url: $form.attr('action'),
				data: $form.serializeArray(),
				type: 'post',
				beforeSend: function() {
					$button.button('loading');
				},
				complete: function() {
					$button.button('reset');
				},
				success: function(response, status, xhr) {
					switch (typeof response) {
						case 'object':
							if (response.success) {
								console.log('success');
							} else {
								alert(response.message);
								console.log('fail');
							}
							break;
						case 'string':
							var $section = $('#collapse-shipping-address').closest('.panel');
							$section.find('.panel-body').html(response);
							app.setupShippingSection();
							break;
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});	

		var updateAddressSection = function() {
			$('#payment-existing,#payment-new').hide();
			$('.address-type:checked').closest('.radio').next().show();
			if ($('.address-type').length==0)
				$('#payment-new').show();
		};
		$('.address-type').click(updateAddressSection);
		updateAddressSection();
	}

});
