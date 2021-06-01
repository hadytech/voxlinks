<?php
    /**
     * Render job details for shortcode
     * @since 1.0.0
     */
    global $post;
?>
<div class="easyjobs-shortcode-wrapper">
    <?php if(!empty($company) && !empty($job)): ?>
        <?php
        /**
         * Hooks anything before job details
         * @since 1.0.0
         */
        do_action('easyjobs_before_job_details');
        ?>
        <div class="easyjobs-details">
            <?php if(get_theme_mod('easyjobs_single_display_job_banner',true)): ?>
            <?php if(!empty($job->banner_image)):?>
                <div class="ej-job-cover">
                    <img src="<?php echo $job->banner_image; ?>" alt="<?php echo !empty($company->name) ?
                        $company->name : '';
                    ?>">
                </div>
            <?php else: ?>
                <div class="ej-no-cover-photo"></div>
            <?php endif; ?>
            <?php endif; ?>
            <div class="ej-job-header">
                <div class="ej-job-header-left">
                    <div class="ej-job-overview">
                        <?php if(!get_theme_mod('easyjobs_single_hide_company_info',false)): ?>
                        <div class="ej-company-info">
                            <?php if(!get_theme_mod('easyjobs_single_hide_company_logo',false)): ?>
                                <?php if(!empty($company->logo)): ?>
                                <div class="logo">
                                    <img src="<?php echo $company->logo; ?>" alt="">
                                </div>
                                <?php endif; ?>
                            <?php endif; ?>
                            <div class="info">
                                <h2 class="name"><?php echo $company->name;?></h2>
                                <?php if(!empty($company->address)): ?>
                                <p class="location">
                                    <i class="eicon e-map-maker"></i>
                                    <span>
                                        <?php if(!empty($company->address->country) || !empty($company->address->city)) : ?>
                                            <?php if(!empty($company->address->city)): ?>
                                                <?php echo $company->address->city->name; ?>
                                            <?php endif; ?>
                                            <?php if(!empty($company->address->country->name)): ?>
                                             , <?php echo $company->address->country->name; ?>
                                            <?php endif;?>
                                        <?php else: ?>
                                            <?php _e('No location found', EASYJOBS_TEXTDOMAIN);?>
                                        <?php endif; ?>
                                    </span>
                                </p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="ej-job-highlights">
                            <div class="ej-job-highlights-item">
                                <div class="ej-job-highlights-item-label">
                                    <?php _e('Job Title', EASYJOBS_TEXTDOMAIN ); ?>
                                </div>
                                <div class="ej-job-highlights-item-value">
                                    <?php echo !empty($job->title) ? $job->title : ''; ?>
                                </div>
                            </div>
                            <div class="ej-job-highlights-item">
                                <div class="ej-job-highlights-item-label">
                                    <?php _e('Vacancies', EASYJOBS_TEXTDOMAIN ); ?>
                                </div>
                                <div class="ej-job-highlights-item-value">
                                    <?php echo !empty($job->vacancies) ? $job->vacancies : 0; ?>
                                </div>
                            </div>
                            
                            <div class="ej-job-highlights-item">
                                <div class="ej-job-highlights-item-label">
                                    <?php _e('Salary', EASYJOBS_TEXTDOMAIN ); ?>
                                </div>
                                <div class="ej-job-highlights-item-value">
                                    <?php echo $job->salary . ' ' . $job->salary_type->name; ?>
                                </div>
                            </div>
                            <div class="ej-job-highlights-item">
                                <div class="ej-job-highlights-item-label">
                                    <?php _e('Office time', EASYJOBS_TEXTDOMAIN ); ?>
                                </div>
                                <div class="ej-job-highlights-item-value">
                                    <?php echo $job->office_time; ?>
                                </div>
                            </div>
                            <div class="ej-job-highlights-item">
                                <div class="ej-job-highlights-item-label">
                                    <?php _e('Location', EASYJOBS_TEXTDOMAIN ); ?>
                                </div>
                                <div class="ej-job-highlights-item-value">
                                    <?php if($job->is_remote): ?>
                                        <?php _e('Anywhere', EASYJOBS_TEXTDOMAIN); ?>
                                    <?php else: ?>
                                        <?php echo $job->city->name .', ' . $job->country->name; ?>
                                    <?php endif?>
                                </div>
                            </div>
                            <div class="ej-job-highlights-item">
                                <div class="ej-job-highlights-item-label">
                                    <?php _e('Job Type', EASYJOBS_TEXTDOMAIN ); ?>
                                </div>
                                <div class="ej-job-highlights-item-value">
                                    <?php echo $job->employment_type->name; ?>
                                    <?php if($job->is_remote): ?>
                                        <span class="ej-remote-label"><?php _e('Remote', EASYJOBS_TEXTDOMAIN);?></span>
                                    <?php endif?>
                                </div>
                            </div>
                            <div class="ej-job-highlights-item">
                                <div class="ej-job-highlights-item-label">
                                    <?php _e('Deadline', EASYJOBS_TEXTDOMAIN ); ?>
                                </div>
                                <div class="ej-job-highlights-item-value">
                                    <?php echo date('d F, Y', strtotime(str_replace(', ', '', $job->expire_at))); ?>
                                </div>
                            </div>
                        </div>
                        <div class="ej-job-overview-footer">
                            <div class="ej-apply-link">
                                <a href="<?php echo $job->apply_url; ?>" class="ej-btn ej-info-btn" target="_blank"> Apply now</a>
                            </div>
                            <?php if(!get_theme_mod('easyjobs_single_disable_social_sharing',false)): ?>
                            <div class="ej-social-share">
                                <p class="ej-social-share-title">Share On: </p>
                                <ul>
                                    <?php if(!get_theme_mod('easyjobs_single_disable_social_sharing_fb',false)): ?>
                                    <li>
                                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_the_permalink().'&title='. $job->title);?>" class="ej-social-button ej-facebook">
                                            <svg id="Bold" enable-background="new 0 0 24 24" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m15.997 3.985h2.191v-3.816c-.378-.052-1.678-.169-3.192-.169-3.159 0-5.323 1.987-5.323 5.639v3.361h-3.486v4.266h3.486v10.734h4.274v-10.733h3.345l.531-4.266h-3.877v-2.939c.001-1.233.333-2.077 2.051-2.077z"/></svg>
                                        </a>
                                    </li>
                                    <?php endif; ?>
                                    <?php if(!get_theme_mod('easyjobs_single_disable_social_sharing_twitter',false)): ?>
                                    <li>
                                        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_the_permalink().'&text='. $job->title);?>" class="ej-social-button ej-twitter">
                                            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                 viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                                <g>
                                                    <path d="M512,97.248c-19.04,8.352-39.328,13.888-60.48,16.576c21.76-12.992,38.368-33.408,46.176-58.016
                                                            c-20.288,12.096-42.688,20.64-66.56,25.408C411.872,60.704,384.416,48,354.464,48c-58.112,0-104.896,47.168-104.896,104.992
                                                            c0,8.32,0.704,16.32,2.432,23.936c-87.264-4.256-164.48-46.08-216.352-109.792c-9.056,15.712-14.368,33.696-14.368,53.056
                                                            c0,36.352,18.72,68.576,46.624,87.232c-16.864-0.32-33.408-5.216-47.424-12.928c0,0.32,0,0.736,0,1.152
                                                            c0,51.008,36.384,93.376,84.096,103.136c-8.544,2.336-17.856,3.456-27.52,3.456c-6.72,0-13.504-0.384-19.872-1.792
                                                            c13.6,41.568,52.192,72.128,98.08,73.12c-35.712,27.936-81.056,44.768-130.144,44.768c-8.608,0-16.864-0.384-25.12-1.44
                                                            C46.496,446.88,101.6,464,161.024,464c193.152,0,298.752-160,298.752-298.688c0-4.64-0.16-9.12-0.384-13.568
                                                            C480.224,136.96,497.728,118.496,512,97.248z"/>
                                                </g>
                                            </svg>
                                        </a>
                                    </li>
                                    <?php endif; ?>
                                    <?php if(!get_theme_mod('easyjobs_single_disable_social_sharing_linkedin',false))
                                        : ?>
                                    <li>
                                        <a href="http://www.linkedin.com/shareArticle?url=<?php echo urlencode(get_the_permalink().'&title='. $job->title . '&mini=true');?>" class="ej-social-button ej-linkedin">
                                            <svg id="Bold-1" enable-background="new 0 0 24 24" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m23.994 24v-.001h.006v-8.802c0-4.306-.927-7.623-5.961-7.623-2.42 0-4.044 1.328-4.707 2.587h-.07v-2.185h-4.773v16.023h4.97v-7.934c0-2.089.396-4.109 2.983-4.109 2.549 0 2.587 2.384 2.587 4.243v7.801z"/><path d="m.396 7.977h4.976v16.023h-4.976z"/><path d="m2.882 0c-1.591 0-2.882 1.291-2.882 2.882s1.291 2.909 2.882 2.909 2.882-1.318 2.882-2.909c-.001-1.591-1.292-2.882-2.882-2.882z"/></svg>
                                        </a>
                                    </li>
                                    <?php endif;?>
                                </ul>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="ej-job-header-right">
                    <div class="ej-content-block">
                        <h1><?php echo __('Company Description ', EASYJOBS_TEXTDOMAIN);  ?></h1>
                        <?php echo !empty($company->description) ? $company->description : ''; ?>
                    </div>
                    <?php if(!empty($job->skills)): ?>
                    <div class="ej-section">
                        <div class="ej-section-title">
                            <span class="ej-section-title-icon"><i class="eicon e-edit"></i></span>
                            <span class="ej-section-title-text">Skills</span>
                        </div>
                        <div class="ej-section-content with-margin">
                            <ul class="ej-job-skills">
                                <?php foreach ($job->skills as $key => $skill): ?>
                                    <li>
                                        <?php echo Easyjobs_Helper::get_dynamic_label($key, $skill->name);?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="ej-job-body">
                <?php if(!empty($job->requirements)): ?>
                <div class="ej-section">
                    <div class="ej-section-content">
                        <div class="ej-content-block">
                            <h1><?php echo get_theme_mod('easyjobs_single_job_description_title',__('So If You Are Someone Who Has', EASYJOBS_TEXTDOMAIN)); ?></h1>
                            <?php echo $job->requirements; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php if(!empty($job->responsibilies)): ?>
                    <div class="ej-section">
                        <div class="ej-section-title">
                            <span class="ej-section-title-icon"><i class="eicon e-briefcase"></i></span>
                            <span class="ej-section-title-text">
                                <?php _e('Job Responsibilities ', EASYJOBS_TEXTDOMAIN ); ?>
                            </span>
                        </div>
                        <div class="ej-section-content">
                            <div class="ej-content-block">
                                <?php echo $job->responsibilies; ?>
                            </div>

                        </div>
                    </div>
                <?php endif; ?>
                <?php if(!empty($job->other_benefits)): ?>

                    <div class="ej-section">
                        <div class="ej-section-title">
                            <span class="ej-section-title-icon"><i class="eicon e-briefcase"></i></span>
                            <span class="ej-section-title-text">
                                <?php _e('Benefits ', EASYJOBS_TEXTDOMAIN ); ?>
                            </span>
                        </div>
                        <div class="ej-section-content">
                            <div class="ej-content-block">
                                <?php echo $job->company_data->creator->company->benefits;?>
                            </div>

                        </div>
                    </div>
                <?php endif; ?>
                <?php if(!empty($company->showcase_photo)): ?>
                    <div class="ej-section">
                        <div class="ej-section-title">
                            <span class="ej-section-title-icon"><i class="eicon e-briefcase"></i></span>
                            <span class="ej-section-title-text"><?php echo __('Life at ', EASYJOBS_TEXTDOMAIN) . $company->name; ?></span>
                        </div>
                        <div class="ej-section-content">
                            <div class="ej-company-showcase">
                                <div class="ej-showcase-inner">
                                    <div class="ej-showcase-left">
                                        <div class="ej-showcase-image">
                                            <div class="ej-image">
                                                <img src="<?php echo $company->showcase_photo[0]; ?>" alt="<?php echo $company->name; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <?php if(count($company->showcase_photo) > 1): ?>
                                        <div class="ej-showcase-right">
                                            <?php foreach ($company->showcase_photo as $key => $photo): ?>
                                                <?php
                                                if($key === 0)
                                                    continue;
                                                ?>
                                                <div class="ej-showcase-image">
                                                    <div class="ej-image">
                                                        <img src="<?php echo $photo; ?>" alt="<?php echo !empty
                                                        ($company->name) ? $company->name : ''; ?>">
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
        /**
         * Hooks anything after job details
         * @since 1.0.0
         */
        do_action('easyjobs_after_job_details');
        ?>
    <?php endif;?>
</div>
