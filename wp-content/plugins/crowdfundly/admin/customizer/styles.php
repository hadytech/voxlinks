<?php 

function crowdfundly_customizer_editor_styles() { ?>
	<style type="text/css">
		/* === dimention control === */
		.customize-control.customize-control-crowdfundly-dimension,
		.customize-control-crowdfundly-select {
			width: 25%;
			float: left !important;
			clear: none !important;
			margin-top: 0;
			margin-bottom: 12px;
		}
		/* === Heading control === */
		.crowdfundly-general-heading h4 {
			margin-bottom: 0;
		}
		.crowdfundly-heading h4 {
			font-size: 20px;
			font-weight: 500;
			margin-top: 35px;
			margin-bottom: 0; 
			padding: 10px; 
			background-color: #15c7a40d;
			border-top: 2px solid #016b5638;
		}
		/* === Select control === */
		.customize-control-crowdfundly-select {
			width: 100%;
		}
		/* === Number control === */
		.customize-control-crowdfundly-number input.crowdfundly-number {
			width: 50%;
		}
	</style>
	<?php 
}
add_action( 'customize_controls_print_styles', 'crowdfundly_customizer_editor_styles', 999 );


function cf_customizer_style() {
	?>
	<style type="text/css">
		/* === organization === */
		.crowdfundy-org .content-body {
			background-color: <?php echo get_theme_mod( 'crowdfundly_organization_background_color', '' ); ?>;
		}

		.crowdfundy-org .organization__details {
			background-color: <?php echo get_theme_mod( 'crowdfundly_org_section_bg_color', '' ); ?>;
		}

		.organization__info .organization__info-name {
			color: <?php echo get_theme_mod( 'crowdfundly_org_name_color', '' ); ?>;
		}

		.organization__info .organization__info-address {
			color: <?php echo get_theme_mod( 'crowdfundly_org_info_color', '' ); ?>;
		}

		.organization__social .organization__social-title {
			color: <?php echo get_theme_mod( 'crowdfundly_organization_social_media_heading_color', '' ); ?>;
		}
		
		.organization__social-item .organization__social-item-title {
			color: <?php echo get_theme_mod( 'crowdfundly_organization_social_media_name_color', '' ); ?>;
		}

		.organization__social-item .organization__social-item-subtitle {
			color: <?php echo get_theme_mod( 'crowdfundly_organization_social_media_link_color', '' ); ?>;
		}

		.template h4.organization__details-title {
			color: <?php echo get_theme_mod( 'crowdfundly_organization_title_color', '' ); ?>;
			font-size: <?php echo get_theme_mod( 'cf_organization_title_fontsize', '20px' ); ?>px;
			text-transform: <?php echo get_theme_mod( 'cf_organization_title_text_transform', '' ); ?>;
		}

		.organization__details-description p > span {
			color: <?php echo get_theme_mod( 'crowdfundly_organization_desciption_color', '' ); ?> !important;
		}

		.organization__slider .slick-track .slick-slide img {
			height: <?php echo get_theme_mod( 'cf_org_slider_height', '' ); ?>px;
		}

		.organization__info-logo,
		.organization__info-logo .organization__info-logo-img {
			width: <?php echo get_theme_mod( 'cf_org_logo_width', '' ); ?>px;
			height: <?php echo get_theme_mod( 'cf_org_logo_height', '' ); ?>px;
		}

		.template .organization__social-item-icon {
			font-size: <?php echo get_theme_mod( 'cf_org_social_media_icon_size', '' ); ?>px;
		}

		.organization__campaigns .organization__campaigns-title {
			font-size: <?php echo get_theme_mod( 'cf_org_heading_font_size', '' ); ?>px;
			color: <?php echo get_theme_mod( 'crowdfundly_organization_heading_color', '' ); ?>;
			text-transform: <?php echo get_theme_mod( 'cf_org_recent_camp_heading_text_transform', '' ); ?>;
		}

		.organization__campaigns .campaign-card {
			background-color: <?php echo get_theme_mod( 'crowdfundly_org_card_bg_color', '' ); ?>;
		}

		.organization__campaigns .campaign-card:hover {
			background-color: <?php echo get_theme_mod( 'crowdfundly_org_card_bg_color_hover', '' ); ?>;
		}

		.organization__campaigns .campaign-card__top {
			background-color: <?php echo get_theme_mod( 'crowdfundly_org_card_image_bg_color', '' ); ?>;
		}

		.organization__campaigns .campaign-card__title {
			color: <?php echo get_theme_mod( 'crowdfundly_org_card_name_color', '' ); ?>;
			font-size: <?php echo get_theme_mod( 'crowdfundly_org_card_name_fontsize', '' ); ?>px;
		}

		.organization__campaigns .campaign-card__description {
			color: <?php echo get_theme_mod( 'crowdfundly_org_card_description_color', '' ); ?>;
			font-size: <?php echo get_theme_mod( 'crowdfundly_org_card_description_fontsize', '' ); ?>px;			
		}

		.organization__campaigns .progress--slim {
			background-color: <?php echo get_theme_mod( 'crowdfundly_org_card_progress_bg_color', '' ); ?>;
		}

		.organization__campaigns .progress__bar {
			background-color: <?php echo get_theme_mod( 'crowdfundly_org_card_progress_color', '' ); ?>;
		}

		.organization__campaigns .campaign-card__amount {
			color: <?php echo get_theme_mod( 'crowdfundly_org_card_target_amount_color', '' ); ?>;
			font-size: <?php echo get_theme_mod( 'crowdfundly_org_card_target_amount_fontsize', '' ); ?>px;			
		}
		.organization__campaigns .campaign-card__amount strong {
			color: <?php echo get_theme_mod( 'crowdfundly_org_card_raised_amount_color', '' ); ?>;
			font-size: <?php echo get_theme_mod( 'crowdfundly_org_card_raised_amount_fontsize', '' ); ?>px;			
		}

		.organization-all-camp-btn {
			background-color: <?php echo get_theme_mod( 'crowdfundly_org_btn_bg_color', '' ); ?>;
			color: <?php echo get_theme_mod( 'crowdfundly_org_btn_color', '' ); ?>;
			border-color: <?php echo get_theme_mod( 'crowdfundly_org_btn_border_color', '' ); ?>;
			border-top-left-radius: <?php echo get_theme_mod( 'cf_org_all_camp_btn_border_radius_top', '' ); ?>px;
			border-top-right-radius: <?php echo get_theme_mod( 'cf_org_all_camp_btn_border_radius_right', '' ); ?>px;
			border-bottom-right-radius: <?php echo get_theme_mod( 'cf_org_all_camp_btn_border_radius_bottom', '' ); ?>px;
			border-bottom-left-radius: <?php echo get_theme_mod( 'cf_org_all_camp_btn_border_radius_left', '' ); ?>px;
			padding: <?php echo get_theme_mod( 'cf_org_camp_button_padding', '' ); ?>px;
		}

		.organization-all-camp-btn:hover {
			background-color: <?php echo get_theme_mod( 'crowdfundly_org_btn_bg_color_hover', '' ); ?>;
			color: <?php echo get_theme_mod( 'crowdfundly_org_btn_color_hover', '' ); ?>;
			border-color: <?php echo get_theme_mod( 'crowdfundly_org_btn_border_color_hover', '' ); ?>;
		}

		/* === all campaigns === */
		.all-camps .content-body {
			background-color: <?php echo get_theme_mod( 'crowdfundly_all_camp_page_background_color', '' ); ?>;
		}

		.all-campaign__filter-search-icon {
			color: <?php echo get_theme_mod( 'crowdfundly_all_camp_search_icon_color', '' ); ?>;
		}

		.all-campaign__filter-search .all-campaign__filter-search-input {
			border-color: <?php echo get_theme_mod( 'crowdfundly_all_camp_search_input_border_color', '' ); ?>;
		}

		.all-campaign__filter-search .all-campaign__filter-search-input::-webkit-input-placeholder {
			color: <?php echo get_theme_mod( 'crowdfundly_all_camp_search_input_placeholder_color', '' ); ?>;
		}
		.all-campaign__filter-search .all-campaign__filter-search-input::-moz-placeholder {
			color: <?php echo get_theme_mod( 'crowdfundly_all_camp_search_input_placeholder_color', '' ); ?>;
		}
		.all-campaign__filter-search .all-campaign__filter-search-input::-ms-input-placeholder {
			color: <?php echo get_theme_mod( 'crowdfundly_all_camp_search_input_placeholder_color', '' ); ?>;
		}

		.all-campaign .all-campaign__title {
			font-size: <?php echo get_theme_mod( 'cf_all_camp_title_font_size', '' ); ?>px;
			color: <?php echo get_theme_mod( 'crowdfundly_all_camp_title_color', '' ); ?>;
		}

		.organization__details-description p {
			font-size: <?php echo get_theme_mod( 'cf_organization_description_fontsize', '' ); ?>px;
		}

		.all-campaign__filter {
			background-color: <?php echo get_theme_mod( 'crowdfundly_all_camp_search_bar_bg_color', '' ); ?>;
		}

		#allCampaignSearch {
			color: <?php echo get_theme_mod( 'crowdfundly_all_camp_search_btn_color', '' ); ?>;
			background-color: <?php echo get_theme_mod( 'crowdfundly_all_camp_search_btn_bg_color', '' ); ?>;
			border-color: <?php echo get_theme_mod( 'crowdfundly_all_camp_search_btn_border_color', '' ); ?>;
			font-size: <?php echo get_theme_mod( 'crowdfundly_all_camp_search_btn_fontsize', '' ); ?>px;
			
		}

		#allCampaignSearch:hover {
			color: <?php echo get_theme_mod( 'crowdfundly_all_camp_search_btn_color_hover', '' ); ?>;
			background-color: <?php echo get_theme_mod( 'crowdfundly_all_camp_search_btn_bg_color_hover', '' ); ?>;
			border-color: <?php echo get_theme_mod( 'crowdfundly_all_camp_search_btn_border_color_hover', '' ); ?>;
		}

		.all-campaign .campaign-card {
			background-color: <?php echo get_theme_mod( 'crowdfundly_all_camp_card_bg_color', '' ); ?>;
		}

		.all-campaign .campaign-card:hover {
			background-color: <?php echo get_theme_mod( 'crowdfundly_all_camp_card_bg_color_hover', '' ); ?>;
		}

		.all-campaign .campaign-card__img {
			width: <?php echo get_theme_mod( 'cf_all_camp_image_width', '' ); ?>px;
		}

		.all-campaign .campaign-card__title {
			color: <?php echo get_theme_mod( 'crowdfundly_all_camp_name_color', '' ); ?>;
			font-size: <?php echo get_theme_mod( 'crowdfundly_all_camp_name_fontsize', '' ); ?>px;
		}

		.all-campaign .campaign-card__description {
			color: <?php echo get_theme_mod( 'crowdfundly_all_camp_description_color', '' ); ?>;
			font-size: <?php echo get_theme_mod( 'crowdfundly_all_camp_description_fontsize', '' ); ?>px;			
		}

		.all-campaign .progress--slim {
			background-color: <?php echo get_theme_mod( 'crowdfundly_all_camp_progress_bg_color', '' ); ?>;
		}

		.all-campaign .progress__bar--secondary {
			background-color: <?php echo get_theme_mod( 'crowdfundly_all_camp_progress_color', '' ); ?>;
		}

		.all-campaign .campaign-card__amount {
			color: <?php echo get_theme_mod( 'crowdfundly_all_camp_card_target_amount_color', '' ); ?>;
			font-size: <?php echo get_theme_mod( 'crowdfundly_all_camp_target_raised_amount_fontsize', '' ); ?>px;						
		}
		.all-campaign .campaign-card__amount strong {
			color: <?php echo get_theme_mod( 'crowdfundly_all_camp_raised_amount_color', '' ); ?>;
			font-size: <?php echo get_theme_mod( 'crowdfundly_all_camp_target_raised_amount_fontsize', '' ); ?>px;
		}

		#crowdfundly-all-camp-loadmore {
			background-color: <?php echo get_theme_mod( 'cf_all_campaign_load_more_bg_color', '' ); ?>;
			color: <?php echo get_theme_mod( 'cf_all_campaign_load_more_color', '' ); ?>;
			border-color: <?php echo get_theme_mod( 'cf_all_campaign_load_more_border_color', '' ); ?>;
		}
		#crowdfundly-all-camp-loadmore:hover {
			background-color: <?php echo get_theme_mod( 'cf_all_campaign_load_more_bg_color_hover', '' ); ?>;
			color: <?php echo get_theme_mod( 'cf_all_campaign_load_more_color_hover', '' ); ?>;
			border-color: <?php echo get_theme_mod( 'cf_all_campaign_load_more_border_color_hover', '' ); ?>;
		}

		/* === single campaign === */
		.crowdfundly-single-camp .content-body {
			background-color: <?php echo get_theme_mod( 'crowdfundly_single_camp_page_background_color', '' ); ?>;
		}

		.gallery-slider .slick-current.slick-active,
		.campaign__view .thumbnails .slide iframe,
		.campaign__view .thumbnails .slide img {
			background-color: <?php echo get_theme_mod( 'crowdfundly_single_camp_gallery_img_border_color', '' ); ?>;
		}

		.campaign__view-slider .slick-active .slide__inner {
			background-color: <?php echo get_theme_mod( 'crowdfundly_single_camp_gallery_img_bg_color', '' ); ?>;
		}

		.gallery-slider-nav .slick-prev:before,
		.gallery-slider-nav .slick-next:before {
			color: <?php echo get_theme_mod( 'crowdfundly_single_camp_gallery_arrow_color', '' ); ?>;
		}

		.campaign__title.campaign__title--status {
			color: <?php echo get_theme_mod( 'crowdfundly_single_camp_name_color', '' ); ?>;
			font-size: <?php echo get_theme_mod( 'cf_single_camp_name_fontsize', '' ); ?>px;
			text-transform: <?php echo get_theme_mod( 'cf_single_camp_name_text_transform', '' ); ?>;
		}

		.campaign__status-title {
			color: <?php echo get_theme_mod( 'crowdfundly_single_camp_status_color', '' ); ?>;
		}

		.campaign__fundraiser-name-link {
			color: <?php echo get_theme_mod( 'crowdfundly_single_camp_org_name_color', '' ); ?>;
			font-size: <?php echo get_theme_mod( 'crowdfundly_single_camp_org_name_fontsize', '' ); ?>px;			
		}

		.cacampaign__fundraiser-name {
			color: <?php echo get_theme_mod( 'crowdfundly_single_camp_org_name_by_color', '' ); ?>;
		}

		.campaign__funding .funding-goal {
			background-color: <?php echo get_theme_mod( 'crowdfundly_single_camp_funding_goal_box_bg_color', '' ); ?>;
		}

		.funding-goal .funding-card__value,
		.funding-goal .funding-card__lavel {
			color: <?php echo get_theme_mod( 'crowdfundly_single_camp_funding_goal_box_color', '' ); ?>;
		}

		.campaign__funding .fund-raised {
			background-color: <?php echo get_theme_mod( 'crowdfundly_single_camp_funding_raised_bg_color', '' ); ?>;
		}

		.fund-raised .funding-card__value,
		.fund-raised .funding-card__lavel {
			color: <?php echo get_theme_mod( 'crowdfundly_single_camp_funding_raised_color', '' ); ?>;
		}

		.campaign__funding .funding-duration {
			background-color: <?php echo get_theme_mod( 'crowdfundly_single_camp_funding_duration_bg_color', '' ); ?>;
		}

		.funding-duration .funding-card__value,
		.funding-duration .funding-card__lavel {
			color: <?php echo get_theme_mod( 'crowdfundly_single_camp_funding_duration_color', '' ); ?>;
		}

		.campaign__details .progress.progress--sm {
			background-color: <?php echo get_theme_mod( 'crowdfundly_single_camp_progress_bar_bg_color', '' ); ?>;
		}
		.campaign__details .progress__bar.progress__bar--secondary {
			background-color: <?php echo get_theme_mod( 'crowdfundly_single_camp_progress_bar_color', '' ); ?>;
		}

		.campaign__actions-btn {
			background-color: <?php echo get_theme_mod( 'crowdfundly_single_camp_contribute_btn_bg_color', '' ); ?>;
			color: <?php echo get_theme_mod( 'crowdfundly_single_camp_contribute_btn_color', '' ); ?>;
			border-color: <?php echo get_theme_mod( 'crowdfundly_single_camp_contribute_btn_border_color', '' ); ?>;
			text-transform: <?php echo get_theme_mod( 'cf_single_campn_donation_btn_text_transform', '' ); ?>;
			font-size: <?php echo get_theme_mod( 'cf_single_campn_donation_btn_text_fontsize', '' ); ?>px;
		}
		.campaign__actions-btn:hover {
			background-color: <?php echo get_theme_mod( 'crowdfundly_single_camp_contribute_btn_hover_bg_color', '' ); ?>;
			color: <?php echo get_theme_mod( 'crowdfundly_single_camp_contribute_btn_hover_color', '' ); ?>;
			border-color: <?php echo get_theme_mod( 'crowdfundly_single_camp_contribute_btn_hover_border_color', '' ); ?>;
		}

		.back-modal.show-modal,
		#crowdfundly-donation-modal,
		.donate__inner {
			background-color: <?php echo get_theme_mod( 'cf_single_camp_donation_popup_bg_color', '' ); ?>;
		}

		.donate__amount-inner {
			background-color: <?php echo get_theme_mod( 'cf_single_camp_donation_popup_presets_bg_color', '' ); ?>;
			color: <?php echo get_theme_mod( 'donate__amount-value', '' ); ?>;
		}

		.donate__amount-inner:hover {
			background-color: <?php echo get_theme_mod( 'cf_single_camp_donation_popup_presets_bg_color_hover', '' ); ?>;
			border-color: <?php echo get_theme_mod( 'cf_single_camp_donation_popup_presets_bg_color_hover', '' ); ?>;
		}

		.form-group__amount,
		.donate__custom-amount {
			background-color: <?php echo get_theme_mod( 'cf_single_camp_donation_popup_input_bg_color', '' ); ?>;
		}
		.form-group__amount:focus,
		.form-group__amount:focus-within,
		.donate__custom-amount.focus,
		.donate__custom-amount:focus-within {
			background-color: <?php echo get_theme_mod( 'cf_single_camp_donation_popup_input_bg_color', '' ); ?>;
			border-color: <?php echo get_theme_mod( 'cf_single_camp_donation_popup_input_border_color', '' ); ?>;
		}

		#reward-contribution-btn,
		#crowdfundly-donate-btn {
			background-color: <?php echo get_theme_mod( 'cf_single_camp_donation_popup_active_btn_bg_color', '' ); ?>;
			color: <?php echo get_theme_mod( 'cf_single_camp_donation_popup_active_btn_color', '' ); ?>;
			border-color: <?php echo get_theme_mod( 'cf_single_camp_donation_popup_active_btn_border_color', '' ); ?>;			
			font-size: <?php echo get_theme_mod( 'cf_single_camp_donation_popup_active_btn_fontsize', '' ); ?>px;
		}
		
		.campaign__view-tab .g-tab {
			background-color: <?php echo get_theme_mod( 'cf_single_camp_tabs_bg_color', '' ); ?>;
		}

		#campaignTab .nav-link,
		#campaignTab .nav-link span {
			color: <?php echo get_theme_mod( 'cf_single_camp_tabs_nav_color', '' ); ?>;
			font-size: <?php echo get_theme_mod( 'cf_single_camp_tabs_nav_fontsize', '' ); ?>px;
		}

		#campaignTab .nav-link.active {
			color: <?php echo get_theme_mod( 'cf_single_camp_tabs_active_tab_nav_color', '' ); ?>;
			border-color: <?php echo get_theme_mod( 'cf_single_camp_tabs_active_tab_nav_border_color', '' ); ?>;
		}
		#campaignTab .g-tab__nav-item:not(.active) .nav-link.active {
			background-color: <?php echo get_theme_mod( 'cf_single_camp_tabs_active_tab_nav_bg_color', '' ); ?>;
		}

		.tab-content.g-tab__body {
			background-color: <?php echo get_theme_mod( 'cf_single_camp_tabs_content_background_color', '' ); ?>;
		}

		.offer-card,
		.tab-pane .activity,
		.tab-pane .endorsement,
		.tab-pane .donor-card {
			background-color: <?php echo get_theme_mod( 'cf_single_camp_tabs_content_card_bg_color', '' ); ?>;
		}

		#crowdfundly-activites-load-more {
			background-color: <?php echo get_theme_mod( 'cf_single_camp_tabs_activity_tab_btn_bg_color', '' ); ?>;
			color: <?php echo get_theme_mod( 'cf_single_camp_tabs_activity_tab_btn_color', '' ); ?>;
			border-color: <?php echo get_theme_mod( 'cf_single_camp_tabs_activity_tab_btn_border_color', '' ); ?>;
			font-size: <?php echo get_theme_mod( 'cf_single_camp_tabs_activity_tab_btn_fontsize', '' ); ?>px;
		}

		.campaign__view-related-title {
			color: <?php echo get_theme_mod( 'cf_single_camp_similar_camp_heading_color', '' ); ?>;
			font-size: <?php echo get_theme_mod( 'cf_single_camp_heading_fontsize', '' ); ?>px;
		}

		.crowdfundly-single-camp .campaign-card {
			background-color: <?php echo get_theme_mod( 'cf_single_camp_similar_camp_card_bg_color', '' ); ?>;
		}
		.crowdfundly-single-camp .campaign-card:hover {
			background-color: <?php echo get_theme_mod( 'cf_single_camp_similar_camp_card_bg_color_hover', '' ); ?>;
		}

		.crowdfundly-single-camp .campaign-card__top {
			background-color: <?php echo get_theme_mod( 'cf_single_camp_similar_camp_card_image_bg_color', '' ); ?>;
		}

		.crowdfundly-single-camp .campaign-card__title {
			color: <?php echo get_theme_mod( 'cf_single_camp_similar_camp_card_title_color', '' ); ?>;
			font-size: <?php echo get_theme_mod( 'cf_single_camp_similar_camp_card_title_fontsize', '' ); ?>px;
		}

		.crowdfundly-single-camp .campaign-card__description {
			color: <?php echo get_theme_mod( 'cf_single_camp_similar_camp_card_description_color', '' ); ?>;
			font-size: <?php echo get_theme_mod( 'cf_single_camp_similar_camp_card_description_fontsize', '' ); ?>px;
		}

		.crowdfundly-single-camp .progress--slim {
			background-color: <?php echo get_theme_mod( 'cf_single_camp_similar_camp_card_progress_bar_bg_color', '' ); ?>;
		}

		.crowdfundly-single-camp .progress__bar--secondary {
			background-color: <?php echo get_theme_mod( 'cf_single_camp_similar_camp_card_progress_color', '' ); ?>;
		}

		.crowdfundly-single-camp .campaign-card__amount {
			color: <?php echo get_theme_mod( 'cf_single_camp_similar_camp_card_target_amount_color', '' ); ?>;
			font-size: <?php echo get_theme_mod( 'cf_single_camp_similar_camp_card_target_amount_fontsize', '' ); ?>px;
		}
		.crowdfundly-single-camp .campaign-card__amount strong {
			color: <?php echo get_theme_mod( 'cf_single_camp_similar_camp_card_raised_amount_color', '' ); ?>;
			font-size: <?php echo get_theme_mod( 'cf_single_camp_similar_camp_card_raised_amount_fontsize', '' ); ?>px;
		}
	</style>
	<?php 
}
add_action( 'wp_head', 'cf_customizer_style' );
