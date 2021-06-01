<?php
    $readonly = isset( $field['readonly'] ) && $field['readonly'] == true ? 'readonly' : '';
    $placeholder = isset($field['placeholder']) ? $field['placeholder'] : '';
?>

<input <?php echo $readonly; ?> class="<?php echo esc_attr( $class ); ?>" id="<?php echo $field_id; ?>" type="text" name="<?php echo $name; ?>" placeholder="<?php echo $placeholder; ?>" value="<?php echo $value; ?>" <?php echo $attrs; ?>>