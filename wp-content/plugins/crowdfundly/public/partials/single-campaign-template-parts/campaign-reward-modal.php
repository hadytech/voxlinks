<div class="back-modal">
	<h5 class="g-modal__title reward-modal-title">
		<span><?php _e( 'Back this campaign', 'crowdfundly' ); ?></span>
		<span class="reward-modal-close"><a href="#">X</a></span>
	</h5>
	<div class="form-group reward-form">
		<label class="contribution-heading" for="contribution"><?php _e( 'Make a contribution', 'crowdfundly' ); ?></label>
		<div id="crowdfundly-contribution" class="contribution-box">
			<div class="contribution-box__row">
				<div class="d-flex align-items-center mb-0">
					<div class="form-group__amount flex-1">
						<span class="form-group__left-text"><?php echo esc_html( $campaign->currency->symbol ); ?></span>
						<input type="number" step="0.01" min="1" id="reward-contribution-input" class="form-control form-control--amount">
						<span class="form-group__right-text"><?php echo esc_html( $campaign->currency->currency_code ); ?></span>
					</div>
					<div class="reward-btn-wrapper">
						<button id="reward-contribution-btn" disabled="true" type="button" class="btn btn-loader btn-primary btn-min-50 contribution-box__btn">
							<span><?php _e( 'Continue', 'crowdfundly' ); ?></span>
						</button>
					</div>
				</div>
				<p class="g-modal__info-text mb-0 mt-1">
					<?php _e( 'Contributions are not associated with perks', 'crowdfundly' ); ?>
				</p>
			</div>
		</div>
	</div>
	<div class="form-group reward-items">
		<label for="contribution">
			<?php _e( 'Select a Perk', 'crowdfundly' ); ?>
		</label> 
		<div class="row">
			<?php
			 foreach ( $campaign->offers as $offer ) : ?>
				<div class="col-12 col-sm-6 col-md-6 mb-4">
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
						<div class="offer-card__footer">
							<a
								type="button" 
								class="btn btn-outline-primary reward-get-product" 
								data-donate-campaign="<?php echo esc_attr( $campaign->name ); ?>" 
								data-donate-campaign-slug="<?php echo esc_attr( $campaign->slug ); ?>" 
								data-donate-campaign-id="<?php echo esc_attr( $campaign->id ); ?>" 
								data-donate-reward-product-price="<?php echo esc_attr( $offer->offer_price ); ?>"
								data-donate-currency="<?php echo esc_attr( $campaign->currency->currency_code ); ?>" 
								data-donate-csymbol="<?php echo esc_attr( $campaign->currency->symbol ); ?>"
								data-donate-offer-id="<?php echo esc_attr( $offer->id ); ?>"
								href="<?php echo esc_url( '?add-to-cart=' . Crowdfundly_Helper::get_crowdfundly_product_id() . '&crowdfundly_donation=' ); ?>"
							>
								<?php echo __( 'Get Now', 'crowdfundly' ); ?>
							</a>
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

	<div class="donate reward-presets">
		<div class="donate__amounts">
			<div class="donate__amounts-row">
				<?php
				if ( ! empty( $campaign_presets ) ) :
					foreach ( $campaign_presets as $presets ) :
						?>
						<div class="donate__amount" data-donate-campaign="<?php echo esc_attr( $campaign->name ); ?>" data-donate-campaign-id="<?php echo esc_attr( $campaign->id ); ?>" data-donate-amount="<?php echo $presets->amount; ?>" data-donate-currency="<?php echo $campaign->currency->currency_code; ?>" data-donate-csymbol="<?php echo $campaign->currency->symbol;?>">
							<div class="donate__amount-inner">
								<h5 class="donate__amount-value">									
									<?php echo sprintf(__('%1$s %2$s %3$s', 'crowdfundly'), $campaign->currency->symbol, number_format($presets->amount, 2), $campaign->currency->currency_code);?>
								</h5>
							</div>
						</div>
					<?php
					endforeach;
				endif; 
				?>
			</div>
			<div class="donate__custom-amount focus">
				<span class="donate__custom-amount-icon">
					<?php echo $campaign->currency->symbol; ?>
				</span> 
				<input type="number" min="1" step="0.01" placeholder="<?php echo __('Custom Amount', 'crowdfundly'); ?>" class="donate__custom-amount-input"> 
				<span class="donate__custom-amount-icon">
					<?php echo $campaign->currency->currency_code; ?>
				</span>
			</div>			
			<a id="crowdfundly-ajax-cart" href="<?php echo esc_url( '?add-to-cart=' . Crowdfundly_Helper::get_crowdfundly_product_id() . '&crowdfundly_donation=' ); ?>">
				<button 
					type="button" 
					id="crowdfundly-donate-btn" 
					class="btn btn-min-50 btn-primary btn-block my-4" 
					data-donate-campaign="<?php echo esc_attr( $campaign->name ); ?>" 
					data-donate-campaign-id="<?php echo esc_attr( $campaign->id ); ?>" 
					data-donate-currency="<?php echo esc_attr( $campaign->currency->currency_code ); ?>" 
					data-donate-csymbol="<?php echo esc_attr( $campaign->currency->symbol ); ?>"
				>
					<?php echo __('Continue', 'crowdfundly'); ?>
				</button>
			</a>
		</div>
	</div>

</div>
