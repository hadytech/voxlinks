<div class="wrap">
    <hr class="wp-header-end">
    <input type="hidden" class="easyjobs-job-id" value="<?php echo $_GET['job-id']?>">
    <input type="hidden" class="easyjobs-ai-enabled" value="<?php echo $ai_enabled; ?>">
    <div class="easy-page-body">
        <main class="content-area">
            <?php include( EASYJOBS_ADMIN_DIR_PATH .'/partials/easyjobs-admin-header.php');?>
            <!-- content body -->
            <div class="content-area__body">
                <section class="candidates-section section-gap">
                    <div class="d-flex flex-wrap align-items-start justify-content-between">
                        <div class="back-button mt-0">
                            <a href="<?php echo admin_url('admin.php?page=easyjobs-all-jobs');?>" class="back-button__icon">
                                <i class="eicon e-back"></i>
                            </a>
                            <div class="back-button__text d-none d-md-block"><?php _e('Back To Jobs', EASYJOBS_TEXTDOMAIN);?></div>
                        </div>
                        <div class="dropdown ej-job-candidates-action ml-auto mr-3">
                            <button class="button info-button dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php _e('More', EASYJOBS_TEXTDOMAIN);?></button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#ej-invite-candidate-modal"><?php _e('Invite candidates', EASYJOBS_TEXTDOMAIN);?></a>
                                <a class="dropdown-item" href="<?php echo admin_url('admin.php?page=easyjobs-admin&job-id=' . $_GET['job-id']  . '&view=pipeline');?>"><?php _e('Pipeline', EASYJOBS_TEXTDOMAIN);?></a>
                                <a class="dropdown-item ej-export-candidates" href="#"><?php _e('Export', EASYJOBS_TEXTDOMAIN);?></a>
                            </div>
                        </div>
                    </div>
                    <div class="section-title-wrap">
                        <?php if(!empty($job)):?>
                        <div class="mt-1">
                            <div class="section-title"><?php echo $job->title;?></div>
                            <p class="section-label">
                                <?php echo date('d F, Y', strtotime(str_replace(', ', '', $job->expire_at))); ?>
                            </p>
                        </div>
                        <?php endif;?>
                        <div class="d-flex ej-candidate-search-filter align-items-center">
                            <div class="ej-job-candidate-filter">
                                <div class="select-option">
                                    <select>
                                        <option value="select" selected><?php _e('Sort candidates', EASYJOBS_TEXTDOMAIN)?></option>
                                        <?php foreach (Easyjobs_Helper::candidateSortOptions() as $sortOption): ?>
                                            <option value="<?php echo $sortOption['value']?>"><?php _e($sortOption['title'], EASYJOBS_TEXTDOMAIN)?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <form action="" class="form-filter mb-0 mt-1 ej-candidate-search">
                                <div class="search-bar mr-0">
                                    <input type="text" class="easyjobs-search-candidates" placeholder="Search Candidates Name . . ." />
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="candidates-box">
                        <div class="candidates-filter-box easyjobs-filter">
                            <div class="filter-card">
                                <div class="filter-card__heading gutter-10">
                                    <div class="section-title"><?php _e('Filter', EASYJOBS_TEXTDOMAIN); ?></div>
                                </div>
                                <div class="filter-card__body gutter-10">
                                    <ul>
                                        <li>
                                            <label class="checkbox">
                                                <input type="checkbox" id="candidate_filter_1" name="candidate_filter"
                                                       class="filter" value="1"/>
                                                <span><?php _e('New', EASYJOBS_TEXTDOMAIN);?></span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="checkbox">
                                                <input type="checkbox" id="candidate_filter_2" name="candidate_filter"
                                                       class="filter" value="2"/>
                                                <span><?php _e('Rated', EASYJOBS_TEXTDOMAIN);?></span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="checkbox">
                                                <input type="checkbox" id="candidate_filter_3" name="candidate_filter"
                                                       class="filter" value="3"/>
                                                <span><?php _e('Not rated', EASYJOBS_TEXTDOMAIN);?></span>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <?php if(!empty($pipelines)): ?>
                            <div class="filter-card">
                                <div class="filter-card__heading gutter-10">
                                    <div class="section-title">
                                        <?php _e('Filter By Stage', EASYJOBS_TEXTDOMAIN);?>
                                    </div>
                                </div>
                                <div class="filter-card__body gutter-10">
                                    <ul>
                                        <?php foreach ($pipelines as $key=>$pipeline): ?>
                                        <li>
                                            <label class="checkbox">
                                                <input type="checkbox" value="<?php echo $pipeline->id; ?>"
                                                       id="candidate_stage_filter_<?php echo $pipeline->id; ?>"
                                                       name="candidate_filter_stage" class="stage-filter"/>
                                                <span><?php echo $pipeline->name;?></span>
                                            </label>
                                        </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        <!-- data table -->
                        <div class="data-table candidates-table">
                            <div class="table-wrap">
                                <div class="table">
                                    <?php if(!empty($candidates)): ?>
                                        <div class="table__row table__head">
                                            <div class="table-cell"><?php _e('Name', EASYJOBS_TEXTDOMAIN);?></div>
                                            <?php if($ai_enabled) : ?>
                                            <div class="table-cell"><?php _e('Score', EASYJOBS_TEXTDOMAIN);?></div>
                                            <?php endif; ?>
                                            <div class="table-cell candidate-apply-time"><?php _e('Date',
                                                    EASYJOBS_TEXTDOMAIN);?></div>
                                            <div class="table-cell"><?php _e('Stage', EASYJOBS_TEXTDOMAIN);?></div>
                                            <div class="table-cell"><?php _e('Rating', EASYJOBS_TEXTDOMAIN);?></div>
                                        </div>
                                        <div class="table__body">
                                            <?php foreach ($candidates as $candidate): ?>
                                                <div class="table__row" data-candidate-id="<?php echo $candidate->id; ?>">
                                                    <div class="table-cell user__info">
                                                        <a href="<?php echo admin_url( 'admin.php?page=easyjobs-admin&candidate-id=' . $candidate->id ); ?>" class="d-flex align-items-center">
                                                            <div class="user__image">
                                                                <img src="<?php echo $candidate->user->profile_image; ?>"
                                                                     alt="" class="w-100 img-fluid">
                                                            </div>
                                                            <h4 class="user__name"><?php echo $candidate->user->name; ?></h4>
                                                        </a>
                                                    </div>
                                                    <?php if($ai_enabled) : ?>
                                                    <div class="table-cell user-ai-score has-ai-score">
                                                        <?php if(!empty($candidate->final_ai_score)): ?>
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar" style="width: <?php echo $candidate->final_ai_score; ?>%;" aria-valuenow="<?php echo $candidate->final_ai_score; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $candidate->final_ai_score; ?>%</div>
                                                        </div>
                                                        <?php Easyjobs_Helper::get_ai_score_details($candidate->scores);?>
                                                        <?php endif; ?>
                                                    </div>
                                                    <?php endif; ?>
                                                    <div class="table-cell candidate-apply-time"><?php echo $candidate->created_at; ?></div>
                                                    <div class="table-cell job__status">
                                                        <div class="semi-button h-modified <?php echo !empty($candidate->pipeline->name) ? Easyjobs_Helper::get_pipeline_label($candidate->pipeline->name) : ''; ?> w-100">
                                                            <?php echo !empty($candidate->pipeline->name) ? $candidate->pipeline->name : ''; ?>
                                                        </div>
                                                    </div>
                                                    <div class="table-cell user-rate">
                                                        <div class="user__text__ratting">
                                                            <?php echo Easyjobs_Helper::rating_icon($candidate->rating); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach;?>
                                        </div>
                                    <?php else: ?>
                                        <div class="table__row table__head">
                                            <div class="table-cell">
                                                <?php _e('No candidates found', EASYJOBS_TEXTDOMAIN);?>
                                            </div>
                                        </div>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <div id="ej-invite-candidate-modal" class="modal fade ej-modal ej-invite-candidate-modal">
                    <div role="document" class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title text-uppercase">Invite candidates</h4>
                                <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body invite__candidate">
                                <form class="ej-invite-candidate" data-nonce="<?php echo wp_create_nonce('easyjobs_invite_candidate');?>" data-job-id="<?php echo $_GET['job-id']?>">
                                    <label>Email*</label>
                                    <div class="input-group mb-3 mt-1">
                                        <input type="email" name="email" placeholder="user@easy.jobs" class="form-control user-email">
                                        <button type="submit" class="button info-button text-capitalize">invite</button>
                                    </div>
                                    <div class="error-message mb-3"></div>
                                </form>
                                <div class="data-table user-table invite__candidate--table">
                                    <div class="table-wrap d-none">
                                        <div class="table table-modal">
                                            <div class="table__row table__head">
                                                <div class="table-cell">Name</div>
                                                <div class="table-cell">Email</div>
                                                <div class="table-cell" style="width: 110px;">
                                                    <span class="d-flex justify-content-end">Actions</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer d-flex justify-content-between"></div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>