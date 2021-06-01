<?php
/**
 * Render jobs landing page for shortcode
 * @since 1.0.0
 */
?>
<div class="easyjobs-shortcode-wrapper">
    <?php if (!empty($company)): ?>
        <div class="easyjobs-details">
            <?php if (!empty($company->cover_photo)): ?>
                <div class="ej-job-cover">
                    <img src="<?php echo $company->cover_photo[0]; ?>" alt="<?php echo $company->name; ?>">
                </div>
            <?php else: ?>
                <div class="ej-no-cover-photo"></div>
            <?php endif; ?>
            <div class="ej-header">
                <div class="ej-company-highlights">
                    <?php if(!get_theme_mod('easyjobs_landing_hide_company_info',false)):?>
                    <div class="ej-company-info">
                        <?php if(!get_theme_mod('easyjobs_landing_hide_company_logo',false)):?>
                        <div class="logo">
                            <img src="<?php echo $company->logo; ?>" alt="">
                        </div>
                        <?php endif;?>
                        <div class="info">
                            <h2 class="name"><?php echo $company->name;?></h2>
                            <?php if(!empty($company->address)):?>
                            <p class="location">
                                <i class="eicon e-map-maker"></i>
                                <span>
                                    <?php echo !empty($company->address->city->name) ? $company->address->city->name
                                        .', ': ''?>
                                    <?php echo !empty($company->address->country->name) ? $company->address->country->name : ''?>
                                </span>
                            </p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if(!get_theme_mod('easyjobs_landing_hide_company_website_button')):?>
                    <div class="ej-header-tools">
                        <a href="<?php echo $company->website; ?>" class="ej-btn ej-info-btn">
                            <?php _e('Explore company website', EASYJOBS_TEXTDOMAIN);?>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
                <?php if(!empty($company->description)): ?>
                    <?php if(!get_theme_mod('easyjobs_landing_hide_company_description',false)):?>
                        <div class="ej-company-description">
                           <?php echo $company->description; ?>
                        </div>
                    <?php endif;?>
                <?php endif; ?>
            </div>

            <div class="ej-job-body">
                <div class="ej-section">
                    <div class="ej-section-title">
                        <span class="ej-section-title-icon"><i class="eicon e-briefcase"></i></span>
                        <span class="ej-section-title-text">
                            <?php echo get_theme_mod('easyjobs_landing_job_list_heading', __('Open Job Positions',EASYJOBS_TEXTDOMAIN)
                            );?>
                        </span>
                    </div>
                    <div class="ej-section-content">
                        <?php echo do_shortcode('[easyjobs_list]')?>
                    </div>
                </div>
                <?php if(!empty($company->showcase_photo)): ?>
                <div class="ej-section">
                    <div class="ej-section-title">
                        <span class="ej-section-title-icon"><i class="eicon e-briefcase"></i></span>
                        <span class="ej-section-title-text">
                            <?php if(!empty($showcaseHeading = get_theme_mod('easyjobs_landing_showcase_heading'))): ?>
                            <?php echo $showcaseHeading; ?>
                            <?php else: ?>
                            <?php echo __('Life at ', EASYJOBS_TEXTDOMAIN) . $company->name; ?>
                            <?php endif; ?>
                        </span>
                    </div>
                    <div class="ej-section-content">
                        <div class="ej-company-showcase">
                            <div class="ej-showcase-inner">
                                <div class="ej-showcase-left">
                                    <div class="ej-showcase-image">
                                        <div class="ej-image">
                                            <img src="<?php echo $company->showcase_photo[0]; ?>"
                                                 alt="<?php echo $company->name; ?>">
                                        </div>
                                    </div>
                                </div>
                                <?php if (count($company->showcase_photo) > 1): ?>
                                    <div class="ej-showcase-right">
                                        <?php foreach ($company->showcase_photo as $key => $photo): ?>
                                            <?php
                                            if ($key === 0)
                                                continue;
                                            ?>
                                            <div class="ej-showcase-image">
                                                <div class="ej-image">
                                                    <img src="<?php echo $photo; ?>"
                                                         alt="<?php echo $company->name; ?>">
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif;?>
            </div>
        </div>
    <?php else: ?>
        <h3>
            <?php _e('No open jobs right now', EASYJOBS_TEXTDOMAIN); ?>
        </h3>
    <?php endif; ?>
</div>
