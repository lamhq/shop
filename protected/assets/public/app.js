/*
 * javascript for core app
 */
app = {
	init: function (baseUrl) {
		app.baseUrl = baseUrl;
	},

	showSuccess: function(message) {
		$.notify(message, {
			position:"right bottom",
			className: "success"
		});
	},

	timer: null,

	wait: function (milliseconds) {
		// Create a new Deferred object
		var deferred = $.Deferred();
		clearTimeout(app.timer);
		// Resolve the Deferred after the amount of time specified by milliseconds
		app.timer = setTimeout(deferred.resolve, milliseconds);

		// Return the Deferred's Promise object
		return deferred.promise();
	},

	xhr: null,

	ajax: function(setting) {
		// abort the current ajax request
		var xhr = app.xhr;
		if (xhr) {
			xhr.abort();
		}

		return app.xhr = $.ajax(setting)
			.fail(function( jqXHR, textStatus, errorThrown ) {
				console.log('ajax excecution failed on '+setting.url+' . error: '+errorThrown);
				// alert(errorThrown + "\r\n" + jqXHR.statusText + "\r\n" + jqXHR.responseText);
			});
	},

	load: function(target, setting) {
		var src = setting.src==='undefined' ? false : setting.src;
		return app.ajax(setting)
		.then(function (data, textStatus, jqXHR) {
			var html = '';
			if (src) {
				var $e = $('<div>'+data+'</div>');
				html = $e.find(src).html();
			} else {
				html = data;
			}
			$(target).html(html);
		});
	},

	setupAjaxUploadWidget: function (options) {
		var $widget = $('#'+options.id);
		var counter = 0;

		var checkExtension = function(file) {
			if (options.extensions.length < 1) return true;
			var extension = file.name.split('.').pop();
			if ( $.inArray(extension.toLowerCase(), options.extensions)<0 ) {
				alert('File type is not allowed');
				return false;
			}
			return true;
		};

		var checkMaxSize = function(file) {
			if (options.maxSize==0) return true;

			if ( file.size > options.maxSize*1000 ) {
				alert('File is too large');
				return false;
			}
			return true;
		};

		var isImage = function(name) {
			var extension = name.split('.').pop();
			return ['jpg', 'png', 'gif'].indexOf(extension.toLowerCase()) > -1;
		}

		var uploadFile = function(file) {
			return new Promise(function(resolve, reject) {
				if ( !checkExtension(file) || !checkMaxSize(file) ) {
					return false;
				}

				// append file data to form
				var data = new FormData();
				data.append('file', file);

				// append csrf param to form
				data.append(app.getCsrfParamName(), app.getCsrfParamValue());

				$widget.find('.loader').removeClass('hide'); // show loading

				var request = new XMLHttpRequest();
				request.onreadystatechange = function(){
					if(request.readyState == 4){	// done
						$widget.find('.loader').addClass('hide');
						try {
							var response = JSON.parse(request.response);
							resolve(response);
							// options.onSuccess(resp);
						} catch (e){
							// options.onFail(request.responseText);
						}
					}
				};
				// request.upload.addEventListener('progress', options.onProgress, false);
				request.open('POST', options.uploadUrl);
				request.send(data);
			});
		};

		/**
		 * add file upload item to widget
		 * @param object data { url, value }
		 */
		var addItem = function (data) {
			if (data.value.trim()=='') return;

			var img = title = '';
			if ( isImage(data.value) ) {
				img = '<img src="{url}" alt="" />';
				title = '';
			} else {
				img = '';
				title = '<span class="title">'+data.value.split('/').pop()+'</span>';
			}

			var inputName = options.name;
			if (options.multiple) {
				inputName = options.name+'[i'+counter+']';
				counter++;
			}

			var html = options.itemTemplate
				.replace('{img}', img)
				.replace('{title}', title)
				.replace('{removeButton}', '<span class="glyphicon glyphicon-remove-sign remove" aria-hidden="true"></span>')
				.replace('{input}', '<input type=hidden name="{name}[value]" value="{value}" />'
					+ '<input type=hidden name="{name}[url]" value="{url}" />'
					+ '<input type=hidden name="{name}[path]" value="{path}" />'
				);

			html = html.replace(/{url}/g, data.url)
				.replace(/{value}/g, data.value)
				.replace(/{path}/g, data.path)
				.replace(/{name}/g, inputName);

			var $item = $(html);
			if ( !isImage(data.value) ) {
				$item.addClass('not-image');
			}
			$widget.find('.upload-files').append($item);
			$widget.find('.placeholderInput').prop('disabled', true);
		};

		var removeItem = function ($item) {
			$widget.find('.placeholderInput').prop('disabled', false);
			$item.remove();
		};

		// validate and send file content to server by ajax
		$widget.on('change', '.ajax-file-input', function() {
			if ( this.files.length === 0){
				this.value = '';
				return;
			}

			$(this.files).each(function () {
				uploadFile(this).then(function (data) {
					if (!options.multiple) {
						removeItem($widget.find('.item'));
					}
					addItem(data);
				});
			});
			this.value = '';
		});

		// remove current selected file
		$widget.on('click', '.remove', function() {
			$widget.find('.placeholderInput').prop('disabled', false);
			removeItem($(this).closest('.item'));
		});

		// init items
		if (options.multiple) {
			options.value.forEach(function(item, index, array) {
				addItem({
					url: item.url,
					value: item.value,
					path: item.path
				});
			});
		} else {
			var item = options.value;
			addItem({
				url: item.url,
				value: item.value,
				path: item.path
			});
		}

		// init sortable items
		$widget.find('.upload-files').sortable({
			opacity: 0.6,
			revert: true,
			placeholder: 'sortable-placeholder',
			cursor: 'move'
		});

		if (options.multiple) {
			$widget.find('.ajax-file-input').prop('multiple', true);
		}
	},

	getCsrfParamName: function () {
		return $('meta[name=csrf-param]').attr('content');
	},

	getCsrfParamValue: function () {
		return $('meta[name=csrf-token]').attr('content');
	},

	setupRedactorUpload: function (selector) {
		// add csrf token to data submit to server
		$(selector).data('redactor').opts.uploadStartCallback = function(e, formData) {
			formData.append(app.getCsrfParamName(), app.getCsrfParamValue());
		};
	}
};

