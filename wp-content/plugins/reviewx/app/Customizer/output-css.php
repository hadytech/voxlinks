<?php
/**
 * reviewx Theme Customizer outout for layout settings
 *
 * @package reviewx
 */

/**
 * This function adds some styles to the WordPress Customizer
 */
function reviewx_customizer_styles() { 
	?>
	<style type="text/css">
		.customize-control-reviewx-title .reviewx-select,
		.customize-control-reviewx-title .reviewx-dimension{
			display: flex;
		}
		.customize-control-reviewx-range-value { 
			display: flex;
		}
		.customize-control-reviewx-range-value .customize-control-title,
		.customize-control-reviewx-number .customize-control-title {
			float: left;
		}
		.reviewx-customize-control-separator {
			display: block;
			margin: 0 -12px;
			border: 1px solid #ddd;
			border-left: 0;
			border-right: 0;
			padding: 15px;
			font-size: 11px;
			font-weight: 600;
			letter-spacing: 2px;
			line-height: 1;
			text-transform: uppercase;
			color: #555;
			background-color: #fff;
		}
		.customize-control.customize-control-reviewx-dimension,
		.customize-control-reviewx-select {
			width: 100%;
			float: left !important;
			clear: none !important;
			margin-top: 0;
			margin-bottom: 12px;
		}
		.customize-control.customize-control-reviewx-dimension .customize-control-title,
		.customize-control-reviewx-select .customize-control-title{
			font-size: 11px;
			font-weight: normal;
			color: #888b8c;
			margin-top: 0;
		}
		.reviewx-customizer-reset {
			font-size: 22px;
    		line-height: 26px;
    		margin-left: 5px;
			transition: unset;
		}
		.reviewx-customizer-reset svg {
			width: 16px;
			fill: #FE1F4A;
		}
		.customize-control-title .customize-control-title {
			margin-bottom: 0;
		}
	</style>
	<?php

}
add_action( 'customize_controls_print_styles', 'reviewx_customizer_styles', 999 );

