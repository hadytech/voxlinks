<?php 
$opt_alert_class = '';
if( isset( $field['disable'] ) && $field['disable'] === true ) {
    $opt_alert_class = 'easyjobs-opt-alert';
}
?>
<tr data-id="<?php echo $key; ?>" id="<?php echo esc_attr( $id ); ?>" class="easyjobs-field <?php echo $row_class.' type-'.$field['type']; ?>">
    <?php if( $field['type'] == 'title' && !empty( $field['label'] )) : ?>
        <th colspan="2" class="easyjobs-control easyjobs-title"><h3><?php esc_html_e( $field['label'], 'easyjobs' ); ?></h3></th>
    <?php else: ?>
        <?php if( empty( $field['label'] ) ) : ?>
            <td class="easyjobs-control" colspan="2">
        <?php else : ?>
        <th class="easyjobs-label">
            <label for="<?php echo esc_attr( $name ); ?>"><?php esc_html_e( $field['label'], 'easyjobs' ); ?></label>
        </th>
        <td class="easyjobs-control">
        <?php 
            endif; 
            do_action( 'easyjobs_field_before_wrapper', $name, $value, $field, $post_id );
        ?>
            <div class="easyjobs-control-wrapper <?php echo $opt_alert_class; ?>">
            <?php
                if($file_name ) {
                    $file_url = EASYJOBS_ADMIN_DIR_PATH . 'includes/fields/easyjobs-'. $file_name .'.php';
                    if(file_exists($file_url))
                        include EASYJOBS_ADMIN_DIR_PATH . 'includes/fields/easyjobs-'. $file_name .'.php';
                }
                if( isset($field['view']) ) {
                    call_user_func( $field['view'] );
                }
                if( isset( $field['description'] ) && ! empty( $field['description'] ) ) : 
                    ?>
                        <p class="easyjobs-field-description"><?php _e( $field['description'], 'easyjobs' ); ?></p>
                    <?php
                endif;
                if( isset( $field['help'] ) && ! empty( $field['help'] ) ) : 
                    ?>
                        <p class="easyjobs-field-help"><?php _e( $field['help'], 'easyjobs' ); ?></p>
                    <?php
                endif;
            ?>
            </div>
            <?php do_action( 'easyjobs_field_after_wrapper', $name, $value, $field, $post_id ); ?>
        </td>
    <?php endif; ?>
</tr>
