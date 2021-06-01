<?php 
    $current_tab = get_option( '_rx_builder_quick_setup' );

    if( ! $current_tab ) {
        $current_tab = 'source_tab';
    }

    $totaltabs = count( $tabs );
    $position = intval( array_search( $current_tab, array_keys( $tabs) ) + 1 );

?>
<div class="rx-metabox-wrapper rx-metabox-quick-setup">

    <div class="rx-settings-header">

        <div class="rx-header-left">
            <div class="rx-admin-header">
                <img src="<?php echo esc_url(assets('admin/images/ReviewX.svg')); ?>" alt="<?php esc_attr_e( 'ReviewX', 'reviewx' ) ?>">
                    <div>                
                        <h2 class="rx-plugin-tagline"><?php esc_html_e( 'Quick Setup For WooCommerce', 'reviewx' ); ?></h2>
                        <h4 class="rx-plugin-tagline2">
                            <a href='post-new.php?post_type=reviewx'>
                                <?php esc_html_e( 'Click here to use ReviewX with custom post types', 'reviewx' ); ?>
                            </a>
                        </h4>
                    </div>
            </div>
        </div>

        <div class="rx-header-right">
            <span><?php esc_html_e( 'ReviewX', 'reviewx' ); ?>: <strong><?php echo REVIEWX_VERSION; ?></strong></span>
            <?php 
                if( class_exists('ReviewXPro') ):
            ?>
            <span><?php esc_html_e( 'ReviewX Pro', 'reviewx' ); ?>: <strong><?php echo REVIEWX_PRO_VERSION; ?></strong></span>
            <?php endif; ?>
        </div>

    </div>

    <div class="rx-metatab-menu rx-quick-builder-tab-menu">

    <?php if( ! empty( $tabs ) ) : ?>
        <ul>
            <?php 
                $tid = 1;
                $checker = 1;
                $tabids = array();
                foreach( $tabs as $id => $tab ) {
                    $tabids[]   = $id;
                    $active     = $current_tab === $id ? ' active' : '';                    
                    $class      = isset( $tab['icon'] ) ? ' rx-has-icon rx-quick-setup-li' : '';
                    $class      .= $active;

                    if( $position > $tid ) {
                        $completeClass = ' rx-complete';
                        $class      .= $completeClass;
                    }
                    ?>
                        <li data-tabid="<?php echo $tid++; ?>" class="<?php echo esc_attr( $class ); ?>" data-tab="<?php echo esc_attr( $id ); ?>">
                            <?php if( isset( $tab['icon'] ) ) : ?>
                                <span class="rx-menu-icon">
                                    <?php 
                                        if( $id == 'source_tab' ) {
                                    ?>
                                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve">

                                            <g>
                                                <path class="st0" d="M65,26.3c-8.5,0-17.1,0-25.6,0c-3,0-4.1-1-4.1-4c0-5.3,0-10.6,0-15.9c0-2.8,1-3.8,3.8-3.8c17.2,0,39.8,0,57,0
                                                    c2.8,0,3.8,1,3.8,3.8c0,5.4,0,10.7,0,16.1c0,2.8-1,3.8-3.8,3.8C87.6,26.3,73.6,26.3,65,26.3z"/>
                                                <path class="st0" d="M64.9,38.1c8.5,0,22.5,0,31,0c3.1,0,4.1,1,4.1,4c0,5.3,0,10.6,0,15.9c0,2.8-1,3.8-3.8,3.8c-17.2,0-39.8,0-57,0
                                                    c-2.8,0-3.8-1-3.9-3.8c0-5.4,0-10.7,0-16.1c0-2.8,1-3.8,3.8-3.8C47.8,38.1,56.4,38.1,64.9,38.1z"/>
                                                <path class="st0" d="M65,97.4c-8.5,0-17.1,0-25.6,0c-3.1,0-4.1-1-4.1-4c0-5.3,0-10.6,0-15.9c0-2.8,1.1-3.8,4-3.9
                                                    c17.1,0,39.6,0,56.8,0c2.8,0,3.8,1.1,3.9,3.8c0,5.4,0,10.7,0,16.1c0,2.8-1,3.8-3.8,3.8C87.6,97.4,73.6,97.4,65,97.4z"/>
                                                <path class="st0" d="M23.5,14.6c0,2.7,0,5.5,0,8.2c0,2.4-1.1,3.5-3.5,3.5c-5.6,0-11.1,0-16.7,0c-2.4,0-3.5-1.1-3.5-3.5
                                                    c0-5.6,0-11.1,0-16.7c0-2.4,1.1-3.5,3.5-3.5c5.6,0,11.1,0,16.7,0c2.4,0,3.5,1.1,3.5,3.5C23.5,8.9,23.5,11.8,23.5,14.6z"/>
                                                <path class="st0" d="M11.6,38.1c2.7,0,5.5,0,8.2,0c2.5,0,3.6,1.1,3.6,3.6c0,5.5,0,11,0,16.5c0,2.5-1.1,3.6-3.6,3.6
                                                    c-5.6,0-11.1,0-16.7,0c-2.2,0-3.4-1.2-3.4-3.4c0-5.6,0-11.3,0-16.9c0-2.3,1.2-3.4,3.6-3.4C6.1,38.1,8.9,38.1,11.6,38.1z"/>
                                                <path class="st0" d="M23.5,85.4c0,2.8,0,5.6,0,8.4c0,2.5-1.1,3.6-3.6,3.6c-5.5,0-11,0-16.5,0c-2.5,0-3.6-1.1-3.6-3.6
                                                    c0-5.5,0-11,0-16.5c0-2.5,1.1-3.6,3.7-3.6c5.5,0,11,0,16.5,0c2.5,0,3.5,1.1,3.6,3.6C23.5,80,23.5,82.7,23.5,85.4z"/>
                                            </g>

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
                                        <?php } elseif( $id = 'license_tab' ) { ?>
                                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	                                            viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve">
                                                <g>
                                                    <circle class="st0" cx="50" cy="28.1" r="28.1"/>
                                                    <path class="st0" d="M29.9,59.5c5.8,3.8,12.7,5.9,20.1,5.9s14.3-2.2,20.1-5.9V100L50,82.7L29.9,100V59.5z"/>
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
        <div class="rx-meta-contents rx-metatab-wrapper" data-totaltab="<?php echo esc_attr( $totaltabs ); ?>">
            <div class="rx-form-builder-section">
                <form method="post" id="rx-builder-form" action="<?php echo self::get_form_action( '', true ); ?>">                    
                    <input type="hidden" name="rx_builder_current_tab" id="rx_builder_current_tab" value="<?php echo esc_attr($current_tab); ?>">                    
                    <input type="hidden" name="rx_builder_from_where" id="rx_builder_from_where" value="quick_setup">
                    <input type="hidden" name="rx_builder_current_page" id="rx_builder_current_page" value="reviewx-quick-setup">
                    <?php \ReviewX\Modules\OptimisticLock::input(\ReviewX\Constants\LockForm::QUICK_SETUP); ?>
                    <input type="hidden" name="rx-tab-nonce" class="rx-tab-nonce" value="<?php echo wp_create_nonce( "special-string" ); ?>">
                    <?php 
                        wp_nonce_field( $builder_args['id'], $builder_args['id'] . '_nonce' );
                        $tabid = 1;
                        $is_pro = false;
                        foreach( $tabs as $id => $tab  ) {
                            $active = $current_tab === $id ? ' active ' : '';                                    
                            $sections = \ReviewX_Helper::sorter( $tab['sections'], 'priority', 'ASC' );

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
                                        //Check multiple dimentional
                                        if( isset( $section['is_multiple'] ) ):
                                            $i=1;
                                            ?>
                                            <div class="rx-meta-parent-section">
                                            <?php
                                            foreach( $section as $key => $value ):
                                                if( $key == 'is_multiple' ) {
                                                    continue;
                                                } else {
                                                    $title_key  = 'title'.$i;
                                                    $field_key  = 'fields'.$i;
                                                    $fields = ReviewX_Helper::sorter( (isset($section[$field_key])?$section[$field_key]:[]), 'priority', 'ASC' );
                                                    if( ! empty( $fields ) )  {
                                                        $is_pro = isset( $section['is_pro'] ) ? $section['is_pro'] : false;
                                                        ?>
                                                            <div id="rx-meta-section-<?php echo esc_attr( $sec_id ); ?>" class="rx-meta-section">                                        
                                                                <h3 class="rx-meta-section-title">
                                                                    <?php echo esc_html( $section[$title_key] ); ?>    
                                                                </h3> 
                                                                
                                                                <div class="rx-meta-section-desc-box">
                                                                    <p class="rx-meta-section-desc"><?php echo array_key_exists('desc', $section) ? $section['desc'] : ''; ?></p>
                                                                    <p class="rx-meta-section-desc"><?php echo array_key_exists('desc', $section) ? $section['desc1'] : ''; ?></p>
                                                                </div>                        
                                                                <table>
                                                                    <?php                                                                               
                                                                        foreach( $fields as $key => $field ) {  
                                                                            \ReviewX\Controllers\Admin\Core\ReviewxMetaBox::render_option_field( $key, $field, '', $id, $is_pro );
                                                                        }
                                                                    ?>
                                                                </table>                                     
                                                            </div>                                                       
                                                        <?php
                                                    }
                                                }
                                                $i++;
                                            endforeach;
                                            ?>
                                            </div> 
                                            <?php
                                        else:
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
                                                        <div class="rx-meta-section-desc-box">
                                                            <p class="rx-meta-section-desc"><?php echo array_key_exists('desc', $section) ? $section['desc'] : ''; ?></p>
                                                            <p class="rx-meta-section-desc"><?php echo array_key_exists('desc', $section) ? $section['desc1'] : ''; ?></p>
                                                        </div>                   
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
                                    <button class="rx-quick-previous-btn" type="button" data-tab="<?php echo isset( $tabids[ $tabid - 3 ] ) ? $tabids[ $tabid - 3  ] : ''; ?>" data-tabid="<?php echo ($tabid - 2); ?>"><?php esc_html_e( 'Previous', 'reviewx' );?></button>


                                    <?php if($id == 'email_tab'): ?>
                                            <a  title="<?php echo esc_html__('Save & Send Email', 'reviewx'); ?>" type="button" class="thickbox rx_thickbok" href="#TB_inline&width=600&height=550&inlineId=my-content-id" ><?php esc_html_e( $id == 'email_tab' ? 'Save & Send email' : 'Save & Next', 'reviewx' );?></a>
                                    <?php else: ?>
                                            <button class="rx_save_setting_tab quick-builder-submit-btn rx-quick-builder-btn" type="button" data-tab="<?php echo isset( $tabids[ $tabid - 1 ] ) ? $tabids[ $tabid - 1 ] : ''; ?>" data-tabid="<?php echo $tabid; ?>" data-currenttab="<?php echo isset( $tabids[ $tabid - 2 ] ) ? $tabids[ $tabid - 2 ] : ''; ?>"><?php esc_html_e( $id == 'email_tab' ? 'Save & Send email' : 'Save & Next', 'reviewx' );?></button>
                                    <?php endif; ?>

                                    <?php if( $id == 'email_tab' ) {
                                        ?>
                                        <a class="rx_quick_setup_skip_email" href="#"><?php esc_html_e( 'Skip & Next', 'reviewx' );?></a>
                                        <?php
                                    } ?>
                                <?php } else {
                                    $redirect_url = add_query_arg( array('page'=> 'reviewx-all'), admin_url( 'admin.php' ) );
                                ?>
                                    <div class="quick-builder-finalize-button-area">
                                        <button class="rx-quick-previous-btn" type="button" data-tab="<?php echo isset( $tabids[ $tabid - 3 ] ) ? $tabids[ $tabid - 3  ] : ''; ?>" data-tabid="<?php echo ($tabid - 2); ?>"><?php esc_html_e( 'Previous', 'reviewx' );?></button>
                                        <button class="quick-builder-submit-btn quick-builder-finalize-btn" data-redirect-url="<?php echo esc_url($redirect_url); ?>" type="button"><?php esc_html_e( 'Launch', 'reviewx' );?></button>
                                    </div> 
                                <?php 
                                    } 
                                } ?>

                                <?php if($id == 'email_tab'):  ?>
                                    <div id="my-content-id" style="display:none;">

                                    <div class="rx_erf_item">
                                        <div class="rx_label"><?php esc_html_e( 'Select Order Status:', 'reviewx' );?> </div>
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
                                        <div class="rx_label"><?php esc_html_e( 'Orders Date Range:', 'reviewx' );?> </div>
                                        <div class="rx_content">
                                            <select class="select-css" id="date_range">
                                                <option value="all_the_time"><?php esc_html_e( 'All the Time', 'reviewx' );?></option>
                                                <option value="yesterday"><?php esc_html_e( 'Yesterday', 'reviewx' );?></option>
                                                <option value="last_week"><?php esc_html_e( 'Last Week', 'reviewx' );?></option>
                                                <option value="this_month"><?php esc_html_e( 'This Month', 'reviewx' );?></option>
                                                <option value="last_month"><?php esc_html_e( 'Last Month', 'reviewx' );?></option>
                                                <option value="this_year"><?php esc_html_e( 'This Year', 'reviewx' );?></option>
                                                <option value="last_year"><?php esc_html_e( 'Last year', 'reviewx' );?></option>
                                                <option <?php !\ReviewX_Helper::is_pro() ? _e('disabled') : null ?> value="custom_date"><?php esc_html_e( 'Custom Date', 'reviewx' );?></option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="rx_erf_item">
                                    <?php if( !\ReviewX_Helper::is_pro() ): ?>
                                        <div class="rx-pro-label-wrapper">
                                            <sup class="rx-pro-label"><?php echo __('Pro', 'reviewx');?></sup>
                                        </div>  
                                        <?php endif; ?>                                           
                                        <div class="rx_label"><?php esc_html_e( 'Custom Date Range:', 'reviewx' );?> </div>
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
                                        <div class="rx_label"><?php esc_html_e( 'Filter Products', 'reviewx' );?></div>
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
                                        <div class="rx_label"><?php esc_html_e( 'Filter By:', 'reviewx' );?> </div>
                                        <div class="rx_content">
                                            <select <?php !\ReviewX_Helper::is_pro() ? _e('disabled') : null ?> class="select-css" id="filter_by">
                                                <option value="-">-</option>
                                                <option value="by_category"><?php esc_html_e( 'By Category', 'reviewx' );?></option>
                                                <option value="by_products"><?php esc_html_e( 'By Product(s):', 'reviewx' );?></option>
                                                <option value="by_both"><?php esc_html_e( 'By Products + By Category', 'reviewx' );?></option>
                                                <option value="by_special_conditions"><?php esc_html_e( 'Special Conditions', 'reviewx' );?></option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="rx_erf_item">
                                    <?php if( !\ReviewX_Helper::is_pro() ): ?>
                                        <div class="rx-pro-label-wrapper">
                                            <sup class="rx-pro-label"><?php echo __('Pro', 'reviewx');?></sup>
                                        </div>  
                                        <?php endif; ?>                                           
                                        <div class="rx_label"><?php esc_html_e( 'Filter By Category:', 'reviewx' );?> </div>
                                        <div class="rx_content">
                                            <select <?php !\ReviewX_Helper::is_pro() ? _e('disabled') : null ?> name="" class="select-css" id="filter_by_category" class="te_input">
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
                                        <div class="rx_label"><?php esc_html_e( 'Filter By Products:', 'reviewx' );?> </div>
                                        <div class="rx_content">
                                            <select <?php !\ReviewX_Helper::is_pro() ? _e('disabled') : null ?> name="" class="select-css" id="filter_by_products" class="te_input">
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
                                        <div class="rx_label"><?php esc_html_e( 'Filter By Conditions:', 'reviewx' );?> </div>
                                        <div class="rx_content">
                                            <select <?php !\ReviewX_Helper::is_pro() ? _e('disabled') : null ?> class="select-css" id="filter_by_conditions">
                                                <option value="most_reviewed"><?php esc_html_e( 'Most Reviewed Product', 'reviewx' );?></option>
                                                <option value="less_reviewed"><?php esc_html_e( 'Lowest Reviewed Product', 'reviewx' );?></option>
                                                <option value="top_rated"><?php echo __( 'Top Rated Product', 'reviewx' );?></option>
                                                <option value="less_rated"><?php echo __( 'Lowest Rated Product', 'reviewx' );?></option>
                                            </select>
                                        </div>
                                    </div>

                                    <button class="rx_save_setting_tab quick-builder-submit-btn rx-quick-builder-btn" type="button" data-tab="<?php echo isset( $tabids[ $tabid - 1 ] ) ? $tabids[ $tabid - 1 ] : ''; ?>" data-tabid="<?php echo $tabid; ?>" data-currenttab="<?php echo isset( $tabids[ $tabid - 2 ] ) ? $tabids[ $tabid - 2 ] : ''; ?>"><?php esc_html_e( 'Save', 'reviewx' );?></button>
                                </div>
                                <?php endif; ?>

                                <?php if( class_exists('ReviewXPro') ) {
                                    if( $tabid <= $totaltabs ) {
                                        ?>
                                        <input type="hidden" name="rx-setting-nonce" class="rx-setting-nonce" value="<?php echo wp_create_nonce( "special-string" ); ?>">
                                        <button class="rx-quick-previous-btn" type="button" data-tab="<?php echo isset( $tabids[ $tabid - 3 ] ) ? $tabids[ $tabid - 3  ] : ''; ?>" data-tabid="<?php echo ($tabid - 2); ?>"><?php esc_html_e( 'Previous', 'reviewx' );?></button>

                                        <?php if($id == 'email_tab'): ?>
                                            <a title="<?php echo esc_html__('Save & Send Email', 'reviewx'); ?>" class="thickbox rx_thickbok" href="#TB_inline&width=600&height=550&inlineId=my-content-id" ><?php esc_html_e( $id == 'email_tab' ? 'Save & Send email' : 'Save & Next', 'reviewx' );?></a>
                                        <?php else: ?>
                                        <button class="rx_save_setting_tab quick-builder-submit-btn rx-quick-builder-btn" type="button" data-tab="<?php echo isset( $tabids[ $tabid - 1 ] ) ? $tabids[ $tabid - 1 ] : ''; ?>" data-tabid="<?php echo $tabid; ?>" data-currenttab="<?php echo isset( $tabids[ $tabid - 2 ] ) ? $tabids[ $tabid - 2 ] : ''; ?>"><?php esc_html_e( $id == 'email_tab' ? 'Save & Send email' : 'Save & Next', 'reviewx' );?></button>
                                        <?php endif; ?>

                                        <?php if( $id == 'email_tab' ) {
                                    ?>
                                        <a class="rx_quick_setup_skip_email" data-tabid="4" data-tab="email_tab"><?php esc_html_e( 'Skip & Next', 'reviewx' );?></a>
                                    <?php
                                        } ?>
                                    <?php } else {
                                        $redirect_url = add_query_arg( array('page'=> 'reviewx-all'), admin_url( 'admin.php' ) );
                                    ?>
                                    <div class="quick-builder-finalize-button-area">
                                        <button class="rx-quick-previous-btn" type="button" data-tab="<?php echo isset( $tabids[ $tabid - 3 ] ) ? $tabids[ $tabid - 3  ] : ''; ?>" data-tabid="<?php echo ($tabid - 2); ?>"><?php esc_html_e( 'Previous', 'reviewx' );?></button>
                                        <button class="quick-builder-submit-btn quick-builder-finalize-btn" data-redirect-url="<?php echo esc_url($redirect_url); ?>" type="button"><?php esc_html_e( 'Launch', 'reviewx' );?></button>
                                    </div>                                    
                                    <?php }                                    
                                } ?>    
                            </div>
                            <?php do_action( 'rx_builder_after_tab', $id, $tab ); ?>
                            </div>
                            <?php
                        }
                    ?>
                </form>
            </div>
        </div>
    </div>    
</div>