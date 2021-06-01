<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function reviewx_review_filter_query_html( $args ) {

	if( \ReviewX_Helper::check_post_type_availability( $args['post_type'] ) == TRUE ) {

		$reviewx_id 		= \ReviewX_Helper::get_reviewx_post_type_id( $args['post_type'] );
		$settings   		= \ReviewX\Controllers\Admin\Core\ReviewxMetaBox::get_metabox_settings( $reviewx_id );
		$review_per_page    = isset($args['number']) ? $args['number'] : $settings->review_per_page;
		$allow_img    		= $settings->allow_img;
		$review_style    	= $settings->review_style;
		
	} else if( $args['post_type'] == 'product' ) {

		$settings           = \ReviewX\Controllers\Admin\Core\ReviewxMetaBox::get_option_settings();
		$review_per_page    = isset($args['number']) ? $args['number'] : $settings->review_per_page;
		$review_style    	= $settings->review_style;
		$allow_img          = get_option( '_rx_option_allow_img' );	
		
	}
	
	$comments           = get_comments($args);
	if( count( $comments ) ) { ?>
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
	<?php
        echo '<div class="rx_listing_container rx_listing_container_style_1">';
        echo '<div class="rx_listing_style_1">';
        echo '<ul class="rx_listing" id="rx-commentlist">';
        foreach ($comments as $comment) {
            $comment_gallery_meta       = get_comment_meta( $comment->comment_ID, 'reviewx_attachments', true );
            $get_rating                 = get_comment_meta( $comment->comment_ID, 'rating', true );
			$verified_wc_review 	    = \ReviewX_Helper::wc_review_is_from_verified_owner ( $comment->comment_ID, $args['post_id'] );
			$get_review_title           = get_comment_meta( $comment->comment_ID, 'reviewx_title', true );
	
            ?>
			<li class="review rx_review_block rx-pagination-item" id="li-comment-<?php echo esc_attr( $comment->comment_ID ); ?>">
				<div class="rx_flex rx_review_wrap">
					<div class="rx_author_info">
						<div class="rx_thumb">
							<?php 
								//Retrive comment author gravatar                     
								\ReviewX_Helper::get_gravatar( $comment, $args['post_type'] );                                               
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
							<?php if( isset($args['post_title']) && $args['post_title'] == 'on' ) { ?>
								<div class="rx_review_product">
									<?php echo __('Review on:', 'reviewx'); ?> 
									<a href="<?php echo esc_url(get_permalink($comment->comment_post_ID)); ?>" target="_blank"> <?php echo get_the_title($comment->comment_post_ID); ?></a>
								</div> 							
							<?php } ?>                          
						</div>						

						<?php                                    
							if( $allow_img == 1 ) { ?>
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
        echo '</ul>';
        echo '</div>';
		echo '</div>';
		//Check pagination on/off from shortcode, by default it is on for product single page 
		if( isset($args['pagination']) && ($args['pagination'] == 'on' ||  $args['pagination'] != 'off' || $args['pagination'] == '') ) {
				$paged = isset( $args['paged'] ) ? $args['paged'] : 1; 
			?>
			<input type="hidden" id="rx-total-review" value="<?php echo esc_attr( $args['total_review'] ); ?>">
			<script>
				jQuery(document).ready(function($){
					let total_reviews = $('#rx-total-review').val();	
					let rx_pagination_limit  = $("#rx-pagination-limit").val();
					if( rx_pagination_limit == '' || rx_pagination_limit == undefined || rx_pagination_limit == null ) {
						rx_pagination_limit = 20;
					}
					rx_pagination_limit 	 = parseInt(rx_pagination_limit);
					let perPage 			 = Math.ceil(total_reviews / rx_pagination_limit);	
					let limitPagination      = 5;
					if( limitPagination > perPage ) {
						limitPagination = perPage;
					}				
					if(total_reviews > rx_pagination_limit ) {
						$('#rx-commentlist').paginathing({
							totalItems: total_reviews,
							perPage: rx_pagination_limit,
							limitPagination: limitPagination,
							page:<?php echo $paged; ?>,
							pageNumbers: true						
						});
					}
				});
			</script>
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

	echo '<input type="hidden" id="rx-pagination-limit" value="'.esc_attr( $review_per_page ).'">';
}