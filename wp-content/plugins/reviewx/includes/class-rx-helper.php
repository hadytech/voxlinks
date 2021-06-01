<?php
/**
 * This class will provide all kind of helper methods.
 */
use ReviewX\Controllers\Admin\Core\ReviewxMetaBox;

class ReviewX_Helper {
    /**
     * This function is responsible for the data sanitization
     *
     * @param array $field
     * @param string|array $value
     * @return string|array
     */
    public static function sanitize_field( $field, $value ) 
    {
        if ( isset( $field['sanitize'] ) && ! empty( $field['sanitize'] ) ) {
            if ( function_exists( $field['sanitize'] ) ) {
                $value = call_user_func( $field['sanitize'], $value );
            }
            return $value;
        }

        switch ( $field['type'] ) {
            case 'text':
                $value = sanitize_text_field( $value );
                break;
            case 'textarea':
                $value = sanitize_textarea_field( $value );
                break;
            case 'email':
                $value = sanitize_email( $value );
                break;              
            default:
                break;
        }

        return $value;
    }
    /**
     * This function is responsible for making an array sort by their key
     * @param array $data
     * @param string $using
     * @param string $way
     * @return array
     */
    public static function sorter( $data, $using = 'time_date',  $way = 'DESC' )
    {
        if( ! is_array( $data ) ) {
            return $data;
        }
        $new_array = [];
        if( $using === 'key' ) {
            if( $way !== 'ASC' ) {
                krsort( $data );
            } else {
                ksort( $data );
            }
        } else {
            foreach( $data as $key => $value ) {
                if( ! is_array( $value ) ) continue;
                foreach( $value as $inner_key => $single ) {
                    if( $inner_key == $using ) {
                        $value[ 'tempid' ] = $key;
                        if( isset( $new_array[ $single ] ) ) {
                            $single = $single + 1;
                        }
                        $new_array[ $single ] = $value;
                    }
                }
            }

            if( $way !== 'ASC' ) {
                krsort( $new_array );
            } else {
                ksort( $new_array );
            }

            if( ! empty( $new_array ) ) {
                foreach( $new_array as $array ) {
                    $index = $array['tempid'];
                    unset( $array['tempid'] );
                    $new_data[ $index ] = $array;
                }
                $data = $new_data;
            }
        }

        return $data;
    }
    /**
     * Sorting Data 
     * by their type
     *
     * @param array $value
     * @param string $key
     * @return void
     */
    public static function sortBy( &$value, $key = 'comments' ) 
    {
        switch( $key ) {
            case 'comments' : 
                return self::sorter( $value, 'key', 'DESC' );
                break;
            default: 
                return self::sorter( $value, 'timestamp', 'DESC' );
                break;
        }
    }

    /**
     * 
     * @param none
     * @return void
     */    
    public static function is_pro() {
        return class_exists('ReviewXPro');
    }

    /**
     * get total rating counts for this product
     *
     * @param int
     * @return array
     */
    public static function get_rating_counts_for_product( $prod_id )
    {
        global $wpdb;

        $counts     = array();
        $raw_counts = $wpdb->get_results(
            $wpdb->prepare(
                "
				SELECT meta_value, COUNT( * ) as meta_value_count FROM $wpdb->commentmeta
				LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
				WHERE meta_key = 'rating'
				AND comment_post_ID = %d
				AND comment_approved = '1'
				AND meta_value > 0
				GROUP BY meta_value
					",
                $prod_id
            )
        );

        foreach ( $raw_counts as $count ) {
            $counts[ $count->meta_value ] = absint( $count->meta_value_count ); // WPCS: slow query ok.
        }

        return $counts;
    }

    /**
     * Get average rating
     *
     * @param int
     * @return array
     */
    public static function get_average_rating_for_product( $prod_id )
    {
        global $wpdb;

        if( get_post_type($prod_id) == 'product' ) {
            $product = wc_get_product( $prod_id );
            $count   = $product->get_rating_count();
    
            if ( $count ) {
                $ratings = $wpdb->get_var(
                    $wpdb->prepare(
                        "
                        SELECT SUM(meta_value) FROM $wpdb->commentmeta
                        LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
                        WHERE meta_key = 'rating'
                        AND comment_post_ID = %d
                        AND comment_approved = '1'
                        AND meta_value > 0
                            ",
                        $prod_id
                    )
                );
                $average = number_format( $ratings / $count, 2, '.', '' );
            } else {
                $average = 0;
            }
        } else {

            $count   = array_sum( self::get_rating_counts_for_product($prod_id) );
            if ( $count ) {
                $ratings = $wpdb->get_var(
                    $wpdb->prepare(
                        "
                        SELECT SUM(meta_value) FROM $wpdb->commentmeta
                        LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
                        WHERE meta_key = 'rating'
                        AND comment_post_ID = %d
                        AND comment_approved = '1'
                        AND meta_value > 0
                            ",
                        $prod_id
                    )
                );

                $average = number_format( $ratings / $count, 2, '.', '' );
            } else {
                $average = 0;
            }
        }


        return $average;
    }

	/**
	 * Get product review count for a product (not replies). Please note this is not cached.
	 *
	 * @since 3.0.0
	 * @param WC_Product $product Product instance.
	 * @return int
	 */
    public static function get_review_count_for_product( $prod_id ) 
    {
		global $wpdb;

		$count = $wpdb->get_var(
			$wpdb->prepare(
				"
			SELECT COUNT(*) FROM $wpdb->comments
			WHERE comment_parent = 0
			AND comment_post_ID = %d
			AND comment_approved = '1'
				",
				$prod_id
			)
		);

		return $count;
	}    
     /** 
     * @param none
     * @return void
     */       
    public static function is_multi_criteria( $post_type ) {

        if( self::check_post_type_availability( $post_type ) == TRUE ) {
            $reviewx_id = self::get_reviewx_post_type_id( $post_type );
            return self::get_post_meta( $reviewx_id, 'allow_multi_criteria' );
        } else {
            return self::get_option( 'allow_multi_criteria' );
        }

    }

