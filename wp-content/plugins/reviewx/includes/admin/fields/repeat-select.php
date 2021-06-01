<?php
    if ( absint( $value ) == 1 ) {
    $attrs .= ' checked="checked"';
    }

    if( isset( $field['disable'] ) && $field['disable'] === true ) {
    $attrs .= ' disabled';
    }
?>

<table class="form-table">
	<tbody id="append_body">
    <tr valign="top" >
        <input class="<?php echo esc_attr( $class ); ?>" type="checkbox" id="<?php echo esc_attr( $name ); ?>" name="<?php echo esc_attr( $name ); ?>" value="1" <?php echo esc_attr( $attrs ); ?>/>
    </tr>
    <tr valign="top" >
        <input class="<?php echo esc_attr( $class ); ?>" type="checkbox" id="<?php echo esc_attr( $name ); ?>" name="<?php echo esc_attr( $name ); ?>" value="1" <?php echo esc_attr( $attrs ); ?>/>
    </tr>
    <tr valign="top" >
        <input class="<?php echo esc_attr( $class ); ?>" type="checkbox" id="<?php echo esc_attr( $name ); ?>" name="<?php echo esc_attr( $name ); ?>" value="1" <?php echo esc_attr( $attrs ); ?>/>
    </tr>
    <tr valign="top" >
        <input class="<?php echo esc_attr( $class ); ?>" type="checkbox" id="<?php echo esc_attr( $name ); ?>" name="<?php echo esc_attr( $name ); ?>" value="1" <?php echo esc_attr( $attrs ); ?>/>
    </tr>
	</tbody>			
</table>

