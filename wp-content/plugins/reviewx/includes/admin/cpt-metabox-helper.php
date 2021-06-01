<?php

function reviewx_cpt_metabox_args() {
    return array(
        'id'           => 'rx_metabox_wrapper',
        'title'        => __('ReviewX - Advanced Multi-criteria Rating & Reviews for WooCommerce', 'reviewx'),
        'object_types' => array( 'reviewx' ),
        'context'      => 'normal',
        'priority'     => 'high',
        'show_header'  => false,
        'tabnumber'    => true,
        'layout'       => 'horizontal',
        'tabs'         => apply_filters( 'rx_metabox_builder_tabs', array(
            'source_tab' => array(
                'title'         => __('Criteria', 'reviewx'),
                'icon'          => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve"> <g><path class="st0" d="M65,26.3c-8.5,0-17.1,0-25.6,0c-3,0-4.1-1-4.1-4c0-5.3,0-10.6,0-15.9c0-2.8,1-3.8,3.8-3.8c17.2,0,39.8,0,57,0 c2.8,0,3.8,1,3.8,3.8c0,5.4,0,10.7,0,16.1c0,2.8-1,3.8-3.8,3.8C87.6,26.3,73.6,26.3,65,26.3z"></path> <path class="st0" d="M64.9,38.1c8.5,0,22.5,0,31,0c3.1,0,4.1,1,4.1,4c0,5.3,0,10.6,0,15.9c0,2.8-1,3.8-3.8,3.8c-17.2,0-39.8,0-57,0 c-2.8,0-3.8-1-3.9-3.8c0-5.4,0-10.7,0-16.1c0-2.8,1-3.8,3.8-3.8C47.8,38.1,56.4,38.1,64.9,38.1z"></path> <path class="st0" d="M65,97.4c-8.5,0-17.1,0-25.6,0c-3.1,0-4.1-1-4.1-4c0-5.3,0-10.6,0-15.9c0-2.8,1.1-3.8,4-3.9 c17.1,0,39.6,0,56.8,0c2.8,0,3.8,1.1,3.9,3.8c0,5.4,0,10.7,0,16.1c0,2.8-1,3.8-3.8,3.8C87.6,97.4,73.6,97.4,65,97.4z"></path> <path class="st0" d="M23.5,14.6c0,2.7,0,5.5,0,8.2c0,2.4-1.1,3.5-3.5,3.5c-5.6,0-11.1,0-16.7,0c-2.4,0-3.5-1.1-3.5-3.5 c0-5.6,0-11.1,0-16.7c0-2.4,1.1-3.5,3.5-3.5c5.6,0,11.1,0,16.7,0c2.4,0,3.5,1.1,3.5,3.5C23.5,8.9,23.5,11.8,23.5,14.6z"></path> <path class="st0" d="M11.6,38.1c2.7,0,5.5,0,8.2,0c2.5,0,3.6,1.1,3.6,3.6c0,5.5,0,11,0,16.5c0,2.5-1.1,3.6-3.6,3.6 c-5.6,0-11.1,0-16.7,0c-2.2,0-3.4-1.2-3.4-3.4c0-5.6,0-11.3,0-16.9c0-2.3,1.2-3.4,3.6-3.4C6.1,38.1,8.9,38.1,11.6,38.1z"></path> <path class="st0" d="M23.5,85.4c0,2.8,0,5.6,0,8.4c0,2.5-1.1,3.6-3.6,3.6c-5.5,0-11,0-16.5,0c-2.5,0-3.6-1.1-3.6-3.6 c0-5.5,0-11,0-16.5c0-2.5,1.1-3.6,3.7-3.6c5.5,0,11,0,16.5,0c2.5,0,3.5,1.1,3.6,3.6C23.5,80,23.5,82.7,23.5,85.4z"></path></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>',
                'sections'      => apply_filters('rx_source_tab_sections', array(    
                     'repeat_field' => array(
                        'title'  => __('Product Review Criteria', 'reviewx'),
                        'fields' => array(
                            'custom_post_types' => array(
                                'heading' => __('Custom Post Type', 'reviewx'),
                                'label'   => __('Select custom post type to enable review', 'reviewx'),
                                'options' => \ReviewX_Helper::get_custom_post_types(),                                
                                'type'    => 'select',                              
                            ),
                            'allow_multi_criteria' => array(
                                'heading' => __('Enable Multi-criteria Based Rating System.', 'reviewx'),
                                'label'   => __('Disable this switch to use the classic star rating system without multi-criteria.', 'reviewx'),
                                'type'    => 'switcher',
                                'default' => 1
                            ),                         
                            'review_criteria' => array(
                                'type'  => 'repeat-field',                                
                            ),                           
                        )
                    ),
                )
              )
            ),
            'content_tab' => array(
                'title'         => __('Settings', 'reviewx'),
                'icon'          => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve"> <path class="st0" d="M89.9,77.8c-0.5,0.9-0.8,1.8-1.4,2.4c-2.5,2.6-5.1,5.2-7.7,7.8c-1.4,1.4-2.9,1.4-4.5,0.4 c-2.3-1.4-4.6-2.8-6.9-4.1c-0.7-0.4-1.6-0.2-2.4-0.2c-0.1,0-0.1,0.1-0.2,0.1c-4.2,0.9-6.3,3.6-6.5,7.9c-0.1,1.7-0.8,3.3-1.2,5 c-0.5,1.9-1.6,2.9-3.6,2.9c-3.5,0-7,0-10.5,0c-1.9,0-3.1-0.9-3.5-2.7c-0.8-3-1.6-6-2.2-9.1c-0.3-1.4-1.2-1.9-2.3-2.6 c-3.5-2.3-6.4-1.1-9.5,0.9c-6,4-5.5,3.4-10.3-1.3c-1.5-1.5-3-3.1-4.6-4.6c-1.6-1.5-1.8-3.1-0.6-5c1.3-2.1,2.6-4.1,3.8-6.3 c0.4-0.8,0.3-1.9,0.2-2.8c-0.7-4.3-3.6-6-7.7-6.4c-1.7-0.2-3.3-0.8-5-1.2c-2-0.5-3-1.6-3-3.8c0.1-3.4,0.1-6.8,0-10.3 c0-2,0.9-3.2,2.8-3.7c3-0.7,5.9-1.5,8.9-2.2c1.4-0.3,2-1,2.7-2.2c1.7-2.9,1.2-5.3-0.7-7.9c-1.2-1.7-2.2-3.5-3.2-5.3 c-0.9-1.5-0.7-2.9,0.5-4.1c2.6-2.6,5.1-5.2,7.7-7.7c1.4-1.4,2.9-1.4,4.5-0.4c2.5,1.5,4.9,3.1,7.5,4.4c0.6,0.4,1.6,0.2,2.4,0.2 c0.4,0,0.8-0.5,1.2-0.6c3.8-0.6,5.1-3.2,5.5-6.7c0.2-2,1-4,1.5-6.1C41.9,0.9,43,0,44.8,0c3.6,0,7.1,0,10.7,0c1.9,0,3,1,3.5,2.8 c0.8,3,1.6,6,2.2,9.1c0.3,1.3,1.1,1.8,2.1,2.5c3.5,2.3,6.3,1.2,9.5-0.9c6.6-4.4,5.9-3.7,11,1.3c1.5,1.5,2.9,3,4.4,4.4 c1.4,1.4,1.6,2.9,0.6,4.6c-1.4,2.2-2.6,4.5-4,6.7c-0.7,1.1-0.5,2-0.3,3.3c1,4.1,3.7,5.6,7.6,6c1.8,0.2,3.5,0.9,5.2,1.3 c1.9,0.5,2.9,1.6,2.9,3.7c0,3.5,0,7,0,10.5c0,1.9-0.9,3.1-2.7,3.5c-3,0.8-6,1.6-9.1,2.2c-1.3,0.3-1.9,1-2.5,2.1 c-2.1,3.4-1.4,6.3,0.9,9.3C87.9,74,88.8,75.9,89.9,77.8z M50,70.5c11.1,0.2,20.4-8.9,20.6-20.1c0.2-11.4-8.8-20.7-20.2-20.9 c-11.2-0.2-20.6,9-20.7,20.2C29.6,61.1,38.6,70.3,50,70.5z"></path><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>',
                'sections'      => apply_filters('rx_content_tab_sections', array(
                    'order_status' => array(
                        'is_multiple' => true,
                        'title1'  => __('Enable Filter(s)', 'reviewx'),
                        'fields1' => apply_filters('rx_allow_filter_keyword', true ),                                                                     
                    ),                     
                    'allow_utilities' => array(
                        'title'  => __('Settings', 'reviewx'),
                        'fields' => array(                            
                            'allow_img' => array(
                                'heading' => __('Image Review', 'reviewx'),
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
                                'heading' => __('Allow Video', 'reviewx'),
                                'label' => __('Allow customers to link the video with review', 'reviewx'),
                                'type'  => 'switcher',
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
                                'default'	=> 'both'                                
                            ),                             
                            'allow_anonymouse' => array(
                                'is_pro' => true,
                                'heading' => __('Allow Anonymous Review', 'reviewx'),
                                'label' => __('Allow customer to give review anonymously', 'reviewx'),
                                'type'  => 'switcher',
                                'disabled' => true
                            ),
                            'allow_media_compliance' => array(
                                'heading' => __('Enable Consent Checkbox', 'reviewx'),
                                'label' => __('Allow the shop owner to display a  consent checkbox', 'reviewx'),
                                'type'  => 'switcher',
                            ),                             
                            'allow_share_review' => array(
                                'is_pro' => true,
                                'heading' => __('Review Share', 'reviewx'),
                                'label' => __('Allow customer to share review to the social media', 'reviewx'),
                                'type'  => 'switcher',
                                'disabled' => true
                            ),
                            'allow_like_dislike' => array(
                                'is_pro' => true,
                                'heading' => __('Enable Like', 'reviewx'),
                                'label' => __('Allow customer to react on the review', 'reviewx'),
                                'type'  => 'switcher',
                                'disabled' => true
                            ),
                            'disable_auto_approval' => array(
                                'is_pro' => true,
                                'heading' => __('Review Auto Approval', 'reviewx'),
                                'label' => __('Enable/disable the review auto-approval', 'reviewx'),
                                'type'  => 'switcher',
                                'default'	=> 1
                            ), 
                            'allow_review_title' => array(
                                'heading' => __('Review Title', 'reviewx'),
                                'label' => __('Enable/disable the review title field', 'reviewx'),
                                'type'  => 'switcher',
                                'default'	=> 1
                            ),  
                            'allow_multiple_review' => array(
                                'is_pro' => true,
                                'heading' => __('Enable Multiple Review', 'reviewx'),
                                'label' => __('Enable/disable mulitiple review', 'reviewx'),
                                'type'  => 'switcher',
                                'disabled' => true                                
                            ), 
                            'allow_recaptcha' => array(
                                'heading' => __('Enable reCAPTCHA', 'reviewx'),
                                'label' => __('Enable reCAPTCHA with review', 'reviewx'),
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
                            'review_per_page' => array(
                                'heading' => __('Pagination for review', 'reviewx'),
                                'label' => __('Display review per page', 'reviewx'),
                                'type'  => 'number',
                                'default'	=> 10                                
                            ),                            
                        )
                    ), 
                ))
            ),
            'design_tab' => array(
                'title'      => __('Design', 'reviewx'),
                'icon'       => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve"><path class="st0" d="M50,0C22.4,0,0,22.4,0,50s22.4,50,50,50c4.6,0,8.3-3.7,8.3-8.3c0-2.2-0.8-4.1-2.2-5.6c-1.3-1.5-2.1-3.4-2.1-5.5 c0-4.6,3.7-8.3,8.3-8.3h9.8c15.3,0,27.8-12.4,27.8-27.8C100,19.9,77.6,0,50,0z M19.4,50c-4.6,0-8.3-3.7-8.3-8.3s3.7-8.3,8.3-8.3 s8.3,3.7,8.3,8.3S24.1,50,19.4,50z M36.1,27.8c-4.6,0-8.3-3.7-8.3-8.3s3.7-8.3,8.3-8.3s8.3,3.7,8.3,8.3S40.7,27.8,36.1,27.8z M63.9,27.8c-4.6,0-8.3-3.7-8.3-8.3s3.7-8.3,8.3-8.3s8.3,3.7,8.3,8.3S68.5,27.8,63.9,27.8z M80.6,50c-4.6,0-8.3-3.7-8.3-8.3 s3.7-8.3,8.3-8.3c4.6,0,8.3,3.7,8.3,8.3S85.2,50,80.6,50z"/><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>',
                'sections'   => apply_filters('rx_design_tab_sections', array(

                    'radio_button' => array(
                        'title'  => __('Graph Style', 'reviewx'),
                        'fields' => array(
                            'graph_style' => array(
                                'type' => 'theme',
                                'priority'=> 4,
                                'default'=>'graph_style_two_free',                                
                                'options'=> apply_filters( 'rx_colored_themes', array(
                                    'graph_style_two_free'  => esc_url(assets('admin/images/themes/graph_style-5.png')),
                                    'graph_style_default'   => esc_url(assets('admin/images/themes/graph_style-1.png')),
                                    'graph_style_one'       => esc_url(assets('admin/images/themes/graph_style-2.png')),                                    
                                    // 'graph_style_two'       => array(
                                    //     'is_pro'            => true,
                                    //     'source'            => esc_url(assets('admin/images/themes/graph_style-3.png'))
                                    // ),
                                    'graph_style_three'     => array(
                                        'is_pro'            => true,
                                        'source'            => esc_url(assets('admin/images/themes/graph_style-4.png'))
                                    ),                                                                                                          
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
                                    'review_style_default' => esc_url(assets('admin/images/themes/photo-style.png')),
                                    'review_style_one'     => esc_url(assets('admin/images/themes/photo-style-2.png')),
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
                                    'template_style_one'     => esc_url(assets('admin/images/themes/template-style-1.png')),
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
                                  'rating_style_one'    => esc_url(assets('admin/images/themes/rating_style-1.png')),
                                  'rating_style_two'    => array(
                                    'is_pro'            => true,
                                    'source'            => esc_url(assets('admin/images/themes/rating_style-2.png')),
                                    'title'            => __( 'We calculate the average rating  from this like-dislike  rating & will display as a star rating in individual review', 'reviewx' ),
                                    
                                ),    
                                'rating_style_three'     => array(
                                    'is_pro'           => true,
                                    'source'           => esc_url(assets('admin/images/themes/rating_style-3.png')),
                                    'title'             => __( 'We calculate the average rating  from this happy-sad  rating & will display as a star rating in individual review', 'reviewx' ),
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
                        'title'  => __('Admin Reply Icon', 'reviewx'),
                        'fields' => array(
                            'icon_upload' => array(
                                'is_pro' => true,
                                'type'  => 'media',                             
                            ),                           
                        )
                    ),

                    'recommend_icon_upload' => array(
                        'title'  => __('Recommended Icon', 'reviewx'),
                        'fields' => array(
                            'recommend_icon_upload' => array(
                                'is_pro' => true,
                                'type'  => 'media',                             
                            ),                           
                        )
                    ),                    
                ))
            ),
            'display_tab' => array(
                'title'         => __('Overview', 'reviewx'),
                'icon'          => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve"><g><path class="st0" d="M98.5,60.5L82.4,17.6c0,0,0,0,0,0l0,0c-2.1-5.7-7.6-9.5-13.7-9.5c-6,0-11.5,3.8-13.7,9.5 c-0.6,1.6-0.9,3.4-0.9,5.1v18.8h-8.3V22.7c0-8.1-6.6-14.6-14.6-14.6c-6,0-11.5,3.8-13.7,9.5c0,0,0,0,0,0L1.3,60.5c0,0,0,0,0,0 c-1,2.6-1.5,5.3-1.5,8.1c0,12.7,10.3,22.9,22.9,22.9c12.7,0,22.9-10.3,22.9-22.9v-2.1h8.3v2.1c0,12.7,10.3,22.9,22.9,22.9 c12.6,0,22.9-10.3,22.9-22.9C100,65.8,99.5,63.1,98.5,60.5L98.5,60.5z M22.8,83.2c-8.1,0-14.6-6.6-14.6-14.6c0-1.8,0.3-3.5,0.9-5.1 c2.1-5.7,7.6-9.5,13.7-9.5c8.1,0,14.6,6.6,14.6,14.6C37.4,76.7,30.9,83.2,22.8,83.2L22.8,83.2z M77.1,83.2 c-8.1,0-14.6-6.6-14.6-14.6C62.5,60.6,69,54,77.1,54c6,0,11.5,3.8,13.7,9.5c0.6,1.6,0.9,3.4,0.9,5.1C91.7,76.7,85.1,83.2,77.1,83.2 L77.1,83.2z M77.1,83.2"/></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>',
                'sections'      => apply_filters('rx_display_tab_sections', array(
                    'image' => array(
                        'title'    => __('Setting Preview', 'reviewx'),
                        'priority' => 100,
                        'fields'   => array(
                            'show_settings_preview'  => array(
                                'type'      => 'preview',
                                'label'     => '',
                                'priority'	=> 5,
                                'content'   => apply_filters('rx_pro_feature_overview', array(
                                    array(
                                        'id'    => 'action_custom_post_type',
                                        'icon'  => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve"><g><g><path class="st0" d="M20.9,61.6c1.1,1.1,1.6,2.6,1.4,4.1l-4.7,26.5c-0.4,2.5,1.2,4.8,3.7,5.3c1,0.2,2,0,2.8-0.4l23.7-12.7 c1.4-0.7,3-0.7,4.4,0l23.7,12.7c2.2,1.2,5,0.4,6.2-1.8c0.5-0.9,0.7-2,0.5-3l-4.7-26.5c-0.3-1.5,0.2-3.1,1.4-4.1l19.4-18.7 c1.8-1.8,1.9-4.7,0.1-6.5c-0.7-0.7-1.7-1.2-2.7-1.4l-26.6-3.7c-1.5-0.2-2.8-1.2-3.5-2.5L54.1,4.6C53,2.4,50.3,1.4,48,2.6 c-0.9,0.4-1.6,1.2-2.1,2.1L34.2,28.9c-0.7,1.4-2,2.3-3.6,2.5L4,35.1c-2.5,0.3-4.3,2.7-3.9,5.2c0.1,1,0.6,2,1.4,2.7L20.9,61.6z"/></g></g></svg>',
                                        'label' =>  __('Custom Post Type', 'reviewx'),
                                        'value' => '',
                                    ),
                                    array(
                                        'id'    => 'action_multi_criteria',
                                        'icon'  => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve"><path class="st0" d="M48.7,1.2v30.9c0,0.7-0.6,1.2-1.2,1.2H25.2c-0.7,0-1.2,0.6-1.2,1.2v10.5v21.7v0H2.8c-0.7,0-1.2,0.6-1.2,1.2 v30.9c0,0.7,0.6,1.2,1.2,1.2H97c0.7,0,1.2-0.6,1.2-1.2v-7.5V66.7v0V45.1V33.4v0V1.2C98.3,0.5,97.7,0,97,0H49.9 C49.3,0,48.7,0.5,48.7,1.2z"/></svg>',
                                        'label' =>  __('Multi Criteria', 'reviewx'),
                                        'value' => '',
                                    ),                                                                          
                                    array(
                                        'id'    => 'action_image_allowed',
                                        'icon'  => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve"><g><path class="st0" d="M37.1,46.5c5.5,0,10-4.5,10-10c0-5.5-4.5-10-10-10c-5.5,0-10,4.5-10,10C27.1,42,31.6,46.5,37.1,46.5L37.1,46.5 z M37.1,46.5"/><path class="st0" d="M93.8,15c0-8.3-6.7-15-15-15H22.2c-8.3,0-15,6.7-15,15v70c0,8.3,6.7,15,15,15h56.6c8.3,0,15-6.7,15-15V15z M22.2,10h56.6c2.8,0,5,2.2,5,5v38.7L73.4,43.4c-3.4-3.4-9-3.4-12.4,0L37.2,67.2l-6.3-6.3c-3.4-3.4-9-3.4-12.4,0l-1.3,1.3V15 C17.2,12.2,19.4,10,22.2,10L22.2,10z M22.2,10"/></g></svg>',
                                        'label' =>  __('Allow image with review', 'reviewx'),
                                        'value' => '',
                                    ), 
                                    array(
                                        'id'    => 'action_recommendation_feature',
                                        'icon'  => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve"><path class="st0" d="M50.1,0c-27.6,0-50,22.4-50,50s22.4,50,50,50s50-22.4,50-50S77.7,0,50.1,0z M53.7,72.2l-3.7,3.3l-3.7-3.3 c-13-11.8-21.5-19.5-21.5-29c0-7.8,6.1-13.8,13.8-13.8c4.4,0,8.6,2,11.3,5.2c2.7-3.2,6.9-5.2,11.3-5.2c7.8,0,13.8,6.1,13.8,13.8 C75.3,52.6,66.7,60.4,53.7,72.2z"/></svg>',
                                        'label' =>  __('Allow recommendation feature', 'reviewx'),
                                        'value' => '',
                                    ), 
                                    array(
                                        'id'    => 'action_pagination_per_page',
                                        'icon'  => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve"><path class="st0" d="M96.7,0.5H20.1c-1.7,0-3,1.3-3,3l-0.7,66.8H3.1c-1.7,0-3,1.3-3,3v9c0,9.1,7.3,16.8,16.5,17.1H82 c0.3,0,0.7,0,0.9,0c9.4,0,17.1-7.7,17.1-17.1V3.6C99.9,1.8,98.5,0.5,96.7,0.5z M60.2,18.8V25H32.4l-0.1-6.2H60.2z M17.1,93.5 c-6.1,0-10.8-5-10.8-10.8v-6h59.5v6c0,4,1.3,7.9,4,10.8H17.1z M82.7,57.1H32.4v-6.2h50.3V57.1z M82.7,41.1H32.4v-6.2h50.3V41.1z"/></svg>',
                                        'label' =>  __('Display review per page', 'reviewx'),
                                        'value' => '',
                                    ), 
                                    array(
                                        'id'    => 'action_graph_style',
                                        'icon'  => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve"><g><path class="st0" d="M41.1,8.8C30.5,9.7,20.7,14.4,13,22.1C-5,40-5,68.6,13,86.5c17.9,17.9,46.6,17.9,64.5,0 c7.7-7.7,12.3-17.5,13.2-28.1H41.1L41.1,8.8z"/><path class="st0" d="M59.6,0c-1.6,0-2.9,1.3-2.9,2.9l0.1,37.2c0,1.6,1.3,2.9,2.9,2.9h37.2c1.6,0,2.9-1.3,2.9-2.9 C99.7,18.1,81.7,0,59.6,0L59.6,0z M59.6,0"/></g></svg>',
                                        'label' =>  __('Graph Style type', 'reviewx'),
                                        'value' => '',
                                    ), 
                                    array(
                                        'id'    => 'action_rating_type',
                                        'icon'  => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve"><g><g><path class="st0" d="M20.9,61.6c1.1,1.1,1.6,2.6,1.4,4.1l-4.7,26.5c-0.4,2.5,1.2,4.8,3.7,5.3c1,0.2,2,0,2.8-0.4l23.7-12.7 c1.4-0.7,3-0.7,4.4,0l23.7,12.7c2.2,1.2,5,0.4,6.2-1.8c0.5-0.9,0.7-2,0.5-3l-4.7-26.5c-0.3-1.5,0.2-3.1,1.4-4.1l19.4-18.7 c1.8-1.8,1.9-4.7,0.1-6.5c-0.7-0.7-1.7-1.2-2.7-1.4l-26.6-3.7c-1.5-0.2-2.8-1.2-3.5-2.5L54.1,4.6C53,2.4,50.3,1.4,48,2.6 c-0.9,0.4-1.6,1.2-2.1,2.1L34.2,28.9c-0.7,1.4-2,2.3-3.6,2.5L4,35.1c-2.5,0.3-4.3,2.7-3.9,5.2c0.1,1,0.6,2,1.4,2.7L20.9,61.6z"/></g></g></svg>',
                                        'label' =>  __('Product rating type', 'reviewx'),
                                        'value' => '',
                                    ), 
                                    array(
                                        'id'    => 'action_color_theme',
                                        'icon'  => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve"><g><path class="st0" d="M42.3,74.1c-0.2,0-0.3,0-0.5,0.1c-0.2,0.5-0.5,1.1-0.9,1.6c-4.6,6.4-9.2,12.8-13.8,19l-3.7,5.1 c17.9,0,35.5,0,53.2,0c-3.7-5-7.3-10-8.2-11.2c-0.8-1-1.5-2.1-2.3-3.1c-2.3-3.1-4.6-6.2-6.8-9.5c-0.4-0.6-0.8-1.3-1.1-2 c-0.2,0-0.3,0-0.4,0C52.7,74,47.5,74,42.3,74.1z"/> <path class="st0" d="M30.7,54.6c-0.1-0.2-0.2-0.5-0.3-0.6c-0.6-0.1-1.3-0.2-1.9-0.4c-8.1-2.6-16.3-5.2-24.2-7.8l-4.1-1.3 c-0.1,0-0.2-0.1-0.3-0.1C5.5,61.2,10.9,77.9,16.5,95l2.1-2.9c1.9-2.6,3.7-5.1,5.5-7.5c0.7-1,1.4-1.9,2.1-2.9 c2.5-3.4,5.1-7,7.7-10.4c0.5-0.6,1-1.1,1.6-1.6c0-0.2-0.1-0.4-0.1-0.6C33.9,64.1,32.2,59.4,30.7,54.6z"/><path class="st0" d="M93.1,46.6l-3.7,1.2c-5.7,1.9-11.7,3.8-17.6,5.6c-0.7,0.2-1.4,0.4-2.2,0.4c-0.1,0.1-0.1,0.3-0.2,0.4 c-1.7,4.8-3.3,9.6-4.7,14.5c-0.1,0.2-0.1,0.4-0.1,0.6c0.5,0.4,0.9,0.9,1.3,1.4c5,6.8,10,13.7,14.9,20.4l2.6,3.6 c0,0.1,0.1,0.1,0.1,0.2C89,77.9,94.4,61.3,100,44.3c-0.6,0.2-1.2,0.4-1.7,0.6C96.4,45.5,94.8,46.1,93.1,46.6z"/> <path class="st0" d="M54.3,37.2c4.1,3.1,8.2,6.1,12.4,9c0.1,0.1,0.3,0.2,0.4,0.2c0.5-0.3,1.1-0.6,1.7-0.8c7.7-2.6,15.4-5.1,23.5-7.7l5-1.6C82.7,25.7,68.5,15.4,54.2,5c0,0.5,0.1,1.1,0.1,1.7c0,2.9,0,5.7,0,8.6c0,6.3,0,12.7,0,19.1 c0,0.9-0.1,1.8-0.3,2.6C54.1,37,54.2,37.1,54.3,37.2z"/><path class="st0" d="M45.4,37.5c0.2-0.2,0.4-0.3,0.6-0.5c-0.2-0.7-0.3-1.4-0.3-2.1c-0.1-8.2-0.1-16.5,0-24.5l0-4.8 c0-0.2,0-0.4,0-0.5C31.3,15.6,17,25.9,2.7,36.3c0.2,0.1,0.5,0.1,0.8,0.2c3.1,1,6.2,2,9.4,3c5.8,1.9,11.7,3.8,17.6,5.7 c1,0.3,1.8,0.7,2.5,1.1c0.1-0.1,0.3-0.2,0.4-0.2C37.4,43.3,41.4,40.3,45.4,37.5z"/></g></svg>',
                                        'label' =>  __('Color schema', 'reviewx'),
                                        'value' => '<div id="action_color_theme_color"></div>',
                                    ),
                                    array(
                                        'id'    => 'action_review_title',
                                        'icon'  => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve"><g><g><path class="st0" d="M20.9,61.6c1.1,1.1,1.6,2.6,1.4,4.1l-4.7,26.5c-0.4,2.5,1.2,4.8,3.7,5.3c1,0.2,2,0,2.8-0.4l23.7-12.7 c1.4-0.7,3-0.7,4.4,0l23.7,12.7c2.2,1.2,5,0.4,6.2-1.8c0.5-0.9,0.7-2,0.5-3l-4.7-26.5c-0.3-1.5,0.2-3.1,1.4-4.1l19.4-18.7 c1.8-1.8,1.9-4.7,0.1-6.5c-0.7-0.7-1.7-1.2-2.7-1.4l-26.6-3.7c-1.5-0.2-2.8-1.2-3.5-2.5L54.1,4.6C53,2.4,50.3,1.4,48,2.6 c-0.9,0.4-1.6,1.2-2.1,2.1L34.2,28.9c-0.7,1.4-2,2.3-3.6,2.5L4,35.1c-2.5,0.3-4.3,2.7-3.9,5.2c0.1,1,0.6,2,1.4,2.7L20.9,61.6z"/></g></g></svg>',
                                        'label' =>  __('Review Title', 'reviewx'),
                                        'value' => '',
                                    ),
                                    array(
                                        'id'    => 'action_recaptcha',
                                        'icon'  => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve"><g><g><path class="st0" d="M20.9,61.6c1.1,1.1,1.6,2.6,1.4,4.1l-4.7,26.5c-0.4,2.5,1.2,4.8,3.7,5.3c1,0.2,2,0,2.8-0.4l23.7-12.7 c1.4-0.7,3-0.7,4.4,0l23.7,12.7c2.2,1.2,5,0.4,6.2-1.8c0.5-0.9,0.7-2,0.5-3l-4.7-26.5c-0.3-1.5,0.2-3.1,1.4-4.1l19.4-18.7 c1.8-1.8,1.9-4.7,0.1-6.5c-0.7-0.7-1.7-1.2-2.7-1.4l-26.6-3.7c-1.5-0.2-2.8-1.2-3.5-2.5L54.1,4.6C53,2.4,50.3,1.4,48,2.6 c-0.9,0.4-1.6,1.2-2.1,2.1L34.2,28.9c-0.7,1.4-2,2.3-3.6,2.5L4,35.1c-2.5,0.3-4.3,2.7-3.9,5.2c0.1,1,0.6,2,1.4,2.7L20.9,61.6z"/></g></g></svg>',
                                        'label' =>  __('reCAPTCHA', 'reviewx'),
                                        'value' => '',
                                    ),                                                                          
                                )
                            )),                            
                        )
                    ),                
                ))
            ),
        ))
    );
}