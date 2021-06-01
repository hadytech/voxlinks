<?php
/**
 * Render job list for shortcode
 * @since 1.0.0
 */
?>

<?php if(!empty($jobs) && !empty($job_with_page_id)): ?>
    <div class="easyjobs-shortcode-wrapper">
        <div class="ej-job-list">
            <?php foreach ($jobs as $job): ?>
                <?php
                    if($job->is_expired){
                        continue;
                    }
                ?>
                <div class="ej-job-list-item">
                    <div class="ej-job-list-item-inner">
                        <div class="ej-job-list-item-col">
                            <h2 class="ej-job-title">
                                <a href="<?php echo get_the_permalink($job_with_page_id[$job->id]);?>"><?php echo $job->title; ?></a>
                            </h2>
                            <?php if(!get_theme_mod('easyjobs_landing_hide_job_metas',false)): ?>
                            <div class="ej-job-list-info">
                                <div class="ej-job-list-info-block">
                                    <i class="eicon e-briefcase-2"></i>
                                    <a href="<?php echo $job->company_easyjob_url;?>" target="_blank">
                                        <?php echo $job->company_name; ?>
                                    </a>
                                </div>
                                <div class="ej-job-list-info-block">
                                    <i class="eicon e-map-maker"></i>
                                    <?php if($job->is_remote): ?>
                                    <span><?php _e('Anywhere (Remote)', EASYJOBS_TEXTDOMAIN); ?></span>
                                    <?php else: ?>
                                    <span>
                                        <?php if(!empty($job->job_address->city)) : ?>
                                        <?php echo $job->job_address->city->name?>
                                        <?php endif; ?>
                                        <?php if(!empty($job->job_address->country)) : ?>
                                        , <?php echo $job->job_address->country->name; ?>
                                        <?php endif; ?>
                                    </span>
                                    <?php endif?>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="ej-job-list-item-col">
                            <?php
                            if (!$job->is_expired):
                                ?>
                                <p class="ej-deadline">
                                    <?php echo $job->expire_at; ?>
                                </p>
                                <p class="ej-list-sub">
                                    No of vacancies: <?php echo $job->vacancies; ?>
                                </p>
                            <?php else: ?>
                                <p class="ej-list-title ej-expired">
                                    <?php _e('Expired', EASYJOBS_TEXTDOMAIN); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                        <div class="ej-job-list-item-col">
                            <a href="<?php echo !empty($job->apply_url) ? $job->apply_url : '#';?>" class="ej-btn ej-info-btn-light" target="_blank">Apply</a>
                        </div>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
    </div>
<?php else: ?>
    <h3>
        <?php _e('No open jobs right now', EASYJOBS_TEXTDOMAIN ); ?>
    </h3>
<?php endif; ?>
