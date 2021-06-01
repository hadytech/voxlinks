<div class="tab-pane fade show active" id="story" role="tabpanel" aria-labelledby="story-tab">
	<div class="g-tab__index">
		<div class="editor-view">
			<div>
				<?php
				$story = \Crowdfundly_Helper::get_campaign_story_details( json_decode($campaign->story) );

				if ( $story != null ) :
					echo $story;
				else:
					?>
					<div class="section-placeholder section-placeholder--sm">
						<div class="section-placeholder__inner">
							<div class="section-placeholder__icon">
								<span class="section-placeholder__icon-text">
									<i class="fas fa-align-left"></i>
								</span>
							</div>
							<h3 class="section-placeholder__title">
								<?php _e( 'Sorry', 'crowdfundly' ); ?>
							</h3>
							<p class="section-placeholder__desc">
								<?php echo __('No story found', 'crowdfundly'); ?>
							</p>
						</div>
					</div>
					<?php
				endif;
				?>
			</div>
		</div>
	</div>
</div>