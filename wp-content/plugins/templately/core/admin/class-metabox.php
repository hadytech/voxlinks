<?php
/**
 * Metabox Class
 * 
 * @package Templately
 */
namespace Templately\Admin;

defined( 'ABSPATH' ) or exit;

class Metabox {
    /**
     * This is invoked via the add_meta_boxes hook
     *
     * @param string $post_type
     * @param WP_Post $post
     * @return void
     */
    public static function metabox( $post_type, $post ){
        
    }
    public static function metabox_display( $post ){

    }
    public static function metabox_save( $post_id, $post ){
        if( ! current_user_can( 'edit_post' ) ) {
            return;
        }
        if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { 
            return;
        }
    }
}