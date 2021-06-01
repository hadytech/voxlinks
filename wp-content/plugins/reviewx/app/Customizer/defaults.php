<?php
/**
 *
 * @package reviewx
 */

// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;


if ( ! function_exists( 'reviewx_get_option_defaults' ) ) :
/**
 * Set default options
 */
function reviewx_get_option_defaults() {

	$reviewx_defaults = array(
		'reviewx_section_title_color'=>'',
		'reviewx_section_title_font_size'=> '',
		'reviewx_average_count_color' => '#333',
		'reviewx_average_count_font_size'=> '',
		'reviewx_heighest_rating_point_color' => '#9e9e9e',
		'reviewx_heighest_rating_point_font_size'=> '',
		'reviewx_star_rating_color' => '#FFAF22',
		'reviewx_star_rating_size'=> '',
		'reviewx_average_text_color' => '#444',
		'reviewx_average_text_font_size' => '',
		'reviewx_recommendation_count_color' => '#444',
		'reviewx_recommendation_count_font_size' => '',
		'reviewx_recommendation_text_color' => '#444',
		'reviewx_recommendation_text_font_size' => '',
		'reviewx_separator_border_style' => 'solid',
		'reviewx_separator_border_width' => '100',
		'reviewx_separator_border_height' => '1',
		'reviewx_separator_border_color'=> '#ddd',
		'reviewx_box_shadow_color' => '#797979',
		'reviewx_box_shadow_horizontal' => '',
		'reviewx_box_shadow_vertical' => '',
		'reviewx_box_shadow_blur' => '',
		'reviewx_box_shadow_spread' => '',
		'reviewx_box_shadow_position' => '',
		'reviewx_statistics_border_style'=> '',
		'reviewx_statistics_border_color' => '',
		'reviewx_statistics_border_weight' => '',
		'reviewx_criteria_name_color' => '#1a1a1a',
		'reviewx_criteria_name_font_size' => '#2f4fff',
		'reviewx_progress_bar_bg_color' => '',
		'reviewx_progress_bar_text_color' => '#fff',
		'reviewx_progress_bar_font_size' => '',
		'reviewx_progress_bar_border_color' => '',
		'reviewx_graph_box_shadow_horizontal' => '',
		'reviewx_graph_box_shadow_vertical' => '',
		'reviewx_graph_box_shadow_blur' => '',
		'reviewx_graph_box_shadow_spread' => '',
		'reviewx_graph_box_shadow_color' => '#797979',
		'reviewx_graph_box_shadow_position' => '',
		'reviewx_graph_border_style' => '',
		'reviewx_graph_border_weight' => '',
		'reviewx_graph_border_color' => '#000',
		
		'reviewx_template_one_filtering_bar_text_color' => '#676767',
		'reviewx_template_one_filtering_bar_text_font_size' => '',
		'reviewx_template_one_filtering_drowpdown_bg_color' => '#fff',
		'reviewx_template_one_filtering_drowpdown_text_color' => '#373747',
		'reviewx_template_one_filtering_drowpdown_icon_color' => '#fff',
		'reviewx_template_one_filtering_drowpdown_bar_color' => '',
		'reviewx_template_one_filtering_bg_color' => '#ececec',
		'reviewx_template_one_avatar_box_shadow_color' => '#797979',
		'reviewx_template_one_avatar_box_shadow_horizontal' => '',
		'reviewx_template_one_avatar_box_shadow_vertical' => '',
		'reviewx_template_one_avatar_box_shadow_blur' => '',
		'reviewx_template_one_avatar_box_shadow_spread' => '',
		'reviewx_template_one_avatar_box_shadow_position' => '',
		'reviewx_template_one_avatar_border_style' => '',
		'reviewx_template_one_avatar_border_color' => '#000',
		'reviewx_template_one_avatar_border_weight' => '',
		'reviewx_template_one_reviewer_name_color' => '#373747',
		'reviewx_template_one_reviewer_name_font_size' => '',
		'reviewx_template_one_rating_color' => '#FFAF22',
		'reviewx_template_one_star_rating_size' => '',
		'reviewx_template_one_title_color' => '#373747',
		'reviewx_template_one_title_font_size' => '',
		'reviewx_template_one_review_text_color' => '#9B9B9B',
		'reviewx_template_one_review_text_font_size' => '',
		'reviewx_template_one_background_color' => '',
		'reviewx_template_one_border_color' => '',
		'reviewx_template_one_date_icon_color' => '#707070',
		'reviewx_template_one_date_text_color' => '#6d6d6d',
		'reviewx_template_one_date_font_size' => '',
		'reviewx_template_one_verified_icon_color' => '#12D585',
		'reviewx_template_one_verified_text_color'=> '',
		'reviewx_template_one_verified_font_size' => '#12D585',
		'reviewx_template_one_helpful_text_color' => '#333',
		'reviewx_template_one_helpful_font_size' => '',
		'reviewx_template_one_helpful_button_bgcolor' => '#eaeaea',
		'reviewx_template_one_helpful_thumbsup_color' => '#A4A4A4',
		'reviewx_template_one_helpful_thumbsup_count_color' => '#696969',
		'reviewx_template_one_share_text_color' => '#333',
		'reviewx_template_one_share_text_font_size' => '',
		'reviewx_template_one_share_icon_color' => '#000',
		'reviewx_template_one_facebook_icon_color' => '#B7B7B8',
		'reviewx_template_one_twitter_icon_color' => '#B7B7B8',
		'reviewx_template_one_top_border_color' => '#ececec',
		'reviewx_template_one_highlight_color' => '',
		'reviewx_template_one_attachment_align' => 'flex-start',
		'reviewx_template_one_store_logo_color' => '',
		'reviewx_template_one_store_logo_bg_color' => '#fff',
		'reviewx_template_one_store_logo_border_radius' => '',
		'reviewx_template_one_store_name_color' => '#373747',
		'reviewx_template_one_store_name_font_size' => '',
		'reviewx_template_one_replay_back_icon_color' => '#707070',
		'reviewx_template_one_reply_text_color' => '#707070',
		'reviewx_template_one_reply_text_font_size' => '',
		'reviewx_template_one_reply_date_color' => '#6d6d6d',
		'reviewx_template_one_reply_date_font_size' => '',
		'reviewx_template_one_reply_date_icon_color' => '#707070',
		'reviewx_template_one_reply_edit_icon_color' => '#000',
		'reviewx_template_one_reply_delete_icon_color' => '#000',
		'reviewx_template_one_reply_button_text_color' => '#fff',
		'reviewx_template_one_reply_button_text_font_size' => '',
		'reviewx_template_one_reply_button_bg_color' => '',
		'reviewx_template_one_reply_button_border_color' => '',	
		'reviewx_template_one_reply_background_color' => '',
		'reviewx_template_one_reply_form_background_color' => '#fff',
		'reviewx_template_one_reply_form_border_color' => '#f7f7f7',
		'reviewx_template_one_reply_form_border_radius' => '',
		'reviewx_template_one_reply_form_title_color' => '#f7f7f7',
		'reviewx_template_one_reply_form_title_font_size' => '',
		'reviewx_template_one_reply_form_textarea_color' => '#EBEBF3',
		'reviewx_template_one_reply_form_submit_button_bgcolor' => '',
		'reviewx_template_one_reply_form_submit_button_text_color' => '#fff',
		'reviewx_template_one_reply_form_submit_button_font_size' => '',
		'reviewx_template_one_reply_form_cancel_button_bgcolor' => '#eeeeee',
		'reviewx_template_one_reply_form_cancel_button_text_color' => '#333',
		'reviewx_template_one_reply_form_cancel_button_font_size' => '',
		'reviewx_template_one_pagination_text_color' => '#6f7484',
		'reviewx_template_one_pagination_font_size' => '',
		'reviewx_template_one_pagination_bg_color' => '',
		'reviewx_template_one_pagination_active_color' => '#fff',
		'reviewx_template_one_pagination_active_bgcolor' => '',
		'reviewx_template_one_pagination_hover_text_color' => '#23527c',
		'reviewx_template_one_pagination_hover_bgcolor' => '',
		'reviewx_template_one_criteria_text_color' => '#1a1a1a',
		'reviewx_template_one_criteria_text_font_size' => '',
		'reviewx_template_one_form_rating_icon_color' => '#FFAF22',
		'reviewx_template_one_criteria_icon_size' => '',
		'reviewx_template_one_form_recommendation_icon_active_color' => '',
		'reviewx_template_one_form_external_video_link_color' => '#6d6d6d',
		'reviewx_template_one_form_external_video_font_size' => '',
		'reviewx_template_one_media_upload_compliance_text_color' => '#6d6d6d',
		'reviewx_template_one_media_upload_compliance_font_size' => '',		
		'reviewx_template_one_form_submit_button_text_color' => '#fff',
		'reviewx_template_one_form_submit_button_font_size' => '',
		'reviewx_template_one_form_submit_button_bg_color' => '',
		'reviewx_template_one_form_submit_button_border_radius' => '',					
		
		'reviewx_template_two_filtering_bar_text_color' => '#676767',
		'reviewx_template_two_filtering_bar_text_font_size' => '',
		'reviewx_template_two_filtering_drowpdown_bg_color' => '#fff',
		'reviewx_template_two_filtering_drowpdown_text_color' => '#333',
		'reviewx_template_two_filtering_drowpdown_icon_color' => '#fff',
		'reviewx_template_two_filtering_drowpdown_bar_color' => '',
		'reviewx_template_two_filtering_bg_color' => '#f5f6f9',		
		'reviewx_template_two_avatar_box_shadow_color' => '#797979',
		'reviewx_template_two_avatar_box_shadow_horizontal' => '',
		'reviewx_template_two_avatar_box_shadow_vertical' => '',
		'reviewx_template_two_avatar_box_shadow_blur' => '',
		'reviewx_template_two_avatar_box_shadow_spread' => '',
		'reviewx_template_two_avatar_box_shadow_position' => '',
		'reviewx_template_two_avatar_border_style' => 'solid',
		'reviewx_template_two_avatar_border_color' => '#000',
		'reviewx_template_two_avatar_border_weight' => '1',
		'reviewx_template_two_reviewer_name_color' => '#373747',
		'reviewx_template_two_reviewer_name_font_size' => '',
		'reviewx_template_two_rating_color' => '#FFAF22',
		'reviewx_template_two_star_rating_size' => '',
		'reviewx_template_two_title_color' => '#373747',
		'reviewx_template_two_title_font_size' => '',
		'reviewx_template_two_review_text_color' => '#9B9B9B',
		'reviewx_template_two_review_text_font_size' => '',
		'reviewx_template_two_background_color' => '#F5F6F9',
		'reviewx_template_two_border_color' => '',
		'reviewx_template_two_store_logo_color' => '',
		'reviewx_template_two_date_icon_color' => '#707070',
		'reviewx_template_two_date_text_color' => '#707070',
		'reviewx_template_two_date_font_size' => '',
		'reviewx_template_two_verified_icon_color' => '#12D585',
		'reviewx_template_two_verified_text_color' => '#12D585',
		'reviewx_template_two_verified_font_size' => '',
		'reviewx_template_two_helpful_text_color' => '#12D585',
		'reviewx_template_two_helpful_font_size' => '',
		'reviewx_template_two_helpful_button_bgcolor' => '#eaeaea',
		'reviewx_template_two_helpful_thumbsup_color' => '#A4A4A4',
		'reviewx_template_two_helpful_thumbsup_count_color' => '#696969',
		'reviewx_template_two_share_text_color' => '#333',
		'reviewx_template_two_share_text_font_size' => '',
		'reviewx_template_two_share_icon_color' => '#000',
		'reviewx_template_two_facebook_icon_color' => '#B7B7B8',
		'reviewx_template_two_twitter_icon_color' => '#B7B7B8',
		'reviewx_template_two_highlight_icon_color'=> '',
		'reviewx_template_two_highlight_color' => '#fff4df',
		'reviewx_template_two_attachment_align' => 'flex-start',
		'reviewx_template_two_store_logo_bg_color' => '',
		'reviewx_template_two_store_logo_border_radius' => '',
		'reviewx_template_two_store_name_color' => '#373747',
		'reviewx_template_two_store_name_font_size' => '',
		'reviewx_template_two_replay_back_icon_color' => '',
		'reviewx_template_two_reply_text_color' => '#707070',
		'reviewx_template_two_reply_text_font_size' => '',
		'reviewx_template_two_reply_date_color' => '#373747',
		'reviewx_template_two_reply_date_font_size' => '12',
		'reviewx_template_two_reply_date_icon_color' => '#373747',
		'reviewx_template_two_reply_edit_icon_color' => '#000',
		'reviewx_template_two_reply_delete_icon_color' => '#000',
		'reviewx_template_two_reply_button_text_color' => '#fff',
		'reviewx_template_two_reply_button_text_font_size' => '',
		'reviewx_template_two_reply_button_bg_color' => '',
		'reviewx_template_two_reply_button_border_color' => '',
		'reviewx_template_two_reply_background_color' => '#fff',
		'reviewx_template_two_reply_form_background_color' => '',
		'reviewx_template_two_reply_form_border_color' => '#f7f7f7',
		'reviewx_template_two_reply_form_border_radius' => '',
		'reviewx_template_two_reply_form_title_color' => '#373747',
		'reviewx_template_two_reply_form_title_font_size' => '',
		'reviewx_template_two_reply_form_textarea_color' => '#EBEBF3',
		'reviewx_template_two_reply_form_submit_button_bgcolor' => '',
		'reviewx_template_two_reply_form_submit_button_text_color' => '#fff',
		'reviewx_template_two_reply_form_submit_button_font_size' => '14',
		'reviewx_template_two_reply_form_cancel_button_bgcolor' => '#eeeeee',
		'reviewx_template_two_reply_form_cancel_button_text_color' => '#333',
		'reviewx_template_two_reply_form_cancel_button_font_size' => '',
		'reviewx_template_two_pagination_text_color' => '#6f7484',
		'reviewx_template_two_pagination_font_size' => '',
		'reviewx_template_two_pagination_bg_color' => '',
		'reviewx_template_two_pagination_active_color' => '#fff',
		'reviewx_template_two_pagination_active_bgcolor' => '',
		'reviewx_template_two_pagination_hover_text_color' => '#23527c',
		'reviewx_template_two_pagination_hover_bgcolor' => '',
		'reviewx_template_two_criteria_text_color' => '#1a1a1a',
		'reviewx_template_two_criteria_text_font_size' => '18',
		'reviewx_template_two_form_rating_icon_color' => '#FFAF22',
		'reviewx_template_two_criteria_icon_size' => '',
		'reviewx_template_two_form_recommendation_icon_active_color' => '',
		'reviewx_template_two_form_external_video_link_color' => '#6d6d6d',
		'reviewx_template_two_form_external_video_font_size' => '',
		'reviewx_template_two_media_upload_compliance_text_color' => '#6d6d6d',
		'reviewx_template_two_media_upload_compliance_font_size' => '',
		'reviewx_template_two_form_submit_button_text_color' => '#fff',
		'reviewx_template_two_form_submit_button_font_size' => '16',
		'reviewx_template_two_form_submit_button_bg_color' => '',
		'reviewx_template_two_form_submit_button_border_radius' => '0',
		'reviewx_item' => '',
		'reviewx_attachment_align' => '',
		'reviewx_store_reply' => '',
		'reviewx_reply_form' => '',
		'reviewx_form' => '',
		'reviewx_modify_label_list' => '',
		'reviewx_customer_recommendation_label' => __('Customer(s) recommended this item', 'reviewx'),
		'reviewx_sort_by_label' => __('Sort by', 'reviewx'),
		'reviewx_reply_label' => __('Reply', 'reviewx'),
		'reviewx_reply_to_this_review_label' => __('Reply to this review', 'reviewx'),
		'reviewx_edit_this_reply_label' => __('Edit this reply', 'reviewx'),
		'reviewx_reply_review_label' => __('Reply Review', 'reviewx'),
		'reviewx_update_button_label' => __('Update', 'reviewx'),
		'reviewx_cancel_button_label' => __('Cancel', 'reviewx'),
		'reviewx_helpful_label' => __('Helpful?', 'reviewx'),
		'reviewx_share_on_label' => __('Share on', 'reviewx'),
		'reviewx_modify_label' => '',
		'reviewx_form_title_label' => __('Leave feedback about this', 'reviewx'),
		'reviewx_video_upload_first_label' => __('Upload File', 'reviewx'),
		'reviewx_video_upload_second_label' => __('External Link', 'reviewx'),
		'reviewx_video_external_link' => esc_url('https://www.youtube.com/watch?v=HhBUmxEOfpc'),
		'reviewx_form_recommednation_label' => __('Recommendation:', 'reviewx'),
		'reviewx_anonymously_label' => __('Review anonymously', 'reviewx'),
		'reviewx_media_compliance' => __('I agree to the terms of services.', 'reviewx'),
		'reviewx_submit_button_label' => __('Submit Review', 'reviewx'),
		'reviewx_review_title_validation_label' => __('Please enter a title', 'reviewx'),
		'reviewx_review_leave_label' => __('Please leave a message', 'reviewx'),
		'reviewx_title_validation_label' => __('Review title can\'t be empty', 'reviewx'),
		'reviewx_text_validation_label' => __('Review can\'t be empty', 'reviewx'),
		'reviewx_review_success_label' => __('Your review submitted successfully!', 'reviewx'),
		'reviewx_rate_satisfaction_label' => __('Please rate your satisfaction', 'reviewx'),
		'reviewx_review_failed_label' => __('Review submission failed!', 'reviewx'),
		'reviewx_guest_name_validation_label' => __('Please enter your name', 'reviewx'),
		'reviewx_guest_email_validation_label' => __('Please enter a valid email address', 'reviewx'),
		'reviewx_already_given_review_label' => __('This email has already given review on this product', 'reviewx'),
		'reviewx_re_reviewed_without_purchase_again' => __('Once reviewed item can not be re-reviewed without purchase it again.', 'reviewx'),
		'reviewx_only_logged_customer_review' => __('Only logged in customers who have purchased this product may leave a review.', 'reviewx'),	
		'reviewx_re_reviewed_without_purchase_it' => __('Once reviewed item can not be re-reviewed without purchase.', 'reviewx'),
		'reviewx_order_form' => '',
		'reviewx_order_review_form_criteria_text_color' => '',	
		'reviewx_order_review_form_criteria_text_font_size' => '',
		'reviewx_order_review_form_rating_icon_color' => '',
		'reviewx_order_review_form_criteria_icon_size' => '',
		'reviewx_order_review_form_recommendation_icon_active_color' => '',
		'reviewx_order_review_form_external_video_link_color' => '',
		'reviewx_order_review_form_external_video_font_size' => '',
		'reviewx_order_review_form_submit_button_text_color' => '',
		'reviewx_order_review_form_submit_button_font_size' => '',
		'reviewx_order_review_form_submit_button_bg_color' => '',
		'reviewx_order_review_form_submit_button_border_radius' => '',
		'reviewx_order_review_form_cancel_button_text_color' => '',
		'reviewx_order_review_form_cancel_button_font_size' => '',
		'reviewx_order_review_form_cancel_button_bg_color' => '',
		'reviewx_order_review_form_cancel_button_border_radius' => '',
		
		'reviewx_order_review_form_go_back_button_text_color' => '',
		'reviewx_order_review_form_go_back_button_font_size' => '',
		'reviewx_order_review_form_go_back_button_bg_color' => '',
		'reviewx_order_review_form_go_back_button_border_radius' => '',	
		'reviewx_order_review_form_bg_color' => '',
		'reviewx_order_review_form_order_summary_bg_color' => '',
		'reviewx_order_review_form_recommendation_text_color'=> '',	
		'reviewx_order_review_form_recommendation_text_font_size'=> '',	

		'reviewx_order_view_review_button_text_color' => '',
		'reviewx_order_view_review_button_font_size' => '',
		'reviewx_order_view_review_button_bg_color' => '',
		'reviewx_order_view_review_button_border_radius' => '',

		'reviewx_order_submit_review_button_text_color' => '',
		'reviewx_order_submit_review_button_font_size' => '',
		'reviewx_order_media_upload_compliance_text_color' => '',
		'reviewx_order_media_upload_compliance_font_size' => '',	
		'reviewx_order_submit_review_button_bg_color' => '',
		'reviewx_order_submit_review_button_border_radius' => '',		
	);
	
	return apply_filters( 'reviewx_option_defaults', $reviewx_defaults );
}
endif;