    /**
     * 
     * @param integer
     * @return void
     */           
    public static function set_criteria_default_rating( $rating, $post_type ) 
    {
        $data 						= array();
        if( self::check_post_type_availability( $post_type ) == TRUE ) {
            $reviewx_id = self::get_reviewx_post_type_id( $post_type );
            $settings         = ReviewxMetaBox::get_metabox_settings( $reviewx_id );  
            $review_criteria 			= $settings->review_criteria; 
        } else {
            $settings 					= ReviewxMetaBox::get_option_settings();
            $review_criteria 			= $settings->review_criteria; 
        }        

        foreach( $review_criteria as $key => $value ) {
            $data[$key] =  $rating;
        }     
        return $data; 
    }

    /**
     * 
     * @param integer
     * @return void
     */
    public static function total_rating_count( $prod_id ) 
    {

        global $wpdb;
        $data = [];
        $default_rating = array(
            array(
                'rating'=>5,
                'rating_count'=>1,
                'rating_sum'=>0,
            ),
            array(
                'rating'=>4,
                'rating_count'=>1,
                'rating_sum'=>0,
            ),
            array(
                'rating'=>3,
                'rating_count'=>1,
                'rating_sum'=>0,
            ),
            array(
                'rating'=>2,
                'rating_count'=>1,
                'rating_sum'=>0,
            ),
            array(
                'rating'=>1,
                'rating_count'=>1,
                'rating_sum'=>0,
            )
        );        

        $rx_comment 	    = $wpdb->prefix . 'comments';
        $rx_commentmeta 	= $wpdb->prefix . 'commentmeta';

        $data['review_count'] = $wpdb->get_results( $wpdb->prepare(
            "SELECT
            COUNT(cm.meta_key) as total_review,
            ROUND(SUM(cm.meta_value)) as rating_sum 
            FROM $rx_comment c
            INNER JOIN $rx_commentmeta cm
            ON c.comment_ID = cm.comment_id 
            WHERE c.comment_post_ID = %d 
            AND cm.meta_key = 'rating'
            AND c.comment_approved = 1
            AND c.comment_parent = 0
            ", $prod_id
        ) );

        $data['rating_count'] = $wpdb->get_results( $wpdb->prepare(
            "SELECT
            ROUND(cm.meta_value) as rating,
            COUNT(cm.meta_value) as total_review,
            ROUND(cm.meta_value * COUNT(cm.meta_value)) as rating_sum
            FROM $rx_comment c
            INNER JOIN $rx_commentmeta cm
            ON c.comment_ID = cm.comment_id 
            WHERE c.comment_post_ID = %d 
            AND cm.meta_key = 'rating'
            AND c.comment_approved = 1
            AND c.comment_parent = 0
            GROUP BY ROUND(cm.meta_value)
            ", $prod_id
        ), ARRAY_A );

        if(count($data['rating_count']) < 5) {
            foreach( $default_rating as $key => $value ) {
                if( self::search_for_id($value['rating'], $data['rating_count']) == false) {
                    array_push($data['rating_count'], $value); 
                }
            }
        }

        $data['rating_count'] = self::sort_array( $data['rating_count'], 'rating' );

        return $data;

    }

    /**
     * 
     * @param integer, array
     * @return void
     */    
    public static function search_for_id($id, $data) {
        foreach ($data as $key => $val) {   
            if ($val['rating'] == $id) { 
                return true;
            }
        }
        return false;
    }

    /**
     * 
     * @param array, string
     * @return void
     */    
    public static function sort_array( $data, $field ) {
        $field = (array) $field;
        uasort( $data, function($a, $b) use($field) {
            $retval = 0;
            foreach( $field as $fieldname ) {
                if( $retval == 0 ) $retval = strnatcmp( $a[$fieldname], $b[$fieldname] );
            }
            return $retval;
        } );
        return $data;
    }
    
    /**
     * 
     * @param integer, integer
     * @return void
     */    
    public static function get_percentage($total, $number) {
        if ( $total > 0 ) {
        return round($number / ($total / 100),2);
        } else {
            return 0;
        }
    }

    /**
     * @param $prod_id
     * @param $user_id
     * @param $order_id
     * @return bool
     */
    public static function check_already_reviewed( $prod_id, $user_id = null, $order_id )
    {
        if ( isset($prod_id) && isset($user_id) ) {
            global $wpdb;

            $rx_comment 	    = $wpdb->prefix . 'comments';
            $rx_commentmeta 	= $wpdb->prefix . 'commentmeta';

            if (filter_var($user_id, FILTER_VALIDATE_EMAIL)) {
                $data = $wpdb->get_results( $wpdb->prepare(
                    "SELECT DISTINCT $rx_commentmeta.meta_value FROM $rx_commentmeta 
                            INNER JOIN $rx_comment 
                            ON $rx_commentmeta.comment_id = $rx_comment.comment_ID 
                            WHERE $rx_commentmeta.meta_key = 'reviewx_order' 
                            AND $rx_commentmeta.meta_value = %d 
                            AND $rx_comment.comment_post_ID = %d 
                            AND $rx_comment.comment_author_email = %s",
                    $order_id, $prod_id, $user_id
                ) );
            } else {
                $data = $wpdb->get_results( $wpdb->prepare(
                    "SELECT DISTINCT $rx_commentmeta.meta_value FROM $rx_commentmeta 
                            INNER JOIN $rx_comment 
                            ON $rx_commentmeta.comment_id = $rx_comment.comment_ID 
                            WHERE $rx_commentmeta.meta_key = 'reviewx_order' 
                            AND $rx_commentmeta.meta_value = %d 
                            AND $rx_comment.comment_post_ID = %d 
                            AND $rx_comment.user_id = %d",
                    $order_id, $prod_id, $user_id
                ) );
            }

            if( $data && !empty(current($data)->meta_value) ){
                return true;
            }
        }

        return false;
    }

    /**
     * @param $order_id
     * @param $prod_id
     * @param $user_id
     * @return int
     */
    public static function retrieve_review_id( $order_id, $prod_id, $user_id )
    {
        if ( isset($order_id) && isset($prod_id) && isset($user_id) ) {
            global $wpdb;
            $rx_comment 	    = $wpdb->prefix . 'comments';
            $rx_commentmeta 	= $wpdb->prefix . 'commentmeta';

            $data = $wpdb->get_results( $wpdb->prepare(
                "SELECT DISTINCT $rx_commentmeta.comment_id FROM $rx_commentmeta 
                        INNER JOIN $rx_comment 
                        ON $rx_commentmeta.comment_id = $rx_comment.comment_ID 
                        WHERE $rx_commentmeta.meta_key = 'reviewx_order' 
                        AND $rx_commentmeta.meta_value = %d 
                        AND $rx_comment.comment_post_ID = %d 
                        AND $rx_comment.user_id = %d",
                $order_id, $prod_id, $user_id
            ) );
            if( $data && !empty($data[0]->comment_id) ) {
                return $data[0]->comment_id;
            }
        }
        return 0;
    }
    
