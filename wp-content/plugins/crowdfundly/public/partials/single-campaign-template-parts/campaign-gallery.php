<div class="main">
	<?php
	if ( ! empty( $campaign->gallery ) || ! empty($campaign->videos) ) : ?>
		<div class="slider gallery-slider">
		<?php if ( ! empty($campaign->videos) ) : ?>
			<?php foreach($campaign->videos as $video): ?>
				<div class="slide">
					<div class="slide__inner">
						<div class="slide__bg" style="background-image: url(<?php echo esc_url( '&quot;' . $video->source . '&quot;' ); ?>);"></div>
						<div class="v-player slide__iframe">
							<?php echo Crowdfundly_Helper::render_slider_iframe($video->source); ?>
						</div>
					</div>
				</div>			
			<?php endforeach; ?>
		<?php endif; ?>
			<?php foreach($campaign->gallery as $slide): ?>
				<div class="slide">
					<div class="slide__inner">
						<div class="slide__bg"
							style="background-image: url(<?php echo esc_url( '&quot;' . $slide->source_path . '&quot;' ); ?>);">
						</div>
						<img src="<?php echo esc_url( $slide->source_path ); ?>" class="slide__img" <?php echo __('Slider image', 'crowdfundly'); ?>>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

		<div class="thumbnails slider gallery-slider-nav">	
			
			<?php if ( ! empty($campaign->videos) ) : ?>
			<?php foreach($campaign->videos as $video): ?>
				<div class="slide slide--thumbniail">
					<div class="slide__overlay"></div>
					<?php echo Crowdfundly_Helper::render_slider_iframe($video->source); ?>
				</div>			
			<?php endforeach; ?>	
			<?php endif; ?>

			<?php foreach($campaign->gallery as $slide): ?>
				<div class="slide slide--thumbniail">
				<div class="slide__overlay"></div>
				<img src="<?php echo esc_url( $slide->source_path ); ?>" alt="<?php echo __('Slider thumbniail', 'crowdfundly'); ?>"/>
			</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>