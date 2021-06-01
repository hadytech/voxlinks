<div class="tab-pane fade" id="top-contributors" role="tabpanel" aria-labelledby="top-contributors-tab">
	<div class="g-tab__index">
		<div class="top-donors">
			<div class="donor-list">
				<?php
				if ( ! empty( $topDonor ) ) :
					foreach($topDonor as $donor):
						$avatar_url = CROWDFUNDLY_PUBLIC_URL . 'images/avatar.png';
						if ( ! $donor->is_anonymous && isset( $donor->avatar ) ) {
							$avatar_url = $donor->avatar;
						}
						?>
						<div class="donor-list__item">
							<div class="donor-card">
								<div class="donor-card__avatar" style="background-image: url(<?php echo esc_url( $avatar_url ); ?>);"></div>
								<div class="donor-card__details">
									<h6 class="donor-card__name">
										<?php echo isset($donor->full_name)? esc_html( $donor->full_name ) : ''; ?>
									</h6> 
									<h6 class="donor-card__label">
										<?php _e( 'Amount:', 'crowdfundly' ); ?> 
										<span class="donor-card__value">
											<?php echo esc_html( $donor->currency_code ); ?> 
											<?php echo number_format( $donor->amount, 2 ); ?>
										</span>
									</h6>
								</div>
								<div class="donor-card__badge">
									<img src="<?php echo esc_url( CROWDFUNDLY_PUBLIC_URL . 'images/medal.svg' ); ?>" alt="<?php echo __( 'Badge', 'crowdfundly' ); ?>" class="donor-card__badge-img">
								</div>
							</div>
						</div>
					<?php endforeach; ?>

				<?php else: ?> 
					<div class="donar-not-found">
						<div class="section-placeholder section-placeholder--sm">
							<div class="section-placeholder__inner">
								<div class="section-placeholder__icon">
									<span class="section-placeholder__icon-text">
										<i class="fas fa-donate"></i>
									</span>
								</div>
								<p class="section-placeholder__desc">
									<?php echo __('Sorry no one has contributed yet.', 'crowdfundly'); ?>
								</p>
							</div>
						</div>
					</div>

				<?php endif; ?>
			</div>
		</div>
	</div>
</div>