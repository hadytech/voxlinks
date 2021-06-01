(function( $ ) {
	'use strict';

	var RX_Admin = {

		init: function(){
			RX_Admin.bindEvents();
			RX_Admin.initFields();
		},
		initFields: function(){
			//RX_Admin.initSelect2();
			$('.rx-metabox-wrapper .rx-meta-field').trigger('change');
			RX_Admin.initColorField();
			RX_Admin.initGroupField();
		},
		bindEvents: function(){
			$('body').delegate( '.rx-settings-menu li', 'click', function( e ) {
				RX_Admin.settingsTab( this );
            } );
			$('body').delegate( '.rx-submit-general', 'click', function( e ) {
				e.preventDefault();
				RX_Admin.submitSettings( this );
            } );
			$('body').delegate( '.rx-opt-alert', 'click', function( e ) {
				RX_Admin.fieldAlert( this );
            } );
			$('body').delegate( '.rx-section-reset', 'click', function( e ) {
				e.preventDefault();
				RX_Admin.resetSection( this );
            } );
			$('body').delegate( '.rx-meta-field', 'change', function( ) {
				RX_Admin.fieldChange( this );
			} );
			// .rx-quick-builder-btn,
			$('body').delegate( '.rx-meta-next, .rx-metatab-menu li, .rx-quick-previous-btn', 'click', function(e) {
				e.preventDefault();
				RX_Admin.tabChanger( this );
            } );
			$('body').delegate( '.rx-single-theme-main-wrapper .rx-single-theme-wrapper', 'click', function(e) {
				e.preventDefault();
				RX_Admin.selectImage( this );
            } );
			$('body').delegate( '.rx-group-field .rx-group-field-title', 'click', function(e) {
				e.preventDefault();
				if( $( e.srcElement ).hasClass( 'rx-group-field-title' ) ) {
					RX_Admin.groupToggle( this );
				}
			} );
			$('body').delegate( '.rx-group-field .rx-group-remove', 'click', function() {
				RX_Admin.removeGroup(this);
			} );
			$('body').delegate( '.rx-group-field .rx-group-clone', 'click', function() {
                RX_Admin.cloneGroup(this);
            } );

			$('body').delegate( '.rx-optin-button', 'click', function(e) {
				e.preventDefault();
                RX_Admin.optinAllowOrNot(this);
			} );

			$('body').delegate( '.rx-admin-status label', 'click', function(e) {
				e.stopPropagation();
                RX_Admin.enabledDisabled(this);
			} );
		},
		initSelect2 : function(){
			$('.rx-meta-field').map(function( iterator, item ){
				var node = item.nodeName;

				if( node === 'SELECT' ) {
					$(item).select2();
				}
			});
		},
		tabChanger : function( button ) {
			var button = $( button ),
				totalTab = button.parents('.rx-metatab-wrapper').data('totaltab'),
				tabID = button.data('tabid'),
				// tab = $( '#rx-' + button.data('tab') ),
				tabKey = button.data("tab"),
				tab,
				dir;

			if (tabKey != "" && tabKey != undefined) {
				tab = $("#rx-" + tabKey);
				if( tabKey == "email_tab" || tabKey == "display_tab" ) {
					if( $('.rx-metatab-menu').hasClass('rx-quick-builder-tab-menu') ) {
						$("#rx_builder_current_tab").val("email_tab");
					} else {
						$("#rx_builder_current_tab").val(tabKey);
					}						
				} else {
					$("#rx_builder_current_tab").val(tabKey);
				}				
			}

			if (RX_Admin.onGetCurrentPage() == 'post-type-reviewx' && RX_Admin.onCheckCriteria() == true && tab == undefined) {
				$("#publish").trigger("click");
				return;
			}

			var contentMenu = $(".rx-quick-builder-tab-menu").find(
				'li[data-tab="content_tab"]'
			),
			cDisplay = "none";

			if (contentMenu.length > 0) {
				if (contentMenu[0] != undefined) {
					cDisplay = contentMenu[0].style.display;
					var lMenu = $(
						'.rx-quick-builder-tab-menu li[data-tabid="' + tabID + '"]'
					);
					//cDisplay = lMenu[0].style.display;
				}
				if (cDisplay == "none" && dir != undefined) {
					if (dir == "left") {
						tabID = tabID - 1;
					} else {
						tabID = tabID + 1;
					}
				}
			}

			/*****************
			 * Hide license button for Scheduled Emails tab
			 */
            let currentPage = $('#rx_builder_current_page').val();
			if( currentPage == 'reviewx-review-email' ) {
				if( tabKey == 'scheduled_emails' ){
					$('.rx-license-section').hide();
					$('.rx-form-builder-section').css({'flex':'0 0 100%'});
					$('.rx_review_email_content_wrap .rx_review_email_content').css({'background-color':'#fff'});
					$('.rx_review_email_content_wrap').css({'padding':'0'});
					$('.rx_review_email_content .rx-meta-section table tr td').css({'padding':'0'});
					$('.rx_review_email_content .rx-meta-section table table tr td').css({'padding':'5px 30px'});
					$('#rx-option-disable_autocreate_unsubscribe_page .rx-control').css({'padding-left':'0'});									
								
				} else {
					$('.rx-license-section').show();
					$('.rx-form-builder-section').css({'flex':'0 0 70%'});
					$('.rx_review_email_content_wrap .rx_review_email_content').css({'background-color':'#edeff0'});
					$('.rx_review_email_content_wrap').css({'padding':'30px'});
					$('.rx_review_email_content .rx-meta-section table tr td').css({'padding':'5px 30px'});
					$('.rx_review_email_content .rx-meta-section table table tr td').css({'padding':'0'});	
				}
			}

			if( RX_Admin.onCheckCriteria() === true ) {
				if( tabID != undefined ) {
					$('.rx-metatab-menu li[data-tabid="'+ tabID +'"]')[0].click();
				}
					
				if( tabID != undefined && $('.rx-metatab-menu').hasClass('rx-quick-builder-tab-menu') ) {
					$('.rx-quick-builder-tab-menu li[data-tabid="'+ tabID +'"]')[0].click();

					if (button.nodeName !== "BUTTON") {
						button
							.parent()
							.find("li")
							.each(function (i) {
								if (i < tabID) {
									$(this).addClass("rx-complete");
								} else {
									$(this).removeClass("rx-complete");
								}
							});

						button.addClass("active").siblings().removeClass("active");
						tab.addClass("active").siblings().removeClass("active");
					}

				} else {
					button.addClass("active").siblings().removeClass("active");
					if( tab != undefined ){
						tab.addClass("active").siblings().removeClass("active");
					}
				}
			}
		},
		selectImage : function( image ) {
			var imgParent = $( image ),
				img = imgParent.find('img'),
				value = img.data('theme'),
				
				wrapper = $( imgParent.parents('.rx-theme-field-wrapper') ),
				inputID = wrapper.data('name');			
				imgParent.not('.rx-radio-pro').addClass('rx-theme-selected').parent().siblings().find('.rx-single-theme-wrapper').removeClass('rx-theme-selected');
				imgParent.hasClass('rx-radio-pro') ? '':$('#' + inputID).val( value );
				imgParent.trigger('change');
		},
		fieldAlert: function( element ) {
			var premium_content = document.createElement("p");
			var premium_anchor = document.createElement("a");
	
			premium_anchor.setAttribute('href', 'https://reviewx.io/upgrade/reviewx-pro');
			premium_anchor.setAttribute('target', '_blank');
			premium_anchor.innerText 		= 'Premium';
			premium_anchor.style.color 		= 'red';
			var pro_label 					= $(this).find('.rx-pro-label');
			if (pro_label.hasClass('has-to-update')) {
				premium_anchor.innerText = 'Latest Pro v' + pro_label.text().toString().replace(/[ >=<]/g, '');
			}
			premium_content.innerHTML = 'You need to upgrade to the <strong>' + premium_anchor.outerHTML + ' </strong> Version to use this module.';
	
			Swal.fire({
				title: "Opps...",
				html: premium_content,
				type: 'error',
			});
			return;
		},
		resetSection: function( button ){
			var button = $( button ),
				parent = button.parents('.rx-meta-section'),
				fields = parent.find('.rx-meta-field'), updateFields = [];
			
			window.fieldsss = fields;
			fields.map(function(iterator, item){ 
				var item = $( item ),
					default_value = item.data( 'default' );

				item.val( default_value );

				if( item.hasClass('wp-color-picker') ) {
					item.parents('.wp-picker-container').find('.wp-color-result').removeAttr('style')
				}
				if( item[0].id == 'rx_meta_border' ){
					item.trigger('click');
				} else {
					item.trigger('change');
				}
			});
		},
		fieldChange: function( input ) {
			var field   = $(input),
                id  	= field.attr('id'),
                toggle  = field.data('toggle'),
                hide    = field.data('hide'),
                val     = field.val(),
				i       = 0;

			if ( 'checkbox' === field.attr('type') ) {
				if( ! field.is(':checked') ) {
					val = 0;
				} else {
					val = 1;
				}
			} 

			if ( field.hasClass('rx-theme-selected') ) {
				id = field.parents('.rx-theme-control-wrapper').data('name');
				val = $( '#' + id ).val();
			}

			// TOGGLE sections or fields.
			if ( typeof toggle !== 'undefined' ) {

				if ( typeof toggle !== 'object' ) {
					toggle = JSON.parse(toggle);
				}
				for(i in toggle) {
					RX_Admin.fieldToggle(toggle[i].fields, 'hide', '#rx-meta-', '', id);
					RX_Admin.fieldToggle(toggle[i].sections, 'hide', '#rx-meta-section-', '', id);
				}

				if(typeof toggle[val] !== 'undefined') {
					RX_Admin.fieldToggle(toggle[val].fields, 'show', '#rx-meta-', '', id);
					RX_Admin.fieldToggle(toggle[val].sections, 'show', '#rx-meta-section-', '', id);
				}

			}

			// HIDE sections or fields.
    		if ( typeof hide !== 'undefined' ) {

                if ( typeof hide !== 'object' ) {
    			    hide = JSON.parse(hide);
				}
				
    			if(typeof hide[val] !== 'undefined') {
    				RX_Admin.fieldToggle(hide[val].fields, 'hide', '#rx-meta-', '', id);
    				RX_Admin.fieldToggle(hide[val].sections, 'hide', '#rx-meta-section-', '', id);
    			}
			}
		},
		fieldToggle: function( array, func, prefix, suffix, id = '' ){
			var i = 0;
			
			suffix = 'undefined' == typeof suffix ? '' : suffix;
    		if(typeof array !== 'undefined') {
    			for( ; i < array.length; i++) {
    				$(prefix + array[i] + suffix)[func]();
    			}
    		}
		},
		initColorField: function(){			
			if ( 'undefined' !== typeof $.fn.wpColorPicker ) {
                // Add Color Picker to all inputs that have 'mbt-color-picker' class.
                $( '.rx-colorpicker-field' ).each(function() {
                    var color = $(this).val();
                    $(this).wpColorPicker({
                        click: function(event, ui) {
                            var element = event.target;
                            var color = ui.color.toString();
							$(element).parents('.wp-picker-container').find('input.rx-colorpicker-field').val(color).trigger('change');
                        }
                    }).parents('.wp-picker-container').find('.wp-color-result').css('background-color', '#' + color);
                });
            }
		},
		initGroupField : function(){
			if( $('.rx-group-field-wrapper').length < 0 ) {
				return;
			}
			var fields = $('.rx-group-field-wrapper');

			fields.each(function(){
				var $this  = $( this ),
					groups = $this.find('.rx-group-field'),
					firstGroup   = $this.find('.rx-group-field:first'),
					lastGroup   = $this.find('.rx-group-field:last');

				groups.each(function() {
					var groupContent = $(this).find('.rx-group-field-title:not(.open)').next();
					if ( groupContent.is(':visible') ) {
						groupContent.addClass('open');
					}
				});

				$this.find('.rx-group-field-add').on('click', function( e ){
					e.preventDefault();
					var fieldId     = $this.attr('id'),
					    dataId      = $this.data( 'name' ),
					    wrapper     = $this.find( '.rx-group-fields-wrapper' ),
					    groups      = $this.find('.rx-group-field'),
					    firstGroup  = $this.find('.rx-group-field:first'),
					    lastGroup   = $this.find('.rx-group-field:last'),
					    clone       = $( $this.find('.rx-group-template').html() ),
					    groupId     = parseInt( lastGroup.data('id') ),
					    nextGroupId = groupId + 1,
					    title       = clone.data('group-title');

					groups.each(function() {
						$(this).removeClass('open');
					});

					// Reset all data of clone object.
					clone.attr('data-id', nextGroupId);
					clone.addClass('open');
					// clone.find('.rx-group-field-title > span').html(title + ' ' + nextGroupId);
					clone.find('tr.rx-field[id*='+fieldId+']').each(function() {
						var fieldName       = dataId;
						var fieldNameSuffix = $(this).attr('id').split('[1]')[1];
						var nextFieldId     = fieldName + '[' + nextGroupId + ']' + fieldNameSuffix;
						var label           = $(this).find('th label');

						$(this).find('[name*="'+fieldName+'[1]"]').each(function() {
							var inputName       = $(this).attr('name').split('[1]');
							var inputNamePrefix = inputName[0];
							var inputNameSuffix = inputName[1];
							var newInputName    = inputNamePrefix + '[' + nextGroupId + ']' + inputNameSuffix;
							$(this).attr('id', newInputName).attr('name', newInputName);
							label.attr('for', newInputName);
						});

						$(this).attr('id', nextFieldId);
					});

					clone.insertBefore( $( this ) );
				});

			});

		},
		setDate : function( item ){
			var date    = new Date();
			item.find('.rx-group-field-timestamp').val( date.getTime() );
		},
		groupToggle : function( input ){
			var input = $(input),
				wrapper = input.parents('.rx-group-field');

			if( wrapper.hasClass('open') ) {
				wrapper.removeClass( 'open' );
			} else {
				wrapper.addClass('open').siblings().removeClass('open');
			}
		},
		removeGroup : function( button ){
			var groupId = $(button).parents('.rx-group-field').data('id'),
                group   = $(button).parents('.rx-group-field[data-id="'+groupId+'"]');

            group.fadeOut({
                duration: 300,
                complete: function() {
                    $(this).remove();
                }
            });
		},
		cloneGroup : function( button ){
			var groupId = $(button).parents('.rx-group-field').data('id'),
				group   = $(button).parents('.rx-group-field[data-id="'+groupId+'"]'),
				clone   = $( group.clone() ),
				lastGroup   = $( button ).parents('.rx-group-fields-wrapper').find('.rx-group-field:last'),
				parent  = group.parent(),
				nextGroupID = $( lastGroup ).data('id') + 1;

			clone.attr('data-id', nextGroupID);
			clone.insertAfter(group);
			RX_Admin.resetFieldIds( parent.find('.rx-group-field') );
		},
		resetFieldIds : function( groups ){
			var groupID = 1;
			groups.each(function() {
				var group       = $(this),
					fieldName   = group.data('field-name'),
					fieldId     = 'rx-' + fieldName,
					groupInfo   = group.find('.rx-group-field-info').data('info'),
					subFields   = groupInfo.group_sub_fields;
				group.data('id', groupID);

				subFields.forEach(function( item ){
					var table_row = group.find('tr.rx-field[id="rx-' + item.field_name + '"]');

					table_row.find('[name*="'+item.field_name+'"]').each(function(){
						var name = $(this).attr('name'),
							prefix  = name.split(item.field_name)[0],
							suffix  = '';

						if ( undefined === prefix ) {
							prefix = '';
						}
						
						name = name.replace( name, prefix + fieldName + '[' + groupID + '][' + item.original_name + ']' + suffix );
						$(this).attr('name', name).attr('id', name);
					});

					group.find('tr.rx-field[id="rx-' + item.field_name + '"]').attr('id', fieldId + '[' + groupID + '][' + item.original_name + ']');
				});
				groupID++;
			});
		},
		initMediaField : function( button ){

			var button = $( button ),
				wrapper = button.parents('.rx-media-field-wrapper'),
				removeButton = wrapper.find('.rx-media-remove-button'),
				imgContainer = wrapper.find('.rx-thumb-container'),
				idField = wrapper.find('.rx-media-id'),
				urlField = wrapper.find('.rx-media-url');

			// Create a new media frame
            var frame = wp.media({
                title: 'Upload Photo',
                button: {
                    text: 'Use this photo'
                },
                multiple: false  // Set to true to allow multiple files to be selected
			});

            // When an image is selected in the media frame...
            frame.on( 'select', function() {
                // Get media attachment details from the frame state
                var attachment = frame.state().get('selection').first().toJSON();

                /**
				 * Set image to the image container
				 */
                imgContainer.addClass('rx-has-thumb').append( '<img src="'+attachment.url+'" alt="" style="max-width:100%;"/>' );
                idField.val( attachment.id ); // set image id
                urlField.val( attachment.url ); // set image url

                // Hide the upload button
                button.addClass( 'hidden' );

                // Show the remove button
                removeButton.removeClass( 'hidden' );
            });

            // Finally, open the modal on click
            frame.open();
		},
		removeMedia : function( button ) {
			var button = $( button ),
				wrapper = button.parents('.rx-media-field-wrapper'),
				uploadButton = wrapper.find('.rx-media-upload-button'),
				imgContainer = wrapper.find('.rx-has-thumb'),
				idField = wrapper.find('.rx-media-id'),
				urlField = wrapper.find('.rx-media-url');

			imgContainer.removeClass('rx-has-thumb').find('img').remove();

			urlField.val(''); // URL field has to be empty
			idField.val(''); // ID field has to empty as well

			button.addClass('hidden'); // Hide the remove button first
			uploadButton.removeClass('hidden'); // Show the uplaod button
		},
		shownPreview : function( type ) {
			if ( type === 'press_bar' ) {
				$('#rx-notification-preview').hide();
			} else {
				$('#rx-notification-preview').removeClass('rx-notification-preview-comments').removeClass('rx-notification-preview-conversions');
				$('#rx-notification-preview').show().addClass('rx-notification-preview-' + type);
			}
		},
		updatePreview: function( fields ){

			fields.map(function(item, i){
				var event = item.event || 'change';

				$( item.id ).each(function(){

					$( this ).on( event, function(){
						var val = $( this ).val(),
							suffix = '',
							selector = '.rx-preview-inner';
	
						if( typeof item.selector != 'undefined' ) {
							selector = item.selector;
						}
	
						if( typeof item.unit != 'undefined' ) {
							suffix = item.unit;
						}
						/**
						 * This lines of code use for removing & adding the border css 
						 * on CLICK to want border.
						 */
						if( event == 'click' && item.field == 'border' ) {
							window.itemshide = item.hide;
							if( ! $( this ).is(":checked") ) {
								item.hide.forEach(function(item) {
									if( item.property == 'border-width' ) {
										$( selector ).css( item.property, '0px' );
									} else {
										$( selector ).css( item.property, '' );
									}
								});
							} else {
								item.hide.forEach(function(item) {
									var oval = $(item.key).val();
									$( selector ).css( item.property, oval );
								});
							}
						}
	
						if( typeof item.property != 'undefined' ) {
							$( selector ).css( item.property, val + suffix );
						}
						
						if( 'image_shape' == item.field || 'comment_image_shape' == item.field ) {
							$( selector ).removeClass( 'fp-img-circle fp-img-rounded fp-img-square' );
						}
						if( 'image_position' == item.field || 'comment_image_position' == item.field ) {
							$( selector ).removeClass( 'fp-img-left fp-img-right' );
						}
	
						if( ( item.field == 'image_shape' || 'image_position' == item.field ) || ( item.field == 'comment_image_shape' || 'comment_image_position' == item.field ) ) {
							$( selector ).addClass( 'fp-img-' + val ); 
							/**
							 * This lines of code use for layouting the notification preview
							 */
							if( 'image_position' == item.field || 'comment_image_position' == item.field ) {
								if( val == 'left' ) {
									$( '.rx-preview-inner' ).css( 'flex-direction', 'row' );
								} else {
									$( '.rx-preview-inner' ).css( 'flex-direction', 'row-reverse' );
								}
							}
						}
					})

				});
			});
		},
		optinAllowOrNot : function( button ){
			var button = $( button ),
			    args   = button.data('args'),
			    parent = button.parents('.rx-opt-in'),
			    inputs = parent.find('.rx-single-opt input'),
			    values = {};

			inputs.each(function(){
				var input = $(this)[0],
					id = input.id;
				if( $( input ).is(':checked') ) {
					values[ id ] = true;
				} else {
					values[ id ] = false;
				}
			});

			values  = Object.assign(values, args);

			$.ajax({
				type: 'post',
				url: ajaxurl,
				data: {
					action: 'rx_optin_check',
					fields : values
				},
				success: function(res) {
					if( res == 'true' || res == 'false' ) {
						parent.slideToggle( '500' );
					}
				}
			});
			
		},
		settingsTab : function( button ){
			var button = $(button),
				tabToGo = button.data('tab');

			button.addClass('active').siblings().removeClass('active');
			$('#fs-'+tabToGo).addClass('active').siblings().removeClass('active');
		},
		submitSettings : function( button ){
			var button = $(button),
				submitKey = button.data('key'),
				nonce = button.data('nonce'),
				form = button.parent('#rx-settings-general-form'),
				formData = $( form ).serializeArray();
		
			$.ajax({
				type: 'POST',
				url: ajaxurl,
				data: {
					action: 'rx_general_settings',
					key: submitKey,
					nonce: nonce,
					form_data: formData
				},
				success: function(res) {
					if ( res === 'success' ) {
						swal({
							title     : "Settings Saved!",
							text      : "Click OK to continue",
							icon      : "success",
							buttons   : [false, "Ok"],
						});
					} else {
						swal({
							title     : "Settings Not Saved!",
							text      : "Click OK to continue",
							icon      : "success",
							buttons   : [false, "Ok"],
						});
					}
				}
			});			
		},
		createTitle : function( selector ){
			$('body').on('change', selector, function( e ){
				var type = $(this).val(),
					title = e.currentTarget.selectedOptions[0].innerText,
					options = { year: 'numeric', month: 'short', day: 'numeric' },
					date = ( new Date() ).toLocaleDateString('en-US', options);
				return [ type, title, date ];
			});
		},
		enabledDisabled : function ( label ) {

			var $this = $(label),
				postID = $this.data("post"),
				nonce = $this.data("nonce"),
				siblings = $this.siblings("input"),
				$swal = $this.data("swal"),
				isActive = siblings.is(":checked");

			if (isActive) {
				$this
					.siblings(".rx-admin-status-title.nxast-enable")
					.removeClass("active");
				$this
					.siblings(".rx-admin-status-title.nxast-disable")
					.addClass("active");
			} else {
				$this
					.siblings(".rx-admin-status-title.nxast-disable")
					.removeClass("active");
				$this
					.siblings(".rx-admin-status-title.nxast-enable")
					.addClass("active");
			}

			$.ajax({
				type: "post",
				url: window.ajaxurl,
				data: {
					action: "reviewx_toggle_status",
					post_id: postID,
					nonce: nonce,
					status: isActive ? "inactive" : "active",
					url: window.location.href,
				},
				success: function (res) {
					if (res !== "success") {
						window.location.href = window.location.href;
					}
				},
			});

		},
		onLoadSettings : function ( type = 'option' ) {

			if($("#rx_"+type+"_allow_multi_criteria").is(':checked')){
				let allowed_image = "Enabled";
				$("#action_multi_criteria").text(allowed_image);
			} else {
				let allowed_image = "No";
				$("#action_multi_criteria").text(allowed_image);
			}

			if( RX_Admin.onGetCurrentPage() == 'post-type-reviewx' ){
				let custom_post_type = $("#rx_meta_custom_post_types option:selected").text();
				$("#action_custom_post_type").text(custom_post_type);
			}

			if( RX_Admin.onGetCurrentPage() != 'post-type-reviewx' ){
				$('.rx-wc-order-status').each(function() {
					let rx_wc_order_status = $("#rx_option_"+$(this).attr('data-order-key')+"");
					if( $(rx_wc_order_status).is( ':checked') ){
						$("#rx-wc-"+$(this).attr('data-order-key')+"").text($(this).attr('data-order-label'));
					}
				})
			}

			if($("#rx_"+type+"_allow_img").is(':checked')){
				let allowed_image = "Enabled";
				$("#action_image_allowed").text(allowed_image);
			} else {
				let allowed_image = "No";
				$("#action_image_allowed").text(allowed_image);
			}
	
			if($("#rx_"+type+"_allow_multiple_img").is(':checked')){
				let allowed_multiple_image = "Yes";
				$("#action_multiple_image_allowed").text(allowed_multiple_image);
			} else {
				let allowed_multiple_image = "No";
				$("#action_multiple_image_allowed").text(allowed_multiple_image);
			}	
			
			if($("#rx_"+type+"_allow_video").is(':checked')){
				let allowed_video = "Yes";
				$("#action_video_allowed").text(allowed_video);
			} else {
				let allowed_video = "No";
				$("#action_video_allowed").text(allowed_video);
			}

			if($("#rx_"+type+"_allow_anonymouse").is(':checked')){
				let allowed_anonymouse = "Yes";
				$("#action_anonymouse_allowed").text(allowed_anonymouse);
			} else {
				let allowed_anonymouse = "No";
				$("#action_anonymouse_allowed").text(allowed_anonymouse);
			}

			if($("#rx_"+type+"_allow_share_review").is(':checked')){
				let allowed_anonymouse = "Yes";
				$("#action_share_review_allowed").text(allowed_anonymouse);
			} else {
				let allowed_anonymouse = "No";
				$("#action_share_review_allowed").text(allowed_anonymouse);
			}
			
			if($("#rx_"+type+"_allow_like_dislike").is(':checked')){
				let allowed_anonymouse = "Yes";
				$("#action_like_dislike_allowed").text(allowed_anonymouse);
			} else {
				let allowed_anonymouse = "No";
				$("#action_like_dislike_allowed").text(allowed_anonymouse);
			}
	
			if($("#rx_"+type+"_allow_edit_review").is(':checked')){
				let allowed_edit_review = "Yes";
				$("#action_edit_review").text(allowed_edit_review);
			} else {
				let allowed_edit_review = "No";
				$("#action_edit_review").text(allowed_edit_review);
			}			
			
			if($("#rx_"+type+"_allow_recommendation").is(':checked')){
				let allow_recommendation = "Enabled";
				$("#action_recommendation_feature").text(allow_recommendation);
			} else {
				let allow_recommendation = "No";
				$("#action_recommendation_feature").text(allow_recommendation);
			}
	
			if($("#rx_"+type+"_allow_recommendation_feature").is(':checked')){
				let allow_recommendation_feature = "Yes";
				$("#action_recommendation_friends").text(allow_recommendation_feature);
			} else {
				let allow_recommendation_feature = "No";
				$("#action_recommendation_friends").text(allow_recommendation_feature);
			}			
			
			if($("#rx_"+type+"_review_per_page").val() != ''){
				let review_per_page = $("#rx_"+type+"_review_per_page").val();
				$("#action_pagination_per_page").text(review_per_page);
			} else {
				let review_per_page = $("#rx_"+type+"_review_per_page").val();
				$("#action_pagination_per_page").text(review_per_page);
			}
						
			if($("#rx_"+type+"_color_theme").val() != ''){
				let color_theme = $("#rx_"+type+"_color_theme").val();
				$("#action_color_theme_color").css({"background-color": color_theme, "width": "24px", "height": "24px", "border": "2px solid #fff", "box-shadow": "0px 1px 4px #b0b0b0", "border-radius": "6px"});
			} else {
				let color_theme = $("#rx_"+type+"_color_theme").val();
			}	
			
			if($("input[name='rx_"+type+"_graph_style']:checked").val() == "graph_style_one"){
				let graph_style = "Horizontal Bar";
				$("#action_graph_style").text(graph_style);
			}else if($("input[name='rx_"+type+"_graph_style']:checked").val() == "graph_style_two"){
				let graph_style = "Pie Chart";
				$("#action_graph_style").text(graph_style);
			} else if($("input[name='rx_"+type+"_graph_style']:checked").val() == "graph_style_three"){
				let graph_style = "Vertical Bar";
				$("#action_graph_style").text(graph_style);
			} else {
				let graph_style = "Horizontal Solid Bar";
				$("#action_graph_style").text(graph_style);
			}

			if($("#rx_"+type+"_rating_style").val() == "rating_style_one"){
				let rating_style = "Star";
				$("#action_rating_type").text(rating_style);
			}else if($("#rx_"+type+"_rating_style").val() == "rating_style_two"){
				let rating_style = "Emoji";
				$("#action_rating_type").text(rating_style);
			} else if($("#rx_"+type+"_rating_style").val() == "rating_style_three"){
				let rating_style = "Thumbs up";
				$("#action_rating_type").text(rating_style);
			}

			if($("#rx_"+type+"_allow_review_title").is(':checked')){
				let allow_title = "Enabled";
				$("#action_review_title").text(allow_title);
			} else {
				let allow_title = "No";
				$("#action_review_title").text(allow_title);
			}

			if($("#rx_"+type+"_allow_recaptcha").is(':checked')){
				let allow_recaptcha = "Enabled";
				$("#action_recaptcha").text(allow_recaptcha);
			} else {
				let allow_recaptcha = "No";
				$("#action_recaptcha").text(allow_recaptcha);
			}

			if($("#rx_"+type+"_disable_auto_approval").is(':checked')){
				let auto_approval = "Enabled";
				$("#action_review_auto_approval").text(auto_approval);
			} else {
				let auto_approval = "No";
				$("#action_review_auto_approval").text(auto_approval);
			}

			if($("#rx_"+type+"_allow_multiple_review").is(':checked')){
				let multiple_review = "Enabled";
				$("#action_multiple_review").text(multiple_review);
			} else {
				let multiple_review = "No";
				$("#action_multiple_review").text(multiple_review);
			}

		},
		onCheckCurrentPage: function () {
			let currentPage = $("#rx_builder_current_page").val();
			if( currentPage == 'reviewx-quick-setup' || currentPage == 'reviewx-review-email' || currentPage == 'rx-wc-settings' ){
				return true;
			}
			return false;
		},
		onSaveCurrentTab: function ( $tab ) {
			jQuery.ajax({
				url: ajax_admin.ajax_admin_url,
				type: 'post',
				data : {
					action: 'save_current_tab',
					tab: $tab,
					page: $("#rx_builder_current_page").val(),
					security: $(".rx-tab-nonce").val()
				},
				success: function( data ) {},
				error: function() {}
			});
		},
		onCheckCriteria: function () {
			let goForward = true;
			$("#append_body :input").map(function() {
				if( $(this).val() == '' ) {
					$(this).css( "border-color", "red");
					$(this).siblings('.show_error_message').text(ajax_admin.rx_criteria_error);
					goForward = false;
				}
			});
			return goForward;
		},
		onGetCurrentPage: function () {
			return $("#rx_builder_current_page").val();
		},
	};

	/**
	 * ReviewX Admin Fired
	 * when the document is ready.
	 */
	$(document).ready(function( $ ) {
		/**
		 * Current Tab Manage
		 */
		let $tabMenu = $('.rx-metatab-menu, .rx-builder-tab-menu');
		$tabMenu.on( 'click', 'li', function(){

			let $tab = $(this).data( 'tab' ),
				tabID = $(this).data('tabid') - 1;

			if ($tab == "email_tab") {
				$('.rx_save_setting_tab').text(ajax_admin.rx_before_email_sent);
			} else {
				$('.rx_save_setting_tab').text(ajax_admin.rx_save_setting);
			}

			var contentMenu = $(".rx-builder-tab-menu").find(
				'li[data-tab="content_tab"]'
			),
			cDisplay = "none";
			if (contentMenu.length > 0) {
				if (contentMenu[0] != undefined) {
					cDisplay = contentMenu[0].style.display;
					var lMenu = $(
						'.rx-builder-tab-menu li[data-tabid="' + tabID + '"]'
					);
					//cDisplay = lMenu[0].style.display;
				}
				if (cDisplay == "none" && dir != undefined) {
					if (dir == "left") {
						tabID = tabID - 1;
					} else {
						tabID = tabID + 1;
					}
				}
			}

			/***Save Review Email Current Tab */
			if( RX_Admin.onCheckCurrentPage() === true ) {
				if( $tab == 'editor_tab' || $tab == 'content_tab' || $tab == 'scheduled_emails' ) {
					jQuery.ajax({
						url: ajax_admin.ajax_admin_url,
						type: 'post',
						data : {
							action: 'save_review_email_current_tab',
							tab: $tab,
							security: $(".rx-tab-nonce").val()
						},
						success: function( data ) {},
						error: function( error ) {},
					});
				}
			}

			if( RX_Admin.onCheckCriteria() === true && RX_Admin.onCheckCurrentPage() === true ) {
				//Save current tab
				RX_Admin.onSaveCurrentTab( $tab );

				if ($(this).nodeName !== "BUTTON") {
					$(this).addClass( 'active' ).siblings().removeClass('active');
					$('#rx-' + $tab).addClass( 'active' ).siblings().removeClass('active');
					return;
				}

				$('.rx-metatab-menu li[data-tabid="' + tabID + '"]').trigger("click");
				$('.rx-builder-tab-menu li[data-tabid="' + tabID + '"]').trigger(
					"click"
				);
			}

			// TAB click, set changes value and display preview
			if( RX_Admin.onGetCurrentPage() == 'post-type-reviewx' ){
				RX_Admin.onLoadSettings('meta');
			} else {
				RX_Admin.onLoadSettings('option');
			}
		});

		/**
		 * Setting page saved individual tab
		 *
		 */
		// let $saveSettingTab = $('.rx_save_setting_tab')
		$('#rx_option_email_editor-tmce').trigger('click');
		$(document).on('click', ".rx_save_setting_tab", function (e) {			
			let that = this;
			//Grab current tab
			let $tab = $(this).data('tab');
			let tabID = $(this).data('tabid') - 1;
			
			if( RX_Admin.onCheckCriteria() === true ) {
				let $emailEditorHtml = $('#rx_option_email_editor-html');

				if ($emailEditorHtml) {
					$('#rx_option_email_editor-html').trigger('click');
				}

				let rx_tab_field_val = $("#rx-builder-form").serializeArray();
				let rxs = rx_tab_field_val.filter(function(rx) {
					if (rx.name == "rx_builder_current_tab") {
						return rx;
					}
				})

				if (rxs[0].value == 'content_tab') {
					if($('#rx_option_allow_recaptcha').is(":checked")) {
						if (!$('#rx_option_recaptcha_site_key').val() || !$('#rx_option_recaptcha_secret_key').val()) {
							Swal.fire({
								title: "Re-Captcha",
								text: "If you want to enable re-captcha, site key and secret key are required!",
								type: 'warning',
							})
							return;
						}
					}
				}

				if (rxs[0].value == "email_tab") {
					$('.rx_save_setting_tab').text(ajax_admin.rx_setting_sending);

					$.ajax({
						url: ajax_admin.ajax_admin_url,
						type: 'post',
						data: {
							action: 'save_setting_tab',
							rx_tab_field: rx_tab_field_val,
							security: $('.rx-setting-nonce').val(),
							filter: filterIntialization()
						},
						success: function (data) {
							$('#TB_overlay').click();

							$('#rx_option_email_editor-tmce').trigger('click');

							if (rx_tab_field_val[0].value == "email_tab") {
								$('.rx_save_setting_tab').text(ajax_admin.rx_before_email_sent);
							}
							if( data.success === true ) {
								if( $tab != undefined ) {
									jQuery.ajax({
										url: ajax_admin.ajax_admin_url,
										type: 'post',
										data : {action: 'save_current_tab',tab: $tab,page: $("#rx_builder_current_page").val(),security: $(".rx-tab-nonce").val()},
										success: function( data ) {},
										error: function() {}
									});
									e.preventDefault();
									RX_Admin.tabChanger(that);
								} else {
									if (rx_tab_field_val[0].value == "email_tab") {
										Swal.fire({
											title: ajax_admin.review_success_title,
											text: '',
											html: ajax_admin.review_sending_msg,
											type: 'success',
											timer: 2000,
										}).then(function() {});
									}
								}
								$( "." +data.optimistic_lock_form_id + "_version" ).val(data.optimistic_lock_version);
							} else {
								Swal.fire({
									title: ajax_admin.review_failed_title,
									text: '',
									html: ajax_admin.review_failed_msg,
									type: 'error',
									timer: 2000,
								});
							}
						},
						error: function (error) {
							let response = error.responseJSON;
							if (response.action === "optimistic_error") {
								Swal.fire({
									title: "Error",
									text: '',
									html: response.message,
									type: 'error',
									timer: 10000,
								}).then(function() {
									window.location.reload(true);
								});
							}
						}
					});

				} else { 
					$('.rx_save_setting_tab').text(ajax_admin.rx_setting_saving);
					$.ajax({
						url: ajax_admin.ajax_admin_url,
						type: 'post',
						data: {
							action: 'save_setting_tab',
							rx_tab_field: rx_tab_field_val,
							security: $('.rx-setting-nonce').val()
						},
						success: function (data) {
							$('.rx_save_setting_tab').text(ajax_admin.rx_save_setting);
							$('#rx_option_email_editor-tmce').trigger('click');
							if( data.success === true ) {
	
								if( $tab != undefined ) {
									//Save current tab
									RX_Admin.onSaveCurrentTab( $tab );
									e.preventDefault();
									RX_Admin.tabChanger( that );
						
								} else {
									Swal.fire({
										title: ajax_admin.review_success_title,
										text: '',
										html: ajax_admin.review_success_msg,
										type: 'success',
										timer: 2000,
									}).then(function() {});
								}
								$( "." +data.optimistic_lock_form_id + "_version" ).val(data.optimistic_lock_version);
							} else {
								Swal.fire({
									title: ajax_admin.review_failed_title,
									text: '',
									html: ajax_admin.review_failed_msg,
									type: 'error',
									timer: 2000,
								});
							}
						},
						error: function (error) {
							let response = error.responseJSON;
							if (response.action === "optimistic_error") {
								Swal.fire({
									title: "Error",
									text: '',
									html: response.message,
									type: 'error',
									timer: 10000,
								}).then(function() {
									window.location.reload(true);
								});
							}
						}
					});					
				}
			}
		});

		$(document).on('keyup', '#append_body :input', function() {
			if( $(this).val() != '' ) {
				$(this).css("border-color", "#CCCCCC");
				$(this).siblings('.show_error_message').text('');
				//goForward = true;
			}
		});
		/*=======================================*/

		let $graphStyle = $('.rx-choose-graph-style');
		$graphStyle.on( 'click', function(){
			let $graph = $(this).val();
			if( $graph == "s1" ){

				$(".graph-1").removeClass('rx-div-hide');
				$(".graph-1").addClass('rx-div-show');

				$(".graph-2").removeClass('rx-div-show');
				$(".graph-2").addClass('rx-div-hide');

				$(".graph-3").removeClass('rx-div-show');
				$(".graph-3").addClass('rx-div-hide');

			} else if( $graph == "s2" ){

				$(".graph-2").removeClass('rx-div-hide');
				$(".graph-2").addClass('rx-div-show');

				$(".graph-1").removeClass('rx-div-show');
				$(".graph-1").addClass('rx-div-hide');

				$(".graph-3").removeClass('rx-div-show');
				$(".graph-3").addClass('rx-div-hide');				

			} else if( $graph == "s3" ){

				$(".graph-3").removeClass('rx-div-hide');
				$(".graph-3").addClass('rx-div-show');

				$(".graph-1").removeClass('rx-div-show');
				$(".graph-1").addClass('rx-div-hide');

				$(".graph-2").removeClass('rx-div-show');
				$(".graph-2").addClass('rx-div-hide');
			}
		});

		RX_Admin.init();
	});

	function handleUniqueId(length) {
		var result           = '';
		var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		var charactersLength = characters.length;
		for ( var i = 0; i < length; i++ ) {
		   result += characters.charAt(Math.floor(Math.random() * charactersLength));
		}
		return result;
	}

	let maxField 			= 3; //Input fields increment limitation
	let wrapper 		    = $('#append_body'); //Input field wrapper
	const total 			= ($('.playfield').length);
	let counter 			= 1;
	let currentFields 		= total;

	$(".rx-click-overlay").on( 'click', function(){ //Once add button is clicked

		let total 			= $('.playfield').length;
		if( total < maxField ) { //Check maximum number of input fields

			let criteria_name       = 'ctr_'+handleUniqueId(5);
			let fieldHTML ='';
			if( $('#rx_builder_current_page').val() == 'post-type-reviewx' ) {
				fieldHTML 		    = '<tr valign="top"><td class="middle-align">' +
				'<input type="text" name="rx_meta_review_criteria[]" maxlength="80" value="" class="timezone_string rx-meta-field playfield" placeholder="Criteria Name"/><input type="hidden" name="rx_meta_review_criteria_name[]" value="'+criteria_name+'"/>' +
				'<a href="javascript:void(0);" class="up_button" title="Add"><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve"><style type="text/css">.st0{fill:#9BA1B0;}</style><path class="st0" d="M99.1,47.9L82.7,32.5c-0.8-0.8-2.1-1-3.1-0.5c-1.1,0.5-1.7,1.5-1.7,2.6v6.7H58.7V22.1h6.7 c1.2,0,2.2-0.7,2.6-1.7c0.5-1.1,0.2-2.3-0.5-3.1L52.1,0.9C51.6,0.3,50.8,0,50,0s-1.6,0.3-2.1,0.9L32.5,17.3c-0.8,0.8-1,2.1-0.5,3.1 c0.5,1.1,1.5,1.7,2.6,1.7h6.7v19.2H22.1v-6.7c0-1.2-0.7-2.2-1.7-2.6c-1.1-0.5-2.3-0.2-3.1,0.5L0.9,47.9C0.3,48.4,0,49.2,0,50 s0.3,1.6,0.9,2.1l16.3,15.4c0.8,0.8,2.1,1,3.1,0.5c1.1-0.5,1.7-1.5,1.7-2.6v-6.7h19.2v19.2h-6.7c-1.2,0-2.2,0.7-2.6,1.7 c-0.5,1.1-0.2,2.3,0.5,3.1l15.4,16.3c0.5,0.6,1.3,0.9,2.1,0.9s1.6-0.3,2.1-0.9l15.4-16.3c0.8-0.8,1-2.1,0.5-3.1 c-0.5-1.1-1.5-1.7-2.6-1.7h-6.7V58.7h19.2v6.7c0,1.2,0.7,2.2,1.7,2.6c1.1,0.5,2.3,0.2,3.1-0.5l16.3-15.4c0.6-0.5,0.9-1.3,0.9-2.1 S99.7,48.4,99.1,47.9z"/><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg></a>' +
				'<a href="javascript:void(0);" class="remove_button" title="Remove"><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve"><g><path class="st0" d="M19,35.3c1.4,20.8,2.7,37.6,4.1,58.4c0.2,3.6,3.2,6.2,6.9,6.2c13.2,0,26.5,0,39.7,0c3.9,0,6.7-2.7,7-6.7 C77.8,76,79,58.8,80.1,41.5c0.3-3.8,0.4-3.6,0.7-7.6c-20.7,0-41.2,0-61.7,0C19,34.4,19,34.9,19,35.3z M61.7,56 c0.2-2.4,0.4-4.7,0.6-7.1c0.2-2.4,1.5-3.7,3.4-3.5c1.9,0.2,3,1.6,2.8,4c-0.6,7.4-1.3,14.8-1.9,22.2c-0.4,4.1-0.7,8.3-1.1,12.4 c-0.2,2.2-1.5,3.5-3.3,3.4c-1.8-0.1-3-1.6-2.9-3.2C60.1,74.5,60.9,65.2,61.7,56z M46.7,49.3c0-2.6,1.2-4,3.2-3.9 c1.9,0.1,3,1.4,3,3.9c0,5.7,0,11.5,0,17.2c0,0,0,0,0,0c0,5.7,0,11.3,0,17c0,2.5-1.2,4.1-3.1,4.1c-1.9,0-3.1-1.5-3.1-4 C46.7,72,46.7,60.7,46.7,49.3z M32.8,45.7c2.1-1.1,4.3,0.3,4.6,2.9c0.6,6.7,1.2,13.5,1.8,20.2c0.4,5,0.9,9.9,1.3,15.6 c0,1.4-1.1,2.9-2.9,3.1c-1.8,0.2-3.2-1.2-3.4-3.3c-1-11.5-2-23.1-3.1-34.6C31,47.9,31.3,46.5,32.8,45.7z"/><path class="st0" d="M88.7,16.3c-0.3-2.7-2.6-4.8-5.4-5.2c-1.1-0.2-2.2-0.2-3.3-0.2c-4.2,0-8.4,0-12.9,0c0-1.4,0-2.6,0-3.8 C66.9,2.7,64.2,0,59.7,0c-6.6,0-13.2,0-19.8,0c-4.2,0-7,2.7-7.2,6.9c-0.1,1.2,0,2.5,0,3.9c-1.1,0-1.9,0.1-2.7,0.1c-4,0-8-0.1-12,0 c-3.3,0.1-6.1,1.7-6.7,4.5c-0.6,2.5-0.4,5.2-0.6,7.9c26.3,0,52.1,0,78.1,0C88.7,20.9,88.9,18.6,88.7,16.3z"/></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg></a>' +
				'<div class="show_error_message"></div>' +
				'</div></td></tr>';
			} else {
				fieldHTML 		    = '<tr valign="top"><td class="middle-align">' +
				'<input type="text" name="rx_option_review_criteria[]" maxlength="80" value="" class="timezone_string rx-meta-field playfield" placeholder="Criteria Name"/><input type="hidden" name="rx_option_review_criteria_name[]" value="'+criteria_name+'"/>' +
				'<a href="javascript:void(0);" class="up_button" title="Add"><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve"><style type="text/css">.st0{fill:#9BA1B0;}</style><path class="st0" d="M99.1,47.9L82.7,32.5c-0.8-0.8-2.1-1-3.1-0.5c-1.1,0.5-1.7,1.5-1.7,2.6v6.7H58.7V22.1h6.7 c1.2,0,2.2-0.7,2.6-1.7c0.5-1.1,0.2-2.3-0.5-3.1L52.1,0.9C51.6,0.3,50.8,0,50,0s-1.6,0.3-2.1,0.9L32.5,17.3c-0.8,0.8-1,2.1-0.5,3.1 c0.5,1.1,1.5,1.7,2.6,1.7h6.7v19.2H22.1v-6.7c0-1.2-0.7-2.2-1.7-2.6c-1.1-0.5-2.3-0.2-3.1,0.5L0.9,47.9C0.3,48.4,0,49.2,0,50 s0.3,1.6,0.9,2.1l16.3,15.4c0.8,0.8,2.1,1,3.1,0.5c1.1-0.5,1.7-1.5,1.7-2.6v-6.7h19.2v19.2h-6.7c-1.2,0-2.2,0.7-2.6,1.7 c-0.5,1.1-0.2,2.3,0.5,3.1l15.4,16.3c0.5,0.6,1.3,0.9,2.1,0.9s1.6-0.3,2.1-0.9l15.4-16.3c0.8-0.8,1-2.1,0.5-3.1 c-0.5-1.1-1.5-1.7-2.6-1.7h-6.7V58.7h19.2v6.7c0,1.2,0.7,2.2,1.7,2.6c1.1,0.5,2.3,0.2,3.1-0.5l16.3-15.4c0.6-0.5,0.9-1.3,0.9-2.1 S99.7,48.4,99.1,47.9z"/><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg></a>' +
				'<a href="javascript:void(0);" class="remove_button" title="Remove"><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve"><g><path class="st0" d="M19,35.3c1.4,20.8,2.7,37.6,4.1,58.4c0.2,3.6,3.2,6.2,6.9,6.2c13.2,0,26.5,0,39.7,0c3.9,0,6.7-2.7,7-6.7 C77.8,76,79,58.8,80.1,41.5c0.3-3.8,0.4-3.6,0.7-7.6c-20.7,0-41.2,0-61.7,0C19,34.4,19,34.9,19,35.3z M61.7,56 c0.2-2.4,0.4-4.7,0.6-7.1c0.2-2.4,1.5-3.7,3.4-3.5c1.9,0.2,3,1.6,2.8,4c-0.6,7.4-1.3,14.8-1.9,22.2c-0.4,4.1-0.7,8.3-1.1,12.4 c-0.2,2.2-1.5,3.5-3.3,3.4c-1.8-0.1-3-1.6-2.9-3.2C60.1,74.5,60.9,65.2,61.7,56z M46.7,49.3c0-2.6,1.2-4,3.2-3.9 c1.9,0.1,3,1.4,3,3.9c0,5.7,0,11.5,0,17.2c0,0,0,0,0,0c0,5.7,0,11.3,0,17c0,2.5-1.2,4.1-3.1,4.1c-1.9,0-3.1-1.5-3.1-4 C46.7,72,46.7,60.7,46.7,49.3z M32.8,45.7c2.1-1.1,4.3,0.3,4.6,2.9c0.6,6.7,1.2,13.5,1.8,20.2c0.4,5,0.9,9.9,1.3,15.6 c0,1.4-1.1,2.9-2.9,3.1c-1.8,0.2-3.2-1.2-3.4-3.3c-1-11.5-2-23.1-3.1-34.6C31,47.9,31.3,46.5,32.8,45.7z"/><path class="st0" d="M88.7,16.3c-0.3-2.7-2.6-4.8-5.4-5.2c-1.1-0.2-2.2-0.2-3.3-0.2c-4.2,0-8.4,0-12.9,0c0-1.4,0-2.6,0-3.8 C66.9,2.7,64.2,0,59.7,0c-6.6,0-13.2,0-19.8,0c-4.2,0-7,2.7-7.2,6.9c-0.1,1.2,0,2.5,0,3.9c-1.1,0-1.9,0.1-2.7,0.1c-4,0-8-0.1-12,0 c-3.3,0.1-6.1,1.7-6.7,4.5c-0.6,2.5-0.4,5.2-0.6,7.9c26.3,0,52.1,0,78.1,0C88.7,20.9,88.9,18.6,88.7,16.3z"/></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg></a>' +
				'<div class="show_error_message"></div>' +
				'</div></td></tr>';
			}

			$(wrapper).append(fieldHTML); // Add field html
		}
		currentFields++;
		counter++;

		handleAddNewButtonVisibility(currentFields);
	});

	$(wrapper).on('click', '.remove_button', function(e){ //Once remove button is clicked
		e.preventDefault();
		$(this).parent().parent().remove(); //Remove field html.

		currentFields--;
		handleAddNewButtonVisibility(currentFields);
	});

	function handleAddNewButtonVisibility(current) {
		const el = $(".add-field");
		if( current > maxField ) {	
			currentFields = 3;			
			return el.prop("disabled", true);
		}
		return el.prop("disabled", false);
	}

	//document on load
	if( RX_Admin.onGetCurrentPage() == 'post-type-reviewx' ){
		RX_Admin.onLoadSettings('meta');
	} else {
		RX_Admin.onLoadSettings('option');
	}

	/**
	 * When make any changes and click previous/next button
	 */
	$(document).on('click', ".quick-builder-submit-btn", function () {
		RX_Admin.onLoadSettings('option');
	});	

	//Sortable rating criteria
	$(document).ready( function () {
		$('.form-table #append_body').sortable({
			cursor: 'move',
		});
	});

	$('body').on('click', 
		'.is-pro td > div > label, .rx-pro-checkbox table tr td, .rx-radio-pro, #rx-admin-upload-photo, #rx-admin-upload-video, .rx_admin_remove_image, .rx_admin_remove_video, .rviwx-rating-column__item-field, .rx_highlight_switch, .rx-media-upload-button, .reviewx_recommended_list .reviewx_radio', function (e) {
		e.preventDefault();

		var premium_content = document.createElement("p");
		var premium_anchor = document.createElement("a");

		premium_anchor.setAttribute('href', 'https://reviewx.io/upgrade/reviewx-pro');
		premium_anchor.setAttribute('target', '_blank');
		premium_anchor.innerText 		= 'Premium';
		premium_anchor.style.color 		= 'red';
		var pro_label 					= $(this).find('.rx-pro-label');
		if (pro_label.hasClass('has-to-update')) {
			premium_anchor.innerText = 'Latest Pro v' + pro_label.text().toString().replace(/[ >=<]/g, '');
		}
		premium_content.innerHTML = 'You need to upgrade to the <strong>' + premium_anchor.outerHTML + ' </strong> Version to use this module.';

		Swal.fire({
			title: "Opps...",
			html: premium_content,
			type: 'error',
		});
		return;		
	});

	$('body').on('click', '.rx-edit-video-source-control, .rx-set-edit-video-url, .rx-edit-review-video-uploader, .rx-manual-review-pro', function (e) {
		e.preventDefault();
		var premium_content = document.createElement("p");
		var premium_anchor = document.createElement("a");

		premium_anchor.setAttribute('href', 'https://reviewx.io/upgrade/reviewx-pro');
		premium_anchor.setAttribute('target', '_blank');
		premium_anchor.innerText 		= 'Premium';
		premium_anchor.style.color 		= 'red';
		var pro_label 					= $(this).find('.rx-pro-label');
		if (pro_label.hasClass('has-to-update')) {
			premium_anchor.innerText = 'Latest Pro v' + pro_label.text().toString().replace(/[ >=<]/g, '');
		}
		premium_content.innerHTML = 'You need to upgrade to the <strong>' + premium_anchor.outerHTML + ' </strong> Version to use this module.';

		Swal.fire({
			title: "Opps...",
			html: premium_content,
			type: 'error',
		});
		return;		
	});	

	$(".rx-click-overlay").on('click',function() {
		if($(".add-field").is(':disabled')) {
			var premium_content = document.createElement("p");
			var premium_anchor = document.createElement("a");
	
			premium_anchor.setAttribute('href', 'https://reviewx.io/upgrade/reviewx-pro');
			premium_anchor.setAttribute('target', '_blank');
			premium_anchor.innerText 		= 'Premium';
			premium_anchor.style.color 		= 'red';
			var pro_label 					= $(this).find('.rx-pro-label');
			if (pro_label.hasClass('has-to-update')) {
				premium_anchor.innerText = 'Latest Pro v' + pro_label.text().toString().replace(/[ >=<]/g, '');
			}
			premium_content.innerHTML = 'You need to upgrade to the <strong>' + premium_anchor.outerHTML + ' </strong> Version to use this module.';
	
			Swal.fire({
				title: "Opps...",
				html: premium_content,
				type: 'error',
			});
			return;
		}		
	});

	/*========================================
	 * Function for default review open image
	 *========================================*/
	$(document).ready( function ($) {
		$('.popup-link').magnificPopup({
			delegate: 'a',
			type: 'image',
			tLoading: 'Loading image #%curr%...',
			mainClass: 'mfp-img-mobile',
			gallery: {
				enabled: true,
				navigateByImgClick: true,
				preload: [0,1]
			},
			image: {
				tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
			}
		});
	});

	$('.rx_quick_setup_skip_email').on('click', function(){
		$('#rx_builder_current_tab').val( 'display_tab' );
		jQuery.ajax({
			url: ajax_admin.ajax_admin_url,
			type: 'post',
			data : {
				action: 'save_quick_setup_current_tab',
				tab: 'display_tab',
				security: $(".rx-tab-nonce").val()
			},
			success: function( data ){
			},
			error: function( err ){
				console.log(err);
			}
		});
		$('.rx-metatab-menu li:nth-child(4)').removeClass('active');
		$('.rx-metatab-menu li:nth-child(5)').addClass( 'active' );
		$('#rx-display_tab').addClass( 'active' ).siblings().removeClass('active');
	});

	// Finalize button for quick setup
	$('.quick-builder-finalize-btn').on('click', function(){
		let redirect_url = $(this).data('redirect-url');
		Swal.fire({
			title: 'Good job!',
			text: '',
			html: 'Setup is Complete.',
			type: 'success',
			timer: 2000,
		}).then(function() {
			window.location = redirect_url;
		});
	});

	$('#send_test_email_section').hide();
	$('.send_test_email').on('change', function () {
		if ($(this).is(":checked")) {
			$('#send_test_email_section').show();
		} else {
			$('#send_test_email_section').hide();
		}
	});

	$('#send_test_email').on('keyup', function () {
		$('.rx-test-email-validation-error').hide();
	});

	$('#send_test_email_button').on('click', function () {
		var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
		if (testEmail.test($("#send_test_email").val())){
			save_setting_tab(function() {
				$.ajax({
					url: ajax_admin.ajax_admin_url,
					type: 'post',
					data : {
						action: 'send_test_email',
						test_email: $("#send_test_email").val()
					},
					success: function( data ){
						Swal.fire({
							title: ajax_admin.rx_test_email_title,
							text: '',
							html: ajax_admin.rx_test_email_message,
							type: 'success',
							timer: 2000,
						})
					},
					error: function( err ){
						console.log(err);
					}
				});
			})
		} else {
			$('.rx-test-email-validation-error').show();
			$('.rx-test-email-validation-error').text(ajax_admin.rx_test_email_valid);
		}
	});

	$('#filterButton').on('click', function() {
		$.ajax({
			url: ajax_admin.ajax_admin_url,
			type: 'post',
			data : {
				action: 'rx_send_email',
				filter: filterIntialization(),
				returned: true
			},
			success: function( data ){
				$('#TB_overlay').click()
				Swal.fire({
					title: ajax_admin.review_success_title,
					text: '',
					html: ajax_admin.rx_mail_sent_msg,
					type: 'success',
					timer: 2000,
				});
			},
			error: function( err ){
				console.log(err);
			}
		});
	})

	$('#schedule_filterButton').on('click', function() {
		$.ajax({
			url: ajax_admin.ajax_admin_url,
			type: 'post',
			data : {
				action: 'rx_send_schedule_email',
				filter: filterSchedule(),
			},
			success: function( data ){
				$('#TB_overlay').click();

				Swal.fire({
					title: ajax_admin.review_success_title,
					text: '',
					html: 'Email Schedule Successfully!',
					type: 'success',
					timer: 2000,
				});
			},
			error: function( err ){
				console.log(err);
			}
		});
	})

	function filterIntialization(prefix = '') {

		const DATE_RANGE = {
			yesterday: 'yesterday',
			last_week: 'last_week',
			this_month: 'this_month',
			last_month: 'last_month',
			this_year: 'this_year',
			last_year: 'last_year',
			all_the_time: 'all_the_time',
			custom_date: 'custom_date'
		};

		const FILTER_BY = {
			by_category: 'by_category',
			by_products: 'by_products',
			by_special_conditions: 'by_special_conditions',
			by_both: [
				'by_category',
				'by_products'
			],
		}

		let orderStatusElem = $("#" + prefix + "rx_order_status");
		let dateRangeElem = $("#" + prefix + "date_range");
		let startTimeElem = $("#" + prefix + "start_datetime");
		let endTimeElem = $("#" + prefix + "end_datetime");
		let filterProductsElem = $("#" + prefix + "filter_products");
		let filterByElem = $("#" + prefix + "filter_by");
		let filterByCategoriesElem = $("#" + prefix + "filter_by_category");
		let filterByProductsElem = $("#" + prefix + "filter_by_products");
		let filterByConditionsElem = $("#" + prefix + "filter_by_conditions");

		// filterByCategoriesElem.select2();
		// filterByProductsElem.select2();

		customDateDisableFields(true);
		filterProductDisableFields(true);
		filterByDisabledFields(true, []);

		// dateRangeElem.change(function () {
		// 	customDateDisableFields($(this).val() !== DATE_RANGE.custom_date);
		// });

		filterProductsElem.change(function () {
			let isChecked = $(this).is(":checked");
			filterProductDisableFields(!isChecked);

			if (! isChecked) {
				filterByElem.val('-');
				filterByDisabledFields(true);
			}

		});

		// filterByElem.change(function () {
		// 	let only = $(this).val() === "by_both" ? FILTER_BY['by_both'] : [FILTER_BY[$(this).val()]];
		// 	filterByDisabledFields(true, only);
		// });

		function customDateDisableFields(action) {
			startTimeElem.prop('disabled', action);
			endTimeElem.prop('disabled', action);
		}

		function filterProductDisableFields(action) {
			filterByElem.prop('disabled', action);
		}

		function filterByDisabledFields(action, only = [], onlyAction = false) {

			filterByCategoriesElem.prop(
				'disabled',
				only.includes(FILTER_BY.by_category) ? onlyAction : action
			);

			filterByProductsElem.prop(
				'disabled',
				only.includes(FILTER_BY.by_products) ? onlyAction : action
			);

			filterByConditionsElem.prop(
				'disabled',
				only.includes(FILTER_BY.by_special_conditions) ? onlyAction : action
			);

		}

		return {
			'order_status': orderStatusElem.val(),
			'date_range': dateRangeElem.val()
		}
	}

	function filterSchedule() {
		let cronAfterElem = $("#cron_after");
		return Object.assign(filterIntialization('schedule_'), {
			'cron_after': cronAfterElem.val()
		});
	}

	filterIntialization();
	filterIntialization('schedule_');

	if($('#rx_option_allow_recaptcha').is(':checked')){
		$("#rx-option-recaptcha_site_key").show();
		$("#rx-option-recaptcha_secret_key").show();
	}

	$('#rx_option_allow_recaptcha').on('click', function() {
		if($(this).is(':checked')){
			$("#rx-option-recaptcha_site_key").fadeIn();
			$("#rx-option-recaptcha_secret_key").fadeIn();
		} else {
			$("#rx-option-recaptcha_site_key").fadeOut();
			$("#rx-option-recaptcha_secret_key").fadeOut();
		}
	});

	if($('#rx_meta_allow_recaptcha').is(':checked')){
		$("#rx-option-recaptcha_site_key").show();
		$("#rx-option-recaptcha_secret_key").show();
	}

	$('#rx_meta_allow_recaptcha').on('click', function() {
		if($(this).is(':checked')){
			$("#rx-option-recaptcha_site_key").fadeIn();
			$("#rx-option-recaptcha_secret_key").fadeIn();
		} else {
			$("#rx-option-recaptcha_site_key").fadeOut();
			$("#rx-option-recaptcha_secret_key").fadeOut();
		}
	});

	/**
	 * Please Use when you need to save  all the form
	 * and then you need to do something
	 * @param fn
	 */
	function save_setting_tab(fn) {
		let rx_tab_field_val = $("#rx-builder-form").serializeArray();
		$.ajax({
			url: ajax_admin.ajax_admin_url,
			type: 'post',
			data: {
				action: 'save_setting_tab',
				rx_tab_field: rx_tab_field_val,
				security: $('.rx-setting-nonce').val()
			},
			success: function (data) {
				$( "." +data.optimistic_lock_form_id + "_version" ).val(data.optimistic_lock_version);
				fn(data);
			},
		});
	}

	if(!$('#rx_option_allow_multi_criteria').is(':checked') && !$('#rx_meta_allow_multi_criteria').is(':checked')) {
		$("#rx-option-review_criteria").hide();
	}

	$('#rx_option_allow_multi_criteria').on('click', function() {
		if($(this).is(':checked')) {
			$("#rx-option-review_criteria").fadeIn();
		} else {
			$("#rx-option-review_criteria").fadeOut();
		}
	});

	if($('#rx_option_unsubscribe_url').val() == '') {
		$('#rx-option-unsubscribe_url').hide();
	}

	$(document).on('click', ".post-type-reviewx .quick-builder-submit-btn", function () {
		RX_Admin.tabChanger(this);
	});

	$('#rx_meta_allow_multi_criteria').on('click', function() {
		if($(this).is(':checked')) {
			$("#rx-option-review_criteria").fadeIn();
		} else {
			$("#rx-option-review_criteria").fadeOut();
		}
	});

	$(document).ready( function ($) {
		$("#rx_meta_custom_post_types").on('change', function(){
			let $that = $(this)
			$.ajax({
				url: ajax_admin.ajax_admin_url,
				type: 'post',
				data: {
					action: 'check_custom_post_type_exists',
					cpt_id: $(this).val(),
					post_id: $("#post_ID").val(),
					security: $('.rx-setting-nonce').val()
				},
				success: function (data) {
					if(data.success == false && data.self == false ){
						Swal.fire({
							title: "Opps...",
							html: "This post type already in used",
							type: 'error',
						});
						$($that).val(0);
					}
				},
			});
		})
	})

	$('.rx-send-manually').click(function () {
		$.ajax({
			url: ajax_admin.ajax_admin_url,
			type: 'post',
			data : {
				action: 'rx_send_now',
				order_id: $(this).data('orderId'),
			},
			success: function( data ){
				Swal.fire({
					title: ajax_admin.review_success_title,
					text: '',
					html: 'Email Schedule Successfully!',
					type: 'success',
					timer: 2000,
				});

				window.location.reload();
			},
			error: function( err ){
				console.log(err);
			}
		});
	});

	$('.rx-cancelled-manually').click(function () {
		$.ajax({
			url: ajax_admin.ajax_admin_url,
			type: 'post',
			data : {
				action: 'rx_cancelled_now',
				order_id: $(this).data('orderId'),
			},
			success: function( data ){
				Swal.fire({
					title: ajax_admin.review_success_title,
					text: '',
					html: 'Email Cancelled Successfully!',
					type: 'success',
					timer: 2000,
				});

				window.location.reload();
			},
			error: function( err ){
				console.log(err);
			}
		});
	});

	$(document).on('click',  "#resetEmailTemplate", function(e) {
		e.preventDefault();
		
		Swal.fire({
			title : ajax_admin.rx_mail_reset_template,
			text :  ajax_admin.rx_mail_asked_for_reset,
			type: 'info',
			confirmButtonText: ajax_admin.rx_mail_reset_confirm_button_text,
			showCancelButton: true
		}).then(function(result) {
			if(result.value) {
				tinyMCE.get('rx_option_email_editor').setContent(ajax_admin.rx_mail_default_template);
				Swal.fire({
					title: ajax_admin.review_success_title,
					text: '',
					html: ajax_admin.rx_mail_reset_success_text,
					type: 'success',
					timer: 2000,
				});
			}
		});
		
	});

})( jQuery );