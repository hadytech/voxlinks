<div class="tab-pane fade" id="updates" role="tabpanel" aria-labelledby="updates-tab">
	<div class="g-tab__index">
		<div class="campaign-updates">
			<div class="campaign-updates__inner">
				<?php if(! empty($updates->data) ): ?>
					<!--single update-->
					<?php foreach ($updates->data as $update): ?>
						<div class="campaign-update">
							<div class="campaign-update__inner">
								<div class="campaign-update__row align-items-start">
									<p class="campaign-update__date flex-1">                                                                                
										<?php echo date_i18n(get_option('date_format'), strtotime($update->created_at)); ?>
									</p> 
								</div>
									
								<div class="campaign-update__info-text">
									<div class="campaign-view-updates__single-text-line">
										<?php
											$message = str_replace('["', '', $update->message); 
											$message = str_replace('"]', '', $message);                                                                                     
											echo $message;
										?>
									</div>
								</div>

								<?php if ( $update->video_url ):
									$pattern = '/(http(s|):|)\/\/(www\.|)yout(.*?)\/(embed\/|watch.*?v=|)([a-z_A-Z0-9\-]{11})/i';
									preg_match( $pattern, $update->video_url, $results );
									?>
									<div class="story-video-wrapper">
										<iframe width="770" height="425" src="<?php echo esc_url( 'https://www.youtube.com/embed/' . $results[6] . '?controls=0' ); ?>" frameborder="0" allowfullscreen></iframe>
									</div>
								<?php endif; ?>

								<?php foreach ($update->images as $image): ?>
									<img src="<?php echo esc_url( $image->source_path ); ?>" alt="<?php echo __('Campaign update image', 'crowdfundly'); ?>" class="campaign-update__img"> 
								<?php endforeach; ?>
							</div>
						</div>
					<?php endforeach; ?>
				<?php else: ?> 
					<div>
						<div class="section-placeholder section-placeholder--sm">
							<div class="section-placeholder__inner">
								<div class="section-placeholder__icon">
									<span class="section-placeholder__icon-text">
										<i class="fas fa-bezier-curve"></i>
									</span>
								</div>
								<p class="section-placeholder__desc">
									<?php echo __('No Update Found', 'crowdfundly'); ?>
								</p>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>