/* Autocomplete for Bootstrap (copy from opencart) */
(function($) {
	$.fn.bsAutocomplete = function(option) {
		return this.each(function() {
			var $this = $(this);
			var $dropdown = $('<ul class="dropdown-menu" />');
			
			this.timer = null;
			this.items = [];

			$.extend(this, option);

			$this.attr('autocomplete', 'off');

			// Focus
			$this.on('focus', function() {
				this.request();
			});

			// Blur
			$this.on('blur', function() {
				setTimeout(function(object) {
					object.hide();
				}, 200, this);
			});

			// Keydown
			$this.on('keydown', function(event) {
				switch(event.keyCode) {
					case 27: // escape
						this.hide();
						break;
					default:
						this.request();
						break;
				}
			});

			// Click
			this.click = function(event) {
				event.preventDefault();

				var value = $(event.target).parent().attr('data-value');

				if (value && this.items[value]) {
					this.select(this.items[value]);
				}
			}

			// Show
			this.show = function() {
				var pos = $this.position();

				$dropdown.css({
					top: pos.top + $this.outerHeight(),
					left: pos.left
				});

				$dropdown.show();
			}

			// Hide
			this.hide = function() {
				$dropdown.hide();
			}

			// Request
			this.request = function() {
				clearTimeout(this.timer);

				this.timer = setTimeout(function(object) {
					object.source($(object).val(), $.proxy(object.response, object));
				}, 200, this);
			}

			// Response
			this.response = function(json) {
				var html = '';
				var category = {};
				var name;
				var i = 0, j = 0;

				if (json.length) {
					for (i = 0; i < json.length; i++) {
						// update element items
						this.items[json[i]['value']] = json[i];

						if (!json[i]['category']) {
							// ungrouped items
							html += '<li data-value="' + json[i]['value'] + '"><a href="#">' + json[i]['label'] + '</a></li>';
						} else {
							// grouped items
							name = json[i]['category'];
							if (!category[name]) {
								category[name] = [];
							}

							category[name].push(json[i]);
						}
					}

					for (name in category) {
						html += '<li class="dropdown-header">' + name + '</li>';

						for (j = 0; j < category[name].length; j++) {
							html += '<li data-value="' + category[name][j]['value'] + '"><a href="#">&nbsp;&nbsp;&nbsp;' + category[name][j]['label'] + '</a></li>';
						}
					}
				}

				if (html) {
					this.show();
				} else {
					this.hide();
				}

				$dropdown.html(html);
			}

			$dropdown.on('click', '> li > a', $.proxy(this.click, this));
			$this.after($dropdown);
		});
	}
})(window.jQuery);
