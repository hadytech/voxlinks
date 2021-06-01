<?php

/**
 * Fired during plugin activation
 *
 * @link       https://easy.jobs
 * @since      1.0.0
 *
 * @package    Easyjobs
 * @subpackage Easyjobs/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Easyjobs
 * @subpackage Easyjobs/includes
 * @author     EasyJobs <support@easy.jobs>
 */
class Easyjobs_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate($network_wide) {
        $main_page = get_posts( array(
            'post_type'      => 'page',
            'posts_per_page' => - 1,
            'meta_query'     => array(
                array(
                    'key'     => 'easyjobs_job_id',
                    'value'   => 'all',
                    'compare' => '='
                ),
            ),
        ) );
        if(empty($main_page)){
            $page_id = wp_insert_post(array(
                'post_type' => sanitize_text_field('page'),
                'post_title' => sanitize_text_field('Jobs'),
                'post_status' => sanitize_text_field('publish'),
                'post_content' => sanitize_textarea_field('[easyjobs]'),
                'page_template'  => sanitize_file_name('easyjobs-template.php')
            ));
            if($page_id){
                update_post_meta($page_id,'easyjobs_job_id', 'all');
            }
        }
        flush_rewrite_rules();

        if ( is_multisite() && $network_wide ) {
            return;
        }
        set_transient( 'easyjobs_activation_redirect', true, MINUTE_IN_SECONDS );
	}

}
