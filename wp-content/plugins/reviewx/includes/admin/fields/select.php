<?php 
    $class .= ' rx-select';
?>
<select class="<?php echo esc_attr( $class ); ?>" name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $name ); ?>" <?php echo esc_attr( $attrs ); ?>>
    <?php 
        foreach( $field['options'] as $opt_id => $option ) {
            $selected = ( $value == $opt_id ) ? 'selected="true"' : '';
            echo '<option value="'. $opt_id .'" '. $selected .'>'. $option .'</option>';

        }
    ?>
</select>