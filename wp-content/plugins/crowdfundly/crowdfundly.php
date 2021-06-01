<?php
/**
 * Plugin Name:       Crowdfundly
 * Plugin URI:        https://crowdfundly.io/
 * Description:       All-in-one digital crowdfunding solution. Build your own crowdfunding platform to raise money for any purpose.
 * Version:           1.1.4
 * Author:            Crowdfundly 
 * Author URI:        https://crowdfundly.io/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt 
 * Text Domain:       crowdfundly
 * Domain Path:       /languages
 */

// If this file is called directly, abort. 
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'CROWDFUNDLY_VERSION', '1.1.4' );
define( 'CROWDFUNDLY_PLUGIN_URL', 'https://crowdfundly.io' );
define( 'CROWDFUNDLY_URL', plugins_url( '/', __FILE__ ) );
define( 'CROWDFUNDLY_ADMIN_URL', CROWDFUNDLY_URL . 'admin/' ); 
define( 'CROWDFUNDLY_PUBLIC_URL', CROWDFUNDLY_URL . 'public/' );
define( 'CROWDFUNDLY_FILE', __FILE__ );
define( 'CROWDFUNDLY_BASENAME', plugin_basename( __FILE__ ) );
define( 'CROWDFUNDLY_ROOT_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'CROWDFUNDLY_ADMIN_DIR_PATH', CROWDFUNDLY_ROOT_DIR_PATH . 'admin/' );
define( 'CROWDFUNDLY_CUSTOMIZER_DIR_PATH', CROWDFUNDLY_ADMIN_DIR_PATH . 'customizer/' );
define( 'CROWDFUNDLY_PUBLIC_PATH', CROWDFUNDLY_ROOT_DIR_PATH . 'public/' );
define( 'CROWDFUNDLY_APP_URL', 'https://api.crowdfundly.io');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-crowdfundly-activator.php
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-crowdfundly-activator.php';
function activate_crowdfundly() {
	Crowdfundly_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-crowdfundly-deactivator.php
 */
function deactivate_crowdfundly() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-crowdfundly-deactivator.php';
	Crowdfundly_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_crowdfundly' );
Crowdfundly_Activator::redirect();
register_deactivation_hook( __FILE__, 'deactivate_crowdfundly' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-crowdfundly.php';

/**
 * Begins execution of the plugin. 
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle. 
 *
 * @since    1.0.0
 */
// require CROWDFUNDLY_CUSTOMIZER_DIR_PATH . 'customizer.php';
function run_crowdfundly() {

	$plugin = new Crowdfundly();
	$plugin->run();
}
run_crowdfundly();