    /**
     * Grab all custom post types
     * 
     * @param none
     * @return array
     */    
    public static function get_custom_post_types() 
    {
        global $wp_post_types;
        $pre_data = $data = [];
        $data[] = __('Select', 'reviewx');
        foreach( $wp_post_types as $key => $pt ) {
            $pre_data[$key] = $pt->label;
        }
        // Remove _builtins or others
        $pt_remove = array(
                            'attachment',
                            'nav_menu_item',
                            'customize_changeset',
                            'revision',
                            'reviewx', 
                            'custom_css', 
                            'oembed_cache', 
                            'user_request',
                            'wp_block',
                            'product',
                            'product_variation',
                            'shop_order',
                            'shop_order_refund',
                            'shop_coupon',
                            'page'
                        );
        
        foreach ( $pre_data as $key => $posttype ):
         if ( in_array($key, $pt_remove) ) continue;
         $data[ $key ] = $posttype;;
        endforeach;   
        return $data;     
    }

    /**
     * Grab save custom post types
     * 
     * @param none
     * @return array
     */     
    public static function get_enabled_types() 
    {
        
        $data = [];
        // WP Query arguments.
		$args = array(
			'post_type'      => 'reviewx',
			'posts_per_page' => '-1',
			'post_status'    => 'publish',
			'meta_key'       => '_rx_meta_active_check',
            'meta_value'     => 1,
            'orderby'        => 'ID',
            'order'          => 'DESC'            
        );
        
		// Get the reviewx posts.
		$posts = get_posts( $args );
		if ( count( $posts ) ) {
			foreach ( $posts as $post ) {
                $post_type = get_post_meta( $post->ID, '_rx_meta_custom_post_types', true ); 
                if( self::get_exist_data( $data, $post_type ) == true ) {
                    $data[ $post->ID ] = $post_type;
                }				
			}
		}
		return $data;
    }
    
    public static function get_exist_data( $data, $post_type ) 
    {

        foreach( $data as $d ){
            if( $d == $post_type ) {
                return false; 
            }
        }

        return true;
    }

    /**
     * Get save post meta
     * 
     * @param none
     * @return array/string
     */    
    public static function get_post_meta( $post_id, $key, $single = true ) 
    {
		return get_post_meta( $post_id, '_rx_meta_' . $key, $single );
    }
    
    /**
     * Get saved option
     * 
     * @param none
     * @return array/string
     */     
    public static function get_option( $key ) 
    {
		return get_option( '_rx_option_' . $key );
    }

    /**
     * Check post type availability
     * 
     * @param none
     * @return boolean
     */ 
    public static function check_post_type_availability( $post_type )
    {
        $post_types = self::get_enabled_types();
        if( in_array($post_type, $post_types) ){
            return TRUE; 
        }
        return FALSE;
    }

    /**
     * Retrieve reviewx id
     * 
     * @param string
     * @return integer
     */    
    public static function get_reviewx_post_type_id( $post_type )
    {
        $post_types = self::get_enabled_types();
        return array_search ($post_type, $post_types);
    }

    public static function set_google_schema( $post_id = null ) {
        
    }

    /**
     * Retrieve google schema
     * 
     * @param string
     * @return void
     */    
    public static function get_gravatar( $comment, $post_type ) 
    {
        if( self::check_post_type_availability( $post_type ) == TRUE ) {        
            echo get_avatar( $comment->comment_author_email, 70 );  
        } else if( $post_type == 'product' ) { 
            echo get_avatar( $comment, apply_filters( 'woocommerce_review_gravatar_size', '70' ), '' );  
        }
    }

    /**
     * Check WC is enabled/activated
     * 
     * @param string
     * @return void
     */
    public static function check_wc_is_enabled() 
    {
        $enabled = true;
        $wc_is_enabled = get_option( '_rx_wc_active_check' );
        if( $wc_is_enabled == 1 ) {
            $enabled = true;
        } else if( \ReviewX\Controllers\Admin\Core\ReviewxMetaBox::rx_exists_option( '_rx_wc_active_check' ) == false ) {
            $enabled = true;
        } else {
            $enabled = false;
        }
        return $enabled;
    }

    /**
     * Check verified purchase
     * 
     * @param integer
     * @return void
     */    
    public static function wc_review_is_from_verified_owner ( $comment_id, $post_id = null) 
    {
        $verified = false;
        if( class_exists( 'WooCommerce' ) && get_post_type( $post_id ) == 'product' ) {
            $get_order_meta = get_comment_meta( $comment_id, 'reviewx_order', true );            
            if( wc_review_is_from_verified_owner( $comment_id ) || ! empty($get_order_meta) ) {
                $verified = true;
            }
        } else if( class_exists( 'Easy_Digital_Downloads' ) && get_post_type( $post_id ) == 'download' ){
            $get_order_meta = get_comment_meta( $comment_id, 'reviewx_order', true );            
            if( ! empty($get_order_meta) ) {
                $verified = true;
            }
        }
        return $verified;
    }