function reviewx_customize_css() {
	$output = reviewx_generate_output();
	$template = get_option( '_rx_option_template_style' );

    ?>
	<style type="text/css">
		.woocommerce-Reviews-title{
			color: <?php echo $output['reviewx_section_title_color']; ?>;
			font-size: <?php echo $output['reviewx_section_title_font_size']; ?>px;			
		}
		.rx-temp-rating .rx-temp-rating-number p {
			color: <?php echo $output['reviewx_average_count_color']; ?>;
			font-size: <?php echo $output['reviewx_average_count_font_size']; ?>px !important;
		}

		.rx-temp-rating .rx-temp-rating-number span{
			color: <?php echo $output['reviewx_heighest_rating_point_color']; ?> !important;
			font-size: <?php echo $output['reviewx_heighest_rating_point_font_size']; ?>px !important;
		}

		.rx_avg_star_color{
			fill: <?php echo $output['reviewx_star_rating_color']; ?> !important;			
		}		
		.rx-temp-rating-star svg{
			width: <?php echo $output['reviewx_star_rating_size']; ?>px !important;
			height: <?php echo $output['reviewx_star_rating_size']; ?>px !important;
		}

		.rx-temp-total-rating-count p{
			color: <?php echo $output['reviewx_average_text_color']; ?> !important;
			font-size: <?php echo $output['reviewx_average_text_font_size']; ?>px !important;		
		}

		.rx_recommended_box .rx_recommended_box_heading{
			color: <?php echo $output['reviewx_recommendation_count_color']; ?> !important;
			font-size: <?php echo $output['reviewx_recommendation_count_font_size']; ?>px !important;		
		}

		.rx_recommended_box .rx_recommended_box_content{
			color: <?php echo $output['reviewx_recommendation_text_color']; ?> !important;
			font-size: <?php echo $output['reviewx_recommendation_text_font_size']; ?>px !important;		
		}				
		
		.rx_recommended_wrapper hr{
			border-style: <?php echo $output['reviewx_separator_border_style']; ?> !important;
			width: <?php echo $output['reviewx_separator_border_width']; ?>% !important;
			height: <?php echo $output['reviewx_separator_border_height']; ?>px !important;
			border-color: <?php echo $output['reviewx_separator_border_color']; ?> !important;
			background-color: <?php echo $output['reviewx_separator_border_color']; ?> !important;
		}

		.rx_recommended_wrapper{
			box-shadow: <?php echo $output['reviewx_box_shadow_horizontal']; ?>px <?php echo $output['reviewx_box_shadow_vertical']; ?>px <?php echo $output['reviewx_box_shadow_blur']; ?>px <?php echo $output['reviewx_box_shadow_spread']; ?>px <?php echo $output['reviewx_box_shadow_color']; ?> <?php echo $output['reviewx_box_shadow_position']; ?> !important;
			border-style: <?php echo $output['reviewx_statistics_border_style']; ?> !important;
			border-width: <?php echo $output['reviewx_statistics_border_weight']; ?>px !important;
			border-color: <?php echo $output['reviewx_statistics_border_color']; ?> !important;
		}

		.rx-graph-style-2 .progress-bar-t, .rx_style_two_free_progress_bar .progressbar-title, .vertical .vertical_bar_label{
			color: <?php echo $output['reviewx_criteria_name_color']; ?> !important;
			font-size: <?php echo $output['reviewx_criteria_name_font_size']; ?>px !important;	
		}
		
		.rx-horizontal .progress-fill,.rx_style_one_progress .rx_style_one_progress-bar, .rx_style_two_free_progress_bar .progress .progress-bar,.vertical .progress-fill {
			background-color: <?php echo $output['reviewx_progress_bar_bg_color']; ?> !important;
		} 

		.rx-horizontal .progress-fill span,
		.rx_style_one_progress.orange .rx_style_one_progress-icon, 
		.rx_style_one_progress.orange .rx_style_one_progress-value,
		.rx_style_two_free_progress_bar .progress .progress-bar span,
		.vertical .progress-fill {
			color: <?php echo $output['reviewx_progress_bar_text_color']; ?>;
			font-size: <?php echo $output['reviewx_progress_bar_font_size']; ?>px !important;	
		}

		.rx_style_one_progress.orange .rx_style_one_progress-icon, .rx_style_one_progress.orange .rx_style_one_progress-value{
			border-color: <?php echo $output['reviewx_progress_bar_border_color']; ?> !important;	
		}

		.rx_rating_graph_wrapper{
			box-shadow: <?php echo $output['reviewx_graph_box_shadow_horizontal']; ?>px <?php echo $output['reviewx_graph_box_shadow_vertical']; ?>px <?php echo $output['reviewx_graph_box_shadow_blur']; ?>px <?php echo $output['reviewx_graph_box_shadow_spread']; ?>px <?php echo $output['reviewx_graph_box_shadow_color']; ?> <?php echo $output['reviewx_graph_box_shadow_position']; ?> !important;
			border-style: <?php echo $output['reviewx_graph_border_style']; ?> !important;
			border-width: <?php echo $output['reviewx_graph_border_weight']; ?>px !important;
			border-color: <?php echo $output['reviewx_graph_border_color']; ?> !important;
		}
	<?php if( $template == 'template_style_one' ) { ?>	

		.rx-filter-bar .rx_filter_header h4, .rx-filter-bar .rx-short-by h4{
			color: <?php echo $output['reviewx_template_one_filtering_bar_text_color']; ?> !important;
			font-size: <?php echo $output['reviewx_template_one_filtering_bar_text_font_size']; ?>px !important;
		}

		.rx-filter-bar .rx_review_shorting_2 .box select{
			color: <?php echo $output['reviewx_template_one_filtering_drowpdown_text_color']; ?> !important;	
			background-color: <?php echo $output['reviewx_template_one_filtering_drowpdown_bg_color']; ?> !important;				
		}

		.rx-filter-bar .rx_review_shorting_2 .box .rx-selection-arrow b{
			border-color: <?php echo $output['reviewx_template_one_filtering_drowpdown_icon_color']; ?> transparent transparent transparent !important;
		}
		.rx-filter-bar .rx_review_shorting_2 .box .rx-selection-arrow{
			background-color: <?php echo $output['reviewx_template_one_filtering_drowpdown_bar_color']; ?> !important;
		}
		.rx-filter-bar{
			background-color: <?php echo $output['reviewx_template_one_filtering_bg_color']; ?> !important;	
		}
		.rx_listing .rx_review_block .rx_thumb{
			box-shadow: <?php echo $output['reviewx_template_one_avatar_box_shadow_horizontal']; ?>px <?php echo $output['reviewx_template_one_avatar_box_shadow_vertical']; ?>px <?php echo $output['reviewx_template_one_avatar_box_shadow_blur']; ?>px <?php echo $output['reviewx_template_one_avatar_box_shadow_spread']; ?>px <?php echo $output['reviewx_template_one_avatar_box_shadow_color']; ?> <?php echo $output['reviewx_template_one_avatar_box_shadow_position']; ?>;
			border-style: <?php echo $output['reviewx_template_one_avatar_border_style']; ?> !important;
			border-width: <?php echo $output['reviewx_template_one_avatar_border_weight']; ?>px !important;
			border-color: <?php echo $output['reviewx_template_one_avatar_border_color']; ?> !important;			
		}
		

		.rx_listing .rx_review_block .rx_author_info .rx_author_name h4{
			color: <?php echo $output['reviewx_template_one_reviewer_name_color']; ?> !important;
			font-size: <?php echo $output['reviewx_template_one_reviewer_name_font_size']; ?>px !important;			
		}

		.rx_review_sort_list .rx_listing_container .rx_listing .rx_avg_star_color{
			fill: <?php echo $output['reviewx_template_one_rating_color']; ?> !important;
		}

		.rx_listing .rx_review_block .rx_body .review_rating svg{
			width: <?php echo $output['reviewx_template_one_star_rating_size']; ?>px !important; 	
			height: <?php echo $output['reviewx_template_one_star_rating_size']; ?>px !important; 			
		}

		.rx_listing .rx_review_block .review_title{
			color: <?php echo $output['reviewx_template_one_title_color']; ?> !important;
			font-size: <?php echo $output['reviewx_template_one_title_font_size']; ?>px !important;			
		}

		.rx_listing .rx_review_block .rx_body p{
			color: <?php echo $output['reviewx_template_one_review_text_color']; ?> !important;
			font-size: <?php echo $output['reviewx_template_one_review_text_font_size']; ?>px !important;	
		}

		.rx_listing .rx_review_block .rx_body .rx_review_calender svg .st0{
			fill:  <?php echo $output['reviewx_template_one_date_icon_color']; ?> !important;
		}

		.rx_listing .rx_review_block .rx_body .rx_review_calender{
			color: <?php echo $output['reviewx_template_one_date_text_color']; ?> !important;
			font-size: <?php echo $output['reviewx_template_one_date_font_size']; ?>px !important;	
		}

		.rx_listing .rx_review_block .rx_body .rx_varified .rx_varified_user svg .st0{			
			fill:  <?php echo $output['reviewx_template_one_verified_icon_color']; ?> !important;
		}

		.rx_review_block .rx_body .rx_varified .rx_varified_user span{
			color: <?php echo $output['reviewx_template_one_verified_text_color']; ?> !important;
			font-size: <?php echo $output['reviewx_template_one_verified_font_size']; ?>px !important;	
		}

		.rx_listing .rx_review_block .rx_body .rx_meta .rx_review_vote_icon p{
			color: <?php echo $output['reviewx_template_one_helpful_text_color']; ?> !important;
			font-size: <?php echo $output['reviewx_template_one_helpful_font_size']; ?>px !important;	
		}

		.rx_listing .rx_review_vote_icon .like{
			background-color: <?php echo $output['reviewx_template_one_helpful_button_bgcolor']; ?> !important;
		}

		.rx_listing .rx_helpful_style_1_svg svg{
			fill:  <?php echo $output['reviewx_template_one_helpful_thumbsup_color']; ?> !important;
		}

		.rx_listing .rx_review_vote_icon .like .rx_helpful_count_val{
			color: <?php echo $output['reviewx_template_one_helpful_thumbsup_count_color']; ?> !important;
		}

		.rx_listing .rx_review_block .rx_body .rx_meta .rx_share p{			
			color: <?php echo $output['reviewx_template_one_share_text_color']; ?> !important;
			font-size: <?php echo $output['reviewx_template_one_share_text_font_size']; ?>px !important;	
		}

		.rx_listing .social-links .wc_rx_btns ul li:nth-child(1) svg{
			fill:  <?php echo $output['reviewx_template_one_helpful_thumbsup_color']; ?> !important;
		}

		.rx_listing .social-links .wc_rx_btns ul li:nth-child(2) a svg .st0{
			fill:  <?php echo $output['reviewx_template_one_facebook_icon_color']; ?> !important;			
		}

		.rx_listing .social-links .wc_rx_btns ul li:nth-child(3) a svg .st0{
			fill:  <?php echo $output['reviewx_template_one_twitter_icon_color']; ?> !important;
		}

		.rx_listing .rx_review_block + .rx_review_block{
			border-top: 2px solid <?php echo $output['reviewx_template_one_top_border_color']; ?> !important;
		}

		.rx_listing .reviewx_highlight_comment{
			border-color: <?php echo $output['reviewx_template_one_highlight_color']; ?> !important;
		}
		.rx_listing .rx_review_block .rx_body .rx_photos{
			justify-content: <?php echo $output['reviewx_template_one_attachment_align']; ?> !important;
		}

		.rx_listing_container{			
			background-color: <?php echo $output['reviewx_template_one_background_color']; ?> !important;
			border-color: <?php echo $output['reviewx_template_one_border_color']; ?> !important;
		}

		.rx_listing .rx_review_block .children .rx_thumb svg .st0{
			fill:  <?php echo $output['reviewx_template_one_store_logo_color']; ?> !important;
		}

		.rx_listing .rx_review_block .children .rx_thumb{
			background-color: <?php echo $output['reviewx_template_one_store_logo_bg_color']; ?> !important;
			border-radius: <?php echo $output['reviewx_template_one_store_logo_border_radius']; ?>px !important;
			border: none !important;;
		}

		.rx_listing .rx_review_block .children .review_title{
			color: <?php echo $output['reviewx_template_one_store_name_color']; ?> !important;
			font-size: <?php echo $output['reviewx_template_one_store_name_font_size']; ?>px !important;				
		}

		.rx_listing .rx_review_block .children .owner_arrow svg .st0{			
			fill:  <?php echo $output['reviewx_template_one_replay_back_icon_color']; ?> !important;
		}

		.rx_listing .rx_review_block .children .comment-content p{
			color: <?php echo $output['reviewx_template_one_reply_text_color']; ?> !important;
			font-size: <?php echo $output['reviewx_template_one_reply_text_font_size']; ?>px !important;
		}

		.rx_listing .rx_review_block .children .rx_review_calender{			
			color: <?php echo $output['reviewx_template_one_reply_date_color']; ?> !important;			
			font-size: <?php echo $output['reviewx_template_one_reply_date_font_size']; ?>px !important;	
		}

		.rx_listing .rx_review_block .children .rx_body .rx_review_calender svg .st0{			
			fill:  <?php echo $output['reviewx_template_one_reply_date_icon_color']; ?> !important;
		}

		.admin-reply-edit-icon svg{
			fill:  <?php echo $output['reviewx_template_one_reply_edit_icon_color']; ?> !important;
			
		}

		.admin-reply-delete-icon svg{
			fill:  <?php echo $output['reviewx_template_one_reply_delete_icon_color']; ?> !important;
		}

		.rx_listing .rx_review_block .rx_meta .rx-admin-reply{			
			color: <?php echo $output['reviewx_template_one_reply_button_text_color']; ?> !important;	
			font-size: <?php echo $output['reviewx_template_one_reply_button_text_font_size']; ?>px !important;	
			background-color: <?php echo $output['reviewx_template_one_reply_button_bg_color']; ?> !important;	
			border-color: <?php echo $output['reviewx_template_one_reply_button_border_color']; ?> !important;		
		}		

		.rx_listing .children{
			background-color: <?php echo $output['reviewx_template_one_reply_background_color']; ?> !important;
		}

		.rx-admin-edit-reply-area, .rx-admin-reply-area{
			background-color: <?php echo $output['reviewx_template_one_reply_form_background_color']; ?> !important;
			border-color: <?php echo $output['reviewx_template_one_reply_form_border_color']; ?> !important;
			border-radius: <?php echo $output['reviewx_template_one_reply_form_border_radius']; ?>px !important;			
		}

		.rx_listing_style_1 .rx_review_block .rx_body .admin-reply-form-title,
		.rx_listing_style_1 .rx-admin-edit-reply-area .admin-reply-form-title{
			color: <?php echo $output['reviewx_template_one_reply_form_title_color']; ?> !important;
			font-size: <?php echo $output['reviewx_template_one_reply_form_title_font_size']; ?>px !important;			
		}

		.rx_listing .rx_review_block .rx_body .rx-admin-reply-area .comment-form-comment textarea, .rx-admin-edit-reply-area .comment-form-comment textarea{			
			background-color: <?php echo $output['reviewx_template_one_reply_form_textarea_color']; ?> !important;
		}

		.rx-admin-edit-reply-area .form-submit .admin-review-edit-reply, 
		.rx-admin-reply-area .form-submit .admin-review-reply{
			background-color: <?php echo $output['reviewx_template_one_reply_form_submit_button_bgcolor']; ?> !important;
			color: <?php echo $output['reviewx_template_one_reply_form_submit_button_text_color']; ?> !important;
			font-size: <?php echo $output['reviewx_template_one_reply_form_submit_button_font_size']; ?>px !important;			
		}

		.rx-admin-edit-reply-area .form-submit .cancel-admin-edit-reply, .rx-admin-reply-area .form-submit .cancel-admin-reply{
			color: <?php echo $output['reviewx_template_one_reply_form_cancel_button_text_color']; ?> !important;			
			background-color: <?php echo $output['reviewx_template_one_reply_form_cancel_button_bgcolor']; ?>!important;	
		}

		.rx-admin-edit-reply-area .form-submit .cancel-admin-reply, .rx-admin-reply-area .form-submit .cancel-admin-reply{
			font-size: <?php echo $output['reviewx_template_one_reply_form_cancel_button_font_size']; ?>px !important;			
		}

		.rx_listing_style_1 .rx_pagination a{
			color: <?php echo $output['reviewx_template_one_pagination_text_color']; ?> !important;	
			font-size: <?php echo $output['reviewx_template_one_pagination_font_size']; ?>px !important;	
			background-color: <?php echo $output['reviewx_template_one_pagination_bg_color']; ?>!important;							
		}

		.rx_listing_style_1 .rx_pagination .rx-page.active a{
			color: <?php echo $output['reviewx_template_one_pagination_active_color']; ?> !important;	
			background-color: <?php echo $output['reviewx_template_one_pagination_active_bgcolor']; ?>!important;					
		}

		.rx_listing_style_1 .rx_pagination a:hover{
			color: <?php echo $output['reviewx_template_one_pagination_hover_text_color']; ?> !important;	
			background-color: <?php echo $output['reviewx_template_one_pagination_hover_bgcolor']; ?>!important;					
		}

		.rx-review-form-area-style-1 .rx-criteria-table td{
			color: <?php echo $output['reviewx_template_one_criteria_text_color']; ?> !important;	
			font-size: <?php echo $output['reviewx_template_one_criteria_text_font_size']; ?>px !important;				
		}

		.rx-review-form-area-style-1 .rx_star_rating > input:checked ~ label .icon-star,
		.rx-review-form-area-style-1 .reviewx-thumbs-rating input[type="radio"]:checked + label svg, .rx-review-form-area-style-1 .reviewx-thumbs-rating input[type="radio"]:checked + label svg #rx_dislike path,
		.rx-review-form-area-style-1 .reviewx-face-rating fieldset input[type="radio"]:checked + label .happy_st0, .rx-review-form-area-style-1 .reviewx-face-rating fieldset input[type="radio"]:checked + label .st1{
			fill:  <?php echo $output['reviewx_template_one_form_rating_icon_color']; ?> !important;
		}
		.rx-review-form-area-style-1 .rx_star_rating .icon-star,
		.rx-review-form-area-style-1 .rx_star_rating:not(:checked) > label:hover .icon-star, .rx_star_rating:not(:checked) > label:hover ~ label .icon-star{
			stroke:  <?php echo $output['reviewx_template_one_form_rating_icon_color']; ?> !important;
		}

		.rx-review-form-area-style-1 .rx_star_rating .icon-star{
			width:  <?php echo $output['reviewx_template_one_criteria_icon_size']; ?>px !important;	
			height:  <?php echo $output['reviewx_template_one_criteria_icon_size']; ?>px !important;	
			stroke:  <?php echo $output['reviewx_template_one_form_rating_icon_color']; ?> !important;
		}

		.rx-review-form-area-style-1 .rx_star_rating:not(:checked) > label:hover .icon-star, .rx-review-form-area-style-1 .rx_star_rating:not(:checked) > label:hover ~ label .icon-star{
			fill:  <?php echo $output['reviewx_template_one_form_rating_icon_color']; ?> !important;
		}

		.rx-review-form-area-style-1 .reviewx_recommended_list .reviewx_radio input[type="radio"]:checked + .radio-label svg .rx_happy, 
		.rx-review-form-area-style-1 .reviewx_recommended_list .reviewx_radio input[type="radio"]:checked + .radio-label svg .st1{
			fill:  <?php echo $output['reviewx_template_one_form_recommendation_icon_active_color']; ?> !important;			
		}

		.rx-review-form-area-style-1 #review_form .rx-note-video{
			color: <?php echo $output['reviewx_template_one_form_external_video_link_color']; ?> !important;	
			font-size: <?php echo $output['reviewx_template_one_form_external_video_font_size']; ?>px !important;										
		}

		.rx-review-form-area-style-1 .review_media_compliance .review_anonymouse_label{
			color: <?php echo $output['reviewx_template_one_media_upload_compliance_text_color']; ?> !important;	
			font-size: <?php echo $output['reviewx_template_one_media_upload_compliance_font_size']; ?>px !important;										
		}			

		.rx-review-form-area-style-1 #review_form input[type="submit"], 
		.rx-review-form-area-style-1 #review_form input[type="submit"]:focus{
			color: <?php echo $output['reviewx_template_one_form_submit_button_text_color']; ?> !important;	
			font-size: <?php echo $output['reviewx_template_one_form_submit_button_font_size']; ?>px !important;	
			background-color: <?php echo $output['reviewx_template_one_form_submit_button_bg_color']; ?> !important;					
		}

		.rx-review-form-area-style-1 #respond input#submit{
			border-radius: <?php echo $output['reviewx_template_one_form_submit_button_border_radius']; ?>px !important;
		}

	<?php } else { ?>	

		.rx-filter-bar-style-2 .rx_filter_header h4, 
		.rx-filter-bar-style-2 .rx-short-by h4{
			color: <?php echo $output['reviewx_template_two_filtering_bar_text_color']; ?> !important;
			font-size: <?php echo $output['reviewx_template_two_filtering_bar_text_font_size']; ?>px !important;
		}

		.rx-filter-bar-style-2 .rx_review_shorting_2 .box select{
			font-size: <?php echo $output['reviewx_template_two_filtering_bar_text_font_size']; ?>px !important;
			color: <?php echo $output['reviewx_template_two_filtering_drowpdown_text_color']; ?> !important;	
			background-color: <?php echo $output['reviewx_template_two_filtering_drowpdown_bg_color']; ?> !important;	
		}
		
		.rx-filter-bar-style-2 .rx_review_shorting_2 .box .rx-selection-arrow{
			background-color: <?php echo $output['reviewx_template_two_filtering_drowpdown_bar_color']; ?> !important;
		}

		.rx-filter-bar-style-2 .rx_review_shorting_2 .box .rx-selection-arrow b{
			border-color: <?php echo $output['reviewx_template_two_filtering_drowpdown_icon_color']; ?> transparent transparent transparent !important;
		}

		.rx-filter-bar-style-2{
			background-color: <?php echo $output['reviewx_template_two_filtering_bg_color']; ?> !important;	
		}

		.rx_listing_style_2 .rx_review_block{
			background-color: <?php echo $output['reviewx_template_two_background_color']; ?> !important;
		}

		.rx_listing_style_2 .rx_review_block .rx_thumb{
			box-shadow: <?php echo $output['reviewx_template_two_avatar_box_shadow_horizontal']; ?>px <?php echo $output['reviewx_template_two_avatar_box_shadow_vertical']; ?>px <?php echo $output['reviewx_template_two_avatar_box_shadow_blur']; ?>px <?php echo $output['reviewx_template_two_avatar_box_shadow_spread']; ?>px <?php echo $output['reviewx_template_two_avatar_box_shadow_color']; ?> <?php echo $output['reviewx_template_two_avatar_box_shadow_position']; ?> !important;
			border-style: <?php echo $output['reviewx_template_two_avatar_border_style']; ?> !important;
			border-width: <?php echo $output['reviewx_template_two_avatar_border_weight']; ?>px !important;
			border-color: <?php echo $output['reviewx_template_two_avatar_border_color']; ?> !important;			
		}

		.rx_listing_style_2 .rx_review_block .rx_author_info .rx_author_name h4{
			color: <?php echo $output['reviewx_template_two_reviewer_name_color']; ?> !important;
			font-size: <?php echo $output['reviewx_template_two_reviewer_name_font_size']; ?>px !important;			
		}

		.rx_review_sort_list .rx_listing_container_style_2 .rx_listing_style_2 .rx_avg_star_color{
			fill: <?php echo $output['reviewx_template_two_rating_color']; ?> !important;

		}	

		.rx_listing_style_2 .rx_review_block .rx_body .review_rating svg{
			width: <?php echo $output['reviewx_template_two_star_rating_size']; ?>px !important; 	
			height: <?php echo $output['reviewx_template_two_star_rating_size']; ?>px !important; 			

		}

		.rx_listing_style_2 .rx_review_block .review_title{
			color: <?php echo $output['reviewx_template_two_title_color']; ?> !important;
			font-size: <?php echo $output['reviewx_template_two_title_font_size']; ?>px !important;	

		}	

		.rx_listing_style_2 .rx_review_block .rx_body p{
			color: <?php echo $output['reviewx_template_two_review_text_color']; ?> !important;
			font-size: <?php echo $output['reviewx_template_two_review_text_font_size']; ?>px !important;	
		}

		.rx_listing_style_2 .rx_review_block .rx_body .rx_varified .rx_varified_user svg .st0{			
			fill: <?php echo $output['reviewx_template_two_verified_icon_color']; ?> !important;
		}

		.rx_listing_style_2 .rx_review_block .rx_body .rx_varified .rx_varified_user span{
			color: <?php echo $output['reviewx_template_two_verified_text_color']; ?> !important;
			font-size: <?php echo $output['reviewx_template_two_verified_font_size']; ?>px !important;	
		}
		
		.rx_listing_style_2 .rx_review_block .rx_body .rx_meta .rx_review_vote_icon p{
			color: <?php echo $output['reviewx_template_two_helpful_text_color']; ?> !important;
			font-size: <?php echo $output['reviewx_template_two_helpful_font_size']; ?>px !important;	
		}

		.rx_listing_style_2 .rx_review_vote_icon .like{
			background-color: <?php echo $output['reviewx_template_two_helpful_button_bgcolor']; ?> !important;
		}

		.rx_listing_style_2 .rx_helpful_style_2_svg svg{
			fill:  <?php echo $output['reviewx_template_two_helpful_thumbsup_color']; ?> !important;
		}

		.rx_listing_style_2 .rx_review_vote_icon .like .rx_helpful_count_val{
			color: <?php echo $output['reviewx_template_two_helpful_thumbsup_count_color']; ?> !important;
		}

		.rx_listing_style_2 .rx_review_block .rx_body .rx_meta .rx_share p{
			color: <?php echo $output['reviewx_template_two_share_text_color']; ?> !important;
			font-size: <?php echo $output['reviewx_template_two_share_text_font_size']; ?>px !important;				
		}

		.rx_listing_style_2 .social-links .wc_rx_btns ul li:nth-child(1) svg{
			fill:  <?php echo $output['reviewx_template_two_helpful_thumbsup_color']; ?> !important;
		}

		.rx_listing_style_2 .social-links .wc_rx_btns ul li:nth-child(2) a svg .st0{
			fill:  <?php echo $output['reviewx_template_two_facebook_icon_color']; ?> !important;
		}

		.rx_listing_style_2 .social-links .wc_rx_btns ul li:nth-child(3) a svg .st0{
			fill:  <?php echo $output['reviewx_template_two_twitter_icon_color']; ?> !important;
		}

		.rx_listing_style_2 .rx_admin_heighlights span svg{
			color: <?php echo $output['reviewx_template_two_highlight_icon_color']; ?> !important;
		}

		.rx_listing_style_2 .reviewx_highlight_comment{
			background-color: <?php echo $output['reviewx_template_two_highlight_color']; ?> !important;
		}

		.rx_listing_style_2.rx_listing_filter_style_2 .reviewx_highlight_comment .children, .rx_listing_style_2 .reviewx_highlight_comment .children .rx_review_block{

		}

		.rx_listing_style_2 .rx_review_block .rx_body .rx_photos{
			justify-content: <?php echo $output['reviewx_template_two_attachment_align']; ?> !important;

		}

		.rx_listing_style_2 .rx_review_block .children .rx_thumb svg .st0{
			fill:  <?php echo $output['reviewx_template_two_store_logo_color']; ?> !important;
		}

		.rx_listing_style_2 .rx_review_block .children .rx_thumb{
			background-color: <?php echo $output['reviewx_template_two_store_logo_bg_color']; ?> !important;
		}

		.rx_listing_style_2 .rx_review_block .children .review_title{
			color: <?php echo $output['reviewx_template_two_store_name_color']; ?> !important;
			font-size: <?php echo $output['reviewx_template_two_store_name_font_size']; ?>px !important;	

		}

		.rx_listing_style_2 .rx_review_block .children .owner_arrow svg .st0{
			fill:  <?php echo $output['reviewx_template_two_replay_back_icon_color']; ?> !important;
		}

		.rx_listing_style_2 .rx_review_block .children .comment-content p{
			color: <?php echo $output['reviewx_template_two_reply_text_color']; ?> !important;
			font-size: <?php echo $output['reviewx_template_two_reply_text_font_size']; ?>px !important;
		}

		.rx_listing_style_2 .rx_review_block .children .rx_review_calender{
			color: <?php echo $output['reviewx_template_two_reply_date_color']; ?> !important;			
			font-size: <?php echo $output['reviewx_template_two_reply_date_font_size']; ?>px !important;
		}

		.rx_listing_style_2 .rx_review_block .rx_body .rx_review_calender svg .st0{
			fill: <?php echo $output['reviewx_template_two_date_icon_color']; ?> !important; 
		}

		.rx_listing_style_2 .rx_review_block .rx_body .rx_review_calender{
			color:  <?php echo $output['reviewx_template_two_date_text_color']; ?> !important;
			font-size: <?php echo $output['reviewx_template_two_date_font_size']; ?>px !important;
		}

		.admin-reply-edit-icon svg{
			fill:  <?php echo $output['reviewx_template_two_reply_edit_icon_color']; ?> !important;
		}

		.admin-reply-delete-icon svg{
			fill:  <?php echo $output['reviewx_template_two_reply_delete_icon_color']; ?> !important;
		}

		.rx_listing_style_2 .rx_review_block .rx_body .rx_meta .rx-admin-reply{
			color: <?php echo $output['reviewx_template_two_reply_button_text_color']; ?> !important;	
			font-size: <?php echo $output['reviewx_template_two_reply_button_text_font_size']; ?>px !important;	
			background-color: <?php echo $output['reviewx_template_two_reply_button_bg_color']; ?> !important;	
			border-color: <?php echo $output['reviewx_template_two_reply_button_border_color']; ?> !important;		
		}

		.rx_listing_container_style_2 .rx-admin-edit-reply-area,
		.rx_listing_container_style_2 .rx_review_block .rx_body .rx-admin-reply-area{
			background-color: <?php echo $output['reviewx_template_two_reply_form_background_color']; ?> !important;
			border-color: <?php echo $output['reviewx_template_two_reply_form_border_color']; ?> !important;
			border-radius: <?php echo $output['reviewx_template_two_reply_form_border_radius']; ?>px !important;
		}

		.rx_listing_container_style_2 .rx-admin-reply-area,
		.rx_listing_container_style_2 .rx_review_block .rx_body .rx-admin-edit-reply-area{
			border-radius: <?php echo $output['reviewx_template_two_reply_form_border_radius']; ?>px !important;
		}

		.rx_listing_container_style_2 .rx_review_block .rx_body .rx-admin-reply-area .admin-reply-form-title,
		.rx_listing_container_style_2 .rx-admin-edit-reply-area .admin-reply-form-title{
			color: <?php echo $output['reviewx_template_two_reply_form_title_color']; ?> !important;
			font-size: <?php echo $output['reviewx_template_two_reply_form_title_font_size']; ?>px !important;	
		}

		.rx_listing_container_style_2 .rx_review_block .rx_body .rx-admin-reply-area .comment-form-comment .rx-admin-reply-text, 
		.rx_listing_container_style_2 .rx-admin-edit-reply-area .comment-form-comment .rx-admin-reply-text{
			background-color: <?php echo $output['reviewx_template_two_reply_form_textarea_color']; ?> !important;
		}

		.rx_listing_container_style_2 .rx-admin-edit-reply-area .form-submit .admin-review-edit-reply, 
		.rx_listing_container_style_2 .rx_review_block .rx_body .rx-admin-reply-area .form-submit .admin-review-reply{
			color: <?php echo $output['reviewx_template_two_reply_form_submit_button_text_color']; ?> !important;
			font-size: <?php echo $output['reviewx_template_two_reply_form_submit_button_font_size']; ?>px !important;
			background-color: <?php echo $output['reviewx_template_two_reply_form_submit_button_bgcolor']; ?> !important;			
		}

		.rx_listing_container_style_2 .rx-admin-edit-reply-area .form-submit .cancel-admin-edit-reply, 
		.rx_review_block .rx_body .rx-admin-reply-area .form-submit .cancel-admin-reply{
			color: <?php echo $output['reviewx_template_two_reply_form_cancel_button_text_color']; ?> !important;	
			font-size: <?php echo $output['reviewx_template_two_reply_form_cancel_button_font_size']; ?>px !important;		
			background-color: <?php echo $output['reviewx_template_two_reply_form_cancel_button_bgcolor']; ?> !important;
		}

		.rx_listing_container_style_2 .rx-admin-edit-reply-area .form-submit .cancel-admin-reply, 
		.rx_listing_container_style_2 .rx_review_block .rx_body .rx-admin-reply-area .form-submit .cancel-admin-reply{
			font-size: <?php echo $output['reviewx_template_two_reply_form_cancel_button_font_size']; ?>px !important;
		}

		.rx_listing_container_style_2 .rx_pagination a{
			color: <?php echo $output['reviewx_template_two_pagination_text_color']; ?> !important;	
			font-size: <?php echo $output['reviewx_template_two_pagination_font_size']; ?>px !important;	
			background-color: <?php echo $output['reviewx_template_two_pagination_bg_color']; ?>!important;
		}

		.rx_listing_container_style_2 .rx_pagination .rx-page.active a{
			color: <?php echo $output['reviewx_template_two_pagination_active_color']; ?> !important;	
			background-color: <?php echo $output['reviewx_template_two_pagination_active_bgcolor']; ?>;
		}

		.rx_listing_container_style_2 .rx_pagination a:hover{
			color: <?php echo $output['reviewx_template_two_pagination_hover_text_color']; ?> !important;	
			background-color: <?php echo $output['reviewx_template_two_pagination_hover_bgcolor']; ?>!important;
		}

		.rx-review-form-area-style-2 .rx-criteria-table td{
			color: <?php echo $output['reviewx_template_two_criteria_text_color']; ?> !important;	
			font-size: <?php echo $output['reviewx_template_two_criteria_text_font_size']; ?>px !important;				
		}

		.rx-review-form-area-style-2 .rx_star_rating > input:checked ~ label .icon-star,
		.rx-review-form-area-style-2 .reviewx-thumbs-rating input[type="radio"]:checked + label svg, .rx-review-form-area-style-2 .reviewx-thumbs-rating input[type="radio"]:checked + label svg #rx_dislike path,
		.rx-review-form-area-style-2 .reviewx-face-rating fieldset input[type="radio"]:checked + label .happy_st0, .rx-review-form-area-style-2 .reviewx-face-rating fieldset input[type="radio"]:checked + label .st1{
			fill:  <?php echo $output['reviewx_template_two_form_rating_icon_color']; ?> !important;
		}

		.rx-review-form-area-style-2 .rx_star_rating .icon-star,
		.rx-review-form-area-style-2 .rx_star_rating:not(:checked) > label:hover .icon-star, .rx_star_rating:not(:checked) > label:hover ~ label .icon-star{
			stroke:  <?php echo $output['reviewx_template_two_form_rating_icon_color']; ?> !important;
		}

		.rx-review-form-area-style-2 .rx_star_rating:not(:checked) > label:hover .icon-star, .rx-review-form-area-style-2 .rx_star_rating:not(:checked) > label:hover ~ label .icon-star{
			fill:  <?php echo $output['reviewx_template_two_form_rating_icon_color']; ?> !important;
		}

		.rx-review-form-area-style-2 .rx_star_rating .icon-star{
			width:  <?php echo $output['reviewx_template_two_criteria_icon_size']; ?>px !important;	
			height:  <?php echo $output['reviewx_template_two_criteria_icon_size']; ?>px !important;	
			stroke:  <?php echo $output['reviewx_template_two_form_rating_icon_color']; ?> !important;
		}

		.rx-review-form-area-style-2 .reviewx_recommended_list .reviewx_radio input[type="radio"]:checked + .radio-label svg .rx_happy, .rx-review-form-area-style-2 .reviewx_recommended_list .reviewx_radio input[type="radio"]:checked + .radio-label svg .st1{
			fill:  <?php echo $output['reviewx_template_two_form_recommendation_icon_active_color']; ?> !important;			
		}

		.rx-review-form-area-style-2 #review_form .rx-note-video{
			color: <?php echo $output['reviewx_template_two_form_external_video_link_color']; ?> !important;	
			font-size: <?php echo $output['reviewx_template_two_form_external_video_font_size']; ?>px !important;										
		}

		.rx-review-form-area-style-2 .review_media_compliance .review_anonymouse_label{
			color: <?php echo $output['reviewx_template_two_media_upload_compliance_text_color']; ?> !important;	
			font-size: <?php echo $output['reviewx_template_two_media_upload_compliance_font_size']; ?>px !important;										
		}		

		.rx-review-form-area-style-2 #review_form input[type="submit"], 
		.rx-review-form-area-style-2 #review_form input[type="submit"]:focus{
			color: <?php echo $output['reviewx_template_two_form_submit_button_text_color']; ?> !important;	
			font-size: <?php echo $output['reviewx_template_two_form_submit_button_font_size']; ?>px !important;	
			background-color: <?php echo $output['reviewx_template_two_form_submit_button_bg_color']; ?>;
			border-color: <?php echo $output['reviewx_template_two_form_submit_button_bg_color']; ?> !important;
			outline-color: <?php echo $output['reviewx_template_two_form_submit_button_bg_color']; ?> !important;
		}

		.rx-review-form-area-style-2 #respond input#submit{
			border-radius: <?php echo $output['reviewx_template_two_form_submit_button_border_radius']; ?>px !important;
		}
	<?php } ?>

		.rx_myaccount-review_form .rx-criteria-table td{
			color: <?php echo $output['reviewx_order_review_form_criteria_text_color']; ?> !important;	
			font-size: <?php echo $output['reviewx_order_review_form_criteria_text_font_size']; ?>px !important;				
		}

		.rx_myaccount-review_form .rx_star_rating > input:checked ~ label .icon-star{
			fill:  <?php echo $output['reviewx_order_review_form_rating_icon_color']; ?> !important;
			stroke:  <?php echo $output['reviewx_order_review_form_rating_icon_color']; ?> !important;
		}

		.rx_myaccount-review_form .rx_star_rating .icon-star{
			stroke:  <?php echo $output['reviewx_order_review_form_rating_icon_color']; ?> !important;
			width:  <?php echo $output['reviewx_order_review_form_criteria_icon_size']; ?>px !important;	
			height:  <?php echo $output['reviewx_order_review_form_criteria_icon_size']; ?>px !important;				
		}

		.reviewx_recommended_list .reviewx_radio input[type="radio"]:checked + .radio-label svg .rx_happy, 
		.reviewx_recommended_list .reviewx_radio input[type="radio"]:checked + .radio-label svg .st1{
			fill:  <?php echo $output['reviewx_order_review_form_recommendation_icon_active_color']; ?> !important;			
		}

		#rx-form .rx-note-video,
		.rx-review-form .rx-note-video{
			color: <?php echo $output['reviewx_order_review_form_external_video_link_color']; ?> !important;	
			font-size: <?php echo $output['reviewx_order_review_form_external_video_font_size']; ?>px !important;										
		}

		.rx_myaccount-review_form #rx-submit,
		.rx-review-form #rx-edit{
			color: <?php echo $output['reviewx_order_review_form_submit_button_text_color']; ?> !important;	
			font-size: <?php echo $output['reviewx_order_review_form_submit_button_font_size']; ?>px !important;	
			background-color: <?php echo $output['reviewx_order_review_form_submit_button_bg_color']; ?> !important;
			border-radius: <?php echo $output['reviewx_order_review_form_submit_button_border_radius']; ?>px !important;
			border-color: <?php echo $output['reviewx_order_review_form_submit_button_bg_color']; ?> !important;					
		}

		.rx_myaccount-review_form .rx-cancel-btn.rx-cancel, .rx-edit-cancel{
			color: <?php echo $output['reviewx_order_review_form_cancel_button_text_color']; ?> !important;	
			font-size: <?php echo $output['reviewx_order_review_form_cancel_button_font_size']; ?>px !important;	
			background-color: <?php echo $output['reviewx_order_review_form_cancel_button_bg_color']; ?> !important;
			border: 1px solid <?php echo $output['reviewx_order_review_form_cancel_button_bg_color']; ?> !important;
			border-radius: <?php echo $output['reviewx_order_review_form_cancel_button_border_radius']; ?>px !important;	
		}

		.rx_myaccount-review_form .rx-cancel{
			color: <?php echo $output['reviewx_order_review_form_go_back_button_text_color']; ?> !important;	
			font-size: <?php echo $output['reviewx_order_review_form_go_back_button_font_size']; ?>px !important;	
			background-color: <?php echo $output['reviewx_order_review_form_go_back_button_bg_color']; ?> !important;
			border: 1px solid <?php echo $output['reviewx_order_review_form_go_back_button_bg_color']; ?> !important;
			border-radius: <?php echo $output['reviewx_order_review_form_go_back_button_border_radius']; ?>px !important;	
		}

		.rx-form, .rx_myaccount-review_form fieldset, .rx_myaccount-review_form .rx-criteria-table td, .rx-rating-table td{	
			background-color: <?php echo $output['reviewx_order_review_form_bg_color']; ?> !important;
		}	

		.rx_short_summery_wrap{
			background-color: <?php echo $output['reviewx_order_review_form_order_summary_bg_color']; ?> !important;
		}

		.responstable td{
			border-color: <?php echo $output['reviewx_order_review_form_order_summary_bg_color']; ?> !important;
		}

		.rx-form .reviewx_recommended h2{
			color: <?php echo $output['reviewx_order_review_form_recommendation_text_color']; ?> !important;	
			font-size: <?php echo $output['reviewx_order_review_form_recommendation_text_font_size']; ?>px !important;	
		}

		.reviewx-order-table .woocommerce-orders-table__cell p .rx_my_account_view_review{
			color: <?php echo $output['reviewx_order_view_review_button_text_color']; ?> !important;	
			font-size: <?php echo $output['reviewx_order_view_review_button_font_size']; ?>px !important;	
			background-color: <?php echo $output['reviewx_order_view_review_button_bg_color']; ?> !important;
			border: 1px solid <?php echo $output['reviewx_order_view_review_button_bg_color']; ?> !important;
			border-radius: <?php echo $output['reviewx_order_view_review_button_border_radius']; ?>px !important;				
		}

		.woocommerce-orders .woocommerce-orders-table__cell p .rx_my_account_submit_review{
			color: <?php echo $output['reviewx_order_submit_review_button_text_color']; ?> !important;	
			font-size: <?php echo $output['reviewx_order_submit_review_button_font_size']; ?>px !important;	
			background-color: <?php echo $output['reviewx_order_submit_review_button_bg_color']; ?> !important;
			border: 1px solid <?php echo $output['reviewx_order_submit_review_button_bg_color']; ?> !important;
			border-radius: <?php echo $output['reviewx_order_submit_review_button_border_radius']; ?>px !important;			
		}

		#rx-my-account-review-form .review_media_compliance .review_anonymouse_label{
			color: <?php echo $output['reviewx_order_media_upload_compliance_text_color']; ?> !important;	
			font-size: <?php echo $output['reviewx_order_media_upload_compliance_font_size']; ?>px !important;		
		}

		.rx_myaccount-review_form .rx_star_rating:not(:checked) > label:hover .icon-star, .rx_myaccount-review_form .rx_star_rating:not(:checked) > label:hover ~ label .icon-star{
			fill:  <?php echo $output['reviewx_order_review_form_rating_icon_color']; ?> !important;
		}						

	</style>
    <?php
}
add_action( 'wp_head', 'reviewx_customize_css');