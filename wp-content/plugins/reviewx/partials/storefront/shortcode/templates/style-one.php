<?php
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }
    
    if( $reviewx_shortcode['rx_post_type'] == 'product' ){
        $settings 				= \ReviewX\Controllers\Admin\Core\ReviewxMetaBox::get_option_settings();
        $allow_img_filter 		= get_option( '_rx_option_allow_img' );
        $review_per_page  		= $settings->review_per_page;
        $review_style    	    = $settings->review_style;

        $filter_recent  		= get_option( '_rx_option_filter_recent' );   
        $filter_photo  		    = get_option( '_rx_option_filter_photo' );   
        $filter_text  		    = get_option( '_rx_option_filter_text' );   
        $filter_top_rated  		= get_option( '_rx_option_filter_rating' );   
        $filter_low_rated       = get_option( '_rx_option_filter_low_rating' );   

        $post_id                = $reviewx_shortcode['rx_product_id'];                                 
        $rx_total_reviewer      = rx_total_reviewer_free( $post_id, '' ); 
    } else if( \ReviewX_Helper::check_post_type_availability( $reviewx_shortcode['rx_post_type'] ) == TRUE ) {
        
        $reviewx_id             = \ReviewX_Helper::get_reviewx_post_type_id( $reviewx_shortcode['rx_post_type'] );   
        $allow_img_filter 		= \ReviewX_Helper::get_post_meta( $reviewx_id, 'allow_img', true );
        $review_per_page  		= \ReviewX_Helper::get_post_meta( $reviewx_id, 'review_per_page', true );  
        $review_style  		    = \ReviewX_Helper::get_post_meta( $reviewx_id, 'review_style', true ); 
        
        $filter_recent  		= \ReviewX_Helper::get_post_meta( $reviewx_id, 'filter_recent', true );  
        $filter_photo  		    = \ReviewX_Helper::get_post_meta( $reviewx_id, 'filter_photo', true );   
        $filter_text  		    = \ReviewX_Helper::get_post_meta( $reviewx_id, 'filter_text', true );   
        $filter_top_rated  		= \ReviewX_Helper::get_post_meta( $reviewx_id, 'filter_rating', true );  
        $filter_low_rated       = \ReviewX_Helper::get_post_meta( $reviewx_id, 'filter_low_rating', true );   

        $post_id                = $reviewx_shortcode['rx_product_id'];                                 
        $rx_total_reviewer      = rx_total_reviewer_free( $post_id, '' ); 
    }                         
    ?>
    <?php if( $reviewx_shortcode['rx_filter'] == 'on' || $reviewx_shortcode['rx_filter'] != 'off' ) { ?>    
	<div class="rx-filter-bar">
		<div class="rx_filter_header">
            <h4>
                <?php 
                    if( $rx_total_reviewer > 0 ) {
                        printf( sprintf( __( 'Reviewed by %02d customer(s)', 'reviewx' ), $rx_total_reviewer ) ); 
                    } else {
                        printf( sprintf( __( 'Reviewed by %d customer(s)', 'reviewx' ), $rx_total_reviewer ) ); 
                    }                        
                ?>
            </h4>
        </div>  
             
        <?php if( $filter_recent == 1 || $filter_photo == 1 || $filter_text == 1 || $filter_top_rated == 1 || $filter_low_rated == 1 ) { ?>
		<div class="rx-short-by">
			<h4><?php echo ! empty(get_theme_mod('reviewx_sort_by_label') ) ? get_theme_mod('reviewx_sort_by_label') : __( 'Sort by', 'reviewx' ); ?></h4>
			<div class="rx_review_shorting_2">
				<div class="box">
					<select class="rx_shorting" name="rx_shorting">
                        <?php if( $filter_recent == 1 ) { ?>
						<option value="recent"><?php echo __( 'Recent Review', 'reviewx' ); ?></option>
                        <?php } ?>
						<?php if( $allow_img_filter == 1 && $filter_photo == 1) { ?>                                
							<option value="photo" <?php if($reviewx_shortcode['rx_sort_by'] == 'photo'){ echo "selected=selected"; } ?>><?php echo __( 'Photo Review', 'reviewx' ); ?></option>
                        <?php } ?>
                        <?php if( $filter_text == 1 ) { ?>
                        <option value="text" <?php if($reviewx_shortcode['rx_sort_by'] == 'text'){ echo "selected=selected"; } ?>><?php echo __( 'Text Review', 'reviewx' ); ?></option>
                        <?php } ?>
                        <?php if( $filter_top_rated == 1 ) { ?>
                        <option value="rating" <?php if($reviewx_shortcode['rx_sort_by'] == 'top'){ echo "selected=selected"; } ?>><?php echo __( 'Top Rated', 'reviewx' ); ?></option>
                        <?php } ?>
                        <?php if( $filter_low_rated == 1 ) { ?>
                        <option value="low"><?php echo __( 'Low Rated', 'reviewx' ); ?></option>
                        <?php } ?>  
                    </select> 
                    <span class="rx-selection-arrow"><b></b></span>
				</div>
			</div>		
        </div>  
        <?php } ?>     
    </div>
    <?php } ?>

    <input type="hidden" name="rx-sort-nonce" class="rx-sort-nonce" value="<?php echo wp_create_nonce( "special-string" ); ?>">
    <input type="hidden" class="rx_product_id" name="rx_product_id" value="<?php echo esc_attr( $reviewx_shortcode['rx_product_id'] ); ?>"> 
    <input type="hidden" class="rx-product-rating" name="rx-product-rating" id="rx-product-rating" value="<?php echo esc_attr( $reviewx_shortcode['rx_rating'] ); ?>"> 
    <input type="hidden" name="rx-sorting-post-type" class="rx-sorting-post-type" id="rx-sorting-post-type" value="<?php echo esc_attr( $reviewx_shortcode['rx_post_type'] ); ?>">
    <input type="hidden" name="rx-product-title" class="rx-product-title" id="rx-product-title" value="<?php echo esc_attr( $reviewx_shortcode['rx_post_title'] ); ?>">
    <?php if ( is_user_logged_in() ) { ?>
    <input type="hidden" name="rx-user-id" class="rx-user-id" id="rx-user-id" value="<?php echo get_current_user_id(); ?>">                    
    <?php } ?>    
    
    <div class="rx_review_sort_list">
    <?php                         
        $comments           = get_comments($args);
        if( count( $comments ) ) { 
        ?>
        <!--- Start spinner -->
        <div class="rx_content_loader">
            <div class="rx_double_spinner">
                <div></div>
                <div>
                    <div></div>
                </div>
            </div>
        </div>		
        <!--- End spinner -->	

        <div class="rx_listing_container rx_listing_container_style_1">
            <div class="rx_listing_style_1">
                <ul class="rx_listing" id="rx-commentlist">
                    <?php
                        foreach ($comments as $comment) {
                            $comment_gallery_meta       = get_comment_meta( $comment->comment_ID, 'reviewx_attachments', true );
                            $get_rating                 = get_comment_meta( $comment->comment_ID, 'rating', true );
                            $verified_wc_review 	    = \ReviewX_Helper::wc_review_is_from_verified_owner ( $comment->comment_ID, $post_id );
                            $get_review_title           = get_comment_meta( $comment->comment_ID, 'reviewx_title', true );
                        ?>
                        <li class="review rx_review_block rx-pagination-item" id="li-comment-<?php echo esc_attr( $comment->comment_ID ); ?>">
                            <div class="rx_flex rx_review_wrap">
                                <div class="rx_author_info">
                                    <div class="rx_thumb">
                                        <?php 
                                            //Retrive comment author gravatar                     
                                            echo get_avatar( $comment, apply_filters( 'woocommerce_review_gravatar_size', '70' ), '' );                                                
                                        ?>                     
                                    </div>
                                    <div class="rx_author_name">
                                        <h4><?php echo esc_html( $comment->comment_author ); ?></h4>
                                    </div>                    
                                </div>
                                <div class="rx_body">
                                    <div class="rx_flex rx_rating_section">
                                        <?php if ( '0' === $comment->comment_approved ) { ?>
                                            <div class="rx_approval_notice">
                                                <em><svg width="18" height="18" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1152 1376v-160q0-14-9-23t-23-9h-96v-512q0-14-9-23t-23-9h-320q-14 0-23 9t-9 23v160q0 14 9 23t23 9h96v320h-96q-14 0-23 9t-9 23v160q0 14 9 23t23 9h448q14 0 23-9t9-23zm-128-896v-160q0-14-9-23t-23-9h-192q-14 0-23 9t-9 23v160q0 14 9 23t23 9h192q14 0 23-9t9-23zm640 416q0 209-103 385.5t-279.5 279.5-385.5 103-385.5-103-279.5-279.5-103-385.5 103-385.5 279.5-279.5 385.5-103 385.5 103 279.5 279.5 103 385.5z"/></svg> <?php esc_html_e('Your review is awaiting for approval', 'reviewx' ); ?></em>
                                            </div>
                                        <?php } ?>  							
                                        <div class="review_rating">
                                            <?php echo reviewx_show_star_rating( $get_rating ); ?>  
                                        </div>
                                    </div>

                                    <?php
                                        // Display title
                                        if( ! empty( $get_review_title ) ) {
                                            ?>
                                            <h4 class="review_title"><?php echo html_entity_decode( $get_review_title ); ?></h4>
                                            <?php
                                        }
                                    ?>                    					
                                    <?php comment_text($comment); ?>
                                    
                                    <div class="rx_flex rx_varified">
                                        <div class="rx_review_calender">
                                            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                viewBox="-49 141 512 512" style="enable-background:new -49 141 512 512;" xml:space="preserve">
                                                <g>
                                                    <path class="st0" d="M383,161h-10.8H357h-40h-91h-40H96H56h-7.8H31c-44.1,0-80,35.9-80,80v312c0,44.1,35.9,80,80,80h352
                                                    c42.1,0,76.7-32.7,79.8-74c0.1-1,0.2-2,0.2-3V241C463,196.9,427.1,161,383,161z M423,553c0,22.1-17.9,40-40,40H31
                                                    c-22.1,0-40-17.9-40-40V241c0-22.1,17.9-40,40-40h25v20c0,11,9,20,20,20s20-9,20-20v-20h90v20c0,11,9,20,20,20s20-9,20-20v-20h91
                                                    v20c0,11,9,20,20,20c11,0,20-9,20-20v-20h26c22.1,0,40,17.9,40,40V553z"/>
                                                    <circle class="st0" cx="76" cy="331" r="20"/>
                                                    <circle class="st0" cx="250" cy="331" r="20"/>
                                                    <circle class="st0" cx="337" cy="331" r="20"/>
                                                    <circle class="st0" cx="76" cy="418" r="20"/>
                                                    <circle class="st0" cx="76" cy="505" r="20"/>
                                                    <circle class="st0" cx="163" cy="331" r="20"/>
                                                    <circle class="st0" cx="163" cy="418" r="20"/>
                                                    <circle class="st0" cx="163" cy="505" r="20"/>
                                                    <circle class="st0" cx="250" cy="418" r="20"/>
                                                    <circle class="st0" cx="337" cy="418" r="20"/>
                                                    <circle class="st0" cx="250" cy="505" r="20"/>
                                                </g>
                                            </svg>
                                            <span> <?php echo date_i18n(get_option('date_format'), strtotime($comment->comment_date)); ?></span>
                                        </div>
                                        <?php if( $verified_wc_review ) { ?>
                                        <div class="rx_varified_user">
                                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                viewBox="0 0 80 80" style="enable-background:new 0 0 80 80;" xml:space="preserve">
                                                <style type="text/css">
                                                    .st1{fill:#FFFFFF;}
                                                </style>
                                                <circle class="st0" cx="40" cy="40" r="40"/>
                                                <path class="st1" d="M20.4,41.1c0-0.3,0.1-0.7,0.3-1c0.5-1.1,1.5-1.9,2.5-2.7c1.2-1,2.7-0.7,3.9,0.4c2.1,2.1,4.2,4.2,6.3,6.3
                                                c0.2,0.2,0.3,0.4,0.5,0.6c0.3-0.3,0.5-0.5,0.7-0.7c6-6,11.9-11.9,17.9-17.9c1.7-1.7,3.3-1.7,4.9,0c0.7,0.8,1.3,1.6,1.9,2.5
                                                c0.8,1.2,0.1,1.8-1.6,3.5c-7.3,7.4-14.7,14.7-22,22c-1.3,1.3-2.3,1.3-3.6,0c-3.4-3.4-6.9-6.8-10.2-10.3
                                                C20.5,42.4,20.3,41.7,20.4,41.1z"/>
                                            </svg>
                                            <span><?php esc_html_e( 'Verified Purchase', 'reviewx' ); ?></span>
                                        </div>
                                        <?php } ?>  
                                        <?php if( $reviewx_shortcode['rx_post_title'] == 'on') { ?>
                                        <div class="rx_review_product">
                                            <?php echo __('Review on:', 'reviewx'); ?> 
                                            <a href="<?php echo esc_url(get_permalink($comment->comment_post_ID)); ?>" target="_blank"> <?php echo get_the_title($comment->comment_post_ID); ?></a>
                                        </div> 
                                        <?php } ?>                                                                 
                                    </div>						

                                    <?php                                    
                                        if( $allow_img_filter == 1 ) { ?>
                                        <div class="rx_flex rx_photos" <?php echo ($review_style == "review_style_one") ? 'style="justify-content: flex-end"' : ' '; ?>>
                                        <?php
                                            if( ! empty( $comment_gallery_meta ) && array_key_exists('images', $comment_gallery_meta) && count($comment_gallery_meta['images']) ) {
                                                $full_img_url   = wp_get_attachment_image_src( $comment_gallery_meta['images'][0], 'full' );
                                                $img_url        = wp_get_attachment_image_src( $comment_gallery_meta['images'][0] );
                                                ?>								
                                                <div class="rx_photo">
                                                    <div class="popup-link">
                                                        <a href="<?php echo esc_url( $full_img_url[0] ); ?>">
                                                            <img src="<?php echo esc_url( $img_url[0] ); ?>"  class="img-fluid" alt="<?php echo esc_attr( $comment_gallery_meta['images'][0] ); ?>">
                                                        </a>
                                                    </div>                
                                                </div>                                 			
                                                <?php
                                            } ?>
                                        </div>
                                        <?php
                                        }
                                    ?>
                                </div>
                            </div>
                        </li>
                        <?php
                        }
                    ?>
                </ul>
            </div>
        </div>                          
        <?php 
            if( $reviewx_shortcode['rx_pagination'] == 'on' || $reviewx_shortcode['rx_pagination'] != 'off' ) {
                if( isset($reviewx_shortcode['rx_per_page']) ) {
                    $review_per_page = intval($reviewx_shortcode['rx_per_page']);
                }      
        ?>  
        <input type="hidden" id="rx-total-review" value="<?php echo \ReviewX_Helper::get_total_review( $post_id, $reviewx_shortcode['rx_post_type'], $reviewx_shortcode['rx_sort_by'], $reviewx_shortcode['rx_rating'], get_current_user_id() ); ?>">                         
        <input type="hidden" id="rx-pagination-limit" value="<?php echo esc_attr( $review_per_page ); ?>">
        <?php
            }
        } else {

            echo '<div class="rx_no_review">';
            if( $args['tag'] == "photo" ) {
                echo esc_html__( 'There is no photo review yet.', 'reviewx' );
            } else if( $args['tag'] == "text" ) {
                echo esc_html__( 'There is no text review yet.', 'reviewx' );
            } else {
                echo esc_html__( 'There is no text review yet.', 'reviewx' );
            }
            echo '</div>';
        
        } 
    ?>   
    </div> 
    <input type="hidden" name="rx-allow-shortcode-pagination" class="rx-allow-shortcode-pagination" id="rx-allow-shortcode-pagination" value="<?php echo $reviewx_shortcode['rx_pagination']; ?>">   
