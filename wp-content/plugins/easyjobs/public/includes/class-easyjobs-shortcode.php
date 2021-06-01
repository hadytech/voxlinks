<?php
/**
 * Class Easyjobs_Shortcode
 * Handles all public shortcodes for Easyjobs
 * @since 1.0.0
 */
class Easyjobs_Shortcode
{
    /**
     * Easyjobs_Shortcode constructor.
     */
    public function __construct()
    {
        add_shortcode( 'easyjobs', array( $this, 'render_easyjobs_shortcode' ) );
        add_shortcode( 'easyjobs_list', array( $this, 'render_easyjobs_list_shortcode' ) );
        add_shortcode( 'easyjobs_details', array( $this, 'render_easyjobs_details_shortcode' ) );
    }

    /**
     * Render content for shortcode 'easyjobs'
     * @since 1.0.0
     * @return false|string
     */
    public function render_easyjobs_shortcode()
    {
        $company = $this->get_company_info();
        $jobs = $this->get_published_jobs();
        $job_with_page_id = EasyJobs_Helper::get_job_with_page($jobs);
        $new_job_with_page_id = EasyJobs_Helper::create_pages_if_required($jobs, $job_with_page_id);

        // if there is new job and page, we need to add it
        $job_with_page_id = $job_with_page_id + $new_job_with_page_id;

        ob_start();
        include EASYJOBS_PUBLIC_PATH . 'partials/easyjobs-jobs-landing.php';
        return ob_get_clean();
    }
    /**
     * Render content for shortcode 'easyjobs_details'
     * @since 1.0.0
     * @return false|string
     */
    public function render_easyjobs_details_shortcode($atts)
    {
        if(empty($atts['id'])){
            return '';
        }
        $company = $this->get_company_info();
        $job = Easyjobs_Helper::get_job($atts['id']);
        ob_start();
        include EASYJOBS_PUBLIC_PATH . 'partials/easyjobs-job-details.php';
        return ob_get_clean();
    }

    public function render_easyjobs_list_shortcode()
    {
        if(!Easyjobs_Helper::is_api_connected()){
            return __('Api is not connected', EASYJOBS_TEXTDOMAIN);
        }
        $jobs = $this->get_published_jobs();
        $job_with_page_id =Easyjobs_Helper::get_job_with_page($jobs);
        $new_job_with_page_id = EasyJobs_Helper::create_pages_if_required($jobs, $job_with_page_id);

        // if there is new job and page, we need to add it
        $job_with_page_id = $job_with_page_id + $new_job_with_page_id;

        ob_start();
        include EASYJOBS_PUBLIC_PATH . 'partials/easyjobs-job-list.php';
        return ob_get_clean();
    }

    /**
     * Get published job from api
     * @since 1.0.0
     * @return object|false
     */
    private function get_published_jobs()
    {
        $jobs = Easyjobs_Api::get('published_jobs');
        if($jobs->status === 'success'){
            return $jobs->data;
        }
        return false;
    }

    /**
     * Get company info from api
     * @since 1.0.0
     * @return object|bool
     */
    private function get_company_info()
    {
        $company_info = Easyjobs_Api::get('company');
        if(!empty($company_info) && $company_info->status == 'success'){
            return $company_info->data;
        }
        return false;
    }
}