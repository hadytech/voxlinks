
<div class="row rx-form rx_myaccount-review_form hide" id="rx-form">

    <div class="rx-flex-container">
        <a href="#" class="rx-cancel rx-form-btn rv-btn">
            <svg style="width: 12px; vertical-align: middle" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="home" class="svg-inline--fa fa-home fa-w-18" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M280.37 148.26L96 300.11V464a16 16 0 0 0 16 16l112.06-.29a16 16 0 0 0 15.92-16V368a16 16 0 0 1 16-16h64a16 16 0 0 1 16 16v95.64a16 16 0 0 0 16 16.05L464 480a16 16 0 0 0 16-16V300L295.67 148.26a12.19 12.19 0 0 0-15.3 0zM571.6 251.47L488 182.56V44.05a12 12 0 0 0-12-12h-56a12 12 0 0 0-12 12v72.61L318.47 43a48 48 0 0 0-61 0L4.34 251.47a12 12 0 0 0-1.6 16.9l25.5 31A12 12 0 0 0 45.15 301l235.22-193.74a12.19 12.19 0 0 1 15.3 0L530.9 301a12 12 0 0 0 16.9-1.6l25.5-31a12 12 0 0 0-1.7-16.93z"></path></svg>
            <?php esc_html_e( 'Go Back', 'reviewx' ); ?>
        </a>
    </div>
    <div class="rx-flex-grid-container rx_short_summery_wrap">
        <div class="rx-flex-grid-33 rx_short_summery_img_wrap">
            <a id="prod-link" href="" target="_blank">
                <img src="" id="img-thumb" class="rv-thumb">
            </a>
        </div>

        <div class="rx-flex-grid-66 short_summary">
            <table class="responstable order_summery table table-striped table-dark">
                <tbody>
                <tr>
                    <td style="width: 30%;"><?php esc_html_e( 'Order No:', 'reviewx' ); ?> </td>
                    <td style="width: 70%;" scope="row">
                        <?php esc_html_e( '#', 'reviewx' ); ?><span id="prod-order"></span>
                    </td>
                </tr>
                <tr>
                    <td style="width: 30%;"><?php esc_html_e( 'Order Status:', 'reviewx' ); ?></td>
                    <td style="width: 70%;" scope="row">"<span id="prod-order-status"></span>"</td>
                </tr>
                <tr>
                    <td style="width: 30%;"><?php esc_html_e( 'Item:', 'reviewx' ); ?></td>
                    <td style="width: 70%;" scope="row"><a id="prod-url" href="" target="_blank"><span id="prod-name"></span></a></td>
                </tr>
                <tr>
                    <td style="width: 30%;"><?php esc_html_e( 'Quantity:', 'reviewx' ); ?></td>
                    <td style="width: 70%;" scope="row"><span id="prod-qty"></span>&nbsp;<span><?php esc_html_e( 'pc(s)', 'reviewx' ); ?></span></td>
                </tr>
                <tr>
                    <td style="width: 30%;"><?php esc_html_e( 'Price:', 'reviewx' ); ?></td>
                    <td style="width: 70%;" scope="row" id="prod-price"></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="rx-review-form">
        <form id="rx-my-account-review-form" action="" method="post">
            <fieldset>
                <div class="form-row">
                    <div class="rx-form-group rx-flex-grid-100 rv-t">
                        <h2><?php echo ! empty(get_theme_mod('reviewx_form_title_label') ) ? get_theme_mod('reviewx_form_title_label') : esc_html__( 'Leave feedback about this', 'reviewx' ); ?></h2>
                        <?php if( is_array( $review_criteria ) && count( $review_criteria ) != 0 ) { ?>
                            <table class="rx-criteria-table reviewx-rating">
                                <tbody>
                                <?php
                                    echo apply_filters( 'rx_load_product_rating_type', $settings );
                                ?>
                                <tr>
                                    <td colspan=2 class="rx-error-td">
                                        <span class="rx-error" id="rx-rating-error"></span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        <?php } ?>
                    </div>

                    <?php if( $allow_review_title == 1 ){ ?>
                    <div class="rx_my_account_review_title rx-flex-grid-100">
                        <input type="text" id="reviewx_title" class="form-control review-box reviewx_title" name="reviewx_title" required placeholder="<?php esc_attr_e('Review title', 'reviewx'); ?>">
                        <span class="rx-error" id="rx-review-title-error"></span>
                    </div>
                    <?php } ?>

                    <div class="rx_my_account_review_content rx-form-group rx-flex-grid-100">
                        <textarea id="rx_text" class="form-control review-box rx-review-box" name="rx_text" aria-required="true" required placeholder="<?php esc_attr_e( 'Describe your review', 'reviewx' ); ?>"></textarea>                        
                        <span class="rx-error" id="rx-review-text-error"></span>
                    </div>

                    <?php
                    // Filter allow image
                    $allow_img_data['is_allow_img']      = $allow_img;
                    $allow_img_data['signature']         = 1;
                    apply_filters( 'rx_form_field_image', $allow_img_data );

                    // Filter allow video
                    $allow_video_data['is_allow_video']   = $allow_video;
                    $allow_video_data['video_source']     = $video_source;
                    $allow_video_data['signature']        = 1;
                    apply_filters( 'rx_allow_video_url', $allow_video_data);
                    ?>

                    <div class="rx-flex-grid-100 rv-t">
                        <?php if( $allow_recommendation == 1 ) { ?>
                            <div class="reviewx_recommended">
                                <h2><?php echo !empty(get_theme_mod('reviewx_form_recommednation_label') ) ? get_theme_mod('reviewx_form_recommednation_label') : __( 'Recommendation:', 'reviewx' ); ?></h2>
                                <div class="reviewx_recommended_list">
                                    <div class="reviewx_radio">
                                        <input id="recommend" name="rx-recommend-status" value="1" type="radio" checked="checked" >
                                        <label for="recommend" class="radio-label happy_face">
                                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                 viewBox="0 0 80 80" style="enable-background:new 0 0 80 80;" xml:space="preserve">
                                            <style type="text/css">
                                                .happy_st0{fill:#D0D6DC;}
                                                .happy_st1{fill:#6D6D6D;}
                                            </style>
                                                <g>
                                                    <radialGradient id="SVGID_1_" cx="40" cy="40" r="40" gradientUnits="userSpaceOnUse">
                                                        <stop  offset="0" style="stop-color:#62E2FF"/>
                                                        <stop  offset="0.9581" style="stop-color:#3593FF"/>
                                                    </radialGradient>
                                                    <path class="happy_st0 rx_happy" d="M40,0C18,0,0,18,0,40c0,22,18,40,40,40s40-18,40-40C80,18,62,0,40,0z M54,24c3.2,0,6,2.8,6,6c0,3.2-2.8,6-6,6
		                                    c-3.2,0-6-2.8-6-6C48,26.8,50.8,24,54,24z M26,24c3.2,0,6,2.8,6,6c0,3.2-2.8,6-6,6c-3.2,0-6-2.8-6-6C20,26.8,22.8,24,26,24z M40,64
		                                    c-10.4,0-19.2-6.8-22.4-16h44.8C59.2,57.2,50.4,64,40,64z"/>
                                                    <path class="happy_st1" d="M54,36c3.2,0,6-2.8,6-6c0-3.2-2.8-6-6-6c-3.2,0-6,2.8-6,6C48,33.2,50.8,36,54,36z"/>
                                                    <path class="happy_st1" d="M26,36c3.2,0,6-2.8,6-6c0-3.2-2.8-6-6-6c-3.2,0-6,2.8-6,6C20,33.2,22.8,36,26,36z"/>
                                                    <path class="happy_st1" d="M40,64c10.4,0,19.2-6.8,22.4-16H17.6C20.8,57.2,29.6,64,40,64z"/>
                                                </g>
                                        </svg>
                                        </label>
                                    </div>
                                    <div class="reviewx_radio">
                                        <input id="neutral" name="rx-recommend-status" value="0" type="radio">
                                        <label for="neutral" class="radio-label neutral_face">
                                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                 viewBox="0 0 80 80" style="enable-background:new 0 0 80 80;" xml:space="preserve">
                                            <style type="text/css">
                                                .st0{fill:#6D6D6D;}
                                                .st1{fill:#D1D7DD;}
                                            </style>
                                                <g>
                                                    <path class="st0" d="M54,36c3.2,0,6-2.8,6-6c0-3.2-2.8-6-6-6c-3.2,0-6,2.8-6,6C48,33.2,50.8,36,54,36z"/>
                                                    <path class="st0" d="M26,36c3.2,0,6-2.8,6-6c0-3.2-2.8-6-6-6c-3.2,0-6,2.8-6,6C20,33.2,22.8,36,26,36z"/>
                                                    <path class="st1" d="M40,0C18,0,0,18,0,40c0,22,18,40,40,40s40-18,40-40C80,18,62,0,40,0z M54,24c3.2,0,6,2.8,6,6c0,3.2-2.8,6-6,6
		                                    c-3.2,0-6-2.8-6-6C48,26.8,50.8,24,54,24z M26,24c3.2,0,6,2.8,6,6c0,3.2-2.8,6-6,6c-3.2,0-6-2.8-6-6C20,26.8,22.8,24,26,24z"/>
                                                    <path class="st0" d="M58.4,57.3H21.6c-0.5,0-0.9-0.4-0.9-0.9v-7.1c0-0.5,0.4-0.9,0.9-0.9h36.8c0.5,0,0.9,0.4,0.9,0.9v7.1
                                            C59.3,56.9,58.9,57.3,58.4,57.3z"/>
                                                </g>
                                        </svg>
                                        </label>
                                    </div>
                                    <div class="reviewx_radio">
                                        <input id="not_recommend" name="rx-recommend-status" value="0" type="radio">
                                        <label for="not_recommend" class="radio-label sad_face">
                                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                 viewBox="0 0 80 80" style="enable-background:new 0 0 80 80;" xml:space="preserve">
                                            <style type="text/css">
                                                .st0{fill:#6D6D6D;}
                                                .st1{fill:#D1D7DD;}
                                            </style>
                                                <g>
                                                    <path class="st0" d="M54,36c3.2,0,6-2.8,6-6c0-3.2-2.8-6-6-6c-3.2,0-6,2.8-6,6C48,33.2,50.8,36,54,36z"/>
                                                    <path class="st0" d="M26,36c3.2,0,6-2.8,6-6c0-3.2-2.8-6-6-6c-3.2,0-6,2.8-6,6C20,33.2,22.8,36,26,36z"/>
                                                    <path class="st1" d="M40,0C18,0,0,18,0,40c0,22,18,40,40,40s40-18,40-40C80,18,62,0,40,0z M54,24c3.2,0,6,2.8,6,6c0,3.2-2.8,6-6,6
		                                    c-3.2,0-6-2.8-6-6C48,26.8,50.8,24,54,24z M26,24c3.2,0,6,2.8,6,6c0,3.2-2.8,6-6,6c-3.2,0-6-2.8-6-6C20,26.8,22.8,24,26,24z"/>
                                                    <path class="st0" d="M40,42.8c-9.5,0-17.5,6.2-20.4,14.6h40.8C57.5,49,49.5,42.8,40,42.8z"/>
                                                </g>
                                        </svg>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        <?php } //end if, $allow_recommendation ?>
                    </div>

                </div>

                <?php
                $anony_data = array();
                $anony_data['is_anonymouse']                = $allow_anonymouse;
                $anony_data['allow_img']                    = $allow_img;
                $anony_data['allow_video']                  = $allow_video;
                $anony_data['allow_media_compliance']       = get_option( '_rx_option_allow_media_compliance' );
                $anony_data['signature']                    = 1;
                
                apply_filters( 'rx_allow_anonymouse_user', $anony_data );
                if( !ReviewX_Helper::is_pro() && get_option( '_rx_option_allow_media_compliance' ) == 1 ) {
                ?>
                <div class="review_media_compliance">
                <label class="review_media_compliance_label">
                    <input type="checkbox" name="rx_allow_media_compliance" id="rx_allow_media_compliance" value="1">
                    <span class="review_media_compliance_icon"></span>
                    <?php echo !empty(get_theme_mod('reviewx_media_compliance') ) ? html_entity_decode( get_theme_mod('reviewx_media_compliance') ): esc_html__( 'I agree to the terms of services.', 'reviewx' ); ?>
                </label>
                    <span class="rx-error" id="rx-media-compliance-error"></span>
                </div> 
                <?php } ?>
                <div class="rx-form-group">
                    <?php echo \ReviewX\Controllers\Storefront\Modules\ReCaptcha::showField(); ?>
                </div>
                <div class="rx-form-submit-status"></div>
                <div class="rx-form-submit-notice"></div>
                <div class="rx-form-group">
                    <input type="hidden" name="rx-user-id" id="rx-user-id" value="<?php echo get_current_user_id(); ?>">
                    <input type="hidden" name="rx-order-id" id="rx-order-id">
                    <input type="hidden" name="rx-product-id" id="rx-product-id">
                    <input type="hidden" name="rx-total-criteria" id="rx-total-criteria" value="<?php echo count( $review_criteria ); ?>">
                    <input type="hidden" name="rx-nonce" id="rx-nonce" value="<?php echo wp_create_nonce( "special-string" ); ?>">
                    <input name="cancel" class="rx-cancel-btn rx-cancel" value="<?php esc_attr_e( 'Cancel', 'reviewx' ); ?>" type="button">
                    <input name="rx-submit" id="rx-submit" class="submit rx-form-btn rx-form-primary-btn rv-btn" value="<?php esc_attr_e( 'Submit', 'reviewx' ); ?>" type="button">
                </div>
            </fieldset>
        </form>

    </div>

</div>
