<?php

if( isset( $field['disable'] ) && $field['disable'] === true ) {
    $attrs .= ' disabled';
}

?>

<table class="form-table">
    <tbody id="append_body">
    <?php
    $i = 0;
    if( is_array($value) ) :
        
        foreach( $value as $key => $v ) :
            ?>
            <tr valign="top" >
                <td class="middle-align">
                    <input type="text" name="<?php echo esc_attr( $name ); ?>[]" maxlength="80" value="<?php echo esc_attr( $v ); ?>" class="timezone_string rx-meta-field playfield" placeholder="<?php esc_html_e( 'Criteria Name', 'reviewx' ); ?>">
                    <input type="hidden" name="<?php echo $name; ?>_name[]" value="<?php echo $key; ?>">
                    <a href="javascript:void(0);" class="up_button" title="<?php esc_html_e( 'Up field', 'reviewx' ); ?>">
                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve">
                            <style type="text/css">.st0{fill:#9BA1B0;}</style>
                            <path class="st0" d="M99.1,47.9L82.7,32.5c-0.8-0.8-2.1-1-3.1-0.5c-1.1,0.5-1.7,1.5-1.7,2.6v6.7H58.7V22.1h6.7 c1.2,0,2.2-0.7,2.6-1.7c0.5-1.1,0.2-2.3-0.5-3.1L52.1,0.9C51.6,0.3,50.8,0,50,0s-1.6,0.3-2.1,0.9L32.5,17.3c-0.8,0.8-1,2.1-0.5,3.1 c0.5,1.1,1.5,1.7,2.6,1.7h6.7v19.2H22.1v-6.7c0-1.2-0.7-2.2-1.7-2.6c-1.1-0.5-2.3-0.2-3.1,0.5L0.9,47.9C0.3,48.4,0,49.2,0,50 s0.3,1.6,0.9,2.1l16.3,15.4c0.8,0.8,2.1,1,3.1,0.5c1.1-0.5,1.7-1.5,1.7-2.6v-6.7h19.2v19.2h-6.7c-1.2,0-2.2,0.7-2.6,1.7 c-0.5,1.1-0.2,2.3,0.5,3.1l15.4,16.3c0.5,0.6,1.3,0.9,2.1,0.9s1.6-0.3,2.1-0.9l15.4-16.3c0.8-0.8,1-2.1,0.5-3.1 c-0.5-1.1-1.5-1.7-2.6-1.7h-6.7V58.7h19.2v6.7c0,1.2,0.7,2.2,1.7,2.6c1.1,0.5,2.3,0.2,3.1-0.5l16.3-15.4c0.6-0.5,0.9-1.3,0.9-2.1 S99.7,48.4,99.1,47.9z"/><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g>
                        </svg>                        
                    </a>
                    <a href="javascript:void(0);" class="remove_button" title="<?php esc_html_e( 'Remove', 'reviewx' ); ?>">
                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve">
                            <g><path class="st0" d="M19,35.3c1.4,20.8,2.7,37.6,4.1,58.4c0.2,3.6,3.2,6.2,6.9,6.2c13.2,0,26.5,0,39.7,0c3.9,0,6.7-2.7,7-6.7 C77.8,76,79,58.8,80.1,41.5c0.3-3.8,0.4-3.6,0.7-7.6c-20.7,0-41.2,0-61.7,0C19,34.4,19,34.9,19,35.3z M61.7,56 c0.2-2.4,0.4-4.7,0.6-7.1c0.2-2.4,1.5-3.7,3.4-3.5c1.9,0.2,3,1.6,2.8,4c-0.6,7.4-1.3,14.8-1.9,22.2c-0.4,4.1-0.7,8.3-1.1,12.4 c-0.2,2.2-1.5,3.5-3.3,3.4c-1.8-0.1-3-1.6-2.9-3.2C60.1,74.5,60.9,65.2,61.7,56z M46.7,49.3c0-2.6,1.2-4,3.2-3.9 c1.9,0.1,3,1.4,3,3.9c0,5.7,0,11.5,0,17.2c0,0,0,0,0,0c0,5.7,0,11.3,0,17c0,2.5-1.2,4.1-3.1,4.1c-1.9,0-3.1-1.5-3.1-4 C46.7,72,46.7,60.7,46.7,49.3z M32.8,45.7c2.1-1.1,4.3,0.3,4.6,2.9c0.6,6.7,1.2,13.5,1.8,20.2c0.4,5,0.9,9.9,1.3,15.6 c0,1.4-1.1,2.9-2.9,3.1c-1.8,0.2-3.2-1.2-3.4-3.3c-1-11.5-2-23.1-3.1-34.6C31,47.9,31.3,46.5,32.8,45.7z"/><path class="st0" d="M88.7,16.3c-0.3-2.7-2.6-4.8-5.4-5.2c-1.1-0.2-2.2-0.2-3.3-0.2c-4.2,0-8.4,0-12.9,0c0-1.4,0-2.6,0-3.8 C66.9,2.7,64.2,0,59.7,0c-6.6,0-13.2,0-19.8,0c-4.2,0-7,2.7-7.2,6.9c-0.1,1.2,0,2.5,0,3.9c-1.1,0-1.9,0.1-2.7,0.1c-4,0-8-0.1-12,0 c-3.3,0.1-6.1,1.7-6.7,4.5c-0.6,2.5-0.4,5.2-0.6,7.9c26.3,0,52.1,0,78.1,0C88.7,20.9,88.9,18.6,88.7,16.3z"/></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g>
                        </svg>                    
                    </a>
                    <div class="show_error_message"></div>
                </td>
            </tr>
            <?php $i++; endforeach; ?>
    <?php else:	?>
        <tr valign="top" >
            <td class="middle-align">
                <input type="text" name="<?php echo esc_attr( $name ); ?>[]" maxlength="80" class="timezone_string rx-meta-field playfield" placeholder="<?php esc_html_e( 'Criteria Name', 'reviewx' ); ?>" value="<?php esc_attr_e('Quality', 'reviewx'); ?>">
                <input type="hidden" name="<?php echo $name; ?>_name[]" value="ctr_h8S7">
                <a href="javascript:void(0);" class="up_button" title="<?php esc_html_e( 'Up field', 'reviewx' ); ?>">
                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve">
                            <style type="text/css">.st0{fill:#9BA1B0;}</style>
                            <path class="st0" d="M99.1,47.9L82.7,32.5c-0.8-0.8-2.1-1-3.1-0.5c-1.1,0.5-1.7,1.5-1.7,2.6v6.7H58.7V22.1h6.7 c1.2,0,2.2-0.7,2.6-1.7c0.5-1.1,0.2-2.3-0.5-3.1L52.1,0.9C51.6,0.3,50.8,0,50,0s-1.6,0.3-2.1,0.9L32.5,17.3c-0.8,0.8-1,2.1-0.5,3.1 c0.5,1.1,1.5,1.7,2.6,1.7h6.7v19.2H22.1v-6.7c0-1.2-0.7-2.2-1.7-2.6c-1.1-0.5-2.3-0.2-3.1,0.5L0.9,47.9C0.3,48.4,0,49.2,0,50 s0.3,1.6,0.9,2.1l16.3,15.4c0.8,0.8,2.1,1,3.1,0.5c1.1-0.5,1.7-1.5,1.7-2.6v-6.7h19.2v19.2h-6.7c-1.2,0-2.2,0.7-2.6,1.7 c-0.5,1.1-0.2,2.3,0.5,3.1l15.4,16.3c0.5,0.6,1.3,0.9,2.1,0.9s1.6-0.3,2.1-0.9l15.4-16.3c0.8-0.8,1-2.1,0.5-3.1 c-0.5-1.1-1.5-1.7-2.6-1.7h-6.7V58.7h19.2v6.7c0,1.2,0.7,2.2,1.7,2.6c1.1,0.5,2.3,0.2,3.1-0.5l16.3-15.4c0.6-0.5,0.9-1.3,0.9-2.1 S99.7,48.4,99.1,47.9z"/><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g>
                        </svg>                        
                    </a>
                    <a href="javascript:void(0);" class="remove_button" title="<?php esc_html_e( 'Remove', 'reviewx' ); ?>">
                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve">
                            <g><path class="st0" d="M19,35.3c1.4,20.8,2.7,37.6,4.1,58.4c0.2,3.6,3.2,6.2,6.9,6.2c13.2,0,26.5,0,39.7,0c3.9,0,6.7-2.7,7-6.7 C77.8,76,79,58.8,80.1,41.5c0.3-3.8,0.4-3.6,0.7-7.6c-20.7,0-41.2,0-61.7,0C19,34.4,19,34.9,19,35.3z M61.7,56 c0.2-2.4,0.4-4.7,0.6-7.1c0.2-2.4,1.5-3.7,3.4-3.5c1.9,0.2,3,1.6,2.8,4c-0.6,7.4-1.3,14.8-1.9,22.2c-0.4,4.1-0.7,8.3-1.1,12.4 c-0.2,2.2-1.5,3.5-3.3,3.4c-1.8-0.1-3-1.6-2.9-3.2C60.1,74.5,60.9,65.2,61.7,56z M46.7,49.3c0-2.6,1.2-4,3.2-3.9 c1.9,0.1,3,1.4,3,3.9c0,5.7,0,11.5,0,17.2c0,0,0,0,0,0c0,5.7,0,11.3,0,17c0,2.5-1.2,4.1-3.1,4.1c-1.9,0-3.1-1.5-3.1-4 C46.7,72,46.7,60.7,46.7,49.3z M32.8,45.7c2.1-1.1,4.3,0.3,4.6,2.9c0.6,6.7,1.2,13.5,1.8,20.2c0.4,5,0.9,9.9,1.3,15.6 c0,1.4-1.1,2.9-2.9,3.1c-1.8,0.2-3.2-1.2-3.4-3.3c-1-11.5-2-23.1-3.1-34.6C31,47.9,31.3,46.5,32.8,45.7z"/><path class="st0" d="M88.7,16.3c-0.3-2.7-2.6-4.8-5.4-5.2c-1.1-0.2-2.2-0.2-3.3-0.2c-4.2,0-8.4,0-12.9,0c0-1.4,0-2.6,0-3.8 C66.9,2.7,64.2,0,59.7,0c-6.6,0-13.2,0-19.8,0c-4.2,0-7,2.7-7.2,6.9c-0.1,1.2,0,2.5,0,3.9c-1.1,0-1.9,0.1-2.7,0.1c-4,0-8-0.1-12,0 c-3.3,0.1-6.1,1.7-6.7,4.5c-0.6,2.5-0.4,5.2-0.6,7.9c26.3,0,52.1,0,78.1,0C88.7,20.9,88.9,18.6,88.7,16.3z"/></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g>
                        </svg>                    
                    </a>             
                <div class="show_error_message"></div>
            </td>
        </tr>
        <tr valign="top" >
            <td class="middle-align">
                <input type="text" name="<?php echo esc_attr( $name ); ?>[]" maxlength="80" class="timezone_string rx-meta-field playfield" placeholder="<?php esc_html_e( 'Criteria Name', 'reviewx' ); ?>" value="<?php esc_attr_e('Price', 'reviewx'); ?>">
                <input type="hidden" name="<?php echo $name; ?>_name[]" value="ctr_h8S8">
                <a href="javascript:void(0);" class="up_button" title="<?php esc_html_e( 'Up field', 'reviewx' ); ?>">
                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve">
                            <style type="text/css">.st0{fill:#9BA1B0;}</style>
                            <path class="st0" d="M99.1,47.9L82.7,32.5c-0.8-0.8-2.1-1-3.1-0.5c-1.1,0.5-1.7,1.5-1.7,2.6v6.7H58.7V22.1h6.7 c1.2,0,2.2-0.7,2.6-1.7c0.5-1.1,0.2-2.3-0.5-3.1L52.1,0.9C51.6,0.3,50.8,0,50,0s-1.6,0.3-2.1,0.9L32.5,17.3c-0.8,0.8-1,2.1-0.5,3.1 c0.5,1.1,1.5,1.7,2.6,1.7h6.7v19.2H22.1v-6.7c0-1.2-0.7-2.2-1.7-2.6c-1.1-0.5-2.3-0.2-3.1,0.5L0.9,47.9C0.3,48.4,0,49.2,0,50 s0.3,1.6,0.9,2.1l16.3,15.4c0.8,0.8,2.1,1,3.1,0.5c1.1-0.5,1.7-1.5,1.7-2.6v-6.7h19.2v19.2h-6.7c-1.2,0-2.2,0.7-2.6,1.7 c-0.5,1.1-0.2,2.3,0.5,3.1l15.4,16.3c0.5,0.6,1.3,0.9,2.1,0.9s1.6-0.3,2.1-0.9l15.4-16.3c0.8-0.8,1-2.1,0.5-3.1 c-0.5-1.1-1.5-1.7-2.6-1.7h-6.7V58.7h19.2v6.7c0,1.2,0.7,2.2,1.7,2.6c1.1,0.5,2.3,0.2,3.1-0.5l16.3-15.4c0.6-0.5,0.9-1.3,0.9-2.1 S99.7,48.4,99.1,47.9z"/><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g>
                        </svg>                        
                    </a>
                    <a href="javascript:void(0);" class="remove_button" title="<?php esc_html_e( 'Remove', 'reviewx' ); ?>">
                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve">
                            <g><path class="st0" d="M19,35.3c1.4,20.8,2.7,37.6,4.1,58.4c0.2,3.6,3.2,6.2,6.9,6.2c13.2,0,26.5,0,39.7,0c3.9,0,6.7-2.7,7-6.7 C77.8,76,79,58.8,80.1,41.5c0.3-3.8,0.4-3.6,0.7-7.6c-20.7,0-41.2,0-61.7,0C19,34.4,19,34.9,19,35.3z M61.7,56 c0.2-2.4,0.4-4.7,0.6-7.1c0.2-2.4,1.5-3.7,3.4-3.5c1.9,0.2,3,1.6,2.8,4c-0.6,7.4-1.3,14.8-1.9,22.2c-0.4,4.1-0.7,8.3-1.1,12.4 c-0.2,2.2-1.5,3.5-3.3,3.4c-1.8-0.1-3-1.6-2.9-3.2C60.1,74.5,60.9,65.2,61.7,56z M46.7,49.3c0-2.6,1.2-4,3.2-3.9 c1.9,0.1,3,1.4,3,3.9c0,5.7,0,11.5,0,17.2c0,0,0,0,0,0c0,5.7,0,11.3,0,17c0,2.5-1.2,4.1-3.1,4.1c-1.9,0-3.1-1.5-3.1-4 C46.7,72,46.7,60.7,46.7,49.3z M32.8,45.7c2.1-1.1,4.3,0.3,4.6,2.9c0.6,6.7,1.2,13.5,1.8,20.2c0.4,5,0.9,9.9,1.3,15.6 c0,1.4-1.1,2.9-2.9,3.1c-1.8,0.2-3.2-1.2-3.4-3.3c-1-11.5-2-23.1-3.1-34.6C31,47.9,31.3,46.5,32.8,45.7z"/><path class="st0" d="M88.7,16.3c-0.3-2.7-2.6-4.8-5.4-5.2c-1.1-0.2-2.2-0.2-3.3-0.2c-4.2,0-8.4,0-12.9,0c0-1.4,0-2.6,0-3.8 C66.9,2.7,64.2,0,59.7,0c-6.6,0-13.2,0-19.8,0c-4.2,0-7,2.7-7.2,6.9c-0.1,1.2,0,2.5,0,3.9c-1.1,0-1.9,0.1-2.7,0.1c-4,0-8-0.1-12,0 c-3.3,0.1-6.1,1.7-6.7,4.5c-0.6,2.5-0.4,5.2-0.6,7.9c26.3,0,52.1,0,78.1,0C88.7,20.9,88.9,18.6,88.7,16.3z"/></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g>
                        </svg>                    
                    </a>                 
                <div class="show_error_message"></div>
            </td>
        </tr> 
        <tr valign="top" >
            <td class="middle-align">
                <input type="text" name="<?php echo esc_attr( $name ); ?>[]" maxlength="80" class="timezone_string rx-meta-field playfield" placeholder="<?php esc_html_e( 'Criteria Name', 'reviewx' ); ?>" value="<?php esc_attr_e('Service', 'reviewx'); ?>">
                <input type="hidden" name="<?php echo $name; ?>_name[]" value="ctr_h8S9">
                <a href="javascript:void(0);" class="up_button" title="<?php esc_html_e( 'Up field', 'reviewx' ); ?>">
                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve">
                        <style type="text/css">.st0{fill:#9BA1B0;}</style>
                        <path class="st0" d="M99.1,47.9L82.7,32.5c-0.8-0.8-2.1-1-3.1-0.5c-1.1,0.5-1.7,1.5-1.7,2.6v6.7H58.7V22.1h6.7 c1.2,0,2.2-0.7,2.6-1.7c0.5-1.1,0.2-2.3-0.5-3.1L52.1,0.9C51.6,0.3,50.8,0,50,0s-1.6,0.3-2.1,0.9L32.5,17.3c-0.8,0.8-1,2.1-0.5,3.1 c0.5,1.1,1.5,1.7,2.6,1.7h6.7v19.2H22.1v-6.7c0-1.2-0.7-2.2-1.7-2.6c-1.1-0.5-2.3-0.2-3.1,0.5L0.9,47.9C0.3,48.4,0,49.2,0,50 s0.3,1.6,0.9,2.1l16.3,15.4c0.8,0.8,2.1,1,3.1,0.5c1.1-0.5,1.7-1.5,1.7-2.6v-6.7h19.2v19.2h-6.7c-1.2,0-2.2,0.7-2.6,1.7 c-0.5,1.1-0.2,2.3,0.5,3.1l15.4,16.3c0.5,0.6,1.3,0.9,2.1,0.9s1.6-0.3,2.1-0.9l15.4-16.3c0.8-0.8,1-2.1,0.5-3.1 c-0.5-1.1-1.5-1.7-2.6-1.7h-6.7V58.7h19.2v6.7c0,1.2,0.7,2.2,1.7,2.6c1.1,0.5,2.3,0.2,3.1-0.5l16.3-15.4c0.6-0.5,0.9-1.3,0.9-2.1 S99.7,48.4,99.1,47.9z"/><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g>
                    </svg>                        
                </a>
                <a href="javascript:void(0);" class="remove_button" title="<?php esc_html_e( 'Remove', 'reviewx' ); ?>">
                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve">
                        <g><path class="st0" d="M19,35.3c1.4,20.8,2.7,37.6,4.1,58.4c0.2,3.6,3.2,6.2,6.9,6.2c13.2,0,26.5,0,39.7,0c3.9,0,6.7-2.7,7-6.7 C77.8,76,79,58.8,80.1,41.5c0.3-3.8,0.4-3.6,0.7-7.6c-20.7,0-41.2,0-61.7,0C19,34.4,19,34.9,19,35.3z M61.7,56 c0.2-2.4,0.4-4.7,0.6-7.1c0.2-2.4,1.5-3.7,3.4-3.5c1.9,0.2,3,1.6,2.8,4c-0.6,7.4-1.3,14.8-1.9,22.2c-0.4,4.1-0.7,8.3-1.1,12.4 c-0.2,2.2-1.5,3.5-3.3,3.4c-1.8-0.1-3-1.6-2.9-3.2C60.1,74.5,60.9,65.2,61.7,56z M46.7,49.3c0-2.6,1.2-4,3.2-3.9 c1.9,0.1,3,1.4,3,3.9c0,5.7,0,11.5,0,17.2c0,0,0,0,0,0c0,5.7,0,11.3,0,17c0,2.5-1.2,4.1-3.1,4.1c-1.9,0-3.1-1.5-3.1-4 C46.7,72,46.7,60.7,46.7,49.3z M32.8,45.7c2.1-1.1,4.3,0.3,4.6,2.9c0.6,6.7,1.2,13.5,1.8,20.2c0.4,5,0.9,9.9,1.3,15.6 c0,1.4-1.1,2.9-2.9,3.1c-1.8,0.2-3.2-1.2-3.4-3.3c-1-11.5-2-23.1-3.1-34.6C31,47.9,31.3,46.5,32.8,45.7z"/><path class="st0" d="M88.7,16.3c-0.3-2.7-2.6-4.8-5.4-5.2c-1.1-0.2-2.2-0.2-3.3-0.2c-4.2,0-8.4,0-12.9,0c0-1.4,0-2.6,0-3.8 C66.9,2.7,64.2,0,59.7,0c-6.6,0-13.2,0-19.8,0c-4.2,0-7,2.7-7.2,6.9c-0.1,1.2,0,2.5,0,3.9c-1.1,0-1.9,0.1-2.7,0.1c-4,0-8-0.1-12,0 c-3.3,0.1-6.1,1.7-6.7,4.5c-0.6,2.5-0.4,5.2-0.6,7.9c26.3,0,52.1,0,78.1,0C88.7,20.9,88.9,18.6,88.7,16.3z"/></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g>
                    </svg>                    
                </a>                  
                <div class="show_error_message"></div>
            </td>
        </tr>                
    <?php endif; ?>
    </tbody>
</table>
<table class="form-table">
    <tr valign="top">
        <td class="middle-align">
            <div class="rx-click-area-wrapper">
                <div class="rx-click-overlay" id="rx-click-overlay"></div>
                <label for="add-field" class="rx-group-field-add" >
                    <span class="dashicons dashicons-plus-alt rx_add_field_icon"></span>
                    <span class="rx_add_field_label"><?php esc_html_e( 'Add New Criteria', 'reviewx' );?></span>
                    <input type="button" name="add-field" id="add-field" class="timezone_string add-field" value="">
                </label>
            </div>            
        </td>
    </tr>
</table> 
