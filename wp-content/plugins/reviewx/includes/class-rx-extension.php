<?php
/**
 * Register all extensions for the plugin.
 * 
 * @link       https://wpdeveloper.net
 * @since      1.0.0
 * 
 * @package    ReviewX
 * @subpackage ReviewX/extensions
 * @author     WPDeveloper <support@wpdeveloper.net>
 */
class ReviewX_Extension {
    /**
     * ReviewX_Extension or null
     * @var ReviewX_Extension
     */
    protected static $_instance = null;
    /**
     * Settings options for all reviewx we saw
     * @var array
     */
    protected static $settings;
    /**
     * Limit of the store
     * for storing reviewx in options table.
     * @var array ( multi dimensional, has key for every types of reviewx );
     */
    protected $cache_limit;
    /**
     * Prefix
     *
     * @var string
     */
    protected $prefix = 'rx_';
    /**
     * All Active Reviewx Items
     *
     * @var array
     */
    public static $active_items = [];
    public static $enabled_types = [];

    public static $powered_by = null;

    protected $limiter;

    protected $template_name;
    
    /**
     * Default data
     * @var array
     */
    public $defaults = array();
    /**
     * Get instance of ReviewX_Extension
     * @return ReviewX_Extension
     */
    public static function get_instance(){
        $class = get_called_class();
        if( ! isset( self::$_instance[ $class ] ) || self::$_instance[ $class ] === null ) {
            self::$_instance[ $class ] = new $class;
        }
        return self::$_instance[ $class ];
    }
    /**
     * Constructor of extension for ready the settings and cache limit.
     */
    public function __construct( $template = '' ){

        self::$settings      = ReviewX_DB::get_settings();

        if( ! empty( self::$settings ) && isset( self::$settings['cache_limit'] ) ) {
            $this->cache_limit = intval( self::$settings['cache_limit'] );
        }

        if( ! empty( self::$settings ) && isset( self::$settings['disable_powered_by'] ) ) {
            self::$powered_by = intval( self::$settings['disable_powered_by'] );
        }

        $this->template_name = $template;
    }
    /**
     * To check plugins installed or not
     * @param string $plugin_file
     * @return boolean
     * @since 1.2.4
     */
    public function plugins( $plugin_file = '' ) {
        if( empty( $plugin_file ) ) {
            return false;
        }
        if( ! function_exists( 'get_plugins' ) ) {
            require ABSPATH . 'wp-admin/includes/plugin.php';
        }
        $plugins = get_plugins();
        if( isset( $plugins[ $plugin_file ] ) ) {
            return true;
        }
        return false;
    }

    public function template_name( $data ){
        if( $this->template_name ) {
            $data[] = $this->template_name;
        }

        return $data;
    }
    /**
     * this function is responsible for check a type of reviewx is created or not
     *
     * @param string $type
     * @return boolean
     */
    public static function is_created( $type = '' ){
        if( empty( $type ) ) {
            return false;
        }

        if( empty( self::$active_items ) ) {
            self::$active_items = ReviewX_Admin::get_active_items();
        }

        if( ! empty( self::$active_items ) ) {
            return in_array( $type, array_keys( self::$active_items ) );
        } else {
            return false;
        }
    }

    public static function is_enabled( $type = '' ){
        if( empty( $type ) ) {
            return false;
        }

        if( $type == 'press_bar' ) {
            return true;
        }

        $types = array();

        self::$enabled_types = ReviewX_Admin::$enabled_types;

        if( ! empty( self::$enabled_types ) ) {
            foreach( $types as $type ) {
                if( in_array( $type, array_keys( self::$enabled_types ) ) ) {
                    return true;
                }
            }
        } else {
            return false;
        }
    }
    /**
     * This method is responsible for get all 
     * the reviewx we have stored
     *
     * @param string $type
     * @return array - Multidimensional, has a key for every type of reviewx with all data stored.
     */
    public function get_notifications( $type = '' ){
        $reviewxs = ReviewX_DB::get_reviewxs();
        if( empty( $type ) || empty( $reviewxs ) || ! isset( $reviewxs[ $type ] ) ) {
            return [];
        }
        return $reviewxs[ $type ];
    }
    /**
     * This method is responsible for save the data
     *
     * @param string $type - notification type
     * @param array $data - notification data to save.
     * @return boolean
     */
    protected function save( $type = '', $data = [], $key = '' ){
        if( empty( $type ) ) {
            return;
        }
        $reviewxs = ReviewX_DB::get_reviewxs();

        if( ! empty( $reviewxs[ $type ] ) ) {
            $input = $reviewxs[ $type ];
        } else {
            $input = array();
        }

        $this->limiter->setValues( $input );
        $this->limiter->append( $data, $key );
        $reviewxs[ $type ] = $this->limiter->values();
        // hook anythings on save
        do_action( 'rx_before_data_save', $type, $data, $key );
        return ReviewX_DB::update_notifications( $reviewxs );
    }

    protected function update_notifications( $type = '', $values = array() ){
        $reviewxs = ReviewX_DB::get_notifications();
        $this->limiter->setValues( $values );
        
        $reviewxs[ $type ] = $this->limiter->values();
        return ReviewX_DB::update_notifications( $reviewxs );
    }

    public static function remote_get( $url, $args = array() ){
        $defaults = array(
            'timeout'     => 20,
            'redirection' => 5,
            'httpversion' => '1.1',
            'user-agent'  => 'ReviewX/'. REVIEWX_VERSION .'; ' . home_url(),
            'body'        => null,
            'sslverify'   => false,
            'stream'      => false,
            'filename'    => null
        );
        $args = wp_parse_args( $args, $defaults );
        $request = wp_remote_get( $url, $args );

        if( is_wp_error( $request ) ) {
            return false;
        }
        $response = json_decode( $request['body'] );
        if( isset( $response->status ) && $response->status == 'fail' ) {
            return false;
        }
        return $response;
    }

    /**
     * This function will convert all the data key into double curly braces format
     * {{key}} = $value
     *
     * @param boolean $data
     * @return void
     */
    public static function newData( $data = array() ) {
        if( empty( $data ) ) return;
        $new_data = array();
        foreach( $data as $key => $single_data ) {
            if( $key == 'link' || $key == 'post_link' ) continue;
            if( $key == 'timestamp' ) {
                $new_data[ '{{time}}' ] = ReviewX_Helper::get_timeago_html( $single_data );
                continue;
            }
            $new_data[ '{{'. $key .'}}' ] = $single_data;
        }
        return $new_data;
    }

    public function trimed( &$value ) {
        if( ! is_array( $value ) ) {
            $value = trim( $value );
        } else {
            $value = $value;
        }
    }

    public static function notEmpty( $key, $data ){
        if( isset( $data[ $key ] ) ) {
            if( ! empty( $data[ $key ] ) ) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * For checking type
     *
     * @param [type] $post_id
     * @return boolean
     * 
     * @since 1.1.3
     */
    public function check_type( $post_id ){
        $settings = ReviewX_MetaBox::get_option_settings( $post_id );
        if( $this->type !== ReviewX_Helper::get_type( $settings ) ) {
            return false;
        }
        return true;
    }

}