<div class="wrap">
    <hr class="wp-header-end">
    <div class="easyjobs-wrapper admin-area">
        <div class="easy-page-body">
            <main class="content-area">
                <?php include( EASYJOBS_ADMIN_DIR_PATH .'/partials/easyjobs-admin-header.php');?>
                <!-- content body -->
                <div class="content-area__body">
                    <?php if(!empty($job) && !empty($pipelines)): ?>
                        <section class="pipeline-section">
                            <div class="d-flex justify-content-between my-5">
                                <div class="back-button m-0">
                                    <a href="<?php echo admin_url('admin.php?page=easyjobs-all-jobs')?>" class="back-button__icon">
                                        <i class="eicon e-back"></i>
                                    </a>
                                    <div class="back-button__text d-none d-md-block"><?php _e('Back To Jobs', EASYJOBS_TEXTDOMAIN);?></div>
                                    <div class="section-title d-block d-md-none ml-4">
                                        <?php echo $job->title; ?>
                                    </div>
                                </div>
                                <div class="dropdown pipeline-action ml-auto mr-3 d-none d-md-block">
                                    <button class="button white-button dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php _e('Job Menu', EASYJOBS_TEXTDOMAIN);?></button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="<?php echo admin_url('admin.php?page=easyjobs-all-jobs');?>"><?php _e('All jobs', EASYJOBS_TEXTDOMAIN);?></a>
                                        <a class="dropdown-item" href="<?php echo admin_url('admin.php?page=easyjobs-admin&job-id=' . $job->id . '&view=candidates'); ?>"><?php _e('Candidates', EASYJOBS_TEXTDOMAIN);?></a>
                                    </div>
                                </div>
                                <button class="edit-button d-none d-md-flex mr-3" data-toggle="modal" data-target="#pipeline-modal">
                                    <span class="edit-icon"><i class="eicon e-pencil"></i></span>
                                    <span> <?php _e('Edit Pipeline', EASYJOBS_TEXTDOMAIN);?> </span>
                                </button>
                                <div class="dropdown pipeline-move-btn">
                                    <button class="button primary-button dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <?php _e('Move To Stage', EASYJOBS_TEXTDOMAIN); ?>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <?php foreach ($pipelines as $pipeline): ?>
                                        <a class="dropdown-item change-pipeline" href="#" data-key="<?php echo $pipeline->id; ?>" data-job-id="<?php echo $job->id; ?>">
                                            <?php echo $pipeline->name; ?>
                                        </a>
                                        <?php endforeach;?>
                                    </div>
                                </div>
                            </div>
                            <div class="section-title-wrap">
                                <div class="active-pipeline pipeline-button">
                                    <span><?php echo $pipelines[0]->name;?></span>
                                    <span class="candidates-number"><?php echo count($pipelines[0]->applicants); ?></span>
                                </div>
                                <div class="d-none d-md-block job-title">
                                    <div class="section-title"><?php echo $job->title;?></div>
                                    <span class="section-label">
                                        <?php echo date('d F, Y', strtotime(str_replace(', ', '', $job->expire_at)));?>
                                    </span>
                                </div>
                                <div class="nav pipeline-toggler" id="nav-tab" role="tablist">
                                    <a class="toggler-button active" data-toggle="tab" href="#pipeline-box" role="tab" aria-controls="pipeline-box" aria-selected="true" data-job-id="<?php echo $job->id; ?>">
                                        <div class="icon"><i class="eicon e-thumbnail"></i></div>
                                    </a>
                                    <a class="toggler-button" data-toggle="tab" href="#pipeline-list-box" role="tab" aria-controls="pipeline-list-box" aria-selected="true" data-job-id="<?php echo $job->id; ?>">
                                        <div class="icon"><i class="eicon e-trello"></i></div>
                                    </a>
                                </div>
                            </div>
                            <div class="tab-content pipeline-tab-content">
                                <div id="pipeline-box" class="tab-pane fade show active">
                                    <div class="pipeline-box">
                                        <div class="pipeline-menu">
                                            <div class="pipeline-hamburger">
                                                <div class="hamburger-toggler"></div>
                                            </div>
                                            <ul class="pipeline-nav nav nav-tabs flex-column"
                                                id="pipeline-tab" role="tablist">
                                                <?php foreach ($pipelines as $key => $pipeline): ?>
                                                    <li class="nav-item" role="presentation">
                                                        <a class="pipeline-button <?php echo 'pipeline-' .Easyjobs_Helper::get_tab_name($pipeline->name); ?> <?php echo $key == 0 ? 'active': ''; ?> <?php echo ($pipeline->id == 'selected') || ($pipeline->id == 'rejected') ?
                                                            $pipeline->id : '';?>" data-toggle="tab"
                                                           href="#<?php echo Easyjobs_Helper::get_tab_name($pipeline->name); ?>"
                                                           role="tab"
                                                           aria-controls="<?php echo Easyjobs_Helper::get_tab_name($pipeline->name); ?>"
                                                           aria-selected="<?php echo $key == 0 ? 'true': 'false'; ?>">
                                                            <span><?php echo $pipeline->name; ?></span>
                                                            <span class="candidates-number"><?php echo count($pipeline->applicants); ?> </span>
                                                        </a>
                                                    </li>
                                                <?php endforeach;?>
                                            </ul>
                                        </div>
                                        <div class="pipeline-content tab-content">
                                            <?php foreach ($pipelines as $k => $pipeline): ?>
                                                <div class="tab-pane pipeline-tab fade <?php echo $k==0 ? 'show active' : ''?>"
                                                     id="<?php echo Easyjobs_Helper::get_tab_name($pipeline->name); ?>"
                                                     role="tabpanel" aria-labelledby="<?php echo Easyjobs_Helper::get_tab_name($pipeline->name); ?>">
                                                    <div class="row row-cols-xl-3">
                                                        <?php foreach ($pipeline->applicants as $applicant): ?>
                                                            <div class="col">
                                                                <div class="pipeline-card">
                                                                    <div class="user__image">
                                                                        <img src="<?php echo $applicant->user->profile_image?>" alt="" class="w-100 img-fluid" />
                                                                    </div>
                                                                    <div class="user__details">
                                                                        <a href="<?php echo admin_url( 'admin.php?page=easyjobs-admin&candidate-id=' . $applicant->id ); ?>" class="user__name">
                                                                            <?php echo $applicant->user->name; ?>
                                                                        </a>
                                                                        <div class="d-flex">
                                                                            <span class="user__address"><?php echo $applicant->user->nationality; ?></span> &nbsp;
                                                                            <p class="user__experience"> <?php echo $applicant->user->experience; ?> <?php _e('Years', EASYJOBS_TEXTDOMAIN);?></p>
                                                                        </div>
                                                                        <div class="d-flex justify-content-between mt-3">
                                                                            <div class="user__text__ratting">
                                                                                <?php echo Easyjobs_Helper::rating_icon($applicant->rating); ?>
                                                                            </div>
                                                                            <div class="application-duration"><?php echo $applicant->updated_diff;?></div>
                                                                        </div>
                                                                    </div>
                                                                    <label class="checkbox pipeline-checkbox">
                                                                        <input type="checkbox" class="applicant" value="<?php echo $applicant->id; ?>" id="applicant-<?php echo $applicant->id?>" />
                                                                        <span></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        <?php endforeach;?>
                                                    </div>
                                                </div>
                                            <?php endforeach;?>
                                        </div>
                                    </div>
                                </div>
                                <div id="pipeline-list-box" class="tab-pane fade">
                                    <div class="pipeline-list-box">
                                        <?php foreach ($pipelines as $key => $pipeline): ?>
                                        <div class="pipeline__board <?php echo ($pipeline->id == 'selected') || ($pipeline->id == 'rejected') ?
                                            $pipeline->id : '';?>">
                                            <div class="pipeline__board--title">
                                                <h5><?php echo ucfirst($pipeline->name); ?></h5><span class="candidates-number"><?php echo count($pipeline->applicants) ?></span>
                                            </div>
                                            <ul class="pipeline__board--content" id="<?php echo 'pipeline-'. $pipeline->id?>" data-pipeline-id="<?php echo $pipeline->id?>" data-job-id="<?php echo $job->id; ?>">
                                                <?php if(!empty($pipeline->applicants)): ?>
                                                    <?php foreach($pipeline->applicants as $applicant): ?>
                                                        <li class="pipeline-card" id="applicant-<?php echo $applicant->id; ?>" data-applicant-id="<?php echo $applicant->id; ?>">
                                                            <div class="user__image">
                                                                <img src="<?php echo $applicant->user->profile_image?>" alt="" class="w-100 img-fluid" />
                                                            </div>
                                                            <div class="user__details">
                                                                <a href="<?php echo admin_url( 'admin.php?page=easyjobs-admin&candidate-id=' . $applicant->id ); ?>" class="user__name"><?php echo $applicant->user->name; ?></a>
                                                                <div class="d-flex">
                                                                    <?php if(!empty($applicant->user->address)): ?>
                                                                    <span class="user__address">
                                                                        <?php echo $applicant->user->address?>
                                                                    </span>
                                                                    <?php endif; ?>
                                                                    <?php if(!empty($applicant->user->experience)): ?>
                                                                    <p class="user__experience">
                                                                        <?php echo $applicant->user->experience; ?> Years
                                                                    </p>
                                                                    <?php endif;?>
                                                                </div>
                                                                <div class="d-flex justify-content-between mt-3">
                                                                    <div class="user__text__ratting">
                                                                        <?php echo Easyjobs_Helper::rating_icon($applicant->rating); ?>
                                                                    </div>
                                                                    <div class="application-duration"><?php echo $applicant->updated_diff;?></div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    <?php endforeach;?>
                                                <?php else: ?>
                                                <li class="pipeline-card-not-found">
                                                    <p> No candidates found. </p>
                                                </li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                        <?php endforeach;?>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <div id="pipeline-modal" class="modal fade custom-fields">
                            <div role="document" class="modal-dialog modal-lg modal-dialog-centered">
                                <form class="save-pipeline" data-nonce="<?php echo wp_create_nonce('easyjobs_save_pipeline');?>" data-job-id="<?php echo $job->id;?>">
                                    <div class="modal-content">
                                        <div class="modal-header"><h4 class="modal-title text-uppercase">edit job pipeline</h4>
                                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                                        aria-hidden="true">×</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group pipeline-step-list">
                                                <label>Pipeline Steps</label>
                                                <div class="pipeline-main-wrapper">
                                                    <?php foreach ($pipelines as $stage): ?>
                                                    <?php
                                                       if( $stage->id === 'selected' || $stage->id === 'rejected'){
                                                           continue;
                                                       }
                                                    ?>
                                                    <div class="input-wrapper pipeline-wrapper">
                                                        <input type="text" name="pipeline[]" disabled="disabled" class="form-control pipeline-stage" value="<?php echo $stage->name; ?>" data-stage-id="<?php echo $stage->id; ?>">
                                                        <?php if(!$stage->is_fixed): ?>
                                                        <a href="#" class="input-wrapper-append delete-stage" draggable="false">
                                                            <i class="eicon e-delete"></i>
                                                        </a>
                                                        <?php endif;?>
                                                    </div>
                                                    <?php endforeach;?>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-12"><label>New Pipeline Step Name</label></div>
                                                <div class="col-md-9">
                                                    <input type="text" placeholder="New step title" class="form-control" id="add_new_stage" name="add_new_stage">
                                                    <div class="error-message"></div>
                                                </div>
                                                <div class="col-md-3">
                                                    <button class="button semi-button-info w-100 add-new-stage">Add New</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer d-flex justify-content-between">
                                            <button data-dismiss="modal" class="button semi-button-info">Back</button>
                                            <button type="submit" class="button info-button">Save Pipeline</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>
</div>