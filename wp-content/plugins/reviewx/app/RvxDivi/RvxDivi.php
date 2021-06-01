<?php

if ( ! function_exists( 'rvx_initialize_extension' ) ):
/**
 * Creates the extension's main class instance.
 *
 * @since 1.0.0
 */
function rvx_initialize_extension() {
	if( class_exists('WooCommerce') ) {
		require_once plugin_dir_path( __FILE__ ) . 'includes/RvxTabs.php';
		require_once plugin_dir_path( __FILE__ ) . 'includes/RvxReviews.php';	
	}	
}
add_action( 'divi_extensions_init', 'rvx_initialize_extension' );
endif;