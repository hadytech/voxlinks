<?php 
    $opt_alert_class = '';
    if( isset( $field['disable'] ) && $field['disable'] === true ) {
        $opt_alert_class = 'crowdfundly-opt-alert';
    }
?>
<tr data-id="<?php echo $key; ?>" id="<?php echo esc_attr( $id ); ?>" class="crowdfundly-field <?php echo $row_class.' type-'.$field['type']; ?>">
    <?php if( $field['type'] == 'title' && !empty( $field['label'] )) : ?>
        <th colspan="2" class="crowdfundly-control crowdfundly-title"><h3><?php esc_html_e( $field['label'], 'crowdfundly' ); ?></h3></th>
    <?php else: ?>
        <?php if( empty( $field['label'] ) ) : ?>
            <td class="crowdfundly-control" colspan="2">
        <?php else : ?>
        <th class="crowdfundly-label <?php if( isset($field['depends']) && !class_exists($field['depends']['required']) ){ ?>crowdfundly-disabled<?php } ?>">
            <label for="<?php echo esc_attr( $name ); ?>"><?php esc_html_e( $field['label'], 'crowdfundly' ); ?></label>
        </th>
        <td class="crowdfundly-control">
        <?php 
            endif; 
            do_action( 'crowdfundly_field_before_wrapper', $name, $value, $field, $post_id );
        ?>
            <div class="crowdfundly-control-wrapper <?php echo $opt_alert_class; if( isset($field['depends']) && !class_exists($field['depends']['required']) ){ ?>crowdfundly-disabled<?php } ?>">
            <?php
                if($file_name ) {
                    $file_url = CROWDFUNDLY_ADMIN_DIR_PATH . 'includes/fields/crowdfundly-'. $file_name .'.php';
                    if(file_exists($file_url))
                        include CROWDFUNDLY_ADMIN_DIR_PATH . 'includes/fields/crowdfundly-'. $file_name .'.php';
                }
                if( isset($field['view']) ) {
                    call_user_func( $field['view'] );
                }
                if( isset( $field['description'] ) && ! empty( $field['description'] ) ) : 
                    ?>
                        <p class="crowdfundly-field-description"><?php _e( $field['description'], 'crowdfundly' ); ?></p>
                    <?php
                endif;
                if( isset( $field['help'] ) && ! empty( $field['help'] ) ) : 
                    ?>
                        <p class="crowdfundly-field-help"><?php _e( $field['help'], 'crowdfundly' ); ?></p>
                    <?php
                endif;
            ?>
            </div>
            
            <?php
            if( isset($field['depends']) && !class_exists($field['depends']['required']) ){
                ?>
                <p class="crowdfundly-required-notice"><?php echo esc_attr($field['depends']['description']); ?></p>
                <?php
            }
            ?>
            <?php do_action( 'crowdfundly_field_after_wrapper', $name, $value, $field, $post_id ); ?>
        </td>
    <?php endif; ?>
</tr>
