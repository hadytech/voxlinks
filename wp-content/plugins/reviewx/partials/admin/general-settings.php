<?php 
    $current_tab = get_option( '_rx_builder_current_tab' );
    
    if( ! $current_tab ) {
        $current_tab = 'source_tab';
    }

    $totaltabs = count( $tabs );
    $position = intval( array_search( $current_tab, array_keys( $tabs) ) + 1 );

?>
<div class="rx-metabox-wrapper">

    <div class="rx-settings-header">

        <div class="rx-header-left">
            <div class="rx-admin-header">
                <img src="<?php echo esc_url(assets('admin/images/ReviewX.svg')); ?>" alt="<?php echo esc_attr__('ReviewX', 'reviewx')?>">
                <h2><?php _e( 'Advanced Multi-criteria Rating & Reviews for WooCommerce', 'reviewx' ); ?></h2>
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

    <!-- <div class="rx-metatab-menu"> -->

    <?php //if( ! empty( $tabs ) ) : ?>
        <!-- <ul> -->
            <?php 
                // $tid = 1;
                // foreach( $tabs as $id => $tab ) {
                //     $active = $current_tab === $id ? ' active' : 'active';
                //     $class = isset( $tab['icon'] ) ? ' rx-has-icon' : '';
                //     $class .= $active;
                    ?>
                        <!-- <li data-tabid="<?php //echo $tid++; ?>" class="<?php// echo esc_attr( $class ); ?>" data-tab="<?php //echo esc_attr( $id ); ?>">
                            <?php //if( isset( $tab['icon'] ) ) : ?>
                                <span class="rx-menu-icon">
                                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve"><g><circle class="st0" cx="50" cy="28.1" r="28.1"/><path class="st0" d="M29.9,59.5c5.8,3.8,12.7,5.9,20.1,5.9s14.3-2.2,20.1-5.9V100L50,82.7L29.9,100V59.5z"/></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                                </span>
                            <?php// endif; ?>
                            <span class="rx-menu-title"><?php //echo esc_html($tab['title']); ?></span>
                        </li> -->
                    <?php
                //}
            ?>
        <!-- </ul> -->
    <?php //endif; ?>

    <!-- </div> -->
    <div class="rx-meta-main-container">
        <div class="rx-meta-contents rx-metatab-wrapper" data-totaltab="<?php echo esc_attr( $totaltabs ); ?>">
            <div class="rx-form-builder-section">
                <form method="post" id="rx-builder-form" action="<?php echo self::get_form_action( '', false ); ?>">                    
                    <!-- <input type="hidden" name="rx_builder_current_tab" id="rx_builder_current_tab" value="<?php //echo esc_attr($current_tab); ?>"> -->
                    <!-- <input type="hidden" name="rx_builder_from_where" id="rx_builder_from_where" value="settings"> -->
                    <input type="hidden" name="rx_builder_current_page" id="rx_builder_current_page" value="rx-settings">
                    <?php \ReviewX\Modules\OptimisticLock::input(\ReviewX\Constants\LockForm::SETTINGS); ?>
                    <input type="hidden" name="rx-tab-nonce" class="rx-tab-nonce" value="<?php echo wp_create_nonce( "special-string" ); ?>">
                    <?php 
                        wp_nonce_field( $builder_args['id'], $builder_args['id'] . '_nonce' );
                        $tabid = 1;
                        $is_pro = false;
                        foreach( $tabs as $id => $tab  ) {

                            $active = $current_tab === $id ? ' active ' : 'active';                                    
                            $sections = ReviewX_Helper::sorter( $tab['sections'], 'priority', 'ASC' );   
                            ?>

                            <div id="rx-<?php echo esc_attr( $id ) ?>" class="rx-metatab-content <?php echo esc_attr( $active ); ?>">
                            <?php
                                if( $id == 'content_tab' ):
                                    echo '<div class="rx-meta-content-tab-parent-section">';
                                endif;  
                            ?>

                            <?php 
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
                                                <h3 class="rx-meta-section-title">
                                                    <?php echo esc_html( $section['title'] ); ?>    
                                                </h3>  
                                                <table>
                                                    <?php                                                                                
                                                        foreach( $fields as $key => $field ) {
                                                            \ReviewX\Controllers\Admin\Core\ReviewxMetaBox::render_option_field( $key, $field, '', $id, $is_pro );
                                                        }
                                                    ?>
                                                </table>                                     
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
                                <?php
                                $tabid = ++$tabid;
                                if( !class_exists('ReviewXPro') ) {
                                if( $tabid <= $totaltabs ) {
                                    ?>
                                    <input type="hidden" name="rx-setting-nonce" class="rx-setting-nonce" value="<?php echo wp_create_nonce( "special-string" ); ?>">
                                    <button class="rx_save_setting_tab quick-builder-submit-btn" type="button" data-tabid="<?php echo esc_attr($tabid); ?>"><?php esc_html_e( $id == 'email_tab' ? 'Save & Send email' : 'Save', 'reviewx' );?></button>
                                <?php } } ?>
                                <?php if( class_exists('ReviewXPro') ) {
                                if( $tabid < $totaltabs ) {
                                    ?>
                                    <input type="hidden" name="rx-setting-nonce" class="rx-setting-nonce" value="<?php echo wp_create_nonce( "special-string" ); ?>">
                                    <button class="rx_save_setting_tab quick-builder-submit-btn" type="button" data-tabid="<?php echo esc_attr($tabid); ?>"><?php esc_html_e( $id == 'email_tab' ? 'Save & Send email' : 'Save', 'reviewx' );?></button>
                                <?php } } ?>    
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