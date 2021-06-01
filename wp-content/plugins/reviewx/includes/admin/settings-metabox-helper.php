<?php

function reviewx_settings_metabox_args(){
    return array(
        'id'           => 'rx_metabox_wrapper',
        'title'        => __('ReviewX', 'reviewx'),
        'object_types' => array( 'reviewx' ),
        'context'      => 'normal',
        'priority'     => 'high',
        'show_header'  => false,
        'tabnumber'    => true,
        'layout'       => 'horizontal',
        'tabs'         => apply_filters( 'rx_metabox_tabs', array(
            'source_tab' => array(
                'title'         => __('Criteria', 'reviewx'),
                'icon'          => '',
                'sections'      => apply_filters('rx_source_tab_sections', array(
                     'repeat_field' => array(
                        'title'  => __('Product Review Criteria', 'reviewx'),
                        'fields' => array(
                            'allow_multi_criteria' => array(
                                'heading' => __('Enable Multi-criteria Based Rating System.', 'reviewx'),
                                'label'   => __('Disable this switch to use the default WooCommerce rating system without multi-criteria.', 'reviewx'),
                                'type'    => 'switcher',
                                'default' => 1
                            ),                            
                            'review_criteria' => array(
                                'label' => __('Review on criteria', 'reviewx'),
                                'type'  => 'repeat-field',
                            ),
                        )
                    ),
                )
              )
            ),
            'content_tab' => array(
                'title'         => __('Settings', 'reviewx'),
                'icon'          => '',
                'sections'      => apply_filters('rx_content_tab_sections', array(

                    'order_status' => array(
                        'is_multiple' => true,  
                        'title1'  => __('Enable Order Status', 'reviewx'),
                        'fields1' => apply_filters('rx_builder_wc_order_status', true ), 
                        'title2'  => __('Enable Filter(s)', 'reviewx'),
                        'fields2' => apply_filters('rx_allow_filter_keyword', true ),                                           
                    ),

                    'allow_utilities' => array(
                        'title'  => __('Other Settings', 'reviewx'),
                        'fields' => array(                         
                            'allow_img' => array(
                                'heading' => __('Image Review', 'reviewx' ),
                                'label'  => __('Allow customers to upload the image with review', 'reviewx'),
                                'type'  => 'switcher',
                                'default'	=> 1
                            ), 
                            'allow_recommendation' => array(
                                'heading' => __('Recommendation', 'reviewx'),
                                'label' => __('Allow customers to recommend the products', 'reviewx'),
                                'type'  => 'switcher',
                                'default'	=> 1
                            ),                             
                            'allow_video' => array(
                                'is_pro' => true,
                                'heading' => __( 'Allow Video', 'reviewx'),
                                'label' => __('Allow customers to link the video with review', 'reviewx'),
                                'type'  => 'switcher',
                                'default'	=> 1,
                                'disabled' => true
                            ),
                            'video_source' => array(
                                'heading' => __('Video Source', 'reviewx'),
                                'label'   => __('', 'reviewx'),
                                'options' => array(
                                    'self' => __('Internal', 'reviewx'),
                                    'external' => __('External', 'reviewx'),
                                    'both' => __('Both Internal & External', 'reviewx'),
                                ),                                
                                'type'    => 'select',                              
                            ),                            
                            'allow_anonymouse' => array(
                                'is_pro' => true,
                                'heading' => __('Allow Anonymous Review', 'reviewx'),
                                'label' => __('Allow customer to give review anonymously', 'reviewx'),
                                'type'  => 'switcher',
                                'default'	=> 1,
                                'disabled' => true
                            ),
                            'allow_media_compliance' => array(
                                'heading' => __('Enable Consent Checkbox', 'reviewx'),
                                'label' => __('Allow the shop owner to display a  consent checkbox', 'reviewx'),
                                'type'  => 'switcher',
                                'default'	=> 1
                            ),                             
                            'allow_share_review' => array(
                                'is_pro' => true,
                                'heading' => __('Review Share', 'reviewx'),
                                'label' => __('Allow customer to share review to the social media', 'reviewx'),
                                'type'  => 'switcher',
                                'default'	=> 1
                            ),
                            'allow_like_dislike' => array(
                                'is_pro' => true,
                                'heading' => __( 'Enable Like', 'reviewx' ),
                                'label' => __('Allow customer to react on the review', 'reviewx'),
                                'type'  => 'switcher',
                                'default'	=> 1,
                                'disabled' => true
                            ),
                            'disable_auto_approval' => array(
                                'is_pro' => true,
                                'heading' => __('Review Auto Approval', 'reviewx'),
                                'label' => __('Enable/disable the review auto-approval', 'reviewx'),
                                'type'  => 'switcher',
                                'default'	=> 1,
                            ),   
                            'allow_review_title' => array(
                                'heading' => __('Review Title', 'reviewx'),
                                'label' => __('Enable/disable the review title field', 'reviewx'),
                                'type'  => 'switcher',
                                'default'	=> 1,
                                
                            ),  
                            'allow_multiple_review' => array(
                                'is_pro' => true,
                                'heading' => __('Enable Multiple Review', 'reviewx'),
                                'label' => __('Enable/disable mulitiple review', 'reviewx'),
                                'type'  => 'switcher', 
                                'default'	=> 1,
                                'disabled' => true                               
                            ), 
                            'allow_recaptcha' => array(
                                'heading' => __('Eanble reCAPTCHA', 'reviewx'),
                                'label' => __('Eanble reCAPTCHA', 'reviewx'),
                                'type'  => 'switcher',                             
                            ), 
                            'recaptcha_site_key' => array(
                                'heading' => __('reCAPTCHA Site Key', 'reviewx'),
                                'label' => __('', 'reviewx'),
                                'type'  => 'text',                             
                            ), 
                            'recaptcha_secret_key' => array(
                                'heading' => __('reCAPTCHA Secret Key', 'reviewx'),
                                'label' => __('', 'reviewx'),
                                'type'  => 'text',                             
                            ),   
                            'disable_richschema' => array(
                                'heading' => __('Disable Default Product Schema', 'reviewx'),
                                'label' => __('Disable default product schema', 'reviewx'),
                                'type'  => 'switcher',                             
                            ),                                                                                                                                                                                                                                  
                            'review_per_page' => array(
                                'heading' => __('Pagination for review', 'reviewx'),
                                'label' => __('Disable price from the rich schema', 'reviewx'),
                                'type'  => 'number',
                                'default'	=> 10                                
                            ),                            
                        )
                    ),     
                ))
            ),
            'design_tab' => array(
                'title'      => __('Design', 'reviewx'),
                'icon'       => '',
                'sections'   => apply_filters('rx_design_tab_sections', array(
                    'radio_button' => array(
                        'title'  => __('Graph Style', 'reviewx'),
                        'fields' => array(
                            'graph_style' => array(
                                'type' => 'theme',
                                'priority'=> 4,
                                'default'=>'graph_style_two_free',                                
                                'options'=> apply_filters( 'rx_colored_themes', array(
                                    'graph_style_two_free'=> esc_url(assets('admin/images/themes/graph_style-5.png')),
                                    'graph_style_default' => esc_url(assets('admin/images/themes/graph_style-1.png')),
                                    'graph_style_one'     => esc_url(assets('admin/images/themes/graph_style-2.png')),                                    
                                  ) )
                            ),
                        )
                    ),

                    'review_type' => array(
                        'title'  => __('Photo Review Style', 'reviewx'),
                        'fields' => array(
                            'review_style' => array(
                                'type' => 'theme',
                                'priority'=> 6,
                                'default'=>'review_style_default',
                                'options'=> apply_filters( 'rx_photo_review_style', array(
                                    'review_style_one'     => esc_url(assets('admin/images/themes/review-style-2.jpg')),
                                ) )
                            ),
                        )
                    ),
    
                    'template_style' => array(
                        'title'  => __('Template Style', 'reviewx'),
                        'fields' => array(
                            'template_style' => array(
                                'type' => 'theme',
                                'priority'=> 6,
                                'default'=>'template_style_two',
                                'options'=> apply_filters( 'rx_template_style_style', array(
                                    'template_style_one'     => esc_url(assets('admin/images/themes/template-style-1.jpg')),
                                    'template_style_two'     => esc_url(assets('admin/images/themes/template-style-2.png')),
                                ) )
                            ),
                        )
                    ), 

                    'review_form_position' => array(
                        'title'  => __('Review Form Position', 'reviewx'),
                        'fields' => array(
                            'review_form_position' => array(
                                'type' => 'theme',
                                'priority'=> 6,
                                'default'=>'bottom',
                                'options'=> apply_filters( 'rx_review_form_position_style', array(
                                    'bottom'  => esc_url(assets('admin/images/themes/review-form-position-bottom.png')),
                                    'top'     => array(
                                        'is_pro'            => true,
                                        'source'            => esc_url(assets('admin/images/themes/review-form-position-top.png'))
                                    ),
                                ) )
                            ),
                        )
                    ),

                    'rating_type' => array(
                        'title'  => __('Product Rating Type', 'reviewx'),
                        'fields' => array(
                           'rating_style' => array(
                                'type'                  => 'theme',
                                'priority'              => 5,
                                'default'               => 'rating_style_one',                               
                                'options'               => apply_filters('rx_product_rating_type', array(
                                  'rating_style_one'    => esc_url(assets('admin/images/themes/rating_style-1.jpg')),
                                  'rating_style_two'    => array(
                                    'is_pro'            => true,
                                    'source'            => esc_url(assets('admin/images/themes/rating_style-2.png')),
                                    'title'             => __( 'We calculate the average rating  from this happy-sad  rating & will display as a star rating in individual review', 'reviewx' ),
                                ),    
                                'rating_style_three'     => array(
                                    'is_pro'           => true,
                                    'source'           => esc_url(assets('admin/images/themes/rating_style-3.png')),
                                    'title'            => __( 'We calculate the average rating  from this like-dislike  rating & will display as a star rating in individual review', 'reviewx' ),
                                ),                                                              
                                )),
                            ),                            
                        )
                    ),
    
                    'color_edit' => array(
                        'title'  => __('Theme Color', 'reviewx'),
                        'fields' => array(
                            'color_theme' => array(
                                'type'  => 'colorpicker',
                                'default' => '#2f4fff ',                              
                            ),
                           
                        )
                    ),

                    'icon_upload' => array(
                        'title'  => __('Shop Icon', 'reviewx'),
                        'fields' => array(
                            'icon_upload' => array(
                                'type'  => 'media',                             
                            ),                           
                        )
                    ), 

                    'recommend_icon_upload' => array(
                        'title'  => __('Recommended Icon', 'reviewx'),
                        'fields' => array(
                            'recommend_icon_upload' => array(
                                'type'  => 'media',                             
                            ),                           
                        )
                    ),                                       
                ))
            ),
            'email_tab' => array(
                'title'      => __('Email', 'reviewx'),
                'icon'       => '',
                'sections'   => apply_filters('rx_design_tab_sections', array(
                    'image' => array(
                        'title'    => __('Create an email who did not review yet', 'reviewx'),
                        'priority' => 100,
                        'fields'   => array(
                            'email_subject'  => array(
                                'type'      => 'email_subject',
                                'label'     => '',
                                'priority'	=> 5,
                                'default'   => __('Your Feedback Means a Lot to Us!', 'reviewx' )
                            ),
                            'email_editor'  => array(
                                'type'      => 'editor',
                                'label'     => '',
                                'priority'	=> 6,
                            ),
                            'email_preset_placeholder'  => array(
                                'type'      => 'email_presets',
                                'label'     => '',
                                'priority'	=> 7,
                            ),

                        )
                    ),
                ))
            ),
            'display_tab' => array(
                'title'         => __('Overview', 'reviewx'),
                'icon'          => '',
                'sections'      => apply_filters('rx_display_tab_sections', array(
                    'preview' => array(
                        'title'    => __('Setting Preview', 'reviewx'),
                        'priority' => 100,
                        'fields'   => array(
                            'show_default_image'  => array(
                                'type'      => 'checkbox',
                                'label'     => __('Show Default Image' , 'reviewx'),
                                'priority'	=> 5,
                                'toggle'	=> [
                                    '1' => [
                                        'fields' => [ 'image_url' ]
                                    ]
                                ],
                                'description' => __('If checked, this will show in reviewxs.', 'reviewx'),
                            ),
                            
                        )
                    ),
                    
                ))
            ),
        ))
    );
}