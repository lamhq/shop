/*
 * javascript for core app
 */
app = {
	init: function (baseUrl) {
		app.baseUrl = baseUrl;
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

};
