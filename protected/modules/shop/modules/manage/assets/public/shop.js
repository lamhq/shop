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
});
