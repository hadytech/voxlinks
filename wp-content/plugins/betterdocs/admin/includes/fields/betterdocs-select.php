<?php 
    $class .= ' betterdocs-select';

    $multiple = isset( $field['multiple'] ) ? 'multiple' : '';

    if( $multiple ) {
        $name .= "[]";
    }

    if( isset( $field['disable'] ) && $field['disable'] == true ) {
        $attrs .= ' disabled';
    }
?>
<select data-value="<?php echo is_array( $value ) ? implode( ',', $value ) : $value; ?>" class="<?php echo esc_attr( $class ); ?>" <?php echo $multiple; ?> name="<?php echo $name; ?>" id="<?php echo $field_id; ?>" <?php echo $attrs; ?>>
    <?php 
        if( ! empty( $field['options'] ) ) :
            foreach( $field['options'] as $opt_id => $option ) {
                if( is_array( $value ) ) {
                    $selected = in_array( $opt_id, $value ) ? 'selected="true"' : '';
                } else {
                    $selected = ( $value == $opt_id ) ? 'selected="true"' : '';
                }
                echo '<option value="'. $opt_id .'" '. $selected .'>'. $option .'</option>';
            }
        endif;
    ?>
</select>