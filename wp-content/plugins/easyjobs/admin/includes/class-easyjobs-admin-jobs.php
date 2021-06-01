<?php

/**
 * This class is responsible for all job functionality in admin area
 * @since 1.0.0
 */
class Easyjobs_Admin_Jobs
{
    public $job_with_page = array();
    
    /**
     * Easyjobs_Admin_Jobs constructor.
     * @since 1.0.5
     */
    public function __construct()
    {
        add_action('wp_ajax_easyjobs_search_jobs', array($this, 'show_search_results'));
        add_action('wp_ajax_easyjobs_get_job_create_meta', array($this, 'get_job_create_meta'));
        add_action('wp_ajax_easyjobs_save_job_information', array($this, 'save_job_information'));
        add_action('wp_ajax_easyjobs_get_screening_question_meta', array($this, 'get_screening_question_meta'));
        add_action('wp_ajax_easyjobs_save_screening_questions', array($this, 'save_screening_questions'));
        add_action('wp_ajax_easyjobs_get_quiz_meta', array($this, 'get_quiz_meta'));
        add_action('wp_ajax_easyjobs_save_quiz', array($this, 'save_quiz'));
        add_action('wp_ajax_easyjobs_change_job_status', array($this, 'change_job_status'));
        add_action('wp_ajax_easyjobs_get_job_data', array($this, 'get_job_data'));
        add_action('wp_ajax_easyjobs_save_required_fields', array($this, 'save_required_fields'));
        add_action('wp_ajax_easyjobs_delete_job', array($this, 'delete_job'));
    }
    /**
     * Show jobs
     * @since 1.0.0
     * @return void
     */

    public function show_all()
    {
        $jobs = (object)array(
            'published' => $this->get_published_jobs(),
            'draft' => $this->get_draft_jobs(),
            'archived' => $this->get_archived_jobs(),
        );

        $job_with_page_id = Easyjobs_Helper::get_job_with_page($jobs->published);
        $new_job_with_page_id = Easyjobs_Helper::create_pages_if_required($jobs->published, $job_with_page_id);
        $published_job_page_ids = $job_with_page_id + $new_job_with_page_id;

        include EASYJOBS_ADMIN_DIR_PATH . 'partials/easyjobs-jobs-display.php';
    }

    /**
     * Get published jobs
     * @since 1.0.0
     * @return object|bool
     */
    public function get_published_jobs()
    {
        $jobs = Easyjobs_Api::get('published_jobs');
        if ($jobs && $jobs->status == 'success') {
            return $jobs->data;
        }
        return false;
    }

    /**
     * Get draft jobs
     * @since 1.0.0
     * @return object|bool
     */
    public function get_draft_jobs()
    {
        $jobs = Easyjobs_Api::get('draft_jobs');
        if ($jobs && $jobs->status == 'success') {
            return $jobs->data;
        }
        return false;
    }

    /**
     * Get archived jobs from api
     * @since 1.0.0
     * @return object|bool
     */
    public function get_archived_jobs()
    {
        $jobs = Easyjobs_Api::get('archived_jobs');
        if ($jobs && $jobs->status == 'success') {
            return $jobs->data;
        }
        return false;
    }

    /**
     * Show search result
     * @since 1.0.0
     */
    public function show_search_results()
    {
        if(!isset($_POST['keyword']) && !isset($_POST['type'])){
            return;
        };
        $keyword = sanitize_text_field($_POST['keyword']);
        $type = sanitize_text_field($_POST['type']);
        $job_page_links = [];
        if($type == 'published-jobs'){
            $result = $this->get_search_results('published_jobs',$keyword);
            $job_with_page_id = Easyjobs_Helper::get_job_with_page($result);
            $new_job_with_page_id = Easyjobs_Helper::create_pages_if_required($result, $job_with_page_id);
            $job_page_ids = $job_with_page_id + $new_job_with_page_id;
            foreach ($result as $r){
                $job_page_links[$r->id] = get_permalink($job_page_ids[$r->id]);
            }
        }
        if($type == 'draft-jobs'){
            $result = $this->get_search_results('draft_jobs',$keyword);
        }
        if($type == 'archived-jobs'){
            $result = $this->get_search_results('archived_jobs',$keyword);
        }
        if(!empty($result)){
            echo json_encode(array(
                'status' => 'success',
                'jobs' => $result,
                'job_page_links' => $job_page_links
            ));
            wp_die();
        }else{
            echo json_encode(array(
                'status' => 'error'
            ));
            wp_die();
        }
    }

