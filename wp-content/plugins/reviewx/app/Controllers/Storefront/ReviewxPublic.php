<?php

namespace ReviewX\Controllers\Storefront;

use ReviewX\Controllers\Admin\Core\ReviewxMetaBox;
use ReviewX\Controllers\Admin\Criteria\CriteriaController;
use ReviewX\Controllers\Controller;
use ReviewX\Controllers\Storefront\Modules\ReCaptcha;
use ReviewX\Modules\Gatekeeper;
use ReviewX_Helper;

/**
 * Class ReviewxPublic
 * @package ReviewX\Controllers\Storefront
 */
class ReviewxPublic extends Controller
{

    private $plugin_name;
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @param none
     * @return void
     */
    public function __construct( $plugin_name, $version )
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;

        //temporary attachted
        error_reporting(0);
        add_action( 'comments_template', array( $this, 'reviewx_load_review_template'), 99 );
        add_filter( 'wc_get_template', array( $this, 'reviewx_load_orders_template'), 10, 5 );
        add_filter( 'woocommerce_account_orders_columns', array( $this, 'reviewx_reorder_column_order_table' ) );
        add_filter( 'ajax_query_attachments_args', array( $this, 'reviewx_show_current_user_attachments'), 10, 1 );
        add_action( 'admin_init', array( $this, 'reviewx_allow_user_media') );
        add_action( 'wp_head', array( $this, 'reviewx_apply_custom_css'), 100 );

        // Save review
        add_action( 'wp_ajax_review_submit_from_myorder', array( $this, 'reviewx_submit_from_myorder' ) );
        add_action( 'wp_ajax_nopriv_review_submit_from_myorder', array( $this, 'reviewx_submit_from_myorder' ) );
        add_action( 'wp_ajax_rx_front_end_review_submit', array( $this, 'rx_front_end_review_submit' ) );
        add_action( 'wp_ajax_nopriv_rx_front_end_review_submit', array( $this, 'rx_front_end_review_submit' ) );

        //Frontend rating and recommendation option
        add_action('comment_form_before_fields', array( $this, 'reviewx_comment_rating_field' ) );
        add_action('comment_form_logged_in_after', array( $this, 'reviewx_comment_rating_field' ) );

        //Review Title
        add_action( 'comment_form_after_fields', array( $this, 'reviewx_comment_title' ) );
        add_action( 'comment_form_logged_in_after', array( $this, 'reviewx_comment_title' ) );

        //Upload Image
        add_action( 'comment_form_after_fields', array( $this, 'reviewx_comment_upload_image' ) );
        add_action( 'comment_form_logged_in_after', array( $this, 'reviewx_comment_upload_image' ) );

        //Upload Video
        add_action( 'comment_form_after_fields', array( $this, 'reviewx_comment_upload_video' ) );
        add_action( 'comment_form_logged_in_after', array( $this, 'reviewx_comment_upload_video' ) );

        //reviewx recommendation
        add_action( 'comment_form_after_fields', array( $this, 'reviewx_comment_recommendation' ) );
        add_action( 'comment_form_logged_in_after', array( $this, 'reviewx_comment_recommendation' ) );

        add_action( 'comment_form_after_fields', array( $this, 'reviewx_recaptcha' ) );
        add_action( 'comment_form_logged_in_after', array( $this, 'reviewx_recaptcha' ) );

        add_action( 'comment_form_after_fields', array( $this, 'reviewx_order_id_check' ) );
        add_action( 'comment_form_logged_in_after', array( $this, 'reviewx_order_id_check' ) );

        //Rearrange comment form
        add_filter( 'comment_form_fields', array( $this, 'reviewx_rearrange_comment_field' ) );
        add_filter( 'comment_form_submit_button', array( $this, 'reviewx_anonymouse_field' ), 10, 2 );

        //Save comment meta
        add_filter( 'rx_form_field_image', array( $this, 'reviewx_form_field_image' ) );

        add_filter( 'rx_load_review_graph_template', array( $this, 'reviewx_load_review_graph_template' ) );
        add_filter( 'rx_load_review_templates', array( $this, 'reviewx_load_review_templates' ) );
        add_filter( 'rx_load_product_rating_type', array( $this, 'reviewx_load_product_rating_type' ) );
        add_action( 'comment_form_top', array( $this, 'reviewx_display_before_form' ) );

        add_action( 'wp_ajax_rx_guest_review_image_upload', array( $this, 'reviewx_guest_review_image_upload' ) );
        add_action( 'wp_ajax_nopriv_rx_guest_review_image_upload', array( $this, 'reviewx_guest_review_image_upload' ) );

        add_action( 'wp_ajax_rx_remove_guest_image', array( $this, 'reviewx_remove_guest_image' ) );
        add_action( 'wp_ajax_nopriv_rx_remove_guest_image', array( $this, 'reviewx_remove_guest_image' ) );

        add_shortcode( 'rvx-stats', array( $this, 'reviewx_load_recommendation' ) );
        add_shortcode( 'rvx-summary', array( $this, 'reviewx_load_summary' ) );
        add_shortcode( 'rvx-criteria-graph', array( $this, 'reviewx_load_graph' ) );
        add_shortcode( 'rvx-review-list', array( $this, 'reviewx_load_review_list' ) );
        add_shortcode( 'rvx-star-count', array( $this, 'reviewx_star_count' ) );
        add_shortcode( 'rvx-woo-reviews', array( $this, 'reviewx_woo_reviews' ) );

