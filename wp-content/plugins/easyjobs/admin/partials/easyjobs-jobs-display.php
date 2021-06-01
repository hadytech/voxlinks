<?php

/**
 * Provide job list for plugin
 *
 * @link       https://easy.jobs
 * @since      1.0.0
 *
 * @package    Easyjobs
 * @subpackage Easyjobs/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    <hr class="wp-header-end">
    <div class="easy-page-body">
        <main class="content-area">
            <?php include( EASYJOBS_ADMIN_DIR_PATH .'/partials/easyjobs-admin-header.php');?>
            <?php $delete_nonce = wp_create_nonce('easyjobs_delete_job'); ?>
            <!-- content body -->
            <div class="content-area__body">
                <!-- user list -->
                <section class="published-jobs section-gap">
                    <div class="form-filter">
                        <div class="dropdown pipeline-action ej-job-type-select">
                            <button class="button white-button dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Published Jobs</button>
                            <ul class="dropdown-menu dropdown-menu-left nav-tab" role="tablist">
                                <a class="dropdown-item" href="#published-jobs" data-toggle="tab" role="tab" aria-controls="published-jobs" aria-selected="true">Published Jobs</a>
                                <a class="dropdown-item" href="#archive-jobs" data-toggle="tab" role="tab" aria-controls="published-jobs" aria-selected="false">Archived Jobs</a>
                                <a class="dropdown-item" href="#draft-jobs" data-toggle="tab" role="tab" aria-controls="draft-jobs" aria-selected="false">Draft Jobs</a>
                            </ul>
                        </div>
                        <div class="search-bar"><input type="text" class="easyjobs-job-search" placeholder="Search Job Name . . ." /></div>
                        <a href="<?php echo admin_url('admin.php?page=easyjobs'); ?>" class="button primary-button text-uppercase ml-auto">Create A new Job</a>
                    </div>
                    <?php if(!empty($jobs) && !empty($published_job_page_ids)): ?>
                    <div class="tab-content ej-tab-content">
                        <div class="tab-pane fade show active" id="published-jobs" role="tabpanel" aria-labelledby="published-jobs">
                            <div class="section-title-wrap">
                                <h2 class="section-title">
                                    <?php _e('Published Jobs', EASYJOBS_TEXTDOMAIN);?>
                                </h2>
                            </div>
                            <?php if(!empty($jobs->published)):?>
                                <div class="row row-cols-1 row-cols-lg-2 ej-jobs">
                                    <?php foreach ($jobs->published as $job) : ?>
                                    <div class="col">
                                        <div class="job-card">
                                            <div class="card-thumbnail" style="background-image: url('<?php echo $job->banner_image; ?>')">
                                                <?php if($job->is_expired): ?>
                                                    <div class="thumbnail__status thumbnail__status--danger">
                                                        <?php _e('Expired', EASYJOBS_TEXTDOMAIN); ?>
                                                    </div>
                                                <?php else: ?>
                                                    <?php echo Easyjobs_Helper::get_job_status_badge($job->status); ?>
                                                <?php endif; ?>
                                                <div class="card-control">
                                                    <a href="<?php echo admin_url('admin.php?page=easyjobs-admin&job-id=' . $job->id  . '&view=pipeline');?>" class="control-button control-button--primary">
                                                        <div class="control-button__icon">
                                                            <i class="eicon e-pipe"></i>
                                                        </div>
                                                        <span>
                                                            <?php _e('Pipeline', EASYJOBS_TEXTDOMAIN); ?>
                                                        </span>
                                                    </a>
                                                    <a href="<?php echo admin_url('admin.php?page=easyjobs-admin&job-id=' . $job->id . '&view=candidates'); ?>" class="control-button control-button--primary">
                                                        <div class="control-button__icon">
                                                            <i class="eicon e-users"></i>
                                                        </div>
                                                        <span>
                                                            <?php _e('Candidates', EASYJOBS_TEXTDOMAIN); ?>
                                                        </span>
                                                    </a>
                                                    <a href="<?php echo admin_url('admin.php?page=easyjobs#/edit/' . $job->id); ?>" class="control-button control-button--primary">
                                                        <div class="control-button__icon">
                                                            <i class="eicon e-document"></i>
                                                        </div>
                                                        <span>
                                                            <?php _e('Edit', EASYJOBS_TEXTDOMAIN); ?>
                                                        </span>
                                                    </a>
                                                    <div class="dropdown job-control-more">
                                                        <button class="control-button control-button--primary" data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">
                                                            <div class="control-button__icon">
                                                                <i class="eicon e-plus"></i>
                                                            </div>
                                                            <span>
                                                                <?php _e('More', EASYJOBS_TEXTDOMAIN); ?>
                                                            </span>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-center">
                                                            <a class="dropdown-item" href="<?php echo get_the_permalink($published_job_page_ids[$job->id]);?>" target="_blank">
                                                                <div class="dropdown-icon"><i class="eicon e-eye-1"></i></div>View
                                                            </a>
                                                            <a class="dropdown-item delete delete-job" href="#" data-job-id="<?php echo $job->id;?>" target="_blank" data-nonce="<?php echo $delete_nonce; ?>">
                                                                <div class="dropdown-icon"><i class="eicon e-delete"></i></div>Delete
                                                            </a>
                                                            <?php if(!empty($job->social_links)): ?>
                                                            <div class="share-button">
                                                                <a class="dropdown-item" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <div class="dropdown-icon"><i class="eicon e-share"></i></div>
                                                                    <?php _e('Share', EASYJOBS_TEXTDOMAIN); ?>
                                                                </a>
                                                                <div class="share-button-menu">
                                                                    <a class="dropdown-item" href="<?php echo $job->social_links->facebook; ?>">
                                                                        <div class="dropdown-icon"><i class="eicon e-facebook"></i></div>facebook
                                                                    </a>
                                                                    <a class="dropdown-item" href="<?php echo $job->social_links->linkedIn; ?>">
                                                                        <div class="dropdown-icon"><i class="eicon e-linkedin"></i></div>linkedin
                                                                    </a>
                                                                    <a class="dropdown-item" href="<?php echo $job->social_links->twitter; ?>">
                                                                        <div class="dropdown-icon"><i class="eicon e-twitter"></i></div>twitter
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <?php endif;?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-content">
                                                <div class="card-content__left">
                                                    <h3 class="card-title">
                                                        <?php echo $job->title; ?>
                                                    </h3>
                                                    <h4 class="card-sub-title">
                                                        <?php echo $job->category->name; ?>
                                                    </h4>
                                                    <div class="card-info-group">
                                                        <p class="card-info">
                                                            <?php _e('Post Date: ', EASYJOBS_TEXTDOMAIN)?>  <?php echo $job->created_at?>
                                                        </p>
                                                        <p class="card-info">
                                                          <?php _e('Expiry Date: ', EASYJOBS_TEXTDOMAIN)?>  <?php echo $job->expire_at?>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="card-content__right">
                                                    <p><?php echo $job->applicant_count; ?> <?php _e('Applied', EASYJOBS_TEXTDOMAIN)?></p>
                                                    <?php if(!empty($job->applicants)): ?>
                                                    <div class="applicants__img">
                                                        <?php foreach ($job->applicants as $applicant): ?>
                                                        <img src="<?php echo $applicant->image; ?>" alt="" />
                                                        <?php endforeach;?>
                                                        <p class="Applicants"><?php echo $job->applicant_count; ?></p>
                                                    </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <h4 class="empty-message">
                                    <?php _e('No jobs found.', EASYJOBS_TEXTDOMAIN);?>
                                </h4>
                            <?php endif;?>
                        </div>
                        <div class="tab-pane fade" id="archive-jobs" role="tabpanel" aria-labelledby="archive-jobs">
                            <div class="section-title-wrap">
                                <h2 class="section-title">
                                    <?php _e('Archived Jobs', EASYJOBS_TEXTDOMAIN);?>
                                </h2>
                            </div>
                            <?php if(!empty($jobs->archived)):?>
                                <div class="row row-cols-1 row-cols-lg-2 ej-jobs">
                                    <?php foreach ($jobs->archived as $job) : ?>
                                        <div class="col">
                                            <div class="job-card">
                                                <div class="card-thumbnail" style="background-image: url('<?php echo $job->banner_image; ?>')">
                                                    <?php if($job->is_expired): ?>
                                                        <div class="thumbnail__status thumbnail__status--danger">
                                                            <?php _e('Expired', EASYJOBS_TEXTDOMAIN); ?>
                                                        </div>
                                                    <?php else: ?>
                                                        <?php echo Easyjobs_Helper::get_job_status_badge($job->status); ?>
                                                    <?php endif; ?>
                                                    <div class="card-control">
                                                        <a href="<?php echo admin_url('admin.php?page=easyjobs-admin&job-id=' . $job->id  . '&view=pipeline');?>" class="control-button control-button--primary">
                                                            <div class="control-button__icon">
                                                                <i class="eicon e-pipe"></i>
                                                            </div>
                                                            <span>
                                                            <?php _e('Pipeline', EASYJOBS_TEXTDOMAIN); ?>
                                                        </span>
                                                        </a>
                                                        <a href="<?php echo admin_url('admin.php?page=easyjobs-admin&job-id=' . $job->id . '&view=candidates'); ?>" class="control-button control-button--primary">
                                                            <div class="control-button__icon">
                                                                <i class="eicon e-users"></i>
                                                            </div>
                                                            <span>
                                                            <?php _e('Candidates', EASYJOBS_TEXTDOMAIN); ?>
                                                        </span>
                                                        </a>
                                                        <a href="<?php echo admin_url('admin.php?page=easyjobs#/edit/' . $job->id); ?>"  class="control-button control-button--primary">
                                                            <div class="control-button__icon">
                                                                <i class="eicon e-document"></i>
                                                            </div>
                                                            <span>
                                                            <?php _e('Edit', EASYJOBS_TEXTDOMAIN); ?>
                                                        </span>
                                                        </a>
                                                        <a href="#" class="control-button control-button--danger delete-job" data-job-id="<?php echo $job->id;?>" data-nonce="<?php echo $delete_nonce; ?>">
                                                            <div class="control-button__icon">
                                                                <i class="eicon e-delete"></i>
                                                            </div>
                                                            <span>
                                                                <?php _e('Delete', EASYJOBS_TEXTDOMAIN); ?>
                                                            </span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="card-content">
                                                    <div class="card-content__left">
                                                        <h3 class="card-title">
                                                            <?php echo $job->title; ?>
                                                        </h3>
                                                        <h4 class="card-sub-title">
                                                            <?php echo $job->category->name; ?>
                                                        </h4>
                                                        <div class="card-info-group">
                                                            <p class="card-info">
                                                                <?php _e('Post Date: ', EASYJOBS_TEXTDOMAIN)?>  <?php echo $job->created_at?>
                                                            </p>
                                                            <p class="card-info">
                                                                <?php _e('Expiry Date: ', EASYJOBS_TEXTDOMAIN)?>  <?php echo $job->expire_at?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="card-content__right">
                                                        <p><?php echo $job->applicant_count; ?> <?php _e('Applied', EASYJOBS_TEXTDOMAIN)?></p>
                                                        <?php if(!empty($job->applicants)): ?>
                                                        <div class="applicants__img">
                                                            <?php foreach ($job->applicants as $applicant): ?>
                                                                <img src="<?php echo $applicant->image; ?>" alt="" />
                                                            <?php endforeach;?>
                                                            <p class="Applicants"><?php echo $job->applicant_count; ?></p>
                                                        </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <h4 class="empty-message">
                                    <?php _e('No jobs found.', EASYJOBS_TEXTDOMAIN);?>
                                </h4>
                            <?php endif;?>
                        </div>
                        <div class="tab-pane fade" id="draft-jobs" role="tabpanel" aria-labelledby="draft-jobs">
                            <div class="section-title-wrap">
                                <h2 class="section-title">
                                    <?php _e('Draft Jobs', EASYJOBS_TEXTDOMAIN);?>
                                </h2>
                            </div>
                            <?php if(!empty($jobs->draft)):?>
                                <div class="row row-cols-1 row-cols-lg-2 ej-jobs">
                                    <?php foreach ($jobs->draft as $job) : ?>
                                        <div class="col">
                                            <div class="job-card">
                                                <div class="card-thumbnail" style="background-image: url('<?php echo $job->banner_image; ?>')">
                                                    <?php if($job->is_expired): ?>
                                                        <div class="thumbnail__status thumbnail__status--danger">
                                                            <?php _e('Expired', EASYJOBS_TEXTDOMAIN); ?>
                                                        </div>
                                                    <?php else: ?>
                                                        <?php echo Easyjobs_Helper::get_job_status_badge($job->status); ?>
                                                    <?php endif; ?>
                                                    <div class="card-control">
                                                        <a href="<?php echo admin_url('admin.php?page=easyjobs-admin&job-id=' . $job->id  . '&view=pipeline');?>" class="control-button control-button--primary">
                                                            <div class="control-button__icon">
                                                                <i class="eicon e-pipe"></i>
                                                            </div>
                                                            <span>
                                                            <?php _e('Pipeline', EASYJOBS_TEXTDOMAIN); ?>
                                                        </span>
                                                        </a>
                                                        <a href="<?php echo admin_url('admin.php?page=easyjobs-admin&job-id=' . $job->id . '&view=candidates'); ?>" class="control-button control-button--primary">
                                                            <div class="control-button__icon">
                                                                <i class="eicon e-users"></i>
                                                            </div>
                                                            <span>
                                                            <?php _e('Candidates', EASYJOBS_TEXTDOMAIN); ?>
                                                        </span>
                                                        </a>
                                                        <a href="<?php echo admin_url('admin.php?page=easyjobs#/edit/' . $job->id); ?>" class="control-button control-button--primary">
                                                            <div class="control-button__icon">
                                                                <i class="eicon e-document"></i>
                                                            </div>
                                                            <span>
                                                            <?php _e('Edit', EASYJOBS_TEXTDOMAIN); ?>
                                                        </span>
                                                        </a>
                                                        <a href="#" class="control-button control-button--danger delete-job" data-job-id="<?php echo $job->id;?>" data-nonce="<?php echo $delete_nonce; ?>">
                                                            <div class="control-button__icon">
                                                                <i class="eicon e-delete"></i>
                                                            </div>
                                                            <span>
                                                                <?php _e('Delete', EASYJOBS_TEXTDOMAIN); ?>
                                                            </span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="card-content">
                                                    <div class="card-content__left">
                                                        <h3 class="card-title">
                                                            <?php echo $job->title; ?>
                                                        </h3>
                                                        <h4 class="card-sub-title">
                                                            <?php echo $job->category->name; ?>
                                                        </h4>
                                                        <div class="card-info-group">
                                                            <p class="card-info">
                                                                <?php _e('Post Date: ', EASYJOBS_TEXTDOMAIN)?>  <?php echo $job->created_at?>
                                                            </p>
                                                            <p class="card-info">
                                                                <?php _e('Expiry Date: ', EASYJOBS_TEXTDOMAIN)?>  <?php echo $job->expire_at?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="card-content__right">
                                                        <p><?php echo $job->applicant_count; ?> <?php _e('Applied', EASYJOBS_TEXTDOMAIN)?></p>
                                                        <?php if(!empty($job->applicants)): ?>
                                                        <div class="applicants__img">
                                                            <?php foreach ($job->applicants as $applicant): ?>
                                                                <img src="<?php echo $applicant->image; ?>" alt="" />
                                                            <?php endforeach;?>
                                                            <p class="Applicants"><?php echo $job->applicant_count; ?></p>
                                                        </div>
                                                        <?php endif;?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <h4 class="empty-message">
                                    <?php _e('No jobs found.', EASYJOBS_TEXTDOMAIN);?>
                                </h4>
                            <?php endif;?>
                        </div>
                    </div>
                    <?php else: ?>
                        <h4 class="empty-message">
                            <?php _e('No jobs found.', EASYJOBS_TEXTDOMAIN);?>
                        </h4>
                    <?php endif; ?>
                </section>
            </div>
        </main>
    </div>
</div>
