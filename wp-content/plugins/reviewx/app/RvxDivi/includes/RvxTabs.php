<?php

class RVX_WooCommerceTabsClass extends DiviExtension {

	/**
	 * The gettext domain for the extension's translations.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $gettext_domain = 'rvx-tabs';

	/**
	 * The extension's WP Plugin name.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $name = 'rvx-tabs';

	/**
	 * The extension's version
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $version = '1.0.0';

	/**
	 * LWP_DiviBreadcrumbs constructor.
	 *
	 * @param string $name
	 * @param array  $args
	 */
	public function __construct( $name = 'rvx-tabs', $args = array() ) {
		$this->plugin_dir     = plugin_dir_path( __FILE__ );
		$this->plugin_dir_url = plugin_dir_url( $this->plugin_dir );	
		
		$this->_initialize();

		parent::__construct( $name, $args );
	}

	protected function _initialize() {
		add_action( 'wp_enqueue_scripts', array( $this, 'wp_hook_enqueue_scripts' ) );
	}
	public function wp_hook_enqueue_scripts() {
		$this->_enqueue_bundles();
	}

	protected function _enqueue_bundles() {
		// Frontend Bundle.
		// wp_enqueue_script( "rvx-frontend-bundle", plugins_url( '/', __FILE__ )."../scripts/frontend-bundle.min.js", array(), true, true );
		// wp_enqueue_script( "rvx-builder-bundle", plugins_url( '/', __FILE__ )."../scripts/builder-bundle.min.js", array(), true, true );
	}	
}

new RVX_WooCommerceTabsClass;