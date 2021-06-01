<?php
namespace Templately;

class Helper {
    /**
     * Get installed WordPress Plugin List
     * @return void
     */
    public static function get_plugins(){
        if( ! function_exists( 'get_plugins' ) ) {
            require_once \ABSPATH . 'wp-admin/includes/plugin.php';
        }
        return \get_plugins();
    }
    /**
     * Get views for front-end display
     *
     * @param string $name  it will be file name only from the views folder.
     * @param mixed $data
     * @return void
     */
    public static function views( $name, $data = null ){
        $helper = self::class;
        $file = TEMPLATELY_PATH . $name . '.php';
        if( \is_readable( $file ) ) {
            include_once $file;
        }
    }
    /**
     * Send JSON Error
     *
     * @param mixed $data
     * @param int $status_code
     * @return void
     */
    public static function send_error( $data = null, $status_code = null  ) {
        \wp_send_json_error( $data, $status_code );
        \wp_die();
    }
    /**
     * Send JSON Success
     *
     * @param mixed $data
     * @param int $status_code
     * @return void
     */
    public static function send_success( $data = null, $status_code = null  ) {
        \wp_send_json_success( $data, $status_code );
        \wp_die();
    }
}