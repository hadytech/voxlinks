<?php
$current_tab = get_option( '_rx_review_email_current_tab' );

if( ! $current_tab ) {
    $current_tab = 'email_editor_tab';
}

$totaltabs = count( $tabs );
$position = intval( array_search( $current_tab, array_keys( $tabs) ) + 1 );

?>
<div class="rx-metabox-wrapper">

    <div class="rx-settings-header">

        <div class="rx-header-left">
            <div class="rx-admin-header">
                <img src="<?php echo esc_url(assets('admin/images/ReviewX.svg')); ?>" alt="<?php echo esc_attr__('ReviewX', 'reviewx')?>">
                <h2>
                    <?php _e( 'Advanced Multi-criteria Rating & Reviews for WooCommerce', 'reviewx' ); ?></h2>
            </div>
        </div>
        <div class="rx-header-right">
            <span><?php _e( 'ReviewX', 'reviewx' ); ?>: <strong><?php echo esc_html( REVIEWX_VERSION ); ?></strong></span>
            <?php
            if( class_exists('ReviewXPro') ):
                ?>
                <span><?php _e( 'ReviewX Pro', 'reviewx' ); ?>: <strong><?php echo esc_html( REVIEWX_PRO_VERSION ); ?></strong></span>
            <?php endif; ?>
        </div>

    </div>

    <div class="rx-metatab-menu rx-review-email-metatab-menu">

        <?php if( ! empty( $tabs ) ) : ?>
            <ul>
                <?php
                $tid = 1;
                foreach( $tabs as $id => $tab ) {
                    $active = $current_tab === $id ? ' active' : '';
                    $class = isset( $tab['icon'] ) ? ' rx-has-icon' : '';
                    $class .= $active;

                    ?>
                    <li data-tabid="<?php echo $tid++; ?>" class="<?php echo esc_attr( $class ); ?>" data-tab="<?php echo esc_attr( $id ); ?>">
                        <?php if( isset( $tab['icon'] ) ) : ?>
                            <span class="rx-menu-icon">
                                    <?php
                                    if( $id == 'email_editor_tab' ) {
                                        ?>
                                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                             viewBox="-49 141 512 512" style="enable-background:new -49 141 512 512;" xml:space="preserve">
                                            <style type="text/css">
                                                .st0{fill:#9BA1B0;}
                                                .st1{fill:#9BA1B0;}
                                            </style>
                                            <path class="st0" d="M399.5,373.4L209,493.1L18.5,373.4v-46.1l-21.2,16v66.8L197.7,536c3.4,2.2,7.3,3.2,11.3,3.2
                                                c3.9,0,7.8-1.1,11.3-3.2l200.4-125.9v-66.8l-21.2-16V373.4z"/>
                                            <path class="st1" d="M446.1,298.8L399,263.1V205c0-35.3-28.7-64-64-64H79c-35.3,0-64,28.7-64,64v58.1l-47.1,35.7
                                                c-10.6,8-16.9,20.7-16.9,34V589c0,35.3,28.7,64,64,64h384c35.3,0,64-28.7,64-64V332.8C463,319.5,456.7,306.8,446.1,298.8z
                                                 M97.8,233.5c0-12.7,10.3-23.1,23.1-23.1h172.2c12.7,0,23.1,10.3,23.1,23.1v0c0,12.7-10.3,23.1-23.1,23.1H120.9
                                                C108.1,256.6,97.8,246.3,97.8,233.5L97.8,233.5z M97.8,324.2c0-12.7,10.3-23.1,23.1-23.1h172.2c12.7,0,23.1,10.3,23.1,23.1v0
                                                c0,12.7-10.3,23.1-23.1,23.1H120.9C108.1,347.2,97.8,336.9,97.8,324.2L97.8,324.2z M420.3,400.1l-202,126.9
                                                c-3.5,2.2-7.4,3.3-11.3,3.3s-7.9-1.1-11.3-3.3l-202-126.9v-67.3L15,316.7v46.5l192,120.7l192-120.7v-46.5l21.3,16.2V400.1z"/>
                                        </svg>

                                    <?php } else if( $id == 'content_tab' ) { ?>
                                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                             viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve">

                                            <path class="st0" d="M89.9,77.8c-0.5,0.9-0.8,1.8-1.4,2.4c-2.5,2.6-5.1,5.2-7.7,7.8c-1.4,1.4-2.9,1.4-4.5,0.4
                                                c-2.3-1.4-4.6-2.8-6.9-4.1c-0.7-0.4-1.6-0.2-2.4-0.2c-0.1,0-0.1,0.1-0.2,0.1c-4.2,0.9-6.3,3.6-6.5,7.9c-0.1,1.7-0.8,3.3-1.2,5
                                                c-0.5,1.9-1.6,2.9-3.6,2.9c-3.5,0-7,0-10.5,0c-1.9,0-3.1-0.9-3.5-2.7c-0.8-3-1.6-6-2.2-9.1c-0.3-1.4-1.2-1.9-2.3-2.6
                                                c-3.5-2.3-6.4-1.1-9.5,0.9c-6,4-5.5,3.4-10.3-1.3c-1.5-1.5-3-3.1-4.6-4.6c-1.6-1.5-1.8-3.1-0.6-5c1.3-2.1,2.6-4.1,3.8-6.3
                                                c0.4-0.8,0.3-1.9,0.2-2.8c-0.7-4.3-3.6-6-7.7-6.4c-1.7-0.2-3.3-0.8-5-1.2c-2-0.5-3-1.6-3-3.8c0.1-3.4,0.1-6.8,0-10.3
                                                c0-2,0.9-3.2,2.8-3.7c3-0.7,5.9-1.5,8.9-2.2c1.4-0.3,2-1,2.7-2.2c1.7-2.9,1.2-5.3-0.7-7.9c-1.2-1.7-2.2-3.5-3.2-5.3
                                                c-0.9-1.5-0.7-2.9,0.5-4.1c2.6-2.6,5.1-5.2,7.7-7.7c1.4-1.4,2.9-1.4,4.5-0.4c2.5,1.5,4.9,3.1,7.5,4.4c0.6,0.4,1.6,0.2,2.4,0.2
                                                c0.4,0,0.8-0.5,1.2-0.6c3.8-0.6,5.1-3.2,5.5-6.7c0.2-2,1-4,1.5-6.1C41.9,0.9,43,0,44.8,0c3.6,0,7.1,0,10.7,0c1.9,0,3,1,3.5,2.8
                                                c0.8,3,1.6,6,2.2,9.1c0.3,1.3,1.1,1.8,2.1,2.5c3.5,2.3,6.3,1.2,9.5-0.9c6.6-4.4,5.9-3.7,11,1.3c1.5,1.5,2.9,3,4.4,4.4
                                                c1.4,1.4,1.6,2.9,0.6,4.6c-1.4,2.2-2.6,4.5-4,6.7c-0.7,1.1-0.5,2-0.3,3.3c1,4.1,3.7,5.6,7.6,6c1.8,0.2,3.5,0.9,5.2,1.3
                                                c1.9,0.5,2.9,1.6,2.9,3.7c0,3.5,0,7,0,10.5c0,1.9-0.9,3.1-2.7,3.5c-3,0.8-6,1.6-9.1,2.2c-1.3,0.3-1.9,1-2.5,2.1
                                                c-2.1,3.4-1.4,6.3,0.9,9.3C87.9,74,88.8,75.9,89.9,77.8z M50,70.5c11.1,0.2,20.4-8.9,20.6-20.1c0.2-11.4-8.8-20.7-20.2-20.9
                                                c-11.2-0.2-20.6,9-20.7,20.2C29.6,61.1,38.6,70.3,50,70.5z"/>
                                        </svg>
                                    <?php } else if( $id == 'design_tab' ){ ?>
                                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                             viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve">
                                            <path class="st0" d="M50,0C22.4,0,0,22.4,0,50s22.4,50,50,50c4.6,0,8.3-3.7,8.3-8.3c0-2.2-0.8-4.1-2.2-5.6c-1.3-1.5-2.1-3.4-2.1-5.5
                                                c0-4.6,3.7-8.3,8.3-8.3h9.8c15.3,0,27.8-12.4,27.8-27.8C100,19.9,77.6,0,50,0z M19.4,50c-4.6,0-8.3-3.7-8.3-8.3s3.7-8.3,8.3-8.3
                                                s8.3,3.7,8.3,8.3S24.1,50,19.4,50z M36.1,27.8c-4.6,0-8.3-3.7-8.3-8.3s3.7-8.3,8.3-8.3s8.3,3.7,8.3,8.3S40.7,27.8,36.1,27.8z
                                                M63.9,27.8c-4.6,0-8.3-3.7-8.3-8.3s3.7-8.3,8.3-8.3s8.3,3.7,8.3,8.3S68.5,27.8,63.9,27.8z M80.6,50c-4.6,0-8.3-3.7-8.3-8.3
                                                s3.7-8.3,8.3-8.3c4.6,0,8.3,3.7,8.3,8.3S85.2,50,80.6,50z"/>
                                            <g>
                                        </svg>
                                    <?php } else if( $id == 'display_tab' ) { ?>
                                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve">
                                            <g>
                                                <path class="st0" d="M98.5,60.5L82.4,17.6c0,0,0,0,0,0l0,0c-2.1-5.7-7.6-9.5-13.7-9.5c-6,0-11.5,3.8-13.7,9.5
                                                    c-0.6,1.6-0.9,3.4-0.9,5.1v18.8h-8.3V22.7c0-8.1-6.6-14.6-14.6-14.6c-6,0-11.5,3.8-13.7,9.5c0,0,0,0,0,0L1.3,60.5c0,0,0,0,0,0
                                                    c-1,2.6-1.5,5.3-1.5,8.1c0,12.7,10.3,22.9,22.9,22.9c12.7,0,22.9-10.3,22.9-22.9v-2.1h8.3v2.1c0,12.7,10.3,22.9,22.9,22.9
                                                    c12.6,0,22.9-10.3,22.9-22.9C100,65.8,99.5,63.1,98.5,60.5L98.5,60.5z M22.8,83.2c-8.1,0-14.6-6.6-14.6-14.6c0-1.8,0.3-3.5,0.9-5.1
                                                    c2.1-5.7,7.6-9.5,13.7-9.5c8.1,0,14.6,6.6,14.6,14.6C37.4,76.7,30.9,83.2,22.8,83.2L22.8,83.2z M77.1,83.2
                                                    c-8.1,0-14.6-6.6-14.6-14.6C62.5,60.6,69,54,77.1,54c6,0,11.5,3.8,13.7,9.5c0.6,1.6,0.9,3.4,0.9,5.1C91.7,76.7,85.1,83.2,77.1,83.2
                                                    L77.1,83.2z M77.1,83.2"/>
                                            </g>
                                        </svg>
                                    <?php } elseif( $id = 'scheduled_emails' ) { ?>

                                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                             viewBox="-49 141 512 512" style="enable-background:new -49 141 512 512;" xml:space="preserve">
                                            <style type="text/css">
                                                .st0{fill:#9BA1B0;}
                                            </style>
                                            <g>
                                                <path class="st0" d="M349.3,214.8H-7.6c-13.3,0-23.5,4.5-30.7,13.5c-7.2,9-10.7,20.2-10.7,33.7c0,10.9,4.7,22.6,14.2,35.3
                                                    c9.5,12.7,19.6,22.7,30.3,29.9c5.9,4.1,23.6,16.4,53.1,36.9c29.5,20.5,52.1,36.2,67.8,47.2c1.7,1.2,5.4,3.8,11,7.9
                                                    c5.6,4.1,10.3,7.3,14,9.8c3.7,2.5,8.2,5.3,13.5,8.4c5.3,3.1,10.2,5.4,14.9,7c4.7,1.6,9,2.3,13,2.3h0.5c4,0,8.3-0.8,13-2.3
                                                    c4.7-1.5,9.6-3.9,14.9-7c5.3-3.1,9.7-5.9,13.5-8.4c3.7-2.5,8.4-5.8,14-9.8c5.6-4.1,9.3-6.7,11-7.9c10.6-7.4,32.3-22.5,65-45.1
                                                    c-12.2-17-19.4-37.8-19.4-60.3C295,266.5,317,232.3,349.3,214.8z"/>
                                                <path class="st0" d="M337.9,389.6c-32.1,22-58,40.2-77.8,54.5c-9.8,7.3-17.8,12.9-24,17c-6.1,4.1-14.3,8.2-24.4,12.4
                                                    c-10.2,4.2-19.7,6.3-28.5,6.3h-0.5c-8.8,0-18.3-2.1-28.5-6.3c-10.2-4.2-18.3-8.4-24.5-12.4c-6.1-4-14.1-9.7-23.9-17
                                                    C82.5,427,39.6,397.3-22.9,354.8c-9.8-6.6-18.6-14.1-26.1-22.5v205.5c0,11.4,4.1,21.1,12.2,29.3c8.1,8.1,17.9,12.2,29.3,12.2h381
                                                    c11.4,0,21.1-4,29.3-12.2c8.1-8.1,12.2-17.9,12.2-29.3V408c-5.3,0.9-10.8,1.3-16.4,1.3C375.9,409.3,354.9,402,337.9,389.6z"/>
                                                <circle class="st0" cx="398.5" cy="305.8" r="64.5"/>
                                            </g>
                                            </svg>
                                    <?php } ?>
                                </span>
                        <?php endif; ?>
                        <span class="rx-menu-title"><?php echo esc_html($tab['title']); ?></span>
                    </li>
                    <?php
                }
                ?>
            </ul>
        <?php endif; ?>

    </div>
    <div class="rx-meta-main-container">
        <div class="rx-meta-contents rx-metatab-wrapper rx_review_email_content_wrap" data-totaltab="<?php echo esc_attr( $totaltabs ); ?>">
            <div class="rx-form-builder-section">
                <form method="post" id="rx-builder-form" action="<?php echo self::get_review_email_action( '', true ); ?>">
                    <input type="hidden" name="rx_builder_current_tab" id="rx_builder_current_tab" value="<?php echo esc_attr($current_tab); ?>">
                    <input type="hidden" name="rx_builder_from_where" id="rx_builder_from_where" value="review_email">
                    <input type="hidden" name="rx_builder_current_page" id="rx_builder_current_page" value="reviewx-review-email">
                    <?php \ReviewX\Modules\OptimisticLock::input(\ReviewX\Constants\LockForm::REVIEW_EMAIL); ?>
                    <input type="hidden" name="rx-tab-nonce" class="rx-tab-nonce" value="<?php echo wp_create_nonce( "special-string" ); ?>">
                    <?php
                    wp_nonce_field( $builder_args['id'], $builder_args['id'] . '_nonce' );
                    $tabid = 1;
                    $is_pro = false;
                    foreach( $tabs as $id => $tab  ) {

                        $active = $current_tab === $id ? ' active ' : '';
                        $sections = ReviewX_Helper::sorter( $tab['sections'], 'priority', 'ASC' );
                        ?>

                        <div id="rx-<?php echo esc_attr( $id ) ?>" class="rx-metatab-content <?php echo esc_attr( $active ); ?> rx_review_email_content">
                            <?php
                            if( $id == 'content_tab' ):
                                echo '<div class="rx-meta-content-tab-parent-section">';
                            endif;

                            do_action( 'rx_builder_before_tab', $id, $tab );

                            foreach( $sections as $sec_id => $section ) {
                                /**
                                 * This will go with section_id, and tab_id
                                 */
                                do_action( 'rx_builder_before_section', $sec_id, $section, $id );
                                if( isset( $section['fields'] ) ) :
                                    $fields = ReviewX_Helper::sorter( $section['fields'], 'priority', 'ASC' );
                                    if( ! empty( $fields ) )  :
                                        $is_pro = isset( $section['is_pro'] ) ? $section['is_pro'] : false;
                                        ?>
                                        <div class="rx-meta-parent-section">
                                            <div id="rx-meta-section-<?php echo esc_attr( $sec_id ); ?>" class="rx-meta-section"> 
                                                <?php if( $id == 'scheduled_emails' ) { ?>
                                                    <div class="rx-scheduled-email-heading">
                                                        <div>
                                                            <h3><?php echo esc_html( $section['title'] ); ?></h3>
                                                        </div>
                                                        <div>
                                                            <div id="rx-reminder-modal-id-2" style="display:none;">

                                                                <div class="rx_erf_item">
                                                                    <div class="rx_label"><?php echo __( 'Scheduled At:', 'reviewx' );?> </div>
                                                                    <div class="rx_content">
                                                                        <input class="select-css" type="datetime-local" id="cron_after">
                                                                    </div>
                                                                </div>

                                                                <div class="rx_erf_item">
                                                                    <div class="rx_label"><?php echo __( 'Select Order Status:', 'reviewx' );?> </div>
                                                                    <div class="rx_content">
                                                                        <select class="select-css" id="schedule_rx_order_status">
                                                                        <?php 
                                                                            $wc_order_status = apply_filters( 'rx_wc_order_status', true );
                                                                            foreach( $wc_order_status as $key => $value ) {                                                        
                                                                        ?>                                                
                                                                            <option value="<?php echo $key; ?>"><?php echo sprintf( __('%s', 'reviewx' ), $value ); ?></option>
                                                                        <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="rx_erf_item">
                                                                    <div class="rx_label"><?php echo __( 'Orders Date Range:', 'reviewx' );?> </div>
                                                                    <div class="rx_content">
                                                                        <select class="select-css" id="schedule_date_range">
                                                                            <option value="all_the_time"><?php echo __( 'All the Time', 'reviewx' );?></option>
                                                                            <option value="yesterday"><?php echo __( 'Yesterday', 'reviewx' );?></option>
                                                                            <option value="last_week"><?php echo __( 'Last Week', 'reviewx' );?></option>
                                                                            <option value="this_month"><?php echo __( 'This Month', 'reviewx' );?></option>
                                                                            <option value="last_month"><?php echo __( 'Last Month', 'reviewx' );?></option>
                                                                            <option value="this_year"><?php echo __( 'This Year', 'reviewx' );?></option>
                                                                            <option value="last_year"><?php echo __( 'Last year', 'reviewx' );?></option>
                                                                            <option <?php !\ReviewX_Helper::is_pro() ? _e('disabled') : null ?> value="custom_date"><?php echo __( 'Custom Date', 'reviewx' );?></option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="rx_erf_item">
                                                                    <?php if( !\ReviewX_Helper::is_pro() ): ?>
                                                                    <div class="rx-pro-label-wrapper">
                                                                        <sup class="rx-pro-label"><?php echo __('Pro', 'reviewx');?></sup>
                                                                    </div>  
                                                                    <?php endif; ?>                                                                       
                                                                    <div class="rx_label"><?php echo __( 'Custom Date Range:', 'reviewx' );?> </div>
                                                                    <div class="rx_content">
                                                                        <input <?php !\ReviewX_Helper::is_pro() ? _e('disabled') : null ?> type="date" min="1976-01-01" placeholder="Start Datetime" id="schedule_start_datetime" class="te_input">
                                                                        <input <?php !\ReviewX_Helper::is_pro() ? _e('disabled') : null ?> type="date" min="1976-01-01" placeholder="End Datetime" id="schedule_end_datetime" class="te_input">
                                                                    </div>
                                                                </div>

                                                                <div class="rx_erf_item">
                                                                    <?php if( !\ReviewX_Helper::is_pro() ): ?>
                                                                    <div class="rx-pro-label-wrapper">
                                                                        <sup class="rx-pro-label"><?php echo __('Pro', 'reviewx');?></sup>
                                                                    </div>  
                                                                    <?php endif; ?>                                                                     
                                                                    <div class="rx_label"><?php echo __( 'Filter Products', 'reviewx' );?></div>
                                                                    <div class="rx_content">
                                                                        <div>
                                                                            <label>
                                                                                <input <?php !\ReviewX_Helper::is_pro() ? _e('disabled') : null ?> type="checkbox" id="schedule_filter_products">
                                                                                <span></span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="rx_erf_item">
                                                                    <?php if( !\ReviewX_Helper::is_pro() ): ?>
                                                                    <div class="rx-pro-label-wrapper">
                                                                        <sup class="rx-pro-label"><?php echo __('Pro', 'reviewx');?></sup>
                                                                    </div>  
                                                                    <?php endif; ?>                                                                     
                                                                    <div class="rx_label"><?php echo __( 'Filter By:', 'reviewx' );?> </div>
                                                                    <div class="rx_content">
                                                                        <select <?php !\ReviewX_Helper::is_pro() ? _e('disabled') : null ?> class="select-css" id="schedule_filter_by">
                                                                            <option value="-">-</option>
                                                                            <option value="by_category"><?php echo __( 'By Category', 'reviewx' );?></option>
                                                                            <option value="by_products"><?php echo __( 'By Product(s)', 'reviewx' );?></option>
                                                                            <option value="by_both"><?php echo __( 'By Products + By Category', 'reviewx' );?></option>
                                                                            <option value="by_special_conditions"><?php echo __( 'Special Conditions', 'reviewx' );?></option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="rx_erf_item">
                                                                    <?php if( !\ReviewX_Helper::is_pro() ): ?>
                                                                    <div class="rx-pro-label-wrapper">
                                                                        <sup class="rx-pro-label"><?php echo __('Pro', 'reviewx');?></sup>
                                                                    </div>  
                                                                    <?php endif; ?>                                                                     
                                                                    <div class="rx_label"><?php echo __( 'Filter By Category:', 'reviewx' );?> </div>
                                                                    <div class="rx_content">
                                                                        <select <?php !\ReviewX_Helper::is_pro() ? _e('disabled') : null ?> name="" class="select-css" id="schedule_filter_by_category" class="te_input">
                                                                            <?php foreach(rx_get_categories() as $category): ?>
                                                                                <option value="<?php _e($category->term_id); ?>"><?php _e($category->name); ?></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="rx_erf_item">
                                                                    <?php if( !\ReviewX_Helper::is_pro() ): ?>
                                                                    <div class="rx-pro-label-wrapper">
                                                                        <sup class="rx-pro-label"><?php echo __('Pro', 'reviewx');?></sup>
                                                                    </div>  
                                                                    <?php endif; ?>                                                                     
                                                                    <div class="rx_label"><?php echo __( 'Filter By Products:', 'reviewx' );?> </div>
                                                                    <div class="rx_content">
                                                                        <select <?php !\ReviewX_Helper::is_pro() ? _e('disabled') : null ?> name="" class="select-css" id="schedule_filter_by_products" class="te_input">
                                                                            <?php foreach(rx_get_products() as $product): ?>
                                                                                <?php $product = get_post($product->get_id()); ?>
                                                                                <option value="<?php _e($product->ID) ?>"><?php _e($product->post_title); ?></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="rx_erf_item">
                                                                    <?php if( !\ReviewX_Helper::is_pro() ): ?>
                                                                    <div class="rx-pro-label-wrapper">
                                                                        <sup class="rx-pro-label"><?php echo __('Pro', 'reviewx');?></sup>
                                                                    </div>  
                                                                    <?php endif; ?>                                                                     
                                                                    <div class="rx_label"><?php echo __( 'Filter By Conditions:', 'reviewx' );?> </div>
                                                                    <div class="rx_content">
                                                                        <select <?php !\ReviewX_Helper::is_pro() ? _e('disabled') : null ?> class="select-css" id="schedule_filter_by_conditions">
                                                                            <option value="most_reviewed"><?php echo __( 'Most Reviewed Product', 'reviewx' );?></option>
                                                                            <option value="less_reviewed"><?php echo __( 'Lowest Reviewed Product', 'reviewx' );?></option>
                                                                            <option value="top_rated"><?php echo __( 'Top Rated product', 'reviewx' );?></option>
                                                                            <option value="less_rated"><?php echo __( 'Lowest Rated Product', 'reviewx' );?></option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <button class="quick-builder-submit-btn" id="schedule_filterButton" type="button"><?php esc_html_e( 'Save', 'reviewx' );?></button>

                                                            </div>

                                                            <?php if(\ReviewX_Helper::is_pro()): ?>
                                                                <a title="<?php echo __('Create New Schedule','reviewx'); ?>" href="#TB_inline?&width=600&height=550&inlineId=rx-reminder-modal-id-2" class="thickbox">
                                                                    <button class="rx-common-form-button rx-create-new-schedule rx-common-form-button-free" type="button">
                                                                        <?php esc_html_e( 'Create New Schedule', 'reviewx' );?>
                                                                    </button>
                                                                </a>
                                                            <?php else: ?>
                                                                <div class="rx-create-schedule-area">
                                                                    <button class="rx-common-form-button rx-create-new-schedule rx-common-form-button-free" type="button">
                                                                        <?php esc_html_e( 'Create New Schedule', 'reviewx' );?>
                                                                    </button>
                                                                    <div class="rx-pro-label-wrapper">
                                                                        <sup class="rx-pro-label"><?php esc_html_e( 'Pro', 'reviewx' );?></sup>
                                                                    </div>
                                                                </div>
                                                            <?php endif; ?>
                                                          
                                                        </div>
                                                    </div>
                                                <?php  } else {
                                                    if(!empty( $section['title'] ) ) {
                                                        ?>
                                                        <h3 class="rx-meta-section-title">
                                                            <?php echo esc_html($section['title']); ?>
                                                        </h3>
                                                        <?php
                                                        }
                                                    }
                                                ?>
                                                <?php
                                                if( $id == 'content_tab' ){
                                                    ?>
                                                    <div class="rx_email_setting_tab_section">
                                                        <?php
                                                        foreach( $fields as $key => $field ) {
                                                            \ReviewX\Controllers\Admin\Core\ReviewxMetaBox::render_meta_field_email_setting( $key, $field, '', $id, $is_pro );
                                                        }
                                                        ?>
                                                    </div>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <table>
                                                        <?php
                                                        foreach( $fields as $key => $field ) {
                                                            \ReviewX\Controllers\Admin\Core\ReviewxMetaBox::render_option_field( $key, $field, '', $id, $is_pro );
                                                        }
                                                        ?>
                                                    </table>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    <?php
                                    endif;
                                endif;
                                if( isset( $section['view'] ) ) :
                                    do_action( 'rx_builder_before_section_view', $sec_id, $section, $id );
                                    call_user_func( $section['view'] );
                                    do_action( 'rx_builder_after_section_view', $sec_id, $section, $id );
                                endif;
                                /**
                                 * This will go with section_id, and tab_id
                                 */
                                do_action( 'rx_builder_after_section', $sec_id, $section, $id );
                            }
                            ?>
                            <?php
                            if( $id == 'content_tab' ):
                                echo '</div>';
                            endif;
                            ?>
                            <div class="quick-builder-submit-btn-wrap">

                                <?php if($id == 'email_editor_tab'): ?>
                                    <div id="rx-reminder-modal-id" style="display:none;">
                                        <div class="rx_erf_item">
                                            <div class="rx_label"><?php echo __( 'Select Order Status:', 'reviewx' );?> </div>
                                            <div class="rx_content">
                                                <select class="select-css" id="rx_order_status">
                                                    <?php 
                                                        $wc_order_status = apply_filters( 'rx_wc_order_status', true );
                                                        foreach( $wc_order_status as $key => $value ) {                                                        
                                                    ?>                                                
                                                        <option value="<?php echo $key; ?>"><?php echo sprintf( __('%s', 'reviewx' ), $value ); ?></option>
                                                    <?php } ?>                                                    
                                                </select>
                                            </div>
                                        </div>
                                        <div class="rx_erf_item">
                                            <div class="rx_label"><?php echo __( 'Orders Date Range:', 'reviewx' );?> </div>
                                            <div class="rx_content">
                                                <select class="select-css" id="date_range">
                                                    <option value="all_the_time"><?php echo __( 'All the Time', 'reviewx' );?></option>
                                                    <option value="yesterday"><?php echo __( 'Yesterday', 'reviewx' );?></option>
                                                    <option value="last_week"><?php echo __( 'Last Week', 'reviewx' );?></option>
                                                    <option value="this_month"><?php echo __( 'This Month', 'reviewx' );?></option>
                                                    <option value="last_month"><?php echo __( 'Last Month', 'reviewx' );?></option>
                                                    <option value="this_year"><?php echo __( 'This Year', 'reviewx' );?></option>
                                                    <option value="last_year"><?php echo __( 'Last year', 'reviewx' );?></option>
                                                    <option <?php !\ReviewX_Helper::is_pro() ? _e('disabled') : null ?> value="custom_date"><?php echo __( 'Custom Date', 'reviewx' );?></option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="rx_erf_item">
                                            <?php if( !\ReviewX_Helper::is_pro() ): ?>
                                                <div class="rx-pro-label-wrapper">
                                                    <sup class="rx-pro-label"><?php echo __('Pro', 'reviewx');?></sup>
                                                </div>
                                            <?php endif; ?>

                                            <div class="rx_label"><?php echo __( 'Custom Date Range:', 'reviewx' );?> </div>
                                            <div class="rx_content">
                                                <input <?php !\ReviewX_Helper::is_pro() ? _e('disabled') : null ?> type="date" min="1976-01-01" placeholder="Start Datetime" id="start_datetime" class="te_input">
                                                <input <?php !\ReviewX_Helper::is_pro() ? _e('disabled') : null ?> type="date" min="1976-01-01" placeholder="End Datetime" id="end_datetime" class="te_input">
                                            </div>
                                        </div>

                                        <div class="rx_erf_item">
                                            <?php if( !\ReviewX_Helper::is_pro() ): ?>
                                                <div class="rx-pro-label-wrapper">
                                                    <sup class="rx-pro-label"><?php echo __('Pro', 'reviewx');?></sup>
                                                </div>
                                            <?php endif; ?>
                                            <div class="rx_label"><?php echo __( 'Filter Products', 'reviewx' );?></div>
                                            <div class="rx_content">
                                                <div>
                                                    <label>
                                                        <input <?php !\ReviewX_Helper::is_pro() ? _e('disabled') : null ?> type="checkbox" id="filter_products">
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="rx_erf_item">
                                            <?php if( !\ReviewX_Helper::is_pro() ): ?>
                                                <div class="rx-pro-label-wrapper">
                                                    <sup class="rx-pro-label"><?php echo __('Pro', 'reviewx');?></sup>
                                                </div>
                                            <?php endif; ?>
                                            <div class="rx_label"><?php echo __( 'Filter By:', 'reviewx' );?> </div>
                                            <div class="rx_content">
                                                <select  <?php !\ReviewX_Helper::is_pro() ? _e('disabled') : null ?> class="select-css" id="filter_by">
                                                    <option value="-">-</option>
                                                    <option value="by_category"><?php echo __( 'By Category', 'reviewx' );?></option>
                                                    <option value="by_products"><?php echo __( 'By Product(s)', 'reviewx' );?></option>
                                                    <option value="by_both"><?php echo __( 'By Products + By Category', 'reviewx' );?></option>
                                                    <option value="by_special_conditions"><?php echo __( 'Special Conditions', 'reviewx' );?></option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="rx_erf_item rx_filter_by_category">
                                            <?php if( !\ReviewX_Helper::is_pro() ): ?>
                                                <div class="rx-pro-label-wrapper">
                                                    <sup class="rx-pro-label"><?php echo __('Pro', 'reviewx');?></sup>
                                                </div>
                                            <?php endif; ?>
                                            <div class="rx_label"><?php echo __( 'Filter By Category:', 'reviewx' );?> </div>
                                            <div class="rx_content">
                                                <select <?php !\ReviewX_Helper::is_pro() ? _e('disabled') : null ?> name="" class="select-css" id="filter_by_category" class="te_input">
                                                    <?php foreach(rx_get_categories() as $category): ?>
                                                        <option value="<?php _e($category->term_id); ?>"><?php _e($category->name); ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="rx_erf_item rx_filter_by_products">
                                            <?php if( !\ReviewX_Helper::is_pro() ): ?>
                                                <div class="rx-pro-label-wrapper">
                                                    <sup class="rx-pro-label"><?php echo __('Pro', 'reviewx');?></sup>
                                                </div>
                                            <?php endif; ?>
                                            <div class="rx_label"><?php echo __( 'Filter By Products:', 'reviewx' );?> </div>
                                            <div class="rx_content">
                                                <select <?php !\ReviewX_Helper::is_pro() ? _e('disabled') : null ?> name="" class="select-css" id="filter_by_products" class="te_input">
                                                    <?php foreach(rx_get_products() as $product): ?>
                                                        <?php $product = get_post($product->get_id()); ?>
                                                        <option value="<?php _e($product->ID); ?>"><?php _e($product->post_title); ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="rx_erf_item">
                                            <?php if( !\ReviewX_Helper::is_pro() ): ?>
                                                <div class="rx-pro-label-wrapper">
                                                    <sup class="rx-pro-label"><?php echo __('Pro', 'reviewx');?></sup>
                                                </div>
                                            <?php endif; ?>
                                            <div class="rx_label"><?php echo __( 'Filter By Conditions:', 'reviewx' );?> </div>
                                            <div class="rx_content">
                                                <select <?php !\ReviewX_Helper::is_pro() ? _e('disabled') : null ?> class="select-css" id="filter_by_conditions">
                                                    <option value="most_reviewed"><?php echo __( 'Most Reviewed Product', 'reviewx' );?></option>
                                                    <option value="less_reviewed"><?php echo __( 'Lowest Reviewed Product', 'reviewx' );?></option>
                                                    <option value="top_rated"><?php echo __( 'Top Rated Product', 'reviewx' );?></option>
                                                    <option value="less_rated"><?php echo __( 'Lowest Rated Product', 'reviewx' );?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <button class="quick-builder-submit-btn" id="filterButton" type="button"><?php esc_html_e( 'Save', 'reviewx' );?></button>
                                    </div>
                                <?php endif; ?>

                                <?php
                                $tabid = ++$tabid;
                                if( !class_exists('ReviewXPro') ) {
                                    if( $tabid <= $totaltabs ) {
                                        if( $id !='content_tab'){
                                            add_thickbox();
                                        ?>
                                        <input type="hidden" name="rx-setting-nonce" class="rx-setting-nonce" value="<?php echo wp_create_nonce( "special-string" ); ?>">
                                        <?php if($id == 'email_editor_tab'): ?>
                                                <a title="<?php echo __('Filter & Send Reminder','reviewx'); ?>" href="#TB_inline?&width=600&height=550&inlineId=rx-reminder-modal-id" class="thickbox rx_thickbok"><?php echo __('Filter & Send Reminder', 'reviewx'); ?></a>
                                            <button class="rx_save_setting_tab quick-builder-submit-btn" type="button" data-tabid="<?php echo esc_attr($tabid); ?>"><?php esc_html_e( $id == 'email_tab' ? 'Save & Send email' : 'Save', 'reviewx' );?></button>
                                        <?php endif; ?>
                                    <?php } } } ?>

                                <?php if( class_exists('ReviewXPro') ) {
                                        if ($id == 'email_editor_tab') {
                                        ?>
                                        <input type="hidden" name="rx-setting-nonce" class="rx-setting-nonce" value="<?php echo wp_create_nonce("special-string"); ?>">
                                        <a title="<?php echo __('Filter & Send Reminder','reviewx'); ?>" href="#TB_inline?&width=600&height=550&inlineId=rx-reminder-modal-id" class="thickbox rx_thickbok"><?php echo __('Filter & Send Reminder', 'reviewx'); ?></a>
                                        <button class="rx_save_setting_tab quick-builder-submit-btn rx_review_email_save_btn" type="button" data-tabid="<?php echo esc_attr($tabid); ?>"><?php esc_html_e('Save Settings', 'reviewx'); ?></button>
                                        <?php
                                        }

                                        if ($id == 'content_tab'){
                                        ?>
                                            <button class="rx_save_setting_tab quick-builder-submit-btn" type="button" data-tabid="<?php echo esc_attr($tabid); ?>"><?php esc_html_e('Save Settings', 'reviewx'); ?></button>
                                        <?php
                                        }
                                    }
                                ?>
                            </div>
                            <?php do_action( 'rx_builder_after_tab', $id, $tab ); ?>
                        </div>
                        <?php
                    }
                    ?>
                </form>
            </div>
            <!-- Load license section -->
            <div class="rx-license-section">
                <div class="rx-sidebar-block">
                    <div class="rx-admin-sidebar-logo">
                        <img alt="<?php _e( 'ReviewX', 'reviewx' ) ?>" src="<?php echo esc_url(assets('admin/images/ReviewX_icon.svg')); ?>">
                    </div>
                    <div class="rx-admin-sidebar-cta">
                        <?php
                        if( class_exists('ReviewXPro') ) {
                            printf( __( '<a rel="nofollow" href="%s" target="_blank">Manage License</a>', 'reviewx' ), esc_url('https://wpdeveloper.net/account') );
                        }else{
                            printf( __( '<a rel="nofollow" href="%s" target="_blank">Upgrade to Pro</a>', 'reviewx' ), esc_url('https://reviewx.io/upgrade/reviewx-pro') );
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    include_once REVIEWX_PARTIALS_PATH . 'admin/footer-info-block.php';
    ?>
</div>