    /**
     * Get search result from api
     * @since 1.0.0
     * @param string $type
     * @param string $keyword
     * @return object|bool
     */
    public function get_search_results($type, $keyword)
    {
        $jobs = Easyjobs_Api::search($type, $keyword);
        if ($jobs && $jobs->status == 'success') {
            return $jobs->data;
        }
        return false;
    }

    public function create_job()
    {
        wp_enqueue_script('easyjobs-react');
        include EASYJOBS_ADMIN_DIR_PATH . '/partials/easyjobs-react-layout.php';
    }


    public function get_job_create_meta()
    {
        $metas = Easyjobs_Api::get('job_metas');
        $data = [];
        if(Easyjobs_Helper::is_success_response($metas->status)){
            $data['meta'] = $metas->data;
        }
        if(!empty($data)){
            echo json_encode([
                'status' => 'success',
                'data' => $data
            ]);
        }else{
            echo json_encode([
                'status' => 'error',
                'message' => 'Unable to fetch all data required for job create.'
            ]);
        }

        wp_die();
    }

    public function save_job_information()
    {
        $fields = [
            'title',
            'details',
            'responsibilities',
            'category',
            'vacancies',
            'is_remote',
            'country',
            'state',
            'city',
            'expire_at',
            'employment_type',
            'experience_level',
            'salary_type',
            'salary',
            'office_time',
            'skills',
            'benefits',
            'has_benefits',
            'coverPhoto',
        ];
        $object_values = [
            'category',
            'country',
            'state',
            'city',
            'skills',
            'employment_type',
            'experience_level',
            'salary_type',
        ];
        $data = [];
        foreach ($this->sanitize_form_fields($_POST, $fields) as $key => $form_field){
            if(in_array($key, $object_values)){
                $data[$key] = !empty($form_field) ? json_decode(stripslashes($form_field)): null;
            }else{
                $data[$key] = $form_field;
            }
        }
        if(isset($_POST['job_id'])){
            $response = Easyjobs_Api::post('update_job_info',absint($_POST['job_id']), $data);
        }else{
            $response = Easyjobs_Api::post('save_job_info',null, $data);
        }

        if(Easyjobs_Helper::is_success_response($response->status)){
            echo json_encode([
                'status' => 'success',
                'data' => $response->data
            ]);
        }else{
            echo json_encode([
                'status' => 'error',
                'error' => !empty($response->message) ? Easyjobs_Helper::format_api_error_response($response->message) : ['global' => 'Something went wrong, please try again']
            ]);
        }
        wp_die();
    }

    public function get_screening_question_meta()
    {
        $meta = Easyjobs_Api::get('screening_question_meta');
        if(Easyjobs_Helper::is_success_response($meta->status)){
            echo json_encode([
                'status' => 'success',
                'data' => $meta->data
            ]);
        }else{
            echo json_encode([
                'status' => 'error',
                'message' => $meta->message
            ]);
        }
        wp_die();
    }

    public function save_screening_questions()
    {
        if(!isset($_POST['job_id'])){
            echo json_encode([
                'status' => 'error',
                'message' => 'Job id not found'
            ]);
            wp_die();
        }
        if(!isset($_POST['questions'])){
            echo json_encode([
                'status' => 'error',
                'message' => 'Questions not found'
            ]);
            wp_die();
        }
        $questions = json_decode(stripslashes($_POST['questions']));
        $job_id = absint($_POST['job_id']);
        $sanitized = [];
        foreach ($questions as $question){
            $sanitized[] = $this->sanitize_form_fields($question, ['id','title', 'type', 'options', 'answers']);
        }
        $response = Easyjobs_Api::post('save_questions', $job_id, ['questions' => $sanitized]);

        if(Easyjobs_Helper::is_success_response($response->status)){
            echo json_encode([
                'status' => 'success',
                'data' => $response->data
            ]);
        }else{
            echo json_encode([
                'status' => 'error',
                'message' => $response->message
            ]);
        }

        wp_die();

    }

    public function get_quiz_meta()
    {
        $meta = Easyjobs_Api::get('quiz_meta');
        if($meta->status === 'success'){
            echo json_encode([
                'status' => 'success',
                'data' => $meta->data
            ]);
        }else{
            echo json_encode([
                'status' => 'error',
                'message' => $meta->message
            ]);
        }
        wp_die();
    }

