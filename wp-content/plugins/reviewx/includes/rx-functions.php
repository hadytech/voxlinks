<?php
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Admin notice if WooCommerce is missing
 * @return void
 */
function reviewx_woocommerce_missing_wc_notice() {
    $screen = get_current_screen();
    if( ( $screen->base == 'reviewx_page_reviewx-review-email' || $screen->base == 'reviewx_page_rx-wc-settings' || $screen->base == 'reviewx_page_reviewx-quick-setup'  ) ){
        $reviewx_notice = sprintf(
            __( 'ReviewX requires WooCommerce to be installed and active to working properly. %s', 'reviewx' ),
            '<a href="' . esc_url( admin_url( 'plugin-install.php?s=WooCommerce&tab=search&type=term' ) ) . '">' . __( 'Please click on this link and install WooCommerce', 'reviewx' ) . '</a>'
        );
        printf( '<div class="error notice notice-warning is-dismissible"><p style="padding: 5px 0">%s</p></div>', $reviewx_notice );
    }
}

/**
 * Thing need to process once the reviewx plugin activation is done and loaded.
 * @return void
 */
add_action( 'admin_init', 'reviewx_get_started' );

function reviewx_get_started() {
   
    if ( ( is_admin() && current_user_can( 'activate_plugins' ) &&  ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) ) {
		add_action( 'admin_notices', 'reviewx_woocommerce_missing_wc_notice' );
	}
}

/**
 * Thing need to process once the reviewx plugin activation is done and loaded.
 * @return void
 */
add_filter( 'plugin_action_links_' . REVIEWX_BASENAME, 'reviewx_admin_settings_link', 10, 2 );

function reviewx_admin_settings_link( $links ) {

    if( class_exists('WooCommerce') ) { 
        $settings_url = add_query_arg( array('page'=> 'rx-wc-settings'), admin_url( 'admin.php' ) );              
        $links[] = '<a href="'.esc_url($settings_url).'">'.esc_html__('Settings', 'reviewx' ).'</a>';
    } else {
        $settings_url = add_query_arg( array('page'=> 'rx-admin'), admin_url( 'admin.php' ) );              
        $links[] = '<a href="'.esc_url($settings_url).'">'.esc_html__('Settings', 'reviewx' ).'</a>';       
    }

    $links[] = '<a href="'.esc_url('https://reviewx.io/docs').'">' . __( 'Docs', 'reviewx' ) . '</a>';
    if( !class_exists('ReviewXPro') ) {
        $links[] = '<a href="'.esc_url('https://reviewx.io/upgrade/reviewx-pro').'" style="color: #d30c5c;font-weight: bold;">' . __( 'Upgrade to Pro', 'reviewx' ) . '</a>';
    }
    return $links;    
}

/**
 * Show review descending order
 * @return array
 */
add_filter( 'comments_array', 'reviewx_reverse_comments' );

function reviewx_reverse_comments( $comments ) {
    return array_reverse( $comments );
}

/**
 * Function for count recommended number
 * @param $post_id
 * @return array|object|null 
 *
 */
