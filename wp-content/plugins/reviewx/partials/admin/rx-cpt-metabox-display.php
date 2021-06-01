<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://wpdeveloper.net
 * @since      1.0.0
 *
 * @package    ReviewX
 * @subpackage ReviewX/partials/admin
 */

$current_tab = get_post_meta( $post->ID, '_rx_builder_current_tab', true );
$current_tab = empty( $current_tab ) ? true : $current_tab;
if( ! $current_tab == array_search( $current_tab, array_keys( $tabs) ) ) {
    $current_tab = 'source_tab';
}
$totaltabs = count( $tabs );
$position = intval( array_search( $current_tab, array_keys( $tabs ) ) + 1 );
?>
<div class="rx-metabox-wrapper">
    <div class="rx-metatab-menu rx-quick-builder-tab-menu">
        <ul>
            <?php 
                $tid = 1;
                $tabids = array();
                foreach( $tabs as $id => $tab ) {
                    $tabids[] = $id;
                    $active = $current_tab === $id ? ' active' : '';
                    $class = isset( $tab['icon'] ) ? ' rx-has-icon' : '';
                    $class .= $active;
                    if( $position > $tid ){
                        $class .= ' rx-complete';
                    }
                    ?>
                        <li data-tabid="<?php echo $tid++; ?>" class="<?php echo $class; ?>" data-tab="<?php echo $id; ?>">
                            <?php if( isset( $tab['icon'] ) ) : ?>
                                <span class="rx-menu-icon">
                                    <?php echo $tab['icon']; ?>
                                </span>
                            <?php endif; ?>
                            <span class="rx-menu-title"><?php echo $tab['title']; ?></span>
                        </li>
                    <?php
                }
            ?>
        </ul>
    </div>

    <div class="rx-meta-main-container">
        <div class="rx-meta-contents rx-metatab-wrapper" data-totaltab="<?php echo esc_attr( $totaltabs ); ?>">
            <div class="rx-form-builder-section">
                <input type="hidden" name="rx_builder_current_tab" id="rx_builder_current_tab" value="<?php echo esc_attr($current_tab); ?>">
                <input type="hidden" name="rx_builder_current_page" id="rx_builder_current_page" value="post-type-reviewx">                
                <?php 
                    //wp_nonce_field( $builder_args['id'], $builder_args['id'] . '_nonce' );
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
                                                        <table>
                                                            <?php                                                                               
                                                                foreach( $fields as $key => $field ) {
                                                                    \ReviewX\Controllers\Admin\Core\ReviewxMetaBox::render_meta_field( $key, $field, '', $id, $is_pro );
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
                                                <table>
                                                    <?php                                                                                
                                                        foreach( $fields as $key => $field ) {
                                                            \ReviewX\Controllers\Admin\Core\ReviewxMetaBox::render_meta_field( $key, $field, '', $id, $is_pro );
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
                                if( $tabid <= $totaltabs ) {
                            ?>
                                <button class="rx-quick-previous-btn" type="button" data-tab="<?php echo isset( $tabids[ $tabid - 3 ] ) ? $tabids[ $tabid - 3  ] : ''; ?>" data-tabid="<?php echo ($tabid - 2); ?>"><?php esc_html_e( 'Previous', 'reviewx' );?></button>
                                <button class=" quick-builder-submit-btn" type="button" data-tab="<?php echo isset( $tabids[ $tabid - 1 ] ) ? $tabids[ $tabid - 1 ] : ''; ?>" data-tabid="<?php echo $tabid; ?>" data-currenttab="<?php echo isset( $tabids[ $tabid - 2 ] ) ? $tabids[ $tabid - 2 ] : ''; ?>"><?php esc_html_e( 'Next', 'reviewx' );?></button>
                            <?php } else { ?>
                                <div class="quick-builder-finalize-button-area">
                                    <button class="rx-quick-previous-btn" type="button" data-tab="<?php echo isset( $tabids[ $tabid - 3 ] ) ? $tabids[ $tabid - 3  ] : ''; ?>" data-tabid="<?php echo ($tabid - 2); ?>"><?php esc_html_e( 'Previous', 'reviewx' );?></button>
                                    <button class="quick-builder-submit-btn"><?php esc_html_e( 'Publish', 'reviewx' );?></button>
                                </div> 
                            <?php } ?>  
                        </div>
                        <input type="hidden" name="rx-setting-nonce" class="rx-setting-nonce" id="rx-setting-nonce" value="<?php echo wp_create_nonce("special-string"); ?>">
                        <?php do_action( 'rx_builder_after_tab', $id, $tab ); ?>
                        </div>
                        <?php
                    }
                ?>
            </div>
        </div>
    </div>
</div>