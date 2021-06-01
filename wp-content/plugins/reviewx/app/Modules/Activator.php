<?php

namespace ReviewX\Modules;

use ReviewX\Controllers\Admin\Rating\ProductRating;
use ReviewX\Controllers\Admin\Rating\ReCalculateReviewRating;

class Activator
{
    /**
     * This method will be called on plugin activation
     */
    public function handleActivation()
    {
        require_once __DIR__ . '/../Services/WPFluent/wp-fluent.php';

        self::createMigration();
        if( get_option('_rx_option_disable_autocreate_unsubscribe_page') == '' || get_option('_rx_option_disable_autocreate_unsubscribe_page') == 0 ) {
            self::setupPages();
        }    
        self::setDefaultGravatar();

        set_transient( '_rx_plugin_activation', true, 30 );

        update_option( 'comment_previously_approved', '' );

        //Set enable WC menu
        if( \ReviewX\Controllers\Admin\Core\ReviewxMetaBox::rx_exists_option( '_rx_wc_active_check' ) == false ) {
            update_option( '_rx_wc_active_check', 1 );
        }

        flush_rewrite_rules();
    }

    /**
     * Create migration
     *
     * @return void
     */
    public static function createMigration()
    {
        self::createReviewxCriteriaTable();
        self::createProcessJobsTable();
        self::createReminderEmailTable();
    }

    /**
     * Create Reminder Email
     *
     * @return void
     */
    public static function createReminderEmailTable()
    {
        global $wpdb;
        $reviewx_reminder_email = $wpdb->prefix . 'reviewx_reminder_email';
        if ( ! self::tableExists($reviewx_reminder_email) ) {
            $query = "CREATE TABLE $reviewx_reminder_email (
                id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                order_id int(11) NOT NULL,
                customer_email varchar(100) NOT NULL,
                order_items int(11) NOT NULL,
                order_status varchar(20) NOT NULL,
                order_date date NOT NULL,
                status varchar(50) NOT NULL,
                max_delivery int(11) NOT NULL,
                total_delivery int(11) DEFAULT 0 NOT NULL,
                processed_email text,
                scheduled_at timestamp NOT NULL,
                is_subscribe int(4) DEFAULT 1 NOT NULL
            )";

            self::runSQL($query);
        }
    }

    /**
     * Create Process Jobs table
     *
     * @return void
     */
    public static function createProcessJobsTable()
    {
        global $wpdb;
        $reviewx_process_jobs = $wpdb->prefix . 'reviewx_process_jobs';
        if ( ! self::tableExists($reviewx_process_jobs) ) {
            $query = "CREATE TABLE $reviewx_process_jobs (
				id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                process_name varchar(20) NOT NULL,
                process_meta int(11) NOT NULL
			)";

            self::runSQL($query);
        }
    }

    /**
     * Create Criteria table
     *
     * @return void
     */
    public static function createReviewxCriteriaTable()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'reviewx_criterias';
        $reviewx_process_jobs = $wpdb->prefix . 'reviewx_process_jobs';
        if ( ! self::tableExists($table_name) ) {
            $sql = "CREATE TABLE $table_name (
				review_id int(11) NOT NULL,
				criteria_id varchar(20) NOT NULL,
				rating int(4) NOT NULL,
				is_automated int(4) NOT NULL
			)";

            self::runSQL($sql);
        }
    }

    /**
     * check table exists or not
     * @param  $table_name
     * @return query
     */
    public static function tableExists($table_name){
        global $wpdb;
        return  $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) == $table_name;
    }

    /**
     * Run Sql Here
     * @param  $sql
     */
    private static function runSQL($sql) {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql. " $charset_collate;" );
    }

    /**
     * Sync product rating 
     *
     * @return void
     */
    protected function syncProductRating()
    {
        $products = wpFluent()->table('posts')->where('post_type', 'product')->get();
        foreach ($products as $product) {
            $rating = get_option(sprintf('_rx_product_%s_rating', $product->ID));
            if (! $rating) {
                (new ProductRating())->storeOption($product);
            } else {
                (new ProductRating())->syncReviews($product);
            }
        }
    }
    
    /**
     * Check slug exists or not
     *
     * @param [type] $post_name
     * @return void
     */
    public static function theSlugExists($post_name) 
    {
        global $wpdb;
        $table = $wpdb->prefix . 'posts';
        if($wpdb->get_row("SELECT post_name FROM $table WHERE post_name = '" . $post_name . "'", 'ARRAY_A')) {
            return true;
        } else {
            return false;
        }
    }    
    
    /**
     * Create pages 
     *
     * @return void
     */    
    public static function setupPages() 
    {

        // return if pages were created before
        if( self::theSlugExists('rx-schedule-email-unsubscribe') ) {
            return;
        }

        $pages = array(
            array(
                'post_title' => __( 'ReviewX Schedule Email Unsubscribe', 'reviewx' ),
                'slug'       => 'rx-schedule-email-unsubscribe',
                'page_id'    => 'rx-schedule-email-unsubscribe',
                'content'    => '<h1>You have been unsubscribed.</h1><p>You have been unsubscribed from these emails and sorry to see you go.</p>',
                'template'   => 'rx-schedule-email-unsubscribe-template.php',
            ),
        ); 
        
        if ( $pages ) {
            foreach ( $pages as $page ) {
                $page_id = self::createPage( $page );
            }
        }    

    }

    /**
     * Create Page
     *
     * @param [type] $page
     * @return void
     */
    private static function createPage( $page ) {
        $meta_key = '_wp_page_template';
        $page_obj = get_page_by_path( $page['post_title'] );

        if ( ! $page_obj ) {
            $page_id = wp_insert_post( array(
                'post_title'     => $page['post_title'],
                'post_name'      => $page['slug'],
                'post_content'   => $page['content'],
                'post_status'    => 'publish',
                'post_type'      => 'page',
                'comment_status' => 'closed',
            ) );

            if ( $page_id && ! is_wp_error( $page_id ) ) {

                if ( isset( $page['template'] ) ) {
                    update_post_meta( $page_id, $meta_key, $page['template'] );
                }

                update_option('_rx_option_unsubscribe_url', get_permalink($page_id));

                return $page_id;
            }
        }

        return false;
    }
    
    /**
     * Check default gravatar
     *
     * @param none
     * @return void
     */    
    private static function setDefaultGravatar(){
        if( !class_exists( 'WP_User_Avatar' ) && get_option( 'avatar_default' ) == 'wp_user_avatar' ){
            update_option('avatar_default', 'mystery');
        }
    }


}
