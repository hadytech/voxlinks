<div class="tab-pane fade" id="select-reward" role="tabpanel" aria-labelledby="select-reward-tab">
    <div class="g-tab__index">
        <div class="select-offer">
            <div class="row">
                <?php foreach ( $campaign->offers as $offer ) : ?>
                <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-2 mt-2">
                    <div class="offer-card">
                        <div class="offer-card__img offer-card__img--bg" style="background-image: url(<?php echo esc_url( is_object( $offer->image ) ? $offer->image->source_path : '' ); ?>);"></div>
                        <div class="offer-card__body">
                            <h4 class="offer-card__title">
                                <?php echo esc_html( $offer->title ); ?>
                            </h4> 
                            <span class="badge  badge-warning">
                                <?php printf( '%s %s %s', __( 'Only', 'crowdfundly' ), esc_html( $offer->stock ), __( 'left', 'crowdfundly' ) ); ?>
                            </span>
                            <div class="offer-card__price">
								<h5 class="offer-card__price-old">
                                    <?php echo esc_html( $campaign->currency->symbol . $offer->regular_price . ' ' . $campaign->currency->currency_code ); ?>
                                </h5>
                                <h5 class="offer-card__price-new">
                                    <?php echo esc_html( $campaign->currency->symbol . $offer->offer_price . ' ' . $campaign->currency->currency_code ); ?>
                                </h5>
                            </div>
                            <p class="offer-card__description">
                                <?php echo esc_html( $offer->description ); ?>
                            </p>
                            <div class="offer-card__shipping">
                                <div class="d-flex align-items-center">
                                    <h5 class="offer-card__shipping-title">
                                        <?php echo $offer->is_shipping ? __('Shipping', 'crowdfundly') : ''; ?>
                                    </h5>
                                </div>
                                <?php 
                                    $shipping_info = json_decode( $offer->shipping_info ); 
                                    if( isset($shipping_info) ) {
							    ?>
                                <div class="offer-card__shipping-info">
                                    <p class="offer-card__shipping-info-location">
									    <strong class="offer-card__shipping-info-label">
                                            <?php echo __( 'Shipping location: ', 'crowdfundly' ); ?>
                                        </strong>
									    <?php echo esc_html( $shipping_info[0]->location ); ?>
                                    </p>
                                    <p class="offer-card__shipping-info-fee">
                                        <strong class="offer-card__shipping-info-label">
                                            <?php echo __( 'Shipping fee: ', 'crowdfundly' ); ?>
                                        </strong>
									    <?php echo esc_html( $campaign->currency->symbol . $shipping_info[0]->shippingFee . ' ' . $campaign->currency->currency_code ); ?>
                                    </p>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="offer-card__footer">
                            <?php 
                                $reward_url = Crowdfundly_Helper::get_organization_url();
                                $reward_url .= '/campaigns/'.$campaign->slug.'/'.$campaign->id.'/contribute';
                                $get_now_url = '?add-to-cart=' . Crowdfundly_Helper::get_crowdfundly_product_id() . '&crowdfundly_donation=' . $offer->offer_price .'&crowdfundly_campaign='. esc_attr( $campaign->name ) .'&crowdfundly_campaign_slug='. esc_attr( $campaign->slug ) .'&crowdfundly_campaign_id='.esc_attr( $campaign->id ) .'&crowdfundly_currency='.esc_attr( $campaign->currency->currency_code ) .'&crowdfundly_csymbol='. esc_attr( $campaign->currency->symbol ) .'&crowdfundly_offer_id='.esc_attr( $offer->id );   

                                if( $payment_status == 'disabled' ){     
                            ?>
                                <a type="button" class="btn btn-outline-primary reward-get-product" href="<?php echo esc_url($reward_url); ?>" target="_blank">
								    <?php echo __( 'Get Now', 'crowdfundly' ); ?>
							    </a>                              
                            <?php } else { ?>
                                <a type="button" class="btn btn-outline-primary reward-get-product" href="<?php echo $get_now_url; ?>">
								    <?php echo __( 'Get Now', 'crowdfundly' ); ?>
							    </a>                             
                            <?php } ?>
                           
                        </div>
						<?php 
							if( isset($offer->offer_price) && $offer->offer_price > 0 ){
							$off_price = floor((((int)$offer->regular_price - (int)$offer->offer_price) / (int)$offer->regular_price) * 100);
						?>
						<div class="offer-card__badge">
                            <?php echo sprintf(__('%s OFF', 'crowdfundly'), $off_price.'%'); ?>
                        </div>
						<?php } ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>