<?php

/**
 * Class Easyjobs_Helper
 */
class Easyjobs_Helper {
    /**
     * @param $rating
     * @return string
     */
    public static function rating_icon($rating) {
        $icons = '';
        for($i = 1; $i <= 5; $i++){
            $icons .= '<div class="rate-count';
            if($i <= $rating){
                $icons .= ' rated has-rating">';
            }else{
                $icons .= '">';
            }
            $icons .= '<i class="eicon e-star"></i>
                        </div>';
        }
        return $icons;
    }

    /**
     * This function is responsible for making an array sort by their key
     * @param  array  $data
     * @param  string $using
     * @param  string $way
     * @return array
     */
    public static function sorter($data, $using = 'time_date', $way = 'DESC') {
        if (!is_array($data)) {
            return $data;
        }
        $new_array = [];
        if ($using === 'key') {
            if ($way !== 'ASC') {
                krsort($data);
            } else {
                ksort($data);
            }
        } else {
            foreach ($data as $key => $value) {
                if (!is_array($value)) {
                    continue;
                }
                foreach ($value as $inner_key => $single) {
                    if ($inner_key == $using) {
                        $value[ 'tempid' ] = $key;
                        $single = self::numeric_key_gen($new_array, $single);
                        $new_array[ $single ] = $value;
                    }
                }
            }

            if ($way !== 'ASC') {
                krsort($new_array);
            } else {
                ksort($new_array);
            }

            if (!empty($new_array)) {
                foreach ($new_array as $array) {
                    $index = $array['tempid'];
                    unset($array['tempid']);
                    $new_data[ $index ] = $array;
                }
                $data = $new_data;
            }
        }

        return $data;
    }

    /**
     * This function is responsible for generate unique numeric key for a given array.
     *
     * @param  array   $data
     * @param  integer $index
     * @return integer
     */
    private static function numeric_key_gen($data, $index = 0) {
        if (isset($data[ $index ])) {
            $index += 1;
            return self::numeric_key_gen($data, $index);
        }
        return $index;
    }

    /**
     * This function is responsible for the data sanitization
     *
     * @param  array        $field
     * @param  string|array $value
     * @return string|array
     */
    public static function sanitize_field($field, $value) {
        if (isset($field['sanitize']) && !empty($field['sanitize'])) {
            if (function_exists($field['sanitize'])) {
                $value = call_user_func($field['sanitize'], $value);
            }
            return $value;
        }

        if (is_array($field) && isset($field['type'])) {
            switch ($field['type']) {
                case 'text':
                    $value = sanitize_text_field($value);
                    break;
                case 'textarea':
                    $value = sanitize_textarea_field($value);
                    break;
                case 'email':
                    $value = sanitize_email($value);
                    break;
                default:
                    return $value;
                    break;
            }
        } else {
            $value = sanitize_text_field($value);
        }

        return $value;
    }

    /**
     * Get single job from api
     * @since 1.0.0
     * @param $job_id
     * @return object|bool
     */
    public static function get_job($job_id) {
        $job = Easyjobs_Api::get_by_id('job', $job_id, 'details');
        if ($job && $job->status == 'success') {
            return $job->data;
        }
        return false;
    }

    /**
     * @return string[][]
     */
    public static function subscription_constants() {
        return array(
            /*'attributes' => [
                'companies' => 'Companies',
                'jobs' => 'Active jobs',
                'applications' => 'Active candidates',
                'managers' => 'Team Accounts',
                'messaging' => 'In app messaging',
                'quizzes' => 'Quiz',
                'analytics' => 'Details analytics',
                'job_pipeline' => 'Smart Workflow',
                'custom_domain' => 'Custom domain',
                'screening' => 'IQ test',
            ],*/
            'plan' => [
                1 => 'Month',
                2 => 'Year',
                3 => 'Lifetime'
            ],
            'type' => [
                1  => 'Regular',
                50 => 'App Sumo',
                2  => 'Special',
            ]
        );
    }

    /**
     * @param $data
     * @param $text
     */
    public static function subscription_data_html($data, $text) {
        if ($data) {
            echo __($text, EASYJOBS_TEXTDOMAIN);
        } else {
            echo '<del>' . __($text, EASYJOBS_TEXTDOMAIN) . '</del>';
        }
    }

    /**
     * @return bool
     */
    public static function is_api_connected() {
        $settings = EasyJobs_DB::get_settings();
        if (isset($settings['easyjobs_api_key']) && !empty($settings['easyjobs_api_key'])) {
            return true;
        }
        return false;
    }

