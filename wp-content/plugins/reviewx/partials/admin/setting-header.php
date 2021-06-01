<div class="rx-metabox-wrapper">
    <div class="rx-settings-header">
        <div class="rx-header-left">
            <div class="rx-admin-header">
                <img src="<?php echo esc_url(assets('admin/images/ReviewX.svg')); ?>" alt="<?php echo esc_attr__( 'ReviewX', 'reviewx'); ?>">
                <h2>
                    <?php esc_html_e( 'Advanced Multi-criteria Rating & Reviews for WooCommerce', 'reviewx' ); ?></h2>
            </div>
        </div>

        <div class="rx-header-right">
            <span><?php esc_html_e( 'ReviewX', 'reviewx' ); ?>: <strong><?php echo esc_html( REVIEWX_VERSION ); ?></strong></span>
            <?php 
                if( class_exists('ReviewXPro') ):
            ?>
            <span><?php esc_html_e( 'ReviewX Pro', 'reviewx' ); ?>: <strong><?php echo esc_html(REVIEWX_PRO_VERSION ); ?></strong></span>
            <?php endif; ?>
        </div>
    </div>
</div>