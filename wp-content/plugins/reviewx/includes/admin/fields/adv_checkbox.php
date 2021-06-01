<?php

    if ( absint( $value ) == 1 ) {
        $attrs .= ' checked="checked"';
    }

    if( isset( $field['disable'] ) && $field['disable'] === true ) {
        $attrs .= ' disabled';
    }

?>

<div class="rx-adv-checkbox-wrap">
    <input class="<?php echo esc_attr( $class ); ?>" type="checkbox" id="<?php echo esc_attr( $name ); ?>" name="<?php echo esc_attr( $name ); ?>" value="1" <?php echo esc_attr( $attrs ); ?>/>
    <label for="<?php echo $name; ?>" class="rx-adv-checkbox-label">
        <?php _e( 'Advance Design', 'reviewx' ); ?>
    </label>
</div>