    /**
     * Get review count
     * 
     * @param integer
     * @return void
     */    
    public static function get_total_review( $product_id = 0, $post_type, $keyword, $rating, $user_id = null ) 
    {        
        $total_review = 0;

        switch ( $keyword ) {
            case "photo":
                if( ! empty( $rating ) ) {
                    $args = array(
                        'post_type'         => $post_type,
                        'orderby'           => 'date',
                        'post_id'           => $product_id,
                        'status'            => 'approve', 
                        'parent'=> '0',  
                        'meta_query'        => array(
                            array(
                                'relation' => 'AND',
                                array(
                                    'key'       => 'reviewx_attachments',
                                    'value'     => array( '', array(), serialize( array() ) ),
                                    'compare'   => 'NOT IN'
                                ),
                                array(
                                    'key'       => 'rating',
                                    'value'     => $rating,
                                    'compare'   => '='
                                ),                             
                            )
                        ),
                    ); 

                    if ( isset($user_id) ) {
                        $args['include_unapproved'] = array( $user_id );
                    } else {
                        $unapproved_email = wp_get_unapproved_comment_author_email();
    
                        if ( $unapproved_email ) {
                            $args['include_unapproved'] = array( $unapproved_email );
                        }
                    }

                } else {
                    $args = array(
                        'post_type'         => $post_type,
                        'orderby'           => 'date',
                        'post_id'           => $product_id,
                        'status'            => 'approve',
                        'parent'=> '0',  
                        'meta_query'        => array(
                            array(
                                'key'       => 'reviewx_attachments',
                                'value'     => array( '', array(), serialize( array() ) ),
                                'compare'   => 'NOT IN'
                            )
                        ),
                    );

                    if ( isset($user_id) ) {
                        $args['include_unapproved'] = array( $user_id );
                    } else {
                        $unapproved_email = wp_get_unapproved_comment_author_email();
    
                        if ( $unapproved_email ) {
                            $args['include_unapproved'] = array( $unapproved_email );
                        }
                    }

                }               

                $reviews        = get_comments( $args );
                $total_review   = count($reviews);   
    
            break;
            
            case "video":
                if( ! empty( $rating ) ) {
                    $args = array(
                        'post_type'         => $post_type,
                        'post_id'           => $product_id,
                        'orderby'           => 'date',
                        'status'            => 'approve', 
                        'parent'=> '0',  
                        'meta_query'        => array(
                            array(
                                'relation' => 'AND',
                                array(
                                    'key'   => 'reviewx_video_url',
                                    'value' => '',
                                    'compare' => 'NOT IN'
                                ),
                                array(
                                    'key'       => 'rating',
                                    'value'     => $rating,
                                    'compare'   => '='
                                ),                             
                            )
                        ),
                    );

                    if ( isset($user_id) ) {
                        $args['include_unapproved'] = array( $user_id );
                    } else {
                        $unapproved_email = wp_get_unapproved_comment_author_email();
    
                        if ( $unapproved_email ) {
                            $args['include_unapproved'] = array( $unapproved_email );
                        }
                    }

                } else {
                    $args = array(
                        'post_type'         => $post_type,
                        'post_id'           => $product_id,
                        'orderby'           => 'date',
                        'status'            => 'approve', 
                        'parent'=> '0',  
                        'meta_query' => array(
                            array(
                                'key' => 'reviewx_video_url',
                                'value' => '',
                                'compare' => 'NOT IN'
                            )
                        ),
                    );

                    if ( isset($user_id) ) {
                        $args['include_unapproved'] = array( $user_id );
                    } else {
                        $unapproved_email = wp_get_unapproved_comment_author_email();
    
                        if ( $unapproved_email ) {
                            $args['include_unapproved'] = array( $unapproved_email );
                        }
                    }                    
                }

                $reviews        = get_comments( $args );
                $total_review   = count($reviews);   
    
            break;
    
            case "text":
                if( class_exists('ReviewXPro') ) {
                    
                    if( ! empty( $rating ) ) {
                        $args = array(
                            'post_type' => $post_type,
                            'post_id'           => $product_id,
                            'orderby'   => 'date',
                            'status'            => 'approve',
                            'parent'=> '0',   
                            'meta_query'        => array(
                                array(
                                     'relation' => 'AND',
                                     array( 
                                         'relation' => 'OR',
                                         array(
                                             'relation' => 'AND',
                                             array(
                                                 'key'   => 'reviewx_attachments',
                                                 'compare' => 'NOT EXISTS'
                                             ),
                                             array(
                                                 'key'   => 'reviewx_video_url',
                                                 'compare' => 'NOT EXISTS'
                                             ), 
                                         ),
                                         array(
                                             'relation' => 'AND',
                                             array(
                                                 'key'   => 'reviewx_attachments',
                                                 'value' => ' ',
                                                 'compare' => '='
                                             ),
                                             array(
                                                 'key'   => 'reviewx_video_url',
                                                 'value' => ' ',
                                                 'compare' => '='
                                             ), 
                                         ), 
                                         array(
                                             'relation' => 'AND',
                                             array(
                                                 'key'   => 'reviewx_attachments',
                                                 'compare' => 'NOT EXISTS'
                                             ),
                                             array(
                                                'key'   => 'reviewx_video_url',
                                                'value' => ' ',
                                                'compare' => '='
                                            ), 
                                         ),
                                         array(
                                             'relation' => 'AND',
                                             array(
                                                'key'   => 'reviewx_attachments',
                                                'value' => ' ',
                                                'compare' => '='
                                             ),
                                             array(
                                                'key'   => 'reviewx_video_url',
                                                'compare' => 'NOT EXISTS'
                                            ), 
                                        ),  
                                     ),                                                                                                                               
                                     array(
                                        'key'       => 'rating',
                                        'value'     => $rating,
                                        'compare'   => '='
                                    ),                                    
                                ),
                            ),                
                        );

                        if ( isset($user_id) ) {
                            $args['include_unapproved'] = array( $user_id );
                        } else {
                            $unapproved_email = wp_get_unapproved_comment_author_email();
        
                            if ( $unapproved_email ) {
                                $args['include_unapproved'] = array( $unapproved_email );
                            }
                        }  
                        
                    } else {

                        $args = array(
                            'post_type' => $post_type,
                            'post_id'           => $product_id,
                            'orderby'   => 'date',
                            'status'            => 'approve', 
                            'parent'=> '0',  
                            'meta_query'  => array(
                                array(
                                    'relation' => 'AND',
                                    array(
                                        'key'   => 'reviewx_attachments',
                                        'compare' => 'NOT EXISTS'
                                    ),
                                    array(
                                        'key'   => 'reviewx_video_url',
                                        'compare' => 'NOT EXISTS'
                                    ),
                                ),
                            ),                
                        ); 
                        
                        if ( isset($user_id) ) {
                            $args['include_unapproved'] = array( $user_id );
                        } else {
                            $unapproved_email = wp_get_unapproved_comment_author_email();
        
                            if ( $unapproved_email ) {
                                $args['include_unapproved'] = array( $unapproved_email );
                            }
                        }                         

                    } 
                                       
                } else {
                    if( ! empty( $rating ) ) {
                        $args = array(
                            'post_type' => $post_type,
                            'post_id'   => $product_id,
                            'orderby'   => 'date',
                            'status'    => 'approve', 
                            'parent'=> '0',  
                            'meta_query' => array(
                                array(
                                    'relation' => 'AND',
                                    array(
                                        'key'     => 'reviewx_attachments',
                                        'compare' => 'NOT EXISTS'
                                    ),
                                    array(
                                        'key'       => 'rating',
                                        'value'     => $rating,
                                        'compare'   => '='
                                    ), 
                                ),
                            ),
                        );

                        if( ! class_exists('ReviewXPro') ) {
                            $args['parent'] = 0;  
                        }

                        if ( isset($user_id) ) {
                            $args['include_unapproved'] = array( $user_id );
                        } else {
                            $unapproved_email = wp_get_unapproved_comment_author_email();
        
                            if ( $unapproved_email ) {
                                $args['include_unapproved'] = array( $unapproved_email );
                            }
                        }                                                 

                    } else {
                        $args = array(
                            'post_type' => $post_type,
                            'post_id'           => $product_id,
                            'orderby'   => 'date',
                            'status'            => 'approve', 
                            'parent'=> '0',  
                            'meta_query' => array(
                                array(
                                    'key'   => 'reviewx_attachments',
                                    'compare' => 'NOT EXISTS'
                                ),
                            ),
                        ); 
                        
                        if ( isset($user_id) ) {
                            $args['include_unapproved'] = array( $user_id );
                        } else {
                            $unapproved_email = wp_get_unapproved_comment_author_email();
        
                            if ( $unapproved_email ) {
                                $args['include_unapproved'] = array( $unapproved_email );
                            }
                        }                        

                    }
                }
                
                $reviews        = get_comments( $args );
                $total_review   = count($reviews);   
                
            break;
    
            case "rating":

                $args = array(
                    'post_type'         => $post_type,
                    'post_id'           => $product_id,
                    'status'            => 'approve', 
                    'parent'=> '0',  
                    'meta_query'        => array(
                        'meta_value'    => array(
                            'key'       => 'rating',
                            'value'     => 5,
                            'compare'   => '<='
                        ),
                    ),
                    'orderby'           => array(
                        'meta_value'    => 'DESC'
                    ),
                );

                if ( isset($user_id) ) {
                    $args['include_unapproved'] = array( $user_id );
                } else {
                    $unapproved_email = wp_get_unapproved_comment_author_email();

                    if ( $unapproved_email ) {
                        $args['include_unapproved'] = array( $unapproved_email );
                    }
                }                

                if( ! class_exists('ReviewXPro') ) {
                    $args['parent'] = 0;  
                }

                $reviews        = get_comments( $args );
                $total_review   = count($reviews);   

            break;

            case "low":

                $args = array(
                    'post_type'         => $post_type,
                    'post_id'           => $product_id,
                    'status'            => 'approve', 
                    'parent'=> '0',  
                    'meta_query'        => array(
                        'meta_value'    => array(
                            'key'       => 'rating',
                            'value'     => 5,
                            'compare'   => '<='
                        ),
                    ),
                    'orderby'           => array(
                        'meta_value'    => 'ASC'
                    ),
                );

                if ( isset($user_id) ) {
                    $args['include_unapproved'] = array( $user_id );
                } else {
                    $unapproved_email = wp_get_unapproved_comment_author_email();

                    if ( $unapproved_email ) {
                        $args['include_unapproved'] = array( $unapproved_email );
                    }
                }                

                if( ! class_exists('ReviewXPro') ) {
                    $args['parent'] = 0;  
                }

                $reviews        = get_comments( $args );
                $total_review   = count($reviews);   

            break;            
    
            default:
                if( ! empty( $rating ) ) {
                    $args = array(
                        'post_type'         => $post_type,
                        'post_id'           => $product_id,
                        'orderby'           => 'date',
                        'tag'               => 'recent',
                        'status'            => 'approve', 
                        'parent'=> '0',
                        'meta_query'        => array(
                            'meta_value'    => array(
                                'key'       => 'rating',
                                'value'     => $rating,
                                'compare'   => '='
                            ),
                        ),                        
                    );

                    if ( isset($user_id) ) {
                        $args['include_unapproved'] = array( $user_id );
                    } else {
                        $unapproved_email = wp_get_unapproved_comment_author_email();
    
                        if ( $unapproved_email ) {
                            $args['include_unapproved'] = array( $unapproved_email );
                        }
                    }                    
                } else {
                    $args = array(
                        'post_type'         => $post_type,
                        'post_id'           => $product_id,
                        'orderby'           => 'date',
                        'tag'               => 'recent',
                        'status'            => 'approve', 
                        'parent'=> '0',  
                    );

                    if ( isset($user_id) ) {
                        $args['include_unapproved'] = array( $user_id );
                    } else {
                        $unapproved_email = wp_get_unapproved_comment_author_email();
    
                        if ( $unapproved_email ) {
                            $args['include_unapproved'] = array( $unapproved_email );
                        }
                    }                                         
                }
                
                $reviews        = get_comments( $args );
                $total_review   = count($reviews);           
            break;
        }

        return $total_review;
    }
    
