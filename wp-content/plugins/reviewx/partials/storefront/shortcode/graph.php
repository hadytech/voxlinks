<div class="rx_review_summery_block">
    <div class="rx-reviewbox">
        <div class=" rx-flex-grid-container">
            <!-- Start review chart 55 -->
            <div class="rx-flex-grid-100 stfn_rate rx_rating_graph_wrapper">
                <?php 
                $criteria_arr   = $data['criteria_arr'];
                $criteria_count = $data['criteria_count'];
                if( $data['template'] == 'graph_style_default' ) { ?>
                <div class="rx-horizontal flat rx-graph-style-2">
                <?php if( \ReviewX_Helper::is_multi_criteria( get_post_type( $data['prod_id'] ) ) ) { ?>
                    <?php 
                    foreach ( $data['cri'] as $key => $single_criteria ) {
                        $percentage = intval( round( ($criteria_arr[$key] / $criteria_count[$key])*100/5 ) );
                    ?>
                    <div class="progress-bar">
                        <span class="progress-bar-t"><?php echo esc_html( str_replace( '-', ' ', $single_criteria ) ); ?></span>
                        <div class="progress-track">
                            <div class="progress-fill">
                                <?php if( $percentage > 0 ) : ?>
                                <span><?php echo intval( round( ($criteria_arr[$key] / $criteria_count[$key])*100/5 ) ); ?>%</span>
                                <?php  else: ?>
                                    <span>100%</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>                   
                <?php } else { 
                        $rating_info = \ReviewX_Helper::total_rating_count($data['prod_id']);
                        rsort($rating_info['rating_count']);
                        foreach( $rating_info['rating_count'] as $rt ) {                                
                            $percentage = \ReviewX_Helper::get_percentage($rating_info['review_count'][0]->total_review, $rt['total_review']);                       
                        ?>
                            <div class="progress-bar">
                                <span class="progress-bar-t"><?php printf( __( '%s Star', 'reviewx' ), round( $rt['rating'] ) ); ?></span>
                                <div class="progress-track">
                                    <div class="progress-fill">
                                        <span><?php echo esc_attr($percentage); ?>%</span>
                                    </div>
                                </div>
                            </div>                            
                        <?php    
                        }                
                    } ?>                            
                </div>    
                <?php } else if( $data['template'] == 'graph_style_two_free' ) { ?>
                <div class="rx-horizontal flat rx-graph-style-2">
                    <?php if( \ReviewX_Helper::is_multi_criteria( get_post_type( $data['prod_id'] ) ) ) { ?>
                        <?php 
                            foreach ( $data['cri'] as $key => $single_criteria ) {
                                $percentage = intval( round( ($criteria_arr[$key] / $criteria_count[$key])*100/5 ) );
                            ?>
                            <div class="rx_style_two_free_progress_bar">
                                <h3 class="progressbar-title"><?php echo esc_html( str_replace( '-', ' ', $single_criteria ) ); ?></h3>
                                <div class="progress">
                                    <?php if( $percentage > 0 ) : ?>
                                        <div class="progress-bar" style="width: <?php echo intval( round( ($criteria_arr[$key] / $criteria_count[$key])*100/5 ) ); ?>%;">
                                            <span><?php echo intval( round( ($criteria_arr[$key] / $criteria_count[$key])*100/5 ) ); ?> %</span>
                                        </div>
                                    <?php  else: ?>
                                        <div class="progress-bar" style="width: 100%;">
                                            <span><?php echo __('100', 'reviewx');?>%</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div> 
                        <?php } ?>                    
                    <?php } else { 

                        $rating_info = \ReviewX_Helper::total_rating_count($data['prod_id']);
                        rsort($rating_info['rating_count']);
                        foreach( $rating_info['rating_count'] as $rt ){
                            $percentage = \ReviewX_Helper::get_percentage($rating_info['review_count'][0]->total_review, $rt['total_review']);
                        ?>
                        <div class="rx_style_two_free_progress_bar">
                            <h3 class="progressbar-title"><?php printf( __( '%s Star', 'reviewx' ), round( $rt['rating'] ) ); ?></h3>
                            <div class="progress">
                                <div class="progress-bar" style="width: <?php echo esc_attr($percentage); ?>%;">
                                    <span><?php echo esc_attr($percentage); ?> %</span>
                                </div>
                            </div>
                        </div>
                        <?php    
                        }
                    } ?>                              
                </div>   
                <?php } else if( $data['template'] == 'graph_style_one' ) { ?> 
                <div class="rx-horizontal flat rx-graph-style-2">
                    <?php if( \ReviewX_Helper::is_multi_criteria( get_post_type( $data['prod_id'] ) ) ) { ?>
                    <?php 
                    foreach ( $data['cri'] as $key => $single_criteria ) {
                        $percentage = intval( round( ($criteria_arr[$key] / $criteria_count[$key])*100/5 ) );
                    ?>
                    <div class="progress-bar">
                        <span class="progress-bar-t"><?php echo esc_html( str_replace( '-', ' ', $single_criteria ) ); ?></span>
                        <div class="progress-track">
                            <div class="rx_style_one_progress orange">
                                <?php if( $percentage > 0 ) : ?>
                                    <div class="rx_style_one_progress-bar" style="width: <?php echo intval( round( ($criteria_arr[$key] / $criteria_count[$key])*100/5 ) ); ?>%; height: 100%;">
                                        <span class="rx_style_one_progress-icon">
                                            <img src="<?php echo esc_url( plugins_url( '/', __FILE__ ) . '../../../resources/assets/storefront/images/rocket.svg' ); ?>" class="img-fluid">
                                        </span>
                                        <div class="rx_style_one_progress-value"><span><?php echo intval( round( ($criteria_arr[$key] / $criteria_count[$key])*100/5 ) ); ?></span>%</div>
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
                        $rating_info = \ReviewX_Helper::total_rating_count($data['prod_id']);
                        rsort($rating_info['rating_count']);
                        foreach( $rating_info['rating_count'] as $rt ){
                            $percentage = \ReviewX_Helper::get_percentage($rating_info['review_count'][0]->total_review, $rt['total_review']);
                        ?>
                            <div class="progress-bar">
                                <span class="progress-bar-t"><?php printf( __( '%s Star', 'reviewx' ), round( $rt['rating'] ) ); ?></span>
                                <div class="progress-track">
                                    <div class="rx_style_one_progress orange">
                                        <div class="rx_style_one_progress-bar" style="width: <?php echo esc_attr($percentage); ?>%; height: 100%;">
                                            <span class="rx_style_one_progress-icon">
                                                <img src="<?php echo esc_url( plugins_url( '/', __FILE__ ) . '../../../resources/assets/storefront/images/rocket.svg' ); ?>" class="img-fluid">
                                            </span>
                                            <div class="rx_style_one_progress-value"><span><?php echo esc_attr($percentage); ?></span>%</div>
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                        <?php    
                        }    
                    } 
                    ?>                              
                </div>   
                <?php } else if( $data['template'] == 'graph_style_three' ) { 
                    
                    echo apply_filters( 'rx_load_shortcode_graph_template', $data ); 

                } else { ?>
                    <div class="rx-horizontal flat rx-graph-style-2">
                        <?php 
                        foreach ( $data['cri'] as $key => $single_criteria ) {
                            $percentage = intval( round( ($criteria_arr[$key] / $criteria_count[$key])*100/5 ) );
                        ?>
                        <div class="progress-bar">
                            <span class="progress-bar-t"><?php echo esc_html( str_replace( '-', ' ', $single_criteria ) ); ?></span>
                            <div class="progress-track">
                                <div class="progress-fill">
                                    <?php if( $percentage > 0 ) : ?>
                                    <span><?php echo intval( round( ($criteria_arr[$key] / $criteria_count[$key])*100/5 ) ); ?>%</span>
                                    <?php  else: ?>
                                        <span>100%</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php } ?>                               
                    </div>                
                <?php } ?>    
            </div>
        </div>
    </div>
</div>