    /**
     * @param $employment_type
     * @return string
     */
    public static function get_employment_badge($employment_type)
    {
        if(strtolower($employment_type) == 'permanent'){
            return '<span class="ej-employment-badge permanent">Permanent</span>';
        }
        return '<span class="ej-employment-badge '. strtolower($employment_type) .'">' . $employment_type . '</span>';
    }

    /**
     * @param $number
     * @param $text
     * @return string
     */
    public static function get_dynamic_label($number, $text)
    {
        $labels = [
            'info-label',
            'success-label',
            'primary-label',
            'danger-label',
            'warning-label'
        ];
        $label_count = count($labels);
        if($number < $label_count){
            return '<span class="ej-label ej-'.$labels[$number].'">'. $text . '</span>';
        }else{
            $number = $number + 1;
            $position = ($number - (floor($number / $label_count) * $label_count)) - 1;
            return '<span class="ej-label ej-'.$labels[$position].'">'. $text . '</span>';
        }
    }

	/**
	 * Render array in job_id => page_id format
	 * @since 1.0.0
	 * @param object $jobs
	 * @return array
	 */
	public static function get_job_with_page( $jobs ) {
		$job_with_page = array();
		$pages         = self::get_job_pages( $jobs );
		if ( ! empty( $pages ) ) {
			foreach ( $pages as $page ) {
				$job_with_page[ get_post_meta( $page->ID, 'easyjobs_job_id', true ) ] = $page->ID;
			}
		}

		return $job_with_page;
	}

	/**
	 * Get pages that contains shortcode
	 * @since 1.0.0
	 * @param object $jobs
	 * @return array|null
	 */
	public static function get_job_pages( $jobs ) {
		$published_jobs_ids = array();
		if ( empty( $jobs ) ) {
			return null;
		}
		foreach ( $jobs as $key => $job ) {
			array_push( $published_jobs_ids, $job->id );
		}
		array_push( $published_jobs_ids, 'all' );
		
		$pages = get_posts( array(
			'post_type'      => 'page',
			'posts_per_page' => - 1,
			'meta_query'     => array(
                'relation' => 'OR',
                array(
                    'key'     => 'easyjobs_job_id',
                    'value'   => $published_jobs_ids,
                    'compare' => 'IN'
                ),
                array(
                    'key'     => 'easyjobs_job_id',
                    'value'   => 'all',
                    'compare' => '='
                ),
			),
		) );

		return $pages;
	}

    /**
     * @return false
     */
    public static function get_company_info()
    {
        $settings = EasyJobs_DB::get_settings();
        if(!empty($settings['easyjobs_api_key'])){
            $company_info = Easyjobs_Api::get('company');
            if(!empty($company_info) && $company_info->status == 'success'){
                return $company_info->data;
            }
        }

        return false;
    }

    /**
     * @param $type
     * @return string
     */
    public static function get_social_link_icon($type)
    {
        $icon = '';
        switch (strtolower($type)){
            case 'facebook':
                $icon = '<i class="eicon e-facebook"></i>';
                break;
            case 'linkedin':
                $icon = '<i class="eicon e-linkedin"></i>';
                break;
            case 'twitter':
                $icon = '<i class="eicon e-twitter"></i>';
                break;
            default:
                $icon = '<i class="dashicons dashicons-share"></i>';
                break;
        }
        return $icon;
        
    }
    
    /**
     * Get frontend landing page
     * @since 1.0.4
     * @return WP_Post|null
     */
    public static function get_landing_page()
    {
        $page = get_posts( array(
            'post_type'      => 'page',
            'posts_per_page' => 1,
            'meta_query'     => array(
                array(
                    'key'     => 'easyjobs_job_id',
                    'value'   => 'all',
                    'compare' => '='
                ),
            ),
        ) );
        if(!empty($page))
            return $page[0];
        
        return null;
    }

    /**
     * @param $name
     * @return string|string[]
     */
    public static function get_tab_name($name)
    {
        return str_replace(' ','-', strtolower($name));
    }