    /**
     * Shortcode query args
     *
     * @param array
     * @return void
     **/    
    public static function reviewx_shortcode_query_args( $reviewx_shortcode )
    {

        $args       = array();
        $per_page   = isset( $reviewx_shortcode['rx_per_page'] ) ? $reviewx_shortcode['rx_per_page'] :  get_option( '_rx_option_review_per_page' );
        $post_type  = isset( $reviewx_shortcode['rx_post_type'] ) ? $reviewx_shortcode['rx_post_type'] :  'product';
        $rx_sort_by = isset( $reviewx_shortcode['rx_sort_by'] ) ? $reviewx_shortcode['rx_sort_by'] :  '';

        switch ( $rx_sort_by ) {
            case "photo":
                if( !empty($reviewx_shortcode['rx_rating']) ) {
                    $args = array(
                        'post_type'         => $post_type,
                        'orderby'           => 'date',
                        'order'             => $reviewx_shortcode['rx_order'],
                        'post_id'           => $reviewx_shortcode['rx_product_id'],
                        'meta_query'        => array(
                                array(
                                    'relation' => 'AND',
                                    array(
                                        'key'       => 'reviewx_attachments',
                                        'value'     => array( '', array(), serialize( array() ) ),
                                        'compare'   => 'NOT IN'
                                    ),
                                    array(
                                        'key'       => 'rating',
                                        'value'     => $reviewx_shortcode['rx_rating'],
                                        'compare'   => '='
                                    ),                                                                          
                                )
                            ),
                        'tag' => 'photo',
                        'parent'=> '0'                      
                    );

                    // If pagination ON and Blank, display all
                    if( $reviewx_shortcode['rx_pagination'] == 'on' || $reviewx_shortcode['rx_pagination'] == '' ) {
                        $args['number'] = $per_page;
                        $args['offset'] = 0;
                        $args['paged'] = 1;  
                    }

                    // Display only desire review count
                    if( isset( $reviewx_shortcode['rx_review_count'] ) ) {
                        $args['number'] = $reviewx_shortcode['rx_review_count'];
                    }  

                } else {
                    $args = array(
                        'post_type'         => $post_type,
                        'orderby'           => 'date',
                        'order'             => $reviewx_shortcode['rx_order'],
                        'post_id'           => $reviewx_shortcode['rx_product_id'],
                        'meta_query'        => array(
                                array(
                                    'key'       => 'reviewx_attachments',
                                    'value'     => array( '', array(), serialize( array() ) ),
                                    'compare'   => 'NOT IN'
                                )
                            ),
                        'tag' => 'photo', 
                        'parent'=> '0'                        
                    );

                    // If pagination ON and Blank, display all
                    if( $reviewx_shortcode['rx_pagination'] == 'on' || $reviewx_shortcode['rx_pagination'] == '' ) {
                        $args['number'] = $per_page;
                        $args['offset'] = 0;
                        $args['paged'] = 1;  
                    }

                    // Display only desire review count
                    if( isset( $reviewx_shortcode['rx_review_count'] ) ) {
                        $args['number'] = $reviewx_shortcode['rx_review_count'];
                    }                      

                }    
            break;
            
            case "video":

                if( !empty($reviewx_shortcode['rx_rating']) ) {
                    $args = array(
                        'post_type'         => $post_type,
                        'orderby'           => 'date',
                        'order'             => $reviewx_shortcode['rx_order'],
                        'post_id'           => $reviewx_shortcode['rx_product_id'],
                        'meta_query' => array(
                            array(
                                'relation' => 'AND',
                                array(
                                    'key' => 'reviewx_video_url',
                                    'value' => '',
                                    'compare' => 'NOT IN'
                                ),
                                array(
                                    'key'       => 'rating',
                                    'value'     => $reviewx_shortcode['rx_rating'],
                                    'compare'   => '='
                                ),  
                            )
                        ),
                        'tag' => 'video', 
                        'parent'=> '0'                       
                    ); 
                    
                    // If pagination ON and Blank, display all
                    if( $reviewx_shortcode['rx_pagination'] == 'on' || $reviewx_shortcode['rx_pagination'] == '' ) {
                        $args['number'] = $per_page;
                        $args['offset'] = 0;
                        $args['paged'] = 1;  
                    }

                    // Display only desire review count
                    if( isset( $reviewx_shortcode['rx_review_count'] ) ) {
                        $args['number'] = $reviewx_shortcode['rx_review_count'];
                    }                     
                    
                    if( ! class_exists('ReviewXPro') ) {
                        $args['parent'] = 0;  
                    }                  
                } else {
                    $args = array(
                        'post_type'         => $post_type,
                        'orderby'           => 'date',
                        'order'             => $reviewx_shortcode['rx_order'],
                        'post_id'           => $reviewx_shortcode['rx_product_id'],
                        'meta_query' => array(
                            array(
                                'key' => 'reviewx_video_url',
                                'value' => '',
                                'compare' => 'NOT IN'
                            )
                        ),
                        'tag' => 'video',   
                        'parent'=> '0'                     
                    );

                }
    
            break;
    
            case "text":
                if( class_exists('ReviewXPro') ) {

                    if( !empty($reviewx_shortcode['rx_rating']) ) {
                        $args = array(
                            'post_type'         => $post_type,
                            'orderby'           => 'date',
                            'order'             => $reviewx_shortcode['rx_order'],
                            'post_id'           => $reviewx_shortcode['rx_product_id'],
                            'meta_query'        => array(
                                array(
                                    'relation' => 'AND',
                                    array(
                                        'relation' => 'AND',
                                        array(
                                            'key'   => 'reviewx_attachments',
                                            'compare' => 'NOT EXISTS'
                                        ),
                                        array(
                                            'key'   => 'reviewx_video_url',
                                            'compare' => 'NOT EXISTS'
                                        ), 
                                    ),
                                    array(
                                        'key'       => 'rating',
                                        'value'     => $reviewx_shortcode['rx_rating'],
                                        'compare'   => '='
                                    ),                                    
                                ),
                            ),                   
                            'tag' => 'text',  
                            'parent'=> '0'                            
                        );

                        // If pagination ON and Blank, display all
                        if( $reviewx_shortcode['rx_pagination'] == 'on' || $reviewx_shortcode['rx_pagination'] == '' ) {
                            $args['number'] = $per_page;
                            $args['offset'] = 0;
                            $args['paged'] = 1;  
                        }

                        // Display only desire review count
                        if( isset( $reviewx_shortcode['rx_review_count'] ) ) {
                            $args['number'] = $reviewx_shortcode['rx_review_count'];
                        }                        

                    } else {
                        $args = array(
                            'post_type'         => $post_type,
                            'orderby'           => 'date',
                            'order'             => $reviewx_shortcode['rx_order'],
                            'post_id'           => $reviewx_shortcode['rx_product_id'],
                            'meta_query'        => array(
                                array(
                                    'relation' => 'AND',
                                    array(
                                        'key'   => 'reviewx_attachments',
                                        'compare' => 'NOT EXISTS'
                                    ),
                                    array(
                                        'key'   => 'reviewx_video_url',
                                        'compare' => 'NOT EXISTS'
                                    ),
                                ),
                            ),                   
                            'tag' => 'text',
                            'parent'=> '0'
                        );

                        // If pagination ON and Blank, display all
                        if( $reviewx_shortcode['rx_pagination'] == 'on' || $reviewx_shortcode['rx_pagination'] == '' ) {
                            $args['number'] = $per_page;
                            $args['offset'] = 0;
                            $args['paged'] = 1;  
                        }

                        // Display only desire review count
                        if( isset( $reviewx_shortcode['rx_review_count'] ) ) {
                            $args['number'] = $reviewx_shortcode['rx_review_count'];
                        }

                    }

                } else {
                    if( !empty($reviewx_shortcode['rx_rating']) ) {
                        $args = array(
                            'post_type'         => $post_type,
                            'orderby'           => 'date',
                            'order'             => $reviewx_shortcode['rx_order'],
                            'post_id'           => $reviewx_shortcode['rx_product_id'],
                            'meta_query' => array(
                                array(
                                    'relation' => 'AND',
                                    array(
                                        'key'   => 'reviewx_attachments',
                                        'compare' => 'NOT EXISTS'
                                    ),
                                    array(
                                        'key'       => 'rating',
                                        'value'     => $reviewx_shortcode['rx_rating'],
                                        'compare'   => '='
                                    ),
                                )                                
                            ),
                            'tag' => 'text',
                            'parent'=> '0'  
                        ); 

                        // If pagination ON and Blank, display all
                        if( $reviewx_shortcode['rx_pagination'] == 'on' || $reviewx_shortcode['rx_pagination'] == '' ) {
                            $args['number'] = $per_page;
                            $args['offset'] = 0;
                            $args['paged'] = 1;  
                        }

                        // Display only desire review count
                        if( isset( $reviewx_shortcode['rx_review_count'] ) ) {
                            $args['number'] = $reviewx_shortcode['rx_review_count'];
                        }                        
                        
                    } else {
                        $args = array(
                            'post_type'         => $post_type,
                            'orderby'           => 'date',
                            'order'             => $reviewx_shortcode['rx_order'],
                            'post_id'           => $reviewx_shortcode['rx_product_id'],
                            'meta_query' => array(
                                array(
                                    'key'   => 'reviewx_attachments',
                                    'compare' => 'NOT EXISTS'
                                ),
                            ),
                            'tag' => 'text',
                            'parent'=> '0'  
                        ); 

                        // If pagination ON and Blank, display all
                        if( $reviewx_shortcode['rx_pagination'] == 'on' || $reviewx_shortcode['rx_pagination'] == '' ) {
                            $args['number'] = $per_page;
                            $args['offset'] = 0;
                            $args['paged'] = 1;  
                        }

                        // Display only desire review count
                        if( isset( $reviewx_shortcode['rx_review_count'] ) ) {
                            $args['number'] = $reviewx_shortcode['rx_review_count'];
                        }
                                               
                    }                      
                }
                
            break;
    
            case "top":
                $args = array(
                    'post_type'         => $post_type,                    
                    'post_id'           => $reviewx_shortcode['rx_product_id'],
                    'meta_query'        => array(
                        'meta_value'    => array(
                            'key'       => 'rating',
                            'value'     => 5,
                            'compare'   => '<='
                        ),
                    ),
                    'orderby'           => array(
                        'meta_value'    => $reviewx_shortcode['rx_order']
                    ),
                    'tag' => 'rating',
                    'parent'=> '0'  
                ); 

                // If pagination ON and Blank, display all
                if( $reviewx_shortcode['rx_pagination'] == 'on' || $reviewx_shortcode['rx_pagination'] == '' ) {
                    $args['number'] = $per_page;
                    $args['offset'] = 0;
                    $args['paged'] = 1;  
                }

                // Display only desire review count
                if( isset( $reviewx_shortcode['rx_review_count'] ) ) {
                    $args['number'] = $reviewx_shortcode['rx_review_count'];
                }                          

            break;

            case "low":
                $args = array(
                    'post_type'         => $post_type,                    
                    'post_id'           => $reviewx_shortcode['rx_product_id'],
                    'meta_query'        => array(
                        'meta_value'    => array(
                            'key'       => 'rating',
                            'value'     => 5,
                            'compare'   => '<='
                        ),
                    ),
                    'orderby'           => array(
                        'meta_value'    => 'ASC'
                    ),
                    'tag' => 'rating',
                    'parent'=> '0'  
                ); 

                // If pagination ON and Blank, display all
                if( $reviewx_shortcode['rx_pagination'] == 'on' || $reviewx_shortcode['rx_pagination'] == '' ) {
                    $args['number'] = $per_page;
                    $args['offset'] = 0;
                    $args['paged'] = 1;  
                }

                // Display only desire review count
                if( isset( $reviewx_shortcode['rx_review_count'] ) ) {
                    $args['number'] = $reviewx_shortcode['rx_review_count'];
                }                          

            break;            
    
            default:
                if( !empty($reviewx_shortcode['rx_rating']) ) {
                    $args = array(
                        'post_type'         => $post_type,
                        'orderby'           => 'date',
                        'order'             => $reviewx_shortcode['rx_order'],
                        'post_id'           => $reviewx_shortcode['rx_product_id'],
                        'tag'               => 'recent',
                        'meta_query'        => array(
                            'meta_value'    => array(
                                'key'       => 'rating',
                                'value'     => $reviewx_shortcode['rx_rating'],
                                'compare'   => '='
                            ),
                        ),
                        'parent'=> '0'                         
                    );
                    
                    // If pagination ON and Blank, display all
                    if( $reviewx_shortcode['rx_pagination'] == 'on' || $reviewx_shortcode['rx_pagination'] == '' ) {
                        $args['number'] = $per_page;
                        $args['offset'] = 0;
                        $args['paged'] = 1;  
                    }

                    // Display only desire review count
                    if( isset( $reviewx_shortcode['rx_review_count'] ) ) {
                        $args['number'] = $reviewx_shortcode['rx_review_count'];
                    }                    

                } else {
                    $args = array(
                        'post_type'         => $post_type,
                        'orderby'           => 'date',
                        'order'             => isset($reviewx_shortcode['rx_order'])?$reviewx_shortcode['rx_order']:'',
                        'post_id'           => $reviewx_shortcode['rx_product_id'],
                        'tag'               => 'recent',
                        'parent'=> '0'                        
                    );
                    
                    // If pagination ON and Blank, display all
                    if( ( isset($reviewx_shortcode['rx_pagination']) ? $reviewx_shortcode['rx_pagination'] : '' == 'on' ) || (isset($reviewx_shortcode['rx_pagination']) ? $reviewx_shortcode['rx_pagination'] : '') == '' ) {
                        $args['number'] = $per_page;
                        $args['offset'] = 0;
                        $args['paged'] = 1;  
                    }

                    // Display only desire review count
                    if( isset( $reviewx_shortcode['rx_review_count'] ) ) {
                        $args['number'] = $reviewx_shortcode['rx_review_count'];
                    }
                                        
                }  
            break;
        }

        return $args;
    }

