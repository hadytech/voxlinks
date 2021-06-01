<?php

/**
 * Provide a dashboard area view for the plugin
 *
 * This file is used to markup the admin dashboard of the plugin.
 *
 * @link       https://easy.jobs
 * @since      1.0.5
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
            <!-- content body -->
            <div class="content-area__body">
                <?php if(!empty($company_stats)): ?>
                <!-- counter info -->
                <section class="counter-box section-gap">
                    <div class="row row-cols-md-4">
                        <div class="col">
                            <div class="counter__card">
                                <div class="counter__card__icon gradient-danger">
                                    <i class="eicon e-users"></i>
                                </div>
                                <div class="counter__card__text">
                                    <h4><?php echo !empty($company_stats->active_candidates) ? $company_stats->active_candidates : 0; ?></h4>
                                    <p><?php _e('Active Candidates', EASYJOBS_TEXTDOMAIN)?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <a href="#" class="counter__card">
                                <div class="counter__card__icon gradient-love">
                                    <i class="eicon e-briefcase"></i>
                                </div>
                                <div class="counter__card__text">
                                    <h4><?php echo !empty($company_stats->published_jobs) ? $company_stats->published_jobs : 0;?></h4>
                                    <p><?php _e('Active Jobs', EASYJOBS_TEXTDOMAIN);?></p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="#" class="counter__card">
                                <div class="counter__card__icon gradient-warning">
                                    <i class="eicon e-briefcase"></i>
                                </div>
                                <div class="counter__card__text">
                                    <h4><?php echo !empty($company_stats->draft_jobs) ? $company_stats->draft_jobs : 0; ?></h4>
                                    <p><?php _e('Draft Jobs', EASYJOBS_TEXTDOMAIN)?></p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="#" class="counter__card">
                                <div class="counter__card__icon gradient-info">
                                    <i class="eicon e-users-team"></i>
                                </div>
                                <div class="counter__card__text">
                                    <h4><?php echo !empty($company_stats->managers) ? $company_stats->managers : 0; ?></h4>
                                    <p><?php _e('Team Member', EASYJOBS_TEXTDOMAIN);?></p>
                                </div>
                            </a>
                        </div>
                    </div>
                </section>
                <?php endif; ?>
                <?php if(!empty($recent_applicants)): ?>
                <!-- user list -->
                <section class="user-list section-gap">
                    <div class="section-title-wrap">
                        <h2 class="section-title"><?php _e('Recent Applications', EASYJOBS_TEXTDOMAIN);?></h2>
                    </div>
                    <div class="row row-cols-xl-5">
                        <?php foreach ($recent_applicants as $applicant): ?>
                        <div class="col">
                            <div class="user-card <?php echo $applicant->showAiScore ? 'has-ai-score' : '' ;?>">
                                <div class="user__ratting info-button-light"><i class="eicon e-star"></i> <?php echo
                                    $applicant->rating?></div>
                                <div class="user-picture">
                                    <?php if($ai_enabled && $applicant->showAiScore): ?>
                                        <?php Easyjobs_Helper::get_ai_score_chart($applicant->scores)?>
                                    <?php endif;?>
                                    <img src="<?php echo $applicant->profile_image; ?>" alt="applicant-img"
                                         class="img-fluid" />
                                </div>
                                <div class="user-info">
                                    <h5><?php echo$applicant->name; ?></h5>
                                    <p><?php echo $applicant->job_title?></p>
                                </div>
                                <a href="<?php echo admin_url( 'admin.php?page=easyjobs-admin&candidate-id=' .
                                    $applicant->id ); ?>" class="semi-button semi-button-info mt-auto">View Details</a>
                                <?php if($ai_enabled && $applicant->showAiScore && !empty($applicant->scores)):?>
                                    <?php Easyjobs_Helper::get_ai_score_details($applicant->scores);?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                </section>
                <?php endif;?>
                <?php if(!empty($recent_jobs) && !empty($job_page_ids)): ?>
                <!-- data table -->
                <section class="data-table section-gap" id="easyjobs-recent-jobs">
                    <div class="section-title-wrap">
                        <h2 class="section-title">
                            <?php _e('Recent Jobs', EASYJOBS_TEXTDOMAIN);?>
                        </h2>
                    </div>
                    
                    <div class="table-wrap mb-3">
                        <div class="table">
                            <div class="table__row table__head">
                                <div class="table-cell">Job Title</div>
                                <div class="table-cell">Applicants</div>
                                <div class="table-cell text-center">Status</div>
                                <div class="table-cell text-center">Deadline</div>
                                <div class="table-cell text-center">Actions</div>
                            </div>
                            <?php foreach ($recent_jobs->data as $recent_job): ?>
                            <div class="table__row">
                                <div class="table-cell designation">
                                    <a href="<?php echo admin_url('admin.php?page=easyjobs-admin&job-id=' . $recent_job->id  . '&view=pipeline');?>">
                                        <?php echo $recent_job->title;?>
                                    </a>
                                </div>
                                <div class="table-cell applicant-list">
                                    <div class="applicant-list__wrap">
                                        <?php if(!empty($recent_job->applicants)): ?>
                                        <a href="<?php echo admin_url('admin.php?page=easyjobs-admin&job-id=' . $recent_job->id . '&view=candidates'); ?>" class="applicants__img">
                                            <?php $key = 0;?>
                                            <?php foreach ($recent_job->applicants as $applicant_image): $key++;?>
                                            <?php if($key < 4): ?>
                                            <img src="<?php echo $applicant_image->image; ?>" alt="" />
                                            <?php else:?>
                                                <?php if(($recent_job->applicant_count >= 10) && $key < 5): ?>
                                                    <img src="<?php echo $applicant_image->image; ?>" alt="" />
                                                <?php endif;?>
                                            <?php endif; ?>
                                            <?php endforeach;?>
                                            <p class="Applicants"><?php echo $recent_job->applicant_count; ?></p>
                                        </a>
                                        <?php else: ?>
                                            <p class="Applicants">
                                                <?php _e('0 applied', EASYJOBS_TEXTDOMAIN); ?>
                                            </p>
                                        <?php endif; ?>
                                        <small class="applicants__number"><?php echo $recent_job->applicant_count; ?> Applied</small>
                                    </div>
                                </div>
                                <div class="table-cell job__status">
                                    <?php if(!$recent_job->is_expired): ?>
                                    <span class="success-label"><?php _e('Active', EASYJOBS_TEXTDOMAIN); ?></span>
                                    <?php else: ?>
                                    <span class="danger-label"><?php _e('Expired', EASYJOBS_TEXTDOMAIN); ?></span>
                                    <?php endif?>
                                </div>
                                <div class="table-cell job__deadline">
                                    <div class="deadline__text">
                                        <p><?php echo $recent_job->expire_at; ?></p>
                                        <small><?php echo $recent_job->days_left; ?></small>
                                    </div>
                                </div>
                                <div class="table-cell author-action">
                                    <a href="<?php echo get_the_permalink($job_page_ids[$recent_job->id]); ?>"
                                       class="social-button semi-button-success" target="_blank"><i class="eicon e-eye-alt"></i></a>
                                    <a href="<?php echo admin_url('admin.php?page=easyjobs#/edit/') . $recent_job->id; ?>" class="social-button semi-button-primary"><i class="eicon e-document"></i></a>
                                    <div class="job-share-dashboard">
                                        <a href="" class="social-button semi-button-info"><i class="eicon e-share"></i></a>
                                        <div class="share-button-menu">
                                            <a class="dropdown-item" href="<?php echo $recent_job->social_links->facebook; ?>">
                                                <div class="dropdown-icon"><i class="eicon e-facebook"></i></div>
                                                facebook
                                            </a>
                                            <a class="dropdown-item" href="<?php echo
                                            $recent_job->social_links->linkedIn; ?>">
                                                <div class="dropdown-icon"><i class="eicon e-linkedin"></i></div>
                                                linkedin
                                            </a>
                                            <a class="dropdown-item" href="<?php echo
                                            $recent_job->social_links->twitter; ?>"">
                                                <div class="dropdown-icon"><i class="eicon e-twitter"></i></div>
                                                twitter
                                            </a>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                    <?php if(!empty($total_page) && $total_page > 1): ?>
                    <ul class="pagination-list">
                        <li class="pagination-list__item">
                            <a class="pagination-list__link easyjobs-prev-page-link" href="#">
                                <i class="eicon e-arrow-left"></i>
                            </a>
                        </li>
                        <?php for($i=1; $i<=$total_page; $i++):?>
                        <li class="pagination-list__item <?php echo $recent_jobs->current_page == $i ? 'pagination-list__item--active':'';?>">
                            <a class="pagination-list__link" href="<?php echo admin_url( 'admin.php?page=easyjobs-admin&recent-jobs-page=' .
                                $i .'#easyjobs-recent-jobs' );  ?>"><?php echo $i;?></a>
                        </li>
                        <?php endfor;?>
                        <li class="pagination-list__item">
                            <a class="pagination-list__link easyjobs-next-page-link" href="#" >
                                <i class="eicon e-arrow-right"></i>
                            </a>
                        </li>
                    </ul>
                    <?php endif;?>
                </section>
                <?php endif; ?>
                <?php if(empty($recent_applicants) && empty($recent_jobs->data)) : ?>
                <section class="ej-welcome">
                    <div class="container">
                        <div class="row justify-content-center p-0">
                            <div class="col-md-10 text-center">
                                <h1 class="mb-4"><?php _e('Welcome to Easy.jobs');?></h1>
                                <div class="video p-3 bg-white">
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/xp1E65oLnlc?rel=0" allowfullscreen></iframe>
                                    </div>
                                </div>
                                <div class="ej-welcome-cta mt-4 d-flex justify-content-center align-content-center w-100">
                                    <a href="<?php echo admin_url('admin.php?page=easyjobs#/create');?>" class="button primary-button">Create a job post</a>
                                    <a href="https://easy.jobs/docs/" target="_blank" class="button primary-button ml-4">How to use EasyJobs</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <?php endif; ?>
            </div>
            <?php if(isset($_GET['welcome']) && trim($_GET['welcome']) === 'yes'): ?>
            <div class="modal fade show ej-modal ej-greeting-modal" id="ej-greeting-modal">
                <div role="document" class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close greeting-close-btn">
                            <span aria-hidden="true">×</span>
                        </button>
                        <div class="ej-greeting">
                            <div class="thumb">
                                <img src="<?php echo EASYJOBS_ADMIN_URL; ?>assets/img/greet-thumb.png" alt="">
                            </div>
                            <div class="greet__content">
                                <h2>Welcome To Easy.Jobs</h2>
                                <p>Congrats! Your Easy.Jobs account has been created. Now you can establish your employer brand, find the right candidate quicker, and more</p>
                                <div class="next__attempts">
                                    <a href="<?php echo Easyjobs_Helper::customizer_link(); ?>">
                                        <div class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="42.657" viewBox="0 0 40 42.657">
                                                <g id="promotion" transform="translate(-15.947)">
                                                    <g id="Group_1266" data-name="Group 1266" transform="translate(28.314)">
                                                        <g id="Group_1265" data-name="Group 1265">
                                                            <path id="Path_1690" data-name="Path 1690" d="M177.264,8.666a5.066,5.066,0,0,0,1.4-3.5,5.086,5.086,0,1,0-10.171,0,5.066,5.066,0,0,0,1.4,3.5,7.634,7.634,0,0,0-3.94,6.675v1.271a1.271,1.271,0,0,0,1.271,1.271h12.714a1.271,1.271,0,0,0,1.271-1.271V15.342A7.634,7.634,0,0,0,177.264,8.666Zm-3.688-6.123a2.621,2.621,0,0,1,2.543,2.628,2.543,2.543,0,1,1-5.086,0A2.621,2.621,0,0,1,173.575,2.543Zm-5.086,12.8a5.086,5.086,0,1,1,10.171,0Z" transform="translate(-165.947)"/>
                                                        </g>
                                                    </g>
                                                    <g id="Group_1268" data-name="Group 1268" transform="translate(15.947 22.23)">
                                                        <g id="Group_1267" data-name="Group 1267">
                                                            <path id="Path_1691" data-name="Path 1691" d="M54.688,278.628H43.441v-6.357A1.261,1.261,0,0,0,42.191,271h-12.5a1.261,1.261,0,0,0-1.25,1.271v3.814H17.2a1.261,1.261,0,0,0-1.25,1.271v12.8a1.261,1.261,0,0,0,1.25,1.271H54.688a1.261,1.261,0,0,0,1.25-1.271V279.9A1.261,1.261,0,0,0,54.688,278.628ZM28.444,288.885h-10V278.628h10Zm12.5,0h-10V273.543h10Zm12.5,0h-10v-7.713h10Z" transform="translate(-15.947 -271)"/>
                                                        </g>
                                                    </g>
                                                    <g id="Group_1270" data-name="Group 1270" transform="translate(15.956 12.375)">
                                                        <g id="Group_1269" data-name="Group 1269">
                                                            <path id="Path_1692" data-name="Path 1692" d="M28.064,154.826l-3.011-1.506-1.506-3.011a1.271,1.271,0,0,0-2.274,0l-1.506,3.011-3.011,1.506a1.271,1.271,0,0,0,0,2.274l3.011,1.506,1.506,3.011a1.271,1.271,0,0,0,2.274,0l1.506-3.011,3.011-1.506a1.271,1.271,0,0,0,0-2.274Zm-4.528,1.7a1.271,1.271,0,0,0-.569.569l-.558,1.116-.558-1.116a1.272,1.272,0,0,0-.569-.569l-1.116-.558,1.116-.558a1.272,1.272,0,0,0,.569-.569l.558-1.116.558,1.116a1.271,1.271,0,0,0,.569.569l1.116.558Z" transform="translate(-16.053 -149.606)"/>
                                                        </g>
                                                    </g>
                                                    <g id="Group_1272" data-name="Group 1272" transform="translate(43.233 12.375)">
                                                        <g id="Group_1271" data-name="Group 1271">
                                                            <path id="Path_1693" data-name="Path 1693" d="M358.063,154.826l-3.011-1.506-1.506-3.011a1.271,1.271,0,0,0-2.274,0l-1.506,3.011-3.011,1.506a1.271,1.271,0,0,0,0,2.274l3.011,1.506,1.506,3.011a1.271,1.271,0,0,0,2.274,0l1.506-3.011,3.011-1.506a1.272,1.272,0,0,0,0-2.274Zm-4.528,1.7a1.271,1.271,0,0,0-.569.569l-.558,1.116-.558-1.116a1.272,1.272,0,0,0-.569-.569l-1.116-.558,1.116-.558a1.272,1.272,0,0,0,.569-.569l.558-1.116.558,1.116a1.271,1.271,0,0,0,.569.569l1.116.558Z" transform="translate(-346.052 -149.606)"/>
                                                        </g>
                                                    </g>
                                                </g>
                                            </svg>
                                        </div>
                                        <p>Setup Career Page</p>
                                    </a>
                                    <a href="<?php echo admin_url('admin.php?page=easyjobs#/create');?>">
                                        <div class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="41" height="41" viewBox="0 0 41 41">
                                                <g id="sticky-notes" transform="translate(0.5 0.5)">
                                                    <path id="Path_1694" data-name="Path 1694" d="M30.833,36.731H4.167A4.176,4.176,0,0,1,0,32.556V9.175A4.176,4.176,0,0,1,4.167,5H15.833a.835.835,0,0,1,0,1.67H4.167a2.506,2.506,0,0,0-2.5,2.505V32.556a2.506,2.506,0,0,0,2.5,2.505H30.488L38.333,27.2V9.175a2.506,2.506,0,0,0-2.5-2.505H24.167a.835.835,0,0,1,0-1.67H35.833A4.176,4.176,0,0,1,40,9.175v18.37a.842.842,0,0,1-.243.591l-8.333,8.35A.838.838,0,0,1,30.833,36.731Zm8.333-9.185h.017Z" transform="translate(0 3.269)"  stroke-width="1"/>
                                                    <path id="Path_1695" data-name="Path 1695" d="M18.827,27.923A.827.827,0,0,1,18,27.1V18.827A.827.827,0,0,1,18.827,18H27.1a.827.827,0,0,1,0,1.654H19.654V27.1A.827.827,0,0,1,18.827,27.923Z" transform="translate(12.077 12.077)"  stroke-width="1"/>
                                                    <path id="Path_1696" data-name="Path 1696" d="M12.327,12.923A.827.827,0,0,1,11.5,12.1V3.827a.827.827,0,1,1,1.654,0V12.1A.827.827,0,0,1,12.327,12.923Z" transform="translate(7.673 1.962)"  stroke-width="1"/>
                                                    <path id="Path_1697" data-name="Path 1697" d="M13.308,6.615a3.308,3.308,0,1,1,3.308-3.308A3.311,3.311,0,0,1,13.308,6.615Zm0-4.962a1.654,1.654,0,1,0,1.654,1.654A1.656,1.656,0,0,0,13.308,1.654Z" transform="translate(6.692 0)"  stroke-width="1"/>
                                                    <path id="Path_1698" data-name="Path 1698" d="M29.933,12.654H4.837a.827.827,0,1,1,0-1.654h25.1a.827.827,0,1,1,0,1.654Z" transform="translate(2.615 7.339)"  stroke-width="1"/>
                                                    <path id="Path_1699" data-name="Path 1699" d="M29.933,16.654H4.837a.827.827,0,1,1,0-1.654h25.1a.827.827,0,1,1,0,1.654Z" transform="translate(2.615 10.008)"  stroke-width="1"/>
                                                    <path id="Path_1700" data-name="Path 1700" d="M23.019,20.654H4.827a.827.827,0,0,1,0-1.654H23.019a.827.827,0,0,1,0,1.654Z" transform="translate(2.718 12.677)"  stroke-width="1"/>
                                                </g>
                                            </svg>
                                        </div>
                                        <p>Create a Job Post</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </main>

    </div>
</div>
