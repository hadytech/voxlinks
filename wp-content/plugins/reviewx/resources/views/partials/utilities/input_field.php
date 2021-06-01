<?php if(isset($id)) : ?>
    <input type="checkbox" name="<?php isset($name) ? _e($name) : _e('delete_comments[]') ?>" value="<?php echo esc_attr( $id ); ?>"/>
<?php endif; ?>
