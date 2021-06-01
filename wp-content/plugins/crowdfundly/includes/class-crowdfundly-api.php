<?php


class Crowdfundly_Api
{
    /**
     * API token
     * @var string
     */
    private static $token;

    /**
     * Available get endpoints
     * for retriving data from crowdfundly app
     * @var array
     */
    public static $get_endpoints = array(
        'organization' => CROWDFUNDLY_APP_URL . '/api/v1/organizations',
        'campaign' => CROWDFUNDLY_APP_URL . '/api/v1/campaigns',
        'user' => CROWDFUNDLY_APP_URL . '/api/v1/user',
        'basic_info' => CROWDFUNDLY_APP_URL . '/api/v1/organization',
    );

    /**
     * Available post endpoints
     * @var array
     */
    public static $post_endpoints = array(
        'signup' => CROWDFUNDLY_APP_URL . '/api/v1/auth/register',
        'email_login' => CROWDFUNDLY_APP_URL . '/api/v1/auth/login',
        'authenticate' => CROWDFUNDLY_APP_URL . '/api/v1/wp/authenticate',
    );

    /**
     * Check if api key is valid
     * @param string $api_key
     * @return bool
     */
    public static function authenticate($api_key)
    {
		$result = [ 'status' => false ];
        if( empty( sanitize_text_field($api_key) ) ){
            return $result;
		}
		
        $response = self::remote_post(esc_url(self::$post_endpoints['authenticate']), [
            'token' => sanitize_text_field($api_key)
        ]);

        if( $response->status_code === 200 && $response->status === 'success' ) {
            $resp = (array) $response;
			$resp = array_merge( $resp, [ 'crowdfundly_option_api_key' => sanitize_text_field($api_key), 'email_login' => false ] );
			Crowdfundly_Settings::update($resp);
			
			$result['resp'] = $resp;
			$result['status'] = true;
			$result['status_code'] = esc_attr($response->status_code);
			$result['response_message'] = esc_html($response->response_message);

			return $result;
		}
		
		$result['status_code'] = esc_attr($response->status_code);
		$result['response_message'] = esc_html($response->response_message);
		return $result;
    }

    /**
     * Get data for specific endpoints
     *
     * @param         $type
     * @param array $params
     *
     * @param null $extraRoute
     * @param array $headers
     * @return mixed
     */
    public static function get($type, $params=[], $extraRoute = null, $headers = [])
    {
        if(empty($type)){
            return false;
        }
        if( !array_key_exists( $type, self::$get_endpoints ) ){
            return false;
        }

        $url = self::$get_endpoints[$type];

        if(empty($params)){
            if (! is_null($extraRoute) ) {
                $url = $url . '/' . $extraRoute;
            }
            return self::remote_get($url, '', ['timeout' => 10000], $headers);
        }

        $url = rtrim(self::$get_endpoints[$type],'/');

        if (! is_null($extraRoute) ) {
            $url .= '/' . $extraRoute;
        }

        $url = $url.'?';
        foreach ($params as $key=>$param){
            $url .= $key . '=' . $param . '&';
        }
        $url = rtrim($url,'&');

        return self::remote_get(esc_url($url), '', ['timeout' => 10000], $headers);
    }

    /**
     * Get data from api with id
     * @param string $type
     * @param int $id
     * @param string $suffix
     * @return bool|object
     */
    public static function get_by_id($type, $id, $suffix = '')
    {
        if(empty($type) || !array_key_exists( $type, self::$get_endpoints )){
            return false;
        }
        if(empty($id)){
            return false;
        }
        $url = self::$get_endpoints[$type] . $id;
        if(!empty($suffix)){
            $url .= '/' . $suffix;
        }
        return self::remote_get( esc_url($url) );
    }

    /**
     * @param $type
     * @id int
     * @param $data
     * @return array|bool|mixed|object|string
     */
    public static function post($type, $id, $data, $token = true)
    {
        if(empty($type)){
            return false;
        }
        if(!array_key_exists($type, self::$post_endpoints)){
            return 'Invalid request. No endpoints for ' . $type;
        }

        $url = self::$post_endpoints[$type]['url'];

        if($token){
            if(empty($id)){
                return 'Id not found';
            }
        }

        if(!empty($id)){
            $url .= $id;
        }

        if(!empty(self::$post_endpoints[$type]['part'])){
            $url .=  self::$post_endpoints[$type]['part'];
        }

        return self::remote_post(esc_url($url), $data, [], $token);
    }

    /**
     * Get search results based on job type
     * @param $type
     * @return mixed
     */
    public static function search($type, $keyord)
    {
        if(empty($type)){
            return false;
        }
        $url = self::$get_endpoints[$type] . '?search=' . urlencode($keyord);
        return self::remote_get( esc_url($url) );

    }

    /**
     * @param int $job_id
     * @param string $type
     * @param string $keyord
     * @return array|bool|mixed|object
     */
    public static function search_within_job($job_id, $type, $keywords)
    {
        if(empty($job_id) && empty($type) && empty($keyord))
            return false;
        $url = self::$get_endpoints[$type] . $job_id . '/' . str_replace('job_','', $type) . '?' . $keywords;
        return self::remote_get( esc_url($url) );

    }

