<?php


class Easyjobs_Api
{
    /**
     * Api token
     * @var string
     */
    private static $token;
    
    

    /**
     * Available get endpoints
     * for retriving data from easyjobs app
     * @var array
     */
    private static $get_endpoints = array(
        'company' => EASYJOBS_APP_URL . '/api/v1/company/details',
        'published_jobs' => EASYJOBS_APP_URL . '/api/v1/job/published',
        'draft_jobs' => EASYJOBS_APP_URL . '/api/v1/job/draft',
        'archived_jobs' => EASYJOBS_APP_URL . '/api/v1/job/archive',
        'job_pipeline' => EASYJOBS_APP_URL . '/api/v1/job/',
        'job_candidates' => EASYJOBS_APP_URL . '/api/v1/job/',
        'job_details' => EASYJOBS_APP_URL . '/api/v1/job/',
        'job' => EASYJOBS_APP_URL . '/api/v1/job/',
        'candidate' => EASYJOBS_APP_URL . '/api/v1/job/applicants/',
        'packages' => EASYJOBS_APP_URL . '/api/v1/subscription/packages/',
        'company_stats' => EASYJOBS_APP_URL . '/api/v1/company/stats/',
        'company_recent_applicants' => EASYJOBS_APP_URL . '/api/v1/company/recent-applicants/',
        'company_recent_jobs' => EASYJOBS_APP_URL . '/api/v1/company/recent-jobs/',
        'company_jobs' => EASYJOBS_APP_URL . '/api/v1/company/jobs',
        'company_candidates' => EASYJOBS_APP_URL . '/api/v1/company/candidates/',
        'company_metadata' => EASYJOBS_APP_URL . '/api/v1/company-meta-data/',
        'categories' => EASYJOBS_APP_URL . '/api/v1/category/',
        'job_metas' => EASYJOBS_APP_URL . '/api/v1/job/meta/',
        'skills' => EASYJOBS_APP_URL . '/api/v1/skill/',
        'country' => EASYJOBS_APP_URL . '/api/v1/country/',
        'states' => EASYJOBS_APP_URL . '/api/v1/state/',
        'screening_question_meta' => EASYJOBS_APP_URL . '/api/v1/job/screening-meta-data',
        'quiz_meta' => EASYJOBS_APP_URL . '/api/v1/job/quiz-meta-data',
        'settings_basic_info' => EASYJOBS_APP_URL . '/api/v1/company/setting/basic-info',
        'settings_metadata' => EASYJOBS_APP_URL . '/api/v1/company-meta-data',
        'verification_code' => EASYJOBS_APP_URL . '/api/v1/company/setting/verification-code',
        'photos_and_colors' => EASYJOBS_APP_URL . '/api/v1/company/setting/company-photo',
        'ai_setup' => EASYJOBS_APP_URL . '/api/v1/company/setting/ai-setup',
        'settings_pipeline' => EASYJOBS_APP_URL . '/api/v1/company/setting/pipeline',
        'settings_categories' => EASYJOBS_APP_URL . '/api/v1/company/setting/category',
        'settings_skills' => EASYJOBS_APP_URL . '/api/v1/company/setting/skill',
        'apply_settings' => EASYJOBS_APP_URL . '/api/v1/company/setting/apply-setting',
    );