    /**
     * Check verified badge for non logged user
     *
     * @param string int
     * @return boolean
     **/     
    public static function check_guest_purchase_verified_badge( $email, $prod_id ) {
        
        if ( 'product' === get_post_type( $prod_id ) ) {
            $settings               = (array) ReviewxMetaBox::get_option_settings();
            $reviewx_order_status   = array();
            $wc_order_statuses      = apply_filters( 'rx_wc_order_status', true );
            foreach( $wc_order_statuses as $key => $value ) {
                if( array_key_exists($key, $settings) && $settings[$key] == 1 ){                    
                    array_push($reviewx_order_status, $key);
                }                
            } 

            $customer_orders 	= wc_get_orders( array(
                'meta_key' 		=> '_billing_email',
                'meta_value' 	=> $email,
                'post_status' 	=> $reviewx_order_status,
                'numberposts' 	=> -1
            ) );
            $data = $results = [];        
            $i = 0;
            foreach( $customer_orders as $order ) {
                foreach( $order->get_items() as $item_id => $item ) {
                    $product_id = method_exists( $item, 'get_product_id' ) ? $item->get_product_id() : $item['product_id'];
                    if( $product_id == $prod_id ) {
                        $order_id 	= method_exists( $order, 'get_id' ) ? $order->get_id() : $order->ID;
                        $data[$i]   = $order->ID;
                        $order 		= wc_get_order( $order_id );
                        $get_status = $order->get_status();
                        if( in_array($get_status, $reviewx_order_status) ) {
                            $data[$i]   = $order->ID;
                            global $wpdb;
                            $rx_comment 	    = $wpdb->prefix . 'comments';
                            $rx_commentmeta 	= $wpdb->prefix . 'commentmeta';                    
                            $results = $wpdb->get_results( $wpdb->prepare(
                                "SELECT COUNT($rx_commentmeta.meta_value) as total FROM $rx_commentmeta 
                                    INNER JOIN $rx_comment
                                    ON $rx_commentmeta.comment_id = $rx_comment.comment_ID       
                                    WHERE $rx_commentmeta.meta_key = 'verified'
                                        AND $rx_commentmeta.meta_value = %d 
                                        AND $rx_comment.comment_post_ID = %d 
                                        AND $rx_comment.comment_author_email = %s",
                                1, $prod_id, $email
                            ) );                    
                        }
                    }
                }
                $i++;
            } 
            
            if(count($data) == false){
                return false;
            }
            
            if( $results && !empty(current($results)->total) ) {
                if( current($results)->total > count($data) ) {
                    return false;
                }
            }
            return true;
        }        
    }    
    
