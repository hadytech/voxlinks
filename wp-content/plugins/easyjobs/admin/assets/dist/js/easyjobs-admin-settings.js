(function ($) {
	'use strict';

	/**
	 * Easyjobs Admin Settings JS
	 */

	$.easyjobsAdmin = $.easyjobsAdmin || {};

	$(document).ready(function () {
		$.easyjobsAdmin.init();
	});

	$.easyjobsAdmin.init = function () {
		$.easyjobsAdmin.toggleFields();
		$.easyjobsAdmin.bindEvents();
		$.easyjobsAdmin.initializeFields();
	};

	$.easyjobsAdmin.bindEvents = function () {

		//Advance Checkbox with SweetAlert
		$('body').on('click', '.easyjobs-adv-checkbox-wrap label, .easyjobs-stats-tease', function (e) {
			if (typeof $(this)[0].dataset.swal == 'undefined') {
				return;
			}
			if (typeof $(this)[0].dataset.swal != 'undefined') {
				e.preventDefault();
			}
			var premium_content = document.createElement("p");
			var premium_anchor = document.createElement("a");

			premium_anchor.setAttribute('href', 'https://easyjobs.com');
			premium_anchor.innerText = 'Premium';
			premium_anchor.style.color = 'red';
			premium_content.innerHTML = 'You need to upgrade to the <strong>' + premium_anchor.outerHTML + ' </strong> Version to use this feature';

			swal({
				title: "Opps...",
				content: premium_content,
				icon: "warning",
				buttons: [false, "Close"],
				dangerMode: true,
			});
		});

		/**
		 * Group Field Events
		 */
		$('.easyjobs-group-field .easyjobs-group-field-title').on('click', function (e) {
			e.preventDefault();
			if ($(e.srcElement).hasClass('easyjobs-group-field-title')) {
				$.easyjobsAdmin.groupToggle(this);
			}
		});
		$('.easyjobs-group-field .easyjobs-group-clone').on('click', function () {
			$.easyjobsAdmin.cloneGroup(this);
		});
		$('body').on('click', '.easyjobs-group-field .easyjobs-group-remove', function () {
			$.easyjobsAdmin.removeGroup(this);
		});

		/**
		 * Media Field
		 */
		$('.easyjobs-media-field-wrapper .easyjobs-media-upload-button').on('click', function (e) {
			e.preventDefault();
			$.easyjobsAdmin.initMediaField(this);
		});
		$('.easyjobs-media-field-wrapper .easyjobs-media-remove-button').delegate('click', function (e) {
			e.preventDefault();
			$.easyjobsAdmin.removeMedia(this);
		});

		/**
		 * Settings Tab
		 */
		$('.easyjobs-settings-menu li').on('click', function (e) {
			$.easyjobsAdmin.settingsTab(this);
		});
		$('.easyjobs-settings-button').on('click', function (e) {
			e.preventDefault();
			var form = $(this).parents('#easyjobs-settings-form');
			$.easyjobsAdmin.submitSettings(this, form);
		});

		$('.easyjobs-opt-alert').on('click', function (e) {
			$.easyjobsAdmin.fieldAlert(this);
		});

		/**
		 * Reset Section Settings
		 */
		$('.easyjobs-section-reset').on('click', function (e) {
			e.preventDefault();
			$.easyjobsAdmin.resetSection(this);
		});
	};

	$.easyjobsAdmin.initializeFields = function () {
		if ($('.easyjobs-meta-field, .easyjobs-settings-field').length > 0) {
			$('.easyjobs-meta-field, .easyjobs-settings-field').map(function (iterator, item) {
				var node = item.nodeName;
				if (node === 'SELECT') {
					$(item).select2({
						placeholder: 'Select any'
					});
				}
			});
		}
		
		if ($('.easyjobs-countdown-datepicker').length > 0) {
			$('.easyjobs-countdown-datepicker').each(function () {
				$(this).find('input').datepicker({
					changeMonth: true,
					changeYear: true,
					dateFormat: 'DD, d MM, yy'
				});
			});
		}

		$('.easyjobs-metabox-wrapper .easyjobs-meta-field, .easyjobs-settings-field').trigger('change');

		
		if ($('.easyjobs-colorpicker-field').length > 0) {
			if ('undefined' !== typeof $.fn.wpColorPicker) {
				$('.easyjobs-colorpicker-field').each(function () {
					var color = $(this).val();
					$(this).wpColorPicker({
						change: function (event, ui) {
							var element = event.target;
							var color = ui.color.toString();
							$(element).parents('.wp-picker-container').find('input.easyjobs-colorpicker-field').val(color).trigger('change');
						}
					}).parents('.wp-picker-container').find('.wp-color-result').css('background-color', '#' + color);
				});
			}
		}
		$.easyjobsAdmin.groupField();
		$('.easyjobs-meta-template-editable').trigger('blur');
	};

	$.easyjobsAdmin.groupField = function () {

		if ($('.easyjobs-group-field-wrapper').length < 0) {
			return;
		}

		var fields = $('.easyjobs-group-field-wrapper');

		fields.each(function () {

			var $this = $(this),
				groups = $this.find('.easyjobs-group-field'),
				firstGroup = $this.find('.easyjobs-group-field:first'),
				lastGroup = $this.find('.easyjobs-group-field:last');

			groups.each(function () {
				var groupContent = $(this).find('.easyjobs-group-field-title:not(.open)').next();
				if (groupContent.is(':visible')) {
					groupContent.addClass('open');
				}
			});

			$this.find('.easyjobs-group-field-add').on('click', function (e) {
				e.preventDefault();

				var fieldId = $this.attr('id'),
					dataId = $this.data('name'),
					wrapper = $this.find('.easyjobs-group-fields-wrapper'),
					groups = $this.find('.easyjobs-group-field'),
					firstGroup = $this.find('.easyjobs-group-field:first'),
					lastGroup = $this.find('.easyjobs-group-field:last'),
					clone = $($this.find('.easyjobs-group-template').html()),
					groupId = parseInt(lastGroup.data('id')),
					nextGroupId = 1,
					title = clone.data('group-title');

				if (!isNaN(groupId)) {
					nextGroupId = groupId + 1;
				}

				groups.each(function () {
					$(this).removeClass('open');
				});

				// Reset all data of clone object.
				clone.attr('data-id', nextGroupId);
				clone.addClass('open');
				// clone.find('.easyjobs-group-field-title > span').html(title + ' ' + nextGroupId);
				clone.find('tr.easyjobs-field[id*=' + fieldId + ']').each(function () {
					var fieldName = dataId;
					var fieldNameSuffix = $(this).attr('id').split('[1]')[1];
					var nextFieldId = fieldName + '[' + nextGroupId + ']' + fieldNameSuffix;
					var label = $(this).find('th label');

					$(this).find('[name*="' + fieldName + '[1]"]').each(function () {
						var inputName = $(this).attr('name').split('[1]');
						var inputNamePrefix = inputName[0];
						var inputNameSuffix = inputName[1];
						var newInputName = inputNamePrefix + '[' + nextGroupId + ']' + inputNameSuffix;
						$(this).attr('id', newInputName).attr('name', newInputName);
						label.attr('for', newInputName);
					});

					$(this).attr('id', nextFieldId);
				});

				clone.insertBefore($(this));

				$.easyjobsAdmin.resetFieldIds($('.easyjobs-group-field'));
			});

		});

	};

	/**
	 * This function will change tab 
	 * with menu click & Next Previous Button Click
	 */
	$.easyjobsAdmin.tabChanger = function (buttonName) {
		var button = $(buttonName),
			tabID = button.data('tabid'),
			tabKey = button.data('tab'),
			tab;

		if (tabKey != '') {
			tab = $('#easyjobs-' + tabKey);
			$('#easyjobs_builder_current_tab').val(tabKey);
		}

		if (buttonName.nodeName !== 'BUTTON') {
			button.parent().find('li').each(function (i) {
				if (i < tabID) {
					$(this).addClass('easyjobs-complete');
				} else {
					$(this).removeClass('easyjobs-complete');
				}
			});

			button.addClass('active').siblings().removeClass('active');
			tab.addClass('active').siblings().removeClass('active');
			return;
		}
		if (tab === undefined) {
			$('#publish').trigger('click');
			return;
		}
		$('.easyjobs-metatab-menu li[data-tabid="' + tabID + '"]').trigger('click');
		$('.easyjobs-builder-tab-menu li[data-tabid="' + tabID + '"]').trigger('click');
	};

	$.easyjobsAdmin.toggleFields = function () {
		$(".easyjobs-meta-field, .easyjobs-settings-field").on('change', function (e) {
			$.easyjobsAdmin.checkDependencies(this);
		});
	};

	$.easyjobsAdmin.toggle = function (array, func, prefix, suffix, id) {
		var i = 0;
		suffix = 'undefined' == typeof suffix ? '' : suffix;

		if (typeof array !== 'undefined') {
			for (; i < array.length; i++) {
				var selector = prefix + array[i] + suffix;
				$(selector)[func]();
			}
		}
	};

	$.easyjobsAdmin.checkDependencies = function (variable) {
		if (easyjobs.toggleFields === null) {
			return;
		}

		var current = $(variable),
			container = current.parents('.easyjobs-field:first'),
			id = container.data('id'),
			value = current.val();

		if ('checkbox' === current.attr('type')) {
			if (!current.is(':checked')) {
				value = 0;
			} else {
				value = 1;
			}
		}


		if (current.hasClass('easyjobs-theme-selected')) {
			var currentTheme = current.parents('.easyjobs-theme-control-wrapper').data('name');
			value = $('#' + currentTheme).val();
		}

		var mainid = id;

		if (easyjobs.toggleFields.hasOwnProperty(id)) {
			var canShow = easyjobs.toggleFields[id].hasOwnProperty(value);
			var canHide = true;
			if (easyjobs.hideFields[id]) {
				var canHide = easyjobs.hideFields[id].hasOwnProperty(value);
			}

			if (easyjobs.toggleFields.hasOwnProperty(id) && canHide) {
				$.each(easyjobs.toggleFields[id], function (key, array) {
					$.easyjobsAdmin.toggle(array.fields, 'hide', '#easyjobs-meta-', '', mainid);
					$.easyjobsAdmin.toggle(array.sections, 'hide', '#easyjobs-meta-section-', '', mainid);
				})
			}

			if (canShow) {
				$.easyjobsAdmin.toggle(easyjobs.toggleFields[id][value].fields, 'show', '#easyjobs-meta-', '', mainid);
				$.easyjobsAdmin.toggle(easyjobs.toggleFields[id][value].sections, 'show', '#easyjobs-meta-section-', '', mainid);
			}
		}

		if (easyjobs.hideFields.hasOwnProperty(id)) {
			var hideFields = easyjobs.hideFields[id];

			if (hideFields.hasOwnProperty(value)) {
				$.easyjobsAdmin.toggle(hideFields[value].fields, 'hide', '#easyjobs-meta-', '', mainid);
				$.easyjobsAdmin.toggle(hideFields[value].sections, 'hide', '#easyjobs-meta-section-', '', mainid);
			}
		}

	};

	$.easyjobsAdmin.groupToggle = function (group) {
		var input = $(group),
			wrapper = input.parents('.easyjobs-group-field');

		if (wrapper.hasClass('open')) {
			wrapper.removeClass('open');
		} else {
			wrapper.addClass('open').siblings().removeClass('open');
		}
	};

	$.easyjobsAdmin.removeGroup = function (button) {
		var groupId = $(button).parents('.easyjobs-group-field').attr('data-id'),
			group = $(button).parents('.easyjobs-group-field[data-id="' + groupId + '"]'),
			parent = group.parent();

		group.fadeOut({
			duration: 300,
			complete: function () {
				$(this).remove();
			}
		});

		$.easyjobsAdmin.resetFieldIds(parent.find('.easyjobs-group-field'));
	};

	$.easyjobsAdmin.cloneGroup = function (button) {
		var groupId = $(button).parents('.easyjobs-group-field').attr('data-id'),
			group = $(button).parents('.easyjobs-group-field[data-id="' + groupId + '"]'),
			clone = $(group.clone()),
			lastGroup = $(button).parents('.easyjobs-group-fields-wrapper').find('.easyjobs-group-field:last'),
			parent = group.parent(),
			nextGroupID = $(lastGroup).data('id') + 1;

		group.removeClass('open');

		clone.attr('data-id', nextGroupID);
		clone.insertAfter(group);
		$.easyjobsAdmin.resetFieldIds(parent.find('.easyjobs-group-field'));
	};

	$.easyjobsAdmin.resetFieldIds = function (groups) {
		if (groups.length <= 0) {
			return;
		}
		var groupID = 0;

		groups.map(function (iterator, item) {

			var item = $(item),
				fieldName = item.data('field-name'),
				groupInfo = item.find('.nx-group-field-info').data('info'),
				subFields = groupInfo.group_sub_fields;

			item.attr('data-id', groupID);

			var table_row = item.find('tr.nx-field');

			table_row.each(function (i, child) {

				var child = $($(child)[0]),
					childInput = child.find('[name*="easyjobs_meta_' + fieldName + '"]'),
					key = childInput.attr('data-key'),
					subKey = subFields[i].original_name,
					dataID = fieldName + "[" + groupID + "][" + subKey + "]",
					idName = 'nx-meta-' + dataID,
					inputName = 'easyjobs_meta_' + dataID;

				child.attr('data-id', dataID);
				child.attr('id', idName);

				if (key != undefined) {
					childInput.attr('id', inputName);
					childInput.attr('name', inputName);
					childInput.attr('data-key', dataID);
				} else {
					if (childInput.length > 1) {
						childInput.each(function (i, subInput) {
							if (subInput.type === 'text') {
								var subInputName = inputName + '[url]';
							}
							if (subInput.type === 'hidden') {
								var subInputName = inputName + '[id]';
							}
							subInput = $(subInput);
							subInput.attr('id', subInputName);
							subInput.attr('name', subInputName);
							subInput.attr('data-key', dataID);
						});
					}
				}

			});

			groupID++;
		});
	}

	$.easyjobsAdmin.initMediaField = function (button) {
		var button = $(button),
			wrapper = button.parents('.easyjobs-media-field-wrapper'),
			removeButton = wrapper.find('.easyjobs-media-remove-button'),
			imgContainer = wrapper.find('.easyjobs-thumb-container'),
			idField = wrapper.find('.easyjobs-media-id'),
			urlField = wrapper.find('.easyjobs-media-url');

		// Create a new media frame
		var frame = wp.media({
			title: 'Upload Photo',
			button: {
				text: 'Use this photo'
			},
			multiple: false // Set to true to allow multiple files to be selected
		});

		// When an image is selected in the media frame...
		frame.on('select', function () {
			// Get media attachment details from the frame state
			var attachment = frame.state().get('selection').first().toJSON();
			/**
			 * Set image to the image container
			 */
			imgContainer.addClass('easyjobs-has-thumb').append('<img src="' + attachment.url + '" alt="" style="max-width:100%;"/>');
			idField.val(attachment.id); // set image id
			urlField.val(attachment.url); // set image url
			// Hide the upload button
			button.addClass('hidden');
			// Show the remove button
			removeButton.removeClass('hidden');
		});
		// Finally, open the modal on click
		frame.open();
	};

	$.easyjobsAdmin.removeMedia = function (button) {
		var button = $(button),
			wrapper = button.parents('.easyjobs-media-field-wrapper'),
			uploadButton = wrapper.find('.easyjobs-media-upload-button'),
			imgContainer = wrapper.find('.easyjobs-has-thumb'),
			idField = wrapper.find('.easyjobs-media-id'),
			urlField = wrapper.find('.easyjobs-media-url');

		imgContainer.removeClass('easyjobs-has-thumb').find('img').remove();

		urlField.val(''); // URL field has to be empty
		idField.val(''); // ID field has to empty as well

		button.addClass('hidden'); // Hide the remove button first
		uploadButton.removeClass('hidden'); // Show the uplaod button
	};

	$.easyjobsAdmin.fieldAlert = function (button) {
		var premium_content = document.createElement("p");
		var premium_anchor = document.createElement("a");

		premium_anchor.setAttribute('href', 'https://app.easy.jobs/user/account');
		premium_anchor.innerText = 'Premium';
		premium_anchor.style.color = 'red';
		premium_content.innerHTML = 'You need to upgrade to the <strong>' + premium_anchor.outerHTML + ' </strong> Version to use this feature';

		swal({
			title: "Opps...",
			content: premium_content,
			icon: "warning",
			buttons: [false, "Close"],
			dangerMode: true,
		});
	};

	$.easyjobsAdmin.resetSection = function (button) {
		var button = $(button),
			parent = button.parents('.easyjobs-meta-section'),
			fields = parent.find('.easyjobs-meta-field'),
			updateFields = [];

		window.fieldsss = fields;
		fields.map(function (iterator, item) {
			var item = $(item),
				default_value = item.data('default');

			item.val(default_value);

			if (item.hasClass('wp-color-picker')) {
				item.parents('.wp-picker-container').find('.wp-color-result').removeAttr('style')
			}
			if (item[0].id == 'easyjobs_meta_border') {
				item.trigger('click');
			} else {
				item.trigger('change');
			}
		});
	};

	$.easyjobsAdmin.settingsTab = function (button) {
		var button = $(button),
			tabToGo = button.data('tab');

		button.addClass('active').siblings().removeClass('active');
		$('#easyjobs-' + tabToGo).addClass('active').siblings().removeClass('active');
	};

	$.easyjobsAdmin.submitSettings = function (button, form) {
		var button = $(button),
			submitKey = button.data('key'),
			nonce = button.data('nonce'),
			formData = $(form).serializeArray();

		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data: {
				action: 'easyjobs_general_settings',
				key: submitKey,
				nonce: nonce,
				form_data: formData
			},
			beforeSend: function () {
				button.html('<span>Saving...</span>');
			},
			success: function (res) {
				button.html('Save Settings');
				if (res === 'success') {
					swal({
						title: "Settings Saved!",
						text: "Click OK to continue",
						icon: "success",
						buttons: [false, "Ok"],
						timer: 2000
					});
					$('.nx-save-now').removeClass("nx-save-now");
				} else {
					swal({
						title: "Settings Not Saved!",
						text: "Click OK to continue",
						icon: "success",
						buttons: [false, "Ok"],
					});
				}
			}
		});
	};
})(jQuery);