    public function postWithBasicAuth($type, $data, $credentials)
    {
        $return_object = ['status' => 'error'];
        if(empty($type)){
            $return_object['message'] = 'Request endpoint type is not provided';
            return (object) $return_object;
        }
        if(!array_key_exists($type, self::$post_endpoints)){
            $return_object['message'] = 'Invalid request. No endpoints for ' . $type;
            return (object) $return_object;
        }
        if(empty($data)){
            $return_object['message'] = 'Invalid request. Data not provided';
            return (object) $return_object;
        }
        if(empty($credentials)){
            $return_object['message'] = 'Invalid request. Credentials not provided';
            return (object) $return_object;
        }
        $request = [
            'body'    => $data
        ];

        $request['headers']['Authorization']  = 'Basic ' . base64_encode($credentials['email'] . ':' . $credentials['password']);

        $response = wp_remote_post( esc_url(self::$post_endpoints[$type]['url']), $request);

        if ( is_wp_error( $response ) ) {
            $error_message = $response->get_error_message();
            return (object)[
                'status' => 'error',
                'message' => 'Something went wrong: ' . $error_message
            ];
        }
        return json_decode($response['body']);
    }

    /**
     * Get data from api
     * @param string $url
     * @param string $api_key
     * @param array $options
     * @param array $headers
     * @return object
     */
    private static function remote_get($url, $api_key='', $options = array(), $headers = array())
    {

        if(!empty($api_key)){
            $token = $api_key;
        }else{
            $token = self::getToken();
        }

        $response = false;

		if ( false === $response ) {
			$response = wp_remote_get( esc_url($url), 
				array_merge(
					array(
                        'headers' => array_merge( array( 'Authorization' => 'Bearer '. $token ), $headers ),
                        'timeout'     => 12,
                        'sslverify' => false
					), 
					$options
				)
			);
		}
		
		if ( is_wp_error( $response ) ) {
			$error_message = $response->get_error_message();
			return (object) array(
				'status' => 'error',
				'error_type' => 'fetch error',
				'message' => 'Something went wrong. Details: ' . $error_message
			);
		}
		if ( is_array( $response ) ) {
			return json_decode($response['body']);
		}

		return (object) array(
			'status' => 'error',
			'error_type' => 'fetch error',
			'message' => 'Something went wrong. Try again later'
		);
    }

    /**
     * Post data to api
     * @param string $url
     * @param array $data
     * @param array $options
     * @param bool $token
     * @return array|mixed|object
     */
    private static function remote_post($url, $data, $options= array(), $token= true)
    {
        $request = [
            'body'    => $data
        ];

        if($token){
            $request['headers']['Authorization']  = 'Bearer ' . self::getToken();
        }

		$response = wp_remote_post( esc_url($url), array_merge($request, $options));

		$status_code = wp_remote_retrieve_response_code( $response );
		$response_message = wp_remote_retrieve_response_message( $response );

        if ( $status_code != 200 ) {
            return array(
				'status' => 'error',
				'status_code' => $status_code,
				'error_message' => $response_message,
            );
        }
        $data = json_decode($response['body']);
		$data->status = 'success';
		$data->status_code = $status_code;
		$data->response_message = $response_message;
        return $data;
    }

    /**
     * Get token from database if not set
     * @return string
     */
    private static function getToken()
    {
        if(!empty(self::$token)){
            return self::$token;
        }
        if (Crowdfundly_Settings::hasToken()) {
            return self::$token = Crowdfundly_Settings::getToken();   
        }
	}

	/**
	 * Custom endpoint for logout.
	 */
	public static function crowdfundly_logout_route() {
		if ( Crowdfundly_Settings::hasToken() == false ) return;

		add_action( 'rest_api_init', function() {
			register_rest_route( 'crowdfundly/api', '/logout/', array(
				'methods' => 'POST',
				'callback' => [ __CLASS__, 'crowdfundly_logout_route_api' ],
				'permission_callback' => function() { return ''; }
			) );
		} );
  	}

	/**
	 * callback method for register_rest_route
	 *
	 * @param \WP_REST_Request $req
	 * @return string|false|\WP_Error
	 */
	public static function crowdfundly_logout_route_api(\WP_REST_Request $req) {
		$headers = $req->get_headers();
		$token = $headers['authorization'][0];
		$crowdfundly_user_token = 'Bearer ' . Crowdfundly_Settings::getToken();
		$clear_crowdfundly_data = false;
		$success_payload = [ "logout" => true ];

		if ( $crowdfundly_user_token != $token ) {
			return new WP_Error( '401', esc_html__( 'Not Authorized', 'crowdfundly' ), array( 'status' => 401 ) );
		}

		try {
			$clear_crowdfundly_data = Crowdfundly_Settings::clear_crowdfundly_data();
		} catch ( \Exception $e ) {
			$clear_crowdfundly_data = false;
		}

		if ( $clear_crowdfundly_data == false ) {
			return new WP_Error( '500', esc_html__( 'Internal Server Error', 'crowdfundly' ), array( 'status' => 500 ) );
		}

		return json_encode($success_payload);
	}

    /**
	 * Custom endpoint for changed Organization.
	 */
	public static function crowdfundly_track_changed_organization() {
		// if ( Crowdfundly_Settings::hasToken() == false ) return;

		add_action( 'rest_api_init', function() {
			register_rest_route( 'crowdfundly/api', '/changed-organization/', array(
				'methods' => 'POST',
				'callback' => [ __CLASS__, 'crowdfundly_track_changed_organization_api' ],
				'permission_callback' => function() { return ''; }
			) );
		} );
  	}

	/**
	 * callback method for register_rest_route
	 *
	 * @param \WP_REST_Request $req
	 * @return string|false|\WP_Error
	 */
	public static function crowdfundly_track_changed_organization_api(\WP_REST_Request $req) {
        $org_data = json_decode($req->get_body());
        return Crowdfundly_Settings::updateUser( $org_data->organization );
	}

}