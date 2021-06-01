;( function( $ ) {

	function cf_wp_customize(key, callback) {
		wp.customize( key, function( value ) {
			value.bind( callback );
		});
	}

	// ********** organizations **********
	cf_wp_customize( 
		'crowdfundly_organization_background_color', 
		function( newval ) {
			$('.crowdfundy-org .content-body').css('background-color', newval );
        }
	);

	cf_wp_customize( 
		'cf_org_slider_height', 
		function( newval ) {
			$('.organization__slider .slick-track .slick-slide img').css('height', newval + 'px');
        }
	);

	cf_wp_customize(
		'crowdfundly_org_section_bg_color', 
		function( newval ) {
			$('.organization__details').css('background-color', newval );
        }
	);

	cf_wp_customize( 
		'crowdfundly_org_name_color', 
		function( newval ) {
			$('.organization__info-name').css('color', newval );
        }
	);

	cf_wp_customize( 
		'crowdfundly_org_info_color', 
		function( newval ) {
			$('.organization__info-address').css('color', newval );
        }
	);

	cf_wp_customize( 
		'crowdfundly_organization_social_media_heading_color', 
		function( newval ) {
			$('.organization__social-title').css('color', newval );
        }
	);

	cf_wp_customize( 
		'crowdfundly_organization_social_media_name_color', 
		function( newval ) {
			$('.organization__social-item-title').css('color', newval );
        }
	);

	cf_wp_customize( 
		'crowdfundly_organization_social_media_link_color', 
		function( newval ) {
			$('.organization__social-item-subtitle').css('color', newval );
        }
	);

	cf_wp_customize( 
		'crowdfundly_organization_title_color', 
		function( newval ) {
			$('.organization__details-title').css('color', newval );
        }
	);

	cf_wp_customize( 
		'crowdfundly_organization_desciption_color', 
		function( newval ) {
			$('.organization__details-description p > span').css('color', newval );
        }
	);

	cf_wp_customize( 
		'cf_organization_title_fontsize', 
		function( newval ) {
			$('.organization__details-title').css('font-size', newval + 'px');
        }
	);

	cf_wp_customize( 
		'cf_organization_title_text_transform', 
		function( newval ) {
			$('.organization__details-title').css('text-transform', newval);
        }
	);

	cf_wp_customize( 
		'cf_organization_description_fontsize', 
		function( newval ) {
			$('.organization__details-description p').css('font-size', newval + 'px');
        }
	);
	
	cf_wp_customize( 
		'cf_org_logo_width', 
		function( newval ) {
			$('.organization__info-logo .organization__info-logo-img').css('width', newval + 'px');
			$('.organization__info-logo').css('width', newval + 'px');
			$('.organization__info-logo .organization__info-logo-img').css('height', newval + 'px');
			$('.organization__info-logo').css('height', newval + 'px');
        }
	);

	cf_wp_customize( 
		'cf_org_social_media_icon_size', 
		function( newval ) {
			$('.template .organization__social-item-icon').css('font-size', newval + 'px');
        }
	);

	cf_wp_customize( 
		'cf_org_recent_campaign_title', 
		function( newval ) {
			$('.organization__campaigns-title').html(newval);
        }
	);

	cf_wp_customize( 
		'cf_org_recent_camp_heading_text_transform', 
		function( newval ) {
			$('.organization__campaigns-title').css('text-transform', newval);
        }
	);

	cf_wp_customize( 
		'cf_org_heading_font_size', 
		function( newval ) {
			$('.organization__campaigns-title').css('font-size', newval + 'px');
        }
	);

	cf_wp_customize( 
		'crowdfundly_organization_heading_color', 
		function( newval ) {
			$('.organization__campaigns-title').css('color', newval);
        }
	);

	cf_wp_customize( 
		'crowdfundly_org_card_bg_color', 
		function( newval ) {
			$('.campaign-card').css('background-color', newval);
        }
	);

	cf_wp_customize(
		'crowdfundly_org_card_bg_color_hover', 
		function( newval ) {
			$('.campaign-card').hover(function() {
				$(this).css('background-color', newval);
			});
        }
	);

	cf_wp_customize( 
		'crowdfundly_org_card_image_bg_color', 
		function( newval ) {
			$('.campaign-card__top').css('background-color', newval);
        }
	);

	cf_wp_customize( 
		'crowdfundly_org_card_name_color', 
		function( newval ) {
			$('.campaign-card__title').css('color', newval);
        }
	);

	cf_wp_customize( 
		'cf_organization_name_fontsize', 
		function( newval ) {
			$('.organization__info-name').css('font-size', newval + 'px');
        }
	);

	cf_wp_customize( 
		'crowdfundly_org_card_description_color', 
		function( newval ) {
			$('.campaign-card__description').css('color', newval);
        }
	);

	cf_wp_customize( 
		'crowdfundly_org_card_progress_bg_color', 
		function( newval ) {
			$('.progress--slim').css('background-color', newval);
        }
	);

	cf_wp_customize( 
		'crowdfundly_org_card_progress_color', 
		function( newval ) {
			$('.progress__bar').css('background-color', newval);
        }
	);

	cf_wp_customize( 
		'crowdfundly_org_card_raised_amount_color', 
		function( newval ) {
			$('.campaign-card__amount strong').css('color', newval);
        }
	);

	cf_wp_customize( 
		'crowdfundly_org_card_target_amount_color', 
		function( newval ) {
			$('.campaign-card__amount').css('color', newval);
        }
	);

	cf_wp_customize(
		'cf_org_camp_button_padding', 
		function( newval ) {
			$('.organization-all-camp-btn').css('padding', newval + 'px');
        }
	);

	cf_wp_customize(
		'cf_org_all_camp_btn_border_radius_top', 
		function( newval ) {
			$('.organization-all-camp-btn').css('border-top-left-radius', newval + 'px');
        }
	);

	cf_wp_customize(
		'cf_org_all_camp_btn_border_radius_right',
		function( newval ) {
			$('.organization-all-camp-btn').css('border-top-right-radius', newval + 'px');
        }
	);

	cf_wp_customize(
		'cf_org_all_camp_btn_border_radius_bottom', 
		function( newval ) {
			$('.organization-all-camp-btn').css('border-bottom-right-radius', newval + 'px');
        }
	);

	cf_wp_customize(
		'cf_org_all_camp_btn_border_radius_left', 
		function( newval ) {
			$('.organization-all-camp-btn').css('border-bottom-left-radius', newval + 'px');
        }
	);

	cf_wp_customize(
		'crowdfundly_org_btn_bg_color', 
		function( newval ) {
			$('.organization-all-camp-btn').css('background-color', newval);
        }
	);

	cf_wp_customize(
		'crowdfundly_org_btn_color', 
		function( newval ) {
			$('.organization-all-camp-btn').css('color', newval);
        }
	);

	cf_wp_customize(
		'crowdfundly_org_btn_border_color', 
		function( newval ) {
			$('.organization-all-camp-btn').css('border-color', newval);
        }
	);

	cf_wp_customize(
		'crowdfundly_org_btn_bg_color_hover', 
		function( newval ) {
			$('.organization-all-camp-btn').hover(function() {
				$(this).css('background-color', newval);
			});
        }
	);

	cf_wp_customize(
		'crowdfundly_org_btn_color_hover', 
		function( newval ) {
			$('.organization-all-camp-btn').hover(function() {
				$(this).css('color', newval);
			});
        }
	);

	cf_wp_customize(
		'crowdfundly_org_btn_border_color_hover', 
		function( newval ) {
			$('.organization-all-camp-btn').hover(function() {
				$(this).css('border-color', newval);
			});
        }
	);


	// ********** all campaigns **********
	cf_wp_customize( 
		'crowdfundly_all_camp_page_background_color', 
		function( newval ) {
			$('.all-camps .content-body').css('background-color', newval );
        }
	);

	cf_wp_customize( 
		'cf_all_camp_title_font_size', 
		function( newval ) {
			$('.all-campaign__title').css('font-size', newval + 'px');
        }
	);

	cf_wp_customize( 
		'cf_all_camp_title', 
		function( newval ) {
			$('.all-campaign__title').html(newval);
        }
	);

	cf_wp_customize( 
		'crowdfundly_all_camp_title_color', 
		function( newval ) {
			$('.all-campaign__title').css('color', newval );
        }
	);

	cf_wp_customize( 
		'crowdfundly_all_camp_search_bar_bg_color', 
		function( newval ) {
			$('.all-campaign__filter').css('background-color', newval );
        }
	);

	cf_wp_customize( 
		'crowdfundly_all_camp_search_icon_color', 
		function( newval ) {
			$('.all-campaign__filter-search-icon').css('color', newval );
        }
	);

	cf_wp_customize( 
		'crowdfundly_all_camp_search_input_border_color', 
		function( newval ) {
			$('.all-campaign__filter-search-input').css('border-color', newval );
        }
	);
		
	cf_wp_customize( 
		'crowdfundly_all_camp_search_btn_color', 
		function( newval ) {
			$('#allCampaignSearch').css('color', newval );
        }
	);

	cf_wp_customize( 
		'crowdfundly_all_camp_search_btn_bg_color', 
		function( newval ) {
			$('#allCampaignSearch').css('background-color', newval );
        }
	);

	cf_wp_customize( 
		'crowdfundly_all_camp_search_btn_border_color', 
		function( newval ) {
			$('#allCampaignSearch').css('border-color', newval );
        }
	);

	cf_wp_customize( 
		'crowdfundly_all_camp_search_btn_color_hover', 
		function( newval ) {
			$('#allCampaignSearch').hover(function() {
				$(this).css('color', newval );
			});
        }
	);

	cf_wp_customize( 
		'crowdfundly_all_camp_search_btn_bg_color_hover', 
		function( newval ) {
			$('#allCampaignSearch').hover(function() {
				$(this).css('background-color', newval );
			});
        }
	);

	cf_wp_customize( 
		'crowdfundly_all_camp_search_btn_border_color_hover', 
		function( newval ) {
			$('#allCampaignSearch').hover(function() {
				$(this).css('border-color', newval );
			});
        }
	);

	cf_wp_customize( 
		'crowdfundly_all_camp_card_bg_color', 
		function( newval ) {
			$('.campaign-card').css('background-color', newval );
        }
	);

	cf_wp_customize( 
		'crowdfundly_all_camp_card_bg_color_hover', 
		function( newval ) {
			$('.campaign-card').hover(function() {
				$(this).css('background-color', newval );
			})
        }
	);

	cf_wp_customize( 
		'cf_all_camp_image_width', 
		function( newval ) {
			$('.campaign-card__img').css('width', newval + 'px');
        }
	);

	cf_wp_customize( 
		'crowdfundly_all_camp_name_color', 
		function( newval ) {
			$('.campaign-card__title').css('color', newval );
        }
	);

	cf_wp_customize( 
		'crowdfundly_all_camp_name_fontsize', 
		function( newval ) {
			$('.campaign-card__title').css('font-size', newval + 'px');
        }
	);
	
	cf_wp_customize( 
		'crowdfundly_all_camp_description_color', 
		function( newval ) {
			$('.campaign-card__description').css('color', newval );
        }
	);

	cf_wp_customize( 
		'crowdfundly_all_camp_description_fontsize', 
		function( newval ) {
			$('.campaign-card__description').css('font-size', newval + 'px');
        }
	);

	cf_wp_customize( 
		'crowdfundly_all_camp_progress_bg_color', 
		function( newval ) {
			$('.progress--slim').css('background-color', newval );
        }
	);

	cf_wp_customize( 
		'crowdfundly_all_camp_progress_color', 
		function( newval ) {
			$('.progress__bar--secondary').css('background-color', newval );
        }
	);

	cf_wp_customize( 
		'crowdfundly_all_camp_card_target_amount_color', 
		function( newval ) {
			$('.campaign-card__amount').css('color', newval );
        }
	);

	cf_wp_customize( 
		'crowdfundly_all_camp_raised_amount_color', 
		function( newval ) {
			$('.campaign-card__amount strong').css('color', newval );
			$('.campaign-card__amount').css('color', newval );
        }
	);

	cf_wp_customize( 
		'crowdfundly_all_camp_target_raised_amount_fontsize', 
		function( newval ) {
			$('.campaign-card__amount strong').css('font-size', newval + 'px');
			$('.campaign-card__amount').css('font-size', newval + 'px');
        }
	);

	cf_wp_customize( 
		'cf_all_campaign_load_more_bg_color', 
		function( newval ) {
			$('#crowdfundly-all-camp-loadmore').css('background-color', newval);
        }
	);

	cf_wp_customize( 
		'cf_all_campaign_load_more_bg_color_hover', 
		function( newval ) {
			$('#crowdfundly-all-camp-loadmore').hover( function() {
				$(this).css("background-color", newval)
			} );
        }
	);

	cf_wp_customize( 
		'cf_all_campaign_load_more_color', 
		function( newval ) {
			$('#crowdfundly-all-camp-loadmore').css('color', newval);
        }
	);

	cf_wp_customize( 
		'cf_all_campaign_load_more_color_hover', 
		function( newval ) {
			$('#crowdfundly-all-camp-loadmore').hover( function() {
				$(this).css("color", newval)
			} );
        }
	);

	cf_wp_customize( 
		'cf_all_campaign_load_more_border_color', 
		function( newval ) {
			$('#crowdfundly-all-camp-loadmore').css('border-color', newval);
        }
	);

	cf_wp_customize( 
		'cf_all_campaign_load_more_border_color_hover', 
		function( newval ) {
			$('#crowdfundly-all-camp-loadmore').hover( function() {
				$(this).css("border-color", newval)
			} );
        }
	);

	// ********** single campaign **********
	cf_wp_customize( 
		'crowdfundly_single_camp_gallery_img_border_color', 
		function( newval ) {
			$('.gallery-slider .slick-current.slick-active').css('background-color', newval );
			$('.campaign__view .thumbnails .slide iframe').css('background-color', newval );
			$('.campaign__view .thumbnails .slide img').css('background-color', newval );
        }
	);

	cf_wp_customize( 
		'crowdfundly_single_camp_gallery_img_bg_color', 
		function( newval ) {
			$('.campaign__view-slider .slide__inner').css('background-color', newval );
        }
	);

	cf_wp_customize( 
		'crowdfundly_single_camp_gallery_arrow_color',
		function( newval ) {
			$('.gallery-slider-nav .slick-prev:before').css('color', newval );
			$('.gallery-slider-nav .slick-next:before').css('color', newval );
        }
	);

	cf_wp_customize( 
		'crowdfundly_single_camp_name_color', 
		function( newval ) {
			$('.campaign__title.campaign__title--status').css('color', newval );
        }
	);

	cf_wp_customize( 
		'cf_single_camp_name_fontsize', 
		function( newval ) {
			$('.campaign__title.campaign__title--status').css('font-size', newval + 'px');
        }
	);

	cf_wp_customize( 
		'cf_single_camp_name_text_transform', 
		function( newval ) {
			$('.campaign__title.campaign__title--status').css('text-transform', newval);
        }
	);

	cf_wp_customize( 
		'crowdfundly_single_camp_status_color', 
		function( newval ) {
			$('.campaign__status-title').css('color', newval );
        }
	);

	cf_wp_customize( 
		'crowdfundly_single_camp_org_name_color', 
		function( newval ) {
			$('.campaign__fundraiser-name-link').css('color', newval );
        }
	);

	cf_wp_customize( 
		'crowdfundly_single_camp_org_name_by_color', 
		function( newval ) {
			$('.campaign__fundraiser-name').css('color', newval );
        }
	);

	cf_wp_customize( 
		'crowdfundly_single_camp_funding_goal_box_bg_color', 
		function( newval ) {
			$('.funding-goal').css('background-color', newval );
        }
	);

	cf_wp_customize( 
		'crowdfundly_single_camp_funding_goal_box_color', 
		function( newval ) {
			$('.funding-goal .funding-card__value').css('color', newval );
			$('.funding-goal .funding-card__lavel').css('color', newval );
        }
	);

	cf_wp_customize( 
		'crowdfundly_single_camp_funding_raised_bg_color', 
		function( newval ) {
			$('.fund-raised').css('background-color', newval );
        }
	);

	cf_wp_customize( 
		'crowdfundly_single_camp_funding_raised_color', 
		function( newval ) {
			$('.fund-raised .funding-card__value').css('color', newval );
			$('.fund-raised .funding-card__lavel').css('color', newval );
        }
	);

	cf_wp_customize( 
		'crowdfundly_single_camp_funding_duration_bg_color', 
		function( newval ) {
			$('.funding-duration').css('background-color', newval );
        }
	);

	cf_wp_customize( 
		'crowdfundly_single_camp_funding_duration_color', 
		function( newval ) {
			$('.funding-duration .funding-card__value').css('color', newval );
			$('.funding-duration .funding-card__lavel').css('color', newval );
        }
	);

	cf_wp_customize( 
		'crowdfundly_single_camp_progress_bar_bg_color', 
		function( newval ) {
			$('.progress.progress--sm').css('background-color', newval );
        }
	);

	cf_wp_customize( 
		'crowdfundly_single_camp_progress_bar_color', 
		function( newval ) {
			$('.progress__bar.progress__bar--secondary').css('background-color', newval );
        }
	);

	cf_wp_customize( 
		'crowdfundly_single_camp_contribute_btn_bg_color', 
		function( newval ) {
			$('.campaign__actions-btn').css('background-color', newval );
        }
	);
	cf_wp_customize( 
		'crowdfundly_single_camp_contribute_btn_color', 
		function( newval ) {
			$('.campaign__actions-btn').css('color', newval );
        }
	);
	cf_wp_customize( 
		'crowdfundly_single_camp_contribute_btn_border_color', 
		function( newval ) {
			$('.campaign__actions-btn').css('border-color', newval );
        }
	);

	cf_wp_customize(
		'crowdfundly_single_camp_contribute_btn_hover_bg_color', 
		function( newval ) {
			$('.campaign__actions-btn').hover( function() {
				$(this).css("background-color", newval)
			} );
        }
	);
	cf_wp_customize( 
		'crowdfundly_single_camp_contribute_btn_hover_color', 
		function( newval ) {
			$('.campaign__actions-btn').hover( function() {
				$(this).css("color", newval)
			} );
        }
	);
	cf_wp_customize( 
		'crowdfundly_single_camp_contribute_btn_hover_border_color', 
		function( newval ) {
			$('.campaign__actions-btn').hover( function() {
				$(this).css("border-color", newval)
			} );
        }
	);

	cf_wp_customize( 
		'cf_single_campn_donation_btn_texts', 
		function( newval ) {
			$('.campaign__actions-btn').html(newval);
        }
	);

	cf_wp_customize( 
		'cf_single_campn_donation_btn_text_transform', 
		function( newval ) {
			$('.campaign__actions-btn').css('text-transform', newval);
        }
	);

	cf_wp_customize(
		'cf_single_camp_donation_popup_bg_color', 
		function( newval ) {
			$('.back-modal.show-modal').css("background-color", newval);
			$('#crowdfundly-donation-modal').css("background-color", newval);
			$('.donate__inner').css("background-color", newval);
        }
	);

	cf_wp_customize(
		'cf_single_camp_donation_popup_presets_bg_color', 
		function( newval ) {
			$('.donate__amount-inner').css("background-color", newval);
			$('.donate__amount-inner').css("border-color", newval);
        }
	);

	cf_wp_customize(
		'cf_single_camp_donation_popup_presets_bg_color_hover', 
		function( newval ) {
			$('.donate__amount-inner').hover(function() {
				$(this).css("background-color", newval);
				$(this).css("border-color", newval);
			});
        }
	);

	cf_wp_customize(
		'cf_single_camp_donation_popup_presets_color', 
		function( newval ) {
			$('.donate__amount-value').css("color", newval);
        }
	);

	cf_wp_customize(
		'cf_single_camp_donation_popup_input_bg_color', 
		function( newval ) {
			$('.donate__custom-amount').css("background-color", newval);
        }
	);

	cf_wp_customize(
		'cf_single_camp_donation_popup_input_border_color', 
		function( newval ) {
			$('.donate__custom-amount.focus').css("border-color", newval);
			$('.donate__custom-amount.focus-within').css("border-color", newval);
        }
	);

	cf_wp_customize(
		'cf_single_camp_donation_popup_active_btn_bg_color', 
		function( newval ) {
			$('#crowdfundly-donate-btn').css("background-color", newval);
			$('#reward-contribution-btn').css("background-color", newval);
        }
	);

	cf_wp_customize(
		'cf_single_camp_donation_popup_active_btn_color', 
		function( newval ) {
			$('#crowdfundly-donate-btn').css("color", newval);
			$('#reward-contribution-btn').css("color", newval);
        }
	);

	cf_wp_customize(
		'cf_single_camp_donation_popup_active_btn_border_color', 
		function( newval ) {
			$('#crowdfundly-donate-btn').css("border-color", newval);
			$('#reward-contribution-btn').css("border-color", newval);
        }
	);

	cf_wp_customize(
		'cf_single_camp_donation_popup_active_btn_fontsize', 
		function( newval ) {
			$('#crowdfundly-donate-btn').css("font-size", newval + 'px');
			$('#reward-contribution-btn').css("font-size", newval + 'px');
        }
	);

	cf_wp_customize( 
		'cf_single_camp_tabs_bg_color', 
		function( newval ) {
			$('.campaign__view-tab .g-tab').css("background-color", newval);
        }
	);

	cf_wp_customize( 
		'cf_single_camp_tabs_nav_color', 
		function( newval ) {
			$('#campaignTab .nav-link').css("color", newval);
			$('#campaignTab .nav-link span').css("color", newval);
        }
	);

	cf_wp_customize( 
		'cf_single_camp_tabs_active_tab_nav_bg_color', 
		function( newval ) {
			$('#campaignTab .nav-link.active').css("background-color", newval);
        }
	);

	cf_wp_customize(
		'cf_single_camp_tabs_active_tab_nav_color', 
		function( newval ) {
			$('#campaignTab .nav-link.active').css("color", newval);
        }
	);

	cf_wp_customize(
		'cf_single_camp_tabs_active_tab_nav_border_color', 
		function( newval ) {
			$('#campaignTab .nav-link.active').css("border-color", newval);
        }
	);

	cf_wp_customize(
		'cf_single_camp_tabs_content_background_color', 
		function( newval ) {
			$('.tab-content.g-tab__body').css("background-color", newval);
        }
	);

	cf_wp_customize(
		'cf_single_camp_tabs_content_card_bg_color', 
		function( newval ) {
			$('.offer-card').css("background-color", newval);
			$('.tab-pane .activity').css("background-color", newval);
			$('.tab-pane .endorsement').css("background-color", newval);
			$('.tab-pane .donor-card').css("background-color", newval);
        }
	);

	cf_wp_customize(
		'cf_single_camp_tabs_activity_tab_btn_bg_color', 
		function( newval ) {
			$('#crowdfundly-activites-load-more').css("background-color", newval);
        }
	);

	cf_wp_customize(
		'cf_single_camp_tabs_activity_tab_btn_color', 
		function( newval ) {
			$('#crowdfundly-activites-load-more').css("color", newval);
        }
	);

	cf_wp_customize(
		'cf_single_camp_tabs_activity_tab_btn_border_color', 
		function( newval ) {
			$('#crowdfundly-activites-load-more').css("border-color", newval);
        }
	);
	
	cf_wp_customize( 
		'cf_single_camp_similar_campaign_heading', 
		function( newval ) {
			$('.campaign__view-related-title').html(newval);
        }
	);

	cf_wp_customize(
		'cf_single_camp_similar_camp_heading_color', 
		function( newval ) {
			$('.campaign__view-related-title').css("color", newval);
        }
	);

	cf_wp_customize( 
		'cf_single_camp_heading_fontsize', 
		function( newval ) {
			$('.campaign__view-related-title').css('font-size', newval + 'px');
        }
	);

	cf_wp_customize( 
		'cf_similar_camp_heading_text_transform', 
		function( newval ) {
			$('.campaign__view-related-title').css('text-transform', newval);
        }
	);

	cf_wp_customize(
		'cf_single_camp_similar_camp_card_bg_color', 
		function( newval ) {
			$('.crowdfundly-single-camp .campaign-card').css("background-color", newval);
        }
	);

	cf_wp_customize(
		'cf_single_camp_similar_camp_card_bg_color_hover', 
		function( newval ) {
			$('.crowdfundly-single-camp .campaign-card').hover(function() {
				$(this).css("background-color", newval);
			});
        }
	);

	cf_wp_customize(
		'cf_single_camp_similar_camp_card_image_bg_color', 
		function( newval ) {
			$('.crowdfundly-single-camp .campaign-card__top').css("background-color", newval);
        }
	);

	cf_wp_customize(
		'cf_single_camp_similar_camp_card_title_color', 
		function( newval ) {
			$('.crowdfundly-single-camp .campaign-card__title').css("color", newval);
        }
	);

	cf_wp_customize(
		'cf_single_camp_similar_camp_card_description_color', 
		function( newval ) {
			$('.crowdfundly-single-camp .campaign-card__description').css("color", newval);
        }
	);

	cf_wp_customize(
		'cf_single_camp_similar_camp_card_progress_bar_bg_color', 
		function( newval ) {
			$('.crowdfundly-single-camp .progress--slim').css("background-color", newval);
        }
	);

	cf_wp_customize(
		'cf_single_camp_similar_camp_card_progress_color', 
		function( newval ) {
			$('.crowdfundly-single-camp .progress__bar--secondary').css("background-color", newval);
        }
	);

	cf_wp_customize(
		'cf_single_camp_similar_camp_card_target_amount_color', 
		function( newval ) {
			$('.crowdfundly-single-camp .campaign-card__amount').css("color", newval);
        }
	);

	cf_wp_customize(
		'cf_single_camp_similar_camp_card_raised_amount_color', 
		function( newval ) {
			$('.crowdfundly-single-camp .campaign-card__amount strong').css("color", newval);
        }
	);

} )( jQuery );
