<?php
/**
 * Plugin Name:       ReviewX
 * Plugin URI:        https://reviewx.io/
 * Description:       Advanced Multi-criteria Rating & Reviews for WooCommerce. Turn your customer reviews into sales by collecting and leveraging reviews, ratings with multiple criteria.
 * Version:           1.3.2
 * Author:            WPDeveloper
 * Author URI:        https://wpdeveloper.net/
 * Text Domain:       reviewx
 * Domain Path:       /languages
 * @package     ReviewX
 * @author      WPDeveloper <support@wpdeveloper.net>
 * @copyright   Copyright (C) 2020 WPDeveloper & JoulesLabs. All rights reserved.
 * @license     GPLv3 or later
 * @since       1.0.0
 */

require __DIR__ . '/vendor/autoload.php';

use JoulesLabs\Warehouse\Foundation\Bootstrap;


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

define( 'PLUGIN_NAME', 'reviewx');
define( 'REVIEWX_VERSION', '1.3.2' );

define( 'REVIEWX_URL', plugins_url( '/', __FILE__ ) );
define( 'REVIEWX_ADMIN_URL', REVIEWX_URL . 'admin/' );
define( 'REVIEWX_PUBLIC_URL', REVIEWX_URL . 'public/' );
define( 'REVIEWX_FILE', __FILE__ );
define( 'REVIEWX_DIR', __DIR__ );
define( 'REVIEWX_BASENAME', plugin_basename( __FILE__ ) );
define( 'REVIEWX_ROOT_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'REVIEWX_ADMIN_DIR_PATH', REVIEWX_ROOT_DIR_PATH . 'admin/' );
define( 'REVIEWX_PUBLIC_PATH', REVIEWX_ROOT_DIR_PATH . 'public/' );
define( 'REVIEWX_PLUGIN_PATH', trailingslashit(plugin_dir_path(__FILE__)) );
define( 'REVIEWX_INCLUDE_PATH', REVIEWX_ROOT_DIR_PATH . 'includes/' );
define( 'REVIEWX_PARTIALS_PATH', REVIEWX_ROOT_DIR_PATH . 'partials/' );
define( 'REVIEWX_CUSTOMIZER_URL', REVIEWX_URL . 'app/Customizer/' );
define( 'REVIEWX_AUTOLOGIN_CODE_LENGTH', 32 );
define( 'REVIEWX_AUTOLOGIN_CODE_CHARACTERS', "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789" );
define( 'REVIEWX_AUTOLOGIN_VALUE_NAME', 'rx_autologin_code' );
define( 'REVIEWX_AUTOLOGIN_USER_META_KEY', 'rx_autologin_code' );
define( 'REVIEWX_AUTOLOGIN_STAGED_CODE_USER_META_KEY', 'rx_autologin_staged_code' );
define( 'REVIEWX_AUTOLOGIN_STAGED_CODE_NONCE_USER_META_KEY', 'rx_autologin_staged_code_nonce' );
define( 'REVIEWX_AUTOLOGIN_BIG_WEBSITE_THRESHOLD', 20 );

/**
 * rx-function.php require for load plugin internal function
 */
require_once ABSPATH . WPINC . "/class-phpass.php";
require_once ( REVIEWX_ROOT_DIR_PATH . 'includes/rx-functions.php' );

/**
 * The functions responsible for ReviewX customizer
 */
require_once REVIEWX_ROOT_DIR_PATH . 'app/Customizer/customizer.php';
require_once REVIEWX_ROOT_DIR_PATH . 'app/Customizer/defaults.php';

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require_once REVIEWX_ROOT_DIR_PATH . 'includes/class-rx.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
if (! function_exists('run_reviewx')) {
    function run_reviewx() {
        $plugin = new ReviewX();
        $plugin->run();
    }
}
run_reviewx();

if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

Bootstrap::run(__FILE__);

add_action('plugins_loaded', function () {
    \ReviewX\Elementor\Classes\Starter::instance();
});