        add_action( 'wp_loaded', array( $this, 'rx_set_default_gravatar' ) );   
        add_filter( 'woocommerce_order_item_permalink', array( $this, 'modify_product_permalink' ), 10, 2 );
        
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @param none
     * @return void
     */
    public function reviewx_enqueue_styles()
    {
        if( get_option('template') != 'porto' && (class_exists('WooCommerce') && !is_shop()) ){      
            wp_enqueue_style( $this->plugin_name . '-magnific-popup',  esc_url(assets('storefront/css/magnific-popup.css')), array(), $this->version, 'all' );
        }
        wp_enqueue_style( $this->plugin_name,  assets('storefront/css/reviewx-public.css'), array(), $this->version, 'all' );
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @param none
     * @return void
     */
    public function reviewx_enqueue_scripts()
    { 
        $post_id = get_option('woocommerce_myaccount_page_id'); //specify post id here
        if( is_single() || ( class_exists('WooCommerce') && get_the_ID() == $post_id ) ) {
            wp_enqueue_media();
        }
        if( !class_exists('WooCommerce') || (get_option('template') != 'porto' && (class_exists('WooCommerce') && !is_shop())) ){        
            wp_enqueue_script( $this->plugin_name . '-magnific-popup-min-js',  esc_url(assets('storefront/js/jquery.magnific-popup.min.js')), array( 'jquery' ), $this->version, true );
        }
       if ( !class_exists('WooCommerce') || (class_exists('WooCommerce') && !is_shop() ) ) {
            wp_enqueue_script( $this->plugin_name . '-jquery-validate-js',  esc_url(assets('storefront/js/jquery.validate.min.js')), array( 'jquery' ), $this->version, true );
            wp_enqueue_script( $this->plugin_name . '-js',  esc_url(assets('storefront/js/reviewx.js')), array( 'jquery' ), $this->version, true );
            wp_localize_script( 'reviewx-js', 'rx_ajax_data',
                array(
                    'ajax_url' 					=> admin_url('admin-ajax.php'),
                    'ajax_nonce' 				=> wp_create_nonce('special-string'),
                    'rx_review_title_error' 	=> ! empty(get_theme_mod('reviewx_title_validation_label') ) ? get_theme_mod('reviewx_title_validation_label') : __( 'Review title can\'t be empty', 'reviewx' ),
                    'rx_review_text_error' 		=> ! empty(get_theme_mod('reviewx_text_validation_label') ) ? get_theme_mod('reviewx_text_validation_label') : __( 'Review can\'t be empty', 'reviewx' ),
                    'rx_rating_satisfaction' 	=> ! empty(get_theme_mod('reviewx_rate_satisfaction_label') ) ? get_theme_mod('reviewx_rate_satisfaction_label') : __( 'Please rate your satisfaction', 'reviewx' ),
                    'review_success_title'		=> __( 'Success', 'reviewx' ),
                    'review_success_msg'		=> ! empty(get_theme_mod('reviewx_review_success_label') ) ? get_theme_mod('reviewx_review_success_label') : __( 'Your review submitted successfully!', 'reviewx' ),
                    'review_status_msg'		    => '<svg width="18" height="18" viewBox="0 0 1792 1792" class="rx-review-status-notice-i" xmlns="http://www.w3.org/2000/svg"><path d="M1152 1376v-160q0-14-9-23t-23-9h-96v-512q0-14-9-23t-23-9h-320q-14 0-23 9t-9 23v160q0 14 9 23t23 9h96v320h-96q-14 0-23 9t-9 23v160q0 14 9 23t23 9h448q14 0 23-9t9-23zm-128-896v-160q0-14-9-23t-23-9h-192q-14 0-23 9t-9 23v160q0 14 9 23t23 9h192q14 0 23-9t9-23zm640 416q0 209-103 385.5t-279.5 279.5-385.5 103-385.5-103-279.5-279.5-103-385.5 103-385.5 279.5-279.5 385.5-103 385.5 103 279.5 279.5 103 385.5z"/></svg>'.__( ' Your review is awaiting for approval', 'reviewx' ).'',
                    'review_failed_title'		=> __( 'Error', 'reviewx' ),
                    'review_failed_msg'			=> ! empty(get_theme_mod('reviewx_review_failed_label') ) ? get_theme_mod('reviewx_review_failed_label') : __( 'Review submission failed!', 'reviewx' ),                                
                    'already_review_msg'		=> ! empty(get_theme_mod('reviewx_already_given_review_label') ) ? get_theme_mod('reviewx_already_given_review_label') : __( 'This email has already given review on this product', 'reviewx' ),
                    'highlight_button_text'		=> '<span><svg style="height: 15px; vertical-align: middle" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="adjust" class="svg-inline--fa fa-adjust fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M8 256c0 136.966 111.033 248 248 248s248-111.034 248-248S392.966 8 256 8 8 119.033 8 256zm248 184V72c101.705 0 184 82.311 184 184 0 101.705-82.311 184-184 184z"></path></svg> '.__('Highlight', 'reviewx' ).' </span>',
                    'highlight_button_rtext'	=> '<span><svg style="height: 15px; vertical-align: middle; color :#f75677 " aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash" class="svg-inline--fa fa-trash fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM53.2 467a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128H32z"></path></svg> '.__('Remove', 'reviewx' ).'</span>',
                    'reply_to_this_review'		=> ! empty(get_theme_mod('reviewx_reply_to_this_review_label') ) ? get_theme_mod('reviewx_reply_to_this_review_label') : __( 'Reply to this review', 'reviewx' ),
                    'edit_this_reply'	        => ! empty(get_theme_mod('reviewx_edit_this_reply_label') ) ? get_theme_mod('reviewx_edit_this_reply_label') : __( 'Edit this reply', 'reviewx' ),
                    'review_reply'	            => ! empty(get_theme_mod('reviewx_reply_review_label') ) ? get_theme_mod('reviewx_reply_review_label') : __( 'Reply Review', 'reviewx' ),
                    'reply_update'	            => ! empty(get_theme_mod('reviewx_update_button_label') ) ? get_theme_mod('reviewx_update_button_label') : __( 'Update', 'reviewx' ),
                    'review_reply_cancel'	    => ! empty(get_theme_mod('reviewx_cancel_button_label') ) ? get_theme_mod('reviewx_cancel_button_label') : __( 'Cancel', 'reviewx' ),
                    'please_reave_message'      => ! empty(get_theme_mod('reviewx_review_leave_label') ) ? get_theme_mod('reviewx_review_leave_label') : __('Please leave a message', 'reviewx'),
                    'please_enter_title'        => ! empty(get_theme_mod('reviewx_review_title_validation_label') ) ? get_theme_mod('reviewx_review_title_validation_label') : __('Please enter a title', 'reviewx'),
                    'please_enter_email'        => ! empty(get_theme_mod('reviewx_guest_email_validation_label') ) ? get_theme_mod('reviewx_guest_email_validation_label') : __('Please enter a valid email address', 'reviewx'),
                    'please_enter_name'         => ! empty(get_theme_mod('reviewx_guest_name_validation_label') ) ? get_theme_mod('reviewx_guest_name_validation_label') : __('Please enter your name', 'reviewx'),
                    'please_accept_agreement'   => ! empty(get_theme_mod('reviewx_media_upload_compliance_validation') ) ? get_theme_mod('reviewx_media_upload_compliance_validation') : __('Please accept the compliance', 'reviewx'),
                    'theme_name'                => get_option('template'),
                    'rx_max_file_size'		    => __( 'Max file size (5MB) exceeds', 'reviewx' ),                           
                )
            );
        }
    }

    /**
     * Get the order id from current user
     * if who make a order
     *
     * @param none
     * @return void
     */
    public function reviewx_order_id_check()
    {

        if( class_exists( 'WooCommerce' ) && get_post_type( get_the_ID() ) == 'product' ) {
            $settings               = (array) ReviewxMetaBox::get_option_settings();
            $reviewx_order_status   = array();
            $wc_order_statuses      = apply_filters( 'rx_wc_order_status', true );
            foreach( $wc_order_statuses as $key => $value ) {
                if( array_key_exists($key, $settings) && $settings[$key] == 1 ){                    
                   array_push($reviewx_order_status, $key);
                }                
            }   
            
            if(is_user_logged_in()) {
                $customer_user_id 	= get_current_user_id();
                $customer_orders 	= wc_get_orders( array(
                    'meta_key' 		=> '_customer_user',
                    'meta_value' 	=> $customer_user_id,
                    'post_status' 	=> $reviewx_order_status,
                    'numberposts' 	=> -1
                ) );
        
                foreach( $customer_orders as $order ) {
                    foreach( $order->get_items() as $item_id => $item ) {
                        $product_id = method_exists( $item, 'get_product_id' ) ? $item->get_product_id() : $item['product_id'];
                        if( $product_id == get_the_ID() ) {
                            $order_id 	= method_exists( $order, 'get_id' ) ? $order->get_id() : $order->ID;
                            $order 		= wc_get_order( $order_id );
                            $get_product_current_status = $order->get_status();
                            if( in_array($get_product_current_status, $reviewx_order_status) ) {
                                $check_already_reviewed = \ReviewX_Helper::check_already_reviewed( $product_id, get_current_user_id(), $order_id );
                                if( empty( $check_already_reviewed ) ) {
                                    echo "<input type='hidden' name='reviewx_order' value='".esc_attr($order_id)."'>";
                                }
                            }
                        }
                    }
                }
            } else {
                if (isset($_GET[REVIEWX_AUTOLOGIN_VALUE_NAME])) {    
                    $autologin_code = preg_replace('/[^a-zA-Z0-9]+/', '', $_GET[REVIEWX_AUTOLOGIN_VALUE_NAME]);
                    if($autologin_code) {
                        if(strpos($autologin_code, "rxwcorder") !== false) {
                            $rxwcorder  = explode("rxwcorder", $autologin_code);
                            $order_id   = isset($rxwcorder[1])?$rxwcorder[1]: '';
                            $order 		= wc_get_order( $order_id );
                            $get_product_current_status = $order->get_status(); 
                            if( in_array($get_product_current_status, $reviewx_order_status) ) {
                                $check_already_reviewed = \ReviewX_Helper::check_already_reviewed( get_the_ID(), $order->get_billing_email(), $order_id );
                                if( empty( $check_already_reviewed ) ) {
                                    echo "<input type='hidden' name='reviewx_order' value='".esc_attr($order_id)."'>";
                                }
                            }                           
                        }    
                    }
                }
            }

        } else if( class_exists( 'Easy_Digital_Downloads' ) ) {
            if ( is_user_logged_in() ) {

                $user_id 	 = get_current_user_id();
                //Get customer details
                $customer    = new \EDD_Customer( $user_id, true ); 
                $emails      = isset($customer->emails)?$customer->emails:[];
                //Get order id, here is payment id 
                $payment_ids = explode( ',', $customer->payment_ids );
                $user_data   = get_userdata( $user_id );
                
                //Check logged in email is in the order history
                if( in_array($user_data->user_email,  $emails) ) {
                    $payments    = edd_get_payments( array( 'post__in' => $payment_ids ) );
                    $payments    = array_slice( $payments, 0, 10 );

                    foreach( $payment_ids as $payment_id ) {
                        //Retrieve payment history
                        $payment      = new \EDD_Payment( $payment_id );
                        $cart_items   = $payment->cart_details;

                        if ( ! empty( $cart_items ) && is_array( $cart_items ) ) {
                            foreach ( $cart_items as $key => $cart_item ) {
                                $item_id    = isset( $cart_item['id'] ) ? $cart_item['id'] : $cart_item;
                                if( $item_id == get_the_ID() ) {
                                    
                                    $check_already_reviewed = \ReviewX_Helper::check_already_reviewed( get_the_ID(), get_current_user_id(), $payment_id );
                                    if( empty( $check_already_reviewed ) ) {
                                        echo "<input type='hidden' name='reviewx_order' value='".esc_attr($payment_id)."'>";
                                    }                                    
                                    
                                }
                            }
                        }
                    }
                }

            }
        }

    }

    /**
     * Load title and describe area
     *
     * @param none
     * @return void
     */
    public function reviewx_comment_title()
    {    
        $wc_is_enabled = \ReviewX_Helper::check_wc_is_enabled();
        $reviewx_id = \ReviewX_Helper::get_reviewx_post_type_id( get_post_type() );
        if( ( \ReviewX_Helper::check_post_type_availability( get_post_type() ) == TRUE && \ReviewX_Helper::get_post_meta( $reviewx_id, 'allow_review_title' ) == 1 ) || 
            ( get_post_type() == 'product' && \ReviewX_Helper::get_option('allow_review_title')  == 1 && $wc_is_enabled == 1 ) ) { 
            ?>
            <div class="review_title">
                <p>
                    <input type="text" name="reviewx_title" id="review_title" placeholder="<?php esc_attr_e( 'Review title', 'reviewx' ); ?>">
                </p>
            </div>
            <?php
        }

        if( \ReviewX_Helper::check_post_type_availability( get_post_type() ) == TRUE || ( get_post_type() == 'product' && $wc_is_enabled == 1 ) ) { 
        ?>
        <p class="comment-form-comment">
            <textarea id="comment" name="comment" cols="45" rows="8" placeholder="<?php esc_attr_e('Describe your review', 'reviewx' ); ?>"></textarea>
            <input type="hidden" name="rx-post-type" id="rx-post-type" value="<?php echo get_post_type(); ?>">
        </p>
        <?php
        }
    }

    /**
     * Load recommendation
     * in the review form
     *
     * @param none
     * @return void
     */
    public function reviewx_comment_recommendation()
    {
        $wc_is_enabled = \ReviewX_Helper::check_wc_is_enabled();
        $reviewx_id = \ReviewX_Helper::get_reviewx_post_type_id( get_post_type( get_the_ID() ) );
        if( 
            (\ReviewX_Helper::check_post_type_availability( get_post_type( get_the_ID()) ) == TRUE && \ReviewX_Helper::get_post_meta( $reviewx_id, 'allow_recommendation' ) ) || 
            ( get_post_type( get_the_ID() ) == 'product' && \ReviewX_Helper::get_option('allow_recommendation') == 1 && $wc_is_enabled == 1 ) ) { 
            ?>
            <div class="reviewx_recommended">
                <h2 class="reviewx_recommended_title"><?php echo !empty(get_theme_mod('reviewx_form_recommednation_label') ) ? get_theme_mod('reviewx_form_recommednation_label') : __( 'Recommendation:', 'reviewx' ); ?></h2>
                <ul class="reviewx_recommended_list">
                    <li class="reviewx_radio">
                        <input id="recommend" name="is_recommended" value="1" type="radio" checked="checked" >
                        <label for="recommend" class="radio-label happy_face">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                    viewBox="0 0 80 80" style="enable-background:new 0 0 80 80;" xml:space="preserve">
                                    <style type="text/css">
                                        .happy_st0{fill:#D0D6DC;}
                                        .happy_st1{fill:#6d6d6d;}
                                    </style>
                                <g>
                                    <radialGradient id="SVGID_1_" cx="40" cy="40" r="40" gradientUnits="userSpaceOnUse">
                                        <stop  offset="0" style="stop-color:#62E2FF"/>
                                        <stop  offset="0.9581" style="stop-color:#3593FF"/>
                                    </radialGradient>
                                    <path class="happy_st0 rx_happy" d="M40,0C18,0,0,18,0,40c0,22,18,40,40,40s40-18,40-40C80,18,62,0,40,0z M54,24c3.2,0,6,2.8,6,6c0,3.2-2.8,6-6,6
                                        c-3.2,0-6-2.8-6-6C48,26.8,50.8,24,54,24z M26,24c3.2,0,6,2.8,6,6c0,3.2-2.8,6-6,6c-3.2,0-6-2.8-6-6C20,26.8,22.8,24,26,24z M40,64
                                        c-10.4,0-19.2-6.8-22.4-16h44.8C59.2,57.2,50.4,64,40,64z"/>
                                    <path class="happy_st1" d="M54,36c3.2,0,6-2.8,6-6c0-3.2-2.8-6-6-6c-3.2,0-6,2.8-6,6C48,33.2,50.8,36,54,36z"/>
                                    <path class="happy_st1" d="M26,36c3.2,0,6-2.8,6-6c0-3.2-2.8-6-6-6c-3.2,0-6,2.8-6,6C20,33.2,22.8,36,26,36z"/>
                                    <path class="happy_st1" d="M40,64c10.4,0,19.2-6.8,22.4-16H17.6C20.8,57.2,29.6,64,40,64z"/>
                                </g>
                                </svg>
                        </label>
                    </li>
                    <li class="reviewx_radio">
                        <input id="neutral" name="is_recommended" value="0" type="radio">
                        <label for="neutral" class="radio-label neutral_face">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                    viewBox="0 0 80 80" style="enable-background:new 0 0 80 80;" xml:space="preserve">
                                    <style type="text/css">
                                        .st0{fill:#6D6D6D;}
                                        .st1{fill:#D1D7DD;}
                                    </style>
                                <g>
                                    <path class="st0" d="M54,36c3.2,0,6-2.8,6-6c0-3.2-2.8-6-6-6c-3.2,0-6,2.8-6,6C48,33.2,50.8,36,54,36z"/>
                                    <path class="st0" d="M26,36c3.2,0,6-2.8,6-6c0-3.2-2.8-6-6-6c-3.2,0-6,2.8-6,6C20,33.2,22.8,36,26,36z"/>
                                    <path class="st1" d="M40,0C18,0,0,18,0,40c0,22,18,40,40,40s40-18,40-40C80,18,62,0,40,0z M54,24c3.2,0,6,2.8,6,6c0,3.2-2.8,6-6,6
                                        c-3.2,0-6-2.8-6-6C48,26.8,50.8,24,54,24z M26,24c3.2,0,6,2.8,6,6c0,3.2-2.8,6-6,6c-3.2,0-6-2.8-6-6C20,26.8,22.8,24,26,24z"/>
                                    <path class="st0" d="M58.4,57.3H21.6c-0.5,0-0.9-0.4-0.9-0.9v-7.1c0-0.5,0.4-0.9,0.9-0.9h36.8c0.5,0,0.9,0.4,0.9,0.9v7.1
                                        C59.3,56.9,58.9,57.3,58.4,57.3z"/>
                                </g>
                                </svg>
                        </label>
                    </li>
                    <li class="reviewx_radio">
                        <input id="not_recommend" name="is_recommended" value="0" type="radio">
                        <label for="not_recommend" class="radio-label sad_face">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                    viewBox="0 0 80 80" style="enable-background:new 0 0 80 80;" xml:space="preserve">
                                    <style type="text/css">
                                        .st0{fill:#6D6D6D;}
                                        .st1{fill:#D1D7DD;}
                                    </style>
                                <g>
                                    <path class="st0" d="M54,36c3.2,0,6-2.8,6-6c0-3.2-2.8-6-6-6c-3.2,0-6,2.8-6,6C48,33.2,50.8,36,54,36z"/>
                                    <path class="st0" d="M26,36c3.2,0,6-2.8,6-6c0-3.2-2.8-6-6-6c-3.2,0-6,2.8-6,6C20,33.2,22.8,36,26,36z"/>
                                    <path class="st1" d="M40,0C18,0,0,18,0,40c0,22,18,40,40,40s40-18,40-40C80,18,62,0,40,0z M54,24c3.2,0,6,2.8,6,6c0,3.2-2.8,6-6,6
                                        c-3.2,0-6-2.8-6-6C48,26.8,50.8,24,54,24z M26,24c3.2,0,6,2.8,6,6c0,3.2-2.8,6-6,6c-3.2,0-6-2.8-6-6C20,26.8,22.8,24,26,24z"/>
                                    <path class="st0" d="M40,42.8c-9.5,0-17.5,6.2-20.4,14.6h40.8C57.5,49,49.5,42.8,40,42.8z"/>
                                </g>
                                </svg>
                        </label>
                    </li>
                </ul>
            </div>
            <?php
        }

    }

    public function reviewx_recaptcha() {
        $wc_is_enabled = \ReviewX_Helper::check_wc_is_enabled();
        if( \ReviewX_Helper::check_post_type_availability( get_post_type() ) == TRUE || ( get_post_type() == 'product' && $wc_is_enabled == 1 ) ) {
       ?> 
       <div class="form-group">
           <?php echo \ReviewX\Controllers\Storefront\Modules\ReCaptcha::showField(); ?>                
       </div>
       <?php
        }
    }

    /**
     * Upload image
     *
     * @param none
     * @return void
     */    
    public function reviewx_comment_upload_image()
    {
        $wc_is_enabled = \ReviewX_Helper::check_wc_is_enabled();
        $reviewx_id = \ReviewX_Helper::get_reviewx_post_type_id( get_post_type() );
        if( (\ReviewX_Helper::check_post_type_availability( get_post_type() ) == TRUE && \ReviewX_Helper::get_post_meta( $reviewx_id, 'allow_img' ) == 1 ) || 
            ( get_post_type() == 'product' && \ReviewX_Helper::get_option('allow_img') == 1 && $wc_is_enabled == 1 ) ) { 
            if( is_user_logged_in() ) {

                echo '<div class="form-group">
                        <div class="rx-images rx-flex-grid-100" id="rx-images">
                            <p class="rx-comment-form-attachment">
                                <label class="rx_upload_file rx-form-btn">
                                <input id="attachment" name="attachment" type="button" '.apply_filters( 'rx_multiple_image_upload', 1 ).'/>
                                <img src="'.esc_url( assets('storefront/images/image.svg') ).'" class="img-fluid">
                                <span>'.esc_html__( 'Upload images', 'reviewx' ).'</span>
                                </label>
                            </p>                            
                        </div>	                       
                    </div>';
            
            } else {
                
                echo '<div class="form-group">
                        <div class="rx-images rx-flex-grid-100" id="rx-images">
                            <div class="rx_content_loader">
                                <div class="rx_image_upload_spinner">
                                    <div></div>
                                    <div>
                                        <div></div>
                                    </div>
                                </div>
                            </div>                        
                            <p class="rx-comment-form-attachment">
                                <label class="rx_upload_file rx-form-btn">
                                <input id="non-logged-attachment" name="non-logged-attachment[]" accept = "image/*" type="file" '.apply_filters( 'rx_multiple_image_upload', 2 ).'/>
                                <img src="'.esc_url( assets('storefront/images/image.svg') ).'" class="img-fluid">
                                <span>'.esc_html__( 'Upload images', 'reviewx' ).'</span>
                                </label>
                            </p>
                            <p class="rx-guest-attachment-error"></p>                                                        
                        </div>	                       
                    </div>';
            }
            
        }
    }

    /**
     * Upload video
     *
     * @param none
     * @return void
     */
    public function reviewx_comment_upload_video()
    {
        $wc_is_enabled = \ReviewX_Helper::check_wc_is_enabled();
        $anony_data = $allow_img_data  = $allow_video_data = array();
        if( get_post_type() == 'product' && $wc_is_enabled == 1 ) {
            $allow_video_data['is_allow_video']   = \ReviewX_Helper::get_option( 'allow_video' );
            $allow_video_data['video_source']     = \ReviewX_Helper::get_option( 'video_source' );
            $allow_video_data['signature']        = 3;
            apply_filters( 'rx_allow_video_url', $allow_video_data );

        } else if( \ReviewX_Helper::check_post_type_availability( get_post_type() ) == TRUE ) {

            $reviewx_id                           = \ReviewX_Helper::get_reviewx_post_type_id( get_post_type() );                               
            $allow_video_data['is_allow_video']   = \ReviewX_Helper::get_post_meta( $reviewx_id, 'allow_video' );  
            $allow_video_data['video_source']     = \ReviewX_Helper::get_post_meta( $reviewx_id, 'video_source' );  
            $allow_video_data['signature']        = 3;
            apply_filters( 'rx_allow_video_url', $allow_video_data );

        }
    }

    /**
     * View rating and recommendation
     * @param $fields
     */
    public function reviewx_comment_rating_field( $fields )
    {
        $wc_is_enabled = \ReviewX_Helper::check_wc_is_enabled();
        if( \ReviewX_Helper::check_post_type_availability( get_post_type() ) == TRUE ) {
            $reviewx_id 				= \ReviewX_Helper::get_reviewx_post_type_id( get_post_type() );
            $settings                   = ReviewxMetaBox::get_metabox_settings( $reviewx_id );
            ?>
            <div class="product-review-tab">
                <div class="add_your_review">
                    <div class="reviewx-rating">
                        <table class="rx-criteria-table reviewx-rating">
                            <tbody>
                            <?php
                            echo apply_filters( 'rx_load_product_rating_type', $settings );
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                    ?>
                </div>
            </div>
            <?php            
        } else if( get_post_type() == 'product' && $wc_is_enabled == 1 ) {
            $settings 				= ReviewxMetaBox::get_option_settings();
            ?>
            <div class="product-review-tab">
                <div class="add_your_review">
                    <div class="reviewx-rating">
                        <table class="rx-criteria-table reviewx-rating">
                            <tbody>
                            <?php
                            echo apply_filters( 'rx_load_product_rating_type', $settings );
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                    ?>
                </div>
            </div>
            <?php            
        }
    }

    /**
     * Rearrange fields in comment form
     *
     * @param $fields
     * @return mixed
     */
    public function reviewx_rearrange_comment_field( $fields )
    {
        $wc_is_enabled = \ReviewX_Helper::check_wc_is_enabled();
        if( \ReviewX_Helper::check_post_type_availability( get_post_type() ) == TRUE || ( get_post_type() == 'product' && $wc_is_enabled == 1 ) ) {
            unset( $fields['comment'] );
            unset( $fields['cookies'] );
        }
        
        return $fields;

    }    

    /**
     * Reorder column in order table
     *
     * @param array
     * @return array
     *
     */
    public function reviewx_reorder_column_order_table( $columns = array() )
    {

        if( isset($columns['order-total']) ) {
            // Unsets the columns which you want to hide
            unset( $columns['order-number'] );
            unset( $columns['order-date'] );
            unset( $columns['order-status'] );
            unset( $columns['order-total'] );
            unset( $columns['order-actions'] );
        }

        // Add new columns
        $columns['order-number'] 	= __( 'Order', 'reviewx' );
        $columns['order-date'] 		= __( 'Date', 'reviewx' );
        $columns['order-image'] 	= __( 'Image', 'reviewx' );
        $columns['order-name'] 		= __( 'Product', 'reviewx' );
        $columns['order-price'] 	= __( 'Price', 'reviewx' );
        $columns['order-status'] 	= __( 'Status', 'reviewx' );
        $columns['order-actions']   = __( 'Action', 'reviewx' );
        return $columns;
    }

    /**
     * Load custom order table
     * @param $located
     * @param $template_name
     * @param $args
     * @param $template_path
     * @param $default_path
     * @return string
     */
    public function reviewx_load_orders_template( $located, $template_name, $args, $template_path, $default_path )
    {
        $wc_is_enabled = \ReviewX_Helper::check_wc_is_enabled();
        if ( 'myaccount/orders.php' == $template_name && $wc_is_enabled == 1 ) {
            $located = REVIEWX_PARTIALS_PATH . 'storefront/myaccount/order-table.php';
        }
        return $located;
    }

    /**
     * Load custom review template
     *
     * @param $default_template
     * @return mixed|void
     */
    public function reviewx_load_review_template( $default_template )
    {
        $wc_is_enabled = \ReviewX_Helper::check_wc_is_enabled();
        if( is_singular( 'product'  ) && $wc_is_enabled == 1 ) {
            $custom_template    = apply_filters( 'rx_review_template_file', REVIEWX_PARTIALS_PATH . 'storefront/product-reviews.php' );
            return ! empty( $custom_template ) && file_exists( $custom_template ) ? $custom_template : $default_template;
        } else if( \ReviewX_Helper::check_post_type_availability( get_post_type() ) == TRUE ){
            $custom_template    = apply_filters( 'rx_review_template_file', REVIEWX_PARTIALS_PATH . 'storefront/product-reviews.php' );
            return ! empty( $custom_template ) && file_exists( $custom_template ) ? $custom_template : $default_template;
        } else {
            return $default_template; 
        }
    }

    /**
     * Allow upload media this specific user
     *
     */
    public function reviewx_allow_user_media()
    {
        global $wp_roles;
        $roles = $wp_roles->get_names();
        $create_role_names = array('administrator', 'editor', 'author', 'contributor', 'subscriber', 'customer', 'shop_manager');
        foreach ( $create_role_names as $create_role_name ) {
            if( array_key_exists( $create_role_name, $roles) ) {
                $customer = get_role( $create_role_name );
                $customer->add_cap('upload_files');
            }
        }

    }

    /**
     * For show current user attachment
     *
     * @param array $query
     * @return array
     */
    public function reviewx_show_current_user_attachments( $query = array() )
    {
        $user_id = get_current_user_id();
        if( $user_id && !current_user_can('manage_options') ) {
            $query['author'] = $user_id;
        }
        return $query;

    }

    /**
     * Get review criteria from admin setting
     *
     * @param array $postdata
     * @return void
     **/
    public function reviewx_get_review_criteria( $postdata = array(), $post_type )
    {

        $data 						= array();
        if( \ReviewX_Helper::check_post_type_availability( $post_type ) == TRUE ) {
           $reviewx_id       = \ReviewX_Helper::get_reviewx_post_type_id( $post_type );   
           $settings         = ReviewxMetaBox::get_metabox_settings( $reviewx_id );  
           $review_criteria  = $settings->review_criteria;             
        } else {
            $settings 	     = ReviewxMetaBox::get_option_settings();
            $review_criteria = $settings->review_criteria;
        }

        if( ( is_array($postdata) && count($postdata ) > 0 ) && ( is_array($review_criteria) && count($review_criteria) > 0 ) ):
            for( $i=0; $i<count($postdata); $i++ ):
                if( array_key_exists( $postdata[$i]['name'], $review_criteria ) ):
                    $data[$postdata[$i]['name']] = $postdata[$i]['value'];
                endif;
            endfor;
        endif;
        return $data;

    }

    /**
     * Save comment in comment table
     *
     * @param array
     * @return void
     **/
    public function reviewx_submit_from_myorder()
    {

        global $wpdb;
        check_ajax_referer( 'special-string', 'security' );
        $attachments = $photos 	= array();
        $review_status = 0;
        $prod_id = $order_id = $recommend_status = $reviewx_title = $default_rating = '';
        $rx_review_text 		= sanitize_textarea_field($_POST['rx_review_text']);
        $forminput 				= wp_unslash($_POST['forminput']);
        $current_user           = wp_get_current_user();
        $comment_agent          = $_SERVER['HTTP_USER_AGENT'];
        $total_rating_sum 		= 0;

        for( $i=0; $i < count($forminput); $i++ ) {
            if( $forminput[$i]['name'] == "rx-user-id" ):
                $user_id = sanitize_text_field($forminput[$i]['value']);
            endif;

            if( $forminput[$i]['name'] == "rx-order-id" ):
                $order_id = sanitize_text_field($forminput[$i]['value']);
            endif;

            if( $forminput[$i]['name'] == "rx-product-id" ):
                $prod_id = sanitize_text_field($forminput[$i]['value']);
            endif;

            if( $forminput[$i]['name'] == "rx-image" ):
                array_push( $photos, sanitize_text_field($forminput[$i]['value']) );
            endif;

            if( $forminput[$i]['name'] == "reviewx_title" ):
                $reviewx_title = sanitize_text_field($forminput[$i]['value']);
            endif;

            if( $forminput[$i]['name'] == "rx-recommend-status" ):
                $recommend_status = sanitize_text_field($forminput[$i]['value']);
            endif;

            if( $forminput[$i]['name'] == "rx-default-star" ):
                $default_rating = sanitize_text_field($forminput[$i]['value']);
            endif;

        }

        $attachments['images'] 		    = $photos;
        $criteria 					    = array();
        if( \ReviewX_Helper::is_multi_criteria('product') ) {
            $criteria 					= $this->reviewx_get_review_criteria($forminput, 'product');
            $total_rating_sum 			= array_sum(array_values($criteria));
            $rating 					= round( $total_rating_sum/count($criteria) );
        } else {
            $criteria 					= \ReviewX_Helper::set_criteria_default_rating($default_rating, 'product');
            $rating 					= $default_rating; 
        }

        $auto_approval 		        = get_option('_rx_option_disable_auto_approval');   
        $allow_review_title 		= get_option('_rx_option_allow_review_title');      
        if( $auto_approval == 1 ) {
            $review_status = 1;
        }

        $comment_data = array(
            'comment_post_ID'      => (int)$prod_id,
            'comment_author'       => $current_user->display_name,
            'comment_author_email' => $current_user->user_email,
            'comment_author_url'   => '',
            'comment_author_IP'    => $_SERVER['REMOTE_ADDR'],
            'comment_date'         => date( 'Y-m-d H:i:s' ),
            'comment_date_gmt'     => date( 'Y-m-d H:i:s' ),
            'comment_content'      => $rx_review_text,
            'comment_karma'        => '',
            'comment_agent'        => $comment_agent,
            'comment_type'         => 'review',
            'comment_parent'       => '',
            'user_id'              => $current_user->ID,
        );

        $id = wp_new_comment($comment_data);

        if( $id ) {
          
            $ratingOption = get_option('_rx_product_' . $prod_id . '_rating') ? : [];
            $criData = [];
            foreach ($criteria as $key => $value) {
                $criData[$key] = _get($ratingOption[$key], 0) + $value;
            }
            update_option('_rx_product_' . $prod_id . '_rating', array_merge([
                'total_review' =>  _get($ratingOption['total_review'], 0) + 1,
                'total_rating' =>  _get($ratingOption['total_rating'], 0) + $rating
            ], $criData));

            // Save comment extra data
            $posts = array(
                'comment_id' 	=> $id,
                'post_data' 	=> wp_unslash($_POST['forminput']),
                'signature'		=> 1
            );
            apply_filters( 'rx_save_extra_post_data', $posts );

            add_comment_meta( $id, 'rating', $rating, false );
            add_comment_meta( $id, 'reviewx_rating', $criteria, false );
            add_comment_meta( $id, 'reviewx_recommended', $recommend_status, false );
            if( !empty( $order_id ) ) {
                add_comment_meta( $id, 'reviewx_order', $order_id, false );
                update_comment_meta( $id, 'verified', 1, false );
            } else {
                update_comment_meta( $id, 'verified', 0, false );
            }   

            // Check review title is enabled
            if( $allow_review_title == 1 ){
                add_comment_meta( $id, 'reviewx_title', $reviewx_title, false );
            }

            if( !empty( $attachments['images'] ) ) {
                add_comment_meta( $id, 'reviewx_attachments', $attachments, false );
            }

            $comment_table = $wpdb->prefix . 'comments';
            $wpdb->update( $comment_table, array( 'comment_approved' => $review_status ), array( 'comment_ID' => $id ), array( '%s' ), array( '%d' ) );

            if ( $prod_id ) {
                self::clear_transients( $prod_id );
            } 
            
            (new CriteriaController())->storeCriteria($id, $criteria);
            Gatekeeper::setLogForUser($prod_id, $order_id, $id);        
    
            /*=============================================
            *
            * Check WooCommerce Loyalty Points and Rewards plugin
            * is exists
            *
            ==============================================*/
            if( is_plugin_active( 'loyalty-points-rewards/wp-loyalty-points-rewards.php' ) ) {
                $this->product_review_action($id, 1);
            }

        }        
        
        $success_status = ($id) ? true : false;

        $return = array(
            'success' => $success_status,
            'status'  => $review_status 
        );
        
        wp_send_json($return);

    }
    
    /**
     * Front-end AJAX review from submit
     * @throws \WpFluent\Exception
     */
    public function rx_front_end_review_submit()
    {

        global $wpdb;
        check_ajax_referer( 'special-string', 'security' );
        $attachments = $photos 	= array();
        $review_status = 0; 
        $prod_id = $order_id = $review_title = $recommend_status = $user_id = $author = $email = $default_rating = $post_type = '';
        $user_id = 0;
        $review_text 				= sanitize_textarea_field($_POST['rx_review_text']);
        $forminput 					= wp_unslash($_POST['formInput']);        

        $comment_agent          	= $_SERVER['HTTP_USER_AGENT'];
        $total_rating_sum 		    = 0;

        if( is_user_logged_in() ) {
            $current_user           = wp_get_current_user();
            $author 				= $current_user->display_name;
            $email 					= $current_user->user_email;
            $user_id 				= $current_user->ID;
        }

        $reCaptcha = new ReCaptcha();

        for( $i=0; $i < count($forminput); $i++ ) {

            if( $forminput[$i]['name'] == "author" ):
                $author = sanitize_text_field($forminput[$i]['value']);
            endif;

            if( $forminput[$i]['name'] == "email" ):
                $email = sanitize_text_field($forminput[$i]['value']);
            endif;

            if( $forminput[$i]['name'] == "reviewx_order" ):
                $order_id = sanitize_text_field($forminput[$i]['value']);
            endif;

            if( $forminput[$i]['name'] == "comment_post_ID" ):
                $prod_id = absint(sanitize_text_field($forminput[$i]['value']));
            endif;

            if( $forminput[$i]['name'] == "reviewx_title" ):
                $review_title = sanitize_text_field($forminput[$i]['value']);
            endif;

            if( $forminput[$i]['name'] == "rx-image[]" ):
                array_push( $photos, sanitize_text_field($forminput[$i]['value']) );
            endif;

            if( $forminput[$i]['name'] == "is_recommended" ):
                $recommend_status = sanitize_text_field($forminput[$i]['value']);
            endif;

            if( $forminput[$i]['name'] == "rx-default-star" ):
                $default_rating = sanitize_text_field($forminput[$i]['value']);
            endif;

            if( $forminput[$i]['name'] == "rx-post-type" ):
                $post_type = sanitize_text_field($forminput[$i]['value']);
            endif;                        
            
            if (ReCaptcha::isEnable()) {
                if( $forminput[$i]['name'] == "recaptcha-token" ):
                    $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($reCaptcha->getSecretKey()) .  '&response=' . urlencode($forminput[$i]['value']);
                    $response = file_get_contents($url);
                    $responseKeys = json_decode($response,true);
                    if (! $responseKeys['success']) {
                        wp_send_json(array(
                            'success' => 0,
                            'status'  => false
                        ));
                    }
                endif;
            }
        }

        $attachments['images'] 		= $photos;
        $criteria 					= array();
        if( \ReviewX_Helper::is_multi_criteria( $post_type ) ) {
            $criteria 				= $this->reviewx_get_review_criteria($forminput, $post_type);
            $total_rating_sum 		= array_sum(array_values($criteria));
            $rating 				= round( $total_rating_sum/count($criteria) );
        } else {
            $criteria 				= \ReviewX_Helper::set_criteria_default_rating($default_rating, $post_type);
            $rating 				= round($default_rating); 
        }

        if( \ReviewX_Helper::check_post_type_availability( $post_type ) == TRUE ) {
            $reviewx_id             = \ReviewX_Helper::get_reviewx_post_type_id( $post_type );
            $settings               = ReviewxMetaBox::get_metabox_settings( $reviewx_id );
            $allow_title 	        = \ReviewX_Helper::get_post_meta( $reviewx_id, 'allow_review_title', true );
            if( class_exists('ReviewXPro') ) {
                $auto_approval 		= $settings->disable_auto_approval;
            } else {
                $auto_approval      = 1;
            }   
        } else {
            $allow_title 	        = \ReviewX_Helper::get_option( 'allow_review_title' );   
            $auto_approval 		    = \ReviewX_Helper::get_option( 'disable_auto_approval' );  
        }

        if( $auto_approval == 1 ) {
            $review_status = 1;
        }
        
        $comment_data = array(
            'comment_post_ID'      => absint($prod_id),
            'comment_author'       => $author,
            'comment_author_email' => $email,
            'comment_author_url'   => '',
            'comment_author_IP'    => $_SERVER['REMOTE_ADDR'],
            'comment_date'         => date( 'Y-m-d H:i:s' ),
            'comment_date_gmt'     => date( 'Y-m-d H:i:s' ),
            'comment_content'      => $review_text,
            'comment_karma'        => '',
            'comment_agent'        => $comment_agent,
            'comment_type'         => 'review',
            'comment_parent'       => '',
            'user_id'              => $user_id,
        );

        $id = wp_new_comment($comment_data);

        if( $id ) {

            $ratingOption = get_option('_rx_product_' . $prod_id . '_rating') ? : [];
            $criData = [];
            foreach ($criteria as $key => $value) {
                $criData[$key] = _get($ratingOption[$key], 0) + $value;
            }
            update_option('_rx_product_' . $prod_id . '_rating', array_merge([
                'total_review' =>  _get($ratingOption['total_review'], 0) + 1,
                'total_rating' =>  _get($ratingOption['total_rating'], 0) + $rating
            ], $criData));
    
            // Save comment extra data
            $posts = array(
                'comment_id' 	=> $id,
                'post_data' 	=> wp_unslash($_POST['formInput']),
                'signature'		=> 1
            );
            apply_filters( 'rx_save_extra_post_data', $posts );
    
            add_comment_meta( $id, 'rating', $rating, false );
            add_comment_meta( $id, 'reviewx_rating', $criteria, false );
            add_comment_meta( $id, 'reviewx_recommended', $recommend_status, false );
            if( !empty( $order_id ) ) {
                add_comment_meta( $id, 'reviewx_order', $order_id, false );
                update_comment_meta( $id, 'verified', 1, false );
            } else {

                if( \ReviewX_Helper::check_guest_purchase_verified_badge($email, $prod_id) ){
                    update_comment_meta( $id, 'verified', 1, false );
                } else {
                    update_comment_meta( $id, 'verified', 0, false );
                }
                
            }  
    
            // Check review title is enabled
            if( $allow_title == 1 ) {
                add_comment_meta( $id, 'reviewx_title', $review_title, false );
            }      
            
            if( !empty( $attachments['images'] ) ) {
                add_comment_meta( $id, 'reviewx_attachments', $attachments, false );
            }

            $comment_table = $wpdb->prefix . 'comments';
            $wpdb->update( $comment_table, array( 'comment_approved' => $review_status ), array( 'comment_ID' => $id ), array( '%s' ), array( '%d' ) );

            if ( $prod_id ) {
                self::clear_transients( $prod_id );
            } 

            (new CriteriaController())->storeCriteria($id, $criteria);
            Gatekeeper::setLogForUser($comment_data['comment_post_ID'], false, $id);
    
            /*=============================================
            *
            * Check WooCommerce Loyalty Points and Rewards plugin
            * is exists
            *
            ==============================================*/
            if( is_plugin_active( 'loyalty-points-rewards/wp-loyalty-points-rewards.php' ) ) {
                $this->product_review_action($id, 1);
            }

        }

        $success_status = ($id) ? true : false;
        $return = array(
            'success' => $success_status,
            'status'  => $review_status
        );
        
        wp_send_json($return);
    }

	/**
	 * Ensure product average rating and review count is kept up to date.
	 *
	 * @param int $post_id Post ID.
	 */
	public static function clear_transients( $prod_id ) {
            
		if ( 'product' === get_post_type( $prod_id ) ) {
            
			$product = wc_get_product( $prod_id );
			$product->set_rating_counts( \ReviewX_Helper::get_rating_counts_for_product( $prod_id ) );
            $product->set_average_rating( \ReviewX_Helper::get_average_rating_for_product( $prod_id ) );
			$product->set_review_count( \ReviewX_Helper::get_review_count_for_product( $prod_id ) );
            $product->save();
            update_post_meta( $prod_id, '_wc_average_rating', \ReviewX_Helper::get_average_rating_for_product( $prod_id ) );
        }
        
	}    

    /**
     * Include custom css file for dynamic style
     *
     * @param none
     * @return void
     **/
    public function reviewx_apply_custom_css()
    {
        include_once REVIEWX_PARTIALS_PATH . 'storefront/reviewx-custom-css.php';
    }

    /**
     * Add image upload button
     *
     * @param array
     * @return void
     **/
    public function reviewx_form_field_image( $data )
    {
        $echo = '';
        if( is_array($data) && isset( $data['is_allow_img'] ) && 1 == $data['is_allow_img'] ) {
            if( $data['signature'] == 1 ) {
                $echo .= '<div class="rx-images" id="rx-images">';
                $echo .= '<div class="rx-comment-form-attachment">';
                $echo .= '<label class="rx_upload_file rx-form-btn" for="rx-upload-photo">';
                $echo .= '<input name="rx-upload-photo" id="rx-upload-photo" class="submit rx-form-btn rx-form-primary-btn rv-btn" value="'.__( 'Upload image', 'reviewx' ).'" type="button">';
                $echo .= '<img src="'.esc_url( plugins_url( '/', __FILE__ ) . '../../../resources/assets/storefront/images/image.svg' ).'" class="img-fluid">';
                $echo .= '<span>'.__( 'Upload image', 'reviewx' ).'</span>';
                $echo .= '</label>';
                $echo .= '</div>';
                $echo .='</div>';
            } else if( $data['signature'] == 2 ) {

            }
        }
        echo $echo;
    }

    /**
     * Load graph template
     *
     * @param none
     * @return void
     **/
    public function reviewx_load_review_graph_template()
    {
        if( ! class_exists('ReviewXPro') ) {
            $divi_settings = get_post_meta( get_the_ID(), '_rx_option_divi_settings', true );
            if( (\ReviewX_Helper::reviewx_check_divi_active() && $divi_settings['rvx_review_summary'] == 'on') ){
                (new \ReviewX\Controllers\Storefront\GraphTemplateLoader())->loadView();
            } else if ( isset($reviewx_shortcode) && $reviewx_shortcode['rx_graph'] !='off' )  {
                (new \ReviewX\Controllers\Storefront\GraphTemplateLoader())->loadView();
            } else {
                if( !\ReviewX_Helper::reviewx_check_divi_active() && !isset($reviewx_shortcode) ) {
                    (new \ReviewX\Controllers\Storefront\GraphTemplateLoader())->loadView();
                }             
            }                
        }
    }

    /**
     * Load review template
     *
     * @param array
     * @return void
     **/
    public function reviewx_load_review_templates( $data )
    {

        global $reviewx_shortcode;

        if( ! class_exists('ReviewXPro') ) {

            if( get_post_type( get_the_ID() ) == 'product' ) {
                $settings 	     = ReviewxMetaBox::get_option_settings();
                $template_style  = $settings->template_style;
            } else if( \ReviewX_Helper::check_post_type_availability( get_post_type( get_the_ID() ) ) == TRUE ) {
               $reviewx_id       = \ReviewX_Helper::get_reviewx_post_type_id( get_post_type( get_the_ID() ) );   
               $settings         = ReviewxMetaBox::get_metabox_settings( $reviewx_id );  
               $template_style   = $settings->template_style;            
            }

            $rx_elementor_controller  = apply_filters( 'rx_load_elementor_style_controller', '' );
            $rx_elementor_template    = isset($rx_elementor_controller['rx_template_type']) ? $rx_elementor_controller['rx_template_type'] : null;

            $rx_oxygen_controller     = apply_filters( 'rx_load_oxygen_style_controller', '' );
            $rx_oxygen_template       = isset($rx_oxygen_controller['rx_template_type']) ? $rx_oxygen_controller['rx_template_type'] : null;

            $divi_settings = get_post_meta( get_the_ID(), '_rx_option_divi_settings', true );

            //Check elementor template
            if( ! empty($rx_elementor_template) ) {

                switch ( $rx_elementor_template ) {
                    case "template_style_two":
                        include REVIEWX_PARTIALS_PATH . 'storefront/single-review/style-two.php';
                        break;
                    default:
                        include REVIEWX_PARTIALS_PATH . 'storefront/single-review/style-one.php';
                }

            } else if( ! empty($rx_oxygen_template) ) {                

                switch ( $rx_oxygen_template ) {
                    case "box":
                        include REVIEWX_PARTIALS_PATH . 'storefront/single-review/style-two.php';
                        break;
                    default:
                        include REVIEWX_PARTIALS_PATH . 'storefront/single-review/style-one.php';
                }

            } else if( \ReviewX_Helper::reviewx_check_divi_active() ) {
                //Divi

                switch ( $divi_settings['rvx_template_type'] ) {
                    case "template_style_two":
                        include REVIEWX_PARTIALS_PATH . 'storefront/single-review/style-two.php';
                        break;
                    default:
                        include REVIEWX_PARTIALS_PATH . 'storefront/single-review/style-one.php';
                }                

            } else {

                //Serve local template
                switch ( $template_style ) {
                    case "template_style_two":
                        include REVIEWX_PARTIALS_PATH . 'storefront/single-review/style-two.php';
                        break;
                    default:
                        include REVIEWX_PARTIALS_PATH . 'storefront/single-review/style-one.php';
                }

            }

        }

    }

    /**
     * Load product rating
     *
     * @param array
     * @return void
     **/
    public function reviewx_load_product_rating_type( $data )
    {

        if( ! class_exists('ReviewXPro') ) {

            if( \ReviewX_Helper::check_post_type_availability( get_post_type() ) == TRUE ) {
               $reviewx_id       = \ReviewX_Helper::get_reviewx_post_type_id( get_post_type() );   
               $settings         = ReviewxMetaBox::get_metabox_settings( $reviewx_id );  
               $review_criteria  = $settings->review_criteria;             
            } else {
                $settings 	     = ReviewxMetaBox::get_option_settings();
                $review_criteria = $settings->review_criteria;
            }

            if( \ReviewX_Helper::is_multi_criteria( get_post_type() ) ) {
                foreach ( $review_criteria as $key => $value ) {
                    ?>
                    <tr>
                        <td><?php echo esc_html( $value ); ?></td>
                        <td>
                            <div class="reviewx-star-rating rx-star-<?php echo esc_attr( $key ); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                    <symbol id="rx_starIcon" viewBox="0 0 24 24">
                                        <polygon points="12,0 15.708,7.514 24,8.718 18,14.566 19.416,22.825 12,18.926 4.583,22.825 6,14.566 0,8.718 8.292,7.514"/>
                                    </symbol>
                                </svg>
                                <fieldset class="rx_star_rating">
                                    <input type="radio" id="<?php echo esc_attr( $key ); ?>-star5" name="<?php echo esc_attr( $key ); ?>" value="5" checked="checked"/>
                                    <label for="<?php echo esc_attr( $key ); ?>-star5" title="<?php esc_attr_e('Outstanding', 'reviewx' ); ?>">
                                        <svg class="icon icon-star">
                                            <use xlink:href="#rx_starIcon" />
                                        </svg>
                                    </label>
                                    <input type="radio" id="<?php echo esc_attr( $key ); ?>-star4" name="<?php echo esc_attr( $key ); ?>" value="4" />
                                    <label for="<?php echo esc_attr( $key ); ?>-star4" title="<?php esc_attr_e('Very Good', 'reviewx' ); ?>">
                                        <svg class="icon icon-star">
                                            <use xlink:href="#rx_starIcon" />
                                        </svg>
                                    </label>
                                    <input type="radio" id="<?php echo esc_attr( $key ); ?>-star3" name="<?php echo esc_attr( $key ); ?>" value="3" />
                                    <label for="<?php echo esc_attr( $key ); ?>-star3" title="<?php esc_attr_e('Good', 'reviewx' ); ?>">
                                        <svg class="icon icon-star">
                                            <use xlink:href="#rx_starIcon" />
                                        </svg>
                                    </label>
                                    <input type="radio" id="<?php echo esc_attr( $key ); ?>-star2" name="<?php echo esc_attr( $key ); ?>" value="2" />
                                    <label for="<?php echo esc_attr( $key ); ?>-star2" title="<?php esc_attr_e('Poor', 'reviewx' ); ?>">
                                        <svg class="icon icon-star">
                                            <use xlink:href="#rx_starIcon" />
                                        </svg>
                                    </label>
                                    <input type="radio" id="<?php echo esc_attr( $key ); ?>-star1" name="<?php echo esc_attr( $key ); ?>" value="1" />
                                    <label for="<?php echo esc_attr( $key ); ?>-star1" title="<?php esc_attr_e('Very Poor', 'reviewx' ); ?>">
                                        <svg class="icon icon-star">
                                            <use xlink:href="#rx_starIcon" />
                                        </svg>
                                    </label>
                                </fieldset>
                            </div>

                            <script type="application/javascript">
                                jQuery(document).ready(function () {
                                    jQuery('.rx-star-<?php echo $key; ?> input').change(function () {
                                        let radio = jQuery(this);
                                        jQuery(this).attr('checked', true);
                                    });
                                });
                            </script>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td></td>
                    <td>
                        <div class="reviewx-star-rating rx-star-default">
                            <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                <symbol id="rx_starIcon" viewBox="0 0 24 24">
                                    <polygon points="12,0 15.708,7.514 24,8.718 18,14.566 19.416,22.825 12,18.926 4.583,22.825 6,14.566 0,8.718 8.292,7.514"/>
                                </symbol>
                            </svg>
                            <fieldset class="rx_star_rating">
                                <input type="radio" id="rx-default-star5" name="rx-default-star" value="5" checked="checked"/>
                                <label for="rx-default-star5" title="<?php esc_attr_e('Outstanding', 'reviewx' ); ?>">
                                    <svg class="icon icon-star">
                                        <use xlink:href="#rx_starIcon" />
                                    </svg>
                                </label>
                                <input type="radio" id="rx-default-star4" name="rx-default-star" value="4" />
                                <label for="rx-default-star4" title="<?php esc_attr_e('Very Good', 'reviewx' ); ?>">
                                    <svg class="icon icon-star">
                                        <use xlink:href="#rx_starIcon" />
                                    </svg>
                                </label>
                                <input type="radio" id="rx-default-star3" name="rx-default-star" value="3" />
                                <label for="rx-default-star3" title="<?php esc_attr_e('Good', 'reviewx' ); ?>">
                                    <svg class="icon icon-star">
                                        <use xlink:href="#rx_starIcon" />
                                    </svg>
                                </label>
                                <input type="radio" id="rx-default-star2" name="rx-default-star" value="2" />
                                <label for="rx-default-star2" title="<?php esc_attr_e('Poor', 'reviewx' ); ?>">
                                    <svg class="icon icon-star">
                                        <use xlink:href="#rx_starIcon" />
                                    </svg>
                                </label>
                                <input type="radio" id="rx-default-star1" name="rx-default-star" value="1" />
                                <label for="rx-default-star1" title="<?php esc_attr_e('Very Poor', 'reviewx' ); ?>">
                                    <svg class="icon icon-star">
                                        <use xlink:href="#rx_starIcon" />
                                    </svg>
                                </label>
                            </fieldset>
                        </div>

                        <script type="application/javascript">
                            jQuery(document).ready(function () {
                                jQuery('.rx-star-default input').change(function () {
                                    jQuery(this).attr('checked', true);
                                });
                            });
                        </script>
                    </td>
                </tr>
                <?php
            }
        }

    }

    /**
     * @param $settings
     * @return |null
     */
    public function load_edit_review_form( $settings )
    {
        //Will extended by pro version
        return null;
    }

    /**
     * Load before of the form
     *
     * @param none
     * @return void
     **/
    public function reviewx_display_before_form()
    {        
        if( \ReviewX_Helper::check_post_type_availability( get_post_type() ) == TRUE || get_post_type() == 'product' ) {            
            echo '</form><form action="'. site_url( '/wp-comments-post.php' ) .'" method="POST" enctype="multipart/form-data" id="attachmentForm" class="comment-form reviewx_front_end_from" novalidate>';
        }
    }

    /**
     * Compability with WooCommerce Loyalty Points and Rewards
     *
     * @param none
     * @return void
     **/    
    public function product_review_action($comment_id, $approved=0) 
    {
        
        if (!is_user_logged_in() || !$approved)
            return;

        $point_setting = get_option('wlpr_settings');
        $enable_review_reward = (isset($point_setting['wlpr_enable_review_reward']) && !empty($point_setting['wlpr_enable_review_reward'])) ? $point_setting['wlpr_enable_review_reward'] : 'yes';
        if($enable_review_reward == 'no'){
            return;
        }

        $comment = get_comment($comment_id);
        $post_type = get_post_type($comment->comment_post_ID);
        $points = 0;

        if ('product' === $post_type) {
            $points = (isset($point_setting['wlpr_write_review_points']) && (!empty($point_setting['wlpr_write_review_points'])||$point_setting['wlpr_write_review_points']==0)) ? $point_setting['wlpr_write_review_points'] : 50;
        }
        if (!empty($points) && isset($comment->comment_author_email) && !empty($comment->comment_author_email) && filter_var($comment->comment_author_email, FILTER_VALIDATE_EMAIL)) {
            /**
             * Filter the parameters for get_comments called on posting a review.
             */
            $params = apply_filters('wlpr_point_review_post_comments_args', array('author_email' => $comment->comment_author_email, 'post_id' => $comment->comment_post_ID));
            // only award points for the first comment placed on a particular product by a user
            $comments = get_comments($params);
            /**
             * Filter if points should be added for this comment id on posting a review.
             */
            if (count($comments) <= 1 && apply_filters('wlpr_point_post_add_product_review_points', true, $comment_id)) {
                global $wpdb;                
                $point_action_table = new \Wlpr\App\Models\PointAction();
                $where = $wpdb->prepare("user_email = %s AND action = %s AND product_id = %s",$comment->comment_author_email, 'product-review', $comment->comment_post_ID);
                $point_review_action_data = $point_action_table->getWhere($where, '*', true);
                if(empty($point_review_action_data)){
                    //self::$site = empty(self::$site) ? new \Wlpr\App\Controllers\Site\Main() : self::$site;
                    $point = new \Wlpr\App\Helpers\Point();
                    $point->increase_points($comment->comment_author_email, $points, 'product-review', array('product_id' => $comment->comment_post_ID));
                }
            }
        }

    } 
    
    /**
     * Upload guest user image
     *
     * @param integer
     * @return void
     **/     
    public function reviewx_guest_review_image_upload() 
    {

        check_ajax_referer( 'special-string', 'security' );
        $parent_post_id     = isset( $_POST['post_id'] ) ? sanitize_text_field($_POST['post_id']) : 0;  // The parent ID of our attachments
        $valid_formats      = array("jpg", "png", "gif", "bmp", "jpeg"); // Supported file types
        $max_file_size      = 1024 * 500000; // in kb
        $max_image_upload   = 10; // Define how many images can be uploaded to the current post
        $wp_upload_dir      = wp_upload_dir();
        $path               = $wp_upload_dir['path'] . '/';
        $count              = 0;
        $blocks             = array();
    
        $attachments = get_posts( array(
            'post_type'         => 'attachment',
            'posts_per_page'    => -1,
            'post_parent'       => $parent_post_id,
            'exclude'           => get_post_thumbnail_id() // Exclude post thumbnail to the attachment count
        ) );
    
        // Check if user is trying to upload more than the allowed number of images for the current post
        foreach ( $_FILES['files']['name'] as $f => $name ) {
            $extension = pathinfo( $name, PATHINFO_EXTENSION );
            // Generate a randon code for each file name
            $new_filename = $this->generate_random_code( 20 )  . '.' . $extension;
            
            if ( $_FILES['files']['error'][$f] == 4 ) {
                continue; 
            }
            
            if ( $_FILES['files']['error'][$f] == 0 ) {
                // Check if image size is larger than the allowed file size
                if ( $_FILES['files']['size'][$f] > $max_file_size ) {
                    $upload_message[] = sprintf(__("%s is too large!.", 'reviewx'), $name);
                    continue;
                
                // Check if the file being uploaded is in the allowed file types
                } elseif( ! in_array( strtolower( $extension ), $valid_formats ) ){
                    $upload_message[] = sprintf(__("%s is not a valid format.", 'reviewx'), $name);
                    continue;                
                } else{ 
                    // If no errors, upload the file...
                    if( move_uploaded_file( $_FILES["files"]["tmp_name"][$f], $path.$new_filename ) ) {                                
                        $count++; 
                        $filename = $path.$new_filename;
                        $filetype = wp_check_filetype( basename( $filename ), null );
                        $wp_upload_dir = wp_upload_dir();
                        $attachment = array(
                            'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ), 
                            'post_mime_type' => $filetype['type'],
                            'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
                            'post_content'   => '',
                            'post_status'    => 'inherit'
                        );
                        // Insert attachment to the database
                        $attach_id = wp_insert_attachment( $attachment, $filename, $parent_post_id );
                        require_once( ABSPATH . 'wp-admin/includes/image.php' );
                        // Generate meta data
                        $attach_data = wp_generate_attachment_metadata( $attach_id, $filename ); 
                        wp_update_attachment_metadata( $attach_id, $attach_data );
                        $attach_url = wp_get_attachment_url( $attach_id );
                        $blocks[]   = '<div class="rx-image"><img src="'.$attach_url.'" alt=""><a href="javascript:void(0);" class="remove_guest_image" title="Remove Image"><svg style="width: 15px" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times-circle" class="svg-inline--fa fa-times-circle fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z"></path></svg></a><input type="hidden" name="rx-image[]" class="rx-image" value="'.$attach_id.'"></div>';                                
                    }
                }
            }
        }
        
        $data = array('image'=> $blocks, 'message' => $upload_message);
        wp_send_json($data);
    }

    /**
     * Generated random code 
     *
     * @param integer
     * @return void
     **/ 
    public function generate_random_code($length=10) 
    {
 
        $string = '';
        $characters = "23456789ABCDEFHJKLMNPRTVWXYZabcdefghijklmnopqrstuvwxyz";
      
        for ($p = 0; $p < $length; $p++) {
            $string .= $characters[mt_rand(0, strlen($characters)-1)];
        }
      
        return $string;
      
    }

    /**
     * Guest image 
     *
     * @param none
     * @return void
     **/    
    public function reviewx_remove_guest_image()
    {
       
        check_ajax_referer( 'special-string', 'security' );
        $attach_id 	= sanitize_text_field( $_POST['attach_id'] );
        $del = wp_delete_attachment( $attach_id, true );
        if( $del ){
            $return = array( 'success'=> true );
        } else {
            $return = array( 'success'=> false );
        }        
        wp_send_json($return);

    }
 
    /**
     * Recommendation shortcode
     *
     * @param array
     * @return void
     **/     
    public function reviewx_load_recommendation( $atts ) 
    {
        $atts = shortcode_atts( array(
            'product_id' => '',            
        ), $atts );

        global $reviewx_shortcode;
        $reviewx_shortcode['shortcode_type'] = 'recommendation';
        $reviewx_shortcode['rx_product_id']  = $atts['product_id'];
        
        $data = (new \ReviewX\Controllers\Storefront\GraphTemplateLoader())->loadView();
        ob_start();
        include REVIEWX_PARTIALS_PATH . 'storefront/shortcode/recommendation.php';
        $content = ob_get_clean();
        return $content;
    }
    
    /**
     * Review summary shortcode
     *
     * @param array
     * @return void
     **/     
    public function reviewx_load_summary( $atts ) 
    {
        $atts = shortcode_atts( array(
            'product_id' => '',
        ), $atts );

        global $reviewx_shortcode;
        $reviewx_shortcode['shortcode_type'] = 'summary';
        $reviewx_shortcode['rx_product_id']  = $atts['product_id'];
        ob_start();
        if( ! class_exists('ReviewXPro') ) {
            // Load from free version
           (new \ReviewX\Controllers\Storefront\GraphTemplateLoader())->loadView();
        } else {
            // Load from premium version
            apply_filters( 'rx_load_review_graph_template', 1 );
        }        
        $content = ob_get_clean();
        return $content;        
    }

    /**
     * Criteria graph shortcode
     *
     * @param array
     * @return void
     **/     
    public function reviewx_load_graph( $atts )
    {
        $atts = shortcode_atts( array(
            'product_id' => '',            
        ), $atts );

        global $reviewx_shortcode;
        $reviewx_shortcode['shortcode_type'] = 'graph';
        $reviewx_shortcode['rx_product_id']  = $atts['product_id'];
        $data = (new \ReviewX\Controllers\Storefront\GraphTemplateLoader())->loadView();
        ob_start();
        include REVIEWX_PARTIALS_PATH . 'storefront/shortcode/graph.php';
        $content = ob_get_clean();
        return $content;             
    }

    /**
     * Review list shortcode
     *
     * @param array
     * @return void
     **/     
    public function reviewx_load_review_list( $atts )
    {

        $atts = shortcode_atts( array(
            'product_id'    => '',
            'order_by'      => 'desc',
            'sort_by'       => '',
            'filter'        => 'on', 
            'rating'        => '',
            'review_count'  => '',
            'pagination'    => 'on',            
            'per_page'      => '',   
            'post_type'     => '', 
            'post_title'    => '',            
        ), $atts );

        global $reviewx_shortcode;
        $reviewx_shortcode['shortcode_type']    = 'review_list';
        $reviewx_shortcode['rx_product_id']     = $atts['product_id'];
        $reviewx_shortcode['rx_filter']         = $atts['filter'];
        $reviewx_shortcode['rx_pagination']     = $atts['pagination'];
        $reviewx_shortcode['rx_per_page']       = $atts['per_page'];
        $reviewx_shortcode['rx_review_count']   = $atts['review_count'];
        $reviewx_shortcode['rx_order']          = $atts['order_by'];
        $reviewx_shortcode['rx_sort_by']        = $atts['sort_by'];
        $reviewx_shortcode['rx_rating']         = $atts['rating'];
        $reviewx_shortcode['rx_post_title']     = $atts['post_title'];
        
        if( empty( $atts['post_type']) && empty( $atts['product_id'] ) ) {
            $reviewx_shortcode['rx_post_type']  = 'product'; 
        } else if( empty( $atts['post_type'] ) && get_post_type( $atts['product_id'] ) == 'product' ) {             
            $reviewx_shortcode['rx_post_type']  = 'product';
        } else if( ! empty( $atts['post_type'] ) && $atts['post_type'] == 'product' ) {           
            $reviewx_shortcode['rx_post_type']  = $atts['post_type'];
        } else if( ! empty( $atts['post_type'] ) && $atts['post_type'] == get_post_type( $atts['product_id'] ) ) {            
            $reviewx_shortcode['rx_post_type']  = $atts['post_type']; 
        } else if( empty( $atts['post_type'] ) && ! empty( $atts['product_id'] ) ) {        
            $reviewx_shortcode['rx_post_type']  = get_post_type( $atts['product_id'] );                         
        } else if( ! empty( $atts['post_type'] ) && empty( $atts['product_id'] ) ) {
            $reviewx_shortcode['rx_post_type']  = $atts['post_type'];    
        }

        if( $reviewx_shortcode['rx_post_type'] == 'product' ) {
            $settings 	     = \ReviewX\Controllers\Admin\Core\ReviewxMetaBox::get_option_settings();
            $template_style  = $settings->template_style;
            if( empty($atts['per_page']) ){
                $reviewx_shortcode['rx_per_page']       = $settings->review_per_page;                
            }

        } else if( \ReviewX_Helper::check_post_type_availability( $reviewx_shortcode['rx_post_type'] ) == TRUE ) {
           $reviewx_id       = \ReviewX_Helper::get_reviewx_post_type_id( $reviewx_shortcode['rx_post_type'] );   
           $settings         = \ReviewX\Controllers\Admin\Core\ReviewxMetaBox::get_metabox_settings( $reviewx_id );  
           $template_style   = $settings->template_style;
           if( empty($atts['per_page']) ){
            $reviewx_shortcode['rx_per_page']       = $settings->review_per_page;                
           }
        }        
       
        $args = \ReviewX_Helper::reviewx_shortcode_query_args($reviewx_shortcode);

        ob_start();
        if( ! class_exists('ReviewXPro') ) {

            $rx_elementor_controller    = apply_filters( 'rx_load_elementor_style_controller', '' );
            $rx_elementor_template      = isset($rx_elementor_controller['rx_template_type']) ? $rx_elementor_controller['rx_template_type'] : null;

            $rx_oxygen_controller  = apply_filters( 'rx_load_oxygen_style_controller', '' );
            $rx_oxygen_template    = isset($rx_oxygen_controller['rx_template_type']) ? $rx_oxygen_controller['rx_template_type'] : null;
            
            //Check elementor template
            if( ! empty($rx_elementor_template) ) {

                switch ( $rx_elementor_template ) {
                    case "template_style_two":
                        include REVIEWX_PARTIALS_PATH . 'storefront/shortcode/templates/style-two.php';
                        break;
                    default:
                    include REVIEWX_PARTIALS_PATH . 'storefront/shortcode/templates/style-one.php';
                }

            } else if( ! empty($rx_oxygen_template) ) {                

                switch ( $rx_oxygen_template ) {
                    case "box":
                        include REVIEWX_PARTIALS_PATH . 'storefront/shortcode/templates/style-two.php';
                        break;
                    default:
                    include REVIEWX_PARTIALS_PATH . 'storefront/shortcode/templates/style-one.php';
                }

            } else {
                //Serve local template
                switch ( $template_style ) {
                    case "template_style_two":
                        include REVIEWX_PARTIALS_PATH . 'storefront/shortcode/templates/style-two.php';
                        break;
                    default:
                        include REVIEWX_PARTIALS_PATH . 'storefront/shortcode/templates/style-one.php';
                }
            }

        } else {
            apply_filters( 'rx_load_shortcode_review_templates', $reviewx_shortcode, $args ); 
        }

        $content = ob_get_clean();
        return $content;  
    }

    
    /**
     * Update default gravatar
     *
     * @param array
     * @return void
     **/     
    public function rx_set_default_gravatar()
    {
        if( !class_exists( 'WP_User_Avatar' ) && get_option( 'avatar_default' ) == 'wp_user_avatar' ) {
            update_option('avatar_default', 'mystery');
        }
    }

    /**
     * Star rating count shortcode
     *
     * @param array
     * @return void
     **/  
    public function reviewx_star_count( $atts ) 
    {

        $atts = shortcode_atts( array(
            'product_id'    => '',
            'id'            => '',
            'post_id'       => '',            
        ), $atts );
        $html               = '';

        if( (isset($atts['product_id']) && $atts['product_id'] !='') ) {
            $product_id         = $atts['product_id'];
        } else if( (isset($atts['id']) && $atts['id'] !='') ) {
            $product_id         = $atts['id'];
        } else if( (isset($atts['post_id']) && $atts['post_id'] !='') ) {
            $product_id         = $atts['post_id'];
        } else {
            $product_id         =  get_the_ID();            
        }

        if( class_exists( 'WooCommerce' ) && get_post_type($product_id) == 'product' ) {
            $product           = wc_get_product( $product_id ); 
            if( !empty($product) ) {
                $rating_count      = $product->get_rating_count();
                $html .= '<div style="display:flex;">';
                    $html .= wc_get_rating_html( $product->get_average_rating(), $rating_count );
                    if(!empty($product->get_average_rating())){
                        $html .= sprintf( esc_html__( '%s', 'reviewx' ), ' <span>(' . esc_html( $rating_count ) . ')</span>' );
                    }                    
                $html .= '</div>';
            }

        } else if( \ReviewX_Helper::check_post_type_availability( get_post_type( $product_id ) ) == TRUE ) {
   
            $rating         = \ReviewX_Helper::get_average_rating_for_product( $product_id );
            $rating_count   = array_sum( \ReviewX_Helper::get_rating_counts_for_product( $product_id ) );
            if ( 0 < $rating ) {
                $html .= '<div style="display:flex;">';
                    $html .= '<div class="rx-product-rating">';
                        $html .= '<div class="rx-star-rating" role="img" aria-label="Rated 5.00 out of 5">';
                            $html .= '<span style="width:' . ( ( $rating / 5 ) * 100 ) . '%"></span>';                    
                        $html .= '</div>';
                    $html .= '</div>';
                    $html .= sprintf( esc_html__( '%s', 'reviewx' ), ' <span>(' . esc_html( $rating_count ) . ')</span>' );
                $html .= '</div>';
            }

        }   
        
        return $html; 
    
    }

    /**
     * Woo Reviews Shortcode
     *
     * @param none
     * @return void
     **/     
    public function reviewx_woo_reviews( $atts ) 
    {

        $atts = shortcode_atts( array(
            'product_id'    => '',
            'graph'         => '',
            'list'          => '',            
            'form'          => '',
            'order_by'      => 'desc',
            'sort_by'       => '',
            'filter'        => 'on', 
            'rating'        => '',
            'review_count'  => '',
            'pagination'    => 'on',            
            'per_page'      => '',           
        ), $atts );
        
        global $product;
        global $reviewx_shortcode;     
        $reviewx_shortcode['rx_graph']          = $atts['graph'];     
        $reviewx_shortcode['rx_list']           = $atts['list']; 
        $reviewx_shortcode['rx_form']           = $atts['form']; 
        $reviewx_shortcode['rx_order']          = $atts['order_by']; 
        $reviewx_shortcode['rx_sort_by']        = $atts['sort_by']; 
        $reviewx_shortcode['rx_filter']         = $atts['filter']; 
        $reviewx_shortcode['rx_rating']         = $atts['rating'];  
        $reviewx_shortcode['rx_review_count']   = $atts['review_count'];  
        $reviewx_shortcode['rx_pagination']     = $atts['pagination'];  
        $reviewx_shortcode['rx_per_page']       = $atts['per_page']; 
        $reviewx_shortcode['rx_product_id']     = $atts['product_id']; 
        if(empty($atts['product_id']) ){
            $reviewx_shortcode['rx_product_id']     = get_the_ID(); 
        }
		
        $product = wc_get_product( $reviewx_shortcode['rx_product_id'] );
        
		if ( empty( $product ) ) {
			echo '<h3>'.__('This widget only works for the product page. In order to achieve, follow the steps: this  Dashboard >  Template  > Theme Builder > Add New > Choose Template Type \'Single Product\' > Create Template', 'reviewx').'</h3>';
			return;
        } 

		setup_postdata( $product->get_id() );
		return call_user_func( 'comments_template', 'reviews' );
    }
    
    /**
    * Display anonymouse checkbox
    *
    * @param none
    * @return void
    **/    
    public function reviewx_anonymouse_field( $submit_button, $args ) {

        if( get_post_type() == 'product' ) {
            
            $button 			= '';
            $echo 				= '';
            if( !\ReviewX_Helper::is_pro() && get_option('_rx_option_allow_media_compliance') == 1 ) {
            $echo .='<div class="review_media_compliance">';
                $echo .='<label class="review_media_compliance_label">';  
                    $echo .='<input type="checkbox" name="rx_allow_media_compliance" id="rx_allow_media_compliance" value=1>';                                  
                    $echo .='<span class="review_media_compliance_icon"></span>';
                    $echo .= !empty(get_theme_mod('reviewx_media_compliance') ) ? html_entity_decode( get_theme_mod('reviewx_media_compliance') ) : esc_html__( 'I agree to the terms of services.', 'reviewx' );
                    $echo .='<label id="rx_allow_media_compliance-error" class="error" for="rx_allow_media_compliance" style="display: none;"></label>';
                $echo .='</label>';
            $echo .='</div>'; 
            echo $echo; 
            } 	
            $button 				.= '<input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" />';
    
            return sprintf(
                $button,
                esc_attr( $args['name_submit'] ),
                esc_attr( $args['id_submit'] ),
                esc_attr( $args['class_submit'] ),
                esc_attr( $args['label_submit'] )
            );
    
        } else if( \ReviewX_Helper::check_post_type_availability( get_post_type() ) == TRUE ) { 
             
            $button                 = '';
            $echo 				    = '';
            $reviewx_id             = \ReviewX_Helper::get_reviewx_post_type_id( get_post_type() ); 
            $allow_img 		        = \ReviewX_Helper::get_post_meta( $reviewx_id, 'allow_img', true ); 
            $allow_media_compliance = \ReviewX_Helper::get_post_meta( $reviewx_id, 'allow_media_compliance', true );                       
            if( !\ReviewX_Helper::is_pro() && $allow_media_compliance == 1 ) {
            $echo .='<div class="review_media_compliance">';
                $echo .='<label class="review_media_compliance_label">';    
                    $echo .='<input type="checkbox" name="rx_allow_media_compliance" id="rx_allow_media_compliance" value=1>';                
                    $echo .='<span class="review_media_compliance_icon"></span>';
                    $echo .= !empty(get_theme_mod('reviewx_media_compliance') ) ? html_entity_decode( get_theme_mod('reviewx_media_compliance') ) : esc_html__( 'I agree to the terms of services.', 'reviewx' );
                    $echo .='<label id="rx_allow_media_compliance-error" class="error" for="rx_allow_media_compliance" style="display: none;"></label>';
                $echo .='</label>';
            $echo .='</div>'; 
            echo $echo; 
            } 	
            $button     .= '<input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" />';
    
            return sprintf(
                $button,
                esc_attr( $args['name_submit'] ),
                esc_attr( $args['id_submit'] ),
                esc_attr( $args['class_submit'] ),
                esc_attr( $args['label_submit'] )
            ); 
                        
        } else {
    
            $button = '<input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" />';
    
            return sprintf(
                $button,
                esc_attr( $args['name_submit'] ),
                esc_attr( $args['id_submit'] ),
                esc_attr( $args['class_submit'] ),
                esc_attr( $args['label_submit'] )
            );
    
        }

    } 
    
    /**
    * Check auto login code and modify product url in view order page 
    *
    * @param string
    * @return string
    **/    
    public function modify_product_permalink( $url ) {

        if (isset($_GET[REVIEWX_AUTOLOGIN_VALUE_NAME])) {    
            $autologin_code = preg_replace('/[^a-zA-Z0-9]+/', '', $_GET[REVIEWX_AUTOLOGIN_VALUE_NAME]);
            if($autologin_code) {
                $query_string = $_GET[REVIEWX_AUTOLOGIN_VALUE_NAME];
                return esc_url(add_query_arg( array(
                    'rx_autologin_code' => $query_string,
                ), $url ));
            }
        }

        return $url;
    }
}