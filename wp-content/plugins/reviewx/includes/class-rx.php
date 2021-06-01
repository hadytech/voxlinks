<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @version 1.0.0
 */
class ReviewX {

	protected $loader;
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
	 * @since    1.0.0
	 */
	public function __construct() {

		if ( defined( 'REVIEWX_VERSION' ) ) {
			$this->version = REVIEWX_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'reviewx';

		$this->load_dependencies();
		$this->set_locale();
		$this->start_plugin_tracking();
		add_action( 'plugins_loaded', array( $this, 'load_extensions' ) );
        add_action( 'plugins_loaded', array( $this, 'define_admin_hooks' ) );
        add_action( 'plugins_loaded', array( $this, 'define_public_hooks' ) );
		add_action( 'admin_init', array( $this, 'redirect' ) );
	}
	/**
	 * Optional usage tracker
	*/
	public function start_plugin_tracking() {
		if( ! class_exists( 'ReviewX_Plugin_Tracker' ) ) {
			require_once REVIEWX_ROOT_DIR_PATH . 'includes/class-plugin-tracker.php';
		}
		$tracker = ReviewX_Plugin_Tracker::get_instance( REVIEWX_FILE, [
			'opt_in'       => true,
			'goodbye_form' => true,
			'item_id'      => '4e847de6b14caef854e8'
		] );
		$tracker->set_notice_options(array(
			'notice' => __( 'Want to help make <strong>ReviewX</strong> even more awesome? You can get upto <strong>30% discount coupon</strong> for Premium extensions if you allow us to track the usage.', 'reviewx' ),
			'extra_notice' => __( 'We collect non-sensitive diagnostic data and plugin usage information. Your site URL, WordPress & PHP version, plugins & themes and email address to send you the discount coupon. This data lets us make sure this plugin always stays compatible with the most popular plugins and themes. No spam, I promise.', 'reviewx' ),
		));
		$tracker->init();
	}


    /**
     * Redirect to setting page when WooCommerce plugin is activated
     */
    public function redirect() {
        // Bail if no activation transient is set.
        if ( ! get_transient( '_rx_plugin_activation' ) ) {
            return;
        }
        // Delete the activation transient.
        delete_transient( '_rx_plugin_activation' );

		if( get_option( '_rx_wc_active_check' ) == 0 ) {
			wp_safe_redirect( add_query_arg( array(
				'page'		=> 'rx-admin'
			), admin_url( 'admin.php' ) ) );
		} else {
			wp_safe_redirect( add_query_arg( array(
				'page'		=> 'reviewx-quick-setup'
			), admin_url( 'admin.php' ) ) );
		}
    }

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * This file for upload image from frontend
		 */
		//require_once REVIEWX_ROOT_DIR_PATH . 'includes/class-rx-attachment.php';
		require_once REVIEWX_ROOT_DIR_PATH . 'includes/class-rx-db.php';
		require_once REVIEWX_ROOT_DIR_PATH . 'includes/class-rx-loader.php';
		require_once REVIEWX_ROOT_DIR_PATH . 'includes/class-rx-message.php';
		require_once REVIEWX_ROOT_DIR_PATH . 'includes/class-rx-helper.php';
		require_once REVIEWX_ROOT_DIR_PATH . 'includes/class-rx-i18n.php';

		require_once REVIEWX_ROOT_DIR_PATH . 'includes/class-rx-extension-factory.php';
		require_once REVIEWX_ROOT_DIR_PATH . 'includes/class-rx-extension.php';

		require_once REVIEWX_ROOT_DIR_PATH . 'includes/class-rx-user-avatar.php';
		require_once REVIEWX_ROOT_DIR_PATH . 'includes/class-rx-user-avatar-shortcode.php';

		require_once REVIEWX_ROOT_DIR_PATH . 'app/Oxygen/oxygen.php';

		require_once REVIEWX_ROOT_DIR_PATH . 'app/RvxDivi/RvxDivi.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once REVIEWX_ROOT_DIR_PATH . 'partials/storefront/page-template/load-unsubscriber-template.php';
		do_action('reviewx_load_depedencies');

		$this->loader = new ReviewX_Loader();

	}

	/**
	 * This function is responsible for load all extensions
	 *
	 * @return void
	 */
	public function load_extensions(){
		global $rx_extension_factory;

		$extensions = [];

		foreach( $extensions as $key => $extension ) {
			/**
			 * Register the extension
			 */
			rx_register_extension( $extension, $key );
		}
		/**
		 * Init all extensions here.
		 */
		do_action( 'rx_extensions_init' );
		/**
		 * Load all extension.
		 */
		$rx_extension_factory->load();
	}


	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the ReviewX_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new ReviewX_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function define_admin_hooks() {

		$plugin_admin = new \ReviewX\Controllers\Admin\Core\ReviewxAdmin( $this->get_plugin_name(), $this->get_version() );
		$plugin_admin->metabox = new \ReviewX\Controllers\Admin\Core\ReviewxMetaBox;

		add_action( 'init', array( $plugin_admin, 'register') );
		add_action( 'admin_init', array( $plugin_admin, 'admin_init') );
		add_action( 'add_meta_boxes', array( $plugin_admin->metabox, 'add_meta_boxes') );
		add_filter( 'parent_file', array( &$plugin_admin, 'highlight_admin_menu' ) );
		add_filter( 'submenu_file', array( &$plugin_admin, 'highlight_admin_submenu' ), 10, 2);
		add_action( 'admin_menu', array( $plugin_admin, 'menu_page') );
		add_action( 'admin_enqueue_scripts', array( $plugin_admin, 'admin_enqueue_styles') );
		add_action( 'admin_enqueue_scripts', array( $plugin_admin, 'admin_enqueue_scripts') );
		add_action( 'save_post_reviewx', array( $plugin_admin->metabox, 'save_metabox') );
		add_action( 'wp_insert_post', array( $plugin_admin, 'redirect_after_publish'), 9999, 3 );
		add_action( 'rx_assign_rating_old_comment', array( $plugin_admin->metabox, 'rx_assign_rating_old_comment') );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function define_public_hooks() {

		$plugin_public = new \ReviewX\Controllers\Storefront\ReviewxPublic( $this->get_plugin_name(), $this->get_version() );
		add_action( 'wp_enqueue_scripts', array( $plugin_public, 'reviewx_enqueue_styles') );
		add_action( 'wp_enqueue_scripts', array( $plugin_public, 'reviewx_enqueue_scripts') );

	}



	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
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
	 * @return    ReviewX_Loader    Orchestrates the hooks of the plugin.
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

}