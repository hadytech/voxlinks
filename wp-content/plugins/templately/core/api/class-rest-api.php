<?php
namespace Templately;

class REST {
	/**
	 * Instance of REST
	 * @var REST
	 */
    protected static $_instance = null;
	/**
	 * Get the instance of REST
	 * @return REST
     */
	public static function get_instance() {
		if ( static::$_instance === null ) {
			static::$_instance = new static;
		}

		return static::$_instance;
    }
    /**
     * Contains WP_User
     *
     * @var WP_User
     */
    protected $current_user;
    /**
     * Initially Invoked
     */
    public function __construct(){
        \add_action( 'rest_api_init', [ $this, 'register_routes' ] );
    }
    /**
     * Permission check for each route
     *
     * @return boolean
     */
    public function check_permission() {
        $api_key = DB::get_user_specific_login_meta( '_templately_api_key' );
        if( ! empty( $api_key ) && \user_can($this->current_user, 'edit_posts') ) {
            return true;
        }
        return false;
    }
    /**
     * Register Rest Api Init
     *
     * @param WP_REST_Server $wp_rest_server
     * @return void
     */
    public function register_routes( $wp_rest_server ){
        /**
         * Get the current user
         * @var WP_User
         */
        $this->current_user = \wp_get_current_user();
        /**
         * Register Routes
         */
        register_rest_route( 'templately/v1', '/clouds', [
            'methods'  => \WP_REST_Server::READABLE,
            'callback' => [ $this, 'download' ],
            'permission_callback' => [ $this, 'check_permission' ],
            'args' => [
                'id' => [
                    'required' => true,
                    'validate_callback' => function( $id ) { return is_numeric( $id ); }
                ]
            ]
        ]);
    }

    public function error( $type = '' ) {
        switch( $type ) {
            case 'api':
                return $this->formattedError( 'api_error', __( 'Unathorized Access: You have to logged in first.', 'templately' ), 401 );
                break;
            default:
                return $this->formattedError( 'response_error', __( '400 Bad Request.', 'templately' ), 400 );
        }
    }

    public function download( $request ){
        if( $request->has_param('id') ) {
            $id = $request->get_param('id');
            $api_key = DB::get_user_specific_login_meta( '_templately_api_key' );
            if( empty( $api_key ) ) {
                return $this->error('api');
            }
            $response = Query::get(
                Query::prepare(
                    'mutation { downloadMyCloudItem( api_key: "%s", id: %d ){ file, status, message, file_name, file_type } }',
                    $api_key, +$id
                ),
                [
                    'is_rest' => true,
                    'only_data' => true,
                    'query' => 'downloadMyCloudItem'
                ]
            );

            if( isset( $response['file_name'] ) ) {
                require_once ABSPATH . '/wp-admin/includes/file.php';
                $upload_dir = wp_upload_dir();
                $file_name = 'templately-tmp.json';
                $templately_temp_file = $upload_dir['basedir'] . DIRECTORY_SEPARATOR . $file_name;
                if ( \file_exists( $templately_temp_file ) ) {
                    unlink( $templately_temp_file );
                }
                $templately_temp_file_url = $upload_dir['baseurl'] . DIRECTORY_SEPARATOR . $file_name;
                $handle = fopen( $templately_temp_file, 'x+' );
                fwrite( $handle, $response['file'] );
                fclose( $handle );
                $response['fileURL'] = $templately_temp_file_url;
            }
            return $response;
        }
        return $this->error();
    }

    private function formattedError( $code, $message, $http_code, $args = [] ){
        return new \WP_Error( "templately_$code", $message, [ 'status' => $http_code ] );
    }
}