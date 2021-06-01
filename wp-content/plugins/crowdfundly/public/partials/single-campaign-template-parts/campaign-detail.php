<div class="campaign__details">
	<h4 class="campaign__title campaign__title--status">
		<?php echo esc_html( $campaign->name ); ?>
	</h4>
	<div class="campaign__status">
		<span class="campaign__status-title mr-2">
			<i class="fas fa-circle campaign__status-title-icon"></i>
			<?php echo __( 'Published', 'crowdfundly' ); ?>
		</span>
	</div>
	<div class="campaign__fundraiser">
		<?php
		if ( is_object( $campaign->organization ) ) {
			$logo = is_object( $campaign->organization->logo ) ? $campaign->organization->logo->source_path : CROWDFUNDLY_PUBLIC_URL . 'images/avatar.png';
		}
		?>
		<img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( $campaign->organization->name ); ?>" class="campaign__fundraiser-avatar">
		<p class="campaign__fundraiser-name">                                                
			<?php echo __( 'by', 'crowdfundly' ); ?>
			<a href="<?php echo esc_url(Crowdfundly_Settings::getOrganizationPagePermalink()); ?>" class="campaign__fundraiser-name-link">
				<?php echo esc_html( is_object( $campaign->organization ) ? $campaign->organization->name : '' ); ?>
			</a>
		</p>
	</div>
	<div class="campaign__funding">
		<div class="campaign__funding-row">
			<div class="campaign__funding-item">
				<div class="funding-card funding-goal">
					<h5 class="funding-card__value">
						<?php echo esc_html($campaign->currency_symbol . $campaign->target_amount); ?>
					</h5>
					<p class="funding-card__lavel">
						<?php _e( 'Funding Goal', 'crowdfundly' ); ?>
					</p>
				</div>
			</div>
			<div class="campaign__funding-item">
				<div class="funding-card fund-raised">
					<h5 class="funding-card__value">
						<?php echo esc_html( $campaign->currency_symbol . $campaign->raised_amount ); ?>
					</h5>
					<p class="funding-card__lavel">
						<?php _e( 'Funds Raised', 'crowdfundly' ); ?>
					</p>
				</div>
			</div>

			<?php if ( isset( $campaign->validity_countdown_days ) ) : ?>
				<div class="campaign__funding-item">
					<div class="funding-card funding-duration">
						<h5 class="funding-card__value">
							<?php echo esc_html( $campaign->validity_countdown_days ); ?>
						</h5>
						<p class="funding-card__lavel">
							<?php _e( 'Days to Go', 'crowdfundly' ); ?>
						</p>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<div class="campaign__progress">
		<div class="progress progress--sm">
			<?php $width = round(($campaign->raised_amount*100)/$campaign->target_amount); ?>
			<div class="progress__bar progress__bar--secondary" style="width: <?php echo esc_attr( $width . '%' ); ?>"></div>
		</div>
	</div>

	<div class="campaign__actions">
		<?php
		$crowdfundly_settings = Crowdfundly_Settings::get();
		$button_enable = true;
		$button_default_text = null;
		$btn_id = null;
		
		$target_date = strtotime( $campaign->target_date );
		$available_woo_gateways = function_exists( 'WC' ) ? WC()->payment_gateways->get_available_payment_gateways() : [];
		if ( ! isset( $crowdfundly_settings['crowdfundly_option_wc_payment'] ) && empty( $available_woo_gateways ) ) {
			$button_enable = false;
		}

		if ( isset( $crowdfundly_settings['crowdfundly_option_wc_payment'] ) ) {
			if ( $crowdfundly_settings['crowdfundly_option_wc_payment'] == 1 && empty( $available_woo_gateways ) ) {
				$button_enable = false;
			} elseif ( $crowdfundly_settings['crowdfundly_option_wc_payment'] == 0 && empty( $organization_gateways ) ) {
				$button_enable = false;
			}
		} else if ( ! isset( $crowdfundly_settings['crowdfundly_option_wc_payment'] ) && ! empty( $available_woo_gateways ) ) {
			$button_enable = true;
		
		} elseif ( empty( $organization_gateways ) ) {
			$button_enable = false;
		} 
		if ( $campaign->target_amount_raised == 1 ) {
			$button_enable = false;
		}
		if ( $target_date != null && time() > $target_date ) {
			$button_enable = false;
		}
		if ( $notice ) {
			$button_enable = false;
		}
		$payment_status = ( $button_enable == false ) ? 'disabled' : '';
		
		if ( ! empty( $campaign->offers ) ) {
			$button_default_text = __( 'Back It', 'crowdfundly' );
			$btn_id = 'campaign-reward-btn';
		} else {
			$button_default_text = __( 'Contribute Now', 'crowdfundly' );
			$btn_id = 'campaign-contribute-btn';
		}
		
		if ( (class_exists('WooCommerce') && isset($crowdfundly_settings['crowdfundly_option_wc_payment']) && $crowdfundly_settings['crowdfundly_option_wc_payment'] == 1 ) ||
			 (class_exists('WooCommerce') && ! isset($crowdfundly_settings['crowdfundly_option_wc_payment']) )
		) {
			?>
			<button <?php echo esc_attr( $payment_status ); ?> id="<?php echo esc_attr( $btn_id ); ?>" type="button" data-toggle="modal" class="btn btn-primary btn-block campaign__actions-btn">
				<?php echo esc_html( get_theme_mod( 'cf_single_campn_donation_btn_texts', $button_default_text ) ); ?>
			</button>
		<?php } else {
			$crowdfundlu_user = get_option( 'crowdfundly_user', null );
			?>
			<a href="<?php echo esc_url( Crowdfundly_Settings::getDonationPagePermalink($campaign->slug) ); ?>">
				<button type="button" data-toggle="modal" class="btn btn-primary btn-block campaign__actions-btn">
					<?php echo esc_html( get_theme_mod( 'cf_single_campn_donation_btn_texts', $button_default_text ) ); ?>
				</button>
			</a>
		<?php } ?>
	</div>
</div>