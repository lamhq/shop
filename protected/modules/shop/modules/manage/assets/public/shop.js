/*
 * javascript for shop module
 */
app = Object.assign(app, {
	setupProductForm: function () {
		// setup category tag input
		$('.selectpicker').select2();

		// setup redactor wyswyg widget
		app.wait(1000)
		.then(function () {
			$('#product-description').data('redactor').opts.uploadStartCallback = function(e, formData) {
				// add csrf token to data submit to server
				formData.append(app.getCsrfParamName(), app.getCsrfParamValue());
			};
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
	}
});
