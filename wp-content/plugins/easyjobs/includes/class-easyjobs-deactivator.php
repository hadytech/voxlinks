<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://easy.jobs
 * @since      1.0.0
 *
 * @package    Easyjobs
 * @subpackage Easyjobs/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Easyjobs
 * @subpackage Easyjobs/includes
 * @author     EasyJobs <support@easy.jobs>
 */
class Easyjobs_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
        /*$job_page = get_posts( array(
            'post_type' => 'page',
            'posts_per_page' => 1,
            'fields' => 'ids',
            'meta_query' => array(
                array(
                    'key' => 'easyjobs_job_id',
                    'value' => array('all'),
                ),
            ),
        ));
        $child_pages = get_children( array(
            'post_parent' => $job_page[0],
            'post_type'   => 'any',
            'numberposts' => -1,
            'fields'=> 'ids',
            'post_status' => 'any'
        ) );
        foreach ($child_pages as $page){
            wp_delete_post($page);
        }
        wp_delete_post($job_page[0]);*/
	}

}
