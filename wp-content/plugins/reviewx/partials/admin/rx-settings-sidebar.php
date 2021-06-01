<div class="rx-settings-right">
    <div class="rx-sidebar">
        <div class="rx-sidebar-block rx-license-block">
            <?php
                if( class_exists( 'ReviewXPro' ) ) {
                    do_action( 'rx_licensing' );
                }
            ?>
        </div>
    </div>
</div>