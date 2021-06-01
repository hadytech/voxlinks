<?php 
    
    $wp_customize->add_setting('reviewx_item', array(
       'default'           => $defaults['reviewx_item'],
        'sanitize_callback' => 'esc_html',
    ));	

    $wp_customize->add_control(new ReviewX_Separator_Custom_Control(
        $wp_customize, 'reviewx_item', array(
        'label'	            => __( 'Review Item', 'reviewx' ),
        'settings'	        => 'reviewx_item',
        'section'  	        => 'reviewx_advanced_designs_page_settings',
        'priority'          => 59
    )));

    if( $template == 'template_style_one' ) {

        // Box-Shadow    
        $wp_customize->add_control(new ReviewX_Separator_Custom_Control(
            $wp_customize, 'reviewx_template_one_avatar_box_shadow', array(
            'label'	    => __( 'Avatar Box Shadow', 'reviewx' ),
            'settings'	=> 'reviewx_separator',
            'section'  	=> 'reviewx_advanced_designs_page_settings',
            'priority'  => 60
        ))); 

        $wp_customize->add_setting( 'reviewx_template_one_avatar_box_shadow_color' , array(
            'default'     => $defaults['reviewx_template_one_avatar_box_shadow_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );

        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_one_avatar_box_shadow_color',
            array(
                'label'      => __( 'Avatar Box Shadow Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_one_avatar_box_shadow_color',
                'priority' => 61,
            ) )
        );    

        $wp_customize->add_setting( 'reviewx_template_one_avatar_box_shadow_horizontal', array(
            'default'       => $defaults['reviewx_template_one_avatar_box_shadow_horizontal'],
            'capability'    => 'edit_theme_options',
            'transport' => 'postMessage',
            //'sanitize_callback' => 'reviewx_sanitize_integer'
        ) );    

        $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
            $wp_customize, 'reviewx_template_one_avatar_box_shadow_horizontal', array(
            'type'     => 'reviewx-range-value',
            'section'  => 'reviewx_advanced_designs_page_settings',
            'settings' => 'reviewx_template_one_avatar_box_shadow_horizontal',
            'label'    => __( 'Horizontal', 'reviewx' ),
            'input_attrs' => array(
                'min'    => -100,
                'max'    => 100,
                'step'   => 1,
                'suffix' => 'px', //optional suffix
            ),
            'priority' => 62,
        ) ) ); 

        $wp_customize->add_setting( 'reviewx_template_one_avatar_box_shadow_vertical', array(
            'default'       => $defaults['reviewx_template_one_avatar_box_shadow_vertical'],
            'capability'    => 'edit_theme_options',
            'transport' => 'postMessage',
        // 'sanitize_callback' => 'reviewx_sanitize_integer'
        ) );    

        $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
            $wp_customize, 'reviewx_template_one_avatar_box_shadow_vertical', array(
            'type'     => 'reviewx-range-value',
            'section'  => 'reviewx_advanced_designs_page_settings',
            'settings' => 'reviewx_template_one_avatar_box_shadow_vertical',
            'label'    => __( 'Vertical', 'reviewx' ),
            'input_attrs' => array(
                'min'    => -100,
                'max'    => 100,
                'step'   => 1,
                'suffix' => 'px', //optional suffix
            ),
            'priority' => 63,
        ) ) ); 

        $wp_customize->add_setting( 'reviewx_template_one_avatar_box_shadow_blur', array(
            'default'       => $defaults['reviewx_template_one_avatar_box_shadow_blur'],
            'capability'    => 'edit_theme_options',
            'transport' => 'postMessage',
        //  'sanitize_callback' => 'reviewx_sanitize_integer'
        ) );     

        $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
            $wp_customize, 'reviewx_template_one_avatar_box_shadow_blur', array(
            'type'     => 'reviewx-range-value',
            'section'  => 'reviewx_advanced_designs_page_settings',
            'settings' => 'reviewx_template_one_avatar_box_shadow_blur',
            'label'    => __( 'Blur', 'reviewx' ),
            'input_attrs' => array(
                'min'    => -100,
                'max'    => 100,
                'step'   => 1,
                'suffix' => 'px', //optional suffix
            ),
            'priority' => 64,
        ) ) );

        $wp_customize->add_setting( 'reviewx_template_one_avatar_box_shadow_spread', array(
            'default'       => $defaults['reviewx_template_one_avatar_box_shadow_spread'],
            'capability'    => 'edit_theme_options',
            'transport' => 'postMessage',
        // 'sanitize_callback' => 'reviewx_sanitize_integer'
        ) );     

        $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
            $wp_customize, 'reviewx_template_one_avatar_box_shadow_spread', array(
            'type'     => 'reviewx-range-value',
            'section'  => 'reviewx_advanced_designs_page_settings',
            'settings' => 'reviewx_template_one_avatar_box_shadow_spread',
            'label'    => __( 'Spread', 'reviewx' ),
            'input_attrs' => array(
                'min'    => -100,
                'max'    => 100,
                'step'   => 1,
                'suffix' => 'px', //optional suffix
            ),
            'priority' => 65,
        ) ) );

        $wp_customize->add_setting( 'reviewx_template_one_avatar_box_shadow_position', array(
            'default'       => $defaults['reviewx_template_one_avatar_box_shadow_position'],
            'capability'    => 'edit_theme_options',
            'transport' => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_select',
            'priority'  => 66
        ) );    

        $wp_customize->add_control( new ReviewX_Select_Control(
            $wp_customize, 'reviewx_template_one_avatar_box_shadow_position', array(
            'type'     => 'reviewx-select',
            'section'  => 'reviewx_advanced_designs_page_settings',
            'settings' => 'reviewx_template_one_avatar_box_shadow_position',
            'label'    => __( 'Position', 'reviewx' ),
            'priority' => 67,
            'input_attrs' => array(
                'class' => 'reviewx_template_one_avatar_box_shadow_position reviewx-select',
            ),
            'choices'  => array(
                'inset'   	=> __( 'Inset', 'reviewx' ),
                ''    => __( 'Outline', 'reviewx' ),
            )
        ) ) );  
        
        
        $wp_customize->add_setting( 'reviewx_template_one_avatar_border_style', array(
            'default'       => $defaults['reviewx_template_one_avatar_border_style'],
            'capability'    => 'edit_theme_options',
            'transport' => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_select',
            'priority'  => 68
        ) );    
        
        $wp_customize->add_control( new ReviewX_Select_Control(
            $wp_customize, 'reviewx_template_one_avatar_border_style', array(
            'type'     => 'reviewx-select',
            'section'  => 'reviewx_advanced_designs_page_settings',
            'settings' => 'reviewx_template_one_avatar_border_style',
            'label'    => __( 'Border Style', 'reviewx' ),
            'priority' => 69,
            'input_attrs' => array(
                'class' => 'reviewx_template_one_avatar_border_style reviewx-select',
            ),
            'choices'  => array(
                'solid'   	=> __( 'Solid', 'reviewx' ),
                'double'    => __( 'Double', 'reviewx' ),
                'dashed'    => __( 'Dashed', 'reviewx' ),
                'dotted'    => __( 'Dotted', 'reviewx' ),
            )
        ) ) );
    
        $wp_customize->add_setting( 'reviewx_template_one_avatar_border_color' , array(
            'default'     => $defaults['reviewx_template_one_avatar_border_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );
    
        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_one_avatar_border_color',
            array(
                'label'      => __( 'Border Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_one_avatar_border_color',
                'priority' => 70,
            ) )
        );
        
        $wp_customize->add_setting( 'reviewx_template_one_avatar_border_weight', array(
            'default'       => $defaults['reviewx_template_one_avatar_border_weight'],
            'capability'    => 'edit_theme_options',
            'transport' => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_integer'
        ) );     
        
        $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
            $wp_customize, 'reviewx_template_one_avatar_border_weight', array(
            'type'     => 'reviewx-range-value',
            'section'  => 'reviewx_advanced_designs_page_settings',
            'settings' => 'reviewx_template_one_avatar_border_weight',
            'label'    => __( 'Border Weight', 'reviewx' ),
            'input_attrs' => array(
                'min'    => 0,
                'max'    => 100,
                'step'   => 1,
                'suffix' => 'px', //optional suffix
            ),
            'priority' => 71,
        ) ) );   
        
        $wp_customize->add_setting( 'reviewx_template_one_reviewer_name_color' , array(
            'default'     => $defaults['reviewx_template_one_reviewer_name_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );

        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_one_reviewer_name_color',
            array(
                'label'      => __( 'Reviewer Name Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_one_reviewer_name_color',
                'priority' => 72,
            ) )
        ); 
        
        $wp_customize->add_setting( 'reviewx_template_one_reviewer_name_font_size', array(
            'default'           => $defaults['reviewx_template_one_reviewer_name_font_size'],
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_integer'
    
        ) );
    
        $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
            $wp_customize, 'reviewx_template_one_reviewer_name_font_size', array(
            'type'              => 'reviewx-range-value',
            'section'           => 'reviewx_advanced_designs_page_settings',
            'settings'          => 'reviewx_template_one_reviewer_name_font_size',
            'label'             => __( 'Reviewer Name Font Size', 'reviewx' ),
            'input_attrs'       => array(
                'min'    => 0,
                'max'    => 50,
                'step'   => 1,
                'suffix' => 'px', //optional suffix
            ),
            'priority' => 73,
        ) ) );

        $wp_customize->add_setting( 'reviewx_template_one_rating_color' , array(
            'default'     => $defaults['reviewx_template_one_rating_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );
    
        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_one_rating_color',
            array(
                'label'      => __( 'Rating Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_one_rating_color',
                'priority' => 74,
            ) )
        ); 
        
        $wp_customize->add_setting( 'reviewx_template_one_star_rating_size', array(
            'default'           => $defaults['reviewx_template_one_star_rating_size'],
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_integer'
    
        ) );
    
        $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
            $wp_customize, 'reviewx_template_one_star_rating_size', array(
            'type'              => 'reviewx-range-value',
            'section'           => 'reviewx_advanced_designs_page_settings',
            'settings'          => 'reviewx_template_one_star_rating_size',
            'label'             => __( 'Star Rating Size', 'reviewx' ),
            'input_attrs'       => array(
                'min'    => 0,
                'max'    => 100,
                'step'   => 1,
                'suffix' => 'px', //optional suffix
            ),
            'priority' => 75,
        ) ) );
        
        $wp_customize->add_setting( 'reviewx_template_one_title_color' , array(
            'default'     => $defaults['reviewx_template_one_title_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );
    
        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_one_title_color',
            array(
                'label'      => __( 'Review Title Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_one_title_color',
                'priority' => 76,
            ) )
        ); 
        
        $wp_customize->add_setting( 'reviewx_template_one_title_font_size', array(
            'default'           => $defaults['reviewx_template_one_title_font_size'],
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_integer'
    
        ) );
    
        $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
            $wp_customize, 'reviewx_template_one_title_font_size', array(
            'type'              => 'reviewx-range-value',
            'section'           => 'reviewx_advanced_designs_page_settings',
            'settings'          => 'reviewx_template_one_title_font_size',
            'label'             => __( 'Review Title Font Size', 'reviewx' ),
            'input_attrs'       => array(
                'min'    => 0,
                'max'    => 100,
                'step'   => 1,
                'suffix' => 'px', //optional suffix
            ),
            'priority' => 77,
        ) ) );  
        
        $wp_customize->add_setting( 'reviewx_template_one_review_text_color' , array(
            'default'     => $defaults['reviewx_template_one_review_text_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );
    
        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_one_review_text_color',
            array(
                'label'      => __( 'Review Text Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_one_review_text_color',
                'priority' => 78,
            ) )
        ); 
        
        $wp_customize->add_setting( 'reviewx_template_one_review_text_font_size', array(
            'default'           => $defaults['reviewx_template_one_review_text_font_size'],
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_integer'
    
        ) );
    
        $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
            $wp_customize, 'reviewx_template_one_review_text_font_size', array(
            'type'              => 'reviewx-range-value',
            'section'           => 'reviewx_advanced_designs_page_settings',
            'settings'          => 'reviewx_template_one_review_text_font_size',
            'label'             => __( 'Review Text Font Size', 'reviewx' ),
            'input_attrs'       => array(
                'min'    => 0,
                'max'    => 100,
                'step'   => 1,
                'suffix' => 'px', //optional suffix
            ),
            'priority' => 79,
        ) ) ); 
        
        $wp_customize->add_setting( 'reviewx_template_one_background_color' , array(
            'default'     => $defaults['reviewx_template_one_background_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );
    
        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_one_background_color',
            array(
                'label'      => __( 'Review Container Background Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_one_background_color',
                'priority' => 80,
            ) )
        ); 
        
        $wp_customize->add_setting( 'reviewx_template_one_border_color' , array(
            'default'     => $defaults['reviewx_template_one_border_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );
    
        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_one_border_color',
            array(
                'label'      => __( 'Review Container Border Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_one_border_color',
                'priority' => 81,
            ) )
        );

        // Review Meta
            
        $wp_customize->add_control(new ReviewX_Separator_Custom_Control(
            $wp_customize, 'reviewx_item', array(
            'label'	            => esc_html__( 'Review Meta', 'reviewx' ),
            'settings'	        => 'reviewx_item_meta',
            'section'  	        => 'reviewx_advanced_designs_page_settings',
            'priority'          => 82
        )));  

        $wp_customize->add_setting( 'reviewx_template_one_date_icon_color' , array(
            'default'     => $defaults['reviewx_template_one_date_icon_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );

        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_one_date_icon_color',
            array(
                'label'      => __( 'Review Date Icon Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_one_date_icon_color',
                'priority' => 83,
            ) )
        );  

        $wp_customize->add_setting( 'reviewx_template_one_date_text_color' , array(
            'default'     => $defaults['reviewx_template_one_date_text_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );

        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_one_date_text_color',
            array(
                'label'      => __( 'Review Date Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_one_date_text_color',
                'priority' => 84,
            ) )
        );   

        $wp_customize->add_setting( 'reviewx_template_one_date_font_size', array(
            'default'           => $defaults['reviewx_template_one_date_font_size'],
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_integer'

        ) );

        $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
            $wp_customize, 'reviewx_template_one_date_font_size', array(
            'type'              => 'reviewx-range-value',
            'section'           => 'reviewx_advanced_designs_page_settings',
            'settings'          => 'reviewx_template_one_date_font_size',
            'label'             => __( 'Review Date Font Size', 'reviewx' ),
            'input_attrs'       => array(
                'min'    => 0,
                'max'    => 100,
                'step'   => 1,
                'suffix' => 'px', //optional suffix
            ),
            'priority' => 85,
        ) ) );

        $wp_customize->add_setting( 'reviewx_template_one_verified_icon_color' , array(
            'default'     => $defaults['reviewx_template_one_verified_icon_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );        

        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_one_verified_icon_color',
            array(
                'label'      => __( 'Verified Icon Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_one_verified_icon_color',
                'priority' => 86,
            ) )
        );  

        $wp_customize->add_setting( 'reviewx_template_one_verified_text_color' , array(
            'default'     => $defaults['reviewx_template_one_verified_text_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );

        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_one_verified_text_color',
            array(
                'label'      => __( 'Verified Badge Text Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_one_verified_text_color',
                'priority' => 87,
            ) )
        );   

        $wp_customize->add_setting( 'reviewx_template_one_verified_font_size', array(
            'default'           => $defaults['reviewx_template_one_verified_font_size'],
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_integer'

        ) );

        $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
            $wp_customize, 'reviewx_template_one_verified_font_size', array(
            'type'              => 'reviewx-range-value',
            'section'           => 'reviewx_advanced_designs_page_settings',
            'settings'          => 'reviewx_template_one_verified_font_size',
            'label'             => __( 'Verified Badge Font Size', 'reviewx' ),
            'input_attrs'       => array(
                'min'    => 0,
                'max'    => 100,
                'step'   => 1,
                'suffix' => 'px', //optional suffix
            ),
            'priority' => 88,
        ) ) );

        // Load pro review meta
        if( class_exists('ReviewXPro') ) {
            $wp_customize->add_setting( 'reviewx_template_one_helpful_text_color' , array(
                'default'     => $defaults['reviewx_template_one_helpful_text_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );

            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_one_helpful_text_color',
                array(
                    'label'      => __( 'Helpful Text Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_one_helpful_text_color',
                    'priority' => 89,
                ) )
            );   

            $wp_customize->add_setting( 'reviewx_template_one_helpful_font_size', array(
                'default'           => $defaults['reviewx_template_one_helpful_font_size'],
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_integer'
            ) );

            $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
                $wp_customize, 'reviewx_template_one_helpful_font_size', array(
                'type'              => 'reviewx-range-value',
                'section'           => 'reviewx_advanced_designs_page_settings',
                'settings'          => 'reviewx_template_one_helpful_font_size',
                'label'             => __( 'Helpful Text Font Size', 'reviewx' ),
                'input_attrs'       => array(
                    'min'    => 0,
                    'max'    => 100,
                    'step'   => 1,
                    'suffix' => 'px', //optional suffix
                ),
                'priority' => 90,
            ) ) );

            $wp_customize->add_setting( 'reviewx_template_one_helpful_button_bgcolor' , array(
                'default'     => $defaults['reviewx_template_one_helpful_button_bgcolor'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );

            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_one_helpful_button_bgcolor',
                array(
                    'label'      => __( 'Helpful Button Background Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_one_helpful_button_bgcolor',
                    'priority' => 91,
                ) )
            ); 
            
            $wp_customize->add_setting( 'reviewx_template_one_helpful_thumbsup_color' , array(
                'default'     => $defaults['reviewx_template_one_helpful_thumbsup_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );

            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_one_helpful_thumbsup_color',
                array(
                    'label'      => __( 'Helpful Thumbs-up Icon Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_one_helpful_thumbsup_color',
                    'priority' => 92,
                ) )
            );   
            
            $wp_customize->add_setting( 'reviewx_template_one_helpful_thumbsup_count_color' , array(
                'default'     => $defaults['reviewx_template_one_helpful_thumbsup_count_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );

            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_one_helpful_thumbsup_count_color',
                array(
                    'label'      => __( 'Helpful Thumbs-up Count Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_one_helpful_thumbsup_count_color',
                    'priority' => 93,
                ) )
            );  
            
            $wp_customize->add_setting( 'reviewx_template_one_share_text_color' , array(
                'default'     => $defaults['reviewx_template_one_share_text_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );

            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_one_share_text_color',
                array(
                    'label'      => __( 'Share Text Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_one_share_text_color',
                    'priority' => 94,
                ) )
            );

            $wp_customize->add_setting( 'reviewx_template_one_share_text_font_size', array(
                'default'           => $defaults['reviewx_template_one_share_text_font_size'],
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_integer'

            ) );

            $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
                $wp_customize, 'reviewx_template_one_share_text_font_size', array(
                'type'              => 'reviewx-range-value',
                'section'           => 'reviewx_advanced_designs_page_settings',
                'settings'          => 'reviewx_template_one_share_text_font_size',
                'label'             => __( 'Share Text Font Size', 'reviewx' ),
                'input_attrs'       => array(
                    'min'    => 0,
                    'max'    => 100,
                    'step'   => 1,
                    'suffix' => 'px', //optional suffix
                ),
                'priority' => 95,
            ) ) ); 
            
            $wp_customize->add_setting( 'reviewx_template_one_share_icon_color' , array(
                'default'     => $defaults['reviewx_template_one_share_icon_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );

            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_one_share_icon_color',
                array(
                    'label'      => __( 'Share Icon Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_one_share_icon_color',
                    'priority' => 96,
                ) )
            ); 
            
            $wp_customize->add_setting( 'reviewx_template_one_facebook_icon_color' , array(
                'default'     => $defaults['reviewx_template_one_facebook_icon_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );

            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_one_facebook_icon_color',
                array(
                    'label'      => __( 'Facebook Icon Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_one_facebook_icon_color',
                    'priority' => 97,
                ) )
            );  
            
            $wp_customize->add_setting( 'reviewx_template_one_twitter_icon_color' , array(
                'default'     => $defaults['reviewx_template_one_twitter_icon_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );

            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_one_twitter_icon_color',
                array(
                    'label'      => __( 'Twiiter Icon Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_one_twitter_icon_color',
                    'priority' => 98,
                ) )
            ); 
            
            $wp_customize->add_setting( 'reviewx_template_one_top_border_color' , array(
                'default'     => $defaults['reviewx_template_one_top_border_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );

            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_one_top_border_color',
                array(
                    'label'      => __( 'Review Top border Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_one_top_border_color',
                    'priority' => 99,
                ) )
            ); 
            
            $wp_customize->add_setting( 'reviewx_template_one_highlight_color' , array(
                'default'     => $defaults['reviewx_template_one_highlight_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );

            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_one_highlight_color',
                array(
                    'label'      => __( 'Highlight Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_one_highlight_color',
                    'priority' => 100,
                ) )
            );             
        }

        $wp_customize->add_setting('reviewx_attachment_align', array(
        //    'default'           => $defaults['reviewx_attachment_align'],
            'sanitize_callback' => 'esc_html',
        ));	
    
        $wp_customize->add_control(new ReviewX_Separator_Custom_Control(
            $wp_customize, 'reviewx_attachment_align', array(
            'label'	            => esc_html__( 'Review Attachment', 'reviewx' ),
            'settings'	        => 'reviewx_attachment_align',
            'section'  	        => 'reviewx_advanced_designs_page_settings',
            'priority'          => 101
        )));

        $wp_customize->add_setting( 'reviewx_template_one_attachment_align', array(
            'default'       => $defaults['reviewx_template_one_attachment_align'],
            'capability'    => 'edit_theme_options',
            'transport' => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_select',
            'priority'  => 102
        ) );    
        
        $wp_customize->add_control( new ReviewX_Select_Control(
            $wp_customize, 'reviewx_template_one_attachment_align', array(
            'type'     => 'reviewx-select',
            'section'  => 'reviewx_advanced_designs_page_settings',
            'settings' => 'reviewx_template_one_attachment_align',
            'label'    => __( 'Align', 'reviewx' ),
            'priority' => 103,
            'input_attrs' => array(
                'class' => 'reviewx_template_one_attachment_align reviewx-select',
            ),
            'choices'  => array(
                'flex-start'  => __( 'Left', 'reviewx' ),
                'flex-end'    => __( 'Right', 'reviewx' ),
            )
        ) ) );        


        // Load review meta in pro
        if( class_exists('ReviewXPro') ) {
            
            $wp_customize->add_setting('reviewx_store_reply', array(
                'default'           => $defaults['reviewx_store_reply'],
                'sanitize_callback' => 'esc_html',
            ));	
        
            $wp_customize->add_control(new ReviewX_Separator_Custom_Control(
                $wp_customize, 'reviewx_store_reply', array(
                'label'	            => esc_html__( 'Store Reply', 'reviewx' ),
                'settings'	        => 'reviewx_store_reply',
                'section'  	        => 'reviewx_advanced_designs_page_settings',
                'priority'          => 104
            )));

            $wp_customize->add_setting( 'reviewx_template_one_store_logo_color' , array(
                'default'     => $defaults['reviewx_template_one_store_logo_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );
        
            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_one_store_logo_color',
                array(
                    'label'      => __( 'Store Logo Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_one_store_logo_color',
                    'priority' => 105,
                ) )
            );  

            $wp_customize->add_setting( 'reviewx_template_one_store_logo_bg_color' , array(
                'default'     => $defaults['reviewx_template_one_store_logo_bg_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );
        
            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_one_store_logo_bg_color',
                array(
                    'label'      => __( 'Store Logo Background Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_one_store_logo_bg_color',
                    'priority' => 106,
                ) )
            ); 

            $wp_customize->add_setting( 'reviewx_template_one_store_logo_border_radius', array(
                'default'           => $defaults['reviewx_template_one_store_logo_border_radius'],
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_integer'
        
            ) );
        
            $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
                $wp_customize, 'reviewx_template_one_store_logo_border_radius', array(
                'type'              => 'reviewx-range-value',
                'section'           => 'reviewx_advanced_designs_page_settings',
                'settings'          => 'reviewx_template_one_store_logo_border_radius',
                'label'             => __( 'Store Logo Border Radius', 'reviewx' ),
                'input_attrs'       => array(
                    'min'    => 0,
                    'max'    => 100,
                    'step'   => 1,
                    'suffix' => 'px', //optional suffix
                ),
                'priority' => 107,
            ) ) ); 
            
            $wp_customize->add_setting( 'reviewx_template_one_store_name_color' , array(
                'default'     => $defaults['reviewx_template_one_store_name_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );
        
            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_one_store_name_color',
                array(
                    'label'      => __( 'Store Name Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_one_store_name_color',
                    'priority' => 108,
                ) )
            );
            
            $wp_customize->add_setting( 'reviewx_template_one_store_name_font_size', array(
                'default'           => $defaults['reviewx_template_one_store_name_font_size'],
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_integer'
        
            ) );
        
            $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
                $wp_customize, 'reviewx_template_one_store_name_font_size', array(
                'type'              => 'reviewx-range-value',
                'section'           => 'reviewx_advanced_designs_page_settings',
                'settings'          => 'reviewx_template_one_store_name_font_size',
                'label'             => __( 'Store Name Font Size', 'reviewx' ),
                'input_attrs'       => array(
                    'min'    => 0,
                    'max'    => 100,
                    'step'   => 1,
                    'suffix' => 'px', //optional suffix
                ),
                'priority' => 109,
            ) ) ); 
            
            $wp_customize->add_setting( 'reviewx_template_one_replay_back_icon_color' , array(
                'default'     => $defaults['reviewx_template_one_replay_back_icon_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );
        
            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_one_replay_back_icon_color',
                array(
                    'label'      => __( 'Reply Back Icon Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_one_replay_back_icon_color',
                    'priority' => 110,
                ) )
            ); 
            
            $wp_customize->add_setting( 'reviewx_template_one_reply_text_color' , array(
                'default'     => $defaults['reviewx_template_one_reply_text_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );
        
            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_one_reply_text_color',
                array(
                    'label'      => __( 'Reply Text Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_one_reply_text_color',
                    'priority' => 111,
                ) )
            );  
            
            $wp_customize->add_setting( 'reviewx_template_one_reply_text_font_size', array(
                'default'           => $defaults['reviewx_template_one_reply_text_font_size'],
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_integer'
        
            ) );
        
            $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
                $wp_customize, 'reviewx_template_one_reply_text_font_size', array(
                'type'              => 'reviewx-range-value',
                'section'           => 'reviewx_advanced_designs_page_settings',
                'settings'          => 'reviewx_template_one_reply_text_font_size',
                'label'             => __( 'Reply Text Font Size', 'reviewx' ),
                'input_attrs'       => array(
                    'min'    => 0,
                    'max'    => 100,
                    'step'   => 1,
                    'suffix' => 'px', //optional suffix
                ),
                'priority' => 112,
            ) ) );  
            
            $wp_customize->add_setting( 'reviewx_template_one_reply_date_color' , array(
                'default'     => $defaults['reviewx_template_one_reply_date_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );
        
            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_one_reply_date_color',
                array(
                    'label'      => __( 'Reply Date Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_one_reply_date_color',
                    'priority' => 113,
                ) )
            ); 
            
            $wp_customize->add_setting( 'reviewx_template_one_reply_date_font_size', array(
                'default'           => $defaults['reviewx_template_one_reply_date_font_size'],
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_integer'
        
            ) );
        
            $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
                $wp_customize, 'reviewx_template_one_reply_date_font_size', array(
                'type'              => 'reviewx-range-value',
                'section'           => 'reviewx_advanced_designs_page_settings',
                'settings'          => 'reviewx_template_one_reply_date_font_size',
                'label'             => __( 'Reply Date Font Size', 'reviewx' ),
                'input_attrs'       => array(
                    'min'    => 0,
                    'max'    => 100,
                    'step'   => 1,
                    'suffix' => 'px', //optional suffix
                ),
                'priority' => 114,
            ) ) ); 
            
            $wp_customize->add_setting( 'reviewx_template_one_reply_date_icon_color' , array(
                'default'     => $defaults['reviewx_template_one_reply_date_icon_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );
        
            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_one_reply_date_icon_color',
                array(
                    'label'      => __( 'Reply Date Icon Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_one_reply_date_icon_color',
                    'priority' => 115,
                ) )
            ); 
            
            $wp_customize->add_setting( 'reviewx_template_one_reply_edit_icon_color' , array(
                'default'     => $defaults['reviewx_template_one_reply_edit_icon_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );
        
            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_one_reply_edit_icon_color',
                array(
                    'label'      => __( 'Reply Edit Icon Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_one_reply_edit_icon_color',
                    'priority' => 116,
                ) )
            ); 
            
            $wp_customize->add_setting( 'reviewx_template_one_reply_delete_icon_color' , array(
                'default'     => $defaults['reviewx_template_one_reply_delete_icon_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );
        
            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_one_reply_delete_icon_color',
                array(
                    'label'      => __( 'Reply Delete Icon Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_one_reply_delete_icon_color',
                    'priority' => 117,
                ) )
            );  
            
            $wp_customize->add_setting( 'reviewx_template_one_reply_button_text_color' , array(
                'default'     => $defaults['reviewx_template_one_reply_button_text_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );
        
            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_one_reply_button_text_color',
                array(
                    'label'      => __( 'Reply Button Text Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_one_reply_button_text_color',
                    'priority' => 118,
                ) )
            ); 
            
            $wp_customize->add_setting( 'reviewx_template_one_reply_button_text_font_size', array(
                'default'           => $defaults['reviewx_template_one_reply_button_text_font_size'],
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_integer'
        
            ) );
        
            $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
                $wp_customize, 'reviewx_template_one_reply_button_text_font_size', array(
                'type'              => 'reviewx-range-value',
                'section'           => 'reviewx_advanced_designs_page_settings',
                'settings'          => 'reviewx_template_one_reply_button_text_font_size',
                'label'             => __( 'Reply Button Text Font Size', 'reviewx' ),
                'input_attrs'       => array(
                    'min'    => 0,
                    'max'    => 100,
                    'step'   => 1,
                    'suffix' => 'px', //optional suffix
                ),
                'priority' => 119,
            ) ) ); 
            
            $wp_customize->add_setting( 'reviewx_template_one_reply_button_bg_color' , array(
                'default'     => $defaults['reviewx_template_one_reply_button_bg_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );
        
            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_one_reply_button_bg_color',
                array(
                    'label'      => __( 'Reply Button Background Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_one_reply_button_bg_color',
                    'priority' => 120,
                ) )
            );
            
            $wp_customize->add_setting( 'reviewx_template_one_reply_button_border_color' , array(
                'default'     => $defaults['reviewx_template_one_reply_button_border_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );
        
            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_one_reply_button_border_color',
                array(
                    'label'      => __( 'Reply Button Border Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_one_reply_button_border_color',
                    'priority' => 121,
                ) )
            ); 
            
            $wp_customize->add_setting( 'reviewx_template_one_reply_background_color' , array(
                'default'     => $defaults['reviewx_template_one_reply_background_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );
        
            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_one_reply_background_color',
                array(
                    'label'      => __( 'Reply Background Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_one_reply_background_color',
                    'priority' => 122,
                ) )
            );  
            
            $wp_customize->add_setting('reviewx_reply_form', array(
                'default'           => $defaults['reviewx_reply_form'],
                'sanitize_callback' => 'esc_html',
            ));	
        
            $wp_customize->add_control(new ReviewX_Separator_Custom_Control(
                $wp_customize, 'reviewx_reply_form', array(
                'label'	            => esc_html__( 'Reply', 'reviewx' ),
                'settings'	        => 'reviewx_reply_form',
                'section'  	        => 'reviewx_advanced_designs_page_settings',
                'priority'          => 123
            ))); 
            
            $wp_customize->add_setting( 'reviewx_template_one_reply_form_background_color' , array(
                'default'     => $defaults['reviewx_template_one_reply_form_background_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );
        
            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_one_reply_form_background_color',
                array(
                    'label'      => __( 'Reply Form Background Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_one_reply_form_background_color',
                    'priority' => 124,
                ) )
            ); 
            
            $wp_customize->add_setting( 'reviewx_template_one_reply_form_border_color' , array(
                'default'     => $defaults['reviewx_template_one_reply_form_border_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );
        
            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_one_reply_form_border_color',
                array(
                    'label'      => __( 'Reply Form Border Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_one_reply_form_border_color',
                    'priority' => 125,
                ) )
            ); 
            
            $wp_customize->add_setting( 'reviewx_template_one_reply_form_border_radius', array(
                'default'           => $defaults['reviewx_template_one_reply_form_border_radius'],
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_integer'
        
            ) );
        
            $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
                $wp_customize, 'reviewx_template_one_reply_form_border_radius', array(
                'type'              => 'reviewx-range-value',
                'section'           => 'reviewx_advanced_designs_page_settings',
                'settings'          => 'reviewx_template_one_reply_form_border_radius',
                'label'             => __( 'Reply Form Border Radius', 'reviewx' ),
                'input_attrs'       => array(
                    'min'    => 0,
                    'max'    => 100,
                    'step'   => 1,
                    'suffix' => 'px', //optional suffix
                ),
                'priority' => 126,
            ) ) );
            
            $wp_customize->add_setting( 'reviewx_template_one_reply_form_title_color' , array(
                'default'     => $defaults['reviewx_template_one_reply_form_title_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );
        
            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_one_reply_form_title_color',
                array(
                    'label'      => __( 'Reply Form Title Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_one_reply_form_title_color',
                    'priority' => 127,
                ) )
            ); 
            
            $wp_customize->add_setting( 'reviewx_template_one_reply_form_title_font_size', array(
                'default'           => $defaults['reviewx_template_one_reply_form_title_font_size'],
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_integer'
        
            ) );
        
            $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
                $wp_customize, 'reviewx_template_one_reply_form_title_font_size', array(
                'type'              => 'reviewx-range-value',
                'section'           => 'reviewx_advanced_designs_page_settings',
                'settings'          => 'reviewx_template_one_reply_form_title_font_size',
                'label'             => __( 'Reply Form Title Font Size', 'reviewx' ),
                'input_attrs'       => array(
                    'min'    => 0,
                    'max'    => 100,
                    'step'   => 1,
                    'suffix' => 'px', //optional suffix
                ),
                'priority' => 128,
            ) ) );  
            
            $wp_customize->add_setting( 'reviewx_template_one_reply_form_textarea_color' , array(
                'default'     => $defaults['reviewx_template_one_reply_form_textarea_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );
        
            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_one_reply_form_textarea_color',
                array(
                    'label'      => __( 'Reply Text Area Background Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_one_reply_form_textarea_color',
                    'priority' => 129,
                ) )
            );    

            $wp_customize->add_setting( 'reviewx_template_one_reply_form_submit_button_bgcolor' , array(
                'default'     => $defaults['reviewx_template_one_reply_form_submit_button_bgcolor'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );
        
            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_one_reply_form_submit_button_bgcolor',
                array(
                    'label'      => __( 'Reply Submit Button Background Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_one_reply_form_submit_button_bgcolor',
                    'priority' => 130,
                ) )
            );  

            $wp_customize->add_setting( 'reviewx_template_one_reply_form_submit_button_text_color' , array(
                'default'     => $defaults['reviewx_template_one_reply_form_submit_button_text_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );
        
            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_one_reply_form_submit_button_text_color',
                array(
                    'label'      => __( 'Reply Submit Button Text Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_one_reply_form_submit_button_text_color',
                    'priority' => 131,
                ) )
            ); 
            
            $wp_customize->add_setting( 'reviewx_template_one_reply_form_submit_button_font_size', array(
                'default'           => $defaults['reviewx_template_one_reply_form_submit_button_font_size'],
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_integer'
        
            ) );
        
            $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
                $wp_customize, 'reviewx_template_one_reply_form_submit_button_font_size', array(
                'type'              => 'reviewx-range-value',
                'section'           => 'reviewx_advanced_designs_page_settings',
                'settings'          => 'reviewx_template_one_reply_form_submit_button_font_size',
                'label'             => __( 'Reply Submit Button Font Size', 'reviewx' ),
                'input_attrs'       => array(
                    'min'    => 0,
                    'max'    => 100,
                    'step'   => 1,
                    'suffix' => 'px', //optional suffix
                ),
                'priority' => 132,
            ) ) );  
            
            $wp_customize->add_setting( 'reviewx_template_one_reply_form_cancel_button_bgcolor' , array(
                'default'     => $defaults['reviewx_template_one_reply_form_cancel_button_bgcolor'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );
        
            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_one_reply_form_cancel_button_bgcolor',
                array(
                    'label'      => __( 'Reply Cancel Button Background Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_one_reply_form_cancel_button_bgcolor',
                    'priority' => 133,
                ) )
            );  

            $wp_customize->add_setting( 'reviewx_template_one_reply_form_cancel_button_text_color' , array(
                'default'     => $defaults['reviewx_template_one_reply_form_cancel_button_text_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );
        
            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_one_reply_form_cancel_button_text_color',
                array(
                    'label'      => __( 'Reply Cancel Button Text Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_one_reply_form_cancel_button_text_color',
                    'priority' => 134,
                ) )
            ); 
            
            $wp_customize->add_setting( 'reviewx_template_one_reply_form_cancel_button_font_size', array(
                'default'           => $defaults['reviewx_template_one_reply_form_cancel_button_font_size'],
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_integer'
        
            ) );
        
            $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
                $wp_customize, 'reviewx_template_one_reply_form_cancel_button_font_size', array(
                'type'              => 'reviewx-range-value',
                'section'           => 'reviewx_advanced_designs_page_settings',
                'settings'          => 'reviewx_template_one_reply_form_cancel_button_font_size',
                'label'             => __( 'Reply Cancel Button Text Font Size', 'reviewx' ),
                'input_attrs'       => array(
                    'min'    => 0,
                    'max'    => 100,
                    'step'   => 1,
                    'suffix' => 'px', //optional suffix
                ),
                'priority' => 135,
            ) ) );               

        }  
        
        // Pagination
        $wp_customize->add_setting('reviewx_pagination', array(
          //  'default'           => $defaults['reviewx_pagination'],
            'sanitize_callback' => 'esc_html',
        ));	

        $wp_customize->add_control(new ReviewX_Separator_Custom_Control(
            $wp_customize, 'reviewx_pagination', array(
            'label'	            => esc_html__( 'Pagination', 'reviewx' ),
            'settings'	        => 'reviewx_pagination',
            'section'  	        => 'reviewx_advanced_designs_page_settings',
            'priority'          => 136
        )));  

        $wp_customize->add_setting( 'reviewx_template_one_pagination_text_color' , array(
            'default'     => $defaults['reviewx_template_one_pagination_text_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );

        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_one_pagination_text_color',
            array(
                'label'      => __( 'Text Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_one_pagination_text_color',
                'priority' => 137,
            ) )
        ); 

        $wp_customize->add_setting( 'reviewx_template_one_pagination_font_size', array(
            'default'           => $defaults['reviewx_template_one_pagination_font_size'],
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_integer'

        ) );

        $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
            $wp_customize, 'reviewx_template_one_pagination_font_size', array(
            'type'              => 'reviewx-range-value',
            'section'           => 'reviewx_advanced_designs_page_settings',
            'settings'          => 'reviewx_template_one_pagination_font_size',
            'label'             => __( 'Pagination Font Size', 'reviewx' ),
            'input_attrs'       => array(
                'min'    => 0,
                'max'    => 100,
                'step'   => 1,
                'suffix' => 'px', //optional suffix
            ),
            'priority' => 138,
        ) ) ); 

        $wp_customize->add_setting( 'reviewx_template_one_pagination_bg_color' , array(
            'default'     => $defaults['reviewx_template_one_pagination_bg_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );

        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_one_pagination_bg_color',
            array(
                'label'      => __( 'Background Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_one_pagination_bg_color',
                'priority' => 139,
            ) )
        );   

        $wp_customize->add_setting( 'reviewx_template_one_pagination_active_color' , array(
            'default'     => $defaults['reviewx_template_one_pagination_active_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );

        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_one_pagination_active_color',
            array(
                'label'      => __( 'Active Text Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_one_pagination_active_color',
                'priority' => 140,
            ) )
        );  

        $wp_customize->add_setting( 'reviewx_template_one_pagination_active_bgcolor' , array(
            'default'     => $defaults['reviewx_template_one_pagination_active_bgcolor'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );

        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_one_pagination_active_bgcolor',
            array(
                'label'      => __( 'Active Background Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_one_pagination_active_bgcolor',
                'priority' => 141,
            ) )
        ); 

        $wp_customize->add_setting( 'reviewx_template_one_pagination_hover_text_color' , array(
            'default'     => $defaults['reviewx_template_one_pagination_hover_text_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );

        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_one_pagination_hover_text_color',
            array(
                'label'      => __( 'Hover Text Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_one_pagination_hover_text_color',
                'priority' => 142,
            ) )
        );  

        $wp_customize->add_setting( 'reviewx_template_one_pagination_hover_bgcolor' , array(
            'default'     => $defaults['reviewx_template_one_pagination_hover_bgcolor'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );

        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_one_pagination_hover_bgcolor',
            array(
                'label'      => __( 'Hover Background Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_one_pagination_hover_bgcolor',
                'priority' => 143,
            ) )
        ); 
        
        
        $wp_customize->add_setting('reviewx_form', array(
            'default'           => $defaults['reviewx_form'],
            'sanitize_callback' => 'esc_html',
        ));	
    
        $wp_customize->add_control(new ReviewX_Separator_Custom_Control(
            $wp_customize, 'reviewx_form', array(
            'label'	            => esc_html__( 'Review Form', 'reviewx' ),
            'settings'	        => 'reviewx_form',
            'section'  	        => 'reviewx_advanced_designs_page_settings',
            'priority'          => 144
        )));        

        $wp_customize->add_setting( 'reviewx_template_one_criteria_text_color' , array(
            'default'     => $defaults['reviewx_template_one_criteria_text_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );
    
        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_one_criteria_text_color',
            array(
                'label'      => __( 'Criteria Text Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_one_criteria_text_color',
                'priority' => 145,
            ) )
        ); 
        
        $wp_customize->add_setting( 'reviewx_template_one_criteria_text_font_size', array(
            'default'           => $defaults['reviewx_template_one_criteria_text_font_size'],
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_integer'
    
        ) );
    
        $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
            $wp_customize, 'reviewx_template_one_criteria_text_font_size', array(
            'type'              => 'reviewx-range-value',
            'section'           => 'reviewx_advanced_designs_page_settings',
            'settings'          => 'reviewx_template_one_criteria_text_font_size',
            'label'             => __( 'Criteria Text Font Size', 'reviewx' ),
            'input_attrs'       => array(
                'min'    => 0,
                'max'    => 100,
                'step'   => 1,
                'suffix' => 'px', //optional suffix
            ),
            'priority' => 146,
        ) ) );  
        
        $wp_customize->add_setting( 'reviewx_template_one_form_rating_icon_color' , array(
            'default'     => $defaults['reviewx_template_one_form_rating_icon_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );
    
        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_one_form_rating_icon_color',
            array(
                'label'      => __( 'Rating Icon Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_one_form_rating_icon_color',
                'priority' => 147,
            ) )
        );
        
        $wp_customize->add_setting( 'reviewx_template_one_criteria_icon_size', array(
            'default'           => $defaults['reviewx_template_one_criteria_icon_size'],
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_integer'
    
        ) );
    
        $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
            $wp_customize, 'reviewx_template_one_criteria_icon_size', array(
            'type'              => 'reviewx-range-value',
            'section'           => 'reviewx_advanced_designs_page_settings',
            'settings'          => 'reviewx_template_one_criteria_icon_size',
            'label'             => __( 'Rating Icon Size', 'reviewx' ),
            'input_attrs'       => array(
                'min'    => 0,
                'max'    => 100,
                'step'   => 1,
                'suffix' => 'px', //optional suffix
            ),
            'priority' => 148,
        ) ) );          
        
        $wp_customize->add_setting( 'reviewx_template_one_form_recommendation_icon_active_color' , array(
            'default'     => $defaults['reviewx_template_one_form_recommendation_icon_active_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );
    
        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_one_form_recommendation_icon_active_color',
            array(
                'label'      => __( 'Recommendation Icon Active Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_one_form_recommendation_icon_active_color',
                'priority' => 149,
            ) )
        ); 
        
        $wp_customize->add_setting( 'reviewx_template_one_form_external_video_link_color' , array(
            'default'     => $defaults['reviewx_template_one_form_external_video_link_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );
    
        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_one_form_external_video_link_color',
            array(
                'label'      => __( 'External Example Video Link Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_one_form_external_video_link_color',
                'priority' => 150,
            ) )
        );  
        
        $wp_customize->add_setting( 'reviewx_template_one_form_external_video_font_size', array(
            'default'           => $defaults['reviewx_template_one_form_external_video_font_size'],
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_integer'
    
        ) );
    
        $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
            $wp_customize, 'reviewx_template_one_form_external_video_font_size', array(
            'type'              => 'reviewx-range-value',
            'section'           => 'reviewx_advanced_designs_page_settings',
            'settings'          => 'reviewx_template_one_form_external_video_font_size',
            'label'             => __( 'External Example Video Link Font Size', 'reviewx' ),
            'input_attrs'       => array(
                'min'    => 0,
                'max'    => 100,
                'step'   => 1,
                'suffix' => 'px', //optional suffix
            ),
            'priority' => 151,
        ) ) );
        
//Media upload compliance 
$wp_customize->add_setting( 'reviewx_template_one_media_upload_compliance_text_color' , array(
    'default'     => $defaults['reviewx_template_one_media_upload_compliance_text_color'],
    'capability'    => 'edit_theme_options',
    'transport'   => 'postMessage',
    'sanitize_callback' => 'reviewx_sanitize_rgba',
) );

$wp_customize->add_control(
    new ReviewX_Customizer_Alpha_Color_Control(
    $wp_customize,
    'reviewx_template_one_media_upload_compliance_text_color',
    array(
        'label'      => __( 'Media Upload Compliance Text Color', 'reviewx' ),
        'section'    => 'reviewx_advanced_designs_page_settings',
        'settings'   => 'reviewx_template_one_media_upload_compliance_text_color',
        'priority' => 152,
    ) )
);  

$wp_customize->add_setting( 'reviewx_template_one_media_upload_compliance_font_size', array(
    'default'           => $defaults['reviewx_template_one_media_upload_compliance_font_size'],
    'capability'        => 'edit_theme_options',
    'transport'         => 'postMessage',
    'sanitize_callback' => 'reviewx_sanitize_integer'

) );

$wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
    $wp_customize, 'reviewx_template_one_media_upload_compliance_font_size', array(
    'type'              => 'reviewx-range-value',
    'section'           => 'reviewx_advanced_designs_page_settings',
    'settings'          => 'reviewx_template_one_media_upload_compliance_font_size',
    'label'             => __( 'Media Upload Compliance Text Font Size', 'reviewx' ),
    'input_attrs'       => array(
        'min'    => 0,
        'max'    => 100,
        'step'   => 1,
        'suffix' => 'px', //optional suffix
    ),
    'priority' => 153,
) ) );        
        
        $wp_customize->add_setting( 'reviewx_template_one_form_submit_button_text_color' , array(
            'default'     => $defaults['reviewx_template_one_form_submit_button_text_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );
    
        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_one_form_submit_button_text_color',
            array(
                'label'      => __( 'Submit Button Text Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_one_form_submit_button_text_color',
                'priority' => 154,
            ) )
        );  
        
        $wp_customize->add_setting( 'reviewx_template_one_form_submit_button_font_size', array(
            'default'           => $defaults['reviewx_template_one_form_submit_button_font_size'],
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_integer'
    
        ) );
    
        $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
            $wp_customize, 'reviewx_template_one_form_submit_button_font_size', array(
            'type'              => 'reviewx-range-value',
            'section'           => 'reviewx_advanced_designs_page_settings',
            'settings'          => 'reviewx_template_one_form_submit_button_font_size',
            'label'             => __( 'Submit Button Text Font Size', 'reviewx' ),
            'input_attrs'       => array(
                'min'    => 0,
                'max'    => 100,
                'step'   => 1,
                'suffix' => 'px', //optional suffix
            ),
            'priority' => 155,
        ) ) );  
        
        $wp_customize->add_setting( 'reviewx_template_one_form_submit_button_bg_color' , array(
            'default'     => $defaults['reviewx_template_one_form_submit_button_bg_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );
    
        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_one_form_submit_button_bg_color',
            array(
                'label'      => __( 'Submit Button Background Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_one_form_submit_button_bg_color',
                'priority' => 156,
            ) )
        );  
        
        $wp_customize->add_setting( 'reviewx_template_one_form_submit_button_border_radius', array(
            'default'           => $defaults['reviewx_template_one_form_submit_button_border_radius'],
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_integer'
    
        ) );
    
        $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
            $wp_customize, 'reviewx_template_one_form_submit_button_border_radius', array(
            'type'              => 'reviewx-range-value',
            'section'           => 'reviewx_advanced_designs_page_settings',
            'settings'          => 'reviewx_template_one_form_submit_button_border_radius',
            'label'             => __( 'Submit Button Border Radius', 'reviewx' ),
            'input_attrs'       => array(
                'min'    => 0,
                'max'    => 100,
                'step'   => 1,
                'suffix' => 'px', //optional suffix
            ),
            'priority' => 157,
        ) ) );  

    } else {

        // Box-Shadow    
        $wp_customize->add_control(new ReviewX_Separator_Custom_Control(
            $wp_customize, 'reviewx_template_two_avatar_box_shadow', array(
            'label'	    => esc_html__( 'Avatar Box Shadow', 'reviewx' ),
            'settings'	=> 'reviewx_separator',
            'section'  	=> 'reviewx_advanced_designs_page_settings',
            'priority'  => 60
        ))); 

        $wp_customize->add_setting( 'reviewx_template_two_avatar_box_shadow_color' , array(
            'default'     => $defaults['reviewx_template_two_avatar_box_shadow_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );

        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_two_avatar_box_shadow_color',
            array(
                'label'      => __( 'Avatar Box Shadow Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_two_avatar_box_shadow_color',
                'priority' => 61,
            ) )
        );    

        $wp_customize->add_setting( 'reviewx_template_two_avatar_box_shadow_horizontal', array(
            'default'       => $defaults['reviewx_template_two_avatar_box_shadow_horizontal'],
            'capability'    => 'edit_theme_options',
            'transport' => 'postMessage',
            //'sanitize_callback' => 'reviewx_sanitize_integer'
        ) );    

        $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
            $wp_customize, 'reviewx_template_two_avatar_box_shadow_horizontal', array(
            'type'     => 'reviewx-range-value',
            'section'  => 'reviewx_advanced_designs_page_settings',
            'settings' => 'reviewx_template_two_avatar_box_shadow_horizontal',
            'label'    => __( 'Horizontal', 'reviewx' ),
            'input_attrs' => array(
                'min'    => -100,
                'max'    => 100,
                'step'   => 1,
                'suffix' => 'px', //optional suffix
            ),
            'priority' => 62,
        ) ) ); 

        $wp_customize->add_setting( 'reviewx_template_two_avatar_box_shadow_vertical', array(
            'default'       => $defaults['reviewx_template_two_avatar_box_shadow_vertical'],
            'capability'    => 'edit_theme_options',
            'transport' => 'postMessage',
        // 'sanitize_callback' => 'reviewx_sanitize_integer'
        ) );    

        $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
            $wp_customize, 'reviewx_template_two_avatar_box_shadow_vertical', array(
            'type'     => 'reviewx-range-value',
            'section'  => 'reviewx_advanced_designs_page_settings',
            'settings' => 'reviewx_template_two_avatar_box_shadow_vertical',
            'label'    => __( 'Vertical', 'reviewx' ),
            'input_attrs' => array(
                'min'    => -100,
                'max'    => 100,
                'step'   => 1,
                'suffix' => 'px', //optional suffix
            ),
            'priority' => 63,
        ) ) ); 

        $wp_customize->add_setting( 'reviewx_template_two_avatar_box_shadow_blur', array(
            'default'       => $defaults['reviewx_template_two_avatar_box_shadow_blur'],
            'capability'    => 'edit_theme_options',
            'transport' => 'postMessage',
        //  'sanitize_callback' => 'reviewx_sanitize_integer'
        ) );     

        $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
            $wp_customize, 'reviewx_template_two_avatar_box_shadow_blur', array(
            'type'     => 'reviewx-range-value',
            'section'  => 'reviewx_advanced_designs_page_settings',
            'settings' => 'reviewx_template_two_avatar_box_shadow_blur',
            'label'    => __( 'Blur', 'reviewx' ),
            'input_attrs' => array(
                'min'    => -100,
                'max'    => 100,
                'step'   => 1,
                'suffix' => 'px', //optional suffix
            ),
            'priority' => 64,
        ) ) );

        $wp_customize->add_setting( 'reviewx_template_two_avatar_box_shadow_spread', array(
            'default'       => $defaults['reviewx_template_two_avatar_box_shadow_spread'],
            'capability'    => 'edit_theme_options',
            'transport' => 'postMessage',
        // 'sanitize_callback' => 'reviewx_sanitize_integer'
        ) );     

        $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
            $wp_customize, 'reviewx_template_two_avatar_box_shadow_spread', array(
            'type'     => 'reviewx-range-value',
            'section'  => 'reviewx_advanced_designs_page_settings',
            'settings' => 'reviewx_template_two_avatar_box_shadow_spread',
            'label'    => __( 'Spread', 'reviewx' ),
            'input_attrs' => array(
                'min'    => -100,
                'max'    => 100,
                'step'   => 1,
                'suffix' => 'px', //optional suffix
            ),
            'priority' => 65,
        ) ) );

        $wp_customize->add_setting( 'reviewx_template_two_avatar_box_shadow_position', array(
            'default'       => $defaults['reviewx_template_two_avatar_box_shadow_position'],
            'capability'    => 'edit_theme_options',
            'transport' => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_select',
            'priority'  => 66
        ) );    

        $wp_customize->add_control( new ReviewX_Select_Control(
            $wp_customize, 'reviewx_template_two_avatar_box_shadow_position', array(
            'type'     => 'reviewx-select',
            'section'  => 'reviewx_advanced_designs_page_settings',
            'settings' => 'reviewx_template_two_avatar_box_shadow_position',
            'label'    => __( 'Position', 'reviewx' ),
            'priority' => 67,
            'input_attrs' => array(
                'class' => 'reviewx_template_two_avatar_box_shadow_position reviewx-select',
            ),
            'choices'  => array(
                'inset'   	=> __( 'Inset', 'reviewx' ),
                ''    => __( 'Outline', 'reviewx' ),
            )
        ) ) );
        
        $wp_customize->add_setting( 'reviewx_template_two_avatar_border_style', array(
            'default'       => $defaults['reviewx_template_two_avatar_border_style'],
            'capability'    => 'edit_theme_options',
            'transport' => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_select',
            'priority'  => 68
        ) );    
        
        $wp_customize->add_control( new ReviewX_Select_Control(
            $wp_customize, 'reviewx_template_two_avatar_border_style', array(
            'type'     => 'reviewx-select',
            'section'  => 'reviewx_advanced_designs_page_settings',
            'settings' => 'reviewx_template_two_avatar_border_style',
            'label'    => __( 'Border Style', 'reviewx' ),
            'priority' => 69,
            'input_attrs' => array(
                'class' => 'reviewx_template_two_avatar_border_style reviewx-select',
            ),
            'choices'  => array(
                'solid'   	=> __( 'Solid', 'reviewx' ),
                'double'    => __( 'Double', 'reviewx' ),
                'dashed'    => __( 'Dashed', 'reviewx' ),
                'dotted'    => __( 'Dotted', 'reviewx' ),
            )
        ) ) );
    
        $wp_customize->add_setting( 'reviewx_template_two_avatar_border_color' , array(
            'default'     => $defaults['reviewx_template_two_avatar_border_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );
    
        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_two_avatar_border_color',
            array(
                'label'      => __( 'Border Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_two_avatar_border_color',
                'priority' => 70,
            ) )
        );
        
        $wp_customize->add_setting( 'reviewx_template_two_avatar_border_weight', array(
            'default'       => $defaults['reviewx_template_two_avatar_border_weight'],
            'capability'    => 'edit_theme_options',
            'transport' => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_integer'
        ) );     
        
        $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
            $wp_customize, 'reviewx_template_two_avatar_border_weight', array(
            'type'     => 'reviewx-range-value',
            'section'  => 'reviewx_advanced_designs_page_settings',
            'settings' => 'reviewx_template_two_avatar_border_weight',
            'label'    => __( 'Border Weight', 'reviewx' ),
            'input_attrs' => array(
                'min'    => 0,
                'max'    => 100,
                'step'   => 1,
                'suffix' => 'px', //optional suffix
            ),
            'priority' => 71,
        ) ) );

        $wp_customize->add_setting( 'reviewx_template_two_reviewer_name_color' , array(
            'default'     => $defaults['reviewx_template_two_reviewer_name_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );

        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_two_reviewer_name_color',
            array(
                'label'      => __( 'Reviewer Name Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_two_reviewer_name_color',
                'priority' => 72,
            ) )
        );        
        
        $wp_customize->add_setting( 'reviewx_template_two_reviewer_name_font_size', array(
            'default'           => $defaults['reviewx_template_two_reviewer_name_font_size'],
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_integer'
    
        ) );
    
        $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
            $wp_customize, 'reviewx_template_two_reviewer_name_font_size', array(
            'type'              => 'reviewx-range-value',
            'section'           => 'reviewx_advanced_designs_page_settings',
            'settings'          => 'reviewx_template_two_reviewer_name_font_size',
            'label'             => __( 'Reviewer Name Font Size', 'reviewx' ),
            'input_attrs'       => array(
                'min'    => 0,
                'max'    => 50,
                'step'   => 1,
                'suffix' => 'px', //optional suffix
            ),
            'priority' => 73,
        ) ) );  
        
        $wp_customize->add_setting( 'reviewx_template_two_rating_color' , array(
            'default'     => $defaults['reviewx_template_two_rating_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );
    
        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_two_rating_color',
            array(
                'label'      => __( 'Rating Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_two_rating_color',
                'priority' => 74,
            ) )
        );
        

        $wp_customize->add_setting( 'reviewx_template_two_star_rating_size', array(
            'default'           => $defaults['reviewx_template_two_star_rating_size'],
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_integer'
    
        ) );
    
        $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
            $wp_customize, 'reviewx_template_two_star_rating_size', array(
            'type'              => 'reviewx-range-value',
            'section'           => 'reviewx_advanced_designs_page_settings',
            'settings'          => 'reviewx_template_two_star_rating_size',
            'label'             => __( 'Star Rating Size', 'reviewx' ),
            'input_attrs'       => array(
                'min'    => 0,
                'max'    => 100,
                'step'   => 1,
                'suffix' => 'px', //optional suffix
            ),
            'priority' => 75,
        ) ) );
        
        $wp_customize->add_setting( 'reviewx_template_two_title_color' , array(
            'default'     => $defaults['reviewx_template_two_title_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );
    
        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_two_title_color',
            array(
                'label'      => __( 'Review Title Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_two_title_color',
                'priority' => 76,
            ) )
        ); 
        
        $wp_customize->add_setting( 'reviewx_template_two_title_font_size', array(
            'default'           => $defaults['reviewx_template_two_title_font_size'],
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_integer'
    
        ) );
    
        $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
            $wp_customize, 'reviewx_template_two_title_font_size', array(
            'type'              => 'reviewx-range-value',
            'section'           => 'reviewx_advanced_designs_page_settings',
            'settings'          => 'reviewx_template_two_title_font_size',
            'label'             => __( 'Review Title Font Size', 'reviewx' ),
            'input_attrs'       => array(
                'min'    => 0,
                'max'    => 100,
                'step'   => 1,
                'suffix' => 'px', //optional suffix
            ),
            'priority' => 77,
        ) ) );  
        
        $wp_customize->add_setting( 'reviewx_template_two_review_text_color' , array(
            'default'     => $defaults['reviewx_template_two_review_text_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );
    
        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_two_review_text_color',
            array(
                'label'      => __( 'Review Text Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_two_review_text_color',
                'priority' => 78,
            ) )
        ); 
        
        $wp_customize->add_setting( 'reviewx_template_two_review_text_font_size', array(
            'default'           => $defaults['reviewx_template_two_review_text_font_size'],
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_integer'
    
        ) );
    
        $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
            $wp_customize, 'reviewx_template_two_review_text_font_size', array(
            'type'              => 'reviewx-range-value',
            'section'           => 'reviewx_advanced_designs_page_settings',
            'settings'          => 'reviewx_template_two_review_text_font_size',
            'label'             => __( 'Review Text Font Size', 'reviewx' ),
            'input_attrs'       => array(
                'min'    => 0,
                'max'    => 100,
                'step'   => 1,
                'suffix' => 'px', //optional suffix
            ),
            'priority' => 79,
        ) ) ); 
        
        $wp_customize->add_setting( 'reviewx_template_two_background_color' , array(
            'default'     => $defaults['reviewx_template_two_background_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );
    
        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_two_background_color',
            array(
                'label'      => __( 'Review Container Background Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_two_background_color',
                'priority' => 80,
            ) )
        ); 
        
        $wp_customize->add_setting( 'reviewx_template_two_border_color' , array(
            'default'     => $defaults['reviewx_template_two_border_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );
    
        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_two_border_color',
            array(
                'label'      => __( 'Review Container Border Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_two_border_color',
                'priority' => 81,
            ) )
        );  
        
        $wp_customize->add_setting('reviewx_item_meta', array(
           // 'default'           => $defaults['reviewx_item_meta'],
            'sanitize_callback' => 'esc_html',
        ));	

        // Review Meta
    
        $wp_customize->add_control(new ReviewX_Separator_Custom_Control(
            $wp_customize, 'reviewx_item', array(
            'label'	            => esc_html__( 'Review Meta', 'reviewx' ),
            'settings'	        => 'reviewx_item_meta',
            'section'  	        => 'reviewx_advanced_designs_page_settings',
            'priority'          => 82
        )));  
        
        $wp_customize->add_setting( 'reviewx_template_two_date_icon_color' , array(
            'default'     => $defaults['reviewx_template_two_date_icon_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );
    
        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_two_date_icon_color',
            array(
                'label'      => __( 'Review Date Icon Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_two_date_icon_color',
                'priority' => 83,
            ) )
        );  
        
        $wp_customize->add_setting( 'reviewx_template_two_date_text_color' , array(
            'default'     => $defaults['reviewx_template_two_date_text_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );
    
        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_two_date_text_color',
            array(
                'label'      => __( 'Review Date Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_two_date_text_color',
                'priority' => 84,
            ) )
        );   
        
        $wp_customize->add_setting( 'reviewx_template_two_date_font_size', array(
            'default'           => $defaults['reviewx_template_two_date_font_size'],
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_integer'
    
        ) );
    
        $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
            $wp_customize, 'reviewx_template_two_date_font_size', array(
            'type'              => 'reviewx-range-value',
            'section'           => 'reviewx_advanced_designs_page_settings',
            'settings'          => 'reviewx_template_two_date_font_size',
            'label'             => __( 'Review Date Font Size', 'reviewx' ),
            'input_attrs'       => array(
                'min'    => 0,
                'max'    => 100,
                'step'   => 1,
                'suffix' => 'px', //optional suffix
            ),
            'priority' => 85,
        ) ) );

        $wp_customize->add_setting( 'reviewx_template_two_verified_icon_color' , array(
            'default'     => $defaults['reviewx_template_two_verified_icon_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );        
        
        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_two_verified_icon_color',
            array(
                'label'      => __( 'Verified Icon Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_two_verified_icon_color',
                'priority' => 86,
            ) )
        );  
        
        $wp_customize->add_setting( 'reviewx_template_two_verified_text_color' , array(
            'default'     => $defaults['reviewx_template_two_verified_text_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );
    
        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_two_verified_text_color',
            array(
                'label'      => __( 'Verified Badge Text Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_two_verified_text_color',
                'priority' => 87,
            ) )
        );   
        
        $wp_customize->add_setting( 'reviewx_template_two_verified_font_size', array(
            'default'           => $defaults['reviewx_template_two_verified_font_size'],
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_integer'
    
        ) );
    
        $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
            $wp_customize, 'reviewx_template_two_verified_font_size', array(
            'type'              => 'reviewx-range-value',
            'section'           => 'reviewx_advanced_designs_page_settings',
            'settings'          => 'reviewx_template_two_verified_font_size',
            'label'             => __( 'Verified Badge Font Size', 'reviewx' ),
            'input_attrs'       => array(
                'min'    => 0,
                'max'    => 100,
                'step'   => 1,
                'suffix' => 'px', //optional suffix
            ),
            'priority' => 88,
        ) ) );

        // Load pro review meta
        if( class_exists('ReviewXPro') ) {
            $wp_customize->add_setting( 'reviewx_template_two_helpful_text_color' , array(
                'default'     => $defaults['reviewx_template_two_helpful_text_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );

            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_two_helpful_text_color',
                array(
                    'label'      => __( 'Helpful Text Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_two_helpful_text_color',
                    'priority' => 89,
                ) )
            );   

            $wp_customize->add_setting( 'reviewx_template_two_helpful_font_size', array(
                'default'           => $defaults['reviewx_template_two_helpful_font_size'],
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_integer'
            ) );

            $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
                $wp_customize, 'reviewx_template_two_helpful_font_size', array(
                'type'              => 'reviewx-range-value',
                'section'           => 'reviewx_advanced_designs_page_settings',
                'settings'          => 'reviewx_template_two_helpful_font_size',
                'label'             => __( 'Helpful Text Font Size', 'reviewx' ),
                'input_attrs'       => array(
                    'min'    => 0,
                    'max'    => 100,
                    'step'   => 1,
                    'suffix' => 'px', //optional suffix
                ),
                'priority' => 90,
            ) ) );

            $wp_customize->add_setting( 'reviewx_template_two_helpful_button_bgcolor' , array(
                'default'     => $defaults['reviewx_template_two_helpful_button_bgcolor'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );

            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_two_helpful_button_bgcolor',
                array(
                    'label'      => __( 'Helpful Button Background Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_two_helpful_button_bgcolor',
                    'priority' => 91,
                ) )
            ); 
            
            $wp_customize->add_setting( 'reviewx_template_two_helpful_thumbsup_color' , array(
                'default'     => $defaults['reviewx_template_two_helpful_thumbsup_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );

            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_two_helpful_thumbsup_color',
                array(
                    'label'      => __( 'Helpful Thumbs-up Icon Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_two_helpful_thumbsup_color',
                    'priority' => 92,
                ) )
            );   
            
            $wp_customize->add_setting( 'reviewx_template_two_helpful_thumbsup_count_color' , array(
                'default'     => $defaults['reviewx_template_two_helpful_thumbsup_count_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );

            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_two_helpful_thumbsup_count_color',
                array(
                    'label'      => __( 'Helpful Thumbs-up Count Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_two_helpful_thumbsup_count_color',
                    'priority' => 93,
                ) )
            );  
            
            $wp_customize->add_setting( 'reviewx_template_two_share_text_color' , array(
                'default'     => $defaults['reviewx_template_two_share_text_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );

            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_two_share_text_color',
                array(
                    'label'      => __( 'Share Text Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_two_share_text_color',
                    'priority' => 94,
                ) )
            );

            $wp_customize->add_setting( 'reviewx_template_two_share_text_font_size', array(
                'default'           => $defaults['reviewx_template_two_share_text_font_size'],
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_integer'

            ) );

            $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
                $wp_customize, 'reviewx_template_two_share_text_font_size', array(
                'type'              => 'reviewx-range-value',
                'section'           => 'reviewx_advanced_designs_page_settings',
                'settings'          => 'reviewx_template_two_share_text_font_size',
                'label'             => __( 'Share Text Font Size', 'reviewx' ),
                'input_attrs'       => array(
                    'min'    => 0,
                    'max'    => 100,
                    'step'   => 1,
                    'suffix' => 'px', //optional suffix
                ),
                'priority' => 95,
            ) ) ); 
            
            $wp_customize->add_setting( 'reviewx_template_two_share_icon_color' , array(
                'default'     => $defaults['reviewx_template_two_share_icon_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );

            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_two_share_icon_color',
                array(
                    'label'      => __( 'Share Icon Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_two_share_icon_color',
                    'priority' => 96,
                ) )
            ); 
            
            $wp_customize->add_setting( 'reviewx_template_two_facebook_icon_color' , array(
                'default'     => $defaults['reviewx_template_two_facebook_icon_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );

            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_two_facebook_icon_color',
                array(
                    'label'      => __( 'Facebook Icon Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_two_facebook_icon_color',
                    'priority' => 97,
                ) )
            );  
            
            $wp_customize->add_setting( 'reviewx_template_two_twitter_icon_color' , array(
                'default'     => $defaults['reviewx_template_two_twitter_icon_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );

            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_two_twitter_icon_color',
                array(
                    'label'      => __( 'Twiiter Icon Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_two_twitter_icon_color',
                    'priority' => 98,
                ) )
            ); 
            
            $wp_customize->add_setting( 'reviewx_template_two_highlight_icon_color' , array(
                'default'     => $defaults['reviewx_template_two_highlight_icon_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );

            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_two_highlight_icon_color',
                array(
                    'label'      => __( 'Highlight Icon Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_two_highlight_icon_color',
                    'priority' => 99,
                ) )
            ); 
            
            $wp_customize->add_setting( 'reviewx_template_two_highlight_color' , array(
                'default'     => $defaults['reviewx_template_two_highlight_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );

            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_two_highlight_color',
                array(
                    'label'      => __( 'Highlight Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_two_highlight_color',
                    'priority' => 100,
                ) )
            );             
        } 
        
        $wp_customize->add_setting('reviewx_attachment_align', array(
            'default'           => $defaults['reviewx_attachment_align'],
            'sanitize_callback' => 'esc_html',
        ));	
    
        $wp_customize->add_control(new ReviewX_Separator_Custom_Control(
            $wp_customize, 'reviewx_attachment_align', array(
            'label'	            => esc_html__( 'Review Attachment', 'reviewx' ),
            'settings'	        => 'reviewx_attachment_align',
            'section'  	        => 'reviewx_advanced_designs_page_settings',
            'priority'          => 101
        )));

        $wp_customize->add_setting( 'reviewx_template_two_attachment_align', array(
            'default'       => $defaults['reviewx_template_two_attachment_align'],
            'capability'    => 'edit_theme_options',
            'transport' => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_select',
            'priority'  => 102
        ) );    
        
        $wp_customize->add_control( new ReviewX_Select_Control(
            $wp_customize, 'reviewx_template_two_attachment_align', array(
            'type'     => 'reviewx-select',
            'section'  => 'reviewx_advanced_designs_page_settings',
            'settings' => 'reviewx_template_two_attachment_align',
            'label'    => __( 'Align', 'reviewx' ),
            'priority' => 103,
            'input_attrs' => array(
                'class' => 'reviewx_template_two_attachment_align reviewx-select',
            ),
            'choices'  => array(
                'flex-start'  => __( 'Left', 'reviewx' ),
                'flex-end'    => __( 'Right', 'reviewx' ),
            )
        ) ) );        


        // Load review reply in pro
        if( class_exists('ReviewXPro') ) {
            
            $wp_customize->add_setting('reviewx_store_reply', array(
                'default'           => $defaults['reviewx_store_reply'],
                'sanitize_callback' => 'esc_html',
            ));	
        
            $wp_customize->add_control(new ReviewX_Separator_Custom_Control(
                $wp_customize, 'reviewx_store_reply', array(
                'label'	            => esc_html__( 'Store Reply', 'reviewx' ),
                'settings'	        => 'reviewx_store_reply',
                'section'  	        => 'reviewx_advanced_designs_page_settings',
                'priority'          => 104
            )));

            $wp_customize->add_setting( 'reviewx_template_two_store_logo_color' , array(
                'default'     => $defaults['reviewx_template_two_store_logo_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );
        
            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_two_store_logo_color',
                array(
                    'label'      => __( 'Store Logo Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_two_store_logo_color',
                    'priority' => 105,
                ) )
            );  

            $wp_customize->add_setting( 'reviewx_template_two_store_logo_bg_color' , array(
                'default'     => $defaults['reviewx_template_two_store_logo_bg_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );
        
            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_two_store_logo_bg_color',
                array(
                    'label'      => __( 'Store Logo Background Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_two_store_logo_bg_color',
                    'priority' => 106,
                ) )
            ); 

            $wp_customize->add_setting( 'reviewx_template_two_store_logo_border_radius', array(
                'default'           => $defaults['reviewx_template_two_store_logo_border_radius'],
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_integer'
        
            ) );
        
            $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
                $wp_customize, 'reviewx_template_two_store_logo_border_radius', array(
                'type'              => 'reviewx-range-value',
                'section'           => 'reviewx_advanced_designs_page_settings',
                'settings'          => 'reviewx_template_two_store_logo_border_radius',
                'label'             => __( 'Store Logo Border Radius', 'reviewx' ),
                'input_attrs'       => array(
                    'min'    => 0,
                    'max'    => 100,
                    'step'   => 1,
                    'suffix' => 'px', //optional suffix
                ),
                'priority' => 107,
            ) ) ); 
            
            $wp_customize->add_setting( 'reviewx_template_two_store_name_color' , array(
                'default'     => $defaults['reviewx_template_two_store_name_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );
        
            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_two_store_name_color',
                array(
                    'label'      => __( 'Store Name Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_two_store_name_color',
                    'priority' => 108,
                ) )
            );
            
            $wp_customize->add_setting( 'reviewx_template_two_store_name_font_size', array(
                'default'           => $defaults['reviewx_template_two_store_name_font_size'],
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_integer'
        
            ) );
        
            $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
                $wp_customize, 'reviewx_template_two_store_name_font_size', array(
                'type'              => 'reviewx-range-value',
                'section'           => 'reviewx_advanced_designs_page_settings',
                'settings'          => 'reviewx_template_two_store_name_font_size',
                'label'             => __( 'Store Name Font Size', 'reviewx' ),
                'input_attrs'       => array(
                    'min'    => 0,
                    'max'    => 100,
                    'step'   => 1,
                    'suffix' => 'px', //optional suffix
                ),
                'priority' => 109,
            ) ) ); 
            
            $wp_customize->add_setting( 'reviewx_template_two_replay_back_icon_color' , array(
                'default'     => $defaults['reviewx_template_two_replay_back_icon_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );
        
            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_two_replay_back_icon_color',
                array(
                    'label'      => __( 'Reply Back Icon Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_two_replay_back_icon_color',
                    'priority' => 110,
                ) )
            ); 
            
            $wp_customize->add_setting( 'reviewx_template_two_reply_text_color' , array(
                'default'     => $defaults['reviewx_template_two_reply_text_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );
        
            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_two_reply_text_color',
                array(
                    'label'      => __( 'Reply Text Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_two_reply_text_color',
                    'priority' => 111,
                ) )
            );  
            
            $wp_customize->add_setting( 'reviewx_template_two_reply_text_font_size', array(
                'default'           => $defaults['reviewx_template_two_reply_text_font_size'],
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_integer'
        
            ) );
        
            $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
                $wp_customize, 'reviewx_template_two_reply_text_font_size', array(
                'type'              => 'reviewx-range-value',
                'section'           => 'reviewx_advanced_designs_page_settings',
                'settings'          => 'reviewx_template_two_reply_text_font_size',
                'label'             => __( 'Reply Text Font Size', 'reviewx' ),
                'input_attrs'       => array(
                    'min'    => 0,
                    'max'    => 100,
                    'step'   => 1,
                    'suffix' => 'px', //optional suffix
                ),
                'priority' => 112,
            ) ) );  
            
            $wp_customize->add_setting( 'reviewx_template_two_reply_date_color' , array(
                'default'     => $defaults['reviewx_template_two_reply_date_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );
        
            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_two_reply_date_color',
                array(
                    'label'      => __( 'Reply Date Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_two_reply_date_color',
                    'priority' => 113,
                ) )
            ); 
            
            $wp_customize->add_setting( 'reviewx_template_two_reply_date_font_size', array(
                'default'           => $defaults['reviewx_template_two_reply_date_font_size'],
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_integer'
        
            ) );
        
            $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
                $wp_customize, 'reviewx_template_two_reply_date_font_size', array(
                'type'              => 'reviewx-range-value',
                'section'           => 'reviewx_advanced_designs_page_settings',
                'settings'          => 'reviewx_template_two_reply_date_font_size',
                'label'             => __( 'Reply Date Font Size', 'reviewx' ),
                'input_attrs'       => array(
                    'min'    => 0,
                    'max'    => 100,
                    'step'   => 1,
                    'suffix' => 'px', //optional suffix
                ),
                'priority' => 114,
            ) ) ); 
            
            $wp_customize->add_setting( 'reviewx_template_two_reply_date_icon_color' , array(
                'default'     => $defaults['reviewx_template_two_reply_date_icon_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );
        
            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_two_reply_date_icon_color',
                array(
                    'label'      => __( 'Reply Date Icon Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_two_reply_date_icon_color',
                    'priority' => 115,
                ) )
            ); 
            
            $wp_customize->add_setting( 'reviewx_template_two_reply_edit_icon_color' , array(
                'default'     => $defaults['reviewx_template_two_reply_edit_icon_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );
        
            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_two_reply_edit_icon_color',
                array(
                    'label'      => __( 'Reply Edit Icon Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_two_reply_edit_icon_color',
                    'priority' => 116,
                ) )
            ); 
            
            $wp_customize->add_setting( 'reviewx_template_two_reply_delete_icon_color' , array(
                'default'     => $defaults['reviewx_template_two_reply_delete_icon_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );
        
            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_two_reply_delete_icon_color',
                array(
                    'label'      => __( 'Reply Delete Icon Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_two_reply_delete_icon_color',
                    'priority' => 117,
                ) )
            );  
            
            $wp_customize->add_setting( 'reviewx_template_two_reply_button_text_color' , array(
                'default'     => $defaults['reviewx_template_two_reply_button_text_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );
        
            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_two_reply_button_text_color',
                array(
                    'label'      => __( 'Reply Button Text Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_two_reply_button_text_color',
                    'priority' => 118,
                ) )
            ); 
            
            $wp_customize->add_setting( 'reviewx_template_two_reply_button_text_font_size', array(
                'default'           => $defaults['reviewx_template_two_reply_button_text_font_size'],
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_integer'
        
            ) );
        
            $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
                $wp_customize, 'reviewx_template_two_reply_button_text_font_size', array(
                'type'              => 'reviewx-range-value',
                'section'           => 'reviewx_advanced_designs_page_settings',
                'settings'          => 'reviewx_template_two_reply_button_text_font_size',
                'label'             => __( 'Reply Button Text Font Size', 'reviewx' ),
                'input_attrs'       => array(
                    'min'    => 0,
                    'max'    => 100,
                    'step'   => 1,
                    'suffix' => 'px', //optional suffix
                ),
                'priority' => 119,
            ) ) ); 
            
            $wp_customize->add_setting( 'reviewx_template_two_reply_button_bg_color' , array(
                'default'     => $defaults['reviewx_template_two_reply_button_bg_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );
        
            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_two_reply_button_bg_color',
                array(
                    'label'      => __( 'Reply Button Background Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_two_reply_button_bg_color',
                    'priority' => 120,
                ) )
            );
            
            $wp_customize->add_setting( 'reviewx_template_two_reply_button_border_color' , array(
                'default'     => $defaults['reviewx_template_two_reply_button_border_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );
        
            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_two_reply_button_border_color',
                array(
                    'label'      => __( 'Reply Button Border Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_two_reply_button_border_color',
                    'priority' => 121,
                ) )
            ); 
            
            $wp_customize->add_setting( 'reviewx_template_two_reply_background_color' , array(
                'default'     => $defaults['reviewx_template_two_reply_background_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );
        
            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_two_reply_background_color',
                array(
                    'label'      => __( 'Reply Background Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_two_reply_background_color',
                    'priority' => 122,
                ) )
            ); 
            
            $wp_customize->add_setting('reviewx_reply_form', array(
                'default'           => $defaults['reviewx_reply_form'],
                'sanitize_callback' => 'esc_html',
            ));	
        
            $wp_customize->add_control(new ReviewX_Separator_Custom_Control(
                $wp_customize, 'reviewx_reply_form', array(
                'label'	            => esc_html__( 'Reply Form', 'reviewx' ),
                'settings'	        => 'reviewx_reply_form',
                'section'  	        => 'reviewx_advanced_designs_page_settings',
                'priority'          => 123
            ))); 
            
            $wp_customize->add_setting( 'reviewx_template_two_reply_form_background_color' , array(
                'default'     => $defaults['reviewx_template_two_reply_form_background_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );
        
            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_two_reply_form_background_color',
                array(
                    'label'      => __( 'Reply Form Background Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_two_reply_form_background_color',
                    'priority' => 124,
                ) )
            ); 
            
            $wp_customize->add_setting( 'reviewx_template_two_reply_form_border_color' , array(
                'default'     => $defaults['reviewx_template_two_reply_form_border_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );
        
            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_two_reply_form_border_color',
                array(
                    'label'      => __( 'Reply Form Border Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_two_reply_form_border_color',
                    'priority' => 125,
                ) )
            ); 
            
            $wp_customize->add_setting( 'reviewx_template_two_reply_form_border_radius', array(
                'default'           => $defaults['reviewx_template_two_reply_form_border_radius'],
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_integer'
        
            ) );
        
            $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
                $wp_customize, 'reviewx_template_two_reply_form_border_radius', array(
                'type'              => 'reviewx-range-value',
                'section'           => 'reviewx_advanced_designs_page_settings',
                'settings'          => 'reviewx_template_two_reply_form_border_radius',
                'label'             => __( 'Reply Form Border Radius', 'reviewx' ),
                'input_attrs'       => array(
                    'min'    => 0,
                    'max'    => 100,
                    'step'   => 1,
                    'suffix' => 'px', //optional suffix
                ),
                'priority' => 126,
            ) ) );
            
            $wp_customize->add_setting( 'reviewx_template_two_reply_form_title_color' , array(
                'default'     => $defaults['reviewx_template_two_reply_form_title_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );
        
            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_two_reply_form_title_color',
                array(
                    'label'      => __( 'Reply Form Title Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_two_reply_form_title_color',
                    'priority' => 127,
                ) )
            ); 
            
            $wp_customize->add_setting( 'reviewx_template_two_reply_form_title_font_size', array(
                'default'           => $defaults['reviewx_template_two_reply_form_title_font_size'],
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_integer'
        
            ) );
        
            $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
                $wp_customize, 'reviewx_template_two_reply_form_title_font_size', array(
                'type'              => 'reviewx-range-value',
                'section'           => 'reviewx_advanced_designs_page_settings',
                'settings'          => 'reviewx_template_two_reply_form_title_font_size',
                'label'             => __( 'Reply Form Title Font Size', 'reviewx' ),
                'input_attrs'       => array(
                    'min'    => 0,
                    'max'    => 100,
                    'step'   => 1,
                    'suffix' => 'px', //optional suffix
                ),
                'priority' => 128,
            ) ) );  
            
            $wp_customize->add_setting( 'reviewx_template_two_reply_form_textarea_color' , array(
                'default'     => $defaults['reviewx_template_two_reply_form_textarea_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );
        
            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_two_reply_form_textarea_color',
                array(
                    'label'      => __( 'Reply Text Area Background Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_two_reply_form_textarea_color',
                    'priority' => 129,
                ) )
            );    

            $wp_customize->add_setting( 'reviewx_template_two_reply_form_submit_button_bgcolor' , array(
                'default'     => $defaults['reviewx_template_two_reply_form_submit_button_bgcolor'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );
        
            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_two_reply_form_submit_button_bgcolor',
                array(
                    'label'      => __( 'Reply Submit Button Background Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_two_reply_form_submit_button_bgcolor',
                    'priority' => 130,
                ) )
            );  

            $wp_customize->add_setting( 'reviewx_template_two_reply_form_submit_button_text_color' , array(
                'default'     => $defaults['reviewx_template_two_reply_form_submit_button_text_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );
        
            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_two_reply_form_submit_button_text_color',
                array(
                    'label'      => __( 'Reply Submit Button Text Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_two_reply_form_submit_button_text_color',
                    'priority' => 131,
                ) )
            ); 
            
            $wp_customize->add_setting( 'reviewx_template_two_reply_form_submit_button_font_size', array(
                'default'           => $defaults['reviewx_template_two_reply_form_submit_button_font_size'],
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_integer'
        
            ) );
        
            $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
                $wp_customize, 'reviewx_template_two_reply_form_submit_button_font_size', array(
                'type'              => 'reviewx-range-value',
                'section'           => 'reviewx_advanced_designs_page_settings',
                'settings'          => 'reviewx_template_two_reply_form_submit_button_font_size',
                'label'             => __( 'Reply Submit Button Font Size', 'reviewx' ),
                'input_attrs'       => array(
                    'min'    => 0,
                    'max'    => 100,
                    'step'   => 1,
                    'suffix' => 'px', //optional suffix
                ),
                'priority' => 132,
            ) ) );  
            
            $wp_customize->add_setting( 'reviewx_template_two_reply_form_cancel_button_bgcolor' , array(
                'default'     => $defaults['reviewx_template_two_reply_form_cancel_button_bgcolor'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );
        
            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_two_reply_form_cancel_button_bgcolor',
                array(
                    'label'      => __( 'Reply Cancel Button Background Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_two_reply_form_cancel_button_bgcolor',
                    'priority' => 133,
                ) )
            );  

            $wp_customize->add_setting( 'reviewx_template_two_reply_form_cancel_button_text_color' , array(
                'default'     => $defaults['reviewx_template_two_reply_form_cancel_button_text_color'],
                'capability'    => 'edit_theme_options',
                'transport'   => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_rgba',
            ) );
        
            $wp_customize->add_control(
                new ReviewX_Customizer_Alpha_Color_Control(
                $wp_customize,
                'reviewx_template_two_reply_form_cancel_button_text_color',
                array(
                    'label'      => __( 'Reply Cancel Button Text Color', 'reviewx' ),
                    'section'    => 'reviewx_advanced_designs_page_settings',
                    'settings'   => 'reviewx_template_two_reply_form_cancel_button_text_color',
                    'priority' => 134,
                ) )
            ); 
            
            $wp_customize->add_setting( 'reviewx_template_two_reply_form_cancel_button_font_size', array(
                'default'           => $defaults['reviewx_template_two_reply_form_cancel_button_font_size'],
                'capability'        => 'edit_theme_options',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'reviewx_sanitize_integer'
        
            ) );
        
            $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
                $wp_customize, 'reviewx_template_two_reply_form_cancel_button_font_size', array(
                'type'              => 'reviewx-range-value',
                'section'           => 'reviewx_advanced_designs_page_settings',
                'settings'          => 'reviewx_template_two_reply_form_cancel_button_font_size',
                'label'             => __( 'Reply Cancel Button Font Size', 'reviewx' ),
                'input_attrs'       => array(
                    'min'    => 0,
                    'max'    => 100,
                    'step'   => 1,
                    'suffix' => 'px', //optional suffix
                ),
                'priority' => 135,
            ) ) );              
        }

        // Pagination
        $wp_customize->add_setting('reviewx_pagination', array(
         //   'default'           => $defaults['reviewx_pagination'],
            'sanitize_callback' => 'esc_html',
        ));	
    
        $wp_customize->add_control(new ReviewX_Separator_Custom_Control(
            $wp_customize, 'reviewx_pagination', array(
            'label'	            => esc_html__( 'Pagination', 'reviewx' ),
            'settings'	        => 'reviewx_pagination',
            'section'  	        => 'reviewx_advanced_designs_page_settings',
            'priority'          => 136
        )));  
        
        $wp_customize->add_setting( 'reviewx_template_two_pagination_text_color' , array(
            'default'     => $defaults['reviewx_template_two_pagination_text_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );
    
        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_two_pagination_text_color',
            array(
                'label'      => __( 'Text Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_two_pagination_text_color',
                'priority' => 137,
            ) )
        ); 
        
        $wp_customize->add_setting( 'reviewx_template_two_pagination_font_size', array(
            'default'           => $defaults['reviewx_template_two_pagination_font_size'],
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_integer'
    
        ) );
    
        $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
            $wp_customize, 'reviewx_template_two_pagination_font_size', array(
            'type'              => 'reviewx-range-value',
            'section'           => 'reviewx_advanced_designs_page_settings',
            'settings'          => 'reviewx_template_two_pagination_font_size',
            'label'             => __( 'Pagination Font Size', 'reviewx' ),
            'input_attrs'       => array(
                'min'    => 0,
                'max'    => 100,
                'step'   => 1,
                'suffix' => 'px', //optional suffix
            ),
            'priority' => 138,
        ) ) ); 
        
        $wp_customize->add_setting( 'reviewx_template_two_pagination_bg_color' , array(
            'default'     => $defaults['reviewx_template_two_pagination_bg_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );
    
        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_two_pagination_bg_color',
            array(
                'label'      => __( 'Background Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_two_pagination_bg_color',
                'priority' => 139,
            ) )
        );   
        
        $wp_customize->add_setting( 'reviewx_template_two_pagination_active_color' , array(
            'default'     => $defaults['reviewx_template_two_pagination_active_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );
    
        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_two_pagination_active_color',
            array(
                'label'      => __( 'Active Text Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_two_pagination_active_color',
                'priority' => 140,
            ) )
        );  
        
        $wp_customize->add_setting( 'reviewx_template_two_pagination_active_bgcolor' , array(
            'default'     => $defaults['reviewx_template_two_pagination_active_bgcolor'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );
    
        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_two_pagination_active_bgcolor',
            array(
                'label'      => __( 'Active Background Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_two_pagination_active_bgcolor',
                'priority' => 141,
            ) )
        ); 
        
        $wp_customize->add_setting( 'reviewx_template_two_pagination_hover_text_color' , array(
            'default'     => $defaults['reviewx_template_two_pagination_hover_text_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );
    
        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_two_pagination_hover_text_color',
            array(
                'label'      => __( 'Hover Text Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_two_pagination_hover_text_color',
                'priority' => 142,
            ) )
        );  
        
        $wp_customize->add_setting( 'reviewx_template_two_pagination_hover_bgcolor' , array(
            'default'     => $defaults['reviewx_template_two_pagination_hover_bgcolor'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );
    
        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_two_pagination_hover_bgcolor',
            array(
                'label'      => __( 'Hover Background Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_two_pagination_hover_bgcolor',
                'priority' => 143,
            ) )
        ); 
        
        $wp_customize->add_setting('reviewx_form', array(
            'default'           => $defaults['reviewx_form'],
            'sanitize_callback' => 'esc_html',
        ));	
    
        $wp_customize->add_control(new ReviewX_Separator_Custom_Control(
            $wp_customize, 'reviewx_form', array(
            'label'	            => esc_html__( 'Review Form', 'reviewx' ),
            'settings'	        => 'reviewx_form',
            'section'  	        => 'reviewx_advanced_designs_page_settings',
            'priority'          => 144
        )));        

        $wp_customize->add_setting( 'reviewx_template_two_criteria_text_color' , array(
            'default'     => $defaults['reviewx_template_two_criteria_text_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );
    
        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_two_criteria_text_color',
            array(
                'label'      => __( 'Criteria Text Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_two_criteria_text_color',
                'priority' => 145,
            ) )
        ); 
        
        $wp_customize->add_setting( 'reviewx_template_two_criteria_text_font_size', array(
            'default'           => $defaults['reviewx_template_two_criteria_text_font_size'],
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_integer'
    
        ) );
    
        $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
            $wp_customize, 'reviewx_template_two_criteria_text_font_size', array(
            'type'              => 'reviewx-range-value',
            'section'           => 'reviewx_advanced_designs_page_settings',
            'settings'          => 'reviewx_template_two_criteria_text_font_size',
            'label'             => __( 'Criteria Text Font Size', 'reviewx' ),
            'input_attrs'       => array(
                'min'    => 0,
                'max'    => 100,
                'step'   => 1,
                'suffix' => 'px', //optional suffix
            ),
            'priority' => 146,
        ) ) );  
        
        $wp_customize->add_setting( 'reviewx_template_two_form_rating_icon_color' , array(
            'default'     => $defaults['reviewx_template_two_form_rating_icon_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );
    
        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_two_form_rating_icon_color',
            array(
                'label'      => __( 'Rating Icon Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_two_form_rating_icon_color',
                'priority' => 147,
            ) )
        );  

        $wp_customize->add_setting( 'reviewx_template_two_criteria_icon_size', array(
            'default'           => $defaults['reviewx_template_two_criteria_icon_size'],
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_integer'
    
        ) );
    
        $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
            $wp_customize, 'reviewx_template_two_criteria_icon_size', array(
            'type'              => 'reviewx-range-value',
            'section'           => 'reviewx_advanced_designs_page_settings',
            'settings'          => 'reviewx_template_two_criteria_icon_size',
            'label'             => __( 'Rating Icon Size', 'reviewx' ),
            'input_attrs'       => array(
                'min'    => 0,
                'max'    => 100,
                'step'   => 1,
                'suffix' => 'px', //optional suffix
            ),
            'priority' => 148,
        ) ) );          
        
        $wp_customize->add_setting( 'reviewx_template_two_form_recommendation_icon_active_color' , array(
            'default'     => $defaults['reviewx_template_two_form_recommendation_icon_active_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );
    
        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_two_form_recommendation_icon_active_color',
            array(
                'label'      => __( 'Recommendation Icon Active Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_two_form_recommendation_icon_active_color',
                'priority' => 149,
            ) )
        ); 
        
        $wp_customize->add_setting( 'reviewx_template_two_form_external_video_link_color' , array(
            'default'     => $defaults['reviewx_template_two_form_external_video_link_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );
    
        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_two_form_external_video_link_color',
            array(
                'label'      => __( 'External Example Video Link Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_two_form_external_video_link_color',
                'priority' => 150,
            ) )
        );  
        
        $wp_customize->add_setting( 'reviewx_template_two_form_external_video_font_size', array(
            'default'           => $defaults['reviewx_template_two_form_external_video_font_size'],
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_integer'
    
        ) );
    
        $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
            $wp_customize, 'reviewx_template_two_form_external_video_font_size', array(
            'type'              => 'reviewx-range-value',
            'section'           => 'reviewx_advanced_designs_page_settings',
            'settings'          => 'reviewx_template_two_form_external_video_font_size',
            'label'             => __( 'External Example Video Link Font Size', 'reviewx' ),
            'input_attrs'       => array(
                'min'    => 0,
                'max'    => 100,
                'step'   => 1,
                'suffix' => 'px', //optional suffix
            ),
            'priority' => 151,
        ) ) );  

//Media upload compliance 
$wp_customize->add_setting( 'reviewx_template_two_media_upload_compliance_text_color' , array(
    'default'     => $defaults['reviewx_template_two_media_upload_compliance_text_color'],
    'capability'    => 'edit_theme_options',
    'transport'   => 'postMessage',
    'sanitize_callback' => 'reviewx_sanitize_rgba',
) );

$wp_customize->add_control(
    new ReviewX_Customizer_Alpha_Color_Control(
    $wp_customize,
    'reviewx_template_two_media_upload_compliance_text_color',
    array(
        'label'      => __( 'Media Upload Compliance Text Color', 'reviewx' ),
        'section'    => 'reviewx_advanced_designs_page_settings',
        'settings'   => 'reviewx_template_two_media_upload_compliance_text_color',
        'priority' => 152,
    ) )
);  

$wp_customize->add_setting( 'reviewx_template_two_media_upload_compliance_font_size', array(
    'default'           => $defaults['reviewx_template_two_media_upload_compliance_font_size'],
    'capability'        => 'edit_theme_options',
    'transport'         => 'postMessage',
    'sanitize_callback' => 'reviewx_sanitize_integer'

) );

$wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
    $wp_customize, 'reviewx_template_two_media_upload_compliance_font_size', array(
    'type'              => 'reviewx-range-value',
    'section'           => 'reviewx_advanced_designs_page_settings',
    'settings'          => 'reviewx_template_two_media_upload_compliance_font_size',
    'label'             => __( 'Media Upload Compliance Text Font Size', 'reviewx' ),
    'input_attrs'       => array(
        'min'    => 0,
        'max'    => 100,
        'step'   => 1,
        'suffix' => 'px', //optional suffix
    ),
    'priority' => 153,
) ) );        
        
        $wp_customize->add_setting( 'reviewx_template_two_form_submit_button_text_color' , array(
            'default'     => $defaults['reviewx_template_two_form_submit_button_text_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );
    
        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_two_form_submit_button_text_color',
            array(
                'label'      => __( 'Submit Button Text Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_two_form_submit_button_text_color',
                'priority' => 154,
            ) )
        );  
        
        $wp_customize->add_setting( 'reviewx_template_two_form_submit_button_font_size', array(
            'default'           => $defaults['reviewx_template_two_form_submit_button_font_size'],
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_integer'
    
        ) );
    
        $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
            $wp_customize, 'reviewx_template_two_form_submit_button_font_size', array(
            'type'              => 'reviewx-range-value',
            'section'           => 'reviewx_advanced_designs_page_settings',
            'settings'          => 'reviewx_template_two_form_submit_button_font_size',
            'label'             => __( 'Submit Button Text Font Size', 'reviewx' ),
            'input_attrs'       => array(
                'min'    => 0,
                'max'    => 100,
                'step'   => 1,
                'suffix' => 'px', //optional suffix
            ),
            'priority' => 155,
        ) ) );  
        
        $wp_customize->add_setting( 'reviewx_template_two_form_submit_button_bg_color' , array(
            'default'     => $defaults['reviewx_template_two_form_submit_button_bg_color'],
            'capability'    => 'edit_theme_options',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );
    
        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_two_form_submit_button_bg_color',
            array(
                'label'      => __( 'Submit Button Background Color', 'reviewx' ),
                'section'    => 'reviewx_advanced_designs_page_settings',
                'settings'   => 'reviewx_template_two_form_submit_button_bg_color',
                'priority' => 156,
            ) )
        );  
        
        $wp_customize->add_setting( 'reviewx_template_two_form_submit_button_border_radius', array(
            'default'           => $defaults['reviewx_template_two_form_submit_button_border_radius'],
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_integer'
    
        ) );
    
        $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
            $wp_customize, 'reviewx_template_two_form_submit_button_border_radius', array(
            'type'              => 'reviewx-range-value',
            'section'           => 'reviewx_advanced_designs_page_settings',
            'settings'          => 'reviewx_template_two_form_submit_button_border_radius',
            'label'             => __( 'Submit Button Border Radius', 'reviewx' ),
            'input_attrs'       => array(
                'min'    => 0,
                'max'    => 100,
                'step'   => 1,
                'suffix' => 'px', //optional suffix
            ),
            'priority' => 157,
        ) ) );          

    }

    /******************************************************
     * 
     *  Order Review Form
     * 
    *******************************************************/
    $wp_customize->add_setting('reviewx_order_form', array(
        'default'           => $defaults['reviewx_order_form'],
        'sanitize_callback' => 'esc_html',
    ));	

    $wp_customize->add_control(new ReviewX_Separator_Custom_Control(
        $wp_customize, 'reviewx_order_form', array(
        'label'	            => esc_html__( 'Order Review Form', 'reviewx' ),
        'settings'	        => 'reviewx_order_form',
        'section'  	        => 'reviewx_advanced_designs_page_settings',
        'priority'          => 158
    )));        

    $wp_customize->add_setting( 'reviewx_order_review_form_criteria_text_color' , array(
        'default'     => $defaults['reviewx_order_review_form_criteria_text_color'],
        'capability'    => 'edit_theme_options',
        'transport'   => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_rgba',
    ) );

    $wp_customize->add_control(
        new ReviewX_Customizer_Alpha_Color_Control(
        $wp_customize,
        'reviewx_order_review_form_criteria_text_color',
        array(
            'label'      => __( 'Criteria Text Color', 'reviewx' ),
            'section'    => 'reviewx_advanced_designs_page_settings',
            'settings'   => 'reviewx_order_review_form_criteria_text_color',
            'priority' => 159,
        ) )
    ); 
    
    $wp_customize->add_setting( 'reviewx_order_review_form_criteria_text_font_size', array(
        'default'           => $defaults['reviewx_order_review_form_criteria_text_font_size'],
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_integer'

    ) );

    $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
        $wp_customize, 'reviewx_order_review_form_criteria_text_font_size', array(
        'type'              => 'reviewx-range-value',
        'section'           => 'reviewx_advanced_designs_page_settings',
        'settings'          => 'reviewx_order_review_form_criteria_text_font_size',
        'label'             => __( 'Criteria Text Font Size', 'reviewx' ),
        'input_attrs'       => array(
            'min'    => 0,
            'max'    => 100,
            'step'   => 1,
            'suffix' => 'px', //optional suffix
        ),
        'priority' => 160,
    ) ) );  
    
    $wp_customize->add_setting( 'reviewx_order_review_form_rating_icon_color' , array(
        'default'     => $defaults['reviewx_order_review_form_rating_icon_color'],
        'capability'    => 'edit_theme_options',
        'transport'   => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_rgba',
    ) );

    $wp_customize->add_control(
        new ReviewX_Customizer_Alpha_Color_Control(
        $wp_customize,
        'reviewx_order_review_form_rating_icon_color',
        array(
            'label'      => __( 'Rating Icon Color', 'reviewx' ),
            'section'    => 'reviewx_advanced_designs_page_settings',
            'settings'   => 'reviewx_order_review_form_rating_icon_color',
            'priority' => 161,
        ) )
    );  

    $wp_customize->add_setting( 'reviewx_order_review_form_criteria_icon_size', array(
        'default'           => $defaults['reviewx_order_review_form_criteria_icon_size'],
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_integer'

    ) );

    $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
        $wp_customize, 'reviewx_order_review_form_criteria_icon_size', array(
        'type'              => 'reviewx-range-value',
        'section'           => 'reviewx_advanced_designs_page_settings',
        'settings'          => 'reviewx_order_review_form_criteria_icon_size',
        'label'             => __( 'Rating Icon Size', 'reviewx' ),
        'input_attrs'       => array(
            'min'    => 0,
            'max'    => 100,
            'step'   => 1,
            'suffix' => 'px', //optional suffix
        ),
        'priority' => 162,
    ) ) );          
    
    $wp_customize->add_setting( 'reviewx_order_review_form_recommendation_icon_active_color' , array(
        'default'     => $defaults['reviewx_order_review_form_recommendation_icon_active_color'],
        'capability'    => 'edit_theme_options',
        'transport'   => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_rgba',
    ) );

    $wp_customize->add_control(
        new ReviewX_Customizer_Alpha_Color_Control(
        $wp_customize,
        'reviewx_order_review_form_recommendation_icon_active_color',
        array(
            'label'      => __( 'Recommendation Icon Active Color', 'reviewx' ),
            'section'    => 'reviewx_advanced_designs_page_settings',
            'settings'   => 'reviewx_order_review_form_recommendation_icon_active_color',
            'priority' => 163,
        ) )
    ); 

    $wp_customize->add_setting( 'reviewx_order_review_form_recommendation_text_color' , array(
        'default'     => $defaults['reviewx_order_review_form_recommendation_text_color'],
        'capability'    => 'edit_theme_options',
        'transport'   => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_rgba',
    ) );

    $wp_customize->add_control(
        new ReviewX_Customizer_Alpha_Color_Control(
        $wp_customize,
        'reviewx_order_review_form_recommendation_text_color',
        array(
            'label'      => __( 'Recommendation Text Color', 'reviewx' ),
            'section'    => 'reviewx_advanced_designs_page_settings',
            'settings'   => 'reviewx_order_review_form_recommendation_text_color',
            'priority' => 164,
        ) )
    );

    $wp_customize->add_setting( 'reviewx_order_review_form_recommendation_text_font_size', array(
        'default'           => $defaults['reviewx_order_review_form_recommendation_text_font_size'],
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_integer'

    ) );

    $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
        $wp_customize, 'reviewx_order_review_form_recommendation_text_font_size', array(
        'type'              => 'reviewx-range-value',
        'section'           => 'reviewx_advanced_designs_page_settings',
        'settings'          => 'reviewx_order_review_form_recommendation_text_font_size',
        'label'             => __( 'Recommendation Text Font Size', 'reviewx' ),
        'input_attrs'       => array(
            'min'    => 0,
            'max'    => 100,
            'step'   => 1,
            'suffix' => 'px', //optional suffix
        ),
        'priority' => 165,
    ) ) );     
    
    $wp_customize->add_setting( 'reviewx_order_review_form_external_video_link_color' , array(
        'default'     => $defaults['reviewx_order_review_form_external_video_link_color'],
        'capability'    => 'edit_theme_options',
        'transport'   => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_rgba',
    ) );

    $wp_customize->add_control(
        new ReviewX_Customizer_Alpha_Color_Control(
        $wp_customize,
        'reviewx_order_review_form_external_video_link_color',
        array(
            'label'      => __( 'External Example Video Link Color', 'reviewx' ),
            'section'    => 'reviewx_advanced_designs_page_settings',
            'settings'   => 'reviewx_order_review_form_external_video_link_color',
            'priority' => 166,
        ) )
    );  
    
    $wp_customize->add_setting( 'reviewx_order_review_form_external_video_font_size', array(
        'default'           => $defaults['reviewx_order_review_form_external_video_font_size'],
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_integer'

    ) );

    $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
        $wp_customize, 'reviewx_order_review_form_external_video_font_size', array(
        'type'              => 'reviewx-range-value',
        'section'           => 'reviewx_advanced_designs_page_settings',
        'settings'          => 'reviewx_order_review_form_external_video_font_size',
        'label'             => __( 'External Example Video Link Font Size', 'reviewx' ),
        'input_attrs'       => array(
            'min'    => 0,
            'max'    => 100,
            'step'   => 1,
            'suffix' => 'px', //optional suffix
        ),
        'priority' => 167,
    ) ) );  
    
    // Submit button in my order review form
    $wp_customize->add_setting( 'reviewx_order_review_form_submit_button_text_color' , array(
        'default'     => $defaults['reviewx_order_review_form_submit_button_text_color'],
        'capability'    => 'edit_theme_options',
        'transport'   => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_rgba',
    ) );

    $wp_customize->add_control(
        new ReviewX_Customizer_Alpha_Color_Control(
        $wp_customize,
        'reviewx_order_review_form_submit_button_text_color',
        array(
            'label'      => __( 'Submit Button Text Color', 'reviewx' ),
            'section'    => 'reviewx_advanced_designs_page_settings',
            'settings'   => 'reviewx_order_review_form_submit_button_text_color',
            'priority' => 168,
        ) )
    );  
    
    $wp_customize->add_setting( 'reviewx_order_review_form_submit_button_font_size', array(
        'default'           => $defaults['reviewx_order_review_form_submit_button_font_size'],
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_integer'

    ) );

    $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
        $wp_customize, 'reviewx_order_review_form_submit_button_font_size', array(
        'type'              => 'reviewx-range-value',
        'section'           => 'reviewx_advanced_designs_page_settings',
        'settings'          => 'reviewx_order_review_form_submit_button_font_size',
        'label'             => __( 'Submit Button Text Font Size', 'reviewx' ),
        'input_attrs'       => array(
            'min'    => 0,
            'max'    => 100,
            'step'   => 1,
            'suffix' => 'px', //optional suffix
        ),
        'priority' => 169,
    ) ) );  
    
    $wp_customize->add_setting( 'reviewx_order_review_form_submit_button_bg_color' , array(
        'default'     => $defaults['reviewx_order_review_form_submit_button_bg_color'],
        'capability'    => 'edit_theme_options',
        'transport'   => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_rgba',
    ) );

    $wp_customize->add_control(
        new ReviewX_Customizer_Alpha_Color_Control(
        $wp_customize,
        'reviewx_order_review_form_submit_button_bg_color',
        array(
            'label'      => __( 'Submit Button Background Color', 'reviewx' ),
            'section'    => 'reviewx_advanced_designs_page_settings',
            'settings'   => 'reviewx_order_review_form_submit_button_bg_color',
            'priority' => 170,
        ) )
    );  
    
    $wp_customize->add_setting( 'reviewx_order_review_form_submit_button_border_radius', array(
        'default'           => $defaults['reviewx_order_review_form_submit_button_border_radius'],
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_integer'

    ) );

    $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
        $wp_customize, 'reviewx_order_review_form_submit_button_border_radius', array(
        'type'              => 'reviewx-range-value',
        'section'           => 'reviewx_advanced_designs_page_settings',
        'settings'          => 'reviewx_order_review_form_submit_button_border_radius',
        'label'             => __( 'Submit Button Border Radius', 'reviewx' ),
        'input_attrs'       => array(
            'min'    => 0,
            'max'    => 100,
            'step'   => 1,
            'suffix' => 'px', //optional suffix
        ),
        'priority' => 171,
    ) ) );    
    
    // Cancel button in my order review form
    $wp_customize->add_setting( 'reviewx_order_review_form_cancel_button_text_color' , array(
        'default'     => $defaults['reviewx_order_review_form_cancel_button_text_color'],
        'capability'    => 'edit_theme_options',
        'transport'   => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_rgba',
    ) );

    $wp_customize->add_control(
        new ReviewX_Customizer_Alpha_Color_Control(
        $wp_customize,
        'reviewx_order_review_form_cancel_button_text_color',
        array(
            'label'      => __( 'Cancel Button Text Color', 'reviewx' ),
            'section'    => 'reviewx_advanced_designs_page_settings',
            'settings'   => 'reviewx_order_review_form_cancel_button_text_color',
            'priority' => 172,
        ) )
    );  
    
    $wp_customize->add_setting( 'reviewx_order_review_form_cancel_button_font_size', array(
        'default'           => $defaults['reviewx_order_review_form_cancel_button_font_size'],
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_integer'

    ) );

    $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
        $wp_customize, 'reviewx_order_review_form_cancel_button_font_size', array(
        'type'              => 'reviewx-range-value',
        'section'           => 'reviewx_advanced_designs_page_settings',
        'settings'          => 'reviewx_order_review_form_cancel_button_font_size',
        'label'             => __( 'Cancel Button Text Font Size', 'reviewx' ),
        'input_attrs'       => array(
            'min'    => 0,
            'max'    => 100,
            'step'   => 1,
            'suffix' => 'px', //optional suffix
        ),
        'priority' => 173,
    ) ) );  
    
    $wp_customize->add_setting( 'reviewx_order_review_form_cancel_button_bg_color' , array(
        'default'     => $defaults['reviewx_order_review_form_cancel_button_bg_color'],
        'capability'    => 'edit_theme_options',
        'transport'   => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_rgba',
    ) );

    $wp_customize->add_control(
        new ReviewX_Customizer_Alpha_Color_Control(
        $wp_customize,
        'reviewx_order_review_form_cancel_button_bg_color',
        array(
            'label'      => __( 'Cancel Button Background Color', 'reviewx' ),
            'section'    => 'reviewx_advanced_designs_page_settings',
            'settings'   => 'reviewx_order_review_form_cancel_button_bg_color',
            'priority' => 174,
        ) )
    );  
    
    $wp_customize->add_setting( 'reviewx_order_review_form_cancel_button_border_radius', array(
        'default'           => $defaults['reviewx_order_review_form_cancel_button_border_radius'],
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_integer'

    ) );

    $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
        $wp_customize, 'reviewx_order_review_form_cancel_button_border_radius', array(
        'type'              => 'reviewx-range-value',
        'section'           => 'reviewx_advanced_designs_page_settings',
        'settings'          => 'reviewx_order_review_form_cancel_button_border_radius',
        'label'             => __( 'Cancel Button Border Radius', 'reviewx' ),
        'input_attrs'       => array(
            'min'    => 0,
            'max'    => 50,
            'step'   => 1,
            'suffix' => 'px', //optional suffix
        ),
        'priority' => 175,
    ) ) );

    // Go back button in my order review form    

    $wp_customize->add_setting( 'reviewx_order_review_form_go_back_button_text_color' , array(
        'default'     => $defaults['reviewx_order_review_form_go_back_button_text_color'],
        'capability'    => 'edit_theme_options',
        'transport'   => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_rgba',
    ) );

    $wp_customize->add_control(
        new ReviewX_Customizer_Alpha_Color_Control(
        $wp_customize,
        'reviewx_order_review_form_go_back_button_text_color',
        array(
            'label'      => __( 'Go Back Button Text Color', 'reviewx' ),
            'section'    => 'reviewx_advanced_designs_page_settings',
            'settings'   => 'reviewx_order_review_form_go_back_button_text_color',
            'priority' => 176,
        ) )
    );  
    
    $wp_customize->add_setting( 'reviewx_order_review_form_go_back_button_font_size', array(
        'default'           => $defaults['reviewx_order_review_form_go_back_button_font_size'],
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_integer'

    ) );

    $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
        $wp_customize, 'reviewx_order_review_form_go_back_button_font_size', array(
        'type'              => 'reviewx-range-value',
        'section'           => 'reviewx_advanced_designs_page_settings',
        'settings'          => 'reviewx_order_review_form_go_back_button_font_size',
        'label'             => __( 'Go Back Button Text Font Size', 'reviewx' ),
        'input_attrs'       => array(
            'min'    => 0,
            'max'    => 100,
            'step'   => 1,
            'suffix' => 'px', //optional suffix
        ),
        'priority' => 177,
    ) ) );  
    
    $wp_customize->add_setting( 'reviewx_order_review_form_go_back_button_bg_color' , array(
        'default'     => $defaults['reviewx_order_review_form_go_back_button_bg_color'],
        'capability'    => 'edit_theme_options',
        'transport'   => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_rgba',
    ) );

    $wp_customize->add_control(
        new ReviewX_Customizer_Alpha_Color_Control(
        $wp_customize,
        'reviewx_order_review_form_go_back_button_bg_color',
        array(
            'label'      => __( 'Go Back Button Background Color', 'reviewx' ),
            'section'    => 'reviewx_advanced_designs_page_settings',
            'settings'   => 'reviewx_order_review_form_go_back_button_bg_color',
            'priority' => 178,
        ) )
    );  
    
    $wp_customize->add_setting( 'reviewx_order_review_form_go_back_button_border_radius', array(
        'default'           => $defaults['reviewx_order_review_form_go_back_button_border_radius'],
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_integer'
    ) );

    $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
        $wp_customize, 'reviewx_order_review_form_go_back_button_border_radius', array(
        'type'              => 'reviewx-range-value',
        'section'           => 'reviewx_advanced_designs_page_settings',
        'settings'          => 'reviewx_order_review_form_go_back_button_border_radius',
        'label'             => __( 'Go Back Button Border Radius', 'reviewx' ),
        'input_attrs'       => array(
            'min'    => 0,
            'max'    => 50,
            'step'   => 1,
            'suffix' => 'px', //optional suffix
        ),
        'priority' => 179,
    ) ) );

    $wp_customize->add_setting( 'reviewx_order_review_form_order_summary_bg_color' , array(
        'default'     => $defaults['reviewx_order_review_form_order_summary_bg_color'],
        'capability'    => 'edit_theme_options',
        'transport'   => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_rgba',
    ) );

    $wp_customize->add_control(
        new ReviewX_Customizer_Alpha_Color_Control(
        $wp_customize,
        'reviewx_order_review_form_order_summary_bg_color',
        array(
            'label'      => __( 'Order Summary Background Color', 'reviewx' ),
            'section'    => 'reviewx_advanced_designs_page_settings',
            'settings'   => 'reviewx_order_review_form_order_summary_bg_color',
            'priority' => 180,
        ) )
    );    

    $wp_customize->add_setting( 'reviewx_order_review_form_bg_color' , array(
        'default'     => $defaults['reviewx_order_review_form_bg_color'],
        'capability'    => 'edit_theme_options',
        'transport'   => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_rgba',
    ) );

    $wp_customize->add_control(
        new ReviewX_Customizer_Alpha_Color_Control(
        $wp_customize,
        'reviewx_order_review_form_bg_color',
        array(
            'label'      => __( 'Form Background Color', 'reviewx' ),
            'section'    => 'reviewx_advanced_designs_page_settings',
            'settings'   => 'reviewx_order_review_form_bg_color',
            'priority' => 181,
        ) )
    );     

    //View review button 
    $wp_customize->add_setting( 'reviewx_order_view_review_button_text_color' , array(
        'default'     => $defaults['reviewx_order_view_review_button_text_color'],
        'capability'    => 'edit_theme_options',
        'transport'   => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_rgba',
    ) );

    $wp_customize->add_control(
        new ReviewX_Customizer_Alpha_Color_Control(
        $wp_customize,
        'reviewx_order_view_review_button_text_color',
        array(
            'label'      => __( 'View Review Button Text Color', 'reviewx' ),
            'section'    => 'reviewx_advanced_designs_page_settings',
            'settings'   => 'reviewx_order_view_review_button_text_color',
            'priority' => 182,
        ) )
    );  
    
    $wp_customize->add_setting( 'reviewx_order_view_review_button_font_size', array(
        'default'           => $defaults['reviewx_order_view_review_button_font_size'],
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_integer'

    ) );

    $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
        $wp_customize, 'reviewx_order_view_review_button_font_size', array(
        'type'              => 'reviewx-range-value',
        'section'           => 'reviewx_advanced_designs_page_settings',
        'settings'          => 'reviewx_order_view_review_button_font_size',
        'label'             => __( 'View Review Button Text Font Size', 'reviewx' ),
        'input_attrs'       => array(
            'min'    => 0,
            'max'    => 100,
            'step'   => 1,
            'suffix' => 'px', //optional suffix
        ),
        'priority' => 183,
    ) ) );  
    
    $wp_customize->add_setting( 'reviewx_order_view_review_button_bg_color' , array(
        'default'     => $defaults['reviewx_order_view_review_button_bg_color'],
        'capability'    => 'edit_theme_options',
        'transport'   => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_rgba',
    ) );

    $wp_customize->add_control(
        new ReviewX_Customizer_Alpha_Color_Control(
        $wp_customize,
        'reviewx_order_view_review_button_bg_color',
        array(
            'label'      => __( 'View Review Button Background Color', 'reviewx' ),
            'section'    => 'reviewx_advanced_designs_page_settings',
            'settings'   => 'reviewx_order_view_review_button_bg_color',
            'priority' => 184,
        ) )
    );  
    
    $wp_customize->add_setting( 'reviewx_order_view_review_button_border_radius', array(
        'default'           => $defaults['reviewx_order_view_review_button_border_radius'],
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_integer'

    ) );

    $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
        $wp_customize, 'reviewx_order_view_review_button_border_radius', array(
        'type'              => 'reviewx-range-value',
        'section'           => 'reviewx_advanced_designs_page_settings',
        'settings'          => 'reviewx_order_view_review_button_border_radius',
        'label'             => __( 'View Review Button Border Radius', 'reviewx' ),
        'input_attrs'       => array(
            'min'    => 0,
            'max'    => 100,
            'step'   => 1,
            'suffix' => 'px', //optional suffix
        ),
        'priority' => 185,
    ) ) );

    //Submit review button 
    $wp_customize->add_setting( 'reviewx_order_submit_review_button_text_color' , array(
        'default'     => $defaults['reviewx_order_submit_review_button_text_color'],
        'capability'    => 'edit_theme_options',
        'transport'   => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_rgba',
    ) );

    $wp_customize->add_control(
        new ReviewX_Customizer_Alpha_Color_Control(
        $wp_customize,
        'reviewx_order_submit_review_button_text_color',
        array(
            'label'      => __( 'Review Submit Button Text Color', 'reviewx' ),
            'section'    => 'reviewx_advanced_designs_page_settings',
            'settings'   => 'reviewx_order_submit_review_button_text_color',
            'priority' => 186,
        ) )
    );  

    $wp_customize->add_setting( 'reviewx_order_submit_review_button_font_size', array(
        'default'           => $defaults['reviewx_order_submit_review_button_font_size'],
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_integer'

    ) );

    $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
        $wp_customize, 'reviewx_order_submit_review_button_font_size', array(
        'type'              => 'reviewx-range-value',
        'section'           => 'reviewx_advanced_designs_page_settings',
        'settings'          => 'reviewx_order_submit_review_button_font_size',
        'label'             => __( 'Review Submit Button Text Font Size', 'reviewx' ),
        'input_attrs'       => array(
            'min'    => 0,
            'max'    => 100,
            'step'   => 1,
            'suffix' => 'px', //optional suffix
        ),
        'priority' => 187,
    ) ) );
    
    //Media upload compliance 
    $wp_customize->add_setting( 'reviewx_order_media_upload_compliance_text_color' , array(
        'default'     => $defaults['reviewx_order_media_upload_compliance_text_color'],
        'capability'    => 'edit_theme_options',
        'transport'   => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_rgba',
    ) );

    $wp_customize->add_control(
        new ReviewX_Customizer_Alpha_Color_Control(
        $wp_customize,
        'reviewx_order_media_upload_compliance_text_color',
        array(
            'label'      => __( 'Media Upload Compliance Text Color', 'reviewx' ),
            'section'    => 'reviewx_advanced_designs_page_settings',
            'settings'   => 'reviewx_order_media_upload_compliance_text_color',
            'priority' => 188,
        ) )
    );  

    $wp_customize->add_setting( 'reviewx_order_media_upload_compliance_font_size', array(
        'default'           => $defaults['reviewx_order_media_upload_compliance_font_size'],
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_integer'

    ) );

    $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
        $wp_customize, 'reviewx_order_media_upload_compliance_font_size', array(
        'type'              => 'reviewx-range-value',
        'section'           => 'reviewx_advanced_designs_page_settings',
        'settings'          => 'reviewx_order_media_upload_compliance_font_size',
        'label'             => __( 'Media Upload Compliance Text Font Size', 'reviewx' ),
        'input_attrs'       => array(
            'min'    => 0,
            'max'    => 100,
            'step'   => 1,
            'suffix' => 'px', //optional suffix
        ),
        'priority' => 189,
    ) ) );

    $wp_customize->add_setting( 'reviewx_order_submit_review_button_bg_color' , array(
        'default'     => $defaults['reviewx_order_submit_review_button_bg_color'],
        'capability'    => 'edit_theme_options',
        'transport'   => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_rgba',
    ) );

    $wp_customize->add_control(
        new ReviewX_Customizer_Alpha_Color_Control(
        $wp_customize,
        'reviewx_order_submit_review_button_bg_color',
        array(
            'label'      => __( 'Review Submit Button Background Color', 'reviewx' ),
            'section'    => 'reviewx_advanced_designs_page_settings',
            'settings'   => 'reviewx_order_submit_review_button_bg_color',
            'priority' => 190,
        ) )
    );  

    $wp_customize->add_setting( 'reviewx_order_submit_review_button_border_radius', array(
        'default'           => $defaults['reviewx_order_submit_review_button_border_radius'],
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_integer'

    ) );

    $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
        $wp_customize, 'reviewx_order_submit_review_button_border_radius', array(
        'type'              => 'reviewx-range-value',
        'section'           => 'reviewx_advanced_designs_page_settings',
        'settings'          => 'reviewx_order_submit_review_button_border_radius',
        'label'             => __( 'Review Submit Button Border Radius', 'reviewx' ),
        'input_attrs'       => array(
            'min'    => 0,
            'max'    => 100,
            'step'   => 1,
            'suffix' => 'px', //optional suffix
        ),
        'priority' => 191,
    ) ) );    