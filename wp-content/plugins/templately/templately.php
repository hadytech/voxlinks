<?php
/**
 * Plugin Name: Templately
 * Description: The Best Templates Cloud for Elementor & Gutenberg. Get access to stunning templates, WorkSpace, Cloud Library & many more.
 * Plugin URI: https://templately.com
 * Author: Templately
 * Version: 1.2.3
 * Author URI: https://templately.com/
 * Text Domain: templately
 * Domain Path: /languages
 */

define('TEMPLATELY_FILE', __FILE__);
define('TEMPLATELY_VERSION', '1.2.3');
define('TEMPLATELY_PATH', plugin_dir_path(TEMPLATELY_FILE));
define('TEMPLATELY_URL', plugin_dir_url(TEMPLATELY_FILE));
define('TEMPLATELY_ASSETS', TEMPLATELY_URL . 'assets/');

/**
 * Initiate Autoloader for Class Load
 */
if (!class_exists('Templately\Autoloader')) {
    require TEMPLATELY_PATH . 'core/autoloader.php';
    Templately\Autoloader::init();
}
/**
 * Templately Class will be instantiated by function.
 * @return Templately\Plugin
 */
function templately(){
    if ( class_exists('Templately\Plugin') ) {
        return Templately\Plugin::get_instance();
    }
}
templately();