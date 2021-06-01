<div id="crowdfundly-donation-modal" class="donate">
	<div class="donate__inner">
		<h5 class="donate__title">
			<span><?php _e( 'Amount', 'crowdfundly' ); ?></span>
			<span class="donate__close"><a href="#">X</a></span> 
		</h5>
		<div class="donate__amounts">
			<div class="donate__amounts-row">
				<?php
				if ( ! empty( $campaign_presets ) ) :
					foreach ( $campaign_presets as $presets ) :
						?>
						<div class="donate__amount" data-donate-campaign="<?php echo esc_attr( $campaign->name ); ?>" data-donate-campaign-id="<?php echo esc_attr( $campaign->id ); ?>" data-donate-amount="<?php echo esc_attr( $presets->amount ); ?>" data-donate-currency="<?php echo esc_attr( $campaign->currency->currency_code ); ?>" data-donate-csymbol="<?php echo esc_attr( $campaign->currency->symbol ); ?>">
							<div class="donate__amount-inner">
								<h5 class="donate__amount-value">									
									<?php echo sprintf(esc_attr('%s %s %s'), $campaign->currency->symbol, number_format($presets->amount, 2), $campaign->currency->currency_code);?>
								</h5>
							</div>
						</div>
					<?php
					endforeach;
				endif; 
				?>
			</div>
		</div>
		<div class="donate__custom-amount focus">
			<span class="donate__custom-amount-icon"><?php echo esc_html( $campaign->currency->symbol ); ?></span> 
			<input type="number" min="1" step="0.01" placeholder="Custom Amount" class="donate__custom-amount-input"> 
			<span class="donate__custom-amount-icon"><?php echo esc_html( $campaign->currency->currency_code ); ?></span>
		</div>
		<a id="crowdfundly-ajax-cart" href="?add-to-cart=<?php echo Crowdfundly_Helper::get_crowdfundly_product_id(); ?>&crowdfundly_donation=">
			<button type="button" id="crowdfundly-donate-confirm" class="btn btn-min-50 btn-primary btn-block mt-4" disabled="disabled" data-donate-campaign="<?php echo esc_attr( $campaign->name ); ?>" data-donate-campaign-id="<?php echo esc_attr( $campaign->id ); ?>" data-donate-currency="<?php echo esc_attr( $campaign->currency->currency_code ); ?>" data-donate-csymbol="<?php echo esc_attr( $campaign->currency->symbol ); ?>">
				<?php echo __('Continue', 'crowdfundly'); ?>
			</button>
		</a>		
	</div>	

	<!-- <h6 class="donate__info-text text-center mt-4"><?php _e( 'Please select a preset amount or custom amount', 'crowdfundly' ); ?></h6> -->
</div>
