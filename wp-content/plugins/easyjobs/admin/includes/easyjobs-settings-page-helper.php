<?php
function easyjobs_settings_args(){
    $settings_tabs = array(
        'general' => array(
            'title' => __( 'General', EASYJOBS_TEXTDOMAIN ),
            'priority' => 10,
            'button_text' => __( 'Save Settings', EASYJOBS_TEXTDOMAIN ),
            'sections' => apply_filters('easyjobs_general_settings_sections', array(
                'general_settings' => apply_filters('easyjobs_general_settings', array(
                    'title' => __( 'General Settings', 'easyjobs' ),
                    'priority' => 10,
                    'fields' => array(
                        'easyjobs_api_key' => array(
                            'type'        => 'text',
                            'label'       => __('Api Key' , EASYJOBS_TEXTDOMAIN),
                            'priority'    => 11,
                            'help' => 'Don\'t have a API Key? <a href="https://app.easy.jobs/login" target="_blank">Sign Up</a> to get started.'
                        ),

                    ),
                )),
            )),
        ),
        'design' => array(
            'title' => __( 'Design', EASYJOBS_TEXTDOMAIN ),
            'priority' => 10,
            'sections' => apply_filters('easyjobs_design_settings_sections', array(
                'general_settings' => apply_filters('easyjobs_design_settings', array(
                    'title' => __( 'Design', 'easyjobs' ),
                    'priority' => 10,
                    'fields' => array(
                        'design_html' => array(
                            'type'        => 'func',
                            'view' => 'EasyJobs_Settings::design_tab_content'
                        ),
                    ),
                )),
            )),
        ),
        /*'packages' => array(
            'title' => __( 'Packages', 'easyjobs' ),
            'priority' => 10,
            'sections' => apply_filters('easyjobs_pkgs_settings_sections', array(
                'pkgs' => apply_filters('easyjobs_pkgs_settings', array(
                    'title' => __( 'General Settings', 'easyjobs' ),
                    'priority' => 10,
                    'fields' => array(
                        'pkgs_html' => array(
                            'type'        => 'func',
                            'view' => 'EasyJobs_Settings::package_tab_content'
                        ),


                    ),
                )),
            )),
        )*/
    );
    if(Easyjobs_Helper::is_api_connected()){
        $settings_tabs['general'] = array(
            'title' => __( 'General', EASYJOBS_TEXTDOMAIN ),
            'priority' => 10,
            'button_text' => __( 'Save Settings', EASYJOBS_TEXTDOMAIN ),
            'additional_footer_link' => array(
                'text' => __( 'Disconnect Api', EASYJOBS_TEXTDOMAIN ),
                'link' => '#',
            ),
            'sections' => apply_filters('easyjobs_general_settings_sections', array(
                'general_settings' => apply_filters('easyjobs_general_settings', array(
                    'title' => __( 'General Settings', 'easyjobs' ),
                    'priority' => 10,
                    'fields' => array(
                        'easyjobs_api_key' => array(
                            'type'        => 'text',
                            'label'       => __('Api Key' , EASYJOBS_TEXTDOMAIN),
                            'priority'    => 11,
                            'help' => 'Don\'t have a API Key? <a href="https://app.easy.jobs/login" target="_blank">Sign Up</a> to get started.'
                        ),
            
                    ),
                )),
            )),
        );
        $settings_tabs['shortcodes'] = array(
            'title' => __( 'Shortcodes', 'easyjobs' ),
            'priority' => 10,
            'sections' => apply_filters('easyjobs_shortcodes_settings_sections', array(
                'pkgs' => apply_filters('easyjobs_shortcodes_settings', array(
                    'title' => __( 'General Settings', 'easyjobs' ),
                    'priority' => 10,
                    'fields' => array(
                        'shortcodes_html' => array(
                            'type'        => 'func',
                            'view' => 'EasyJobs_Settings::shortcodes_tab_content'
                        ),
                    ),
                )),
            )),
        );
    }
    return apply_filters('easyjobs_settings_tab', $settings_tabs);
}