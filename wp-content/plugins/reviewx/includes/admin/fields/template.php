<?php
    $class .= ' rx-template-field';
    if( isset( $field['variables'] ) ) :
        $variables = $field['variables'];
    endif;
?>
<div id="<?php echo esc_attr( $name ); ?>">
    <?php for( $i = 0; $i < 3; $i++ ) : ?>
        <div>
            <input type="text" class="<?php echo esc_attr( $class ); ?>" name="<?php echo esc_attr( $name ); ?>[]" value="<?php echo ! empty( $value[ $i ] ) ? $value[ $i ] : ''; ?>">
        </div>
    <?php endfor; ?>
    <div class="<?php echo esc_attr( $name ); ?>-variables">
        <span class="<?php echo esc_attr( $name ); ?>-variable-title"><?php _e( 'Variables: ', 'reviewx' ); ?></span>
        <?php foreach ( $variables as $variable ) { ?>
            <span class="rx-variable-tag"><?php echo $variable; ?></span>
        <?php } ?>
    </div>
</div>