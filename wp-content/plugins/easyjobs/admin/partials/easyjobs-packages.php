<?php if(!empty($packages)): ?>
<div class="subcription">
    <div class="subcription__header">
        <h1 class="subcription__header-text text-center">
            <?php _e('Pricing for growing business', EASYJOBS_TEXTDOMAIN); ?>
        </h1>
        <p class="subcription__header-subtitle text-center pt-2">
            <?php _e('All plans start with a 14-day free trial, no credit card required and simple setup.', EASYJOBS_TEXTDOMAIN); ?>
        </p>
    </div>
    <div class="subcription__footer text-center">
        <a href="<?php esc_url_raw('https://app.easy.jobs/user/account'); ?>" target="_blank" class="btn btn-primary"> Upgrade your current plan</a>
    </div>
</div>
<?php endif; ?>