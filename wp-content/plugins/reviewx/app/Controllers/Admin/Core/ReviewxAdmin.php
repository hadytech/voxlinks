<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @since      1.0.0
 *
 */

namespace ReviewX\Controllers\Admin\Core;

use ReviewX\Constants\LockForm;
use ReviewX\Controllers\Admin\Criteria\CriteriaController;
use ReviewX\Controllers\Admin\Email\EmailSettings;
use ReviewX\Controllers\Controller;
use ReviewX\Modules\OptimisticLock;
use ReviewX\Controllers\Admin\Core\ReviewxMetaBox;
use ReviewX\Services\Epoch\Epoch;
use WC_Order;
use ReviewX\Modules\Loader;

if( ! defined( 'ABSPATH' ) ) {
    exit;
}

if( ! class_exists( 'ReviewxAdmin' ) ) {
    /**
     * Class ReviewxAdmin
     * @package ReviewX\Controllers\Admin\Core
     */
    class ReviewxAdmin extends Controller
    {

        /**
         * The ID of this plugin.
         *
         * @since    1.0.0
         * @access   private
         * @var      string    $plugin_name    The ID of this plugin.
         */
        private $plugin_name;

        /**
         * The type.
         *
         * @since    1.0.0
         * @access   public
         * @var string the post type of reviewx.
         */
        public $type = 'reviewx';
        public static $counts;

        /**
         * Metabox
         *
         * @since    1.0.0
         * @access   public
         * @var string metabox.
         */
        public $metabox;

        /**
         * The plugin option
         *
         * @since    1.0.0
         * @access   public
         * @var string option.
         */
        public static $prefix = 'rx_option_';

        /**
         * The plugin settings
         *
         * @since    1.0.0
         * @access   public
         * @var string settings.
         */
        public static $settings;

        /**
         * The version of this plugin.
         *
         * @since    1.0.0
         * @access   private
         * @var      string    $version    The current version of this plugin.
         */
        private $version;

        /**
         * Initialize the class and set its properties.
         *
         * @since    1.0.0
         * @param      string    $plugin_name       The name of this plugin.
         * @param      string    $version    The version of this plugin.
         */
        public function __construct( $plugin_name, $version )
        {
            $this->plugin_name 	= $plugin_name;
            $this->version 		= $version;

            add_filter('set-screen-option', array( $this, 'save_screen_options' ), 10, 3);

            add_action( 'wp_ajax_save_current_tab', array( $this, 'save_current_tab') );
            add_action( 'wp_ajax_nopriv_save_current_tab', array( $this, 'save_current_tab') );

            add_action( 'wp_ajax_save_review_email_current_tab', array( $this, 'save_review_email_current_tab') );
            add_action( 'wp_ajax_nopriv_save_review_email_current_tab', array( $this, 'save_review_email_current_tab') );            

            add_action( 'wp_ajax_save_quick_setup_current_tab', array( $this, 'save_quick_setup_current_tab') );
            add_action( 'wp_ajax_nopriv_save_quick_setup_current_tab', array( $this, 'save_quick_setup_current_tab') );

            add_action( 'wp_ajax_save_setting_tab', array( $this, 'save_setting_tab') );
            add_action( 'wp_ajax_nopriv_save_setting_tab', array( $this, 'save_setting_tab') );
            
            add_action( 'wp_ajax_rx_send_email', array( $this, 'sendEmail') );

            add_action('wp_ajax_rx_send_schedule_email', array($this, 'sendScheduleEmail'));

            add_action('wp_ajax_rx_send_now', array($this, 'sendNowEmail'));

            add_action('wp_ajax_rx_cancelled_now', array($this, 'sendCancelled'));

            add_action( 'admin_head', array( $this, 'load_admin_custom_css') );

            add_action( 'wp_ajax_reviewx_toggle_status', array( $this, 'reviewx_status') );

            add_action( 'wp_ajax_check_custom_post_type_exists', array( $this, 'check_custom_post_type_exists') );
            add_action( 'wp_ajax_nopriv_check_custom_post_type_exists', array( $this, 'check_custom_post_type_exists') );
            add_action( 'wp_loaded', array( $this, 'update_reviewx_title' ) );

        }

        public function bulkAction() {
            if ($_POST['rx_builder_from_where'] == 'review_email' && $_POST['rx_builder_current_tab'] == 'scheduled_emails') {
                $action = $_POST['action'];
                $orderIds = $_POST['LOG_ORDER_IDS'];

                require_once __DIR__ . '/../../../Services/WPFluent/wp-fluent.php';

                if ($action == 'send_now') {
                    foreach ($orderIds as $orderId) {
                        (new EmailSettings())->sendScheduleEmail($orderId);
                    }
                }

                if ($action == "cancelled") {
                    foreach ($orderIds as $orderId) {
                        (new EmailSettings())->cancelledScheduleEmail($orderId);
                    }
                }

            }
        }

        /**
         * Register the stylesheets for the admin area.
         *
         * @since    1.0.0
         * @param $hook
         */
        public function admin_enqueue_styles( $hook )
        {
            wp_enqueue_style( $this->plugin_name . '-sweetalert', assets('admin/css/sweetalert2.min.css'), array(), $this->version, 'all' );
            wp_enqueue_style( $this->plugin_name . '-magnific-popup', assets('admin/css/magnific-popup.css'), array(), $this->version, 'all' );
            wp_enqueue_style( $this->plugin_name . '-admin_style', assets('admin/css/rx-admin_style.css'), array(), $this->version, 'all' );
            wp_enqueue_style( $this->plugin_name, assets('admin/css/reviewx-admin.css'), array(), $this->version, 'all' );
        }

        /**
         * * Register the JavaScript for the admin area.
         * @since    1.0.0
         * @param $hook
         */
        public function admin_enqueue_scripts( $hook )
        {
            $is_enable = (
            ! in_array($hook, [
                'toplevel_page_rx-admin',
                'post-new.php',
                'post.php',
                'reviewx_page_rx-wc-settings',
                'reviewx_page_reviewx-all',
                'reviewx_page_reviewx-quick-setup',
                'reviewx_page_rx-settings',
                'reviewx_page_rx-add-review'
            ])
            );

            if( $is_enable ){
                return;
            }

            wp_enqueue_media();
            wp_enqueue_script( 'wp-color-picker' );
            wp_enqueue_script( 'jquery-ui-core' );
            wp_enqueue_script( 'jquery-ui-sortable' );
            wp_enqueue_script( $this->plugin_name . '-sweetalert2-js', assets('admin/js/sweetalert2.all.min.js'), array( 'jquery' ), $this->version, true );
//            wp_enqueue_script( $this->plugin_name . '-canvasjs-js', assets('admin/js/canvasjs.min.js'), array( 'jquery' ), $this->version, true );
            wp_enqueue_script( $this->plugin_name . '-magnific-popup-js', assets('admin/js/jquery.magnific-popup.min.js'), array( 'jquery' ), $this->version, true );
            wp_enqueue_script( $this->plugin_name . '-admin-script', assets('admin/js/reviewx-admin.js'), array( 'jquery' ), $this->version, true );
            $js_filter = apply_filters( 'reviewx_js_filter', array(
                'ajax_admin_url' 			=>  admin_url('admin-ajax.php'),
                'rx_review_text_error' 		=> __( 'Review can\'t be empty', 'reviewx' ),
                'rx_rating_satisfaction' 	=> __( 'Please rate your satisfaction', 'reviewx' ),
                'review_success_title'		=> __( 'Success', 'reviewx' ),
                'review_success_msg'		=> __( 'Settings saved successfully!', 'reviewx' ),
                'review_sending_msg'		=> __( 'Sent successfully!', 'reviewx' ),
                'review_failed_title'		=> __( 'Error', 'reviewx' ),
                'review_failed_msg'			=> __( 'Settings saved fail!', 'reviewx' ),
                'rx_name_error'				=> __( 'Name can\'t be empty', 'reviewx' ),
                'rx_email_error'			=> __( 'Email can\'t be empty', 'reviewx' ),
                'rx_invalid_email_error'	=> __( 'Invalid email', 'reviewx' ),
                'rx_setting_sending'	    => __( 'Sending...', 'reviewx' ),
                'rx_setting_saving'	        => __( 'Saving...', 'reviewx' ),
                'rx_save_setting'	        => __( 'Save', 'reviewx' ),
                'rx_before_email_sent'      => __( 'Save & Send Email', 'reviewx' ),
                'already_review_msg'		=> __( 'This email has already given review on this product', 'reviewx' ),
                'rx_criteria_error'         => __( 'Your product review criteria field is empty', 'reviewx' ),
                'rx_finalize_title'			=> __( 'Good job!', 'reviewx' ),
                'rx_finalize_msg'         	=> __( 'Setup is Complete.', 'reviewx' ),
                'rx_remidner_title'	        => __( 'Warning!', 'reviewx' ),
                'rx_remidner_msg'	        => __( 'A review reminder email will be sent out to your customers for their unreviewed order items.', 'reviewx' ),  
                'rx_btn_cancel_next'	    => __( 'Cancel', 'reviewx' ),
                'rx_btn_email_sent'         => __( 'Send Email', 'reviewx' ),  
                'rx_test_email_title'       => __( 'Test Mail', 'reviewx' ),
                'rx_test_email_message'     => __( 'Test mail sent successfully!', 'reviewx' ),
                'rx_test_email_valid'       => __( 'Email is invalid!', 'reviewx' ), 
                'rx_mail_sent_msg'		    => __( 'Mail Sent successfully!', 'reviewx' ),                               
            ) );
            wp_localize_script( $this->plugin_name . '-admin-script', 'ajax_admin', $js_filter );

        }

        /**
         * Admin Menu Page
         *
         * @return void
         */
        public function menu_page()
        {
            $this->builder_args = ReviewxMetaBox::get_builder_args();
            $this->metabox_id   = $this->builder_args['id'];

            $settings 			 = apply_filters( 'rx_admin_menu', array(
                'rx-wc-settings' => array(
                    'parent_slug'   => 'rx-admin',
                    'page_title'    => __('WC Settings', 'reviewx'),
                    'menu_title'    => __('WC Settings', 'reviewx'),
                    'capability'    => 'delete_users',
                    'menu_slug'     => 'rx-wc-settings',
                    'callback'      =>  array( $this, 'settings' )
                ),
            ) );

            $hook = add_menu_page( 'ReviewX', 'ReviewX', 'delete_users', 'rx-admin', array( $this, 'reviewx' ), esc_url(assets('admin/images/ReviewX_dash_icon_white.png')), 80 );
            add_action('load-' . $hook, array( $this, 'screen_options' ) );
            add_submenu_page( 'rx-admin', 'All ReviewX', 'All ReviewX', 'delete_users', 'rx-admin' );            
            add_submenu_page( 'rx-admin', __('Add New', 'reviewx'), __('Add New', 'reviewx'), 'delete_users', 'post-new.php?post_type=reviewx' );

            foreach( $settings as $slug => $setting ) {
                $cap  = isset( $setting['capability'] ) ? $setting['capability'] : 'delete_users';
                if( \ReviewX_Helper::check_wc_is_enabled() && class_exists('WooCommerce') ) {
                    add_submenu_page( $setting['parent_slug'], $setting['page_title'], $setting['menu_title'], $cap, $slug, $setting['callback'] );
                }
            }

        }

        /**
         *
         * @return array
         * @since    1.0.0
         */
        public function settings()
        {
            $builder_args = $this->builder_args;
            $tabs         = $this->builder_args['tabs'];
            $prefix       = self::$prefix;
            $metabox_id   = $this->metabox_id;
            /**
             * This lines of code is for editing a reviex in simple|quick builder
             *
             * @var  [type]
             */
            $idd = null;
            if( isset( $_GET['post_id'] ) && ! empty( $_GET['post_id'] ) ) {
                $idd = intval( wp_unslash($_GET['post_id']) );
            }

            include_once REVIEWX_PARTIALS_PATH . 'admin/settings.php';
        }

        /**
         * Quick setup
         *
         * @return void
         * @since    2.0.0
         */
        public function quick_setup()
        {
            if( get_option('_rx_option_disable_autocreate_unsubscribe_page') == '' || get_option('_rx_option_disable_autocreate_unsubscribe_page') == 0 ) {
            $this->generateUnsubscribeEmailPage();
            }

            wp_enqueue_style( $this->plugin_name . '-sweetalert', esc_url(assets('admin/css/sweetalert2.min.css')), array(), $this->version, 'all' );
            wp_enqueue_style( $this->plugin_name . '-select2-css', esc_url(assets('admin/css/select2.min.css')), array(), $this->version);
            wp_enqueue_style( $this->plugin_name, esc_url(assets('admin/css/reviewx-admin.css')), array(), $this->version, 'all' );
            wp_enqueue_script( $this->plugin_name . '-sweetalert2-js', esc_url(assets('admin/js/sweetalert2.all.min.js')), array( 'jquery' ), $this->version, true );
            wp_enqueue_script($this->plugin_name . '-select2-js', esc_url(assets('admin/js/select2.min.js')), array('jquery'), $this->version);

            if( ! \ReviewX_Helper::is_pro() ) {
                wp_enqueue_script( $this->plugin_name . '-admin-script', esc_url(assets('admin/js/reviewx-admin.js')), array( 'jquery' ), $this->version, true );
                $js_filter = apply_filters( 'reviewx_js_filter', array(
                    'ajax_admin_url' 			=>  admin_url('admin-ajax.php'),
                    'rx_review_text_error' 		=> __( 'Review can\'t be empty', 'reviewx' ),
                    'rx_rating_satisfaction' 	=> __( 'Please rate your satisfaction', 'reviewx' ),
                    'review_success_title'		=> __( 'Success', 'reviewx' ),
                    'review_success_msg'		=> __( 'Settings saved successfully!', 'reviewx' ),
                    'review_failed_title'		=> __( 'Error', 'reviewx' ),
                    'review_failed_msg'			=> __( 'Settings saved fail!', 'reviewx' ),
                    'rx_name_error'				=> __( 'Name can\'t be empty', 'reviewx' ),
                    'rx_email_error'			=> __( 'Email can\'t be empty', 'reviewx' ),
                    'rx_invalid_email_error'	=> __( 'Invalid email', 'reviewx' ),
                    'rx_setting_sending'	    => __( 'Sending...', 'reviewx' ),
                    'rx_setting_saving'	        => __( 'Saving...', 'reviewx' ),
                    'rx_save_setting'	        => __( 'Save & Next', 'reviewx' ),
                    'rx_before_email_sent'      => __( 'Save & Send Email', 'reviewx' ),
                    'already_review_msg'		=> __( 'This email has already given review on this product', 'reviewx' ),
                    'rx_criteria_error'         => __( 'Your product review criteria field is empty', 'reviewx' ),
					'rx_finalize_title'			=> __( 'Good job!', 'reviewx' ),
                    'rx_finalize_msg'         	=> __( 'Setup is Complete.',  'reviewx' ),
                    'rx_remidner_title'	        => __( 'Warning!', 'reviewx' ),
                    'rx_remidner_msg'	        => __( 'A review reminder email will be sent out to your customers for their unreviewed order items.', 'reviewx' ), 
                    'rx_btn_cancel_next'	    => __( 'Cancel & Next', 'reviewx' ),
                    'rx_btn_email_sent'         => __( 'Send Email', 'reviewx' ), 
                    'rx_test_email_title'       => __( 'Test Mail', 'reviewx' ),
                    'rx_test_email_message'     => __( 'Test mail sent successfully!', 'reviewx' ),
                    'rx_test_email_valid'       => __( 'Email is invalid!', 'reviewx' ),  
                    'rx_mail_sent_msg'		    => __( 'Mail Sent successfully!', 'reviewx' ),             
                ) );
                wp_localize_script( $this->plugin_name . '-admin-script', 'ajax_admin', $js_filter );
            }

            $this->builder_args = ReviewxMetaBox::get_quick_setup_args();

            $builder_args = $this->builder_args;
            $tabs         = $this->builder_args['tabs'];
            $prefix       = self::$prefix;
            $metabox_id   = $builder_args['id'];
            /**
             * This lines of code is for editing a reviewx in simple|quick builder
             *
             * @var  [type]
             */
            $idd = null;
            if( isset( $_GET['post_id'] ) && ! empty( $_GET['post_id'] ) ) {
                $idd = intval( wp_unslash($_GET['post_id']) );
            }

            include_once REVIEWX_PARTIALS_PATH . 'admin/quick_setup.php';

        }

        /**
         * Review Email
         *
         * @return void
         * @since    2.0.0
         */
        public function review_email()
        {
            if ($_SERVER['REQUEST_METHOD'] == "POST" && ! $this->isBulkProcessed) {
                $this->bulkAction();
            }

            if( get_option('_rx_option_disable_autocreate_unsubscribe_page') == '' || get_option('_rx_option_disable_autocreate_unsubscribe_page') == 0 ) {
            $this->generateUnsubscribeEmailPage();
            }

            wp_enqueue_script( 'jquery-ui-core' );
            wp_enqueue_script( 'jquery-ui-sortable' );
            wp_enqueue_script($this->plugin_name . '-select2-js', esc_url(assets('admin/js/select2.min.js')), array('jquery'), $this->version, true);
            wp_enqueue_style( $this->plugin_name . '-sweetalert', esc_url(assets('admin/css/sweetalert2.min.css')), array(), $this->version, 'all' );
            wp_enqueue_style($this->plugin_name . '-select2-css', esc_url(assets('admin/css/select2.min.css')), array(), $this->version);
            wp_enqueue_style( $this->plugin_name, esc_url(assets('admin/css/reviewx-admin.css')), array(), $this->version, 'all' );
            wp_enqueue_script( $this->plugin_name . '-magnific-popup-js', esc_url(assets('admin/js/jquery.magnific-popup.min.js')), array( 'jquery' ), $this->version, true );
            wp_enqueue_script( $this->plugin_name . '-sweetalert2-js', esc_url(assets('admin/js/sweetalert2.all.min.js')), array( 'jquery' ), $this->version, true );
        
            if( ! \ReviewX_Helper::is_pro() ) {
                wp_enqueue_script( $this->plugin_name . '-admin-script', esc_url(assets('admin/js/reviewx-admin.js')), array( 'jquery' ), $this->version, true );
                $js_filter = apply_filters( 'reviewx_js_filter', array(
                    'ajax_admin_url' 			=>  admin_url('admin-ajax.php'),
                    'rx_review_text_error' 		=> __( 'Review can\'t be empty', 'reviewx' ),
                    'rx_rating_satisfaction' 	=> __( 'Please rate your satisfaction', 'reviewx' ),
                    'review_success_title'		=> __( 'Success', 'reviewx' ),
                    'review_success_msg'		=> __( 'Settings saved successfully!', 'reviewx' ),
                    'review_failed_title'		=> __( 'Error', 'reviewx' ),
                    'review_failed_msg'			=> __( 'Settings saved fail!', 'reviewx' ),
                    'rx_name_error'				=> __( 'Name can\'t be empty', 'reviewx' ),
                    'rx_email_error'			=> __( 'Email can\'t be empty', 'reviewx' ),
                    'rx_invalid_email_error'	=> __( 'Invalid email', 'reviewx' ),
                    'rx_setting_sending'	    => __( 'Sending...', 'reviewx' ),
                    'rx_setting_saving'	        => __( 'Saving...', 'reviewx' ),
                    'rx_save_setting'	        => __( 'Save', 'reviewx' ),
                    'rx_before_email_sent'      => __( 'Save & Send Email', 'reviewx' ),
                    'already_review_msg'		=> __( 'This email has already given review on this product', 'reviewx' ),
                    'rx_criteria_error'         => __( 'Your product review criteria field is empty', 'reviewx' ),
					'rx_finalize_title'			=> __( 'Good job!', 'reviewx' ),
                    'rx_finalize_msg'         	=> __( 'Setup is Complete.',  'reviewx' ),
                    'rx_remidner_title'	        => __( 'Warning!', 'reviewx' ),
                    'rx_remidner_msg'	        => __( 'A review reminder email will be sent out to your customers for their unreviewed order items.', 'reviewx' ), 
                    'rx_btn_cancel_next'	    => __( 'Cancel & Next', 'reviewx' ),
                    'rx_btn_email_sent'         => __( 'Send Email', 'reviewx' ),
                    'rx_test_email_title'       => __( 'Test Mail', 'reviewx' ),
                    'rx_test_email_message'     => __( 'Test mail sent successfully!', 'reviewx' ),
                    'rx_test_email_valid'       => __( 'Email is invalid!', 'reviewx' ),
                    'rx_mail_sent_msg'		    => __( 'Mail Sent successfully!', 'reviewx' ),   
                    'rx_mail_default_template'  => '<table class="body" style="border-collapse: collapse; border-spacing: 0; vertical-align: top; mso-table-lspace: 0pt; mso-table-rspace: 0pt; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; height: 100% !important; width: 100% !important; min-width: 100%; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; -webkit-font-smoothing: antialiased !important; -moz-osx-font-smoothing: grayscale !important; background-color: #f1f1f1; color: #444; font-family: Helvetica,Arial,sans-serif; font-weight: normal; padding: 0; margin: 0; text-align: left; font-size: 14px; mso-line-height-rule: exactly; line-height: 140%;" border="0" width="100%" cellspacing="0" cellpadding="0"><tbody><tr style="padding: 0; vertical-align: top; text-align: left;"><td class="body-inner wp-mail-smtp" style="word-wrap: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; mso-table-lspace: 0pt; mso-table-rspace: 0pt; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; color: #444; font-family: Helvetica,Arial,sans-serif; font-weight: normal; padding: 0; margin: 0; font-size: 14px; mso-line-height-rule: exactly; line-height: 140%; text-align: center;" align="center" valign="top"><table class="container" style="border-collapse: collapse; border-spacing: 0; padding: 0; vertical-align: top; mso-table-lspace: 0pt; mso-table-rspace: 0pt; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; width: 600px; margin: 0 auto 30px auto; text-align: inherit;" border="0" cellspacing="0" cellpadding="0"><tbody><tr style="padding: 0; vertical-align: top; text-align: left;"><td class="content" style="word-wrap: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; mso-table-lspace: 0pt; mso-table-rspace: 0pt; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; color: #444; font-family: Helvetica,Arial,sans-serif; font-weight: normal; margin: 0; text-align: left; font-size: 14px; mso-line-height-rule: exactly; line-height: 140%; background-color: #ffffff; padding: 60px 75px 45px 75px; border-right: 1px solid #ddd; border-bottom: 1px solid #ddd; border-left: 1px solid #ddd; border-top: 3px solid #809eb0;" align="left" valign="top"><div class="success"><p class="text-large" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; color: #444; font-family: Helvetica,Arial,sans-serif; font-weight: normal; padding: 0; text-align: left; mso-line-height-rule: exactly; line-height: 140%; margin: 0 0 15px 0; font-size: 14px;">'.__('Hey ,', 'reviewx').'[CUSTOMER_NAME]</p><p class="text-large" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; color: #444; font-family: Helvetica,Arial,sans-serif; font-weight: normal; padding: 0; text-align: left; mso-line-height-rule: exactly; line-height: 140%; margin: 0 0 15px 0; font-size: 14px;">'.__('Thank you purchasing items from the ','reviewx').' [SHOP_NAME].'.__(' We love to know your experiences with the product(s) that you recently purchased.', 'reviewx').'</p><p class="text-large" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; color: #444; font-family: Helvetica,Arial,sans-serif; font-weight: normal; padding: 0; text-align: left; mso-line-height-rule: exactly; line-height: 140%; margin: 0 0 15px 0; font-size: 14px;">'.__('You can browse a list of orders from your account page and can submit your feedback based on multiple criteria that we specially designed for you. To browse your orders: ', 'reviewx').'[MY_ORDERS_PAGE]</p><p class="text-large" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; color: #444; font-family: Helvetica,Arial,sans-serif; font-weight: normal; padding: 0; text-align: left; mso-line-height-rule: exactly; line-height: 140%; margin: 0 0 15px 0; font-size: 14px;">[ORDER_DATE]'.__(' you placed the order ', 'reviewx').'[ORDER_ID]</p><p class="text-large" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; color: #444; font-family: Helvetica,Arial,sans-serif; font-weight: normal; padding: 0; text-align: left; mso-line-height-rule: exactly; line-height: 140%; margin: 0 0 15px 0; font-size: 14px;">[ORDER_ITEMS]</p><p class="text-large" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; color: #444; font-family: Helvetica,Arial,sans-serif; font-weight: normal; padding: 0; text-align: left; mso-line-height-rule: exactly; line-height: 140%; margin: 0 0 15px 0; font-size: 14px;">'.__('Your feedback means a lot to us! Thanks for being a loyal ', 'reviewx').'[SHOP_NAME] '.__('customer.', 'reviewx').'</p><p class="text-large" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; color: #444; font-family: Helvetica,Arial,sans-serif; font-weight: normal; padding: 0; text-align: left; mso-line-height-rule: exactly; line-height: 140%; margin: 0 0 15px 0; font-size: 14px;">'.__('Regards,', 'reviewx').'</p><p class="text-large" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; color: #444; font-family: Helvetica,Arial,sans-serif; font-weight: normal; padding: 0; text-align: left; mso-line-height-rule: exactly; line-height: 140%; margin: 0 0 15px 0; font-size: 14px;">'.__('Team ', 'reviewx').'[SHOP_NAME]</p></div><h6>'.__('If you want to unsubscribe this email please go to this ', 'reviewx').'[UNSUBSCRIBE_LINK]</h6></td></tr></tbody></table></td></tr></tbody></table>',
                    'rx_mail_reset_template'    => __( 'Reset Template', 'reviewx'),
                    'rx_mail_asked_for_reset'   => __( 'Would you like to reset your email content?', 'reviewx'),
                    'rx_mail_reset_confirm_button_text' => __( 'Reset', 'reviewx'),
                    'rx_mail_reset_success_text' => __( 'Successfully email template reset!', 'reviewx' ),

               ) );
                wp_localize_script( $this->plugin_name . '-admin-script', 'ajax_admin', $js_filter );
            }

            $this->builder_args = ReviewxMetaBox::get_review_email_args();

            $builder_args = $this->builder_args;
            $tabs         = $this->builder_args['tabs'];
            $prefix       = self::$prefix;
            $metabox_id   = $builder_args['id'];
            /**
             * This lines of code is for editing a reviewx in simple|quick builder
             *
             * @var  [type]
             */
            $idd = null;
            if( isset( $_GET['post_id'] ) && ! empty( $_GET['post_id'] ) ) {
                $idd = intval( wp_unslash($_GET['post_id']) );
            }

            include_once REVIEWX_PARTIALS_PATH . 'admin/review_email.php';

        }

        /**
         * Genereate Unsubscribe email page
         *
         * @return void
         */
        public function generateUnsubscribeEmailPage()
        {
            \ReviewX\Modules\Activator::setupPages();
        }

        /**
         * Generate the builder data acording to default meta data
         *
         * @param array $data
         * @return array
         * @since    1.0.0
         */
        protected function builder_data( $data )
        {
            $post_data   = [];
            $prefix      = self::$prefix;
            $meta_fields = ReviewxMetaBox::get_option_fields( $prefix );

            foreach( $meta_fields as $meta_key => $meta_field ) {

                if( in_array( $meta_key, array_keys($data) ) ) {
                     
                    $post_data[ $meta_key ] = $data[ $meta_key ];
                } else {
                    $post_data[ $meta_key ] = '';                 

                    if( isset( $meta_field['defaults'] ) ) {
                        $post_data[ $meta_key ] = $meta_field['defaults'];
                    }

                    if( isset( $meta_field['default'] ) ) {
                        $post_data[ $meta_key ] = $meta_field['default'];                    

                        if( $meta_key == 'rx_option_allow_multi_criteria' ){
                            $post_data[ $meta_key ] = '';
                        }                        

                        if( $meta_key == 'rx_option_allow_img' ){
                            $post_data[ $meta_key ] = '';
                        }
                        
                        if( $meta_key == 'rx_option_allow_recommendation' ){
                            $post_data[ $meta_key ] = '';
                        }
                        
                        if( $meta_key == 'rx_option_completed' ){
                            $post_data[ $meta_key ] = '';
                        }   
                        
                        if( $meta_key == 'rx_option_filter_recent' ){
                            $post_data[ $meta_key ] = '';
                        } 
                        
                        if( $meta_key == 'rx_option_filter_photo' ){
                            $post_data[ $meta_key ] = '';
                        } 
                        
                        if( $meta_key == 'rx_option_filter_text' ){
                            $post_data[ $meta_key ] = '';
                        } 
                        
                        if( $meta_key == 'rx_option_filter_rating' ){
                            $post_data[ $meta_key ] = '';
                        }  

                        if( $meta_key == 'rx_option_filter_low_rating' ){
                            $post_data[ $meta_key ] = '';
                        }  
                        
                        if( $meta_key == 'rx_option_allow_media_compliance' ){
                            $post_data[ $meta_key ] = '';
                        }

                        if( class_exists('ReviewXPro') ) {      
                            
                            if( $meta_key == 'rx_option_filter_video' ){
                                $post_data[ $meta_key ] = '';
                            }
                                                        
                            if( $meta_key == 'rx_option_disable_auto_approval' ){
                                $post_data[ $meta_key ] = '';
                            }

                            if( $meta_key == 'rx_option_allow_video' ){
                                $post_data[ $meta_key ] = '';
                            }

                            if( $meta_key == 'rx_option_allow_anonymouse' ){
                                $post_data[ $meta_key ] = '';
                            }

                            if( $meta_key == 'rx_option_allow_share_review' ){
                                $post_data[ $meta_key ] = '';
                            }

                            if( $meta_key == 'rx_option_allow_like_dislike' ){
                                $post_data[ $meta_key ] = '';
                            }

                            if( $meta_key == 'rx_option_allow_multiple_review' ){
                                $post_data[ $meta_key ] = '';
                            }
                        }                                        

                        if( $meta_key == 'rx_option_allow_review_title' ){
                            $post_data[ $meta_key ] = '';
                        }
                        
                    }                    
                }
            }

            return array_merge( $post_data, $data );
        }

        /**
         * @param string $query_var
         * @param bool $builder_form
         * @return string|void
         */
        public static function get_form_action( $query_var = '', $builder_form = false )
        {
            $page = '/admin.php?page=rx-settings';

            if( $builder_form ) {
                $page = '/admin.php?page=rx-wc-settings';
            }

            if ( is_network_admin() ) {
                return network_admin_url( $page . $query_var );
            } else {
                return admin_url( $page . $query_var );
            }
        }

        /**
         * @param string $query_var
         * @param bool $builder_form
         * @return string|void
         */
        public static function get_review_email_action()
        {
            $page = '/admin.php?page=reviewx-review-email';
            return admin_url( $page );
        }

        /**
         * Save Quick setup current tab
         *
         * @return void
         */
        public function save_quick_setup_current_tab()
        {
            check_ajax_referer( 'special-string', 'security' );
            $current_tab = sanitize_text_field( $_POST['tab'] );
            update_option( '_rx_builder_quick_setup', $current_tab );
            wp_die();
        }

        /**
         * Save current tab
         * @param none
         * @since    1.0.0
         */
        public function save_current_tab()
        {
            check_ajax_referer( 'special-string', 'security' );
            $current_tab = sanitize_text_field( $_POST['tab'] );
            $current_page = sanitize_text_field( $_POST['page'] );
            if( $current_page == 'rx-wc-settings' ) {
                update_option( '_rx_builder_current_tab', $current_tab );
            } else if( $current_page == 'reviewx-quick-setup' ) {
                update_option( '_rx_builder_quick_setup', $current_tab );
            }            
            wp_die();
        }

        /**
         * Save settings value
         *
         * @param none
         * @return array
         */
        public function save_setting_tab()
        {
            check_ajax_referer( 'special-string', 'security' );
            $data 				= [];
            $rx_setting_tab_arg = wp_unslash($_POST['rx_tab_field']);
            $rx_tab_arg 		= $this->set_rating_arg( $rx_setting_tab_arg );
            // Below these functions will be activated for next released
            $rx_ctr_key 		= $this->set_ctr_key( $rx_setting_tab_arg );
            $rx_ctr_key_value   = array_combine($rx_ctr_key, $rx_tab_arg);

            foreach ( $rx_setting_tab_arg as $key => $value ) {
                if( $value['name'] == 'rx_option_review_criteria[]' || $value['name'] == 'rx_option_review_criteria_name[]' ) {
                    $data['rx_option_review_criteria'] = $rx_ctr_key_value;
                    continue;
                } else {
                    $data[$value['name']] = $value['value'];
                }
            }

            if ($data['rx_builder_from_where'] == "settings") {
                
                $optFormID = LockForm::SETTINGS;
                if (! OptimisticLock::validate($optFormID, $data)) {
                    OptimisticLock::errorResponse($optFormID);
                }

                (new CriteriaController())->handleAction($data['rx_option_review_criteria']);
            }

            if ($data['rx_builder_from_where'] == "quick_setup") {
                
                $optFormID = LockForm::QUICK_SETUP;
                if (! OptimisticLock::validate($optFormID, $data)) {
                    OptimisticLock::errorResponse($optFormID);
                }

                (new CriteriaController())->handleAction($data['rx_option_review_criteria']);
            }

            if ($data['rx_builder_from_where'] == "review_email") {
                
                if (\ReviewX_Helper::is_pro()) {
                    $this->reviewEmailFields();
                }

                $optFormID = LockForm::REVIEW_EMAIL;
                if (! OptimisticLock::validate($optFormID, $data)) {
                    OptimisticLock::errorResponse($optFormID);
                }
                
                function isHTML($string){
                    return ($string != strip_tags($string));
                }
                
                if (! isHTML($data['rx_option_email_editor'])) {
                    $data['rx_option_email_editor'] = nl2br($data['rx_option_email_editor']);                 
                }

                EmailSettings::setCurrentTemplateHash($data['rx_option_email_subject'] . $data['rx_option_email_editor']);
            }

            ReviewxMetaBox::save_data( $this->builder_data( $data ), $data['rx_builder_from_where'] );

            if ( $data['rx_builder_current_tab'] == "email_tab" && isset($_POST['filter']) ) {
                $this->sendEmail(false);
            }

            $success_status = ($data) ? true : false;
            $return = array_merge(array(
                'success' => $success_status,
                'current_tab' => $data,
                'settings' => $this->builder_data( $data ),
            ), OptimisticLock::successResponse($optFormID));

            wp_send_json($return);

        }

        /**
         * Return array for rating criteria
         *
         * @param $rating_arg
         * @return array
         */
        public function set_rating_arg( $rating_arg )
        {
            $rating_data = [];
            foreach ( $rating_arg as $key => $value ) {
                if( $value['name'] == 'rx_option_review_criteria[]') {
                    array_push( $rating_data, trim( sanitize_text_field($value['value']) ) );
                }
            }

            return $rating_data;
        }

        /**
         * Return array for rating criteria key
         *
         * @param $rating_arg
         * @return array
         */
        public function set_ctr_key( $rating_arg )
        {
            $rating_key = [];
            foreach ( $rating_arg as $key => $value ) {
                if( $value['name'] == 'rx_option_review_criteria_name[]') {
                    array_push( $rating_key, trim( sanitize_text_field($value['value']) ) );
                }
            }

            return $rating_key;
        }

        /**
         * Load custom CSS
         *
         * @param none
         * @return void
         */
        public function load_admin_custom_css()
        {
            // $screen = get_current_screen();
            // global $parent_file, $submenu_file;
            // if ( $screen->base == 'reviewx_page_rx-wc-settings' ) :
            //     $parent_file = 'rx-admin';
            //     $submenu_file = 'post-new.php?post_type=reviewx';
            // endif;
            include_once REVIEWX_PARTIALS_PATH . 'admin/admin-custom-css.php';
        }

        public function sendScheduleEmail()
        {
            $unreviewdOrderWiseProduct = [];

            (new EmailSettings())->createScheduleEmail($unreviewdOrderWiseProduct);

            wp_send_json(array(
                'success' => true,
                'mailed' => $unreviewdOrderWiseProduct,
            ));
        }

        public function sendNowEmail()
        {
            (new EmailSettings())->sendNowEmail($_POST['order_id']);
        }

        public function sendCancelled()
        {
            (new EmailSettings())->cancelledScheduleEmail($_POST['order_id']);
        }

        public function sendEmail($return = true)
        {
            $unreviewdOrderWiseProduct = [];

            (new EmailSettings())->processBulkEmail($unreviewdOrderWiseProduct);

            if (! is_bool($return)) {
                $return  = boolval($_POST['returned']);
            }

            if ($return) {
                wp_send_json(array(
                    'success' => true,
                    'mailed' => $unreviewdOrderWiseProduct,
                ));
            }
        }

        /**
         * Review Email Fields
         *
         * @return void
         */
        public function reviewEmailFields()
        {
            add_filter('rx_reminder_email_settings_sections', function($items) {
				return array(
                    'order_status' => array(
                        'title'  => __('Automatic Reminder Email', 'reviewx'),
                        'fields' => array(
                            'auto_review_reminder' => array(
                                'heading' => __('Auto Review Reminder', 'reviewx'),
                                'label'  => __('', 'reviewx'),
                                'type'  => 'switcher',
                            ),
                            'get_review_email'  => array(
                                'type'      => 'number',
                                'heading'   => __( 'Days to Wait', 'reviewx' ),
                                'label'     => __('After the order is completed how long \'ReviewX\' should wait to send the review reminder email.', 'reviewx'),
                                'default'   => 5
                            ),
                            // 'filter_products_email'  => array(
                            //     'type'      => 'switcher',
                            //     'heading'     => __('Filter Products', 'reviewx'),
                            //     'default'   => 5
                            // ),
                            // 'filter_products_by' => array(
                            //     'type'    => 'select',
                            //     'heading'   => __( 'Filter by', 'reviewx' ),
                            //     'label'   => __( 'Based on your selection ReviewX will send the review reminder email', 'reviewx' ),
                            //     'options' => array(
                            //         'most_reviewed'     => __( 'Most reviewed product', 'reviewx' ),
                            //         'lowest_reviewed'   => __( 'Lowest reviewed product', 'reviewx' ),
                            //         'highest_price' => __( 'Products with highest price', 'reviewx' ),
                            //         'lowest_price'  => __( 'Products with lowest price', 'reviewx' ),
                            //         'max_quantity'  => __( 'Products with max. quantity', 'reviewx' ),
                            //         'min_quantity'  => __( 'Products with min. quantity', 'reviewx' ),
                            //     ),
                            //     'default'  => 'most_reviewed',
                            // )
                        )
                    ),
                    'allow_utilities' => array(
                        'title'  => __('Other Settings', 'reviewx'),
                        'fields' => array(       
                            'consent_email_subscription' => array(
                                'type' => 'switcher',
                                'heading'   => __('Consent on Checkout Page', 'reviewx'),
                                'label' => __('Allow customers to decide whether they want to receive the review reminder email or not. If you check this box the customer will have a checkbox into their checkout page to decide email consent.', 'reviewx'),
                            ),                     

                            'how_many_email'  => array(
                                'type'      => 'number',
                                'heading'   => __('Email Per Order', 'reviewx'),
                                'label'     => __('Set how many reminder email(s) a customer should receive for single order.', 'reviewx'),
                                'default'   => 5
                            ),
                            'unsubscribe_url' => array(
                                'type'      => 'text',
                                'heading'   => __('Unsubscribe URL', 'reviewx'),
                                'label'     => __('Check the unsubscribe page link. BTW, you are free to modify the page content.', 'reviewx'),
                                'default'   => !empty(get_option('_rx_option_unsubscribe_url') ) ? esc_url( get_option('_rx_option_unsubscribe_url') ) : get_permalink(get_page_by_path('rx-schedule-email-unsubscribe')),
                                'disabled'  => true
                            ),
                        )
                    ), 
                );
			} );
        }

        /**
         * Save Review Email current tab
         * @param none
         * @since    1.0.0
         */
        public function save_review_email_current_tab()
        {
            check_ajax_referer( 'special-string', 'security' );
            $current_tab = sanitize_text_field( $_POST['tab'] );
            update_option( '_rx_review_email_current_tab', $current_tab );
            wp_die();
        }

        /**
        * Register the ReviewX custom post type.
        *
        * @since	1.0.0
        */
        public function register() {

            $labels = array(
                'name'                => 'ReviewX',
                'singular_name'       => 'ReviewX',
                'add_new'             => esc_html__( 'Add New', 'reviewx' ) ,
                'add_new_item'        => esc_html__( 'Add New', 'reviewx' ),
                'edit_item'           => esc_html__( 'Edit', 'reviewx' ),
                'new_item'            => esc_html__( 'New', 'reviewx' ),
                'view_item'           => esc_html__( 'View', 'reviewx' ),
                'search_items'        => esc_html__( 'Search', 'reviewx' ),
                'not_found'           => esc_html__( 'No reviewx x is found', 'reviewx' ),
                'not_found_in_trash'  => esc_html__( 'No reviewx x is found in Trash', 'reviewx' ),
                'menu_name'           => 'ReviewX',
            );

            $args = array(
                'labels'              => $labels,
                'hierarchical'        => false,
                'description'         => '',
                'taxonomies'          => array( '' ),
                'public'              => false,
                'show_ui'             => true,
                'show_in_menu'        => 'ReviewX',
                'show_in_admin_bar'   => true,
                'show_in_rest'        => false,
                'menu_position'       => 80,
                'menu_icon'           => '',
                'show_in_nav_menus'   => false,
                'publicly_queryable'  => false,
                'exclude_from_search' => true,
                'has_archive'         => false,
                'query_var'           => true,
                'can_export'          => true,
                'rewrite'             => '',
                'capability_type'     => 'post',
                'supports'            => array( 'title' ),
            );

            register_post_type( $this->type, $args );
        }

        /**
         * Save screen option
         * @since 1.2.6
         */
        public function save_screen_options($status, $option, $value) {
            if ( 'reviewx_per_page' == $option ) return $value;
            return $status;
        }

        /**
         * Render screen options
         * @since 1.2.6
         */
        public function screen_options(){
            $option = 'per_page';
            $args = array(
                'label' => __('Number of ReviewX Per Page', 'reviewx'),
                'default' => 10,
                'option' => 'reviewx_per_page'
            );

            add_screen_option( $option, $args );
        }

        /**
         * Highlight admin menu
         *
         * @since    1.0.0
         * @param $hook
         */
        public function highlight_admin_menu( $parent_file ){
            if( $parent_file === 'ReviewX' ) {
                return 'rx-admin';
            }
            return $parent_file;
        }

        /**
         * Highlight submenu
         *
         * @since    1.0.0
         * @param $hook
         */
        public function highlight_admin_submenu( $submenu_file, $parent_file ){

            if( ( $parent_file == 'rx-admin' && $submenu_file == 'edit.php?post_type=reviewx' ) ) {
                return "post-new.php?post_type=reviewx";
            }
            return $submenu_file;
        }

        /**
         * Count cost
         *
         * @since    1.0.0
         * @param $hook
         */
        public static function count_posts( $type = 'reviewx', $perm = '' ) {
            global $wpdb;
            if ( ! post_type_exists( $type ) ) {
                return new stdClass;
            }
            $cache_key = 'nx_counts_cache';
            self::$counts = wp_cache_get( $cache_key, 'counts' );
            if ( false !== self::$counts ) {
                return self::$counts;
            }
            $query = "SELECT ID, post_status, meta_key, meta_value FROM {$wpdb->posts} INNER JOIN {$wpdb->postmeta} ON ID = post_id WHERE post_type = %s AND meta_key = '_rx_meta_active_check'";
            $results = (array) $wpdb->get_results( $wpdb->prepare( $query, $type ), ARRAY_A );
            $counts  = array_fill_keys( array( 'enabled', 'disabled', 'trash', 'publish' ), 0 );
            $disable = 0;
            $enable = 0;
            foreach ( $results as $row ) {
                $counts[ 'publish' ] = $counts['publish'] + ( $row['post_status'] === 'publish' ? 1 : 0 );
                $counts[ 'trash' ] = $counts['trash'] + ( $row['post_status'] === 'trash' ? 1 : 0 );

                if( $row[ 'meta_value' ] == 0 ) {
                    $disable = 1;
                    $enable = 0;
                }
                if( $row[ 'meta_value' ] == 1 ) {
                    $disable = 0;
                    $enable = 1;
                }

                if( $disable == 1 && $row['post_status'] == 'trash' ) {
                    $disable = 0;
                }

                if( $enable == 1 && $row['post_status'] == 'trash' ) {
                    $enable = 0;
                }

                $counts[ 'disabled' ] = $counts[ 'disabled' ] + $disable;
                $counts[ 'enabled' ] = $counts[ 'enabled' ] + $enable;
            }
            self::$counts = (object) $counts;
            wp_cache_set( $cache_key, self::$counts, 'counts' );
            return self::$counts;
        }

        public function reviewx() {

            $all_active_class = $enabled_active_class = $disabled_active_class = $trash_active_class = $pagenow = '';
            $paged                  = 1;
            $count_posts            = self::count_posts();
            $screen                 = get_current_screen();
            $user                   = get_current_user_id();
            $option                 = $screen->get_option('per_page', 'option');
            $per_page               = get_user_meta($user, $option, true);
            $per_page               = empty( $per_page ) ? 10 : $per_page;
            $total_page             = ceil( $count_posts->publish / $per_page );
            $pagination_current_url = admin_url('admin.php?page=rx-admin');

            $post_args = array(
                'post_type'         => 'reviewx',
                'numberposts'       => -1,
                'posts_per_page'    => $per_page,
            );

            if( isset( $_GET['page'] ) && $_GET['page'] == 'rx-admin' ) {
                $all_active_class = 'class="active"';
                $pagenow = 'publish, draft';
                if( isset( $_GET['status'] ) && $_GET['status'] == 'enabled' ) {
                    $pagination_current_url = add_query_arg('status', 'enabled', $pagination_current_url);
                    $enabled_active_class   = 'class="active"';
                    $all_active_class       = '';
                    $pagenow                = 'publish';
                    $total_page             = ceil( $count_posts->enabled / $per_page );
                    $post_args              = array_merge( $post_args, array( 'meta_query' => array(
                                                array(
                                                    'key'     => '_rx_meta_active_check',
                                                    'value'   => 1,
                                                    'compare' => '=',
                                                ),
                                            )));
                }
                if( isset( $_GET['status'] ) && $_GET['status'] == 'disabled' ) {
                    $pagination_current_url = add_query_arg('status', 'disabled', $pagination_current_url);
                    $disabled_active_class  = 'class="active"';
                    $all_active_class       = '';
                    $pagenow                = 'publish';
                    $total_page             = ceil( $count_posts->disabled / $per_page );
                    $post_args              = array_merge( $post_args, array( 'meta_query' => array(
                                                array(
                                                    'key'     => '_rx_meta_active_check',
                                                    'value'   => 0,
                                                    'compare' => '=',
                                                ),
                                            )));
                }
                if( isset( $_GET['status'] ) && $_GET['status'] == 'trash' ) {
                    $pagination_current_url = add_query_arg('status', 'trash', $pagination_current_url);
                    $trash_active_class     = 'class="active"';
                    $all_active_class       = '';
                    $pagenow                = 'trash';
                    $total_page             = ceil( $count_posts->trash / $per_page );
                }
                if( isset( $_GET['paged'] ) ) {
                    if( intval( $_GET['paged'] ) > 0 ) {
                        $paged = intval( $_GET['paged'] );
                    }
                }
            }

            $post_args = array_merge( $post_args, array( 'post_status' => explode(', ', $pagenow), 'offset' => ( ( $paged - 1 ) * $per_page ) ));
            $reviewx = new \WP_Query( $post_args );

            $table_header = apply_filters( 'rx_admin_table_header', array(
                'ReviewX Title',
                __('Status', 'reviewx'),
                __('Date', 'reviewx'),
            ));

            include REVIEWX_PARTIALS_PATH . 'admin/setting-header.php';
            include REVIEWX_PARTIALS_PATH . 'admin/rx-admin.php';
        }

        /**
         * Redirect after publish
         *
         * @since    1.0.0
         * @param $hook
         */
        public function redirect_after_publish( $post_ID, $post, $update ){

            if( ( isset( $_POST['is_quick_builder'] ) && $_POST['is_quick_builder'] == true ) || ( isset( $_GET['action'], $_GET['page'] ) && $_GET['action'] == 'rxduplicate' ) ) {
                return;
            }
            if( isset( $post->post_type ) && $post->post_type == 'reviewx' ) {
                if( isset( $post->post_status ) && $post->post_status == 'publish' ) {
                    $current_url = admin_url('admin.php?page=rx-admin');
                    wp_safe_redirect( $current_url );
                    exit;
                }
            }
            return $post_ID;
        }


        /**
         * For Duplicate ReviewX
         * @param string $current_url
         * @return void
         */
        protected function duplicate_reviewx( $current_url = '' ){
            if( empty( $current_url ) ) {
                return;
            }
            // Duplicating ReviewX
            if( isset( $_GET['action'], $_GET['page'], $_GET['post'], $_GET['rx_duplicate_nonce'] )
            && $_GET['action'] === 'rxduplicate' && $_GET['page'] === 'rx-admin' ) {
                if( wp_verify_nonce( $_GET['rx_duplicate_nonce'], 'rx_duplicate_nonce' ) ) {
                    $nx_post_id = intval( $_GET['post'] );
                    $get_post = get_post( $nx_post_id );
                    $post_data = json_decode( json_encode( $get_post ), true );
                    unset( $post_data['ID'] );
                    unset( $post_data['post_date'] );
                    unset( $post_data['post_date_gmt'] );
                    $post_data['post_title'] = $post_data['post_title'] . ' - Copy';
                    $duplicate_post_id = wp_insert_post( $post_data );
                    $duplicate_post_id = intval( $duplicate_post_id );
                    $get_post_meta = get_metadata( 'post', $nx_post_id );
                    if( ! empty( $get_post_meta ) ) {
                        foreach( $get_post_meta as $key => $value ){
                            if( in_array( $key, array( '_edit_lock', '_edit_last', '_rx_meta_views', '_rx_meta_active_check' ) ) ) {
                                continue;
                            }
                            if( $key === '_rx_meta_impression_per_day' ) {
                                add_post_meta( $duplicate_post_id, $key, array() );
                            } else {
                                add_post_meta( $duplicate_post_id, $key, $value[0] );
                            }
                        }
                    }
                    wp_safe_redirect( $current_url );
                    exit;
                }
            }
        }

        /**
         * For Empty Trash
         * @return void
         */
        protected function empty_trash( $current_url = '' ) {
            if( empty( $current_url ) ) {
                return;
            }
            if( isset( $_GET['delete_all'], $_GET['page'] ) && $_GET['delete_all'] == true && $_GET['page'] == 'rx-admin' ) {
                $reviewx = new \WP_Query(array(
                    'post_type' => 'reviewx',
                    'post_status' => array('trash'),
                    'numberposts' => -1,
                ));
                if( $reviewx->have_posts() ) {
                    while( $reviewx->have_posts() ) : $reviewx->the_post();
                        $iddd = get_the_ID();
                        wp_delete_post( $iddd );
                    endwhile;
                    wp_safe_redirect( $current_url ); // TODO: after all remove trash redirect.
                    die;
                }
            }
        }

        /**
         * For Enable and Disable ReviewX.
         * @param string $current_url
         * @return void
         */
        protected function enable_disable( $current_url = '' ){
            if( empty( $current_url ) ) {
                return;
            }
            // For Enable & Disable
            if( isset( $_GET['status'], $_GET['page'] ) && $_GET['page'] == 'rx-admin' ) {
                $post_status         = self::count_posts();
                $get_enabled_post    = $post_status->enabled;
                $get_disabled_post   = $post_status->disabled;
                $trash_reviewx       = $post_status->trash;

                if( ( $_GET['status'] == 'disabled' && $get_disabled_post == 0 )
                    || ( $_GET['status'] == 'trash' && $trash_reviewx == 0 )
                    || ( $_GET['status'] == 'enabled' && $get_enabled_post == 0 )
                ) {
                    wp_safe_redirect( $current_url );
                    die;
                }
            }
        }

        /**
         * Return post meta
         * @param int string, boolean
         * @return void
         */
        public static function get_post_meta( $post_id, $key, $single = true ) {
            return get_post_meta( $post_id, '_nx_meta_' . $key, $single );
        }

        /**
         * Update post meta
         * @param int string, mixed
         * @return void
         */
        public static function update_post_meta( $post_id, $key, $value ) {
            update_post_meta( $post_id, '_nx_meta_' . $key, $value );
        }

        /**
         * Admin Init For User Interactions
         * @return void
         */
        public function admin_init( $hook ) {
            /**
             * ReviewX Admin URL
             */
            $current_url = admin_url('admin.php?page=rx-admin');
            /**
             * For Duplicate ReviewX
             */
            $this->duplicate_reviewx( $current_url );
            /**
             * For Re-generate ReviewX for current custom post type
             * @since 1.4.0
             */
            // $this->regenerate_reviewx( $current_url );
            /**
             * For Empty Trash
             */
            $this->empty_trash( $current_url );
            /**
             * For Enable And Disable
             */
            $this->enable_disable( $current_url );
            /**
             * For Quick Builder Submit
             */
            //$this->quick_builder_submit( $current_url );

        }

        /**
         * Update review status
         * @param $_POST
         * @return void
         */        
        public function reviewx_status() {
            $error = false;

            if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'reviewx_status_nonce' ) ) {
                $error = true;
            }

            if( isset( $_POST['post_id'] ) && $_POST['post_id'] == 'wc' ) {

                $status = $_POST['status'] == 'active' ? '1' : '0';

                update_option( '_rx_wc_active_check', $status );
                if( isset( $_POST['url'] ) ) {
                    wp_safe_redirect( $_POST['url'] );
                }
                echo 'success';
                die();

            } else {

                if ( ! isset( $_POST['post_id'] ) || empty( $_POST['post_id'] ) || ! absint( $_POST['post_id'] ) ) {
                    $error = true;
                }

                if ( $error ) {
                    echo __('There is an error updating status.', 'reviewx');
                    die();
                }

                $post_id = absint( $_POST['post_id'] );
                $status = $_POST['status'] == 'active' ? '1' : '0';

                update_post_meta( $post_id, '_rx_meta_active_check', $status );
                if( isset( $_POST['url'] ) ) {
                    wp_safe_redirect( $_POST['url'] );
                }
                echo 'success';
                die();

            }

        }

        /**
         * Check custom post type exists 
         * @param $_POST
         * @return void
         */        
        public function check_custom_post_type_exists() {

            check_ajax_referer( 'special-string', 'security' );
            $cpt_id  = sanitize_text_field( $_POST['cpt_id'] );
            $post_id = sanitize_text_field( $_POST['post_id'] );

            $cpt = get_post_meta($post_id, '_rx_meta_custom_post_types', true );
            if( $cpt == $cpt_id ) {
                $return = array(
                    'success' => true,
                    'self'    => true
                );
                wp_send_json($return);
            } else {
                $args = array(
                    'post_type' => 'reviewx',
                    'meta_query' => array(
                        array(
                            'key' => '_rx_meta_custom_post_types',
                            'value' => $cpt_id
                        )
                    )
                );
                $query = new \WP_Query($args);
                if( $query->post_count > 0 ){
                    $return = array(
                        'success' => false,
                        'self'    => false
                    );
                } else {
                    $return = array(
                        'success' => true,
                        'self'    => true
                    );
                }

                wp_send_json($return);
            }

        }

        /**
         * Load settings page
         * @param $_POST
         * @return void
         */         
        public function general_settings() {

            $this->builder_args = ReviewxMetaBox::get_general_settings_args();
            $builder_args = $this->builder_args;
            $tabs         = $this->builder_args['tabs'];
            $prefix       = self::$prefix;
            //$metabox_id   = $this->metabox_id;
            include_once REVIEWX_PARTIALS_PATH . 'admin/general-settings.php';

        }

        /**
         * Update review title
         * @param $_POST
         * @return void
         */         
        public function update_reviewx_title() {

            if( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'editedcomment' ) {
                $review_id = sanitize_text_field( $_REQUEST['comment_ID'] );
                $reviewx_title = sanitize_text_field( $_REQUEST['newcomment_review_title'] );
                update_comment_meta( $review_id, 'reviewx_title', $reviewx_title, false );
            }
            
        }

    }
}