<?php

/**
 * Fired during plugin activation
 *
 * @link       https://wpdeveloper.net/
 * @since      1.0.0
 *
 * @package    Crowdfundly
 * @subpackage Crowdfundly/includes
 * @author     WPDeveloper 
 */
class Crowdfundly_Activator {

	/**
	 * Fired during call activation_hook
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		self::before_redirect();
		$organization_id = self::create_organization_page();
		if ($organization_id) {
            self::create_all_campaigns_page($organization_id);
            self::create_single_campaign_page($organization_id);
        }

        global $wp_rewrite; 
        $wp_rewrite->set_permalink_structure('/%postname%/'); 
        update_option( "rewrite_rules", FALSE );
        $wp_rewrite->flush_rules( true );
	}

    /**
     * @return null
     */
	public static function create_organization_page() {
		$organization_page = get_posts( array(
            'post_type'      => 'page',
            'posts_per_page' => - 1,
            'meta_query'     => array(
                array(
                    'key'     => 'crowdfundly_organization_page_id',
                    'value'   => 'all',
                    'compare' => '='
                ),
            ),
		) );
		
        if(empty($organization_page)){
            $page_id = wp_insert_post(array(
                'post_type'     => 'page',
                'post_title'    => sanitize_text_field('Organization'),
                'post_name'     => sanitize_text_field('crowdfundly-organization'),
                'post_status'   => 'publish',
                'post_content'  => sanitize_textarea_field('[crowdfundly-organization]'),
                'page_template' => sanitize_file_name('crowdfundly-template.php')
            ));
            if($page_id){
                update_post_meta($page_id,'crowdfundly_organization_page_id', 'all');
                update_option('crowdfundly_organization_page_id', $page_id);
            }
            return $page_id;
        }

        return null;
	}

    /**
     * @param $organization_page_id
     */
	public static function create_all_campaigns_page($organization_page_id) {
		$all_campaign_page = get_posts( array(
            'post_type'      => 'page',
            'posts_per_page' => - 1,
            'meta_query'     => array(
                array(
                    'key'     => 'crowdfundly_all_campaigns_page_id',
                    'value'   => 'all',
                    'compare' => '='
                ),
            ),
		) );
		
        if(empty($all_campaign_page)){
            $page_id = wp_insert_post(array(
                'post_type'         => 'page',
                'post_title'        => sanitize_text_field('All Campaigns'),
                'post_status'       => 'publish',
                'post_name'         => sanitize_text_field('crowdfundly-all-campaigns'),
                'post_content'      => sanitize_textarea_field('[crowdfundly-all-campaigns]'),
                'page_template'     => sanitize_file_name('crowdfundly-template.php'),
                'post_parent'       => $organization_page_id,
            ));
            if($page_id){
                update_post_meta($page_id,'crowdfundly_all_campaigns_page_id', 'all');
                update_option('crowdfundly_all_campaigns_page_id', $page_id);
            }
        }
	}

    /**
     * @param $organization_page_id
     */
	public static function create_single_campaign_page($organization_page_id)
    {
        $single_campaign_page = get_posts( array(
            'post_type'      => 'page',
            'posts_per_page' => - 1,
            'meta_query'     => array(
                array(
                    'key'     => 'crowdfundly_single_campaign_page_id',
                    'value'   => 'all',
                    'compare' => '='
                ),
            ),
        ) );

        if(empty($single_campaign_page)){
            $page_id = wp_insert_post(array(
                'post_type'         => 'page',
                'post_title'        => sanitize_text_field('Single Campaign'),
                'post_status'       => 'publish',
                'post_name'         => sanitize_text_field('crowdfundly-campaign'),
                'post_content'      => sanitize_textarea_field('[crowdfundly-campaign]'),
                'page_template'     => sanitize_file_name('crowdfundly-template.php'),
                'post_parent'       => $organization_page_id
            ));
            if($page_id){
                update_post_meta($page_id,'crowdfundly_single_campaign_page_id', 'all');
                update_option('crowdfundly_single_campaign_page_id', $page_id);
            }
        }
	}
	
	protected static function before_redirect() {
		add_option( 'crowdfundly_activate_redirect', true );
	}

	public static function redirect() {
		add_action( 'admin_init', function() {
			if ( get_option( 'crowdfundly_activate_redirect', false ) && ! isset( $_GET['activate-multi'] ) ) {
				delete_option( 'crowdfundly_activate_redirect' );
				wp_safe_redirect( admin_url( 'admin.php?page=crowdfundly-admin' ) );
				exit;
			}
		} );
	}

}