    /**
     * Check Divi installed
     *  
     * @param array
     * @return void
     */
    public static function reviewx_check_divi_active() {
        if( get_option('template') == 'Divi' ) {
            return true;
        }
        return false;
    }

    /**
     * Check shortcode and divi review list
     *  
     * @param array
     * @return void
     */
    public static function shortcode_divi_review_list($post_id, $reviewx_shortcode) {

        $divi_settings = get_post_meta( $post_id, '_rx_option_divi_settings', true );
        if( self::reviewx_check_divi_active() && $divi_settings['rvx_review_list'] != 'off'  ) {
            return true;
        } else if( isset($reviewx_shortcode) && $reviewx_shortcode['rx_list'] =='on' ) {
            return true;
        } else {
            if( ( !isset($reviewx_shortcode) || empty($reviewx_shortcode['rx_product_id']) ) && !self::reviewx_check_divi_active() ) {          
                return true;            
            }       
        } 
    }
    
    /**
     * Check shortcode and divi review filter
     *  
     * @param array
     * @return void
     */
    public static function shortcode_divi_review_filter($post_id, $reviewx_shortcode) {
        
        $divi_settings = get_post_meta( $post_id, '_rx_option_divi_settings', true );
        if( self::reviewx_check_divi_active() && $divi_settings['rvx_review_filter'] != 'off'  ) {
            return true;
        } else if( isset($reviewx_shortcode) && $reviewx_shortcode['rx_filter'] =='off' ) {
            return true;         
        }  else {
            if( ( !isset($reviewx_shortcode) || empty($reviewx_shortcode['rx_product_id']) ) && !self::reviewx_check_divi_active() ) {            
                return true;            
            } 
        } 

    }

    /**
     * Check shortcode and divi review form
     *  
     * @param array
     * @return void
     */
    public static function shortcode_divi_review_form($post_id, $reviewx_shortcode) {

        $divi_settings = get_post_meta( $post_id, '_rx_option_divi_settings', true );
        if( self::reviewx_check_divi_active() && $divi_settings['rvx_review_form'] != 'off'  ) {
            return true;
        } else if( isset($reviewx_shortcode) && $reviewx_shortcode['rx_form'] =='on' ) {
            return true;           
        }  else {
            if( ( !isset($reviewx_shortcode) || empty($reviewx_shortcode['rx_product_id']) ) && !self::reviewx_check_divi_active() ) {            
                return true;            
            }
        } 

    }

    /**
     * Check shortcode and divi review form
     *  
     * @param array
     * @return void
     */
    public static function shortcode_divi_review_summary($post_id) {
        
        $divi_settings = get_post_meta( $post_id, '_rx_option_divi_settings', true );
        if( self::reviewx_check_divi_active() && $divi_settings['rvx_review_summary'] != 'off'  ) {
            return true;    
        }  else {
            return false;
        } 

    }    
  
}