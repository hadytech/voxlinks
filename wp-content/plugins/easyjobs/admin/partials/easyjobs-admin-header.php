<?php

/**
 * Header for eayjobs admin pages
 *
 *
 * @link       https://easy.jobs
 * @since      1.0.5
 *
 * @package    Easyjobs
 * @subpackage Easyjobs/admin/partials
 */
$company = Easyjobs_Helper::get_company_info();
?>
<header class="content-area__header d-flex justify-content-between">
    <div>
        <img src="<?php echo EASYJOBS_ADMIN_URL?>/assets/img/logo-blue.svg" alt="">
        <small class="easyjobs-version"><?php _e('Version: ', EASYJOBS_TEXTDOMAIN);?><?php echo EASYJOBS_VERSION;?> </small>
    </div>
    <a href="<?php echo !empty($company->company_easyjob_url) ? $company->company_easyjob_url : '#'; ?>" target="_blank" class="button info-button">
        <?php _e('View Company Page', EASYJOBS_TEXTDOMAIN); ?>
    </a>
</header>
<?php
$status = Easyjobs_Helper::get_verification_status();
if( $status !== null && $status == false) : ?>
    <div class="verification-status">
        <h4 class="not-verified-message mt-5">
            <a href="https://easy.jobs/docs/verify-your-company-profile/" target="_blank"class="link-help">How to verify?</a>
            Your company is not verified, please verify your company.
        </h4>
    </div>
<?php endif; ?>
