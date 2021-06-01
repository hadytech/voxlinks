<?php

namespace Templately;

class Installer {
    // For activate the plugin
    public static function activate( $network_wide ) {
        flush_rewrite_rules();
        if ( is_multisite() && $network_wide ) {
			return;
        }
        set_transient( 'templately_activation_redirect', true, MINUTE_IN_SECONDS );
    }

    public static function deactivate() {
        // For deactivate the plugin
    }

	/**
	 * Init.
	 */
	public static function init() {
		register_activation_hook( TEMPLATELY_FILE, [ __CLASS__, 'activate' ] );
	}
}
