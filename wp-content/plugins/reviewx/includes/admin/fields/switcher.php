<?php

  if ( absint( $value ) == 1 ) {
    $attrs .= ' checked="checked"';
  }

  if( $is_pro && !ReviewX_Helper::is_pro() ) {
    $attrs = '';
    if($default){
      $attrs .= ' checked="checked"';
    }
  }
  
?>
<label class="switch">
<input <?php if( $is_pro && !ReviewX_Helper::is_pro() ){?>disabled<?php } ?> class="<?php echo esc_attr( $class ); ?>" type="checkbox" id="<?php echo esc_attr( $name ); ?>" name="<?php echo esc_attr( $name ); ?>" value="1" <?php echo esc_attr( $attrs ); ?>/>
  <span class="slider round"></span>
</label>
