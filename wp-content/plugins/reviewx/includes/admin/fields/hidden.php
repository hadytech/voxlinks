<?php 
    $class .= ' rx-' . $key;
    
    // if( isset( $field['disable'] ) && $field['disable'] === true ) {
    //     $attrs .= ' disabled';
    // }
?>
<input class="<?php echo esc_attr( $class ); ?>" id="<?php echo esc_attr( $name ); ?>" type="text" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $value ); ?>" <?php echo esc_attr( $attrs ); ?>>