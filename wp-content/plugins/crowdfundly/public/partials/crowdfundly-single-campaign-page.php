<?php
 $crowdfundly_elementor_settings  = apply_filters( 'crowdfundly_single_camp', '' );
?>
<div id="public">
    <div class="content-wrapper template crowdfundly-single-camp">
        <div class="content-body">
            <div class="campaign">
                <div class="campaign__view">
                    <div class="container">
                        <?php if ( $notice ) : ?>
                            <div class="alert alert-danger text-center">
                                <?php echo esc_html( $notice ); ?>
                            </div>
                        <?php endif; ?>

                        <div class="g-section">
                            <div class="row">
                                <div class="col-12 col-sm-5 col-md-6 col-lg-6">
                                    <div class="campaign__view-slider">
                                    	<?php require CROWDFUNDLY_PUBLIC_PATH . 'partials/single-campaign-template-parts/campaign-gallery.php'; ?>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-7 col-md-6 col-lg-6"> 
									<?php require CROWDFUNDLY_PUBLIC_PATH . 'partials/single-campaign-template-parts/campaign-detail.php'; ?>
                                </div> 
							</div>
							
							<?php
							$crowdfundly_settings = Crowdfundly_Settings::get();
							if ( isset($crowdfundly_settings['crowdfundly_option_wc_payment']) && $crowdfundly_settings['crowdfundly_option_wc_payment'] == 1 ) {
								if ( empty( $campaign->offers ) ) {
									require CROWDFUNDLY_PUBLIC_PATH . 'partials/single-campaign-template-parts/campaign-contribute-modal.php';
								} else {
									require CROWDFUNDLY_PUBLIC_PATH . 'partials/single-campaign-template-parts/campaign-reward-modal.php';
								}
							}
							?>
                        </div>
                        <div class="g-section">
                            <div class="campaign__view-tab">
                                <div class="g-tab">
                                    <ul class="nav nav-tabs g-tab__nav" id="campaignTab" role="tablist">
                                       <li class="nav-item g-tab__nav-item">
                                           <a class="nav-link active" id="story-tab" data-toggle="tab" href="#story" role="tab" aria-controls="story" aria-selected="true">
                                                <?php _e( 'Campaign story', 'crowdfundly' ); ?><span>
                                            </a>
                                       </li>
                                        <li class="nav-item g-tab__nav-item">
                                            <a class="nav-link" id="updates-tab" data-toggle="tab" href="#updates" role="tab" aria-controls="updates" aria-selected="false">
                                                <?php _e('Updates', 'crowdfundly'); ?> <span class="pl-1"> (<?php echo esc_html( $campaign->updates_count ); ?>) </span>
                                            </a>
                                        </li>
                                        <li class="nav-item g-tab__nav-item">
                                            <a class="nav-link" id="activities-tab" data-toggle="tab" href="#activities" role="tab" aria-controls="activities" aria-selected="false">
                                               <?php _e('Activities', 'crowdfundly'); ?> <span class="pl-1"> (<?php echo esc_html( $campaign->activities_count ); ?>) </span>
                                            </a>
                                        </li>
                                        <li class="nav-item g-tab__nav-item">
                                            <a class="nav-link" id="endorsements-tab" data-toggle="tab" href="#endorsements" role="tab" aria-controls="endorsements" aria-selected="false">
                                                <?php _e( 'Endorsements', 'crowdfundly' ); ?> <span class="pl-1"><?php echo esc_html( '(' . $endorsements->approved_count . ')' ); ?></span>
                                            </a>
                                        </li>
                                        <li class="nav-item g-tab__nav-item">
                                            <a class="nav-link" id="top-contributors-tab" data-toggle="tab" href="#top-contributors" role="tab" aria-controls="top-contributors" aria-selected="false">
                                                <?php _e( 'Top Contributors', 'crowdfundly' ); ?>
                                            </a>
                                        </li>
                                        <?php if ( ! empty( $campaign->offers ) ) { ?>
                                        <li class="nav-item g-tab__nav-item active">
                                            <a class="nav-link" id="select-reward-tab" data-toggle="tab" href="#select-reward" role="tab" aria-controls="select-reward" aria-selected="false">                                                
                                                <button type="button" class="btn btn-primary"><?php _e( 'Select a reward', 'crowdfundly' ); ?></button>
                                            </a>                                            
                                        </li>
                                        <?php } ?>
                                    </ul>

                                    <div class="tab-content g-tab__body" id="campaignTabContent">
										<?php
                                            require CROWDFUNDLY_PUBLIC_PATH . 'partials/single-campaign-template-parts/campaign-story-tab.php';
                                            require CROWDFUNDLY_PUBLIC_PATH . 'partials/single-campaign-template-parts/campaign-updates-tab.php';
                                            require CROWDFUNDLY_PUBLIC_PATH . 'partials/single-campaign-template-parts/campaign-activites-tab.php';
                                            require CROWDFUNDLY_PUBLIC_PATH . 'partials/single-campaign-template-parts/campaign-endorsments-tab.php';
                                            require CROWDFUNDLY_PUBLIC_PATH . 'partials/single-campaign-template-parts/campaign-top-contributers.php';
                                            require CROWDFUNDLY_PUBLIC_PATH . 'partials/single-campaign-template-parts/campaign-reward.php';
										?>
                                    </div>
                                </div>
                            </div>
                        </div>

						<?php if ( ! empty( $similars ) ) {
							require CROWDFUNDLY_PUBLIC_PATH . 'partials/single-campaign-template-parts/campaign-similar-camp.php';
						}
						?>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>