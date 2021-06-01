<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
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
    <div class="easyjobs-wrapper admin-area">
        <div class="page-header">
            <div class="logo">
                <img src="<?php echo EASYJOBS_ADMIN_URL; ?>assets/img/logo.svg" alt="Easyjobs">
            </div>
            <div class="tools ml-auto">
                <p class="mb-0"><?php _e('Version:', EASYJOBS_TEXTDOMAIN ); ?> <?php echo EASYJOBS_VERSION; ?></p>
            </div>
            <!--<div class="tools">
                <a href="#" class="btn btn-primary">Add New</a>
            </div>-->
        </div>
        <!-- Start Content-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a
                                    href="#published_jobs"
                                    data-toggle="tab"
                                    aria-expanded="false"
                                    class="nav-link <?php echo empty($active_tab) || $active_tab == 'published_jobs' ? ' active' : ''; ?>"
                            >
                                <span class="d-none d-sm-block">
                                    <?php _e('Published Jobs', EASYJOBS_TEXTDOMAIN ); ?>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a
                                    href="#draft_jobs"
                                    data-toggle="tab"
                                    aria-expanded="true"
                                    class="nav-link <?php echo !empty($active_tab) && $active_tab == 'draft_jobs' ? 'active' : '' ?>"
                            >
                                <span class="d-none d-sm-block">
                                    <?php _e('Draft Jobs', EASYJOBS_TEXTDOMAIN ); ?>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a
                                    href="#archived_jobs"
                                    data-toggle="tab"
                                    aria-expanded="false"
                                    class="nav-link <?php echo !empty($active_tab) && $active_tab == 'archived_jobs' ? 'active' : '' ?>"
                            >
                                <span class="d-none d-sm-block">
                                    <?php _e('Archived Jobs', EASYJOBS_TEXTDOMAIN ); ?>
                                </span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-content__header">
                            <div class="row justify-content-between">
                                <div class="col-lg-3 col-sm-6">
                                    <form class="input-group mb-3 mb-sm-0 search-easyjobs">
                                        <input
                                                type="text"
                                                class="form-control"
                                                placeholder="Search..."
                                        />
                                        <div class="input-group-append">
                                            <button class="btn" type="submit">
                                                <i class="dashicons dashicons-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div role="tabpanel"
                             class="tab-pane fade <?php echo empty($active_tab) || $active_tab == 'published_jobs' ? 'show active' : '' ?>"
                             id="published_jobs">
                            <div class="bg-white mt-3">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                    <tr>
                                        <th>
                                            <?php _e('Title', EASYJOBS_TEXTDOMAIN ); ?>
                                        </th>
                                        <th>
                                            <?php _e('Candidates', EASYJOBS_TEXTDOMAIN ); ?>
                                        </th>
                                        <th>
                                            <?php _e('Department', EASYJOBS_TEXTDOMAIN ); ?>
                                        </th>
                                        <th>
                                            <?php _e('Expiry Date', EASYJOBS_TEXTDOMAIN ); ?>
                                        </th>
                                        <th>
                                            <?php _e('Action', EASYJOBS_TEXTDOMAIN ); ?>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($jobs) && !empty($jobs->published)): ?>
                                        <?php foreach ($jobs->published as $job): ?>
                                            <tr>
                                                <td>
                                                    <a href="<?php echo !empty($published_job_page_ids[$job->id]) ? get_the_permalink($published_job_page_ids[$job->id]) : '#'; ?>"
                                                       target="_blank"><?php echo $job->title; ?></a>
                                                </td>
                                                <td><?php echo !empty($job->candidate_count) ? $job->candidate_count : 0; ?></td>
                                                <td><?php echo !empty($job->department) ? $job->department->name : ''; ?></td>
                                                <td><?php echo $job->expire_at; ?></td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a href="javascript:void;" class="dropdown-toggle "
                                                           data-toggle="dropdown" aria-haspopup="true"
                                                           aria-expanded="false"><i class="dashicons dashicons-admin-generic"></i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item"
                                                               href="<?php echo get_the_permalink($published_job_page_ids[$job->id]); ?>"
                                                               target="_blank"><?php _e('Preview', EASYJOBS_TEXTDOMAIN); ?></a>
                                                            <a class="dropdown-item"
                                                               href="<?php echo admin_url('admin.php?page=easyjobs-admin&job-id=' . $job->id . '&view=pipeline'); ?>"><?php _e('Pipeline', EASYJOBS_TEXTDOMAIN); ?></a>
                                                            <a class="dropdown-item"
                                                               href="<?php echo admin_url('admin.php?page=easyjobs-admin&job-id=' . $job->id . '&view=candidates'); ?>"><?php _e('Candidates', EASYJOBS_TEXTDOMAIN); ?></a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5">
                                                <div class="alert alert-danger text-center m-0" role="alert">
                                                    <?php
                                                    if (!empty($no_result_messages) && !empty($no_result_messages['published'])) {
                                                        echo $no_result_messages['published'];
                                                    } else {
                                                        _e('No published jobs found', EASYJOBS_TEXTDOMAIN);
                                                    }
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div role="tabpanel"
                             class="tab-pane fade <?php echo !empty($active_tab) && $active_tab == 'draft_jobs' ? 'show active' : '' ?>"
                             id="draft_jobs">
                            <div class="bg-white mt-3">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                    <tr>
                                        <th>
                                            <?php _e('Title', EASYJOBS_TEXTDOMAIN ); ?>
                                        </th>
                                        <th>
                                            <?php _e('Candidates', EASYJOBS_TEXTDOMAIN ); ?>
                                        </th>
                                        <th>
                                            <?php _e('Department', EASYJOBS_TEXTDOMAIN ); ?>
                                        </th>
                                        <th>
                                            <?php _e('Expiry Date', EASYJOBS_TEXTDOMAIN ); ?>
                                        </th>
                                        <th>
                                            <?php _e('Action', EASYJOBS_TEXTDOMAIN ); ?>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($jobs) && !empty($jobs->draft)): ?>
                                        <?php foreach ($jobs->draft as $job): ?>
                                            <tr>
                                                <td>
                                                    <a href="#"><?php echo $job->title; ?></a>
                                                </td>
                                                <td><?php echo $job->candidate_count; ?></td>
                                                <td><?php echo !empty($job->department->name) ?
                                                        $job->department->name : ''; ?></td>
                                                <td><?php echo $job->expire_at; ?></td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a href="javascript:void;" class="dropdown-toggle "
                                                           data-toggle="dropdown" aria-haspopup="true"
                                                           aria-expanded="false"><i class="dashicons dashicons-admin-generic"></i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item"
                                                               href="#"
                                                               target="_blank"><?php _e('Preview', EASYJOBS_TEXTDOMAIN); ?></a>
                                                            <a class="dropdown-item"
                                                               href="<?php echo admin_url('admin.php?page=easyjobs-all-jobs&job-id=' . $job->id . '&view=pipeline'); ?>"><?php _e('Pipeline', EASYJOBS_TEXTDOMAIN); ?></a>
                                                            <a class="dropdown-item"
                                                               href="<?php echo admin_url('admin.php?page=easyjobs-all-jobs&job-id=' . $job->id . '&view=candidates'); ?>"><?php _e('Candidates', EASYJOBS_TEXTDOMAIN); ?></a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5">
                                                <div class="alert alert-danger text-center m-0" role="alert">
                                                    <?php
                                                    if (!empty($no_result_messages) && !empty($no_result_messages['draft'])) {
                                                        echo $no_result_messages['draft'];
                                                    } else {
                                                        _e('No Draft jobs found', EASYJOBS_TEXTDOMAIN);
                                                    }
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div role="tabpanel"
                             class="tab-pane fade <?php echo !empty($active_tab) && $active_tab == 'archived_jobs' ? 'show active' : '' ?>"
                             id="archived_jobs">
                            <div class="bg-white mt-3">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                    <tr>
                                        <th>
                                            <?php _e('Title', EASYJOBS_TEXTDOMAIN ); ?>
                                        </th>
                                        <th>
                                            <?php _e('Candidates', EASYJOBS_TEXTDOMAIN ); ?>
                                        </th>
                                        <th>
                                            <?php _e('Department', EASYJOBS_TEXTDOMAIN ); ?>
                                        </th>
                                        <th>
                                            <?php _e('Expiry Date', EASYJOBS_TEXTDOMAIN ); ?>
                                        </th>
                                        <th>
                                            <?php _e('Action', EASYJOBS_TEXTDOMAIN ); ?>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($jobs) && !empty($jobs->archived)): ?>
                                        <?php foreach ($jobs->archived as $job): ?>
                                            <tr>
                                                <td>
                                                    <a href="#"><?php echo $job->title; ?></a>
                                                </td>
                                                <td><?php echo $job->candidate_count; ?></td>
                                                <td><?php echo !empty($job->department->name) ?
                                                        $job->department->name : ''; ?></td>
                                                <td><?php echo $job->expire_at; ?></td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a href="javascript:void;" class="dropdown-toggle "
                                                           data-toggle="dropdown" aria-haspopup="true"
                                                           aria-expanded="false"><i class="dashicons dashicons-admin-generic"></i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item"
                                                               href="#"><?php _e('Preview', EASYJOBS_TEXTDOMAIN); ?></a>
                                                            <a class="dropdown-item"
                                                               href="<?php echo admin_url('admin.php?page=easyjobs-all-jobs&job-id=' . $job->id . '&view=pipeline'); ?>"><?php _e('Pipeline', EASYJOBS_TEXTDOMAIN); ?></a>
                                                            <a class="dropdown-item"
                                                               href="<?php echo admin_url('admin.php?page=easyjobs-all-jobs&job-id=' . $job->id . '&view=candidates'); ?>"><?php _e('Candidates', EASYJOBS_TEXTDOMAIN); ?></a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5">
                                                <div class="alert alert-danger text-center m-0" role="alert">
                                                    <?php
                                                    if (!empty($no_result_messages) && !empty($no_result_messages['archived'])) {
                                                        echo $no_result_messages['archived'];
                                                    } else {
                                                        _e('No archived jobs found', EASYJOBS_TEXTDOMAIN);
                                                    }
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- container-fluid -->
    </div>
</div>
