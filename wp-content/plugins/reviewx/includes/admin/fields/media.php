<?php 
    // $image_url = $image_id = '';
    // if( isset( $value['url'] ) ) {
    //     $image_url = $value['url'];
    // }
    // if( isset( $value['id'] ) ) {
    //     $image_id = $value['id'];
    // }
    $image_url = $value;
?>

<div class="rx-media-field-wrapper">

    <?php if( $is_pro ) { ?>
        <?php if( ReviewX_Helper::is_pro() ) { ?>
            <div class="rx-thumb-container rx-shop-icon-display-area <?php echo $image_url == '' ? '' : 'rx-has-thumb'; ?>">
                <?php 
                    if( $image_url ) {
                        echo '<img src="'. esc_url( $image_url ) .'">';
                    }
                ?>
                <a href="javascript:void(0);" class="rx-media-remove-button <?php echo esc_attr( $image_url ) == '' ? 'hidden' : ''; ?>" title="Remove Image">
                    <svg style="width: 15px" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times-circle" class="svg-inline--fa fa-times-circle fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z"></path></svg>
                </a>
            </div>            
        <?php } ?>     
    <?php } else { ?>
        <div class="rx-thumb-container rx-shop-icon-display-area <?php echo $image_url == '' ? '' : 'rx-has-thumb'; ?>">
            <?php 
                if( $image_url ) {
                    echo '<img src="'. esc_url( $image_url ) .'">';
                }
            ?>
            <a href="javascript:void(0);" class="rx-media-remove-button <?php echo esc_attr( $image_url ) == '' ? 'hidden' : ''; ?>" title="Remove Image">
                <svg style="width: 15px" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times-circle" class="svg-inline--fa fa-times-circle fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z"></path></svg>
            </a>
        </div>        
    <?php } ?>
    <div class="rx-media-content">
        <input class="rx-media-url" type="hidden" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_url( $image_url ); ?>">        
    </div>

    <div class="rx-shop-icon-upload-area rx-media-upload-button <?php if( $is_pro){ if(ReviewX_Helper::is_pro() ){ echo esc_attr( $image_url ) == '' ? '' : 'hidden'; }  } else { echo esc_attr( $image_url ) == '' ? '' : 'hidden'; } ?>">
        <div class="rx-media-button">
            <label class="rx_upload_file rx-form-btn">
            <img src="<?php echo esc_url( assets('admin/images/image.svg') ); ?>" class="img-fluid">
            <span><?php echo __('Upload icon', 'reviewx'); ?></span>
            
            <?php if( $is_pro && !ReviewX_Helper::is_pro() ):  // check is pro ?>        
                <div class="rx-pro-label-wrapper">
                    <sup class="rx-pro-label"><?php echo __('Pro', 'reviewx'); ?></sup>
                </div> 
            <?php endif; ?>                               
        </div>
    </div>
    
</div>