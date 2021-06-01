<div class="rx_store_owner">
    <div class="rx_store_owner_icon">
        <?php 
            $shop_icon_url = get_option( '_rx_option_icon_upload' );
            if( !empty($shop_icon_url) ){  ?>
            <div class="rx-shop-icon">
                <img src="<?php echo esc_url($shop_icon_url); ?>" alt="<?php esc_attr_e('ReviewX shop icon',  'reviewx'); ?>"/>
            </div>            
        <?php 
            } else {
        ?>
        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 66 66" style="enable-background:new 0 0 66 66;" xml:space="preserve">
            <g>
                <path class="st0" d="M50,21.2c-0.3,2.8-1.5,4.9-3.7,6.3c-1.5,1-3.3,1.5-5.1,1.4c-3.8-0.2-6.5-2.7-7.8-7.4c-0.5,2.9-1.8,5-4.2,6.4
                c-1.6,0.9-3.3,1.2-5.1,1c-3.8-0.5-6.6-3.3-7.3-7.5c-0.2,0.6-0.2,1.1-0.4,1.6c-1,3.6-4.3,6.1-8,6c-3.8,0-7.3-2.5-8.2-6
                c-0.3-1.1-0.2-2.1,0.4-3.1C3.8,15,6.9,10.1,10,5.1c0.3-0.4,0.6-0.6,1.1-0.6c13.9,0,27.8,0,41.8,0c0.5,0,0.8,0.2,1.1,0.6
                c3.8,5.1,7.7,10.2,11.5,15.3c0.5,0.6,0.6,1.2,0.5,1.9c-0.6,3.8-3.5,6.4-7.3,6.7c-3.8,0.3-7.1-2-8.2-5.7C50.3,22.6,50.2,22,50,21.2z
                "/>
                <path class="st0" d="M49.6,29.8c-4.8,4.3-11.7,4.2-16.4,0c-4.9,4.4-11.9,4.1-16.4,0c-1.5,1.4-3.3,2.4-5.4,2.9
                c-2.1,0.5-4.1,0.4-6.2-0.2v23.1c0,3.3,2.7,6,6,6h13.2c0.2,0,0.4-0.2,0.4-0.4c0,0,0,0,0,0V43.4c0-1,0.8-1.8,1.8-1.8h12.9
                c1,0,1.8,0.8,1.8,1.8v17.7c0,0,0,0,0,0c0,0.2,0.2,0.4,0.4,0.4h13.2c3.3,0,6-2.7,6-6V32.6C55.3,33.2,53.7,32.9,49.6,29.8z"/>
            </g>
        </svg>
        <?php } ?>

    </div>
    <div class="rx_store_owner_title"><?php esc_html_e( 'Reply of review ', 'reviewx' ); ?><a href="<?php echo esc_url( get_comment_link( $parent_id ) ); ?>"><strong>#<?php echo esc_html( $parent_id ); ?></strong></a></div>
</div>