    public function save_quiz()
    {
        if(!isset($_POST['job_id'])){
            echo json_encode([
                'status' => 'error',
                'message' => 'Job id not found'
            ]);
            wp_die();
        }
        if(!isset($_POST['form_data'])){
            echo json_encode([
                'status' => 'error',
                'message' => 'No data to save'
            ]);
            wp_die();
        }
        $form_data = json_decode(stripslashes($_POST['form_data']));
        $questions = $form_data->questions;
        $job_id = absint($_POST['job_id']);
        $sanitized = [];
        foreach ($questions as $question){
            $sanitized[] = $this->sanitize_form_fields($question, ['id','title', 'type', 'options', 'answers']);
        }

        $response = Easyjobs_Api::post('save_quiz', $job_id, [
            'questions' => $sanitized,
            'exam_duration' => sanitize_text_field($form_data->exam_duration),
            'marks_per_question' => sanitize_text_field($form_data->marks_per_question),
        ]);

        if(Easyjobs_Helper::is_success_response($response->status)){
            echo json_encode([
               'status' => 'success',
               'data' => $response->data
            ]);
        }else{
            echo json_encode([
                'status' => 'error',
                'message' => $response->message
            ]);
        }
        wp_die();

    }

    public function change_job_status()
    {
        if(!isset($_POST['job_id'])){
            echo json_encode([
                'status' => 'error',
                'message' => 'Job id not found'
            ]);
            wp_die();
        }
        if(!isset($_POST['status'])){
            echo json_encode([
                'status' => 'error',
                'message' => 'Status not provided'
            ]);
            wp_die();
        }

        $response = Easyjobs_Api::post(
            'change_status',
            absint($_POST['job_id']),
            ['status' => absint($_POST['status'])]
        );

        if(Easyjobs_Helper::is_success_response($response->status)){
            echo json_encode([
                'status' => 'success',
                'data' => $response->data
            ]);
        }else{
            echo json_encode([
                'status' => 'error',
                'message' => $response->message
            ]);
        }
        wp_die();
    }

    public function get_job_data()
    {
        if(!isset($_POST['job_id'])){
            echo Easyjobs_Helper::get_error_response('Job id not provided');
            wp_die();
        }
        if(!isset($_POST['type'])){
            echo Easyjobs_Helper::get_error_response('No type provided');
            wp_die();
        }

        echo Easyjobs_Helper::get_generic_response(Easyjobs_Api::get_by_id(
            'job',
            absint($_POST['job_id']),
            sanitize_text_field($_POST['type'])
        ));

        wp_die();
    }

    public function save_required_fields()
    {
        if(!isset($_POST['job_id'])){
            echo Easyjobs_Helper::get_error_response('Job id not provided');
            wp_die();
        }
        if(!isset($_POST['data'])){
            echo Easyjobs_Helper::get_error_response('No data provided');
            wp_die();
        }
        echo Easyjobs_Helper::get_generic_response(Easyjobs_Api::post(
            'required_fields',
            absint($_POST['job_id']),
            json_decode(stripslashes($_POST['data']))
        ));

        wp_die();
    }

    public function delete_job()
    {
        if (!isset($_POST['nonce']) && !wp_verify_nonce($_POST['nonce'], 'easyjobs_delete_job')) {
            echo json_encode(array(
                'status'  => 'error',
                'message' => 'Nonce not verified'
            ));
            wp_die();
        }
        if (!isset($_POST['form_data']) && !isset($_POST['job_id'])) {
            echo json_encode(array(
                'status'  => 'error',
                'message' => 'Empty form data or job id'
            ));
            wp_die();
        }

        echo json_encode(Easyjobs_Api::post('delete_job', absint($_POST['job_id']), []));
        wp_die();
    }
    private function sanitize_form_fields($post_data, $fields)
    {
        $data = [];
        foreach ($post_data as $key => $value){
            if(in_array($key, $fields)){
                if(Easyjobs_Helper::is_iterable($value)){
                    $data[sanitize_text_field($key)] = $value;
                }else{
                    if($key === 'id'){
                        if(!empty($value)){
                            $data[sanitize_text_field($key)] = absint($value);
                        }else{
                            $data[sanitize_text_field($key)] = null;
                        }

                    }else{
                        $data[sanitize_text_field($key)] = sanitize_text_field($value);
                    }
                }

            }
        }
        return $data;
    }
}