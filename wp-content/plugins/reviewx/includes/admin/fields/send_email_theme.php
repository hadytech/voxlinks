<?php 
    if( isset( $field['options'] ) && ! empty( $field['options'] ) ) {
        $options = $field['options'];
    }

    $theme_title = '';
    $title       = '';
?>

<div class="rx_send_email_theme_wrap">
    <h3><?php esc_html_e('Template Style', 'reviewx' ); ?></h3>
    <div class="rx-theme-field-wrapper" data-name="<?php echo esc_attr( $name ); ?>">
        <input id="<?php echo esc_attr( $name ); ?>" type="hidden" name="<?php echo esc_attr( $name ); ?>" value="template_style_one">
        <div class="rx-theme-field-inner">
            <?php
            if( is_array( $options ) ) {
                $is_pro = false;
                foreach( $options as $opt_key => $opt_value ) {

                    $selected   = ( $value == $opt_key ) ? 'rx-theme-selected' : '';
                    $main_value = $opt_value;
                    if( is_array( $opt_value ) ) {
                        $title      = isset( $opt_value['title'] ) ? $opt_value['title'] : $theme_title;
                        $is_pro     = isset( $opt_value['is_pro'] ) ? $opt_value['is_pro'] : $is_pro;
                        $opt_value  = isset( $opt_value['source'] ) ? $opt_value['source'] : false;
                        $is_pro     = ReviewX_Helper::is_pro() ? false : $is_pro;
                    }

                    ?>
                    <div class="rx-single-theme-main-wrapper">
                        <div class="rx-single-theme-wrapper rx-meta-field <?php echo $is_pro ? 'rx-radio-pro' : ''; ?> <?php echo esc_attr( $selected ); ?>">
                            <img title="<?php echo esc_attr( $title ); ?>"  data-theme="<?php echo esc_attr( $opt_key ); ?>" src="<?php echo esc_url( $opt_value ); ?>" alt="<?php echo esc_attr( $theme_title ); ?>">
                        </div>
                        <?php if( $is_pro ) : ?>
                            <div class="rx-pro-label-wrapper">
                                <sup class="rx-pro-label"><?php echo __( 'Pro', 'reviewx' ); ?></sup>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php
                }
            }
            ?>
        </div>

    </div>
</div>
