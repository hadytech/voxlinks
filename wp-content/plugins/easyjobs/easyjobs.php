<?php

/**
 *
 * @link              https://easy.jobs
 * @since             1.0.0
 * @package           Easyjobs
 *
 * @wordpress-plugin
 * Plugin Name:       EasyJobs
 * Plugin URI:        https://easy.jobs
 * Description:       Easy solution for the job recruitment to attract, manage & hire right talent faster.
 * Version:           1.3.6
 * Author:            EasyJobs
 * Author URI:        https://easy.jobs
 * License:           GPL-3.0+
 * License URI:       https://opensource.org/licenses/GPL-3.0
 * Text Domain:       easyjobs
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Defines CONSTANTS for Whole plugins.
 */
define( 'EASYJOBS_VERSION', '1.3.6' );
define( 'EASYJOBS_PLUGIN_URL', 'https://easy.jobs' );
define( 'EASYJOBS_URL', plugins_url( '/', __FILE__ ) );
define( 'EASYJOBS_ADMIN_URL', EASYJOBS_URL . 'admin/' );
define( 'EASYJOBS_PUBLIC_URL', EASYJOBS_URL . 'public/' );
define( 'EASYJOBS_FILE', __FILE__ );
define( 'EASYJOBS_BASENAME', plugin_basename( __FILE__ ) );
define( 'EASYJOBS_ROOT_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'EASYJOBS_ADMIN_DIR_PATH', EASYJOBS_ROOT_DIR_PATH . 'admin/' );
define( 'EASYJOBS_PUBLIC_PATH', EASYJOBS_ROOT_DIR_PATH . 'public/' );
define( 'EASYJOBS_TEXTDOMAIN', 'easyjobs' );
define( 'EASYJOBS_APPLY_URL', esc_url('https://app.easy.jobs/job/a/') );

if(defined('EASYJOBS_DEV') && (EASYJOBS_DEV== true)){
    define( 'EASYJOBS_APP_URL', esc_url('https://app.easyjobs.dev'));
}else{
    define( 'EASYJOBS_APP_URL', esc_url('https://app.easy.jobs'));
}
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-easyjobs-activator.php
 */
function activate_easyjobs($network_wide) {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-easyjobs-activator.php';
	Easyjobs_Activator::activate($network_wide);
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-easyjobs-deactivator.php
 */
function deactivate_easyjobs() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-easyjobs-deactivator.php';
	Easyjobs_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_easyjobs' );
register_deactivation_hook( __FILE__, 'deactivate_easyjobs' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-easyjobs.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_easyjobs() {

	$plugin = new Easyjobs();
	$plugin->run();

}
run_easyjobs();

register_uninstall_hook(__FILE__,'easyjobs_uninstall');

function easyjobs_uninstall()
{
    delete_option('easyjobs_settings');
}
