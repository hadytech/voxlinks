<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

trait Easyjobs_Elementor_Template {

	public function company_info_template() {

		$company      = $this->company_info;
		$setting      = $this->get_settings();
		$company_name = trim( $setting['easyjobs_company_name'] );
		$company_name = ( empty( $company_name ) && ! empty( $company->name ) ) ? $company->name : $company_name;
		?>
        <div class="easyjobs-shortcode-wrapper">
			<?php if ( ! empty( $company ) ): ?>

                <div class="easyjobs-details">
					<?php if ( $setting['easyjobs_company_details_control'] !== 'yes' ): ?>
						<?php if ( ! empty( $company->cover_photo ) ): ?>
                            <div class="ej-job-cover">
                                <img src="<?php echo $company->cover_photo[0]; ?>" alt="<?php echo $company->name; ?>">
                            </div>
						<?php else: ?>
                            <div class="ej-no-cover-photo"></div>
						<?php endif; ?>
                        <div class="ej-header">
                            <div class="ej-company-highlights">
                                <div class="ej-company-info">
									<?php if ( ! empty( $company->logo ) ): ?>
                                        <div class="logo">
                                            <img src="<?php echo $company->logo; ?>" alt="">
                                        </div>
									<?php endif; ?>
                                    <div class="info">
                                        <h2 class="name"><?php echo $company_name; ?></h2>
										<?php if ( isset( $company->address ) ): ?>
                                            <p class="location">
                                                <i class="eicon e-map-maker"></i>
                                                <span>
                                            <?php echo ! empty( $company->address->city->name ) ?
	                                            $company->address->city->name : '' ?>,
                                            <?php echo ! empty( $company->address->country->name ) ?
	                                            $company->address->country->name : ''; ?>
                                        </span>
                                            </p>
										<?php endif; ?>
                                    </div>
                                </div>
                                <div class="ej-header-tools">
                                    <a href="<?php echo ! empty( $company->website ) ? $company->website : '#'; ?>"
                                       class="ej-btn
                                 ej-info-btn">
										<?php echo $setting['easyjobs_website_link_text']; ?>
                                    </a>
                                </div>
                            </div>
                            <div class="ej-company-description">
								<?php echo ! empty( $company->description ) ? $company->description : ''; ?>
                            </div>
                        </div>
					<?php endif; ?>

                    <div class="ej-job-body">
						<?php if ( $setting['easyjobs_job_list_control'] !== 'yes' ): ?>
                            <div class="ej-section">
                                <div class="ej-section-title">
                                    <span class="ej-section-title-icon"><i class="eicon e-briefcase"></i></span>
                                    <span class="ej-section-title-text"><?php echo $setting['easyjobs_joblist_heading']; ?></span>
                                </div>
                                <div class="ej-section-content">
									<?php $this->job_list_template(); ?>
                                </div>
                            </div>
						<?php endif; ?>
						<?php if ( ! empty( $company->showcase_photo ) && $setting['easyjobs_company_gallery_control'] !== 'yes' ): ?>
                            <div class="ej-section">
                                <div class="ej-section-title">
                                    <span class="ej-section-title-icon"><i class="eicon e-briefcase"></i></span>
                                    <span class="ej-section-title-text"><?php echo $setting['easyjobs_gallery_section_text'] . ' ' . $company_name; ?></span>
                                </div>
                                <div class="ej-section-content">
                                    <div class="ej-company-showcase">
                                        <div class="ej-showcase-inner">
                                            <div class="ej-showcase-left">
                                                <div class="ej-showcase-image">
                                                    <div class="ej-image">
                                                        <img src="<?php echo $company->showcase_photo[0]; ?>"
                                                             alt="<?php echo ! empty( $company->name ) ? $company->name : '';
														     ?>">
                                                    </div>
                                                </div>
                                            </div>
											<?php if ( count( $company->showcase_photo ) > 1 ): ?>
                                                <div class="ej-showcase-right">
													<?php foreach ( $company->showcase_photo as $key => $photo ): ?>
														<?php
														if ( $key === 0 ) {
															continue;
														}
														?>
                                                        <div class="ej-showcase-image">
                                                            <div class="ej-image">
                                                                <img src="<?php echo $photo; ?>"
                                                                     alt="<?php echo ! empty( $company->name ) ?
																	     $company->name : ''; ?>">
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
			<?php else: ?>
                <h3>
					<?php _e( 'No open jobs right now', EASYJOBS_TEXTDOMAIN ); ?>
                </h3>
			<?php endif; ?>
        </div>
		<?php
	}

