<?php
$crowdfundly_single_camp_hide_similar_camps = get_theme_mod( 'cf_single_camp_hide_similar_camps', false );
if ( $crowdfundly_single_camp_hide_similar_camps != true ) :
?>
<div class="g-section">
	<div class="campaign__view-related">
		<h4 class="campaign__view-related-title">
			<?php
			$crowdfundly_similar_camp_heading = get_theme_mod( 'cf_single_camp_similar_campaign_heading', __( 'Similar Campaign', 'crowdfundly' ) );

			if ( ! empty( $crowdfundly_elementor_settings['similar_camps_heading_text'] ) ) {
				$crowdfundly_similar_camp_heading = $crowdfundly_elementor_settings['similar_camps_heading_text'];
			}
			if ( empty( $crowdfundly_similar_camp_heading ) ) {
				$crowdfundly_similar_camp_heading = __( 'Similar Campaign', 'crowdfundly' );
			}

			echo esc_html( $crowdfundly_similar_camp_heading );
			?>
		</h4>
		<div class="row">
			<?php
			$crowdfundly_single_camp_col = '3';
			if ( ! empty( get_theme_mod( 'cf_single_camp_card_column', $crowdfundly_single_camp_col ) ) ) {
				$crowdfundly_single_camp_col = get_theme_mod( 'cf_single_camp_card_column', $crowdfundly_single_camp_col );
			}
			if ( ! empty( $crowdfundly_elementor_settings['similar_camp_card_columns'] ) ) {
				$crowdfundly_single_camp_col = $crowdfundly_elementor_settings['similar_camp_card_columns'];
			}
			foreach ($similars as $similar): ?>
				<div class="col-12 col-sm-6 col-md-4 col-lg-<?php echo esc_attr( $crowdfundly_single_camp_col ); ?>">
					<a href="<?php echo esc_url( Crowdfundly_Settings::getSingleCampaingPagePermalink($similar->slug) ); ?>" class="campaign-card">
						<?php if( !empty($similar->gallery) ) : 
							$logo = $similar->gallery[0]->source_path;
							?>
						<div class="campaign-card__top">
							<div class="campaign-card__bg" style="background-image: url(<?php echo esc_url( "&quot;". $logo ."&quot;"); ?>);"></div>
							<img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr($similar->name ); ?>" class="campaign-card__img">                                                
						</div>
						<?php endif; ?>
						<div class="campaign-card__details">
							<h4 class="campaign-card__title">
								<?php echo esc_html($similar->name); ?>
							</h4>
							<p class="campaign-card__description">
								<?php echo strip_tags(\Crowdfundly_Helper::get_campaign_story($similar->story, 20)); ?>
							</p>
						</div>
						<div class="campaign-card__footer">
							<div class="progress progress--slim">
								<div class="progress__bar progress__bar--secondary" style="width: <?php echo esc_attr( round(($similar->raised_amount*100)/$similar->target_amount) ); ?>;"></div>
							</div>
							<p class="campaign-card__amount"> 
								<strong>
									<i class="fas fa-hand-holding-usd"></i> <?php echo sprintf(__("%1\$d %2\$s", 'crowdfundly'), round($similar->raised_amount, 2), $similar->currency_code ); ?>
								</strong>
								<?php echo sprintf(__("OF %1\$d %2\$s", 'crowdfundly'), $similar->target_amount, $similar->currency_code ); ?>
							</p>							
						</div>
					</a>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
<?php endif; ?>