    /**
     * @param $status
     * @return string
     */
    public static function get_job_status_badge($status)
    {
        switch ($status){
            case 1:
                return '<div class="thumbnail__status thumbnail__status--warning">' . __('Draft', EASYJOBS_TEXTDOMAIN) . '</div>';
            case 2:
                return '<div class="thumbnail__status thumbnail__status--success">' . __('Active', EASYJOBS_TEXTDOMAIN) . '</div>';
            case 3:
                return '<div class="thumbnail__status thumbnail__status--info">' . __('Archived', EASYJOBS_TEXTDOMAIN) . '</div>';
            case 4:
                return '<div class="thumbnail__status thumbnail__status--danger">' . __('Deleted', EASYJOBS_TEXTDOMAIN) . '</div>';
            case 10:
                return '<div class="thumbnail__status thumbnail__status--success">' . __('Republished', EASYJOBS_TEXTDOMAIN) . '</div>';
            default:
                return '<div class="thumbnail__status thumbnail__status--success">' . __('Active', EASYJOBS_TEXTDOMAIN) . '</div>';
                
        }
    }
    /**
     * Create pages for jobs if not created
     * @since 1.1.1
     * @param object $jobs
     * @param array $job_with_page_id
     * @return array
     */

    public static function create_pages_if_required($jobs, $job_with_page_id)
    {
        $parent_page = null;
        if(isset($job_with_page_id['all']) && !empty($job_with_page_id['all'])){
            $parent_page = $job_with_page_id['all'];
        }
        $new_job_id_page_id = array();
        if(empty($parent_page)){
            $parent = get_posts( array(
                'post_type'      => 'page',
                'posts_per_page' => - 1,
                'meta_query'     => array(
                    array(
                        'key'     => 'easyjobs_job_id',
                        'value'   => 'all',
                        'compare' => 'IN'
                    ),
                ),
            ) );
            if(empty($parent)){
                $parent_page = self::create_parent_page();
            }
        }
        if (!empty($parent_page) && !empty($jobs)) {
            foreach ($jobs as $key => $job) {
                if (array_key_exists($job->id, $job_with_page_id)) {
                    continue;
                }
                $page_id = wp_insert_post(array(
                    'post_type' => 'page',
                    'post_title' => $job->title,
                    'post_status' => 'publish',
                    'post_parent' => $parent_page,
                    'post_content' => '[easyjobs_details id=' . $job->id . ']',
                    'page_template'  => 'easyjobs-template.php'
                ));
                if ($page_id) {
                    update_post_meta($page_id, 'easyjobs_job_id', $job->id);
                    $new_job_id_page_id[$job->id] = $page_id;
                }
            }
        }
        return $new_job_id_page_id;
    }


    /**
     * @param $scores
     * @return string
     */
    public static function get_ai_score_circles($scores)
    {
        $html = '';
        $scores = array_filter((array)$scores, function($s){
            return !empty( $s);
        });

        unset($scores['final_score']);

        $sum = array_sum($scores);
        $key = 1;
        $prev_offset = 0;
        $prev_result = 0;

        foreach ($scores as $name => $score){

            $result = (int) round(($score / $sum) * 100);

            if($key == 1){
                $offset = $prev_offset;
            }else{
                $offset = (100 - $prev_result) + $prev_offset;
                $prev_offset = $offset;
            }

            $prev_result = $result;

            $html .= '<circle class="donut-segment" cx="18" cy="18" r="18" fill="transparent" stroke="'.self::get_ai_score_color($name).'" stroke-width="3" stroke-dasharray=" '. $result .', ' . (100 - $result) . '" stroke-dashoffset="'.$offset.'"></circle>';

            $key++;
        }
        return $html;

    }

    /**
     * @param $name
     * @return string
     */
    public static function get_ai_score_color($name)
    {
        $colors = [
            'quiz' => '#ff9635',
            'skill' => '#2fc1e1',
            'education' => '#597dfc',
            'experience' => '#60ce83',
            'final_score' => '#ff5f74'
        ];

        return $colors[$name];
    }

    /**
     * @param $scores
     */
    public static function get_ai_score_details($scores)
    {
        include EASYJOBS_ADMIN_DIR_PATH . 'partials/easyjobs-ai-score-details.php';
    }

    /**
     * @param $scores
     */
    public static function get_ai_score_chart($scores)
    {
        include EASYJOBS_ADMIN_DIR_PATH . 'partials/easyjobs-ai-score-chart.php';
    }

    /**
     * @param $total
     * @param $mark
     * @return float|int
     */
    public static function get_mark_percentage($total, $mark)
    {
        if(empty($total)){
            return 0;
        }
        return round(($mark / $total) * 100);
    }


    /**
     * @param $status
     * @return bool
     */
    public static function is_success_response($status)
    {
        if(strtolower(trim($status)) === 'success')
            return true;

        return false;
    }

