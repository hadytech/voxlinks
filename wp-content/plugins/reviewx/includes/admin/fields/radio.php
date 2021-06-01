<?php

    if ( absint( $value ) == 1 ) {
        $attrs .= ' checked="checked"';
    }

    if( isset( $field['disable'] ) && $field['disable'] === true ) {
        $attrs .= ' disabled';
    }

?>
<div class="rx-graph-style">
    <div>
        <input type="radio" id="<?php echo esc_attr( $name ); ?>" class="rx-choose-graph-style" name="<?php echo esc_attr( $name ); ?>" <?php if($value=="s1" || $value ==""){?> checked="checked"<?php } ?> value="s1"> <?php esc_html_e( 'Style 1', 'reviewx' ); ?> &nbsp;
        <input type="radio" id="<?php echo esc_attr( $name ); ?>" class="rx-choose-graph-style" name="<?php echo esc_attr( $name ); ?>" <?php if($value =="s2" ){?> checked="checked"<?php } ?> value="s2"> <?php esc_html_e( 'Style 2', 'reviewx' ); ?>
        <input type="radio" id="<?php echo esc_attr( $name ); ?>" class="rx-choose-graph-style" name="<?php echo esc_attr( $name ); ?>" <?php if($value =="s3" ){?> checked="checked"<?php } ?> value="s3"> <?php esc_html_e( 'Style 3', 'reviewx' ); ?>
    </div>
    <div>
	    <div class="rx-div-hide graph-1 <?php if( $value == "s1" ): ?> rx-div-show <?php endif; ?>">
		    <img src="<?php echo esc_url(assets('admin/images/themes/bar.png')); ?>" class="" alt="" />
	    </div>
        <div class="rx-div-hide graph-2 <?php if( $value == "s2" ): ?> rx-div-show <?php endif; ?>">
            <img src="<?php echo esc_url(assets('admin/images/themes/poll.png')); ?>" class="" alt="" />
        </div>
        <div class="rx-div-hide graph-3 <?php if( $value == "s3" ): ?> rx-div-show <?php endif; ?>">
            <img src="<?php echo esc_url(assets('admin/images/themes/pie.png')); ?>" class="" alt="" />
        </div>    
    </div>
</div>

