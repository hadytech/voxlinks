<?php
/**
 * This class is responsible for all job pipeline functionality
 * @since 1.0.0
 */
class Easyjobs_Admin_Pipeline {
    public function __construct() {
        add_action('wp_ajax_easyjobs_change_pipeline', array($this, 'change_pipeline'));
        add_action('wp_ajax_easyjobs_save_pipeline', array($this, 'save_pipeline'));
        add_action('wp_ajax_easyjobs_get_pipeline', array($this, 'get_pipeline'));
    }

    /**
     * Show pipelines
     * @since 1.0.0
     * @param  int  $job_id
     * @return void
     */
    public function show($job_id) {
        $pipelines = $this->get_pipelines($job_id);
        $job = Easyjobs_Helper::get_job($job_id);
        include EASYJOBS_ADMIN_DIR_PATH . 'partials/easyjobs-pipeline-display.php';
    }

    /**
     * Get pipelines
     * @since 1.0.0
     * @param  int    $job_id
     * @return object | bool
     */
    public function get_pipelines($job_id) {
        $pipelines = Easyjobs_Api::get_by_id('job', $job_id, 'pipeline');
        
        if ($pipelines && $pipelines->status == 'success') {
            return $pipelines->data;
        }
        return false;
    }

    /**
     * Ajax callback for 'easyjobs_save_pipeline' action
     * Save new pipeline stage in app through api
     * @since 1.0.0
     * @return void
     */
    public function save_pipeline() {
        if (!isset($_POST['nonce']) && !wp_verify_nonce($_POST['nonce'], 'easyjobs_save_pipeline')) {
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
        $data = array(
            'pipeline' => $_POST['form_data']
        );
        $response = Easyjobs_Api::post('save_pipeline', $_POST['job_id'], $data);
        echo json_encode($response);
        wp_die();
    }

    /**
     * Ajax callback for 'easyjobs_change_pipeline' action
     * Handles candidates pipeline stage change
     * @since 1.0.0
     * @return void
     */
    public function change_pipeline() {
        if (isset($_POST['pipeline_id']) && isset($_POST['applicants_id']) && isset($_POST['job_id'])) {
            $applicants = [];
            foreach ($_POST['applicants_id'] as $applicant){
                $applicants[] = sanitize_text_field($applicant);
            }

            $data = array(
                'applicants'  => $applicants,
                'pipeline_id' => sanitize_text_field($_POST['pipeline_id'])
            );

            $response = Easyjobs_Api::post('change_pipeline', sanitize_text_field($_POST['job_id']), $data);
            echo json_encode($response);
        }
        wp_die();
    }

    /**
     * Ajax callback for easyjobs_get_pipeline
     * Get all pipeline for a job
     * @since 1.1.2
     * @return void
     */

    public function get_pipeline()
    {
        if(isset($_POST['job_id'])){
            $job_id = sanitize_text_field($_POST['job_id']);
            $pipelines = $this->get_pipelines($job_id);
            if(empty($pipelines)){
                echo json_encode([
                    'status' => 'error'
                ]);
            }else{
                echo json_encode([
                    'status' => 'success',
                    'data' => $pipelines
                ]);
            }
        }
        wp_die();
    }
}
