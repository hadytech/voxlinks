<div class="tab-pane fade" id="activities" role="tabpanel" aria-labelledby="activities-tab">
	<div class="g-tab__index">
		<div class="activities">
			<?php
			if ( ! empty( $activities ) && ! empty( $activities->data ) ) :
				$activities_data = array_splice( $activities->data, 0, 3 ); 
				foreach ( $activities_data as $activity ): 
					$avatar_url = CROWDFUNDLY_PUBLIC_URL . 'images/avatar.png';
					if ( ! $activity->is_anonymous && isset( $activity->donation->avatar ) ) {
						$avatar_url = $activity->donation->avatar;
					}
					?>
					<div class="activity">
						<div class="activity__avatar" style="background-image: url(<?php echo esc_url($avatar_url); ?>);"></div>
						<div class="activity__details">
							<div class="activity__row">
								<div class="activity__name">
									<?php
									$name = isset($activity->donation->full_name) ? $activity->donation->full_name : $activity->donation->name;
									$donorName = $activity->is_anonymous ? __( 'Anonymous Contributor', 'crowdfundly' ) : $name;
									echo esc_html( $donorName );
									?>
									<span class="activity__label">
										<?php _e( 'has contributed', 'crowdfundly' ); ?>
									</span>
								</div>
								<p class="activity__date">
									<?php echo date_i18n( get_option( 'links_updated_date_format' ), strtotime( $activity->created_at ) ); ?>
								</p>
							</div>
							<div class="activity__row">
								<div class="activity__label">
									<?php _e( 'Amount:', 'crowdfundly' ); ?> 
									<span class="activity__value">
										<?php echo esc_html( $activity->currency_code . " " . $activity->donation_amount ); ?>
									</span>
								</div>
							</div>
							<?php if ( isset( $activity->donation->message ) ) : ?>
								<div class="activity__row">
									<p class="activity__message">
										<?php echo $activity->donation->message; ?>
									</p>
								</div>
							<?php endif; ?>                                                 
						</div>
					</div>
				<?php endforeach; ?>

				<?php else: ?> 
					<div>
						<div class="section-placeholder section-placeholder--sm">
							<div class="section-placeholder__inner">
								<div class="section-placeholder__icon">
									<span class="section-placeholder__icon-text">
										<i class="fas fa-chart-line"></i>
									</span>
								</div>
								<p class="section-placeholder__desc">
									<?php echo __('No activities found for this campaign', 'crowdfundly'); ?>
								</p>
							</div>
						</div>
					</div>

			<?php endif; ?>
		</div>

		<?php if ( $total_activities > 3 ):
			?>
			<div class="text-center mt-3">
				<a id="crowdfundly-activites-load-more" class="btn btn-primary btn-sm px-5" href="#" data-last-page="<?php echo esc_attr( $activities->last_page ); ?>" data-camp-id="<?php echo esc_attr( $campaign->id ); ?>">
					<span class="d-flex align-items-center justify-content-center">
						<span class="ml-2"><?php echo __( 'Load more', 'crowdfundly' ); ?></span>
					</span>
				</a>
			</div>
		<?php endif; ?>

	</div>
</div>