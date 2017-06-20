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

	setupProductList: function(target) {
		$(target).on('change', '.product-toolbar select', function () {
			app.load(target, {
				url: this.value,
				src: target
			});
		});
		$(target).on('click', '.pagination a', function (e) {
			e.preventDefault();
			app.load(target, {
				url: this.href,
				src: target
			});
		});
	},

	setupProductDetailPage: function() {
		// setup product gallery
		$('.thumbnails a').magnificPopup({
			type:'image',
			gallery:{ enabled:true }
		});

		// setup review form
		var $reviewForm = $('#reviewForm');
		$reviewForm.on('submit', 'form', function(e) {
			e.preventDefault();
			var $form = $(this);
			var $button = $form.find('button[type=submit]');
			app.load($reviewForm, {
				url: $form.attr('action'),
				type: 'post',
				data: $form.serializeArray(),
				beforeSend: function() {
					$button.button('loading');
				},
				complete: function() {
					$button.button('reset');
				}
			});
		});

		app.setupAddToCartForm();
		app.loadReviews()
		.then(app.loadReviewForm);
	},

	loadReviews: function () {
		var $reviewSection = $('#reviews');
		return app.load($reviewSection, {
			url: app.baseUrl+'/shop/review/index',
			type: 'get',
			data: { productId: $reviewSection.data('product-id') }
		});
	},

	loadReviewForm: function () {
		var $reviewForm = $('#reviewForm');
		return app.load($reviewForm, {
			url: app.baseUrl+'/shop/review/form',
			type: 'get',
			data: { productId: $reviewForm.data('product-id') }
		});
	},

	removeCartItem: function(id) {
		var data = { key: id };
		data[app.getCsrfParamName()] = app.getCsrfParamValue();

		return app.ajax({
			url: app.baseUrl+'/shop/cart/remove',
			type: 'post',
			data: data,
			dataType: 'json'
		});
	},

	setupAddToCartButton: function () {
		$(document).on('click', '.btn-cart', function () {
			var $button = $(this);
			var prodId = $button.data('product');
			var data = { productId: prodId, qty: 1 };
			data[app.getCsrfParamName()] = app.getCsrfParamValue();

			app.ajax({
				url: app.baseUrl+'/shop/cart/add',
				type: 'post',
				data: data,
				dataType: 'json',
				beforeSend: function() {
					$button.button('loading');
				},
				complete: function() {
					$button.button('reset');
				}
			})
			.then(function (json, textStatus, jqXHR) {
				if (json.redirect) {
					location = json.redirect;
				}
				app.showSuccess(json.message);
				app.loadCartDropdown();
			});
		});
	},

	setupAddToCartForm: function() {
		var $cartForm = $('#cartForm');
		$cartForm.on('submit', 'form', function(e) {
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
			.then(function (json, textStatus, jqXHR) {
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
		return app.load('#cart', {
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
			.then(function () {
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
			.then(function () { location.reload(); });
		});

		app.setupCheckoutSection();
	},

	setupCheckoutSection: function() {
		$(window).load(function() {
			app.loadShippingSection()
				.then(app.loadPaymentSection)
				.then(app.loadReviewSection);
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
		// $('#shipping-section').on('change', 'select', onShippingChange);
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
			.then(function () {
				return app.ajax({
					url: app.baseUrl+'/shop/checkout/place-order',
					type: 'get',
					dataType: 'json'
				});
			})
			.then(function (json) {
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
		return app.load('#shipping-section', {
			url: app.baseUrl+'/shop/checkout/shipping',
			type: 'get'
		}).then(app.setupShipping);
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
			// save the empty option
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
		$('select.city').on('change', function () {
			var city = this.value;
			if (city=='') return;
			$.ajax({
				url: app.baseUrl+'/shop/default/districts',
				type: 'get',
				data: { city: city },
				dataType: 'json'
			})
			.then(function (json, textStatus, jqXHR) {
				if (typeof json === 'object') {
					setDropdownItems($('select.district'), json.districts);
				}
			});
		});

		// reload + reset ward dropdown when changing district
		$('select.district').on('change', function () {
			var district = this.value;
			if (district=='') return;
			$.ajax({
				url: app.baseUrl+'/shop/default/wards',
				type: 'get',
				data: { district: district },
				dataType: 'json'
			})
			.then(function (json, textStatus, jqXHR) {
				if (typeof json === 'object') {
					setDropdownItems($('select.ward'), json.wards);
				}
			});
		});

		$('.selectpicker').select2({
			theme: "bootstrap",
			width: 'resolve'
		});
	},

	loadPaymentSection: function() {
		return app.load('#payment-section', {
			url: app.baseUrl+'/shop/checkout/payment',
			type: 'get'
		});
	},

	loadReviewSection: function() {
		return app.load('#review-section', {
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
	},

	setupEditAccountPage: function() {
		// show change password section if user check change password checkbox
		var updateCPSection = function() {
			$('.cp-section')
				.toggle($('#accountform-changepassword').prop('checked'));
		};
		$('#accountform-changepassword').on('change', updateCPSection);
		updateCPSection();
	},

	setupNotifyJs: function () {
		$.notify.addStyle("bootstrap", {
			html: "<div>\n<span data-notify-html></span>\n</div>",
			classes: {
				base: {
					"font-weight": "bold",
					"padding": "8px 15px 8px 14px",
					"text-shadow": "0 1px 0 rgba(255, 255, 255, 0.5)",
					"background-color": "#fcf8e3",
					"border": "1px solid #fbeed5",
					"border-radius": "4px",
					"white-space": "nowrap",
					"padding-left": "25px",
					"background-repeat": "no-repeat",
					"background-position": "3px 7px"
				},
				error: {
					"color": "#B94A48",
					"background-color": "#F2DEDE",
					"border-color": "#EED3D7",
					"background-image": "url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAtRJREFUeNqkVc1u00AQHq+dOD+0poIQfkIjalW0SEGqRMuRnHos3DjwAH0ArlyQeANOOSMeAA5VjyBxKBQhgSpVUKKQNGloFdw4cWw2jtfMOna6JOUArDTazXi/b3dm55socPqQhFka++aHBsI8GsopRJERNFlY88FCEk9Yiwf8RhgRyaHFQpPHCDmZG5oX2ui2yilkcTT1AcDsbYC1NMAyOi7zTX2Agx7A9luAl88BauiiQ/cJaZQfIpAlngDcvZZMrl8vFPK5+XktrWlx3/ehZ5r9+t6e+WVnp1pxnNIjgBe4/6dAysQc8dsmHwPcW9C0h3fW1hans1ltwJhy0GxK7XZbUlMp5Ww2eyan6+ft/f2FAqXGK4CvQk5HueFz7D6GOZtIrK+srupdx1GRBBqNBtzc2AiMr7nPplRdKhb1q6q6zjFhrklEFOUutoQ50xcX86ZlqaZpQrfbBdu2R6/G19zX6XSgh6RX5ubyHCM8nqSID6ICrGiZjGYYxojEsiw4PDwMSL5VKsC8Yf4VRYFzMzMaxwjlJSlCyAQ9l0CW44PBADzXhe7xMdi9HtTrdYjFYkDQL0cn4Xdq2/EAE+InCnvADTf2eah4Sx9vExQjkqXT6aAERICMewd/UAp/IeYANM2joxt+q5VI+ieq2i0Wg3l6DNzHwTERPgo1ko7XBXj3vdlsT2F+UuhIhYkp7u7CarkcrFOCtR3H5JiwbAIeImjT/YQKKBtGjRFCU5IUgFRe7fF4cCNVIPMYo3VKqxwjyNAXNepuopyqnld602qVsfRpEkkz+GFL1wPj6ySXBpJtWVa5xlhpcyhBNwpZHmtX8AGgfIExo0ZpzkWVTBGiXCSEaHh62/PoR0p/vHaczxXGnj4bSo+G78lELU80h1uogBwWLf5YlsPmgDEd4M236xjm+8nm4IuE/9u+/PH2JXZfbwz4zw1WbO+SQPpXfwG/BBgAhCNZiSb/pOQAAAAASUVORK5CYII=)"
				},
				success: {
					"color": "#468847",
					"background-color": "#DFF0D8",
					"border-color": "#D6E9C6",
					"background-image": "url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAutJREFUeNq0lctPE0Ecx38zu/RFS1EryqtgJFA08YCiMZIAQQ4eRG8eDGdPJiYeTIwHTfwPiAcvXIwXLwoXPaDxkWgQ6islKlJLSQWLUraPLTv7Gme32zoF9KSTfLO7v53vZ3d/M7/fIth+IO6INt2jjoA7bjHCJoAlzCRw59YwHYjBnfMPqAKWQYKjGkfCJqAF0xwZjipQtA3MxeSG87VhOOYegVrUCy7UZM9S6TLIdAamySTclZdYhFhRHloGYg7mgZv1Zzztvgud7V1tbQ2twYA34LJmF4p5dXF1KTufnE+SxeJtuCZNsLDCQU0+RyKTF27Unw101l8e6hns3u0PBalORVVVkcaEKBJDgV3+cGM4tKKmI+ohlIGnygKX00rSBfszz/n2uXv81wd6+rt1orsZCHRdr1Imk2F2Kob3hutSxW8thsd8AXNaln9D7CTfA6O+0UgkMuwVvEFFUbbAcrkcTA8+AtOk8E6KiQiDmMFSDqZItAzEVQviRkdDdaFgPp8HSZKAEAL5Qh7Sq2lIJBJwv2scUqkUnKoZgNhcDKhKg5aH+1IkcouCAdFGAQsuWZYhOjwFHQ96oagWgRoUov1T9kRBEODAwxM2QtEUl+Wp+Ln9VRo6BcMw4ErHRYjH4/B26AlQoQQTRdHWwcd9AH57+UAXddvDD37DmrBBV34WfqiXPl61g+vr6xA9zsGeM9gOdsNXkgpEtTwVvwOklXLKm6+/p5ezwk4B+j6droBs2CsGa/gNs6RIxazl4Tc25mpTgw/apPR1LYlNRFAzgsOxkyXYLIM1V8NMwyAkJSctD1eGVKiq5wWjSPdjmeTkiKvVW4f2YPHWl3GAVq6ymcyCTgovM3FzyRiDe2TaKcEKsLpJvNHjZgPNqEtyi6mZIm4SRFyLMUsONSSdkPeFtY1n0mczoY3BHTLhwPRy9/lzcziCw9ACI+yql0VLzcGAZbYSM5CCSZg1/9oc/nn7+i8N9p/8An4JMADxhH+xHfuiKwAAAABJRU5ErkJggg==)"
				},
				info: {
					"color": "#3A87AD",
					"background-color": "#D9EDF7",
					"border-color": "#BCE8F1",
					"background-image": "url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH3QYFAhkSsdes/QAAA8dJREFUOMvVlGtMW2UYx//POaWHXg6lLaW0ypAtw1UCgbniNOLcVOLmAjHZolOYlxmTGXVZdAnRfXQm+7SoU4mXaOaiZsEpC9FkiQs6Z6bdCnNYruM6KNBw6YWewzl9z+sHImEWv+vz7XmT95f/+3/+7wP814v+efDOV3/SoX3lHAA+6ODeUFfMfjOWMADgdk+eEKz0pF7aQdMAcOKLLjrcVMVX3xdWN29/GhYP7SvnP0cWfS8caSkfHZsPE9Fgnt02JNutQ0QYHB2dDz9/pKX8QjjuO9xUxd/66HdxTeCHZ3rojQObGQBcuNjfplkD3b19Y/6MrimSaKgSMmpGU5WevmE/swa6Oy73tQHA0Rdr2Mmv/6A1n9w9suQ7097Z9lM4FlTgTDrzZTu4StXVfpiI48rVcUDM5cmEksrFnHxfpTtU/3BFQzCQF/2bYVoNbH7zmItbSoMj40JSzmMyX5qDvriA7QdrIIpA+3cdsMpu0nXI8cV0MtKXCPZev+gCEM1S2NHPvWfP/hL+7FSr3+0p5RBEyhEN5JCKYr8XnASMT0xBNyzQGQeI8fjsGD39RMPk7se2bd5ZtTyoFYXftF6y37gx7NeUtJJOTFlAHDZLDuILU3j3+H5oOrD3yWbIztugaAzgnBKJuBLpGfQrS8wO4FZgV+c1IxaLgWVU0tMLEETCos4xMzEIv9cJXQcyagIwigDGwJgOAtHAwAhisQUjy0ORGERiELgG4iakkzo4MYAxcM5hAMi1WWG1yYCJIcMUaBkVRLdGeSU2995TLWzcUAzONJ7J6FBVBYIggMzmFbvdBV44Corg8vjhzC+EJEl8U1kJtgYrhCzgc/vvTwXKSib1paRFVRVORDAJAsw5FuTaJEhWM2SHB3mOAlhkNxwuLzeJsGwqWzf5TFNdKgtY5qHp6ZFf67Y/sAVadCaVY5YACDDb3Oi4NIjLnWMw2QthCBIsVhsUTU9tvXsjeq9+X1d75/KEs4LNOfcdf/+HthMnvwxOD0wmHaXr7ZItn2wuH2SnBzbZAbPJwpPx+VQuzcm7dgRCB57a1uBzUDRL4bfnI0RE0eaXd9W89mpjqHZnUI5Hh2l2dkZZUhOqpi2qSmpOmZ64Tuu9qlz/SEXo6MEHa3wOip46F1n7633eekV8ds8Wxjn37Wl63VVa+ej5oeEZ/82ZBETJjpJ1Rbij2D3Z/1trXUvLsblCK0XfOx0SX2kMsn9dX+d+7Kf6h8o4AIykuffjT8L20LU+w4AZd5VvEPY+XpWqLV327HR7DzXuDnD8r+ovkBehJ8i+y8YAAAAASUVORK5CYII=)"
				},
				warn: {
					"color": "#C09853",
					"background-color": "#FCF8E3",
					"border-color": "#FBEED5",
					"background-image": "url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAMAAAC6V+0/AAABJlBMVEXr6eb/2oD/wi7/xjr/0mP/ykf/tQD/vBj/3o7/uQ//vyL/twebhgD/4pzX1K3z8e349vK6tHCilCWbiQymn0jGworr6dXQza3HxcKkn1vWvV/5uRfk4dXZ1bD18+/52YebiAmyr5S9mhCzrWq5t6ufjRH54aLs0oS+qD751XqPhAybhwXsujG3sm+Zk0PTwG6Shg+PhhObhwOPgQL4zV2nlyrf27uLfgCPhRHu7OmLgAafkyiWkD3l49ibiAfTs0C+lgCniwD4sgDJxqOilzDWowWFfAH08uebig6qpFHBvH/aw26FfQTQzsvy8OyEfz20r3jAvaKbhgG9q0nc2LbZxXanoUu/u5WSggCtp1anpJKdmFz/zlX/1nGJiYmuq5Dx7+sAAADoPUZSAAAAAXRSTlMAQObYZgAAAAFiS0dEAIgFHUgAAAAJcEhZcwAACxMAAAsTAQCanBgAAAAHdElNRQfdBgUBGhh4aah5AAAAlklEQVQY02NgoBIIE8EUcwn1FkIXM1Tj5dDUQhPU502Mi7XXQxGz5uVIjGOJUUUW81HnYEyMi2HVcUOICQZzMMYmxrEyMylJwgUt5BljWRLjmJm4pI1hYp5SQLGYxDgmLnZOVxuooClIDKgXKMbN5ggV1ACLJcaBxNgcoiGCBiZwdWxOETBDrTyEFey0jYJ4eHjMGWgEAIpRFRCUt08qAAAAAElFTkSuQmCC)"
				}
			}
		});
	},

});
