<div class="wrap">
    <hr class="wp-header-end">
    <?php if(!empty($data)):?>
        <div class="easy-page-body">
            <input type="hidden" value="candidate_id">
            <main class="content-area">
                <?php include( EASYJOBS_ADMIN_DIR_PATH .'/partials/easyjobs-admin-header.php');?>
                <!-- content body -->
                <div class="content-area__body section-gap">
                    <!-- applicant details -->
                    <section class="applicant-details">
                        <!--<div class="back-button">
                            <a href="#" class="back-button__icon">
                                <i class="eicon e-back"></i>
                            </a>
                            <div class="back-button__text">Back To Home</div>
                        </div>-->
                        <div class="row">
                            <div class="col-xl-3 d-flex flex-column pr-0">
                                <div class="user-card gutter-10 h-auto candidate-details-user <?php echo $data->evaluation->showAiScore ? 'has-ai-score' : ''; ?>">
                                    <div class="user-picture">
                                        <?php if($ai_enabled && $data->evaluation->showAiScore): ?>
                                            <?php Easyjobs_Helper::get_ai_score_chart($data->evaluation->scores)?>
                                        <?php endif;?>
                                        <img src="<?php echo $data->candidate->user->profile_image?>" alt="applicant-img" class="img-fluid" />
                                    </div>
                                    <div class="user-info">
                                        <h5> <?php echo !empty($data->candidate->user->name) ? $data->candidate->user->name : ''; ?> </h5>
                                        <p> <?php echo $data->candidate->job_title; ?> </p>
                                    </div>
                                    <div class="dropdown pipeline-action selected candidate-details-pipeline">
                                        <button class="button primary-button pipeline-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <?php echo !empty($data->candidate->pipeline) && !empty($data->candidate->pipeline->name) ? $data->candidate->pipeline->name : ''; ?>
                                        </button>
                                        <div class="dropdown-menu">
                                            <?php foreach ($data->candidate->job_pipelines as $pipeline): ?>
                                            <a class="dropdown-item stage" href="#"
                                               data-stage="<?php echo $pipeline->id; ?>"
                                               data-job-id="<?php echo $data->candidate->job_id;?>"
                                               data-candidate-id="<?php echo $data->candidate->id;?>"><?php echo $pipeline->name; ?></a>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <div class="user__ratting user__ratting--removable info-button-light <?php echo intval($data->candidate->rating) === 0 ? 'disabled' : '' ; ?>">
                                        <input type="hidden" value="<?php echo $data->candidate->rating; ?>" class="candidate-rating">
                                        <i class="eicon e-star"></i> <?php echo $data->candidate->rating; ?>
                                    </div>
                                    <?php if($ai_enabled && $data->evaluation->showAiScore && !empty($data->evaluation->scores)):?>
                                        <?php Easyjobs_Helper::get_ai_score_details($data->evaluation->scores);?>
                                    <?php endif; ?>
                                </div>
                                <div class="user-card align-items-baseline gutter-10">
                                    <ul class="user-info user-info__list">
                                        <li>
                                            <div class="user-icon">
                                                <i class="eicon e-user"></i>
                                            </div>
                                            <div class="user-text">
                                                <p class="user-text__label"><?php _e('First Name', EASYJOBS_TEXTDOMAIN);?>*</p>
                                                <p><?php echo $data->candidate->user->first_name;?></p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="user-icon">
                                                <i class="eicon e-user"></i>
                                            </div>
                                            <div class="user-text">
                                                <p class="user-text__label"><?php _e('Last Name', EASYJOBS_TEXTDOMAIN);?>*</p>
                                                <p><?php echo $data->candidate->user->last_name;?></p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="user-icon">
                                                <i class="eicon e-mail"></i>
                                            </div>
                                            <div class="user-text">
                                                <p class="user-text__label"><?php _e('Email Address', EASYJOBS_TEXTDOMAIN);?>*</p>
                                                <p class="user-email"><?php echo $data->candidate->user->email;?></p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="user-icon">
                                                <i class="eicon e-phone"></i>
                                            </div>
                                            <div class="user-text">
                                                <p class="user-text__label"><?php _e('Phone Number', EASYJOBS_TEXTDOMAIN);?>*</p>
                                                <p><?php echo $data->candidate->user->mobile_number;?></p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="user-icon">
                                                <i class="eicon e-calender"></i>
                                            </div>
                                            <div class="user-text">
                                                <p class="user-text__label"><?php _e('Date of Application', EASYJOBS_TEXTDOMAIN);?></p>
                                                <p><?php echo $data->candidate->created_at;?></p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="user-icon">
                                                <i class="eicon e-star"></i>
                                            </div>
                                            <div class="user-text">
                                                <p class="user-text__label"><?php _e('Rate', EASYJOBS_TEXTDOMAIN);?>*</p>
                                                <div class="user__text__ratting">
                                                    <?php echo Easyjobs_Helper::rating_icon($data->candidate->rating); ?>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="user-icon">
                                                <i class="eicon e-share"></i>
                                            </div>
                                            <div class="user-text">
                                                <p class="user-text__label"><?php _e('Social Profile', EASYJOBS_TEXTDOMAIN);?>*</p>
                                                <div class="mt-2">
                                                    <?php foreach ($data->candidate->user->social_profiles as $profile):?>
                                                    <a class="social-button semi-button-primary" href="<?php echo $profile->link?>" target="_blank">
                                                        <?php echo Easyjobs_Helper::get_social_link_icon($profile->type); ?>
                                                    </a>
                                                    <?php endforeach;?>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-xl-6 pr-0">
                                <div class="tab__card tab__card--primary gutter-10 nav-tabs candidate-tabs">
                                    <a class="tab__control active nav-link" data-toggle="tab" href="#application" role="tab" aria-controls="application" aria-selected="true">
                                        <div class="tab__control__icon"><i class="eicon e-paper"></i></div>
                                        <div class="tab__control__text"><?php _e('Application', EASYJOBS_TEXTDOMAIN);?></div>
                                    </a>
                                    <a class="tab__control nav-link" data-toggle="tab" href="#resume" role="tab" aria-controls="resume" aria-selected="false">
                                        <div class="tab__control__icon"><i class="eicon e-cv"></i></div>
                                        <div class="tab__control__text"><?php _e('Resume', EASYJOBS_TEXTDOMAIN);?></div>
                                    </a>
                                    <a class="tab__control nav-link" data-toggle="tab" href="#evaluation" role="tab" aria-controls="evaluation" aria-selected="false">
                                        <div class="tab__control__icon"><i class="eicon e-contract"></i></div>
                                        <div class="tab__control__text"><?php _e('Evaluation', EASYJOBS_TEXTDOMAIN);?></div>
                                    </a>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="application" role="tabpanel" aria-labelledby="application">
                                        <div class="details__card gutter-10">
                                            <div class="details__card__head">
                                                <h4><?php _e('Cover Letter', EASYJOBS_TEXTDOMAIN);?></h4>
                                            </div>
                                            <div class="details__card__body">
                                                <?php if(!empty($data->candidate->cover_letter)): ?>
                                                    <div class="details__text__pre">
                                                        <?php echo $data->candidate->cover_letter; ?>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="label__full  label__full--primary list-item--primary">
                                                        <?php _e('No cover letter', EASYJOBS_TEXTDOMAIN); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="details__card gutter-10">
                                            <div class="details__card__head">
                                                <h4><?php _e('EXPERIENCE', EASYJOBS_TEXTDOMAIN);?></h4>
                                                <p><?php _e('Total Year Of Experience: ', EASYJOBS_TEXTDOMAIN);?> <span>( <?php echo $data->candidate->user->experience; ?> <?php _e(' Years', EASYJOBS_TEXTDOMAIN);?> )</span></p>
                                            </div>
                                            <div class="details__card__body">
                                                <ul class="info__list">
                                                    <?php if(!empty($data->candidate->user->employments)): ?>
                                                        <?php foreach ($data->candidate->user->employments as $employment): ?>
                                                        <li class="label__full  label__full--primary list-item--primary">
                                                            <p><?php echo $employment->designation; ?> ( <?php echo $employment->from . ' - ' . $employment->to; ?>)</p>
                                                            <p class="label__content"><?php echo $employment->company_name; ?></p>
                                                        </li>
                                                        <?php endforeach;?>
                                                    <?php else: ?>
                                                        <li class="label__full  label__full--primary list-item--primary">
                                                            <?php _e('No job experience', EASYJOBS_TEXTDOMAIN); ?>
                                                        </li>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="details__card gutter-10">
                                            <div class="details__card__head">
                                                <h4><?php _e('EDUCATIONAL QUALIFICATION', EASYJOBS_TEXTDOMAIN);?></h4>
                                            </div>
                                            <div class="details__card__body">
                                                <ul class="info__list">
                                                    <?php if(!empty($data->candidate->user->educations)): ?>
                                                        <?php foreach ($data->candidate->user->educations as $education): ?>
                                                        <li class="label__full  label__full--primary list-item--primary">
                                                            <p><?php echo $education->degree_name;?></p>
                                                            <p class="text-muted"><?php echo $education->level_name;?></p>
                                                            <p class="label__content"><?php echo $education->academy_name;?> <span>( <?php echo $education->passing_year;?> )</span></p>
                                                        </li>
                                                        <?php endforeach;?>
                                                    <?php else: ?>
                                                        <li class="label__full  label__full--primary list-item--primary">
                                                            <?php _e('No educational qualification', EASYJOBS_TEXTDOMAIN); ?>
                                                        </li>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="resume" role="tabpanel" aria-labelledby="resume">
                                        <div class="details__card">
                                            <div class="details__card__head">
                                                <h4><?php _e('Resume', EASYJOBS_TEXTDOMAIN);?></h4>
                                            </div>
                                            <div class="details__card__body">
                                                <div class="candidate-resume">
                                                    <span class="resume-link" data-resume-link="<?php echo $data->candidate->user->resume_url; ?>"></span>
                                                    <div class="candidate-resume-iframe">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="evaluation" role="tabpanel" aria-labelledby="evaluation">
                                        <div class="candidate-details-tab__body">
                                            <?php if($ai_enabled && $data->evaluation->showAiScore): ?>
                                            <div class="candidate-details-tab__body gutter-10">
                                                <div class="details__card gutter-10">
                                                    <div class="details__card__head">
                                                        <h4><?php _e('AI Score', EASYJOBS_TEXTDOMAIN);?></h4>
                                                    </div>
                                                    <div class="details__card__body">
                                                        <div class="d-flex justify-content-between flex-wrap">
                                                            <div class="text-center" style="position: relative;">
                                                                <p><?php _e('Skills', EASYJOBS_TEXTDOMAIN);?></p>
                                                                <div class="ai-score-chart">
                                                                    <svg viewBox="0 0 36 36" class="circular-chart">
                                                                        <path class="circle-bg"
                                                                              d="M18 2.0845
                                                                          a 15.9155 15.9155 0 0 1 0 31.831
                                                                          a 15.9155 15.9155 0 0 1 0 -31.831"
                                                                        />
                                                                        <path class="circle"
                                                                              stroke="<?php echo Easyjobs_Helper::get_ai_score_color('skill')?>"
                                                                              stroke-dasharray="<?php echo $data->evaluation->scores->skill ?>, 100"
                                                                              d="M18 2.0845
                                                                          a 15.9155 15.9155 0 0 1 0 31.831
                                                                          a 15.9155 15.9155 0 0 1 0 -31.831"
                                                                        />
                                                                        <text x="18" y="20.35" class="percentage">
                                                                            <?php echo $data->evaluation->scores->skill ?>%
                                                                        </text>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                            <div class="text-center" style="position: relative;">
                                                                <p>Experience</p>
                                                                <div class="ai-score-chart">
                                                                    <svg viewBox="0 0 36 36" class="circular-chart">
                                                                        <path class="circle-bg"
                                                                              d="M18 2.0845
                                                                          a 15.9155 15.9155 0 0 1 0 31.831
                                                                          a 15.9155 15.9155 0 0 1 0 -31.831"
                                                                        />
                                                                        <path class="circle"
                                                                              stroke="<?php echo Easyjobs_Helper::get_ai_score_color('experience')?>"
                                                                              stroke-dasharray="<?php echo $data->evaluation->scores->experience; ?>, 100"
                                                                              d="M18 2.0845
                                                                          a 15.9155 15.9155 0 0 1 0 31.831
                                                                          a 15.9155 15.9155 0 0 1 0 -31.831"
                                                                        />
                                                                        <text x="18" y="20.35" class="percentage">
                                                                            <?php echo $data->evaluation->scores->experience; ?>%
                                                                        </text>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                            <div class="text-center" style="position: relative;">
                                                                <p>Total</p>
                                                                <div class="ai-score-chart">
                                                                    <svg viewBox="0 0 36 36" class="circular-chart">
                                                                        <path class="circle-bg"
                                                                              d="M18 2.0845
                                                                          a 15.9155 15.9155 0 0 1 0 31.831
                                                                          a 15.9155 15.9155 0 0 1 0 -31.831"
                                                                        />
                                                                        <path class="circle"
                                                                              stroke="<?php echo Easyjobs_Helper::get_ai_score_color('final_score')?>"
                                                                              stroke-dasharray="<?php echo $data->evaluation->scores->final_score; ?>, 100"
                                                                              d="M18 2.0845
                                                                          a 15.9155 15.9155 0 0 1 0 31.831
                                                                          a 15.9155 15.9155 0 0 1 0 -31.831"
                                                                        />
                                                                        <text x="18" y="20.35" class="percentage">
                                                                            <?php echo $data->evaluation->scores->final_score; ?>%
                                                                        </text>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                            <?php if(!empty($data->evaluation->quiz) || !empty($data->evaluation->questions)): ?>
                                            <div class="details__card gutter-10">
                                                <div class="details__card__head nav nav-pills" id="myTab" role="tablist">
                                                    <?php if(!empty($data->evaluation->quiz)): ?>
                                                    <a class="tab--toggler active" id="quiz-tab" data-toggle="tab" href="#quiz" role="tab" aria-controls="quiz" aria-selected="true">
                                                        <?php _e('Quiz', EASYJOBS_TEXTDOMAIN); ?>
                                                    </a>
                                                    <?php endif; ?>
                                                    <?php if(!empty($data->evaluation->questions)): ?>
                                                    <a class="tab--toggler" id="screening-question-tab" data-toggle="tab" href="#screening-question" role="tab" aria-controls="screening-question" aria-selected="false">
                                                        <?php _e('Screening Question', EASYJOBS_TEXTDOMAIN); ?>
                                                    </a>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="tab-content">
                                                    <?php if(!empty($data->evaluation->quiz)): ?>
                                                    <div class="tab-pane fade show active" id="quiz" role="tabpanel" aria-labelledby="quiz-tab">
                                                        <div class="details__card__body d-flex justify-content-between align-items-center">
                                                            <ul class="info__list question-answer">
                                                                <li class="list-item--primary">
                                                                    <p class="question">Total Questions: <span><?php echo $data->evaluation->quiz->count;?></span></p>
                                                                </li>
                                                                <li class="list-item--primary">
                                                                    <p class="question">Total Marks: <span><?php echo $data->evaluation->quiz->totalMarks; ?></span></p>
                                                                </li>
                                                                <li class="list-item--primary">
                                                                    <p class="question">Marks Obtained: <span><?php echo $data->evaluation->quiz->marksObtained; ?></span></p>
                                                                </li>
                                                            </ul>
                                                            <div class="text-right total-mark-obtained" style="position: relative;">
                                                                <svg viewBox="0 0 36 36" class="circular-chart">
                                                                    <path class="circle-bg"
                                                                          d="M18 2.0845
                                                                          a 15.9155 15.9155 0 0 1 0 31.831
                                                                          a 15.9155 15.9155 0 0 1 0 -31.831"
                                                                    />
                                                                    <path class="circle"
                                                                          stroke-dasharray="<?php echo Easyjobs_Helper::get_mark_percentage( $data->evaluation->quiz->totalMarks, $data->evaluation->quiz->marksObtained); ?>, 100"
                                                                          d="M18 2.0845
                                                                          a 15.9155 15.9155 0 0 1 0 31.831
                                                                          a 15.9155 15.9155 0 0 1 0 -31.831"
                                                                    />
                                                                    <text x="18" y="20.35" class="percentage">
                                                                        <?php echo Easyjobs_Helper::get_mark_percentage( $data->evaluation->quiz->totalMarks, $data->evaluation->quiz->marksObtained); ?>%
                                                                    </text>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="details__card__body">
                                                            <ul class="info__list question-answer">
                                                                <?php foreach ($data->evaluation->quiz_questions as $k=>$q): ?>
                                                                <li class="list-item--primary">
                                                                    <p class="question"><strong><?php _e('Question-' . ($k+1) . ': ', EASYJOBS_TEXTDOMAIN);?></strong><?php echo $q->asked;?></p>
                                                                    <p class="label__full--modified label__full--primary answer">
                                                                        <span class="ans-label">Ans : </span>
                                                                        <?php echo $q->answer;?>
                                                                        <?php if(!empty($q->correct_answer)): ?>
                                                                        <label class="correct-ans"><span class="prefix">Correct answer: </span><?php echo $q->correct_answer; ?></label>
                                                                        <?php endif; ?>
                                                                        <?php if($q->is_correct):?>
                                                                        <span class="result-check correct"><i class="dashicons dashicons-yes"></i></span>
                                                                        <?php else:?>
                                                                        <span class="result-check wrong"><i class="dashicons dashicons-no-alt"></i></span>
                                                                        <?php endif;?>
                                                                    </p>
                                                                </li>
                                                                <?php endforeach;?>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <?php endif; ?>
                                                    <?php if(!empty($data->evaluation->questions)): ?>
                                                    <div class="tab-pane fade" id="screening-question" role="tabpanel" aria-labelledby="screening-question-tab">

                                                        <div class="details__card__body">
                                                            <ul class="info__list question-answer">
                                                                <?php foreach ($data->evaluation->questions as $key => $question): ?>
                                                                <li class="list-item--primary">
                                                                    <p class="question"><strong><?php _e('Question-' . ($key+1) . ': ', EASYJOBS_TEXTDOMAIN);?></strong><?php echo $question->asked; ?></p>
                                                                    <p class="label__full--modified label__full--primary answer">
                                                                        <span class="ans-label">Ans : </span>
                                                                        <?php echo $question->answer;?>
                                                                        <?php if(!empty($question->correct_answer)): ?>
                                                                            <label class="correct-ans">
                                                                                <span class="prefix">Correct answer: </span><?php echo $question->correct_answer; ?>
                                                                            </label>
                                                                        <?php endif; ?>
                                                                        <?php if($question->is_correct):?>
                                                                            <span class="result-check correct"><i class="dashicons dashicons-yes"></i></span>
                                                                        <?php else:?>
                                                                            <span class="result-check wrong"><i class="dashicons dashicons-no-alt"></i></span>
                                                                        <?php endif;?>
                                                                    </p>
                                                                </li>
                                                                <?php endforeach;?>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                </div>
                        
                            </div>
                            <div class="col-xl-3 d-flex flex-column">
                                <div class="details__card gutter-10">
                                    <div class="details__card__head">
                                        <h4><?php _e('Salary', EASYJOBS_TEXTDOMAIN);?></h4>
                                    </div>
                                    <div class="details__card__body">
                                        <ul class="info__list">
                                            <li class="label__full  label__full--primary list-item--primary">
                                                <p><?php _e('Current Salary', EASYJOBS_TEXTDOMAIN);?></p>
                                                <p class="label__content"><?php echo $data->candidate->user->current_salary; ?></p>
                                            </li>
                                            <li class="label__full  label__full--primary list-item--primary">
                                                <p><?php _e('Expected Salary', EASYJOBS_TEXTDOMAIN);?></p>
                                                <p class="label__content"><?php echo $data->candidate->expected_salary; ?></p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <div class="dg-wrapper">
                        <div class="dg-backdrop"></div>
                        <div class="dg-container">
                            <div class="dg-content-cont dg-content-cont--floating">
                                <div class="dg-main-content">
                                    <div class="dg-view-wrapper">
                                        <div class="dg-content-body dg-content-body--has-title"><h6 class="dg-title">
                                                Confirmation</h6>
                                            <div class="dg-content">Are you sure, you want to remove rating for this candidate?
                                            </div> </div>
                                        <div class="dg-content-footer">
                                            <button class="dg-btn dg-btn--cancel remove-rating-cancel">
                                                <span>No</span>
                                            </button>
                                            <button class="dg-btn dg-btn--ok dg-pull-right remove-rating">
                                                <span class="dg-btn-content">Yes</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    <?php endif; ?>
</div>