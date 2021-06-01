<div class="rx_review_summery_block">
    <div class="rx-reviewbox">
        <div class=" rx-flex-grid-container">
            <div class="rx-flex-grid-100 rx_recommended_wrapper">
                <div class="rx-temp-rating ">
                    <div class="rx_average_rating">
                        <div class="rx-temp-rating-number">
                            <p class="temp-rating_avg"><?php echo $data['rx_count_total_rating_avg']; ?></p><span class="temp-rating_5-star">/<?php esc_html_e('5', 'reviewx');?></span>
                        </div>
                        <div class="rx-temp-rating-star">
                            <?php echo reviewx_show_star_rating( $data['rx_count_total_rating_avg'] ); ?>
                        </div>
                    </div>
                    <div class="rx-temp-total-rating-count">
                        <p> <?php echo sprintf( __('Based on %d rating(s)', 'reviewx' ), $data['rx_total_rating_count'] ); ?> </p>
                    </div>
                </div>
                <?php if( $data['allow_recommendation'] == 1 ) { ?>
                <hr>
                <div class="rx_recommended_box">
                    <div class="rx_recommended_icon_box">
                    <div class="rx_recommended_icon">
                        <?php 
                            $recommended_icon = get_option('_rx_option_recommend_icon_upload');
                            if( ! empty($recommended_icon) && class_exists('ReviewXPro') ) {
                        ?>
                            <img src="<?php echo esc_url( $recommended_icon ); ?>" alt="<?php esc_attr_e( 'ReviewX', 'reviewx'); ?>">
                        <?php } else { ?>
                            <img src="<?php echo esc_url( plugins_url( '/', __FILE__ ) . '../../../resources/assets/storefront/images/recommendation_icon.png' ); ?>" alt="<?php esc_attr_e( 'ReviewX', 'reviewx'); ?>">
                        <?php } ?>
                    </div>
                    </div>
                    <div class="rx_recommended_box-right">
                        <p class="rx_recommended_box_content">
                            <span class="rx_recommended_box_heading">
                                <?php
                                    if( reviewx_product_recommendation_count( $atts['product_id'] ) > 0 ){
                                        echo sprintf("%02d", reviewx_product_recommendation_count( $atts['product_id'] ));
                                    } else {
                                        echo sprintf("%d", reviewx_product_recommendation_count( $atts['product_id'] ));
                                    }
                                ?>
                            </span>
                            <?php  if( get_post_type( $atts['product_id'] ) == 'product' ) { ?>
                                <?php echo ! empty(get_theme_mod('reviewx_customer_recommendation_label') ) ? get_theme_mod('reviewx_customer_recommendation_label') : __( 'Customer(s) recommended this item', 'reviewx' ); ?>
                            <?php } else if( \ReviewX_Helper::check_post_type_availability( get_post_type( $atts['product_id'] ) ) == TRUE ) { ?>
                                <?php echo __( 'Reviewer(s) recommended this item', 'reviewx' ); ?>
                            <?php } ?> 
                        </p>
                    </div>
                </div>
                
                <?php } ?>
            </div>
        </div>
    </div>
</div>