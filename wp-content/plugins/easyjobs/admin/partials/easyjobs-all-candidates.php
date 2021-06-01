<div class="wrap">
    <hr class="wp-header-end">
    <div class="easy-page-body">
        <main class="content-area">
            <?php include( EASYJOBS_ADMIN_DIR_PATH .'/partials/easyjobs-admin-header.php');?>
            <!-- content body -->
            <div class="content-area__body">
                <section class="user-list total-candidates section-gap">
                    <div class="form-filter candidates-filter">
                        <div class="row">
                            <div class="col-3">
                                <div class="search-bar">
                                    <input type="text" placeholder="Search Candidates Name . . ." class="ej-all-candidate-search"/>
                                </div>
                            </div>
                            <?php if(!empty($jobs)): ?>
                            <div class="col">
                                <div class="select-option">
                                    <select class="ej-candidate-job-select">
                                        <option value="select" selected><?php _e('Select Job', EASYJOBS_TEXTDOMAIN)?></option>
                                        <?php foreach ($jobs as $job):?>
                                        <option value="<?php echo $job->id;?>"><?php echo $job->title;?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <?php endif;?>
                            <div class="col">
                                <div class="select-option">
                                    <select class="ej-candidate-rating-select">
                                        <option value="select" selected>Select Rating</option>
                                        <?php for($i=6, $i>=0; $i--;): ?>
                                        <option value=" <?php echo $i;?>"> <?php echo $i;?></option>
                                        <?php endfor;?>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="select-option">
                                    <select class="ej-candidate-status-select">
                                        <option value="select" selected>Select Status</option>
                                        <option value="1">Applied</option>
                                        <option value="5">Selected</option>
                                        <option value="9">Rejected</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-auto">
                                <button class="button warning-button ej-all-candidate-reset">Reset</button>
                            </div>
                        </div>
                    </div>
                    <?php if(!empty($candidates)): ?>
                    <div class="row row-cols-xl-5 has-col-gap ej-all-candidates" id="ej-all-candidates">
                        <?php foreach ($candidates as $candidate): ?>
                        <div class="col">
                            <div class="user-card <?php echo $candidate->showAiScore ? 'has-ai-score' : '' ;?>">
                                <div class="user__ratting info-button-light <?php echo $candidate->rating > 0 ? '' : 'disabled';?>">
                                    <i class="eicon e-star"></i> <?php echo $candidate->rating; ?>
                                </div>
                                <div class="user-picture">
                                    <?php if($ai_enabled && $candidate->showAiScore): ?>
                                        <?php Easyjobs_Helper::get_ai_score_chart($candidate->scores)?>
                                    <?php endif;?>
                                    <img src="<?php echo $candidate->profile_image; ?>" alt="applicant-img" class="img-fluid" />
                                </div>
                                <div class="user-info" >
                                    <h5 data-toggle="tooltip" data-placement="top" title="Test"><?php echo $candidate->name; ?></h5>
                                    <?php if(!empty($candidate->job_title)) : ?>
                                    <p><?php echo $candidate->job_title; ?></p>
                                    <?php endif; ?>
                                </div>
                                <a href="<?php echo admin_url( 'admin.php?page=easyjobs-admin&candidate-id=' . $candidate->id ); ?>" class="semi-button semi-button-info mt-auto">
                                    <?php _e('View details', EASYJOBS_TEXTDOMAIN); ?>
                                </a>
                                <?php if($ai_enabled && $candidate->showAiScore && !empty($candidate->scores)):?>
                                    <?php Easyjobs_Helper::get_ai_score_details($candidate->scores);?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach;?>
                    </div>
                    <div class="ej-all-candidates-pagination">
                        <?php if(!empty($total_page) && $total_page > 1 && !empty($current_page)): ?>
                            <ul class="pagination-list pt-5">
                                <li class="pagination-list__item">
                                    <a class="pagination-list__link easyjobs-prev-page-link" href="#">
                                        <i class="eicon e-arrow-left"></i>
                                    </a>
                                </li>
                                <?php for($i=1; $i<=$total_page; $i++):?>
                                    <li class="pagination-list__item <?php echo $current_page == $i ? 'pagination-list__item--active':'';?>">
                                        <a class="pagination-list__link" href="<?php echo admin_url( 'admin.php?page=easyjobs-candidates&all-candidate-page=' .
                                            $i .'#ej-all-candidates' );  ?>"><?php echo $i;?></a>
                                    </li>
                                <?php endfor;?>
                                <li class="pagination-list__item">
                                    <a class="pagination-list__link easyjobs-next-page-link" href="#" >
                                        <i class="eicon e-arrow-right"></i>
                                    </a>
                                </li>
                            </ul>
                        <?php endif;?>
                    </div>
                    <?php else: ?>
                    <h4 class="empty-message">
                        <?php _e('No candidates found.', EASYJOBS_TEXTDOMAIN);?>
                    </h4>
                    <?php endif;?>
                </section>
            </div>
        </main>
    </div>
</div>