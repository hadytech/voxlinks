(function ($) {
	'use strict';

	/**
	 * crowdfundly Admin Settings JS
	 */

	$.crowdfundlyAdmin = $.crowdfundlyAdmin || {};

	$(document).ready(function () {
		// $.crowdfundlyAdmin.localStorage = localStorage;
		$.crowdfundlyAdmin.init();
	});

	$.crowdfundlyAdmin.init = function () {
		$.crowdfundlyAdmin.toggleFields();
		$.crowdfundlyAdmin.bindEvents();
		$.crowdfundlyAdmin.initializeFields();
	};

	$.crowdfundlyAdmin.bindEvents = function () {

		//Advance Checkbox with SweetAlert
		$('body').on('click', '.crowdfundly-adv-checkbox-wrap label, .crowdfundly-stats-tease', function (e) {
			if (typeof $(this)[0].dataset.swal == 'undefined') {
				return;
			}
			if (typeof $(this)[0].dataset.swal != 'undefined') {
				e.preventDefault();
			}
			var premium_content = document.createElement("p");
			var premium_anchor = document.createElement("a");

			premium_anchor.setAttribute('href', 'https://crowdfundly.io/');
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
		$('.crowdfundly-group-field .crowdfundly-group-field-title').on('click', function (e) {
			e.preventDefault();
			if ($(e.srcElement).hasClass('crowdfundly-group-field-title')) {
				$.crowdfundlyAdmin.groupToggle(this);
			}
		});
		$('.crowdfundly-group-field .crowdfundly-group-clone').on('click', function () {
			$.crowdfundlyAdmin.cloneGroup(this);
		});
		$('body').on('click', '.crowdfundly-group-field .crowdfundly-group-remove', function () {
			$.crowdfundlyAdmin.removeGroup(this);
		});

		/**
		 * Media Field
		 */
		$('.crowdfundly-media-field-wrapper .crowdfundly-media-upload-button').on('click', function (e) {
			e.preventDefault();
			$.crowdfundlyAdmin.initMediaField(this);
		});
		$('.crowdfundly-media-field-wrapper .crowdfundly-media-remove-button').delegate('click', function (e) {
			e.preventDefault();
			$.crowdfundlyAdmin.removeMedia(this);
		});

		/**
		 * Settings Tab
		 */
		$('.crowdfundly-settings-menu li').on('click', function (e) {
			$.crowdfundlyAdmin.settingsTab(this);
		});
		$('.crowdfundly-submit-payment_settings').on('click', function (e) {
			e.preventDefault();
			var form = $(this).parents('#crowdfundly-settings-form');
			$.crowdfundlyAdmin.submitSettings(this, form);
		});

		$('.crowdfundly-opt-alert').on('click', function (e) {
			$.crowdfundlyAdmin.fieldAlert(this);
		});

		/**
		 * Reset Section Settings
		 */
		$('.crowdfundly-section-reset').on('click', function (e) {
			e.preventDefault();
			$.crowdfundlyAdmin.resetSection(this);
		});
	};

	$.crowdfundlyAdmin.initializeFields = function () {
		if ($('.crowdfundly-meta-field, .crowdfundly-settings-field').length > 0) {
			$('.crowdfundly-meta-field, .crowdfundly-settings-field').map(function (iterator, item) {
				var node = item.nodeName;
				if (node === 'SELECT') {
					$(item).select2({
						placeholder: 'Select any'
					});
				}
			});
		}
		
		if ($('.crowdfundly-countdown-datepicker').length > 0) {
			$('.crowdfundly-countdown-datepicker').each(function () {
				$(this).find('input').datepicker({
					changeMonth: true,
					changeYear: true,
					dateFormat: 'DD, d MM, yy'
				});
			});
		}

		$('.crowdfundly-metabox-wrapper .crowdfundly-meta-field, .crowdfundly-settings-field').trigger('change');

		if ($('.crowdfundly-colorpicker-field').length > 0) {
			if ('undefined' !== typeof $.fn.wpColorPicker) {
				$('.crowdfundly-colorpicker-field').each(function () {
					var color = $(this).val();
					$(this).wpColorPicker({
						change: function (event, ui) {
							var element = event.target;
							var color = ui.color.toString();
							$(element).parents('.wp-picker-container').find('input.crowdfundly-colorpicker-field').val(color).trigger('change');
						}
					}).parents('.wp-picker-container').find('.wp-color-result').css('background-color', '#' + color);
				});
			}
		}
		$.crowdfundlyAdmin.groupField();
		$('.crowdfundly-meta-template-editable').trigger('blur');
	};

	$.crowdfundlyAdmin.groupField = function () {

		if ($('.crowdfundly-group-field-wrapper').length < 0) {
			return;
		}

		var fields = $('.crowdfundly-group-field-wrapper');

		fields.each(function () {

			var $this = $(this),
				groups = $this.find('.crowdfundly-group-field'),
				firstGroup = $this.find('.crowdfundly-group-field:first'),
				lastGroup = $this.find('.crowdfundly-group-field:last');

			groups.each(function () {
				var groupContent = $(this).find('.crowdfundly-group-field-title:not(.open)').next();
				if (groupContent.is(':visible')) {
					groupContent.addClass('open');
				}
			});

			$this.find('.crowdfundly-group-field-add').on('click', function (e) {
				e.preventDefault();

				var fieldId = $this.attr('id'),
					dataId = $this.data('name'),
					wrapper = $this.find('.crowdfundly-group-fields-wrapper'),
					groups = $this.find('.crowdfundly-group-field'),
					firstGroup = $this.find('.crowdfundly-group-field:first'),
					lastGroup = $this.find('.crowdfundly-group-field:last'),
					clone = $($this.find('.crowdfundly-group-template').html()),
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
				// clone.find('.crowdfundly-group-field-title > span').html(title + ' ' + nextGroupId);
				clone.find('tr.crowdfundly-field[id*=' + fieldId + ']').each(function () {
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

				$.crowdfundlyAdmin.resetFieldIds($('.crowdfundly-group-field'));
			});

		});

	};

	/**
	 * This function will change tab 
	 * with menu click & Next Previous Button Click
	 */
	$.crowdfundlyAdmin.tabChanger = function (buttonName) {
		var button = $(buttonName),
			tabID = button.data('tabid'),
			tabKey = button.data('tab'),
			tab;

		if (tabKey != '') {
			tab = $('#crowdfundly-' + tabKey);
			$('#crowdfundly_builder_current_tab').val(tabKey);
		}

		if (buttonName.nodeName !== 'BUTTON') {
			button.parent().find('li').each(function (i) {
				if (i < tabID) {
					$(this).addClass('crowdfundly-complete');
				} else {
					$(this).removeClass('crowdfundly-complete');
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
		$('.crowdfundly-metatab-menu li[data-tabid="' + tabID + '"]').trigger('click');
		$('.crowdfundly-builder-tab-menu li[data-tabid="' + tabID + '"]').trigger('click');
	};

	$.crowdfundlyAdmin.toggleFields = function () {
		$(".crowdfundly-meta-field, .crowdfundly-settings-field").on('change', function (e) {
			$.crowdfundlyAdmin.checkDependencies(this);
		});
	};

	$.crowdfundlyAdmin.toggle = function (array, func, prefix, suffix, id) {
		var i = 0;
		suffix = 'undefined' == typeof suffix ? '' : suffix;

		if (typeof array !== 'undefined') {
			for (; i < array.length; i++) {
				var selector = prefix + array[i] + suffix;
				$(selector)[func]();
			}
		}
	};

	$.crowdfundlyAdmin.checkDependencies = function (variable) {
		// console.log("localStorage: ", $.crowdfundlyAdmin.localStorage);
		var crowdfundly = $.crowdfundlyAdmin.localStorage;

		if (crowdfundly === undefined || crowdfundly === null) {
			return;
		}

		var current = $(variable),
			container = current.parents('.crowdfundly-field:first'),
			id = container.data('id'),
			value = current.val();

		if ('checkbox' === current.attr('type')) {
			if (!current.is(':checked')) {
				value = 0;
			} else {
				value = 1;
			}
		}

		if (current.hasClass('crowdfundly-theme-selected')) {
			var currentTheme = current.parents('.crowdfundly-theme-control-wrapper').data('name');
			value = $('#' + currentTheme).val();
		}

		var mainid = id;

		if (crowdfundly.toggleFields.hasOwnProperty(id)) {
			var canShow = crowdfundly.toggleFields[id].hasOwnProperty(value);
			var canHide = true;
			if (crowdfundly.hideFields[id]) {
				var canHide = crowdfundly.hideFields[id].hasOwnProperty(value);
			}

			if (crowdfundly.toggleFields.hasOwnProperty(id) && canHide) {
				$.each(crowdfundly.toggleFields[id], function (key, array) {
					$.crowdfundlyAdmin.toggle(array.fields, 'hide', '#crowdfundly-meta-', '', mainid);
					$.crowdfundlyAdmin.toggle(array.sections, 'hide', '#crowdfundly-meta-section-', '', mainid);
				})
			}

			if (canShow) {
				$.crowdfundlyAdmin.toggle(crowdfundly.toggleFields[id][value].fields, 'show', '#crowdfundly-meta-', '', mainid);
				$.crowdfundlyAdmin.toggle(crowdfundly.toggleFields[id][value].sections, 'show', '#crowdfundly-meta-section-', '', mainid);
			}
		}

		if (crowdfundly.hideFields.hasOwnProperty(id)) {
			var hideFields = crowdfundly.hideFields[id];

			if (hideFields.hasOwnProperty(value)) {
				$.crowdfundlyAdmin.toggle(hideFields[value].fields, 'hide', '#crowdfundly-meta-', '', mainid);
				$.crowdfundlyAdmin.toggle(hideFields[value].sections, 'hide', '#crowdfundly-meta-section-', '', mainid);
			}
		}

	};

	$.crowdfundlyAdmin.groupToggle = function (group) {
		var input = $(group),
			wrapper = input.parents('.crowdfundly-group-field');

		if (wrapper.hasClass('open')) {
			wrapper.removeClass('open');
		} else {
			wrapper.addClass('open').siblings().removeClass('open');
		}
	};

	$.crowdfundlyAdmin.removeGroup = function (button) {
		var groupId = $(button).parents('.crowdfundly-group-field').attr('data-id'),
			group = $(button).parents('.crowdfundly-group-field[data-id="' + groupId + '"]'),
			parent = group.parent();

		group.fadeOut({
			duration: 300,
			complete: function () {
				$(this).remove();
			}
		});

		$.crowdfundlyAdmin.resetFieldIds(parent.find('.crowdfundly-group-field'));
	};

	$.crowdfundlyAdmin.cloneGroup = function (button) {
		var groupId = $(button).parents('.crowdfundly-group-field').attr('data-id'),
			group = $(button).parents('.crowdfundly-group-field[data-id="' + groupId + '"]'),
			clone = $(group.clone()),
			lastGroup = $(button).parents('.crowdfundly-group-fields-wrapper').find('.crowdfundly-group-field:last'),
			parent = group.parent(),
			nextGroupID = $(lastGroup).data('id') + 1;

		group.removeClass('open');

		clone.attr('data-id', nextGroupID);
		clone.insertAfter(group);
		$.crowdfundlyAdmin.resetFieldIds(parent.find('.crowdfundly-group-field'));
	};

	$.crowdfundlyAdmin.resetFieldIds = function (groups) {
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
					childInput = child.find('[name*="crowdfundly_meta_' + fieldName + '"]'),
					key = childInput.attr('data-key'),
					subKey = subFields[i].original_name,
					dataID = fieldName + "[" + groupID + "][" + subKey + "]",
					idName = 'nx-meta-' + dataID,
					inputName = 'crowdfundly_meta_' + dataID;

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
	};

	$.crowdfundlyAdmin.initMediaField = function (button) {
		var button = $(button),
			wrapper = button.parents('.crowdfundly-media-field-wrapper'),
			removeButton = wrapper.find('.crowdfundly-media-remove-button'),
			imgContainer = wrapper.find('.crowdfundly-thumb-container'),
			idField = wrapper.find('.crowdfundly-media-id'),
			urlField = wrapper.find('.crowdfundly-media-url');

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
			imgContainer.addClass('crowdfundly-has-thumb').append('<img src="' + attachment.url + '" alt="" style="max-width:100%;"/>');
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

	$.crowdfundlyAdmin.removeMedia = function (button) {
		var button = $(button),
			wrapper = button.parents('.crowdfundly-media-field-wrapper'),
			uploadButton = wrapper.find('.crowdfundly-media-upload-button'),
			imgContainer = wrapper.find('.crowdfundly-has-thumb'),
			idField = wrapper.find('.crowdfundly-media-id'),
			urlField = wrapper.find('.crowdfundly-media-url');

		imgContainer.removeClass('crowdfundly-has-thumb').find('img').remove();

		urlField.val(''); // URL field has to be empty
		idField.val(''); // ID field has to empty as well

		button.addClass('hidden'); // Hide the remove button first
		uploadButton.removeClass('hidden'); // Show the uplaod button
	};

	$.crowdfundlyAdmin.fieldAlert = function (button) {
		var premium_content = document.createElement("p");
		var premium_anchor = document.createElement("a");

		premium_anchor.setAttribute('href', 'https://crowdfundly.io/');
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

	$.crowdfundlyAdmin.resetSection = function (button) {
		var button = $(button),
			parent = button.parents('.crowdfundly-meta-section'),
			fields = parent.find('.crowdfundly-meta-field'),
			updateFields = [];

		window.fieldsss = fields;
		fields.map(function (iterator, item) {
			var item = $(item),
				default_value = item.data('default');

			item.val(default_value);

			if (item.hasClass('wp-color-picker')) {
				item.parents('.wp-picker-container').find('.wp-color-result').removeAttr('style')
			}
			if (item[0].id == 'crowdfundly_meta_border') {
				item.trigger('click');
			} else {
				item.trigger('change');
			}
		});
	};

	$.crowdfundlyAdmin.settingsTab = function (button) {
		var button = $(button),
			tabToGo = button.data('tab');

		button.addClass('active').siblings().removeClass('active');
		$('#crowdfundly-' + tabToGo).addClass('active').siblings().removeClass('active');

		if ( tabToGo == 'shortcodes' ) {
			$('.crowdfundly-copy-shortcode').click(function(e) {
				e.preventDefault();

				$('.crowdfundly-copy-shortcode').css('background-color', '#eee');
				const shortCodeInput = $(this).parent().children()[0];
				
				$(shortCodeInput).select();
				document.execCommand("copy");
				$(this).css('background-color', '#81fb8170');
			});
		}
	};

	$.crowdfundlyAdmin.submitSettings = function (button, form) {
		var button 		= $(button),
			submitKey 	= button.data('key'),
			formData 	= $(form).serializeArray();

		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data: {
				action: 'crowdfundly_general_settings',
				key: submitKey,
				security: crowdfundlyAuth.nonce,
				form_data: formData
			},
			beforeSend: function () {
				button.html(crowdfundlyAuth.saving);
			},
			success: function (res) {
	
				if (res.success == true) {
					swal({
						title: crowdfundlyAuth.success,
						text: crowdfundlyAuth.save_settings_success,
						icon: "success",
						buttons: [false, "Ok"],
						timer: 2000
					});

					var crowdfundly = JSON.parse(localStorage.getItem('crowdfundly'));   
					crowdfundly.site_url = crowdfundlyAuth.site_url;
					crowdfundly.organization_url = res.organization_url;
					crowdfundly.campaign_url = res.campaign_url;
					localStorage.setItem('crowdfundly', JSON.stringify(crowdfundly));

				} else {
					swal({
						title: crowdfundlyAuth.settings_not_saved,
						text: crowdfundlyAuth.click_ok_to_cont,
						icon: "error",
						buttons: [false, "Ok"],
					});
				}
				button.html(crowdfundlyAuth.save_settings);
			},
			error: function(err) {
				swal({
					title: crowdfundlyAuth.error,
					text: crowdfundlyAuth.save_settings_error,
					icon: "error",
					buttons: [false, "Ok"],
				});				
				button.html(crowdfundlyAuth.save_settings);
				console.log(err);
			}
		});
	};
})(jQuery);