<?php
function reviewx_review_email_args() {
    return array(
        'id'           => 'rx_metabox_wrapper',
        'title'        => __('ReviewX - Advanced Multi-criteria Rating & Reviews for WooCommerce', 'reviewx'),
        'object_types' => array( 'reviewx' ),
        'context'      => 'normal',
        'priority'     => 'high',
        'show_header'  => false,
        'tabnumber'    => true,
        'layout'       => 'horizontal',
        'tabs'         => apply_filters( 'rx_builder_quick_setup_tabs', array(
            'email_editor_tab' => array(
                'title'      => __('Email Content', 'reviewx'),
                'icon'       => '',
                'sections'   => apply_filters('rx_email_editor_tab', array(
                    'image' => array(
                        'title'    => __('Send Email To Customers To Remind About The Review', 'reviewx'),
                        'priority' => 100,
                        'fields'   => array(
                            'template_style' => array(
                                'type' => 'send_email_theme',
                                'priority'=> 4,
                                'title' => __('Template Style', 'reviewx'),
                                'default'=>'template_style_two',
                                'options'=> apply_filters( 'rx_template_style_style', array(
                                    'template_style_one'     => esc_url(assets('admin/images/themes/email-template.png')),
                                    'template_style_two'     => esc_url(assets('admin/images/themes/email-template-upcoming.png')),
                                ) )
                            ),
                            'email_subject'  => array(
                                'type'      => 'email_subject',
                                'label'     => '',
                                'priority'	=> 5,
                                'default'   => __('Your Feedback Means a Lot to Us! | [SHOP_NAME]', 'reviewx' )
                            ),
                            'email_editor'  => array(
                                'type'      => 'editor',
                                'label'     => '',
                                'priority'	=> 6,
                                'default'   => '<table class="body" style="border-collapse: collapse; border-spacing: 0; vertical-align: top; mso-table-lspace: 0pt; mso-table-rspace: 0pt; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; height: 100% !important; width: 100% !important; min-width: 100%; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; -webkit-font-smoothing: antialiased !important; -moz-osx-font-smoothing: grayscale !important; background-color: #f1f1f1; color: #444; font-family: Helvetica,Arial,sans-serif; font-weight: normal; padding: 0; margin: 0; text-align: left; font-size: 14px; mso-line-height-rule: exactly; line-height: 140%;" border="0" width="100%" cellspacing="0" cellpadding="0"><tbody><tr style="padding: 0; vertical-align: top; text-align: left;"><td class="body-inner wp-mail-smtp" style="word-wrap: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; mso-table-lspace: 0pt; mso-table-rspace: 0pt; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; color: #444; font-family: Helvetica,Arial,sans-serif; font-weight: normal; padding: 0; margin: 0; font-size: 14px; mso-line-height-rule: exactly; line-height: 140%; text-align: center;" align="center" valign="top"><table class="container" style="border-collapse: collapse; border-spacing: 0; padding: 0; vertical-align: top; mso-table-lspace: 0pt; mso-table-rspace: 0pt; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; width: 600px; margin: 0 auto 30px auto; text-align: inherit;" border="0" cellspacing="0" cellpadding="0"><tbody><tr style="padding: 0; vertical-align: top; text-align: left;"><td class="content" style="word-wrap: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; mso-table-lspace: 0pt; mso-table-rspace: 0pt; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; color: #444; font-family: Helvetica,Arial,sans-serif; font-weight: normal; margin: 0; text-align: left; font-size: 14px; mso-line-height-rule: exactly; line-height: 140%; background-color: #ffffff; padding: 60px 75px 45px 75px; border-right: 1px solid #ddd; border-bottom: 1px solid #ddd; border-left: 1px solid #ddd; border-top: 3px solid #809eb0;" align="left" valign="top"><div class="success"><p class="text-large" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; color: #444; font-family: Helvetica,Arial,sans-serif; font-weight: normal; padding: 0; text-align: left; mso-line-height-rule: exactly; line-height: 140%; margin: 0 0 15px 0; font-size: 14px;">'.__('Hey ,', 'reviewx').'[CUSTOMER_NAME]</p><p class="text-large" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; color: #444; font-family: Helvetica,Arial,sans-serif; font-weight: normal; padding: 0; text-align: left; mso-line-height-rule: exactly; line-height: 140%; margin: 0 0 15px 0; font-size: 14px;">'.__('Thank you for purchasing items from the ','reviewx').' [SHOP_NAME].'.__(' We love to know your experiences with the product(s) that you recently purchased.', 'reviewx').'</p><p class="text-large" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; color: #444; font-family: Helvetica,Arial,sans-serif; font-weight: normal; padding: 0; text-align: left; mso-line-height-rule: exactly; line-height: 140%; margin: 0 0 15px 0; font-size: 14px;">'.__('You can browse a list of orders from your account page and can submit your feedback based on multiple criteria that we specially designed for you. To browse your orders: ', 'reviewx').'[MY_ORDERS_PAGE]</p><p class="text-large" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; color: #444; font-family: Helvetica,Arial,sans-serif; font-weight: normal; padding: 0; text-align: left; mso-line-height-rule: exactly; line-height: 140%; margin: 0 0 15px 0; font-size: 14px;">[ORDER_DATE]'.__(' you placed the order ', 'reviewx').'[ORDER_ID]</p><p class="text-large" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; color: #444; font-family: Helvetica,Arial,sans-serif; font-weight: normal; padding: 0; text-align: left; mso-line-height-rule: exactly; line-height: 140%; margin: 0 0 15px 0; font-size: 14px;">[ORDER_ITEMS]</p><p class="text-large" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; color: #444; font-family: Helvetica,Arial,sans-serif; font-weight: normal; padding: 0; text-align: left; mso-line-height-rule: exactly; line-height: 140%; margin: 0 0 15px 0; font-size: 14px;">'.__('Your feedback means a lot to us! Thanks for being a loyal ', 'reviewx').'[SHOP_NAME] '.__('customer.', 'reviewx').'</p><p class="text-large" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; color: #444; font-family: Helvetica,Arial,sans-serif; font-weight: normal; padding: 0; text-align: left; mso-line-height-rule: exactly; line-height: 140%; margin: 0 0 15px 0; font-size: 14px;">'.__('Regards,', 'reviewx').'</p><p class="text-large" style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; color: #444; font-family: Helvetica,Arial,sans-serif; font-weight: normal; padding: 0; text-align: left; mso-line-height-rule: exactly; line-height: 140%; margin: 0 0 15px 0; font-size: 14px;">'.__('Team ', 'reviewx').'[SHOP_NAME]</p></div><h6>'.__('If you want to unsubscribe this email please go to this ', 'reviewx').'[UNSUBSCRIBE_LINK]</h6></td></tr></tbody></table></td></tr></tbody></table>'
                            ), // Default email content
                            'email_preset_placeholder'  => array(
                                'type'      => 'email_presets',
                                'label'     => '',
                                'priority'	=> 7,
                            ),
                            'disable_autocreate_unsubscribe_page' => array(
                                'type'      => 'checkbox',
                                'label'     => __('Disable Automatic Create Unsubscribe Page', 'reviewx'),
                                // 'description'=> __('Create Automatic Unsubscribe Page', 'reviewx'),
                                'priority'  => 8,
                            ),                              
                            'reset_email_template'  => array(
                                'type'      => 'reset_email_template_button',
                                'label'     => '',
                                'priority'	=> 9,
                            ),
                            'send_test_email' => array(
                                'type'      => 'send_test_email',
                                'label'     => '',
                                'priority'  => 10,
                            ),                          
                        )
                    ),
                ))
            ),

            'content_tab' => array(
                'title'         => __('Email Settings', 'reviewx'),
                'icon'          => '',
                'sections'      => apply_filters('rx_reminder_email_settings_sections', array(
                    'image' => array(
                        'fields'   => apply_filters('rx_reminder_email_scheduled_fields', array(
                            'free_subscription' => array(
                                'type' => 'free_subscription',
                            ),
                        ))
                    ),
                ))
            ),

            'scheduled_emails' => array(
                'title'      => __('Reminder Emails', 'reviewx'),
                'icon'       => '',
                'sections'   => apply_filters('rx_review_reminder_settings_sections', array(
                    'image' => array(
                        'title'    => __('All Reminder Emails', 'reviewx'),
                        'fields'   => apply_filters('rx_reminder_email_scheduled_fields', array(
                            'email_log' => array(
                                'type' => 'email_log',
                                'label' => ''
                            ),
                        ))
                    ),
                ))
            ),

        ))
    );
}