function reviewx_product_recommendation_count( $post_id ) {

    global $wpdb;
    $rx_comment 		        = $wpdb->prefix  . 'comments';
    $rx_commentmeta 		    = $wpdb->prefix  . 'commentmeta';
    $recommended_query = $wpdb->get_results( $wpdb->prepare(
        "SELECT $rx_commentmeta.meta_value FROM $rx_commentmeta
		INNER JOIN $rx_comment
		ON $rx_commentmeta.comment_id = $rx_comment.comment_ID
		WHERE $rx_commentmeta.meta_key = 'reviewx_recommended'
		AND $rx_commentmeta.meta_value = 1
		AND $rx_comment.comment_post_ID = %d
		AND $rx_comment.comment_approved = 1", $post_id ) );

    return count( $recommended_query );

}

/**
 * Return total recommendation value
 * @param $post_id
 * @return array|object|null
 */
function reviewx_product_recommendation_count_meta( $post_id ) {

    global $wpdb;
    $rx_comment 		        = $wpdb->prefix  . 'comments';
    $rx_commentmeta 		    = $wpdb->prefix  . 'commentmeta';
    $recommended_query = $wpdb->get_results( $wpdb->prepare(
        "SELECT $rx_commentmeta.meta_value FROM $rx_commentmeta
                    INNER JOIN $rx_comment
                    ON $rx_commentmeta.comment_id = $rx_comment.comment_ID
                    WHERE $rx_commentmeta.meta_key = 'reviewx_rating'
                    AND $rx_comment.comment_post_ID = %d
                    AND $rx_comment.comment_approved = 1", $post_id ) );

    return $recommended_query;

}

/**
 * Comment auto approve
 * @param $approved
 * @return int
 */
add_filter( 'pre_comment_approved', 'reviewx_filter_pre_comment_approved', 10, 2 );

function reviewx_filter_pre_comment_approved( $approved, $commentdata ) {
    return $approved;
}

/**
 * Show review star rating
 * @param $get_rating_meta
 * @return $total_point_star
 */
function reviewx_show_star_rating( $get_rating_meta ) {

    $settings         = \ReviewX\Controllers\Admin\Core\ReviewxMetaBox::get_option_settings();
    $total_rating_inc = intval($get_rating_meta);
    $total_point_star = '';

    for( $m = 0; $m < $total_rating_inc; $m++ ) {

        $rating_symbol = '';
        $rating_svg_symbol = "<svg version='1.1' id='Layer_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px'
                                 viewBox='0 0 100 100' xml:space='preserve'>
                                <style type='text/css'>
                                    .rx_avg_star_color{fill:#FFAF22;}
                                </style>
                                <path class='rx_avg_star_color' d='M100,39.3c0-1.5-1.1-2.4-3.4-2.8l-30.2-4.4L52.9,4.8c-0.8-1.6-1.7-2.5-2.9-2.5c-1.2,0-2.2,0.8-2.9,2.5
                                    L33.5,32.1L3.4,36.5C1.1,36.9,0,37.8,0,39.3c0,0.8,0.5,1.8,1.5,2.9l21.9,21.3l-5.2,30c-0.1,0.6-0.1,1-0.1,1.2c0,0.8,0.2,1.6,0.6,2.1
                                    c0.4,0.6,1,0.9,1.9,0.9c0.7,0,1.5-0.2,2.4-0.7l27-14.2L77,97c0.8,0.5,1.6,0.7,2.4,0.7c1.6,0,2.5-1,2.5-3c0-0.5,0-0.9-0.1-1.2
                                    l-5.2-30l21.8-21.3C99.5,41.1,100,40.2,100,39.3z'/>
                                </svg>";
        $rating_symbol = $rating_svg_symbol;
        $total_point_star .= $rating_symbol;

    }

    if( preg_match( '/^\d+\.\d+$/',($get_rating_meta) ) ) {

        $rating_symbol              = '';
        $rating_svg_symbol          = "<svg version='1.1' id='Layer_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px'
                                             viewBox='0 0 100 100' xml:space='preserve'>
                                        <style type='text/css'>
                                            .rx_avg_star_color{fill:#FFAF22;}
                                        </style>
                                        <path class='rx_avg_star_color' d='M100,39.3c0-1.5-1.1-2.4-3.4-2.8l-30.2-4.4L52.9,4.8c-0.8-1.6-1.7-2.5-2.9-2.5c-1.2,0-2.2,0.8-2.9,2.5
                                            L33.5,32.1L3.4,36.5C1.1,36.9,0,37.8,0,39.3c0,0.8,0.5,1.8,1.5,2.9l21.9,21.3l-5.2,30c-0.1,0.6-0.1,1-0.1,1.2c0,0.8,0.2,1.6,0.6,2.1
                                            c0.4,0.6,1,0.9,1.9,0.9c0.7,0,1.5-0.2,2.4-0.7l27-14.2L77,97c0.8,0.5,1.6,0.7,2.4,0.7c1.6,0,2.5-1,2.5-3c0-0.5,0-0.9-0.1-1.2
                                            l-5.2-30l21.8-21.3C99.5,41.1,100,40.2,100,39.3z M68.3,60.7L72.7,86L50,74.1V16.2l11.4,23l25.4,3.7L68.3,60.7z'/>
                                        </svg>";
        $rating_symbol = $rating_svg_symbol;
        $total_point_star .= $rating_symbol;
        $total_rating_inc +=1;

    }

    for( $l= 0; $l<(5-$total_rating_inc);  $l++ ) {

        $rating_symbol              = '';
        $rating_svg_symbol          = "<svg version='1.1' id='Layer_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px'
                                             viewBox='0 0 100 100' xml:space='preserve'>
                                        <style type='text/css'>
                                            .rx_avg_star_color{fill:#FFAF22;}
                                        </style>
                                        <g>
                                            <path class='rx_avg_star_color' d='M100,39.3c0-1.5-1.1-2.4-3.4-2.8l-30.2-4.4L52.9,4.8c-0.8-1.6-1.7-2.5-2.9-2.5c-1.2,0-2.2,0.8-2.9,2.5
                                                L33.5,32.1L3.4,36.5C1.1,36.9,0,37.8,0,39.3c0,0.8,0.5,1.8,1.5,2.9l21.9,21.3l-5.2,30c-0.1,0.6-0.1,1-0.1,1.2
                                                c0,0.8,0.2,1.6,0.6,2.1c0.4,0.6,1,0.9,1.9,0.9c0.7,0,1.5-0.2,2.4-0.7l27-14.2L77,97c0.8,0.5,1.6,0.7,2.4,0.7c1.6,0,2.5-1,2.5-3
                                                c0-0.5,0-0.9-0.1-1.2l-5.2-30l21.8-21.3C99.5,41.1,100,40.2,100,39.3L100,39.3z M68.3,60.7L72.7,86L50,74.1L27.3,86l4.4-25.3
                                                L13.3,42.9l25.4-3.7l11.4-23l11.4,23l25.4,3.7L68.3,60.7z M68.3,60.7'/>
                                        </g>
                                        </svg>";
        $rating_symbol = $rating_svg_symbol;
        $total_point_star .= $rating_symbol;

    }

    return $total_point_star;

}

/**
 * This function for AJAX colling for review filter
 * @param $POST
 * @return void
 */
add_action( 'wp_ajax_rx_sorting', 'reviewx_filter_review' );
add_action( 'wp_ajax_nopriv_rx_sorting', 'reviewx_filter_review' );

function reviewx_filter_review() {

    check_ajax_referer( 'special-string', 'security' );
    $orderby_value  = sanitize_text_field( $_POST[ 'selected' ] );
    $orderby_id     = sanitize_text_field( $_POST[ 'rx_product_id' ] );
    $post_type      = sanitize_text_field( $_POST[ 'rx_post_type' ] );
    $paginaiton     = sanitize_text_field( $_POST[ 'rx_pagination' ] );
    $rating         = sanitize_text_field( $_POST[ 'rx_rating' ] );
    $page           = isset( $_POST['page'] ) ? sanitize_text_field( $_POST[ 'page' ] ) : 1;
    $per_page       = isset( $_POST['per_page'] ) ? sanitize_text_field( $_POST[ 'per_page' ] ) : 10;
    $offset         = ( $page - 1 ) * $per_page;	
    $user_id        = isset($_POST[ 'user_id' ]) ? sanitize_text_field( $_POST[ 'user_id' ] ) : '';
    $post_title     = sanitize_text_field( $_POST[ 'rx_post_title' ] );

    switch ( $orderby_value ) {
        case "photo":
            
            if( ! empty( $rating ) ) {

                $args = array(
                    'post_type'         => $post_type,
                    'orderby'           => 'date',
                    'post_id'           => $orderby_id,
                    'status'            => 'approve', 
                    'parent'            => '0',  
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
                    'tag'               => 'photo',
                    'pagination'        => $paginaiton,
                    'number'            => $per_page,
                    'offset'            => $offset,
                    'paged'             => $page,
                    'total_review'      => ReviewX_Helper::get_total_review( $orderby_id, $post_type, 'photo', $rating, $user_id ),
                    'post_title'        => $post_title                     
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
                    'post_id'           => $orderby_id,
                    'status'            => 'approve', 
                    'parent'            => '0',
                    'meta_query'        => array(
                            array(
                                'key'       => 'reviewx_attachments',
                                'value'     => array( '', array(), serialize( array() ) ),
                                'compare'   => 'NOT IN'
                            )
                        ),
                    'tag'               => 'photo',
                    'pagination'        => $paginaiton,
                    'number'            => $per_page,
                    'offset'            => $offset,
                    'paged'             => $page,
                    'total_review'      => ReviewX_Helper::get_total_review( $orderby_id, $post_type, 'photo', '', $user_id ),
                    'post_title'        => $post_title                     
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

            apply_filters( 'rx_load_filter_review_template', $args );

        break;

        case "video":

            if( ! empty( $rating ) ) {

                $args = array(
                    'post_type'         => $post_type,
                    'orderby'           => 'date',
                    'post_id'           => $orderby_id,
                    'status'            => 'approve', 
                    'parent'            => '0',
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
                    'tag'               => 'video',
                    'pagination'        => $paginaiton,
                    'number'            => $per_page,
                    'offset'            => $offset,
                    'paged'             => $page,
                    'total_review' => ReviewX_Helper::get_total_review( $orderby_id, $post_type, 'video', $rating, $user_id ),
                    'post_title'        => $post_title
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
                    'post_id'           => $orderby_id,
                    'status'            => 'approve', 
                    'parent'            => '0',
                    'meta_query'        => array(
                        array(
                            'key' => 'reviewx_video_url',
                            'value' => '',
                            'compare' => 'NOT IN'
                        )
                    ),
                    'tag'               => 'video',
                    'pagination'        => $paginaiton,
                    'number'            => $per_page,
                    'offset'            => $offset,
                    'paged'             => $page,
                    'total_review' => ReviewX_Helper::get_total_review( $orderby_id, $post_type, 'video', '', $user_id ),
                    'post_title'        => $post_title                     
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

            apply_filters( 'rx_load_filter_review_template', $args );

		break;        

        case "text":

            if( class_exists('ReviewXPro') ) {

                if( ! empty( $rating ) ) {  

                    $args = array(
                        'post_type'         => $post_type,
                        'orderby'           => 'date',
                        'post_id'           => $orderby_id,
                        'status'            => 'approve', 
                        'parent'            => '0',
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
                        'tag'               => 'text',
                        'pagination'        => $paginaiton,
                        'number'            => $per_page,
                        'offset'            => $offset,
                        'paged'             => $page,
                        'total_review' => ReviewX_Helper::get_total_review( $orderby_id, $post_type, 'text', $rating, $user_id ),
                        'post_title'        => $post_title  
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

                } else {

                    $args = array(
                        'post_type'         => $post_type,
                        'orderby'           => 'date',
                        'post_id'           => $orderby_id,
                        'status'            => 'approve', 
                        'parent'            => '0',
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
                        'tag'               => 'text',
                        'pagination'        => $paginaiton,
                        'number'            => $per_page,
                        'offset'            => $offset,
                        'paged'             => $page,
                        'total_review' => ReviewX_Helper::get_total_review( $orderby_id, $post_type, 'text', '', $user_id ),
                        'post_title'        => $post_title  
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

                }

            } else {

                if( ! empty( $rating ) ) {

                    $args = array(
                        'post_type'         => $post_type,
                        'orderby'           => 'date',
                        'post_id'           => $orderby_id,
                        'status'            => 'approve', 
                        'parent'            => '0',
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
                        'tag'               => 'text',
                        'pagination'        => $paginaiton,
                        'number'            => $per_page,
                        'offset'            => $offset,
                        'paged'             => $page,
                        'total_review'      => ReviewX_Helper::get_total_review( $orderby_id, $post_type, 'text', $rating, $user_id ),
                        'post_title'        => $post_title  
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

                } else {

                    $args = array(
                        'post_type'         => $post_type,
                        'orderby'           => 'date',
                        'post_id'           => $orderby_id,
                        'status'            => 'approve',
                        'parent'            => '0', 
                        'meta_query'        => array(
                            array(
                                'key'   => 'reviewx_attachments',
                                'compare' => 'NOT EXISTS'
                            ),
                        ),
                        'tag'               => 'text',
                        'pagination'        => $paginaiton,
                        'number'            => $per_page,
                        'offset'            => $offset,
                        'paged'             => $page,
                        'total_review'      => ReviewX_Helper::get_total_review( $orderby_id, $post_type, 'text', '', $user_id ),
                        'post_title'        => $post_title
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

                }

            }
			
            apply_filters( 'rx_load_filter_review_template', $args );
			
        break;

        case "rating":

            $args = array(
                'post_type'             => $post_type,
                'post_id'               => $orderby_id,
                'status'                => 'approve', 
                'parent'                => '0',
                'meta_query'            => array(
                    'meta_value'        => array(
                        'key'           => 'rating',
                        'value'         => 5,
                        'compare'       => '<='
                    ),
                ),
                'orderby'               => array(
                    'meta_value'        => 'DESC'
                ),
                'tag'                   => 'rating',
                'pagination'            => $paginaiton,
                'number'                => $per_page,
                'offset'                => $offset,
                'paged'                 => $page,
                'total_review'          => ReviewX_Helper::get_total_review( $orderby_id, $post_type, 'rating', '', $user_id ),
                'post_title'            => $post_title 
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

            apply_filters( 'rx_load_filter_review_template', $args );

        break;

        case "low":

            $args = array(
                'post_type'             => $post_type,
                'post_id'               => $orderby_id,
                'status'                => 'approve', 
                'parent'                => '0',
                'meta_query'            => array(
                    'meta_value'        => array(
                        'key'           => 'rating',
                        'value'         => 5,
                        'compare'       => '<='
                    ),
                ),
                'orderby'               => array(
                    'meta_value'        => 'ASC'
                ),
                'tag'                   => 'low',
                'pagination'            => $paginaiton,
                'number'                => $per_page,
                'offset'                => $offset,
                'paged'                 => $page,
                'total_review'          => ReviewX_Helper::get_total_review( $orderby_id, $post_type, 'low', '', $user_id ),
                'post_title'            => $post_title 
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

            apply_filters( 'rx_load_filter_review_template', $args );

        break;  
        
        case "tooltip_filter":
            
            $args = array(
                'post_type'         => $post_type,
                'orderby'           => 'date',
                'post_id'           => $orderby_id,
                'tag'               => 'recent',
                'pagination'        => $paginaiton,
                'status'            => 'approve', 
                'parent'            => '0',
                'meta_query'        => array(
                    'relation' => 'AND',
                    [
                        'key'     => 'rating',
                        'value'   => $rating,
                        'compare' => '>=',
                        'type'    => 'DECIMAL',
                    ],
                    [
                        'key'     => 'rating',
                        'value'   => $rating,
                        'compare' => '<=',
                        'type'    => 'DECIMAL',
                    ],                       
                ),
                'number'            => $per_page,
                'offset'            => $offset,
                'paged'             => $page,
                'total_review'      => ReviewX_Helper::get_total_review( $orderby_id, $post_type, '', $rating, $user_id ),
                'post_title'        => $post_title                     
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

            apply_filters( 'rx_load_filter_review_template', $args );

        break;    

        default:
         
            if( ! empty( $rating ) ) {

                $args = array(
                    'post_type'         => $post_type,
                    'orderby'           => 'date',
                    'post_id'           => $orderby_id,
                    'tag'               => 'recent',
                    'pagination'        => $paginaiton,
                    'status'            => 'approve', 
                    'parent'            => '0',
                    'meta_query'        => array(
                        'meta_value'    => array(
                            'key'       => 'rating',
                            'value'     => $rating,
                            'compare'   => '='
                        ),
                    ),
                    'number'            => $per_page,
                    'offset'            => $offset,
                    'paged'             => $page,
                    'total_review'      => ReviewX_Helper::get_total_review( $orderby_id, $post_type, '', $rating, $user_id ),
                    'post_title'        => $post_title                     
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
                    'post_id'           => $orderby_id,
                    'status'            => 'approve', 
                    'parent'            => '0',
                    'tag'               => 'recent',
                    'pagination'        => $paginaiton,
                    'number'            => $per_page,
                    'offset'            => $offset,
                    'paged'             => $page,
                    'total_review'      => ReviewX_Helper::get_total_review( $orderby_id, $post_type, '', '', $user_id ),
                    'parent'            => 0,
                    'post_title'        => $post_title                    
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
        
            apply_filters( 'rx_load_filter_review_template', $args );

        break;
    }
    wp_die();

}

/**
 * This function load html template
 * @param $args
 * @return void
 */
add_filter( 'rx_load_filter_review_template', 'rx_load_filter_review_template' );
function rx_load_filter_review_template( $args ) {

    if( ! class_exists('ReviewXPro') ) {

        if( $args['post_type'] == 'product' ) {
            $settings 	     = \ReviewX\Controllers\Admin\Core\ReviewxMetaBox::get_option_settings();
            $template_style  = $settings->template_style;
        } else if( \ReviewX_Helper::check_post_type_availability( $args['post_type'] ) == TRUE ) {
           $reviewx_id       = \ReviewX_Helper::get_reviewx_post_type_id( $args['post_type'] );   
           $settings         = \ReviewX\Controllers\Admin\Core\ReviewxMetaBox::get_metabox_settings( $reviewx_id );  
           $template_style   = $settings->template_style;            
        }

        $rx_elementor_controller  = apply_filters( 'rx_load_elementor_style_controller', '' );
        $rx_elementor_template    = isset($rx_elementor_controller['rx_template_type']) ? $rx_elementor_controller['rx_template_type'] : null;

        $rx_oxygen_controller  = apply_filters( 'rx_load_oxygen_style_controller', '' );
        $rx_oxygen_template    = isset($rx_oxygen_controller['rx_template_type']) ? $rx_oxygen_controller['rx_template_type'] : null;

        //Check elementor template 
        if( ! empty($rx_elementor_template) ) {
            switch ( $rx_elementor_template ) {
                case 'template_style_two':
                    include REVIEWX_PARTIALS_PATH . 'storefront/single-review/filter/style-two.php';
                break;
                default:
                    include REVIEWX_PARTIALS_PATH . 'storefront/single-review/filter/style-one.php';
            }
            
        } else if( ! empty($rx_oxygen_template) ) {             

            switch ( $rx_oxygen_template ) {
                case 'box':
                    include REVIEWX_PARTIALS_PATH . 'storefront/single-review/filter/style-two.php';
                break;
                default:
                    include REVIEWX_PARTIALS_PATH . 'storefront/single-review/filter/style-one.php';
            }

        } else {

            //Serve local template	
            switch ( $template_style ) {
                case 'template_style_two':
                    include REVIEWX_PARTIALS_PATH . 'storefront/single-review/filter/style-two.php';
                break;
                default:
                    include REVIEWX_PARTIALS_PATH . 'storefront/single-review/filter/style-one.php';
            }

        }

        reviewx_review_filter_query_html( $args );
    }

}

/**
 * Handle the default star rating in the backend
 * @param none
 * @return void
 */
add_action( 'add_meta_boxes' , 'rx_remove_meta_boxes', 40 );

function rx_remove_meta_boxes() {
    remove_meta_box('woocommerce-rating','comment','normal', 'high' ); 
}

/**
 * Count total reviewer
 * @param $post_id
 * @return int
 */
function rx_total_reviewer_free( $post_id, $post_type = 'product' ) {

    global $wpdb;
    $rx_comment_table = $wpdb->prefix . 'comments';
    if( !empty($post_id) ){
        $data = $wpdb->get_results( $wpdb->prepare( "SELECT DISTINCT comment_author_email FROM $rx_comment_table WHERE comment_approved = '1' AND comment_author_email !='' AND comment_post_ID = %d AND comment_parent = %d", (int) $post_id, 0 ) );        
    } else {
        if( empty($post_type) ){
            $post_type = 'product';
        }
        $data = $wpdb->get_results( $wpdb->prepare( "SELECT DISTINCT comment_author_email FROM $rx_comment_table WHERE comment_post_ID in (
            SELECT ID FROM $wpdb->posts WHERE post_type = '$post_type' AND post_status = 'publish')
            AND comment_approved = '1' AND comment_author_email !=''" 
        ) );
    }

    if( $data && count($data) ) {
        return count($data);
    }
    return 0; 

}

/**
 * Before my order navigation
 * @param none
 * @return void
 */
add_action('woocommerce_before_account_navigation', 'rx_add_class_before_navigation');
function rx_add_class_before_navigation() { ?>
	<div class="rx-woocommerce-myaccount-navigation">
<?php }

/**
 * After my order navigation 
 * @param none
 * @return void
 */
add_action('woocommerce_after_account_navigation', 'rx_add_class_after_navigation');
function rx_add_class_after_navigation() {
	?>
	</div>
	<?php
}

/**
 * Comment note modify
 * @param array
 * @return void
 */
add_filter( 'comment_form_defaults', 'rx_pre_comment_text' );
function rx_pre_comment_text( $arg ) {
  $arg['comment_notes_before'] = sprintf('<p class="comment-notes">%s</p>',sprintf('<span id="email-notes">%s</span>',__( 'Your email address will not be published.', 'reviewx' ), '' ));
  return $arg;
}

/**
 * Save review post per page
 * @param array
 * @return void
 */
add_filter( 'admin_init', 'rx_set_screen_options' );
function rx_set_screen_options() {
    if ( isset( $_POST['wp_screen_options'] ) && is_array( $_POST['wp_screen_options'] ) ) {
        check_admin_referer( 'screen-options-nonce', 'screenoptionnonce' );

        $user = wp_get_current_user();
		if ( ! $user ) {
			return;
        }
        
        $option = $_POST['wp_screen_options']['option'];
        $value  = $_POST['wp_screen_options']['value'];
        
        if ( sanitize_key( $option ) != $option ) {
			return;
        }

        update_user_meta( $user->ID, $option, $value );
    }
}

/**
 * Call cron function to recalculate rating averag
 * @param none
 * @return void
 */

use ReviewX\Controllers\Admin\Email\EmailSettings;
use ReviewX\Controllers\Admin\Rating\ReCalculateReviewRating;
register_activation_hook(REVIEWX_FILE, 'rx_call_cron_function' );
function rx_call_cron_function() {
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'reviewx_process_jobs';
    $post_types     = [];
    $post_types     = ReviewX_Helper::get_enabled_types(); 
    array_push($post_types, 'product' );
    $types = array( 'comment', 'review' );
    
    $args = [
        'post_type' => $post_types,
        'type'  	=> $types,
    ];
    $reviews = get_comments($args);

    if( count($reviews) < 15 ) {

        foreach( $reviews as $rx ) {
            $wpdb->insert( $table_name, array( 'process_name' => 're_calculate_review', 'process_meta' => $rx->comment_ID ), array( '%s', '%d' ) );
        }

        wp_clear_scheduled_hook( 'rx_process_re_calculate' );
        if ( ! wp_next_scheduled( 'rx_process_re_calculate' ) ) {
            wp_schedule_single_event( time() + 120, 'rx_process_re_calculate' );
        }

    } else {

        wp_clear_scheduled_hook( 'rx_collect_review_id' );
        if ( ! wp_next_scheduled( 'rx_collect_review_id' ) ) {             
            wp_schedule_single_event( time() + 120, 'rx_collect_review_id' );
        }

    }

}

add_action('rx_reminder_email_dispatch_scheduled', 'scheduled_email_dispatching');

function scheduled_email_dispatching($args) {
    (new EmailSettings())->sendScheduleEmail($args);
}

/**
 * Collect all review id
 * @param none
 * @return void
 */
add_action( 'rx_collect_review_id', 'collect_all_reviews_id' );
function collect_all_reviews_id(){
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'reviewx_process_jobs';

    $post_types     = [];
    $post_types     = ReviewX_Helper::get_enabled_types(); 
    array_push($post_types, 'product' );
    $types = array( 'comment', 'review' );
    
    $args = [
        'post_type' => $post_types,
        'type'  	=> $types,
    ];
    $reviews = get_comments($args);

    foreach( $reviews as $rx ) {
        $wpdb->insert( $table_name, array( 'process_name' => 're_calculate_review', 'process_meta' => $rx->comment_ID ), array( '%s', '%d' ) );
    }    

    //Rating average calculation is here
    wp_clear_scheduled_hook( 'rx_process_re_calculate' );
    if ( ! wp_next_scheduled( 'rx_process_re_calculate' ) ) {
        wp_schedule_single_event( time() + 120, 'rx_process_re_calculate' );
    } 
}

/**
 * Calculate rating average
 * @param none
 * @return void
 */
add_action( 'rx_process_re_calculate', 'process_review_recalculation' );
function process_review_recalculation() {
    
    global $wpdb;
    $table_name         = $wpdb->prefix . 'reviewx_process_jobs';
    $sql                = $wpdb->prepare("SELECT * FROM $table_name");
    $reviews            = $wpdb->get_results($sql); 
    foreach( $reviews as $rx ) {
        (new ReCalculateReviewRating())->handleAction($rx->process_meta, true);
        $wpdb->delete( $table_name, array( 'id' => $rx->id ) );        
    }

}

/**
 * Check video type
 * @param string
 * @return void
 */
function rx_edit_review_determine_video_url_type( $url ){

    $yt_rx = '/^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$/';
    $has_match_youtube = preg_match($yt_rx, $url, $yt_matches);

    $vm_rx = '/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([‌​0-9]{6,11})[?]?.*/';
    $has_match_vimeo = preg_match($vm_rx, $url, $vm_matches);

    //Then we want the video id which is:
    if($has_match_youtube) {
        $video_id = $yt_matches[5]; 
        $type = 'youtube';
    }
    elseif($has_match_vimeo) {
        $video_id = $vm_matches[5];
        $type = 'vimeo';
    }
    else {
        $video_id = 0;
        $type = 'none';
    }

    $data['video_id'] = $video_id;
    $data['video_type'] = $type;

    return $data;
    
}

/**
 * WP User Avatar Uploader compability
 * @param string
 * @return void
 */
add_filter('media_view_settings', 'rx_media_view_settings', 10, 2);
function rx_media_view_settings($settings) {
    if( class_exists('WP_User_Avatar') ){
        global $post, $wpua_is_profile;
        $wpua_is_profile = 1; 
        // Get post ID so not to interfere with media uploads
        $post_id = is_object($post) ? $post->ID : 0;
        // Don't use post ID on front pages if there's a WPUA uploader
        $settings['post']['id'] = (!is_admin() && $wpua_is_profile == 1) ? 0 : $post_id;
    }    
    return $settings;
}

/**
 * Set WooCommerce email sender name
 * @param string
 * @return void
 */
add_filter( 'wp_mail_from_name', 'rx_mail_from_name' );
function rx_mail_from_name( $name ) {
    return get_option('woocommerce_email_from_name');
}

/**
 * Set WooCommerce sender email address
 * @param string
 * @return void
 */
add_filter( 'wp_mail_from', 'rx_mail_from' );
function rx_mail_from( $email ) {
    return get_option('woocommerce_email_from_address');
}

/**
 * Support EDD for reviewx system
 * @param string
 * @return void
 */
function rx_edd_comments() {
	add_post_type_support( 'download', 'comments' );
}
add_action( 'init', 'rx_edd_comments', 999 );

function rx_touch_time( $edit = 1, $for_post = 1, $tab_index = 0, $multi = 0, $comment_date ) {
	global $wp_locale;
    $post = get_post(44);

	if ( $for_post ) {
		$edit = ! ( in_array( $post->post_status, array( 'draft', 'pending' ), true ) && ( ! $post->post_date_gmt || '0000-00-00 00:00:00' === $post->post_date_gmt ) );
    }

	$tab_index_attribute = '';
	if ( (int) $tab_index > 0 ) {
		$tab_index_attribute = " tabindex=\"$tab_index\"";
	}

	// @todo Remove this?
	// echo '<label for="timestamp" style="display: block;"><input type="checkbox" class="checkbox" name="edit_date" value="1" id="timestamp"'.$tab_index_attribute.' /> '.__( 'Edit timestamp' ).'</label><br />';

    $post_date = ( $for_post ) ? $post->post_date : $comment_date;

	$jj        = ( $edit ) ? mysql2date( 'd', $post_date, false ) : current_time( 'd' );
	$mm        = ( $edit ) ? mysql2date( 'm', $post_date, false ) : current_time( 'm' );
	$aa        = ( $edit ) ? mysql2date( 'Y', $post_date, false ) : current_time( 'Y' );
	$hh        = ( $edit ) ? mysql2date( 'H', $post_date, false ) : current_time( 'H' );
	$mn        = ( $edit ) ? mysql2date( 'i', $post_date, false ) : current_time( 'i' );
	$ss        = ( $edit ) ? mysql2date( 's', $post_date, false ) : current_time( 's' );

	$cur_jj = current_time( 'd' );
	$cur_mm = current_time( 'm' );
	$cur_aa = current_time( 'Y' );
	$cur_hh = current_time( 'H' );
	$cur_mn = current_time( 'i' );

	$month = '<label><span class="screen-reader-text">' . __( 'Month', 'reviewx' ) . '</span><select ' . ( $multi ? '' : 'id="mm" ' ) . 'name="mm"' . $tab_index_attribute . ">\n";
	for ( $i = 1; $i < 13; $i = $i + 1 ) {
		$monthnum  = zeroise( $i, 2 );
		$monthtext = $wp_locale->get_month_abbrev( $wp_locale->get_month( $i ) );
		$month    .= "\t\t\t" . '<option value="' . $monthnum . '" data-text="' . $monthtext . '" ' . selected( $monthnum, $mm, false ) . '>';
		/* translators: 1: Month number (01, 02, etc.), 2: Month abbreviation. */
		$month .= sprintf( __( '%1$s-%2$s' ), $monthnum, $monthtext ) . "</option>\n";
	}
	$month .= '</select></label>';

	$day    = '<label><span class="screen-reader-text">' . __( 'Day' ) . '</span><input type="text" ' . ( $multi ? '' : 'id="jj" ' ) . 'name="jj" value="' . $jj . '" size="2" maxlength="2"' . $tab_index_attribute . ' autocomplete="off" /></label>';
	$year   = '<label><span class="screen-reader-text">' . __( 'Year' ) . '</span><input type="text" ' . ( $multi ? '' : 'id="aa" ' ) . 'name="aa" value="' . $aa . '" size="4" maxlength="4"' . $tab_index_attribute . ' autocomplete="off" /></label>';
	$hour   = '<label><span class="screen-reader-text">' . __( 'Hour' ) . '</span><input type="text" ' . ( $multi ? '' : 'id="hh" ' ) . 'name="hh" value="' . $hh . '" size="2" maxlength="2"' . $tab_index_attribute . ' autocomplete="off" /></label>';
	$minute = '<label><span class="screen-reader-text">' . __( 'Minute' ) . '</span><input type="text" ' . ( $multi ? '' : 'id="mn" ' ) . 'name="mn" value="' . $mn . '" size="2" maxlength="2"' . $tab_index_attribute . ' autocomplete="off" /></label>';

	echo '<div class="timestamp-wrap">';
	/* translators: 1: Month, 2: Day, 3: Year, 4: Hour, 5: Minute. */
	printf( __( '%1$s %2$s, %3$s at %4$s:%5$s' ), $month, $day, $year, $hour, $minute );

	echo '</div><input type="hidden" id="ss" name="ss" value="' . $ss . '" />';

	if ( $multi ) {
		return;
	}

	echo "\n\n";

	$map = array(
		'mm' => array( $mm, $cur_mm ),
		'jj' => array( $jj, $cur_jj ),
		'aa' => array( $aa, $cur_aa ),
		'hh' => array( $hh, $cur_hh ),
		'mn' => array( $mn, $cur_mn ),
	);

	foreach ( $map as $timeunit => $value ) {
		list( $unit, $curr ) = $value;

		echo '<input type="hidden" id="hidden_' . $timeunit . '" name="hidden_' . $timeunit . '" value="' . $unit . '" />' . "\n";
		$cur_timeunit = 'cur_' . $timeunit;
		echo '<input type="hidden" id="' . $cur_timeunit . '" name="' . $cur_timeunit . '" value="' . $curr . '" />' . "\n";
	}
	?>

<p>
<a href="#edit_timestamp" class="save-timestamp hide-if-no-js button"><?php _e( 'OK', 'reviewx' ); ?></a>
<a href="#edit_timestamp" class="cancel-timestamp hide-if-no-js button-cancel"><?php _e( 'Cancel', 'reviewx' ); ?></a>
</p>
	<?php
}

/**
 * Retrieve wc order statuses
 * @param boolean
 * @return void
 */
add_filter( 'rx_wc_order_status', 'rx_wc_order_status' );
function rx_wc_order_status(){

    $data       = array();
    if( class_exists( 'WooCommerce' ) ) {
        $statuses   = wc_get_order_statuses();
        foreach( $statuses as $key=>$value ) {	
            $key = str_replace("wc-", "", $key);
            $data[$key] = $value;  		
        }
    } else {
       $data = array(
        'pending' => __('Pending payment', 'reviewx'),
        'processing' => __('Processing', 'reviewx'),
        'on-hold' => __('On hold', 'reviewx'),
        'completed' => __('Completed', 'reviewx'),
        'cancelled' => __('Cancelled', 'reviewx'),
        'refunded' => __('Refunded', 'reviewx'),
        'failed' => __('Failed', 'reviewx')
       ); 
    }
    
    return $data;
}

/**
 * Retrieve wc order statuses
 * @param boolean
 * @return void
 */
add_filter( 'rx_builder_wc_order_status', 'rx_builder_wc_order_status' );
function rx_builder_wc_order_status(){

    $data         = [];
    $builder_data = [];
    $statuses     = apply_filters('rx_wc_order_status', true);
    foreach( $statuses as $key=>$value ) {

        $builder_data['type'] = 'checkbox';
        $builder_data['label'] = $value; 
        if( $key == "completed" ){
            $builder_data['default'] = 1;
        } else {
            $builder_data['default'] = '';
        }

        $data[$key] = $builder_data;   

    }

    return $data;
}



add_filter( 'rx_allow_filter_keyword', 'rx_allow_filter_keyword' );
function rx_allow_filter_keyword(){
    $options         = [];
    $data            = [];
    $builder_data    = [];    
    if( class_exists('ReviewXPro') ) {
        $options =  array(
            'filter_recent'    => __('Recent Review', 'reviewx'),
            'filter_photo'     => __('Photo Review', 'reviewx'),
            'filter_video'     => __('Video Review', 'reviewx'),
            'filter_text'      => __('Text Review', 'reviewx'),
            'filter_rating'    => __('Top Rated', 'reviewx'),
            'filter_low_rating'       => __('Low Rated', 'reviewx'),                            
        );
    } else {
        $options = array(
            'filter_recent'    => __('Recent Review', 'reviewx'),
            'filter_photo'     => __('Photo Review', 'reviewx'),            
            'filter_text'      => __('Text Review', 'reviewx'),
            'filter_rating'    => __('Top Rated', 'reviewx'),
            'filter_low_rating'       => __('Low Rated', 'reviewx'),                            
        );
    }

    foreach( $options as $key=>$value ) {
        $builder_data['type'] = 'checkbox';
        $builder_data['label'] = $value; 
        $builder_data['default'] = 1;
        $data[$key] = $builder_data;  
    }

    return $data;
}

/**
 * Disable structured product 
 * @param boolean
 * @return void
 */
add_filter( 'woocommerce_structured_data_product', 'structured_data_product_nulled', 10, 2 );
function structured_data_product_nulled( $markup, $product ) {

    $disable_richschema = get_option( '_rx_option_disable_richschema' );
    if( is_product() && $disable_richschema == 1 ) {
        $markup = '';
    }
    return $markup;
}

/**
 * User update nonce
 * @param integer
 * @return void
 */
function rx_new_user_update_nonce_name($user_id) {
    $metadata = get_user_meta($user_id, PKG_AUTOLOGIN_USER_META_KEY, false);
    if (count($metadata) > 0) {
        $codeNonceData = "c" . $metadata[0];
    } else {
        $codeNonceData = 'e';
    }
    return "pkg-update-user-link_" . wp_nonce_tick() . "_$user_id" . "_$codeNonceData";
}

/**
 * Get user page id
 * @param array
 * @return boolean
 */
function rx_autologin_get_page_user_id($parameterArray=NULL) {
    if ($parameterArray === NULL) {
      $parameterArray = $_GET;
    }
    
    $result = False;
    
    // On profile page?
    if (defined('IS_PROFILE_PAGE') && IS_PROFILE_PAGE) {
      $user = wp_get_current_user();
      if ($user && ($user->ID != 0)) {
        $result = $user->ID;
      }
    } else { // Not on profile page -> read user_id from $parameterArray
      if (isset($parameterArray['user_id'])) { 
        $result = (int) $parameterArray['user_id'];
        if (!get_userdata($result)) {
          $result = False;
        }
      }
    }
    
    return $result;
}

/**
 * Autologin stage new code
 * @param integer
 * @return string
 */
function rx_autologin_stage_new_code($user_id) {

    if (!$user_id) {
      wp_die(__('Invalid user ID.'), '', array('response' => 400));
    }
  
    $new_code = rx_autologin_generate_code();
    //update_user_meta($user_id, REVIEWX_AUTOLOGIN_STAGED_CODE_NONCE_USER_META_KEY, $wpnonce);
    $get_code = get_user_meta($user_id, REVIEWX_AUTOLOGIN_USER_META_KEY, true);
    if( !isset($get_code) || empty($get_code) ){
        update_user_meta($user_id, REVIEWX_AUTOLOGIN_USER_META_KEY, $new_code);
    }

    return $new_code;
}

/**
 * Autologin stage new code
 * @param integer
 * @return string
 */
function rx_autologin_generate_code() {
    $hasher = new PasswordHash(8, true); // The PasswordHasher has a php-version independent "safeish" random generator
    
    // Workaround: first value seems to always be zero, so we will skip the first value
    $random_ints = unpack("L*", $hasher->get_random_bytes(4 * (REVIEWX_AUTOLOGIN_CODE_LENGTH + 1)));
    $char_count = strlen(REVIEWX_AUTOLOGIN_CODE_CHARACTERS);
    $new_code = "";
    $_str_copy_php55 = REVIEWX_AUTOLOGIN_CODE_CHARACTERS;
    for ($i = 0; $i < REVIEWX_AUTOLOGIN_CODE_LENGTH; $i++) {
      $new_code = $new_code . $_str_copy_php55[$random_ints[$i + 1] % $char_count];
    }
    return $new_code;
}

/**
 * Autologin join get parameters
 * @param array
 * @return string
 */
function rx_autologin_join_get_parameters($parameters) {
    $keys = array_keys($parameters);
    $assignments = array();
    foreach ($keys as $key) {
      $assignments[] = rawurlencode($key) . "=" . rawurlencode($parameters[$key]);
    }
    return implode('&', $assignments);
}

/**
 * Autologin generate postfix
 * @param none
 * @return string
 */
function rx_autologin_generate_get_postfix() {
    $GETcopy = $_GET;
    unset($GETcopy[REVIEWX_AUTOLOGIN_VALUE_NAME]);
    $GETQuery = rx_autologin_join_get_parameters($GETcopy);
    if (strlen($GETQuery) > 0) {
      $GETQuery = '?' . $GETQuery;
    }
    return $GETQuery;
}

/**
 * Hook general init to login users if an autologin code is specified
 * @param none
 * @return void
 */
add_action('init', 'rx_autologin_authenticate');
function rx_autologin_authenticate() {
  global $wpdb;
  
  // Check if autologin link is specified - if there is one the work begins
  if (isset($_GET[REVIEWX_AUTOLOGIN_VALUE_NAME])) {    
    $autologin_code = preg_replace('/[^a-zA-Z0-9]+/', '', $_GET[REVIEWX_AUTOLOGIN_VALUE_NAME]);
    if($autologin_code) {
        $protocol = (isset($_SERVER["HTTPS"]) && ($_SERVER["HTTPS"] === "on")) ? "https" : "http";
        if(strpos($autologin_code, "rxwcorder") !== false) {
            $rxwcorder = explode("rxwcorder", $autologin_code);
            $order_id = isset($rxwcorder[1])?$rxwcorder[1]: '';
            $order = wc_get_order( $order_id );
            ?>
            <script type="text/javascript">
                document.addEventListener("DOMContentLoaded", function(){
                    document.getElementById("author").value="<?php echo $order->get_billing_first_name() ." ". $order->get_billing_last_name(); ?>";
                    document.getElementById("email").value="<?php echo $order->get_billing_email(); ?>";
                });	            
            </script>
            <?php
            
        } else {
            // Get part left of ? of the request URI for resassembling the target url later
            $subURIs = array();
            if (preg_match('/^([^\?]+)\?/', $_SERVER["REQUEST_URI"], $subURIs) === 1) {
                $targetPage = $subURIs[1];

                if (isset($_SERVER["HTTP_X_FORWARDED_PREFIX"])) {
                $prefix = $_SERVER["HTTP_X_FORWARDED_PREFIX"];
                if (substr($prefix, -1) == "/") {
                    $prefix = substr($prefix, 0, -1);
                }
                $targetPage = $prefix . $targetPage;
                }

                // Query login codes
                $loginCodeQuery = $wpdb->prepare(
                "SELECT user_id, meta_value as login_code FROM $wpdb->usermeta WHERE meta_key = %s and meta_value = '%s';",
                REVIEWX_AUTOLOGIN_USER_META_KEY,
                $autologin_code); // $autologin_code has been heavily cleaned before       
                
                $userIds = array();
                $results = $wpdb->get_results($loginCodeQuery, ARRAY_A);

                if ($results === NULL) {
                    wp_redirect($protocol . '://' . $_SERVER['HTTP_HOST'] . $targetPage);
                    exit;
                }
                foreach ($results as $row) {
                    if ($row["login_code"] === $autologin_code) {
                        $userIds[] = $row["user_id"];
                    }
                }        
                
                // Double login codes? should never happen - better safe than sudden admin rights for someone :D
                if (count($userIds) > 1) {
                //wp_die("Please login normally - this is a statistic bug and prevents you from using login links securely!"); // TODO !!!
                wp_redirect($protocol . '://' . $_SERVER['HTTP_HOST'] . $targetPage);
                exit;
                }

                // Only login if there is only ONE possible user
                if (count($userIds) == 1) {
                $userToLogin = get_user_by('id', (int) $userIds[0]);
            
                // Check if user exists
                if ($userToLogin) {
                    wp_set_auth_cookie($userToLogin->ID, false);
                    do_action('wp_login', $userToLogin->name, $userToLogin);

                    // Create redirect URL without autologin code
                    $GETQuery = rx_autologin_generate_get_postfix();
                    
                    
                    // Augment my solution with https://stackoverflow.com/questions/1907653/how-to-force-page-not-to-be-cached-in-php
                    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
                    header("Cache-Control: no-cache, no-store, must-revalidate, private, max-age=0, s-maxage=0");
                    header("Cache-Control: post-check=0, pre-check=0", false);
                    header("Pragma: no-cache");
                    header("Expires: Mon, 01 Jan 1990 01:00:00 GMT");
                    
                    wp_redirect($protocol . '://' . $_SERVER['HTTP_HOST'] . $targetPage . $GETQuery);
                    exit;
                }
                }
            } 

            // If something went wrong send the user to login-page (and log the old user out if there was any)
            wp_logout();
            wp_redirect(home_url('wp-login.php?rx_autologin_error=invalid_login_code'));
            exit;             
        }          
    }
  }
}
 
/**
 * Hook special login head to be able to display specialized 
 * "invalid autologin link" error
 * @param none
 * @return void
 */
add_action('login_head', 'rx_autologin_extract_login_link_error');
function rx_autologin_extract_login_link_error() {
  global $errors;

  if (isset($_GET['rx_autologin_error'])) {
    $rawMsg = $_GET['rx_autologin_error'];
    
    // Check if valid pkg_autologin_error
    if (in_array($rawMsg, array('invalid_login_code'))) {
      $secureMsg = $rawMsg;
      
      // Add error texts
      switch ($secureMsg) {
        case 'invalid_login_code':
          $errors->add("invalid_autologin_link", __("Invalid autologin link.", 'reviewx'));
          break;
      }
    }
  }
}