    /**
     * @param $name
     * @return string
     */
    public static function get_pipeline_label($name)
    {
        switch (strtolower($name)){
            case 'selected':
                return 'success-label';
            case 'rejected':
                return 'danger-label';
            default:
                return 'primary-label';
        }
    }

    /**
     * Format api error response to display in frontend
     * @param object $error_messages
     * @since 1.1.2
     * @return array
     */

    public static function format_api_error_response($error_messages)
    {
        $errors = [];
        foreach ($error_messages as $key => $message){
            if(is_array($message)){
                foreach ($message as $k => $m){
                    if($k > 1){
                        $errors[$key] .= ' and ';
                    }
                    $errors[$key] .= $m;

                }
                continue;
            }else{
                $errors['global']= ' ' . $message;
            }
        }

        return $errors;
    }

    /**
     * @param $var
     * @return bool
     */
    public static function is_iterable($var)
    {
        return is_array($var) || $var instanceof \Traversable || $var instanceof stdClass;
    }

    /**
     * @param $response
     * @return false|string
     */
    public static function get_generic_response($response)
    {
        if(empty($response->status)){
            return self::get_error_response($response);
        }
        if(self::is_success_response($response->status)){
            return json_encode([
                'status' => 'success',
                'data' => $response->data
            ]);
        }else{
            return self::get_error_response($response->message);
        }
    }

    /**
     * @param $message
     * @return false|string
     */
    public static function get_error_response($message)
    {
        return json_encode([
            'status' => 'error',
            'message' => $message
        ]);
    }

    /**
     * @return bool|null
     */
    public static function get_verification_status()
    {
        if($status = get_transient('easyjobs_company_verification_status')){
            return trim($status) == 'yes';
        }
        $response = Easyjobs_Api::get('settings_basic_info');
        if(Easyjobs_Helper::is_success_response($response->status)){
            set_transient('easyjobs_company_verification_status', $response->data->is_verified ? 'yes' : 'no', 3600);
            return $response->data->is_verified;
        }
        return null;
    }

    /**
     * Candidate sorting options with values
     * @since 1.3.1
     * @return array[]
     */
    public static function candidateSortOptions()
    {
        return [
            [
                'title' => 'Sort by experience',
                'value' => 'SORT_BY_EXPERIENCE'
            ],
            [
                'title' => 'Sort by skill match',
                'value' => 'SORT_BY_SKILL_MATCH'
            ],
            [
                'title' => 'Sort by education match',
                'value' => 'SORT_BY_EDUCATION_MATCH'
            ],
            [
                'title' => 'Sort by experience match',
                'value' => 'SORT_BY_EXPERIENCE_MATCH'
            ],
            [
                'title' => 'Sort by AI score',
                'value' => 'SORT_BY_TOTAL_AI_SCORE'
            ],
            [
                'title' => 'Sort by quiz score',
                'value' => 'SORT_BY_QUIZ_SCORE'
            ],
        ];
    }

    /**
     * Check if ai setup is enabled and insert it in db if required
     * @since 1.3.1
     * @return bool
     */
    public static function is_ai_enabled()
    {
        $exist = EasyJobs_DB::get_settings('easyjobs_ai_setup', true);
        if($exist){
            return $exist === 'yes';
        }else{
            $response = Easyjobs_Api::get('ai_setup');
            if(Easyjobs_Helper::is_success_response($response->status)){
                EasyJobs_DB::update_settings((bool) $response->data->ai_setup_enabled ? 'yes' : 'no', 'easyjobs_ai_setup');
                return (bool) $response->data->ai_setup_enabled;
            }
        }
        return false;
    }

    public static function customizer_link(){

        $query['autofocus[panel]'] = 'easyjobs_customize_options';
        $query['return'] = admin_url( urlencode('admin.php?page=easyjobs#/settings') );

        $job_landing_page = Easyjobs_Helper::get_landing_page();

        if(!empty($job_landing_page)){
            $query['url'] = get_permalink($job_landing_page->ID);
        }

        return add_query_arg( $query, admin_url( 'customize.php' ) );
    }

    public static function create_parent_page()
    {
        $page_id = wp_insert_post(array(
            'post_type' => sanitize_text_field('page'),
            'post_title' => sanitize_text_field('Jobs'),
            'post_status' => sanitize_text_field('publish'),
            'post_content' => sanitize_textarea_field('[easyjobs]'),
            'page_template'  => sanitize_file_name('easyjobs-template.php')
        ));
        if($page_id){
            update_post_meta($page_id,'easyjobs_job_id', 'all');
            return $page_id;
        }
        return null;
    }
}
