<?php
if ( ! defined( 'ABSPATH' ) ) exit;


use Elementor\Elements_Manager;
use Elementor\Plugin;

final class CrowdFundly_Elementor {

	private static $_instance = null;

	const MINIMUM_ELEMENTOR_VERSION = '3.0.0';

	/**
	 * Instance
	 * Ensures only one instance of the class is loaded or can be loaded.
	 * 
	 * @static
	 *
	 * @return CrowdFundly_Elementor An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __construct() {
		add_action( 'plugins_loaded', [ $this, 'on_plugins_loaded' ] );
	}

	/**
	 * On Plugins Loaded
	 *
	 * Checks if Elementor has loaded, and performs some compatibility checks.
	 */
	public function on_plugins_loaded() {
		if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
			return;
		}
		if ( $this->is_compatible() ) {
			add_action( 'elementor/init', [ $this, 'init' ] );
			add_action( 'elementor/preview/enqueue_styles', [ $this, 'frontend_assets' ] );
			add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'crowdfundly_editor_styles' ] );
		} else return;
	}

	/**
	 * Compatibility Checks
	 * 
	 * @return bool
	 */
	public function is_compatible() {
		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return false;
		}

		return true;
	}

	/**
	 * Initialize Elementor hooks
	 */
	public function init() {
		// Add Plugin actions
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'add_widgets' ] );
		add_action( 'elementor/elements/categories_registered', [ $this, 'add_category' ] );
	}

	public function crowdfundly_editor_styles() {
		wp_enqueue_style( 
			'crowdfundly-editor-css', 
			CROWDFUNDLY_URL . 'pagebuilders/elementor/assets/icons/style.css',
			array(), CROWDFUNDLY_VERSION, 'all' 
		);
	}

	/**
	 * Assets for Elementor
	 */
	public function frontend_assets() {
		wp_enqueue_style( 
			'crowdfundly-slick', 
			CROWDFUNDLY_URL . 'assets/slick-dist/slick/slick.css',
			array(), CROWDFUNDLY_VERSION, 'all' 
		);

		wp_enqueue_style(
			'crowdfundly-slick-theme', 
			CROWDFUNDLY_URL . 'assets/slick-dist/slick/slick-theme.css',
			array(), CROWDFUNDLY_VERSION, 'all' 
		);

		wp_enqueue_script( 
			'crowdfundly-slickjs', 
			CROWDFUNDLY_URL . 'assets/slick-dist/slick/slick.min.js',
			array( 'jquery' ), CROWDFUNDLY_VERSION, true
		);

		wp_enqueue_script(
			'crowdfundly-elementor-main-js', 
			CROWDFUNDLY_URL . 'pagebuilders/elementor/assets/main.js', 
			array( 'jquery' ), CROWDFUNDLY_VERSION, 'all' 
		);
	}

	public function add_category( Elements_Manager $elements_manager ) {
		$elements_manager->add_category(
			'crowdfundly_elementor_category',
			array(
				'title' => __( 'Crowdfundly', 'crowdfundly' ),
				'icon' => '',
			)
		);
	}

	public function add_widgets() {
		require_once( __DIR__ . '/widgets/organization-widget.php' );
		require_once( __DIR__ . '/widgets/all-campaign-widget.php' );
		require_once( __DIR__ . '/widgets/single-campaign-widget.php' );

		// Register widgets
		Plugin::instance()->widgets_manager->register_widget_type( new \Crowdfundly_Organization_Widget() );
		Plugin::instance()->widgets_manager->register_widget_type( new \Crowdfundly_All_Campaign_Widget() );
		Plugin::instance()->widgets_manager->register_widget_type( new \Crowdfundly_Single_Campaign_Widget() );
	}

	/**
	 * Admin notice for Elementor minimum version requirement.
	 */
	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'crowdfundly' ),
			'<strong>' . esc_html__( 'Crowdfundly', 'crowdfundly' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'crowdfundly' ) . '</strong>',
			 self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

}