	public function job_list_template() {

		$jobs_obj = new Easyjobs_Admin_Jobs();
		$settings         = $this->get_settings();
		$jobs             = $this->get_published_jobs( [
			'limit'   => $settings['easyjobs_jobs_per_page']['size'],
			'orderby' => $settings['easyjobs_job_list_order_by'] . ':' . $settings['easyjobs_job_list_sort_by']
		] );

		$job_with_page_id = Easyjobs_Helper::get_job_with_page( $jobs );
		$new_job_with_page_id = Easyjobs_Helper::create_pages_if_required($jobs, $job_with_page_id);
		$job_with_page_id += $new_job_with_page_id;
		?>
		<?php if ( ! empty( $jobs ) ): ?>
            <div class="easyjobs-shortcode-wrapper">
                <div class="ej-job-list">
					<?php foreach ( $jobs as $key => $job ): ?>
						<?php
						$current_date = time();
						$end_date     = strtotime( str_replace(',','',$job->expire_at) );

						if ( $job->is_expired && $settings['easyjobs_show_open_job'] === 'yes' ) {
							continue;
						}
						?>
                        <div class="ej-job-list-item">
                            <div class="ej-job-list-item-inner">
                                <div class="ej-job-list-item-col">
                                    <h2 class="ej-job-title">
                                        <a href="<?php echo get_the_permalink( $job_with_page_id[ $job->id ] ); ?>"><?php echo $job->title; ?></a>
                                    </h2>
                                    <div class="ej-job-list-info">
                                        <div class="ej-job-list-info-block ej-job-list-company-name">
                                            <i class="eicon e-briefcase-2"></i>
                                            <a href="<?php echo $job->company_easyjob_url; ?>" target="_blank">
												<?php echo $job->company_name; ?>
                                            </a>
                                        </div>
                                        <div class="ej-job-list-info-block ej-job-list-location">
                                            <i class="eicon e-map-maker"></i>
                                            <?php if($job->is_remote): ?>
                                                <span><?php _e('Anywhere (Remote)', EASYJOBS_TEXTDOMAIN); ?></span>
                                            <?php else: ?>
                                                <span><?php echo $job->job_address->city->name?>, <?php echo $job->job_address->country->name; ?></span>
                                            <?php endif?>
                                        </div>
                                    </div>
                                </div>
                                <div class="ej-job-list-item-col ej-job-time-col">
									<?php if ( !$job->is_expired ): ?>
                                        <p class="ej-deadline ej-el-deadline">
											<?php echo $job->expire_at; ?>
                                        </p>
                                        <p class="ej-list-sub">
                                            No of vacancies: <?php echo $job->vacancies; ?>
                                        </p>
									<?php else: ?>
                                        <p class="ej-list-title ej-expired">
											<?php _e( 'Expired', EASYJOBS_TEXTDOMAIN ); ?>
                                        </p>
									<?php endif; ?>
                                </div>
                                <div class="ej-job-list-item-col ej-job-apply-btn">
                                    <a href="<?php echo $job->apply_url; ?>"
                                       class="ej-apply-btn ej-btn ej-info-btn-light"
                                       target="_blank"><?php echo $settings['easyjobs_joblist_apply_button_text']; ?></a>
                                </div>
                            </div>
                        </div>
					<?php endforeach; ?>
                </div>
            </div>
		<?php else: ?>
            <h3>
				<?php _e( 'No open jobs right now', EASYJOBS_TEXTDOMAIN ); ?>
            </h3>
		<?php endif; ?>
		<?php
	}
}