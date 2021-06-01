<?php
if( ! defined( 'ABSPATH' ) ) {
	exit();
}
?>

<div id="reviews" class="rx_review_summery_block">
	<div class="rx-reviewbox">
		<div class=" rx-flex-grid-container">
            <div class="rx-flex-grid-50 rx_recommended_wrapper">
                <div class="rx-temp-rating ">
                    <div class="rx_average_rating">
                        <div class="rx-temp-rating-number">
                            <p class="temp-rating_avg"><?php echo esc_html( $rx_count_total_rating_avg ); ?></p><span class="temp-rating_5-star">/<?php esc_html_e('5', 'reviewx' );?></span>
                        </div>
                        <div class="rx-temp-rating-star">
                            <?php echo reviewx_show_star_rating( $rx_count_total_rating_avg ); ?>
                        </div>
                    </div>
                    <div class="rx-temp-total-rating-count">
                        <p> <?php echo sprintf( __('Based on %d rating(s)', 'reviewx' ), $rx_total_rating_count ); ?> </p>
                    </div>
                </div>

                <?php if( $allow_recommendation == 1 ) { ?>
                    <hr>
                    <div class="rx_recommended_box">
                        <div class="rx_recommended_icon_box">
                            <div class="rx_recommended_icon">
                                <img src="<?php echo esc_url( plugins_url( '/', __FILE__ ) . '../../../resources/assets/storefront/images/recommendation_icon.png' ); ?>">
                            </div>
                        </div>
                        <div class="rx_recommended_box-right">
                            <p class="rx_recommended_box_content">
                                <?php  if( get_post_type( $prod_id ) == 'product' ) { ?>
                                    <span class="rx_recommended_box_heading">
                                        <?php
											if( reviewx_product_recommendation_count( $prod_id ) > 0 ){
												echo sprintf("%02d", reviewx_product_recommendation_count( $prod_id ));
											} else {
												echo sprintf("%d", reviewx_product_recommendation_count( $prod_id ));
											}
										?>                                        
                                    </span>                                
                                    <?php echo ! empty(get_theme_mod('reviewx_customer_recommendation_label') ) ? get_theme_mod('reviewx_customer_recommendation_label') : __( 'Customer(s) recommended this item', 'reviewx' ); ?>
                                <?php } else if( \ReviewX_Helper::check_post_type_availability( get_post_type( $prod_id ) ) == TRUE ) { ?>
                                    <?php echo __( 'Recommended by ', 'reviewx' ); ?>
                                    <?php
                                        if( reviewx_product_recommendation_count( $prod_id ) > 0 ){
                                            echo sprintf("%02d", reviewx_product_recommendation_count( $prod_id ));
                                        } else {
                                            echo sprintf("%d", reviewx_product_recommendation_count( $prod_id ));
                                        }
                                    ?> 
                                    <?php echo __( ' reviewer(s)', 'reviewx' ); ?>
                                <?php } ?>                                                                
                            </p>
                        </div>
                    </div>
                <?php } ?>
            </div>

			<!-- Start review chart -->
			<div class="rx-flex-grid-50 stfn_rate rx_rating_graph_wrapper">
				<div class="rx-horizontal flat rx-graph-style-2">
                    <?php
                        if( \ReviewX_Helper::is_multi_criteria( get_post_type( $prod_id ) ) ) {
                            foreach ( $cri as $key => $single_criteria ) {
                                $percentage = intval( round( ($criteria_arr[$key] / $criteria_count[$key])*100/5 ) );
                                ?>
                                <div class="progress-bar">
                                    <span class="progress-bar-t"><?php echo esc_html( str_replace( '-', ' ', $single_criteria ) ); ?></span>
                                    <div class="progress-track">
                                        <div class="rx_style_one_progress orange">
                                            <?php if( $percentage > 0 ) : ?>
                                                <div class="rx_style_one_progress-bar" style="width: <?php echo esc_attr($percentage); ?>%; height: 100%;">
                                                    <span class="rx_style_one_progress-icon">
                                                        <img src="<?php echo esc_url( plugins_url( '/', __FILE__ ) . '../../../resources/assets/storefront/images/rocket.svg' ); ?>" class="img-fluid">
                                                    </span>
                                                    <div class="rx_style_one_progress-value"><span><?php echo esc_attr($percentage); ?></span>%</div>
                                                </div>
                                            <?php  else: ?>
                                                <div class="rx_style_one_progress-bar" style="width: 100%; height: 100%;">
                                                    <span class="rx_style_one_progress-icon">
                                                        <img src="<?php echo esc_url( plugins_url( '/', __FILE__ ) . '../../../resources/assets/storefront/images/rocket.svg' ); ?>" class="img-fluid">
                                                    </span>
                                                    <div class="rx_style_one_progress-value"><span><?php echo __( '100', 'reviewx' ); ?></span>%</div>
                                                </div>
                                            <?php endif; ?>                                        
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                        } else { 
                            $rating_info = \ReviewX_Helper::total_rating_count($prod_id);
                            rsort($rating_info['rating_count']);
                            foreach( $rating_info['rating_count'] as $rt ){
                                $percentage = \ReviewX_Helper::get_percentage($rating_info['review_count'][0]->total_review, isset($rt['total_review'])?$rt['total_review']:0);
                            ?>
                                <div class="progress-bar">
                                    <span class="progress-bar-t"><?php printf( __( '%s Star', 'reviewx' ), round( $rt['rating'] ) ); ?></span>
                                    <div class="progress-track rx-tooltip" data-rating="<?php echo esc_attr( round( $rt['rating'] ) ); ?>">
                                        <div class="rx_style_one_progress orange">
                                            <div class="rx_style_one_progress-bar" style="width: <?php echo esc_attr($percentage); ?>%; height: 100%;">
                                                <span class="rx_style_one_progress-icon">
                                                    <img src="<?php echo esc_url( plugins_url( '/', __FILE__ ) . '../../../resources/assets/storefront/images/rocket.svg' ); ?>" class="img-fluid">
                                                </span>
                                                <div class="rx_style_one_progress-value"><span><?php echo esc_attr($percentage); ?></span>%</div>
                                            </div>
                                        </div>
                                        <span class="rx-tooltiptext"><?php echo sprintf( __('%d review(s)', 'reviewx' ), isset($rt['total_review'])?$rt['total_review']:0 ); ?></span>
                                    </div>
                                </div>                            
                            <?php    
                            }
                        } 
                    ?>
				</div>
			</div>
		</div>
	</div>
</div>