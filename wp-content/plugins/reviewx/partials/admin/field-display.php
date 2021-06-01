<?php 
    $opt_alert_class = '';
    if( isset( $field['disable'] ) && $field['disable'] === true ) {
        $opt_alert_class = 'rx-opt-alert';
    }
    $is_pro = false;
    $is_pro = isset( $field['is_pro'] ) ? $field['is_pro'] : false;
?>
<tr style="border-bottom: 1px solid #F2F2F2" id="<?php echo esc_attr( $id ); ?>" class="rx-field <?php echo esc_attr( $row_class ); ?> <?php echo $is_pro == true ? 'is-pro' : ''; ?>">

    <?php if( $idd == 'content_tab' ){ ?>
    <?php if(  
            $name == 'rx_option_recaptcha_site_key' || $name == 'rx_option_recaptcha_secret_key' || $name == 'rx_option_video_source' ||
            $name == 'rx_meta_recaptcha_site_key' || $name == 'rx_meta_recaptcha_secret_key' || $name == 'rx_meta_video_source' 
              ){ ?>
        <th class="rx-label" style="width:15%;"></th>
        <td class="rx-control" style="width:50%; padding: 12px 0">
            <?php 
                do_action( 'rx_field_before_wrapper', $name, $value, $field );
            ?>
            <div class="rx-control-wrapper <?php echo esc_attr( $opt_alert_class ); ?>" style="text-align: left">
                <?php 
                    if( $file_name ) {
                        include REVIEWX_INCLUDE_PATH . 'admin/fields/'. $file_name .'.php';
                    } else {
                        if( $field['view'] ) {
                            call_user_func( $field['view'] );
                        }
                    }
                    if( isset( $field['description'] ) && ! empty( $field['description'] ) ) : 
                        ?>
                            <span class="rx-field-description"><?php echo esc_html( $field['description'] ); ?></span>
                        <?php
                    endif;
                    if( isset( $field['help'] ) && ! empty( $field['help'] ) ) : 
                        ?>
                            <p class="rx-field-help"><?php echo esc_html( $field['help'] ); ?></p>
                        <?php
                    endif;
                ?>
            </div>
            <label style="float: left" for="<?php echo esc_attr( $name ); ?>">
                <?php echo esc_html( $field['heading'] ); ?>
            </label>
            <?php do_action( 'rx_field_after_wrapper', $name, $value, $field ); ?>
        </td>
    <?php } else {?>
        <td class="rx-control">
            <?php 
                do_action( 'rx_field_before_wrapper', $name, $value, $field );
            ?>
            <div class="rx-control-wrapper <?php echo esc_attr( $opt_alert_class ); ?>">
                <?php 
                    if( $file_name ) {
                        include REVIEWX_INCLUDE_PATH . 'admin/fields/'. $file_name .'.php';
                    } else {
                        if( $field['view'] ) {
                            call_user_func( $field['view'] );
                        }
                    }
                    if( isset( $field['description'] ) && ! empty( $field['description'] ) ) : 
                        ?>
                            <span class="rx-field-description"><?php echo esc_html( $field['description'] ); ?></span>
                        <?php
                    endif;
                    if( isset( $field['help'] ) && ! empty( $field['help'] ) ) : 
                        ?>
                            <p class="rx-field-help"><?php echo esc_html( $field['help'] ); ?></p>
                        <?php
                    endif;
                ?>
            </div>
            <?php do_action( 'rx_field_after_wrapper', $name, $value, $field ); ?>
        </td>
        <th class="rx-label">
            <?php if( $is_pro && !ReviewX_Helper::is_pro() ):  // check is pro ?>
                <div class="rx-pro-checkbox">
            <?php endif; ?> 
            <?php             
            if( isset( $field['heading'] ) && ! empty( $field['heading'] ) ) :
                ?>
                    <h3 class="rx-field-heading"><?php echo esc_html( $field['heading'] ); ?></h3>
                <?php
            endif;
            ?>  
            <?php if( $is_pro && !ReviewX_Helper::is_pro() ):  // check is pro ?>        
                <sup class="rx-pro-label"><?php _e( 'Pro', 'reviewx' ); ?></sup>
            <?php endif; ?>                                                                           
            <?php if( $is_pro && !ReviewX_Helper::is_pro() ): // check is pro ?>
                </div>
            <?php endif; ?>          
            <label for="<?php echo esc_attr( $name ); ?>">
                <?php echo esc_html( $field['label']); ?>
            </label>
        </th>
    <?php } ?>
    <?php } else { ?>   
        <?php if( empty( $field['label'] ) ) : ?>
            <td class="rx-control" colspan="2">
        <?php else : ?>
        <td class="rx-control">
        <?php endif; ?>              
            <?php  do_action( 'rx_field_before_wrapper', $name, $value, $field ); ?>
            <div class="rx-control-wrapper <?php echo esc_attr( $opt_alert_class ); ?>">
                <?php 
                    if( $file_name ) {
                        include REVIEWX_INCLUDE_PATH . 'admin/fields/'. $file_name .'.php';
                    } else {
                        if( $field['view'] ) {
                            call_user_func( $field['view'] );
                        }
                    }
                    if( isset( $field['description'] ) && ! empty( $field['description'] ) ) : 
                        ?>
                            <span class="rx-field-description"><?php echo esc_html( $field['description'] ); ?></span>
                        <?php
                    endif;

                    if( isset( $field['help'] ) && ! empty( $field['help'] ) ) : 
                        ?>
                            <p class="rx-field-help"><?php echo esc_html( $field['help'] ); ?></p>
                        <?php
                    endif;
                ?>
            </div>
            <?php do_action( 'rx_field_after_wrapper', $name, $value, $field ); ?>
        </td>
        
        <?php if( ( isset( $field['heading'] ) && ! empty( $field['heading'] ) ) || ( isset( $field['label'] ) && ! empty( $field['label'] ) ) )  : ?> 
        <th class="rx-label">
            <?php if( isset( $field['heading'] ) && ! empty( $field['heading'] ) ) : ?>
                <h3 class="rx-field-heading"><?php echo esc_html( $field['heading'] ); ?></h3>
            <?php endif?>          
            <label for="<?php echo esc_attr( $name ); ?>">
                <?php echo esc_html( $field['label']); ?>
            </label>
        </th> 
        <?php endif?> 
                    
    <?php } ?>    

</tr>
