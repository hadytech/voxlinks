<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://easy.jobs
 * @since      1.0.0
 *
 * @package    Easyjobs
 * @subpackage Easyjobs/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Easyjobs
 * @subpackage Easyjobs/includes
 * @author     EasyJobs <support@easy.jobs>
 */
class Easyjobs {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Easyjobs_Loader    $loader    Maintains and registers all hooks for the plugin.
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
		if ( defined( 'EASYJOBS_VERSION' ) ) {
			$this->version = EASYJOBS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'easyjobs';

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
	 * - Easyjobs_Loader. Orchestrates the hooks of the plugin.
	 * - Easyjobs_i18n. Defines internationalization functionality.
	 * - Easyjobs_Admin. Defines all hooks for the admin area.
	 * - Easyjobs_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

	    /******** Global dependencies ***********/
		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once EASYJOBS_ROOT_DIR_PATH . 'includes/class-easyjobs-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once EASYJOBS_ROOT_DIR_PATH . 'includes/class-easyjobs-i18n.php';

        /**
         * Easyjobs global helper
         */
        require_once EASYJOBS_ROOT_DIR_PATH . 'includes/class-easyjobs-helper.php';
        /**
         * Easyjobs api helper
         * Interact with easyjobs app to get and post data
         */
        require_once EASYJOBS_ROOT_DIR_PATH . 'includes/class-easyjobs-api.php';

        /******** Admin dependencies ***********/

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once EASYJOBS_ADMIN_DIR_PATH . 'class-easyjobs-admin.php';
		require_once EASYJOBS_ADMIN_DIR_PATH . 'includes/class-easyjobs-db.php';
		require_once EASYJOBS_ADMIN_DIR_PATH . 'includes/class-easyjobs-settings.php';
		
        /**
         * This class handles all admin job functionality
         */
        require_once EASYJOBS_ADMIN_DIR_PATH . 'includes/class-easyjobs-admin-jobs.php';

        /**
         * This class handles all admin job pipeline functionality
         */
        require_once EASYJOBS_ADMIN_DIR_PATH . 'includes/class-easyjobs-admin-pipeline.php';

        /**
         * This class handles all admin job candidates functionality
         */
        require_once EASYJOBS_ADMIN_DIR_PATH . 'includes/class-easyjobs-admin-candidates.php';

        require_once EASYJOBS_ADMIN_DIR_PATH . 'includes/class-easyjobs-page-template.php';

        /**
         * This files handles all customizer functionality
         */
        require_once EASYJOBS_ADMIN_DIR_PATH . 'customizer/customizer.php';
        require_once EASYJOBS_ADMIN_DIR_PATH . 'customizer/defaults.php';
        
        /**
         * This file handles admin dashboard functionality
         */
        
        require_once EASYJOBS_ADMIN_DIR_PATH . 'includes/class-easyjobs-admin-dashboard.php';


        /******** Public dependencies ***********/
		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once EASYJOBS_PUBLIC_PATH . 'class-easyjobs-public.php';

        require_once EASYJOBS_PUBLIC_PATH . 'includes/class-easyjobs-shortcode.php';

		$this->loader = new Easyjobs_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Easyjobs_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Easyjobs_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Easyjobs_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action('admin_menu', $plugin_admin,'menu_page');
		// Settings
		EasyJobs_Settings::init();

		Easyjobs_Page_Template::get_instance();
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Easyjobs_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_assets' );
		$this->loader->add_action('init', $plugin_public, 'init');
		$this->loader->add_action( 'elementor/elements/categories_registered', $plugin_public, 'register_widget_categories');
		$this->loader->add_action( 'elementor/widgets/widgets_registered', $plugin_public, 'register_widget' );
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
	 * @return    Easyjobs_Loader    Orchestrates the hooks of the plugin.
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