/**
*  Get default customizer option
*/
if ( ! function_exists( 'reviewx_get_option' ) ) :

	/**
	 * Get default customizer option
	 * @param string $key Option key.
	 * @return mixed Option value.
	 */
	function reviewx_get_option( $key ) {

		$default_options = reviewx_get_option_defaults();

		if ( empty( $key ) ) {
			return;
		}

		$theme_options = (array)get_theme_mods( 'theme_options' );
		$theme_options = wp_parse_args( $theme_options, $default_options );

		$value = null;

		if ( isset( $theme_options[ $key ] ) ) {
			$value = $theme_options[ $key ];
		}

		return $value;
	}

endif;


if( ! function_exists( 'reviewx_generate_defaults' ) ) : 

	function reviewx_generate_defaults(){

		$default_options = reviewx_get_option_defaults();
		$saved_options = get_theme_mods();

		$returned = [];

		if( ! $saved_options ) {
			return;
		}

		foreach( $default_options as $key => $option ) {
			if( array_key_exists( $key, $saved_options ) ) {
				$returned[ $key ] = get_theme_mod( $key );				
			} else {
				switch ( $key ) {
					default:
						$returned[ $key ] = $default_options[ $key ];
						break;
				}
			}
		}

		return $returned;

	}

endif;

if( ! function_exists( 'reviewx_generate_output' ) ) : 

	function reviewx_generate_output(){

		$default_options = reviewx_get_option_defaults();

		$returned = [];
		
		foreach( $default_options as $key => $option ) {
			$returned[ $key ] = get_theme_mod( $key, $option );	
		}

		return $returned;

	}

endif;