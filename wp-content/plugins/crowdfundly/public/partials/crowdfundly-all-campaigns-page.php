<?php
$crowdfundly_elementor_settings  = apply_filters( 'crowdfundly_all_camps', '' );
?>
<div id="public">
    <div class="content-wrapper template all-camps">
        <div class="content-body">
            <div class="all-campaign">
                <div class="container">
                    <?php
                    $crowdfundly_all_camp_hide_search_bar = get_theme_mod( 'cf_all_camp_hide_search_bar', false );

                    if ( $crowdfundly_all_camp_hide_search_bar != true ) :
                    ?>
                        <div class="all-campaign__header">
                            <h4 class="all-campaign__title">
                                <?php
                                $crowdfundly_search_bar_heading = get_theme_mod( 'cf_all_camp_title', __( 'Campaigns', 'crowdfundly' ) );

                                if ( ! empty( $crowdfundly_elementor_settings['search_bar_heading_text'] ) ) {
                                    $crowdfundly_search_bar_heading = $crowdfundly_elementor_settings['search_bar_heading_text'];
                                }
                                if ( empty( $crowdfundly_search_bar_heading ) ) {
                                    $crowdfundly_search_bar_heading = __( 'Campaigns', 'crowdfundly' );
                                }
                                echo esc_html( $crowdfundly_search_bar_heading );
                                ?>
                            </h4>
                            <div class="all-campaign__filter">
                                <div class="all-campaign__filter-search">
                                    <i class="all-campaign__filter-search-icon fas fa-search"></i>
                                    <input type="text" id="allCampaignSearchBox" placeholder="<?php echo esc_attr( 'Search here...', 'crowdfundly' ); ?>" class="all-campaign__filter-search-input">
                                    <button type="button" class="all-campaign__filter-search-btn-clear"><img src="<?php echo esc_url( CROWDFUNDLY_PUBLIC_URL . 'images/gray.png' ); ?>" alt="Close" class="all-campaign__filter-search-btn-clear-icon"></button>
                                    <button type="submit" id="allCampaignSearch" data-page-url="<?php echo esc_url(Crowdfundly_Settings::getAllCampaignPagePermalink()); ?>" class="all-campaign__filter-search-btn-submit btn btn-primary">
                                        <?php echo __( 'Search', 'crowdfundly' ); ?>
                                    </button>
                                </div>
                                <select id="allCampaignTypeSelect" class="all-campaign__filter-select" data-page-url="<?php echo esc_url(Crowdfundly_Settings::getAllCampaignPagePermalink()); ?>">
                                    <option selected="selected" disabled="disabled"><?php echo __( 'Sort by', 'crowdfundly' ); ?></option>
                                    <option value="trending"><?php echo __( 'Trending', 'crowdfundly' ); ?></option>
                                    <option value="almost_there"><?php echo __( 'Almost there', 'crowdfundly' ); ?></option>
                                    <option value="newest"><?php echo __( 'Newest', 'crowdfundly' ); ?></option>
                                    <option value="successful"><?php echo __( 'Successful', 'crowdfundly' ); ?></option>
                                    <option value="last_updated"><?php echo __( 'Last updated', 'crowdfundly' ); ?></option>
                                </select>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="all-campaign__inner">
                        
                        <div class="row" id="all-camp-row">
                            <?php if(! empty($data) ): 
                                $crowdfundly_all_camp_col = '3';
                                if ( ! empty( get_theme_mod( 'cf_all_camp_card_column', $crowdfundly_all_camp_col ) ) ) {
                                    $crowdfundly_all_camp_col = get_theme_mod( 'cf_all_camp_card_column', $crowdfundly_all_camp_col );
                                }
                                if ( ! empty( $crowdfundly_elementor_settings['all_camp_card_columns'] ) ) {
                                    $crowdfundly_all_camp_col = $crowdfundly_elementor_settings['all_camp_card_columns'];
                                }
                                ?>
                                <?php foreach ($data as $camp): ?>
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-<?php echo esc_attr( $crowdfundly_all_camp_col ); ?>">
                                        <a href="<?php echo esc_url( Crowdfundly_Settings::getSingleCampaingPagePermalink($camp->slug) ); ?>" class="campaign-card">
                                            <?php 
                                                if(!empty($camp->gallery) ) :
                                                    $logo = $camp->gallery[0]->source_path;
                                            ?>
                                            <div class="campaign-card__top">
                                                <div class="campaign-card__bg" style="background-image: url(<?php echo esc_url( $logo ); ?>);"></div>
                                                <img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_html( $camp->name ); ?>" class="campaign-card__img">                                                
                                            </div>
                                            <?php endif; ?>
                                            <div class="campaign-card__details">
                                                <h4 class="campaign-card__title">
                                                    <?php echo esc_html( $camp->name ); ?>
                                                </h4>
                                                <p class="campaign-card__description">
                                                    <?php echo strip_tags(\Crowdfundly_Helper::get_campaign_story($camp->story, 20)); ?>
                                                </p>
                                            </div>
                                            <div class="campaign-card__footer">
                                                <div class="progress progress--slim">
                                                    <div class="progress__bar progress__bar--secondary" style="width: <?php  echo esc_html( round(($camp->raised_amount*100)/$camp->target_amount) . '%'); ?>"></div>
                                                </div>
                                                <p class="campaign-card__amount">
                                                    <strong><i class="fas fa-hand-holding-usd"></i> <?php printf( '%s %s', round( $camp->raised_amount, 2 ), $camp->currency->currency_code ); ?></strong>
                                                    <?php printf( '%s %s %s', __('OF', 'crowdfundly'), $camp->target_amount, $camp->currency->currency_code ); ?>
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="section-placeholder">
                                    <div class="section-placeholder__inner">
                                        <div class="section-placeholder__icon">
                                            <span class="section-placeholder__icon-text">
                                                <i class="fas fa-bullhorn"></i>
                                            </span>
                                        </div>
                                        <h3 class="section-placeholder__title"><?php _e( 'Sorry', 'crowdfundly' ); ?></h3>
                                        <p class="section-placeholder__desc"> <?php _e( 'No campaigns to show', 'crowdfundly' ); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
    
                        <?php
                        $cf_all_campaign_load_more_hide = get_theme_mod( 'cf_all_campaign_load_more_hide', false );

                        $per_page_items = get_theme_mod( 'cf_all_camp_per_page', 15 );
                        $per_page_items = ! empty( $crowdfundly_elementor_settings['all_camp_per_page'] ) ? $crowdfundly_elementor_settings['all_camp_per_page'] : $per_page_items;
                        if ( ! empty( $data ) && $cf_all_campaign_load_more_hide != true && $per_page_items < $total_camps ) : ?>
                            <div class="load-more-btn-wrapper text-center">
                                <button
                                id="crowdfundly-all-camp-loadmore"
                                class="btn btn-primary mt-5" 
                                data-per-page="<?php echo esc_attr( $per_page_items ); ?>"
                                data-last-page="<?php echo esc_attr( $last_page ); ?>"
                                data-column="<?php echo esc_attr( $crowdfundly_all_camp_col ); ?>"
                                >
                                    <?php _e( 'Load More', 'crowdfundly' ); ?>
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>