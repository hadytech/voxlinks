<div id="general" class="eael-settings-tab active">
    <div class="row eael-admin-general-wrapper">
        <div class="eael-admin-general-inner">
            <div class="eael-admin-block-wrapper">

                    <?php do_action('add_admin_license_markup'); ?>
                    
                    <?php if (!defined('EAEL_PRO_PLUGIN_BASENAME') && !is_plugin_active('templately/templately.php')) {?>
                        <div class="eael-admin-block-large eael-admin-block-templately">
                            <img class="eael-preview-img" src="<?php echo EAEL_PLUGIN_URL . 'assets/admin/images/templately/templately_promotion_lite.jpg'; ?>" alt="templately banner">
                            <div class="eael-admin-block-templately-overlay">
                                <div class="eael-admin-block-templately-overlay-inner">
                                    <img class="eael-admin-block-templately-logo" src="<?php echo EAEL_PLUGIN_URL . 'assets/admin/images/templately/logo.svg'; ?>" alt="templately logo">
                                    <p class="eael-admin-block-templately-desc"><?php _e('Get Access to over 1,000 Stunning Elementor Templates Library & Cloud with Templately','essential-addons-for-elementor-lite');?></p>
                                    
                                    <?php if ($this->installer->get_local_plugin_data('templately/templately.php') === false) {?>
                                        <a class="ea-button wpdeveloper-plugin-installer" data-action="install" data-slug="templately"><?php _e('Install Templately', 'essential-addons-for-elementor-lite');?></a>
                                    <?php } else {?>
                                        <a class="ea-button wpdeveloper-plugin-installer" data-action="activate" data-basename="templately/templately.php"><?php _e('Activate Templately', 'essential-addons-for-elementor-lite');?></a>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                    <?php }?>

                <?php
                    if( !defined('EAEL_PRO_PLUGIN_BASENAME') ) :
                    $banner_display = (is_plugin_active('templately/templately.php'))?'':'none';
                    ?>
                    <div class="eael-admin-block eael-admin-block-banner" style="display: <?php echo $banner_display; ?>">
                        <a href="https://essential-addons.com/elementor/" target="_blank">
                            <img class="eael-preview-img" src="<?php echo EAEL_PLUGIN_URL . 'assets/admin/images/eael-featured.png'; ?>" alt="essential-addons-for-elementor-featured">
                        </a>
                    </div><!--preview image end-->
                <?php endif; ?>

                    <div class="eael-admin-block eael-admin-block-docs">
                        <header class="eael-admin-block-header">
                            <div class="eael-admin-block-header-icon">
                                <img src="<?php echo EAEL_PLUGIN_URL . 'assets/admin/images/icon-documentation.svg'; ?>" alt="essential-addons-for-elementor-documentation">
                            </div>
                            <h4 class="eael-admin-title"><?php _e('Documentation', 'essential-addons-for-elementor-lite'); ?></h4>
                        </header>
                        <div class="eael-admin-block-content">
                            <p><?php _e('Get started by spending some time with the documentation to get familiar with Essential Addons. Build awesome websites for you or your clients with ease.', 'essential-addons-for-elementor-lite'); ?></a></p>
                            <a href="https://essential-addons.com/elementor/docs/" class="ea-button" target="_blank"><?php _e('Documentation', 'essential-addons-for-elementor-lite'); ?></a>
                        </div>
                    </div>
                    <div class="eael-admin-block eael-admin-block-contribution">
                        <header class="eael-admin-block-header">
                            <div class="eael-admin-block-header-icon">
                                <img src="<?php echo EAEL_PLUGIN_URL . 'assets/admin/images/icon-contribute.svg'; ?>" alt="">
                            </div>
                            <h4 class="eael-admin-title"><?php _e('Contribute to Essential Addons', 'essential-addons-for-elementor-lite'); ?></h4>
                        </header>
                        <div class="eael-admin-block-content">
                            <p><?php _e('You can contribute to make Essential Addons better reporting bugs, creating issues, pull requests at', 'essential-addons-for-elementor-lite'); ?> <a href="https://github.com/rupok/essential-addons-for-elementor-lite/" target="_blank"><?php _e('Github.', 'essential-addons-for-elementor-lite'); ?></a></p>
                            <a href="https://github.com/rupok/essential-addons-for-elementor-lite/issues/new" class="ea-button" target="_blank"><?php _e('Report a bug', 'essential-addons-for-elementor-lite'); ?></a>
                        </div>
                    </div>
                    <div class="eael-admin-block eael-admin-block-support">
                        <header class="eael-admin-block-header">
                            <div class="eael-admin-block-header-icon">
                                <img src="<?php echo EAEL_PLUGIN_URL . 'assets/admin/images/icon-need-help.svg'; ?>" alt="essential-addons-get-help">
                            </div>
                            <h4 class="eael-admin-title"><?php _e('Need Help?', 'essential-addons-for-elementor-lite'); ?></h4>
                        </header>
                        <div class="eael-admin-block-content">

                        <?php if( !defined('EAEL_PRO_PLUGIN_BASENAME') ): ?>
                            <p><?php _e('Stuck with something? Get help from the community on', 'essential-addons-for-elementor-lite'); ?> <a href="https://wordpress.org/support/plugin/essential-addons-for-elementor-lite/" target="_blank"><?php _e('WordPress.org Forum', 'essential-addons-for-elementor-lite'); ?></a> <?php _e('or', 'essential-addons-for-elementor-lite'); ?> <a href="https://www.facebook.com/groups/essentialaddons/" target="_blank"><?php _e('Facebook Community.', 'essential-addons-for-elementor-lite'); ?></a> <?php _e('In case of emergency, initiate a live chat at', 'essential-addons-for-elementor-lite'); ?> <a href="https://essential-addons.com/elementor/" target="_blank"><?php _e('Essential Addons website.', 'essential-addons-for-elementor-lite'); ?></a></p>
                            <a href="http://wpdeveloper.net/support/" class="ea-button" target="_blank"><?php _e('Get Support', 'essential-addons-for-elementor-lite'); ?></a>
                        <?php
                            else:
                                do_action('eael_premium_support_link');
                            endif;
                        ?>

                        </div>
                    </div>

                    <?php if( !defined('EAEL_PRO_PLUGIN_BASENAME') )  : ?>
                    <div class="eael-admin-block eael-admin-block-review">
                        <header class="eael-admin-block-header">
                            <div class="eael-admin-block-header-icon">
                                <img src="<?php echo EAEL_PLUGIN_URL . 'assets/admin/images/icon-show-love.svg'; ?>" alt="rate-essential-addons">
                            </div>
                            <h4 class="eael-admin-title"><?php _e('Show your Love', 'essential-addons-for-elementor-lite'); ?></h4>
                        </header>
                        <div class="eael-admin-block-content">
                            <p><?php _e('We love to have you in Essential Addons family. We are making it more awesome everyday. Take your 2 minutes to review the plugin and spread the love to encourage us to keep it going.', 'essential-addons-for-elementor-lite'); ?></p>

                            <a href="https://wpdeveloper.net/review-essential-addons-elementor" class="review-flexia ea-button" target="_blank"><?php _e('Leave a Review', 'essential-addons-for-elementor-lite'); ?></a>
                        </div>
                    </div>
                    <?php
                        else :
                            do_action('eael_additional_support_links');
                        endif;
                    ?>
            </div><!--admin block-wrapper end-->
        </div>
        <?php
        $templately_promo = '';
        if (defined('EAEL_PRO_PLUGIN_BASENAME') && !is_plugin_active('templately/templately.php')) {
            $templately_promo = 'eael-templately-promo-show';
        }
        ?>
        <div class="eael-admin-sidebar <?php echo $templately_promo; ?>">
            <?php if (defined('EAEL_PRO_PLUGIN_BASENAME') && !is_plugin_active('templately/templately.php')) {?>
                <div class="eael-sidebar-block eael-admin-block-templately">
                    <img class="eael-preview-img" src="<?php echo EAEL_PLUGIN_URL . 'assets/admin/images/templately/templately_promotion_pro.jpg'; ?>" alt="templately banner">
                    <div class="eael-admin-block-templately-overlay">
                        <div class="eael-admin-block-templately-overlay-inner">
                            <img class="eael-admin-block-templately-logo" src="<?php echo EAEL_PLUGIN_URL . 'assets/admin/images/templately/logo.svg'; ?>" alt="templately logo">
                            <p class="eael-admin-block-templately-desc"><?php _e('Get Access to over 1,000 Stunning Elementor Templates Library & Cloud with Templately','essential-addons-for-elementor-lite');?></p>
                            
                            <?php if ($this->installer->get_local_plugin_data('templately/templately.php') === false) {?>
                                <a class="ea-button wpdeveloper-plugin-installer" data-action="install" data-slug="templately"><?php _e('Install Templately', 'essential-addons-for-elementor-lite');?></a>
                            <?php } else {?>
                                <a class="ea-button wpdeveloper-plugin-installer" data-action="activate" data-basename="templately/templately.php"><?php _e('Activate Templately', 'essential-addons-for-elementor-lite');?></a>
                            <?php }?>
                        </div>
                    </div>
                </div>
            <?php }?>

            <div class="eael-sidebar-block">
                <div class="eael-admin-sidebar-logo">
                    <img src="<?php echo EAEL_PLUGIN_URL . 'assets/admin/images/icon-ea-logo.svg'; ?>" alt="essential-addons-for-elementor">
                </div>
                <div class="eael-admin-sidebar-cta">
                    <?php
                        if( !defined('EAEL_PRO_PLUGIN_BASENAME') ) {
                            printf( __( '<a href="https://wpdeveloper.net/in/upgrade-essential-addons-elementor" target="_blank">%s</a>', 'essential-addons-for-elementor-lite'), 'Upgrade to Pro' );
                        }else {
                            do_action('eael_manage_license_action_link');
                        }
                    ?>
                </div>
            </div>
        </div><!--admin sidebar end-->
    </div><!--Row end-->
</div>
