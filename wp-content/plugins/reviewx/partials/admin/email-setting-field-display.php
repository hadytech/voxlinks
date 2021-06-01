<?php
$opt_alert_class = '';
if( isset( $field['disable'] ) && $field['disable'] === true ) {
    $opt_alert_class = 'rx-opt-alert';
}
$is_pro = false;
$is_pro = isset( $field['is_pro'] ) ? $field['is_pro'] : false;
?>
<div id="<?php echo esc_attr( $id ); ?>" class="rx-field <?php echo esc_attr( $row_class ); ?> <?php echo $is_pro == true ? 'is-pro' : ''; ?>">

    <?php if( $idd == 'content_tab' ){

        if( $key == 'email_order_status' ){
        ?>
            <div class="rx_review_email_field_item">
                <div class="rx_review_email_field_title">
                    <h3 class="rx-field-heading"><?php echo esc_html( $field['title'] ); ?>: </h3>
                </div>
                <div class="rx_review_email_field_content_wrap">
                    <ul class="rx_review_email_field_content">
                        <?php
                        foreach ( $field['order_status_fields'] as $key => $order_status_field){
                            $file_name = $order_status_field['type'];
                            ?>
                            <li class="rx_review_email_field_content_item">
                                <div class="rx-control">
                                    <?php
                                    do_action( 'rx_field_before_wrapper', $name, $value, $order_status_field );
                                    ?>
                                    <div class="rx-control-wrapper <?php echo esc_attr( $opt_alert_class ); ?>">
                                        <?php
                                        if( $file_name ) {
                                            include REVIEWX_INCLUDE_PATH . 'admin/fields/'. $file_name .'.php';
                                        } else {
                                            if( $order_status_field['view'] ) {
                                                call_user_func( $order_status_field['view'] );
                                            }
                                        }
                                        if( isset( $order_status_field['description'] ) && ! empty( $order_status_field['description'] ) ) :
                                            ?>
                                            <span class="rx-field-description"><?php echo esc_html( $order_status_field['description'] ); ?></span>
                                        <?php
                                        endif;
                                        if( isset( $order_status_field['help'] ) && ! empty( $order_status_field['help'] ) ) :
                                            ?>
                                            <p class="rx-field-help"><?php echo esc_html( $order_status_field['help'] ); ?></p>
                                        <?php
                                        endif;
                                        ?>
                                    </div>
                                    <?php do_action( 'rx_field_after_wrapper', $name, $value, $order_status_field ); ?>
                                </div>
                                <div class="rx-label">
                                    <?php if( $is_pro && !ReviewX_Helper::is_pro() ):  // check is pro ?>
                                    <div class="rx-pro-checkbox">
                                        <?php endif; ?>
                                        <?php
                                        if( isset( $order_status_field['heading'] ) && ! empty( $order_status_field['heading'] ) ) :
                                            ?>
                                            <h3 class="rx-field-heading"><?php echo esc_html( $order_status_field['heading'] ); ?></h3>
                                        <?php
                                        endif;
                                        ?>
                                        <?php if( $is_pro && !ReviewX_Helper::is_pro() ):  // check is pro ?>
                                            <sup class="rx-pro-label"><?php _e( 'Pro', 'reviewx' ); ?></sup>
                                        <?php endif; ?>
                                        <?php if( $is_pro && !ReviewX_Helper::is_pro() ): // check is pro ?>
                                    </div>
                                <?php endif; ?>
                                    <label class="rx_order_status_title">
                                        <?php echo esc_html( $order_status_field['label']); ?>
                                    </label>
                                </div>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                    <p>
                        <?php echo esc_html( $field['desc'] ); ?>
                    </p>
                </div>
            </div>
            <?php
            }elseif ($key == 'get_review_email'){
            ?>
            <div class="rx_review_email_field_item">
                <div class="rx_review_email_field_title">
                    <h3 class="rx-field-heading"><?php echo esc_html( $field['heading'] ); ?>: </h3>
                </div>
                <div class="rx_review_email_field_content_wrap">
                    <div class="rx-control">
                        <?php
                        do_action( 'rx_field_before_wrapper', $name, $value, $field );
                        ?>
                        <div class="rx-control-wrapper <?php echo esc_attr( $opt_alert_class ); ?>">
                            <?php
                            if( $file_name ) {
                                include REVIEWX_INCLUDE_PATH . 'admin/fields/'. $file_name .'.php';
                            } else {
                                if( $field['view'] ) {
                                    call_user_func( $field['view'] );
                                }
                            }
                            if( isset( $field['description'] ) && ! empty( $field['description'] ) ) :
                                ?>
                                <span class="rx-field-description"><?php echo esc_html( $field['description'] ); ?></span>
                            <?php
                            endif;
                            if( isset( $field['help'] ) && ! empty( $field['help'] ) ) :
                                ?>
                                <p class="rx-field-help"><?php echo esc_html( $field['help'] ); ?></p>
                            <?php
                            endif;
                            ?>
                        </div>
                        <?php do_action( 'rx_field_after_wrapper', $name, $value, $field ); ?>
                    </div>
                    <div class="rx-label">
                        <?php if( $is_pro && !ReviewX_Helper::is_pro() ):  // check is pro ?>
                        <div class="rx-pro-checkbox">
                            <?php endif; ?>
                            <?php if( $is_pro && !ReviewX_Helper::is_pro() ):  // check is pro ?>
                                <sup class="rx-pro-label"><?php _e( 'Pro', 'reviewx' ); ?></sup>
                            <?php endif; ?>
                            <?php if( $is_pro && !ReviewX_Helper::is_pro() ): // check is pro ?>
                        </div>
                        <?php endif; ?>
                        <label for="<?php echo esc_attr( $name ); ?>">
                            <?php echo esc_html( $field['label']); ?>
                        </label>
                    </div>
                </div>
            </div>

            <?php
        }elseif ($key == 'filter_products_email'){
            ?>
            <div class="rx_review_email_field_item">
                <div class="rx_review_email_field_title">
                    <h3 class="rx-field-heading"><?php echo esc_html( $field['heading'] ); ?>: </h3>
                </div>
                <div class="rx_review_email_field_content_wrap">
                    <div class="rx-control">
                        <?php
                        do_action( 'rx_field_before_wrapper', $name, $value, $field );
                        ?>
                        <div class="rx-control-wrapper <?php echo esc_attr( $opt_alert_class ); ?>">
                            <?php
                            if( $file_name ) {
                                include REVIEWX_INCLUDE_PATH . 'admin/fields/'. $file_name .'.php';
                            } else {
                                if( $field['view'] ) {
                                    call_user_func( $field['view'] );
                                }
                            }
                            if( isset( $field['description'] ) && ! empty( $field['description'] ) ) :
                                ?>
                                <span class="rx-field-description"><?php echo esc_html( $field['description'] ); ?></span>
                            <?php
                            endif;
                            if( isset( $field['help'] ) && ! empty( $field['help'] ) ) :
                                ?>
                                <p class="rx-field-help"><?php echo esc_html( $field['help'] ); ?></p>
                            <?php
                            endif;
                            ?>
                        </div>
                        <?php do_action( 'rx_field_after_wrapper', $name, $value, $field ); ?>
                    </div>
                    <div class="rx-label">
                        <?php if( $is_pro && !ReviewX_Helper::is_pro() ):  // check is pro ?>
                        <div class="rx-pro-checkbox">
                            <?php endif; ?>
                            <?php if( $is_pro && !ReviewX_Helper::is_pro() ):  // check is pro ?>
                                <sup class="rx-pro-label"><?php _e( 'Pro', 'reviewx' ); ?></sup>
                            <?php endif; ?>
                            <?php if( $is_pro && !ReviewX_Helper::is_pro() ): // check is pro ?>
                        </div>
                    <?php endif; ?>
                        <label for="<?php echo esc_attr( $name ); ?>">
                            <?php echo esc_html( $field['label']); ?>
                        </label>
                    </div>
                </div>
            </div>
            <?php
        } elseif ($key == 'filter_products_by') {
            ?>
            <div class="rx_review_email_field_item">
                <div class="rx_review_email_field_title">
                    <h3 class="rx-field-heading"><?php echo esc_html( $field['heading'] ); ?>: </h3>
                </div>
                <div class="rx_review_email_field_content_wrap">
                    <div class="rx-control">
                        <?php
                        do_action( 'rx_field_before_wrapper', $name, $value, $field );
                        ?>
                        <div class="rx-control-wrapper <?php echo esc_attr( $opt_alert_class ); ?>">
                            <?php
                            if( $file_name ) {
                                include REVIEWX_INCLUDE_PATH . 'admin/fields/'. $file_name .'.php';
                            } else {
                                if( $field['view'] ) {
                                    call_user_func( $field['view'] );
                                }
                            }
                            if( isset( $field['description'] ) && ! empty( $field['description'] ) ) :
                                ?>
                                <span class="rx-field-description"><?php echo esc_html( $field['description'] ); ?></span>
                            <?php
                            endif;
                            if( isset( $field['help'] ) && ! empty( $field['help'] ) ) :
                                ?>
                                <p class="rx-field-help"><?php echo esc_html( $field['help'] ); ?></p>
                            <?php
                            endif;
                            ?>
                        </div>
                        <?php do_action( 'rx_field_after_wrapper', $name, $value, $field ); ?>
                    </div>
                    <div class="rx-label">
                        <?php if( $is_pro && !ReviewX_Helper::is_pro() ):  // check is pro ?>
                        <div class="rx-pro-checkbox">
                            <?php endif; ?>
                            <?php if( $is_pro && !ReviewX_Helper::is_pro() ):  // check is pro ?>
                                <sup class="rx-pro-label"><?php _e( 'Pro', 'reviewx' ); ?></sup>
                            <?php endif; ?>
                            <?php if( $is_pro && !ReviewX_Helper::is_pro() ): // check is pro ?>
                        </div>
                    <?php endif; ?>
                        <label for="<?php echo esc_attr( $name ); ?>">
                            <?php echo esc_html( $field['label']); ?>
                        </label>
                    </div>
                </div>
            </div>
            <?php
        } elseif ($key == 'unsubscribe_url') {
            ?>
            <div class="rx_review_email_field_item">
                <div class="rx_review_email_field_title rx-field-heading-big-title">
                    <h3 class="rx-field-heading"><?php echo esc_html( $field['heading'] ); ?>: </h3>
                </div>
                <div class="rx_review_email_field_content_wrap">
                    <div class="rx-control">
                        <?php
                        do_action( 'rx_field_before_wrapper', $name, $value, $field );
                        ?>
                        <div class="rx-control-wrapper <?php echo esc_attr( $opt_alert_class ); ?>">
                            <?php
                            if( $file_name ) {
                                include REVIEWX_INCLUDE_PATH . 'admin/fields/'. $file_name .'.php';
                            } else {
                                if( $field['view'] ) {
                                    call_user_func( $field['view'] );
                                }
                            }
                            if( isset( $field['description'] ) && ! empty( $field['description'] ) ) :
                                ?>
                                <span class="rx-field-description"><?php echo esc_html( $field['description'] ); ?></span>
                            <?php
                            endif;
                            if( isset( $field['help'] ) && ! empty( $field['help'] ) ) :
                                ?>
                                <p class="rx-field-help"><?php echo esc_html( $field['help'] ); ?></p>
                            <?php
                            endif;
                            ?>
                        </div>
                        <?php do_action( 'rx_field_after_wrapper', $name, $value, $field ); ?>
                    </div>
                    <div class="rx-label">
                        <?php if( $is_pro && !ReviewX_Helper::is_pro() ):  // check is pro ?>
                        <div class="rx-pro-checkbox">
                            <?php endif; ?>
                            <?php if( $is_pro && !ReviewX_Helper::is_pro() ):  // check is pro ?>
                                <sup class="rx-pro-label"><?php _e( 'Pro', 'reviewx' ); ?></sup>
                            <?php endif; ?>
                            <?php if( $is_pro && !ReviewX_Helper::is_pro() ): // check is pro ?>
                        </div>
                    <?php endif; ?>
                        <label for="<?php echo esc_attr( $name ); ?>">
                            <?php echo esc_html( $field['label']); ?>
                        </label>
                    </div>
                </div>
            </div>
            <?php
        } elseif ($key == 'consent_email_subscription') {
            ?>
            <div class="rx_review_email_field_item">
                <div class="rx_review_email_field_title rx-field-heading-big-title">
                    <h3 class="rx-field-heading"><?php echo esc_html( $field['heading'] ); ?>: </h3>
                </div>
                <div class="rx_review_email_field_content_wrap">
                    <div class="rx-control">
                        <?php
                        do_action( 'rx_field_before_wrapper', $name, $value, $field );
                        ?>
                        <div class="rx-control-wrapper <?php echo esc_attr( $opt_alert_class ); ?>">
                            <?php
                            if( $file_name ) {
                                include REVIEWX_INCLUDE_PATH . 'admin/fields/'. $file_name .'.php';
                            } else {
                                if( $field['view'] ) {
                                    call_user_func( $field['view'] );
                                }
                            }
                            if( isset( $field['description'] ) && ! empty( $field['description'] ) ) :
                                ?>
                                <span class="rx-field-description"><?php echo esc_html( $field['description'] ); ?></span>
                            <?php
                            endif;
                            if( isset( $field['help'] ) && ! empty( $field['help'] ) ) :
                                ?>
                                <p class="rx-field-help"><?php echo esc_html( $field['help'] ); ?></p>
                            <?php
                            endif;
                            ?>
                        </div>
                        <?php do_action( 'rx_field_after_wrapper', $name, $value, $field ); ?>
                    </div>
                    <div class="rx-label">
                        <?php if( $is_pro && !ReviewX_Helper::is_pro() ):  // check is pro ?>
                        <div class="rx-pro-checkbox">
                            <?php endif; ?>
                            <?php if( $is_pro && !ReviewX_Helper::is_pro() ):  // check is pro ?>
                                <sup class="rx-pro-label"><?php _e( 'Pro', 'reviewx' ); ?></sup>
                            <?php endif; ?>
                            <?php if( $is_pro && !ReviewX_Helper::is_pro() ): // check is pro ?>
                        </div>
                    <?php endif; ?>
                        <label for="<?php echo esc_attr( $name ); ?>">
                            <?php echo esc_html( $field['label']); ?>
                        </label>
                    </div>
                </div>
            </div>
            <?php
        } elseif ($key == 'auto_review_reminder') {
            ?>
            <div class="rx_review_email_field_item">
                <div class="rx_review_email_field_title rx-field-heading-big-title">
                    <h3 class="rx-field-heading"><?php echo esc_html( $field['heading'] ); ?>: </h3>
                </div>
                <div class="rx_review_email_field_content_wrap">
                    <div class="rx-control">
                        <?php
                        do_action( 'rx_field_before_wrapper', $name, $value, $field );
                        ?>
                        <div class="rx-control-wrapper <?php echo esc_attr( $opt_alert_class ); ?>">
                            <?php
                            if( $file_name ) {
                                include REVIEWX_INCLUDE_PATH . 'admin/fields/'. $file_name .'.php';
                            } else {
                                if( $field['view'] ) {
                                    call_user_func( $field['view'] );
                                }
                            }
                            if( isset( $field['description'] ) && ! empty( $field['description'] ) ) :
                                ?>
                                <span class="rx-field-description"><?php echo esc_html( $field['description'] ); ?></span>
                            <?php
                            endif;
                            if( isset( $field['help'] ) && ! empty( $field['help'] ) ) :
                                ?>
                                <p class="rx-field-help"><?php echo esc_html( $field['help'] ); ?></p>
                            <?php
                            endif;
                            ?>
                        </div>
                        <?php do_action( 'rx_field_after_wrapper', $name, $value, $field ); ?>
                    </div>
                    <div class="rx-label">
                        <?php if( $is_pro && !ReviewX_Helper::is_pro() ):  // check is pro ?>
                        <div class="rx-pro-checkbox">
                            <?php endif; ?>
                            <?php if( $is_pro && !ReviewX_Helper::is_pro() ):  // check is pro ?>
                                <sup class="rx-pro-label"><?php _e( 'Pro', 'reviewx' ); ?></sup>
                            <?php endif; ?>
                            <?php if( $is_pro && !ReviewX_Helper::is_pro() ): // check is pro ?>
                        </div>
                    <?php endif; ?>
                        <label for="<?php echo esc_attr( $name ); ?>">
                            <?php echo esc_html( $field['label']); ?>
                        </label>
                    </div>
                </div>
            </div>
            <?php            
        } elseif ($key == 'how_many_email') {
            ?>
            <div class="rx_review_email_field_item">
                <div class="rx_review_email_field_title">
                    <h3 class="rx-field-heading"><?php echo esc_html( $field['heading'] ); ?>: </h3>
                </div>
                <div class="rx_review_email_field_content_wrap">
                    <div class="rx-control">
                        <?php
                        do_action( 'rx_field_before_wrapper', $name, $value, $field );
                        ?>
                        <div class="rx-control-wrapper <?php echo esc_attr( $opt_alert_class ); ?>">
                            <?php
                            if( $file_name ) {
                                include REVIEWX_INCLUDE_PATH . 'admin/fields/'. $file_name .'.php';
                            } else {
                                if( $field['view'] ) {
                                    call_user_func( $field['view'] );
                                }
                            }
                            if( isset( $field['description'] ) && ! empty( $field['description'] ) ) :
                                ?>
                                <span class="rx-field-description"><?php echo esc_html( $field['description'] ); ?></span>
                            <?php
                            endif;
                            if( isset( $field['help'] ) && ! empty( $field['help'] ) ) :
                                ?>
                                <p class="rx-field-help"><?php echo esc_html( $field['help'] ); ?></p>
                            <?php
                            endif;
                            ?>
                        </div>
                        <?php do_action( 'rx_field_after_wrapper', $name, $value, $field ); ?>
                    </div>
                    <div class="rx-label">
                        <?php if( $is_pro && !ReviewX_Helper::is_pro() ):  // check is pro ?>
                        <div class="rx-pro-checkbox">
                            <?php endif; ?>
                            <?php if( $is_pro && !ReviewX_Helper::is_pro() ):  // check is pro ?>
                                <sup class="rx-pro-label"><?php _e( 'Pro', 'reviewx' ); ?></sup>
                            <?php endif; ?>
                            <?php if( $is_pro && !ReviewX_Helper::is_pro() ): // check is pro ?>
                        </div>
                    <?php endif; ?>
                        <label for="<?php echo esc_attr( $name ); ?>">
                            <?php echo esc_html( $field['label']); ?>
                        </label>
                    </div>
                </div>
            </div>
            <?php
        } else{
            ?>
            <div class="rx-label">
                <?php if( $is_pro && !ReviewX_Helper::is_pro() ):  // check is pro ?>
                <div class="rx-pro-checkbox">
                    <?php endif; ?>
                    <?php
                    if( isset( $field['heading'] ) && ! empty( $field['heading'] ) ) :
                        ?>
                        <h3 class="rx-field-heading"><?php echo esc_html( $field['heading'] ); ?></h3>
                    <?php
                    endif;
                    ?>
                    <?php if( $is_pro && !ReviewX_Helper::is_pro() ):  // check is pro ?>
                        <sup class="rx-pro-label"><?php _e( 'Pro', 'reviewx' ); ?></sup>
                    <?php endif; ?>
                    <?php if( $is_pro && !ReviewX_Helper::is_pro() ): // check is pro ?>
                </div>
            <?php endif; ?>
                <label for="<?php echo esc_attr( $name ); ?>">
                    <?php echo isset($field['label']) ? esc_html( $field['label'] ) : ''; ?>
                </label>
            </div>
            <div class="rx-control">
                <?php
                do_action( 'rx_field_before_wrapper', $name, $value, $field );
                ?>
                <div class="rx-control-wrapper <?php echo esc_attr( $opt_alert_class ); ?>">
                    <?php
                    if( $file_name ) {
                        include REVIEWX_INCLUDE_PATH . 'admin/fields/'. $file_name .'.php';
                    } else {
                        if( $field['view'] ) {
                            call_user_func( $field['view'] );
                        }
                    }
                    if( isset( $field['description'] ) && ! empty( $field['description'] ) ) :
                        ?>
                        <span class="rx-field-description"><?php echo esc_html( $field['description'] ); ?></span>
                    <?php
                    endif;
                    if( isset( $field['help'] ) && ! empty( $field['help'] ) ) :
                        ?>
                        <p class="rx-field-help"><?php echo esc_html( $field['help'] ); ?></p>
                    <?php
                    endif;
                    ?>
                </div>
                <?php do_action( 'rx_field_after_wrapper', $name, $value, $field ); ?>
            </div>
            <?php
        }
        ?>

    <?php } ?>

</div>
