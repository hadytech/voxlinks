<?php
/**
 * Templately plugin.
 *
 * The main plugin handler class is responsible for initializing Templately. The
 * class registers and all the components required to run the plugin.
 *
 * @package Templately
 */

namespace Templately;

defined('ABSPATH') or exit;

use Templately\Admin\Admin;

final class Plugin {
    /**
     * Plugin Version
     * @var string
     */
    protected static $version;
    /**
     * Plugin Name
     * @var string
     */
    protected static $plugin_name;
    /**
     * Plugin Instance
     * @var \Templately\Plugin
     */
    private static $_instance = null;
    /**
     * Elementor Instance
     *
     * @var \Templately\Elementor
     */
    public $elementor = null;
    /**
     * Admin Instance
     *
     * @var \Templately\Admin\Admin
     */
    public $admin = null;

    /**
     * Get a single instance of Plugin
     * @return Plugin
     */
    public static function get_instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Plugin constructor.
     * Initializing Templately plugin.
     *
     * @access private
     */
    private function __construct() {
        if (defined('TEMPLATELY_VERSION')) {
            self::$version = TEMPLATELY_VERSION;
        } else {
            self::$version = '0.0.1';
        }
        Installer::init();
        self::$plugin_name = 'templately';
        $this->admin = Admin::get_instance();
        REST::get_instance();
        $this->elementor = Elementor::get_instance();
        Loader::add_action('admin_init', $this, 'migrate');
        self::run();
        do_action('templately_init');
    }

    /**
     * Run all actions and hooks
     *
     * @return void
     */
    public static function run() {
        /**
         * Loader will run actions and filters function for the plugin.
         */
        Loader::run();
    }
    /**
     * Migrate Users to Global Signed In if they are already logged in.
     * @since 1.1.5
     * @return void
     */
    public static function migrate(){
        $templately_old_version = \get_option('_templately_migrate' );
        if( \version_compare(TEMPLATELY_VERSION, $templately_old_version, '>') && \version_compare($templately_old_version, '1.1.4', '=') ) {
            if( \get_option( '_templately_connected', false ) ) {
                if( \current_user_can('manage_options') ) {
                    \update_option( '_templately_user_login_choice', ['choice' => true, 'id' => \get_current_user_id() ] );
                }
            }
        }
        if( \version_compare(TEMPLATELY_VERSION, '1.2.0', '=') && ! \get_option('_templately_verification_migrate', false ) ) {
            if( DB::get_user_specific_login_meta( '_templately_connected', false ) ) {
                \update_option( '_templately_verification_migrate', true );
                $user_data = DB::get_user_specific_login_meta('_templately_connect_data');
                $user_data['is_verified'] = true;
                DB::update_user_specific_login_meta( '_templately_connect_data', $user_data );
            }
        }

        if( \version_compare(TEMPLATELY_VERSION, '1.2.2', '=') && \version_compare($templately_old_version, '1.2.2', '<') ) {
            DB::delete_option('_templately_dependencies');
            DB::delete_option('_templately_tags');
            DB::delete_option('_templately_categories');
        }

        // SET VERSION
        \update_option( '_templately_migrate', TEMPLATELY_VERSION );
    }
    /**
     * Get Plugin Name or You can say Text Domain
     * @return string
     */
    public static function get_name() {
        return self::$plugin_name;
    }

    /**
     * Get Plugin Version
     * @return String
     */
    public static function get_version() {
        return self::$version;
    }
}
