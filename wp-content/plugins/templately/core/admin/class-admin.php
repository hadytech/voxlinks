<?php

namespace Templately\Admin;

use Templately\Base;
use Templately\Loader;
use Templately\Helper;
use Templately\Query;
use Templately\DB;

class Admin extends Base {
    public function __construct() {
        Loader::add_action( 'admin_init', $this, 'maybe_redirect_templately' );
        Loader::add_action( 'plugins_loaded', $this, 'load_plugin_textdomain' );
        Loader::add_action( 'admin_menu', Settings::class, 'init' );
        Loader::add_action( 'admin_footer', $this, 'footer' );
        // Loader::add_action('templately_admin_header', $this, 'header');
    }
    public function footer( $hook ){
        echo '<div id="templately-gutenberg"></div>';
    }
    /**
     * Load Text Domain
     */
    public function load_plugin_textdomain(){
        load_plugin_textdomain( 'templately', false, dirname( plugin_basename( TEMPLATELY_FILE ) ) . '/languages' ); 
    }
    /**
     * Redirect on Active
     */
    public function maybe_redirect_templately(){
        if ( ! get_transient( 'templately_activation_redirect' ) ) {
			return;
		}
		if ( wp_doing_ajax() ) {
			return;
		}

		delete_transient( 'templately_activation_redirect' );
		if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
			return;
        }
        // Safe Redirect to Templately Page
        wp_safe_redirect( admin_url( 'admin.php?page=templately' ) );
        exit;
    }

    /**
     * If Elementor doesn't exists.
     *
     * @return boolean
     */
    public static function has_no_elementor() {
        $plugin_url = \wp_nonce_url(\self_admin_url('update.php?action=install-plugin&amp;plugin=elementor'), 'install-plugin_elementor');
        $button_text = 'Install Elementor';
        if (isset(Helper::get_plugins()['elementor/elementor.php'])) {
            $plugin_url = \wp_nonce_url('plugins.php?action=activate&amp;plugin=elementor/elementor.php', 'activate-plugin_elementor/elementor.php');
            $button_text = 'Activate Elementor';
        }
        $output = '<div class="notice notice-error">';
        $output .= sprintf(
            "<p><strong>%s</strong> %s <strong>%s</strong> %s &nbsp;&nbsp;<a  class='button-primary' href='%s'>%s</a></p>",
            __('Templately', 'templately'),
            __('requires', 'templately'),
            __('Elementor', 'templately'),
            __('plugin to be installed and activated. Please install Elementor to continue.', 'templately'),
            esc_url( $plugin_url ),
            __($button_text, 'templately')
        );
        $output .= '</div>';
        echo $output;
    }

    public function header(){
        Helper::views('core/admin/views/header');
    }
    /**
     * Enqueue Admin Styles
     */
    // public function enqueue( $hook ){
        
    // }
}