    /**
     * Available post endpoints
     * @var array
     */
    private static $post_endpoints = array(
        'change_pipeline' => array(
            'url' => EASYJOBS_APP_URL . '/api/v1/job/',
            'part' => '/candidate/pipeline'
        ),
        'save_pipeline' => array(
            'url' => EASYJOBS_APP_URL . '/api/v1/job/',
            'part' => '/pipeline/update'
        ),
        'sign_in' => array(
            'url' => EASYJOBS_APP_URL . '/api/v1/sign-in/'
        ),
        'sign_up' => array(
            'url' => EASYJOBS_APP_URL . '/api/v1/sign-up/'
        ),
        'create_company' => array(
            'url' => EASYJOBS_APP_URL . '/api/v1/create-company/'
        ),
        'save_job_info' => array(
            'url' => EASYJOBS_APP_URL . '/api/v1/job/create/'
        ),
        'save_questions' => array(
            'url' => EASYJOBS_APP_URL . '/api/v1/job/',
            'part' => '/screening',
        ),
        'save_quiz' => array(
            'url' => EASYJOBS_APP_URL . '/api/v1/job/',
            'part' => '/quiz',
        ),
        'change_status' => array(
            'url' => EASYJOBS_APP_URL . '/api/v1/job/',
            'part' => '/change-status',
        ),
        'update_job_info' => array(
            'url' => EASYJOBS_APP_URL . '/api/v1/job/',
            'part' => '/update'
        ),
        'required_fields' => array(
            'url' => EASYJOBS_APP_URL . '/api/v1/job/',
            'part' => '/required-fields'
        ),
        'delete_job' => array(
            'url' => EASYJOBS_APP_URL . '/api/v1/job/',
            'part' => '/delete'
        ),
        'settings_basic_info' => [
            'url' => EASYJOBS_APP_URL . '/api/v1/company/setting/basic-info'
        ],
        'settings_verify' => [
            'url' => EASYJOBS_APP_URL . '/api/v1/company/setting/verify'
        ],
        'company_photo' => [
            'url' => EASYJOBS_APP_URL . '/api/v1/company/setting/company-photo'
        ],
        'brand_color' => [
            'url' => EASYJOBS_APP_URL . '/api/v1/company/setting/brand-color'
        ],
        'show_life' => [
            'url' => EASYJOBS_APP_URL . '/api/v1/company/setting/show-life'
        ],
        'ai_setup' => [
            'url' => EASYJOBS_APP_URL . '/api/v1/company/setting/ai-setup'
        ],
        'create_pipeline' => [
            'url' => EASYJOBS_APP_URL . '/api/v1/company/setting/pipeline'
        ],
        'update_pipeline' => [
            'url' => EASYJOBS_APP_URL . '/api/v1/company/setting/pipeline/',
            'part' => '/update'
        ],
        'delete_pipeline' => [
            'url' => EASYJOBS_APP_URL . '/api/v1/company/setting/pipeline/',
            'part' => '/delete'
        ],
        'save_category' => [
            'url' => EASYJOBS_APP_URL . '/api/v1/company/setting/category/save',
        ],
        'save_skill' => [
            'url' => EASYJOBS_APP_URL . '/api/v1/company/setting/skill/save',
        ],
        'delete_category' => [
            'url' => EASYJOBS_APP_URL . '/api/v1/company/setting/category/',
            'part' => '/delete'
        ],
        'delete_skill' => [
            'url' => EASYJOBS_APP_URL . '/api/v1/company/setting/skill/',
            'part' => '/delete'
        ],
        'delete_custom_field' => [
            'url' => EASYJOBS_APP_URL . '/api/v1/company/setting/apply-setting/',
            'part' => '/delete'
        ],
        'save_apply_settings' => [
            'url' => EASYJOBS_APP_URL . '/api/v1/company/setting/apply-setting/'
        ],
        'invite_candidate' => [
            'url' => EASYJOBS_APP_URL . '/api/v1/job/',
            'part' => '/candidate/add'
        ],
        'delete_invitation' => [
            'url' => EASYJOBS_APP_URL . '/api/v1/job/',
            'part' => '/invitations/delete'
        ],
        'rate_candidate' => [
            'url' => EASYJOBS_APP_URL . '/api/v1/job/applicants/',
            'part' => '/rating'
        ]
    );

    /**
     * Check if api key is valid
     * @param string $api_key
     * @return bool
     */
    public static function authenticate($api_key)
    {
        if(empty($api_key)){
            return false;
        }
        $response = self::remote_get(self::$get_endpoints['company'], $api_key);
        
        if($response->status === 'success'){
            return true;
        }
        return false;
    }

	/**
	 * Get data for specific endpoints
	 *
	 * @param         $type
	 * @param  array  $params
	 *
	 * @return mixed
	 */
    public static function get($type, $params=[])
    {
        if(empty($type)){
            return false;
        }
        if( !array_key_exists( $type, self::$get_endpoints ) ){
            return false;
        }
        if(empty($params)){
            return self::remote_get(self::$get_endpoints[$type]);
        }
        
        $url = rtrim(self::$get_endpoints[$type],'/');

        $url = $url.'?';
        foreach ($params as $key=>$param){
            $url .= $key . '=' . $param . '&';
        }
        $url = rtrim($url,'&');
        return self::remote_get($url);
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
        return self::remote_get($url);
    }

    /**
     * Get data from api with id
     * @param string $url
     * @param array $params
     * @return bool|object
     * @since 1.1.3
     */
    public static function get_custom($url, $params=[])
    {
        if(empty($params)){
            return self::remote_get($url);
        }

        $url = rtrim($url,'/');

        $url = $url.'?';
        foreach ($params as $key=>$param){
            $url .= $key . '=' . $param . '&';
        }
        $url = rtrim($url,'&');

        return self::remote_get($url);
    }

