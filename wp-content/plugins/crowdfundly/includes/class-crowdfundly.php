<?php

/**
 * The file that defines the core plugin class
 *
 *
 * @link       https://wpdeveloper.net/
 * @since      1.0.0
 *
 * @package    Crowdfundly
 * @subpackage Crowdfundly/includes
 * @author     WPDeveloper 
 */
class Crowdfundly {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Crowdfundly_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'CROWDFUNDLY_VERSION' ) ) {
			$this->version = CROWDFUNDLY_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'crowdfundly';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Crowdfundly_Loader. Orchestrates the hooks of the plugin.
	 * - Crowdfundly_i18n. Defines internationalization functionality.
	 * - Crowdfundly_Admin. Defines all hooks for the admin area.
	 * - Crowdfundly_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

        require_once CROWDFUNDLY_ROOT_DIR_PATH . 'includes/class-crowdfundly-helper.php';

        /**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once CROWDFUNDLY_ROOT_DIR_PATH . 'includes/class-crowdfundly-loader.php';

		require_once CROWDFUNDLY_ROOT_DIR_PATH . 'includes/class-crowdfundly-api.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once CROWDFUNDLY_ROOT_DIR_PATH . 'includes/class-crowdfundly-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once CROWDFUNDLY_ROOT_DIR_PATH . 'admin/class-crowdfundly-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once CROWDFUNDLY_ROOT_DIR_PATH . 'public/class-crowdfundly-public.php';

		/**
		 * This class responsible for get/update settings
		 */
		require_once CROWDFUNDLY_ADMIN_DIR_PATH . 'includes/class-crowdfundly-settings.php';

		/**
		 * This class responsible for Page template
		 */
		require_once CROWDFUNDLY_ADMIN_DIR_PATH . 'includes/class-crowdfundly-page-template.php';

		/**
		 * This class responsible for short code
		 */
		require_once CROWDFUNDLY_PUBLIC_PATH . 'includes/class-crowdfundly-shortcode.php';

		$this->loader = new Crowdfundly_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Crowdfundly_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Crowdfundly_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	public function define_admin_hooks() {

		$plugin_admin = new Crowdfundly_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );		
        if (isset($_GET['page']) && (sanitize_text_field($_GET['page']) === 'crowdfundly-admin')) {
            $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'dashboard_scripts');
        }
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'menu_page' );
		$this->loader->add_action( 'wp_loaded', $plugin_admin, 'create_product' );
		$this->loader->add_action( 'admin_head', $plugin_admin, 'fav_icon' );
		
		$plugin_admin->ajax_call();
		Crowdfundly_Page_Template::get_instance();

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Crowdfundly_Public( $this->get_plugin_name(), $this->get_version() );
		
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
        $this->loader->add_action( 'init', $plugin_public, 'init' );
		$this->loader->add_action( 'init', $this, 'after_booted' );

		$this->loader->add_filter( 'woocommerce_add_to_cart_redirect', $plugin_public, 'add_to_cart_redirect' );
		$this->loader->add_filter( 'woocommerce_add_cart_item_data', $plugin_public, 'catch_and_save_submited_donation', 10, 2 );
		$this->loader->add_action( 'woocommerce_before_calculate_totals', $plugin_public, 'add_donation_to_item_price', 10, 1 );
		$this->loader->add_filter( 'woocommerce_available_payment_gateways', $plugin_public, 'unset_gateway_by_product' );		
		$this->loader->add_filter( 'woocommerce_checkout_fields', $plugin_public, 'remove_order_notes' );
		$this->loader->add_filter( 'woocommerce_email_recipient_customer_processing_order', $plugin_public, 'disable_customer_email_notification_for_donation', 10, 2 );
		$this->loader->add_filter( 'woocommerce_currency_symbol', $plugin_public, 'change_existing_currency_symbol', PHP_INT_MAX, 2 );
		$this->loader->add_filter( 'woocommerce_currency', $plugin_public, 'change_wc_currency_by_saas', PHP_INT_MAX, 1 );	
		$this->loader->add_action( 'woocommerce_payment_complete', $plugin_public, 'crowdfundly_donation_complete' );	
		$this->loader->add_action( 'woocommerce_add_order_item_meta',$plugin_public, 'add_donation_item_meta', 1,2);

		$this->loader->add_action( 'wp_ajax_crowdfundly_single_campaign_activites_log', $plugin_public, 'crowdfundly_single_campaign_activites_log' );
		$this->loader->add_action( 'wp_ajax_nopriv_crowdfundly_single_campaign_activites_log', $plugin_public, 'crowdfundly_single_campaign_activites_log' );
		$this->loader->add_action( 'wp_ajax_crowdfundly_all_campaign_load_more', $plugin_public, 'crowdfundly_all_campaign_load_more' );
		$this->loader->add_action( 'wp_ajax_nopriv_crowdfundly_all_campaign_load_more', $plugin_public, 'crowdfundly_all_campaign_load_more' );
		
		$this->loader->add_action( 'woocommerce_before_order_notes', $plugin_public, 'crowdfundly_custom_cart_field' );
		$this->loader->add_filter( 'woocommerce_order_button_text', $plugin_public, 'change_place_order_label' );
		$this->loader->add_action( 'woocommerce_checkout_update_order_meta', $plugin_public, 'give_anonymously_field_update_order_meta', 10, 1 );
		$this->loader->add_action( 'woocommerce_admin_order_data_after_billing_address', $plugin_public, 'display_give_anonymously_on_order_edit_pages', 10, 1 );
		$this->loader->add_action( 'woocommerce_checkout_process', $plugin_public, 'checkout_validate' );
		$this->loader->add_action( 'woocommerce_cart_calculate_fees', $plugin_public, 'add_shipping_fee', 20, 1 );
		$this->loader->add_action( 'woocommerce_thankyou', $plugin_public, 'crowdfundly_remove_cart_data', 10, 1 );
		$this->loader->add_action( 'wp_head', $plugin_public, 'fav_icon' );
		$this->loader->add_action( 'wp_loaded', $plugin_public, 'crowdfundly_coupon_filter' );	

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
		Crowdfundly_Api::crowdfundly_logout_route();
		Crowdfundly_Api::crowdfundly_track_changed_organization();
		$this->crowdfundly_customizer();
		$this->crowdfundly_elmentor();
    }

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Crowdfundly_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	public function after_booted() {
        add_filter('the_title', array($this, 'changeOrganizationPageTitle'));
    }

	public function changeOrganizationPageTitle($title) {
		$crowdfundly_user = get_option( 'crowdfundly_user', null );
        if ( ( $title == "Organization" ) && $crowdfundly_user ) {
			return $crowdfundly_user->name;
        }

        return $title;
	}
	
	/**
	 * Customizer Class initialize
	 */
	public function crowdfundly_customizer() {
		require CROWDFUNDLY_ADMIN_DIR_PATH . 'customizer/customizer.php';
		new CrowdFundly_Customize();
	}

	/**
	 * Elementor Class initialize
	 */
	public function crowdfundly_elmentor() {
		require CROWDFUNDLY_ROOT_DIR_PATH . 'pagebuilders/elementor/crowdfundly-elementor.php';
		CrowdFundly_Elementor::instance();
	}

}