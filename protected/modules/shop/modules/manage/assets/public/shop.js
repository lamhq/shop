/*
 * javascript for shop module
 */
app = Object.assign(app, {

	setupProductForm: function () {
		// setup category tag input
		$('.selectpicker').select2();

		// setup redactor wyswyg widget
		app.wait(500)
		.then(function () {
			app.setupRedactorUpload('#product-description');
		});
	},

	setupCategoryForm: function () {
		app.wait(500)
		.then(function () {
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

	setupOrderForm: function() {
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
				$('#order-customer_id').val(item.value);
				$('#order-telephone').val(item.telephone);
				$('#order-email').val(item.email);
				this.value = item.label;
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
				$('#input-product_id').val(item.value);
				this.value = item.label;
				$(this).data('product', item);
			}
		});

		// get index for adding cart item
		var getItemKey = function() {
			if (typeof app.maxKey === "undefined") {
				app.maxKey = 90;
			}
			var result = app.maxKey;
			app.maxKey++;
			return result;
		};

		// add hidden input contain data of cart item
		var addProductInputs = function(product) {
			var orderForm = $('#orderForm');
			var key = getItemKey();
			var quantity = parseInt($('#input-quantity').val());
			$('<input type="hidden" name="Order[cartItems]['+key+'][product_id]" />')
				.val(product.id).appendTo(orderForm);
			$('<input type="hidden" name="Order[cartItems]['+key+'][name]" />')
				.val(product.name).appendTo(orderForm);
			$('<input type="hidden" name="Order[cartItems]['+key+'][quantity]" />')
				.val(quantity).appendTo(orderForm);
			$('<input type="hidden" name="Order[cartItems]['+key+'][price]" />')
				.val(product.price).appendTo(orderForm);
			$('<input type="hidden" name="Order[cartItems]['+key+'][total]" />')
				.val(product.price*quantity).appendTo(orderForm);
		};

		var reloadForm = function() {
			var orderForm = $('#orderForm');
			
			// disable fake input if cart has items
			$('#fakeItemsInput').prop('disabled', 
				orderForm.find('tr input[name^="Order[cartItems]"]').length>0);
			
			// set the flag to inform server to not save this order
			data = orderForm.serializeArray();
			data.push({ name: 'reload', 'value':1 });
			
			return app.load(orderForm, {
				url: orderForm.attr('action'),
				method: 'post',
				data: data
			}).then(app.setupOrderForm);
		};

		$('#btnAddProduct').on('click', function() {
			var productId = $('#input-product_id').val();
			var quantity = parseInt($('#input-quantity').val());
			if ( productId=='' || isNaN(parseInt(quantity)) || quantity<=0 ) return;

			addProductInputs($('#input-product').data('product'));
			reloadForm().then(function() {
				$('[href="#tab-product"]').trigger('click');
			});
		});

		$('.btn-remove-product').on('click', function() {
			$(this).closest('tr').remove();
			reloadForm().then(function() {
				$('[href="#tab-product"]').trigger('click');
			});
		});
	}
});