    /**
     * @param $type
     * @id int
     * @param $data
     * @return array|bool|mixed|object|string
     */
    public static function post($type, $id, $data = [], $token = true, $headers=[])
    {
        if(empty($type)){
            return false;
        }
        if(!array_key_exists($type, self::$post_endpoints)){
            return 'Invalid request. No endpoints for ' . $type;
        }

        $url = self::$post_endpoints[$type]['url'];

        if(!empty($id) || (string) $id === '0'){
            $url .= $id;
        }

        if(!empty(self::$post_endpoints[$type]['part'])){
            $url .=  self::$post_endpoints[$type]['part'];
        }
        return self::remote_post($url, $data, $headers, $token);
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
        return self::remote_get( $url);

    }

    /**
     * @param int $job_id
     * @param string $type
     * @param $keywords
     * @param string $request_url @since 1.3.1
     * @return array|bool|mixed|object
     */
    public static function search_within_job($job_id, $type, $keywords, $request_url='')
    {
        if(empty($job_id) && empty($type) && empty($keyords))
            return false;
        if(!empty($request_url)){
           $url = $request_url . '?' . $keywords;
        }else{
            $url = self::$get_endpoints[$type] . $job_id . '/' . str_replace('job_','', $type) . '?' . $keywords;
        }

        return self::remote_get( $url);

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

        $response = wp_remote_post( self::$post_endpoints[$type]['url'], $request);

        if ( is_wp_error( $response ) ) {
            $error_message = $response->get_error_message();
            return (object)[
                'status' => 'error',
                'message' => 'Something went wrong: ' . $error_message
            ];
        }
        return json_decode($response['body']);
    }


    public static function postWithFile($type, $data, $file)
    {
        $boundary = wp_generate_password( 24 );
        $headers  = array(
            'content-type' => 'multipart/form-data; boundary=' . $boundary,
            'Authorization' => 'Bearer '. self::getToken()
        );
        $payload = '';
        foreach ( $data as $name => $value ) {
            $payload .= '--' . $boundary;
            $payload .= "\r\n";
            $payload .= 'Content-Disposition: form-data; name="' . $name .
                '"' . "\r\n\r\n";
            $payload .= $value;
            $payload .= "\r\n";
        }
        if ( $file ) {
            $payload .= '--' . $boundary;
            $payload .= "\r\n";
            $payload .= 'Content-Disposition: form-data; name="' . 'file' .
                '"; filename="' . $file['name'] . '"' . "\r\n";
            //        $payload .= 'Content-Type: image/jpeg' . "\r\n";
            $payload .= "\r\n";
            $payload .= file_get_contents( $file['tmp_name'] );
            $payload .= "\r\n";
        }
        $payload .= '--' . $boundary . '--';
        $response = wp_remote_post( self::$post_endpoints[$type]['url'],
            array(
                'headers'    => $headers,
                'body'       => $payload,
            )
        );
        if ( is_wp_error( $response ) ) {
            $error_message = $response->get_error_message();
            return array(
                'status' => 'error',
                'message' => 'Something went wrong: ' . $error_message
            );
        }

        return json_decode($response['body']);
    }

    /**
     * Get data from api
     * @param string $url
     * @param string $api_key
     * @param array $options
     * @return object
     */
    private static function remote_get($url, $api_key='', $options = array())
    {
        if(!empty($api_key)){
            $token = $api_key;
        }else{
            $token = self::getToken();
        }
//        if(empty($token)){
//            return (object) array(
//                'status' => 'error',
//                'error_type' => 'not connected',
//                'message' => 'Api is not connected'
//            );
//        }
        $response = wp_remote_get( $url , array_merge(array(
            'headers' => array(
                'Authorization' => 'Bearer '. $token
            ),
        ), $options));
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
     * @param array $headers
     * @param bool $token
     * @return array|mixed|object
     */
    private static function remote_post($url, $data, $headers= array(), $token= true)
    {
        $request = [];

        if(!empty($data)){
            $request = [
                'body'    => $data
            ];
        }


        if($token){
            $request['headers']['Authorization']  = 'Bearer ' . self::getToken();
        }
        if(!empty($headers)){
            $request['headers'] = array_merge($request['headers'], $headers);
        }
        $response = wp_remote_post( $url, $request);
        if ( is_wp_error( $response ) ) {
            $error_message = $response->get_error_message();
            return array(
                'status' => 'error',
                'message' => 'Something went wrong: ' . $error_message
            );
        }

        return json_decode($response['body']);
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
        $settings = EasyJobs_DB::get_settings();
        return self::$token = !empty($settings['easyjobs_api_key']) ? $settings['easyjobs_api_key'] : '';
    }

}