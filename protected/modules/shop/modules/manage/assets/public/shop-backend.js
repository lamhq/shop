/*
 * javascript for shop module
 */
app = Object.assign(app, {

	setupProductForm: function () {
		// setup category tag input
		$('.selectpicker').select2();

		// setup redactor wyswyg widget
		app.wait(500).then(function () {
			app.setupRedactorUpload('#product-description');
		});
	},

	setupCategoryForm: function () {
		app.wait(500).then(function () {
			app.setupRedactorUpload('#category-description');
		});
	},

	setupOrderFilterForm: function() {
		$('#order-name').bsAutocomplete({
			source: function (request, response) {
				app.ajax({
					url: app.baseUrl+'/shop/manage/order/customer',
					data: { term: request },
					dataType: 'json'
				}).then(function (json) {
					response($.map(json, function(item) {
						return {
							value: item,
							label: item
						};
					}));
				});
			},
			select: function(item) {
				this.value = item.value;
			}
		});
	},

	getOrderForm: function() {
		return $('#orderForm');
	},

	setupOrderForm: function() {
		var reloadForm = function() {
			var orderForm = app.getOrderForm();
			// set the flag to inform server to not save this order
			data = orderForm.serializeArray();
			data.push({ name: 'reload', 'value':1 });

			return app.load(orderForm, {
				url: orderForm.attr('action'),
				method: 'post',
				data: data
			}).then(app.setupOrderForm);
		};

		// search customer
		$('#order-name').bsAutocomplete({
			source: function (request, response) {
				app.ajax({
					url: app.baseUrl+'/shop/manage/order/exist-customer',
					data: { term: request },
					dataType: 'json'
				}).then(function (json) {
					response(json);
				});
			},
			select: function(item) {
				this.value = item.label;
				$('#order-customer_id').val(item.value);
				$('#order-telephone').val(item.telephone);
				$('#order-email').val(item.email);
				reloadForm().then(function() {
					$('[href="#tab-customer"]').trigger('click');
				});
			}
		});

		// search product
		$('#input-product').bsAutocomplete({
			source: function (request, response) {
				app.ajax({
					url: app.baseUrl+'/shop/manage/order/product',
					data: { term: request },
					dataType: 'json'
				}).then(function (json) {
					response(json);
				});
			},
			select: function(item) {
				this.value = item.label;
				$(this).data('product', item);
				$('#input-product_id').val(item.value);
			}
		});

		// add product to cart
		$('#btnAddProduct').on('click', function() {
			var productId = $('#input-product_id').val();
			var quantity = parseInt($('#input-quantity').val());
			if ( productId=='' || isNaN(parseInt(quantity)) || quantity<=0 ) return;

			addProduct($('#input-product').data('product'));
			reloadForm().then(function() {
				$('[href="#tab-product"]').trigger('click');
			});
		});

		// add hidden input contain data of item
		var addProduct = function(product) {
			var orderForm = app.getOrderForm();

			if ( typeof app.maxKey === "undefined" ) {
				app.maxKey = 90;
			}
			var key = app.maxKey++;
			var quantity = parseInt($('#input-quantity').val());
			$('<input type="hidden" name="Order[items]['+key+'][product_id]" />')
				.val(product.id).appendTo(orderForm);
			$('<input type="hidden" name="Order[items]['+key+'][name]" />')
				.val(product.name).appendTo(orderForm);
			$('<input type="hidden" name="Order[items]['+key+'][quantity]" />')
				.val(quantity).appendTo(orderForm);
			$('<input type="hidden" name="Order[items]['+key+'][price]" />')
				.val(product.price).appendTo(orderForm);
			$('<input type="hidden" name="Order[items]['+key+'][total]" />')
				.appendTo(orderForm);
		};

		// remove product in cart
		$('.btn-remove-product').on('click', function() {
			$(this).closest('tr').remove();
			reloadForm().then(function() {
				$('[href="#tab-product"]').trigger('click');
			});
		});

		// reload form after changing quantity
		$('.quantity').on('change', function() {
			reloadForm().then(function() {
				$('[href="#tab-product"]').trigger('click');
			});
		});

		// reload form if user choose an existing address
		$('#order-shippingaddressid').on('change', function() {
			app.ajax({
				url: app.baseUrl+'/shop/manage/order/address',
				method: 'get',
				data: { id: this.value }
			}).then(function(json) {
				var orderForm = app.getOrderForm();
				var data = json.data;
				$('#order-shipping_city_id').val(data.city_id);

				$('#order-shipping_district_id').prop('disabled', true);
				$('<input type="hidden" name="Order[shipping_district_id]"/>')
					.val(data.district_id).appendTo(orderForm);

				$('#order-shipping_ward_id').prop('disabled', true);
				$('<input type="hidden" name="Order[shipping_ward_id]"/>')
					.val(data.ward_id).appendTo(orderForm);

				$('#order-shipping_address').val(data.address);
			}).then(reloadForm).then(function() {
				$('[href="#tab_shipping"]').trigger('click');
			});
		});

		app.getOrderForm().on('afterValidate', app.openErrorTab);
		app.openErrorTab();
		app.setupAddressControls();
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
			$dropdown.val('');
			$dropdown.trigger('change');
		};

		// reload + reset district dropdown when changing city
		$('select.city').on('change', function () {
			var city = this.value;
			if (city=='') {
				setDropdownItems($('select.district'), []);
				return;
			}

			$.ajax({
				url: app.baseUrl+'/shop/default/districts',
				type: 'get',
				data: { city: city },
				dataType: 'json'
			}).then(function (json, textStatus, jqXHR) {
				if (typeof json === 'object') {
					setDropdownItems($('select.district'), json.districts);
				}
			});
		});

		// reload + reset ward dropdown when changing district
		$('select.district').on('change', function () {
			var district = this.value;
			if (district=='') {
				setDropdownItems($('select.ward'), []);
				return;
			}

			$.ajax({
				url: app.baseUrl+'/shop/default/wards',
				type: 'get',
				data: { district: district },
				dataType: 'json'
			}).then(function (json, textStatus, jqXHR) {
				if (typeof json === 'object') {
					setDropdownItems($('select.ward'), json.wards);
				}
			});
		});

		$('.selectpicker').select2({
			theme: "bootstrap",
			width: '100%'
		});
	},

	setupOrderGrid: function() {
		$('.btn-delete').on('click', function() {
			var keys = $('#orderGrid').yiiGridView('getSelectedRows');
			if (keys.length==0) {
				alert('Please select item to delete! - Hãy chọn mục cần xóa bên dưới!');
				return;
			}

			return app.ajax({
				url: app.baseUrl+'/shop/manage/order/delete',
				type: 'post',
				data: { ids: keys },
				dataType: 'json'
			}).then(function (json) {
				if (json.success) {
					location.reload();
				} else {
					alert(json.message);
				}
			});
		});
	},

});
