<?php
function crowdfundly_settings_args(){
    $settings_tabs = array(
        'general' => array(
            'title' => __( 'General', 'crowdfundly' ), 
            'icon'  => '<i class="fas fa-home"></i>',
            'priority' => 10,
            'sections' => apply_filters('crowdfundly_general_settings_sections', array(
                'general_settings' => apply_filters('crowdfundly_general_settings', array( 
                    'title' => __( 'General Settings', 'crowdfundly' ),
                    'priority' => 10,
                    'fields' => array(
                        'crowdfundly_api_key' => array(
                            'type'        => 'text',
                            'label'       => __('API Key' , 'crowdfundly'),  
                            'priority'    => 11,
                            'help'        => ''
                        ),
                    ),
                )),
            )),
        ),
        'design' => array(
            'title' => __( 'Design', 'crowdfundly' ),
            'icon'  => '<i class="fas fa-ruler-vertical"></i>',
            'priority' => 10,
            'sections' => apply_filters('crowdfundly_design_settings_sections', array(
                'general_settings' => apply_filters('crowdfundly_design_settings', array(
                    'title' => __( 'Design', 'crowdfundly' ),
                    'priority' => 10,
                    'fields' => array(
                        'design_html' => array(
                            'type'        => 'func',
                            'view' => 'Crowdfundly_Settings::design_tab_content'
                        ),
                    ),
                )),
            )),
        ),
    );
    if(Crowdfundly_Settings::hasToken()){
        $settings_tabs['general'] = array(
            'title' => __( 'General', 'crowdfundly' ),
            'icon'  => '<i class="fas fa-home"></i>',
            'priority' => 10,
            'additional_footer_link' => array(
                'text' =>  !empty(Crowdfundly_Settings::is_email_log_in())?__( 'Logout', 'crowdfundly' ):__( 'Disconnect API', 'crowdfundly' ),
                'link' => '#',
            ),
            
            'sections' => empty(Crowdfundly_Settings::is_email_log_in())?apply_filters('crowdfundly_general_settings_sections', array(
                'general_settings' => apply_filters('crowdfundly_general_settings', array(
                    'title' => __( 'General Settings', 'crowdfundly' ),
                    'priority' => 10,
                    'fields' => array(
                        'api_key' => array(
                            'type'        => 'text',
                            'label'       => __('API Key' , 'crowdfundly'),
                            'priority'    => 11,
                            'help'        => ''
                        ),            
                    ),
                )),
            )):'',
        );
        $settings_tabs['shortcodes'] = array(
            'title' => __( 'Shortcodes', 'crowdfundly' ),
            'icon'  => '<i class="fas fa-bezier-curve"></i>',
            'priority' => 10,
            'sections' => apply_filters('crowdfundly_shortcodes_settings_sections', array(
                'pkgs' => apply_filters('crowdfundly_shortcodes_settings', array(
                    'title' => __( 'General Settings', 'crowdfundly' ),
                    'priority' => 10,
                    'fields' => array(
                        'shortcodes_html' => array(
                            'type'        => 'func',
                            'view' => 'Crowdfundly_Settings::shortcodes_tab_content'
                        ),
                    ),
                )),
            )),
        );
        $settings_tabs['payment_settings'] = array(
            'title' => __( 'Settings', 'crowdfundly' ),
            'icon'  => '<i class="fas fa-cogs"></i>',
            'priority' => 10,
            'button_text' => __( 'Save Settings', 'crowdfundly' ),
            'sections' => apply_filters('crowdfundly_payment_settings_sections', array(
                'pkgs' => apply_filters('crowdfundly_payment_settings', array(
                    'title' => __( 'Settings', 'crowdfundly' ),
                    'priority' => 10,
                    'fields' => array(
                        'wc_payment' => array(
                            'type'        => 'checkbox',
                            'label'       => __('WooCommerce Payment' , 'crowdfundly'),
                            'priority'    => 13,
                            'help'        => __('Enable to accept fund using WooCommerce payment gateway', 'crowdfundly'),
                            'default'	  => 1,
                            'depends'     => array(
                                'required'      => 'WooCommerce',
                                'description'   => __('*You have to install WooCommerce to enable this feature', 'crowdfundly'),
                            )  
                        ),
                        'disable_automatice_shortcode_page' => array(
                            'type'        => 'checkbox',
                            'label'       => __('Disable Automatic Create Shortcode Pages' , 'crowdfundly'),
                            'priority'    => 14,
                            'help'        => __('Disable automatic create shortcode pages', 'crowdfundly'), 
                        ),                        
                        'crowdfundly_organization_slug' => array(
                            'type'        => 'text',
                            'label'       => __('Organization Page Slug' , 'crowdfundly'),
                            'priority'    => 15,
                            'default'     => 'crowdfundly-organization'  
                        ),
                        'crowdfundly_all_campaign_slug' => array(
                            'type'        => 'text',
                            'label'       => __('All Campaign Page Slug' , 'crowdfundly'),
                            'priority'    => 16,
                            'default'       => 'crowdfundly-all-campaigns'
                        ),
                        'crowdfundly_single_campaign_slug' => array(
                            'type'        => 'text',
                            'label'       => __('Single Campaign Page Slug' , 'crowdfundly'),
                            'priority'    => 17,
                            'default'     => 'crowdfundly-single-campaign'
                        ),                                                                        
                    ),
                )),
            )),
        );        
    }
    return apply_filters('crowdfundly_settings_tab', $settings_tabs);  
}