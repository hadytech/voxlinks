<?php
    global $pagenow;
    $post_status           = self::count_posts();
    $publish_reviewx       = isset( $post_status->publish ) ? $post_status->publish : 0;
    $trash_reviewx         = $post_status->trash;
    $current_url           = admin_url('admin.php?page=rx-admin');
    $publish_url           = add_query_arg('status', 'enabled', $current_url);
    $disabled_url          = add_query_arg('status', 'disabled', $current_url);
    $trash_url             = add_query_arg('status', 'trash', $current_url);
    $empty_trash_url       = add_query_arg('delete_all', true, $current_url);
    $get_enabled_post      = $post_status->enabled;
    $get_disabled_post     = $post_status->disabled;
    $total_reviewx         = $get_enabled_post + $get_disabled_post;
    ?>
    <div class="rx-admin-wrapper">

        <div class="rx-admin-notice">
        </div>
    
        <div class="rx-admin-menu">
            <ul>
                <li <?php echo $all_active_class; ?>><a href="<?php echo esc_url( $current_url ); ?>">All (<?php echo $total_reviewx; ?>)</a></li>
                <?php if( $get_enabled_post > 0 ) : ?>
                <li <?php echo $enabled_active_class; ?>><a href="<?php echo esc_url( $publish_url ); ?>"><?php _e( 'Enabled', 'reviewx' ); ?> (<?php echo $get_enabled_post; ?>)</a></li>
                <?php endif; ?>
                <?php if( $get_disabled_post > 0 ) : ?>
                <li <?php echo $disabled_active_class; ?>><a href="<?php echo esc_url( $disabled_url ); ?>"><?php _e( 'Disabled', 'reviewx' ); ?> (<?php echo $get_disabled_post; ?>)</a></li>
                <?php endif; ?>
                <?php if( $trash_reviewx > 0 ) : ?>
                    <li <?php echo $trash_active_class; ?>><a href="<?php echo esc_url( $trash_url ); ?>"><?php _e( 'Trash', 'reviewx' ); ?> (<?php echo $trash_reviewx; ?>)</a></li>
                    <?php if( isset( $_GET['status'] ) && $_GET['status'] === 'trash' ) : ?>
                        <li class="rx-empty-trash-btn"><a href="<?php echo esc_url( $empty_trash_url ); ?>"><?php _e( 'Empty Trash', 'reviewx' ); ?></a></li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
        </div>
    
        <div class="rx-admin-items">
            <table class="wp-list-table widefat fixed striped reviewx-list">
                <thead>
                    <tr>
                        <?php 
                            if( ! empty( $table_header ) ) {
                                foreach( $table_header as $title ) {
                                    echo '<td>' . $title . '</td>';
                                }
                            }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="rx-admin-title">
                                <strong>
                                    <?php
                                        $wc_is_enabled = \ReviewX_Helper::check_wc_is_enabled();
                                        if( $wc_is_enabled && class_exists('WooCommerce') ) {                                            
                                            $settings_url = add_query_arg( array('page'=> 'rx-wc-settings'), admin_url( 'admin.php' ) );     
                                        } else {
                                            $settings_url = '';
                                            $wc_is_enabled = '';
                                            //update_option( '_rx_wc_active_check', 0 ); 
                                        }                                                                                 
                                    ?>
                                    <a href="<?php echo esc_url($settings_url); ?>">
                                        <?php esc_html_e( 'WooCommerce','reviewx' ); ?>
                                    </a>
                                </strong>
                                <?php if( $wc_is_enabled ) { ?>
                                <div class="rx-admin-title-actions">
                                    <a class="rx-admin-title-edit" href="<?php echo esc_url($settings_url); ?>"><?php esc_html_e( 'Edit','reviewx' ); ?></a>
                                </div>                                
                                <?php } ?>
                            </div>
                        </td>
                        <td>
                            <div class="rx-admin-status">
                                <span class="rx-admin-status-title nxast-enable <?php echo $wc_is_enabled ? 'active' : ''; ?>"><?php echo _e( 'Enabled','reviewx' ); ?></span>  
                                <span class="rx-admin-status-title nxast-disable <?php echo $wc_is_enabled ? '' : 'active'; ?>"><?php echo _e( 'Disabled', 'reviewx' ); ?></span>
                                <input type="checkbox" id="rx-toggle-wc" name="_rx_wc_active_check" <?php echo $wc_is_enabled ? 'checked="checked"' : ''; ?>>
                                <label data-swal="true" data-post="wc" data-nonce="<?php echo wp_create_nonce('reviewx_status_nonce'); ?>" for="rx-toggle-disable"></label>                                              
                            </div>
                        </td>
                        <td></td>
                    </tr>                    
                    <?php 
                        $trash_btn_title = __( 'Trash', 'reviewx' );
                        $trash_page = false;
                        $trashed = false;
                        if( $reviewx->have_posts() ) :
                            $post_type_object = get_post_type_object( 'reviewx' );
                            global $nx_extension_factory;
                            while( $reviewx->have_posts() ) : $reviewx->the_post(); 
                                $idd = get_the_ID();
                                $duplicate_url = add_query_arg(array(
                                    'action' => 'rxduplicate',
                                    'post' => $idd,
                                    'rx_duplicate_nonce' => wp_create_nonce( 'rx_duplicate_nonce' ),
                                ), $current_url);
                                $is_enabled = get_post_meta( $idd, '_rx_meta_active_check', true );
                                $settings = array();
                                $theme_name = '';
                                $type = '';
                                $nx_type = '';
                                $extension_class ='';
                                $extension = null;
                                if( ! empty( $extension_class ) ) {
                                    $extension = $extension_class::get_instance();
                                }
                                /**
                                 * @since 1.4.0
                                 * re-generating system
                                 */
                                $regenerate_url = add_query_arg(array(
                                    'action' => 'rx_regenerate',
                                    'rx_type' => $nx_type,
                                    'post' => $idd,
                                    // 'from' => $settings->display_from,
                                    // 'last' => $settings->display_last,
                                    'rx_regenerate_nonce' => wp_create_nonce( 'rx_regenerate_nonce' ),
                                ), $current_url );
    
                                $is_enabled_before = false;
                                $status = get_post_status( $idd );
                                if( $pagenow === 'admin.php' && isset( $_GET['page'] ) && $_GET['page'] === 'rx-admin' ) {
                                    if( isset( $_GET['status'] ) && $_GET['status'] === 'trash' ) {
                                        $trash_page = true;
                                        $trashed = true;
                                        if( $status !== 'trash' ) {
                                            continue;
                                        }
                                        $trash_btn_title = __( 'Delete Permanently', 'reviewx' );
                                    } elseif( isset( $_GET['status'] ) && $_GET['status'] === 'enabled' ){
                                        if( $status !== 'publish' || $is_enabled != 1 ) {
                                            continue;
                                        }
                                    } elseif( isset( $_GET['status'] ) && $_GET['status'] === 'disabled' ){
                                        if( $status !== 'publish' || $is_enabled != 0 ) {
                                            continue;
                                        }
                                    } else {
                                        if( $status === 'trash' ) {
                                            continue;
                                        }
                                    }
                                }
                                ?>
                                    <tr>
                                        <td>
                                            <div class="rx-admin-title">
                                                <strong>
                                                    <?php 
                                                        if( ! $trashed ) echo '<a href="post.php?action=edit&post='. $idd .'">';
                                                        echo get_the_title(); 
                                                        if( ! $trashed ) echo '</a>';
                                                    ?>
                                                </strong>
                                                <div class="rx-admin-title-actions">
                                                    <?php if( ! $trash_page ) : ?>
                                                        <a class="rx-admin-title-edit" href="post.php?action=edit&post=<?php echo $idd; ?>"><?php _e( 'Edit', 'reviewx' ); ?></a>
                                                        <!-- <a class="rx-admin-title-duplicate" href="<?php echo esc_url( $duplicate_url ); ?>"><?php _e( 'Duplicate', 'reviewx' ); ?></a> -->
                                                    <?php do_action('rx_admin_title_actions', $idd); else :  ?>
                                                        <a class="rx-admin-title-restore" href="<?php echo wp_nonce_url( admin_url( sprintf( $post_type_object->_edit_link . '&amp;action=untrash', $idd ) ), 'untrash-post_' . $idd ); ?>"><?php _e( 'Restore', 'reviewx' ); ?></a>
                                                    <?php endif; ?>
                                                    <a class="rx-admin-title-trash" href="<?php echo get_delete_post_link( $idd, '', $trashed ); ?>"><?php echo $trash_btn_title; ?></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="rx-admin-status">
                                                <span class="rx-admin-status-title nxast-enable <?php echo $is_enabled ? 'active' : ''; ?>"><?php echo _e( 'Enabled', 'reviewx' ); ?></span>
                                                <span class="rx-admin-status-title nxast-disable <?php echo $is_enabled ? '' : 'active'; ?>"><?php echo _e( 'Disabled', 'reviewx' ); ?></span>
                                                <input type="checkbox" id="rx-toggle-<?php echo $idd; ?>" name="_rx_meta_active_check" <?php echo $is_enabled ? 'checked="checked"' : ''; ?>>
                                                <?php 
                                                if( $is_enabled_before ) : ?>
                                                    <label data-swal="true" data-post="<?php echo $idd; ?>" data-nonce="<?php echo wp_create_nonce('reviewx_status_nonce'); ?>" for="rx-toggle-disable-<?php echo $idd; ?>"></label>
                                                <?php else :  ?>
                                                    <label data-swal="false" data-post="<?php echo $idd; ?>" data-nonce="<?php echo wp_create_nonce('reviewx_status_nonce'); ?>" for="rx-toggle-<?php echo $idd; ?>"></label>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="rx-admin-date">
                                                <?php 
                                                    if( get_post_status( get_the_ID() ) === 'publish' ) {
                                                        echo '<span class="rx-admin-publish-status">' . _e('Published', 'reviewx') . '</span><br><span class="rx-admin-publish-date">' . get_the_time( __( 'Y/m/d', 'reviewx' ) ). '</span>';
                                                    }
                                                    if( get_post_status( get_the_ID() ) === 'trash' ) {
                                                        echo '<span class="rx-admin-publish-status">' . _e('Last Modified', 'reviewx') . '</span><br><span class="rx-admin-publish-date">' . get_the_time( __( 'Y/m/d', 'reviewx' ) ). '</span>';
                                                    }
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                
                                <?php
                            endwhile;
                        endif;
    
                        // if( ! $total_reviewx && ! $trashed ) {
                        //     echo '<tr><td colspan="5"><div class="rx-admin-not-found"><p>'. __('No ReviewX is found.', 'reviewx') .'</p></div></td></tr>';
                        // }
                    ?>
                </tbody>
            </table>
        </div>
        <?php 
        /**
         * Pagination
         * @since 1.2.6
         */
        if( $total_page > 1 ) : ?>
            <div class="rx-admin-items-pagination">
                <ul>
                    <?php 
                        if( $total_page > 1 ) {
                            if( $paged > 1 ) {
                                echo '<li class="rx-prev-page"><a href="'. $pagination_current_url .'&paged='. ($paged - 1) .'"><span class="dashicons dashicons-arrow-left-alt2"></span></a></li>';
                            }
                            for( $i = 1; $i <= $total_page; $i++ ) {
                                $active_page = $paged == $i ? 'class="rx-current-page"' : '';
                                echo '<li '. $active_page .'><a href="'. $pagination_current_url .'&paged='. $i .'">'. $i .'</a></li>';
                            }
                            if( $total_page > $paged ) {
                                echo '<li class="rx-next-page"><a href="'. $pagination_current_url .'&paged='. ($paged + 1) .'"><span class="dashicons dashicons-arrow-right-alt2"></span></a></li>';
                            }
                        }
                    ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>    