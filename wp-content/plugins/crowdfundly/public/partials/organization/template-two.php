<div class="content-wrapper template crowdfundy-org">
    <div class="content-body">
        <div class="template">
            <div class="template__2">
                <div class="organization">
                    <?php
                    $crowdfundly_hide_slider = get_theme_mod( 'cf_org_hide_slider', false );
                    if ( $crowdfundly_hide_slider != true ) :
                    ?>
                        <div class="organization__slider">
                            <div class="main agile">
                                <div class="slider org-slider">
                                    <?php foreach($company->gallery as $slide): ?>
                                        <div>
                                            <img class="slide" src="<?php echo esc_url( $slide->source_path ); ?>" alt="<?php echo __('Campaign slider image', 'crowdfundly'); ?>">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="container <?php echo $crowdfundly_hide_slider ? esc_attr( 'crowdfundly-org-without-slider' ) : ''; ?>">
                        <div class="organization__details">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-5 col-xl-4 organization__details-left">
                                    <div class="organization__info">
                                        <div class="organization__info-top">
                                            <div class="organization__info-logo">
                                                <?php $logo = is_object( $company->logo ) ? $company->logo->source_path : CROWDFUNDLY_PUBLIC_URL . 'images/avatar.png'; ?>
                                                <img src="<?php echo esc_url( $logo ); ?>" class="organization__info-logo-img" alt="<?php echo esc_attr( $company->name ); ?>">
                                            </div>

                                            <div class="organization__info-top-right">
                                                <h4 class="organization__info-name">
                                                    <?php echo esc_html( $company->name ); ?>
                                                </h4>
                                                <p class="organization__info-address">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    <?php echo esc_html( $company->address ); ?>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="organization__social">
                                            <h5 class="organization__social-title"><?php echo __('Linked accounts', 'crowdfundly');?></h5>
                                            <ul class="organization__social-list">
                                                <?php
													foreach($company->socialProfiles as $profile):
														if( !empty($profile->link) ):
														?> 
                                                    <li class="organization__social-item organization__social-item--<?php echo esc_html( $profile->social_network->name ); ?>">
                                                        <a href="<?php echo esc_url( $profile->link ); ?>" target="_blank" title="<?php echo esc_attr( $profile->social_network->name ); ?>" class="organization__social-item-link">
                                                            <i class="organization__social-item-icon <?php echo esc_attr( $profile->social_network->icon ); ?>"></i>
                                                            <div class="organization__social-item-details">
                                                                <h5  class="organization__social-item-title">
                                                                    <?php echo esc_html( $profile->social_network->name ); ?>
                                                                </h5>
                                                                <p class="organization__social-item-subtitle">
                                                                    <?php echo esc_html( $profile->link ); ?>
                                                                </p>
                                                            </div>
                                                        </a>
                                                    </li>
                                                <?php endif; endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-7 col-md-8">
                                    <div class="organization__details-inner">
                                        <h4 class="organization__details-title">
                                            <?php echo esc_html( $company->name ); ?>
                                        </h4>
                                        <div>
                                            <?php echo $company->description; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php 
                        $crowdfundly_hide_recent_camps = get_theme_mod( 'cf_org_hide_recent_camps', false );
						if ( $crowdfundly_hide_recent_camps != true ) :

                            if(! empty($recent_campaigns)): ?>
                                <div class="organization__campaigns">
                                    <h4 class="organization__campaigns-title">
                                        <?php
                                        $crowdfundly_recent_text = get_theme_mod( 'cf_org_recent_campaign_title', __( 'Recent Campaign', 'crowdfundly' ) );

                                        $crowdfundly_elementor_settings  = apply_filters( 'crowdfundly_org_camp', '' );
                                        if ( ! empty( $crowdfundly_elementor_settings['recent_camps_heading_text'] ) ) {
                                            $crowdfundly_recent_text = $crowdfundly_elementor_settings['recent_camps_heading_text'];
                                        }
                                        if ( empty( $crowdfundly_recent_text ) ) {
                                            $crowdfundly_recent_text = __( 'Recent Campaign', 'crowdfundly' );
                                        }

                                        echo esc_html( $crowdfundly_recent_text );

                                        $crowdfundly_recent_camp_col = '3';
                                        if ( ! empty( get_theme_mod( 'cf_org_recent_camp_card_column', $crowdfundly_recent_camp_col ) ) ) {
											$crowdfundly_recent_camp_col = get_theme_mod( 'cf_org_recent_camp_card_column', $crowdfundly_recent_camp_col );
										}
                                        if ( ! empty( $crowdfundly_elementor_settings['camp_card_columns'] ) ) {
                                            $crowdfundly_recent_camp_col = $crowdfundly_elementor_settings['camp_card_columns'];
                                        }
                                        ?>
                                    </h4>
                                    <div class="row" id="recent-campaigns">
                                        <?php foreach($recent_campaigns as $campaign): ?>
                                            <div class="col-12 col-sm-6 col-md-4 col-lg-<?php echo esc_attr( $crowdfundly_recent_camp_col ); ?>">
                                                <a href="<?php echo esc_url( Crowdfundly_Settings::getSingleCampaingPagePermalink($campaign->slug) ); ?>" class="campaign-card">
                                                    <?php 
                                                        if(!empty($campaign->gallery) ) :
                                                            $logo = $campaign->gallery[0]->source_path;
                                                    ?>
                                                    <div class="campaign-card__top">
                                                        <div class="campaign-card__bg" style="background-image: url(<?php echo esc_url( '&quot;'. $logo .'&quot;' ); ?>);"></div>
                                                        <img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_html( $campaign->name ); ?>" class="campaign-card__img"> <!---->
                                                    </div>
                                                    <?php endif; ?>
                                                    <div class="campaign-card__details"> 
                                                        <h4 class="campaign-card__title">
                                                            <?php echo esc_html( $campaign->name ); ?>
                                                        </h4>
                                                        <p class="campaign-card__description">
                                                            <?php echo strip_tags(\Crowdfundly_Helper::get_campaign_story($campaign->story, 20)); ?>
                                                        </p>
                                                        </div>
                                                    <div class="campaign-card__footer">
                                                        <div class="progress progress--slim">
                                                            <div class="progress__bar progress__bar--secondary" style="width: 0%;"></div>
                                                        </div>
                                                        <p class="campaign-card__amount"> 
                                                            <strong>
                                                                <i class="fas fa-hand-holding-usd"></i> <?php echo sprintf(__("%1\$d %2\$s", 'crowdfundly'), round($campaign->raised_amount, 2), $campaign->currency_code ); ?>
                                                            </strong>
                                                            <?php echo sprintf(__("OF %1\$d %2\$s", 'crowdfundly'), $campaign->target_amount, $campaign->currency_code ); ?>
                                                        </p>
                                                    </div>
                                                </a>
                                            </div>
                                        <?php endforeach; ?>

                                        <?php
										$crowdfundly_hide_all_camps_btn = get_theme_mod( 'cf_org_hide_btn', false );
										if ( $crowdfundly_hide_all_camps_btn != true ) :
										?>
                                            <div class="col-12 d-flex align-items-center justify-content-center org-all-campaign-btn-wrap">
                                                <a href="<?php echo esc_url( Crowdfundly_Settings::getAllCampaignPageLinkByID() ); ?>" class="btn btn-primary organization-all-camp-btn"><?php _e( 'All Campaigns', 'crowdfundly' ); ?></a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php
                            endif;
                        endif;    
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
