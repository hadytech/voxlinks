<?php 
    
    $wp_customize->add_setting('reviewx_filtering_bar', array(
    //    'default'           => $defaults['reviewx_filtering_bar'],
        'sanitize_callback' => 'esc_html',
    ));	

    $wp_customize->add_control(new ReviewX_Separator_Custom_Control(
        $wp_customize, 'reviewx_filtering_bar', array(
        'label'	            => __( 'Filtering Bar', 'reviewx' ),
        'settings'	        => 'reviewx_filtering_bar',
        'section'  	        => 'reviewx_advanced_designs_page_settings',
        'priority'          => 51
    )));

    if( $template == 'template_style_one' ) {

        $wp_customize->add_setting( 'reviewx_template_one_filtering_bar_text_color' , array(
            'default'           => $defaults['reviewx_template_one_filtering_bar_text_color'],
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );

        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_one_filtering_bar_text_color',
            array(
                'label'         => __( 'Text Color', 'reviewx' ),
                'section'       => 'reviewx_advanced_designs_page_settings',
                'settings'      => 'reviewx_template_one_filtering_bar_text_color',
                'priority'      => 52,
            ) )
        ); 

        $wp_customize->add_setting( 'reviewx_template_one_filtering_bar_text_font_size', array(
            'default'           => $defaults['reviewx_template_one_filtering_bar_text_font_size'],
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_integer'

        ) );

        $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
            $wp_customize, 'reviewx_template_one_filtering_bar_text_font_size', array(
            'type'              => 'reviewx-range-value',
            'section'           => 'reviewx_advanced_designs_page_settings',
            'settings'          => 'reviewx_template_one_filtering_bar_text_font_size',
            'label'             => __( 'Font Size', 'reviewx' ),
            'input_attrs'       => array(
                'min'    => 0,
                'max'    => 50,
                'step'   => 1,
                'suffix' => 'px', //optional suffix
            ),
            'priority' => 53,
        ) ) );
        
        $wp_customize->add_setting( 'reviewx_template_one_filtering_drowpdown_bg_color' , array(
            'default'           => $defaults['reviewx_template_one_filtering_drowpdown_bg_color'],
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );

        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_one_filtering_drowpdown_bg_color',
            array(
                'label'         => __( 'Dropdown Background Color', 'reviewx' ),
                'section'       => 'reviewx_advanced_designs_page_settings',
                'settings'      => 'reviewx_template_one_filtering_drowpdown_bg_color',
                'priority'      => 54,
            ) )
        );         

        $wp_customize->add_setting( 'reviewx_template_one_filtering_drowpdown_text_color' , array(
            'default'           => $defaults['reviewx_template_one_filtering_drowpdown_text_color'],
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );

        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_one_filtering_drowpdown_text_color',
            array(
                'label'         => __( 'Dropdown Text Color', 'reviewx' ),
                'section'       => 'reviewx_advanced_designs_page_settings',
                'settings'      => 'reviewx_template_one_filtering_drowpdown_text_color',
                'priority'      => 55,
            ) )
        );
        
        $wp_customize->add_setting( 'reviewx_template_one_filtering_drowpdown_icon_color' , array(
            'default'           => $defaults['reviewx_template_one_filtering_drowpdown_icon_color'],
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );

        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_one_filtering_drowpdown_icon_color',
            array(
                'label'         => __( 'Dropdown Selector Icon Color', 'reviewx' ),
                'section'       => 'reviewx_advanced_designs_page_settings',
                'settings'      => 'reviewx_template_one_filtering_drowpdown_icon_color',
                'priority'      => 56,
            ) )
        ); 
        
        $wp_customize->add_setting( 'reviewx_template_one_filtering_drowpdown_bar_color' , array(
            'default'           => $defaults['reviewx_template_one_filtering_drowpdown_bar_color'],
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );

        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_one_filtering_drowpdown_bar_color',
            array(
                'label'         => __( 'Dropdown Bar Color', 'reviewx' ),
                'section'       => 'reviewx_advanced_designs_page_settings',
                'settings'      => 'reviewx_template_one_filtering_drowpdown_bar_color',
                'priority'      => 57,
            ) )
        );
        
        $wp_customize->add_setting( 'reviewx_template_one_filtering_bg_color' , array(
            'default'           => $defaults['reviewx_template_one_filtering_bg_color'],
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );

        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_one_filtering_bg_color',
            array(
                'label'         => __( 'Filter Background Color', 'reviewx' ),
                'section'       => 'reviewx_advanced_designs_page_settings',
                'settings'      => 'reviewx_template_one_filtering_bg_color',
                'priority'      => 58,
            ) )
        );          

    } else {

        $wp_customize->add_setting( 'reviewx_template_two_filtering_bar_text_color' , array(
            'default'           => $defaults['reviewx_template_two_filtering_bar_text_color'],
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );

        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_two_filtering_bar_text_color',
            array(
                'label'         => __( 'Text Color', 'reviewx' ),
                'section'       => 'reviewx_advanced_designs_page_settings',
                'settings'      => 'reviewx_template_two_filtering_bar_text_color',
                'priority'      => 52,
            ) )
        ); 

        $wp_customize->add_setting( 'reviewx_template_two_filtering_bar_text_font_size', array(
            'default'           => $defaults['reviewx_template_two_filtering_bar_text_font_size'],
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_integer'

        ) );

        $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
            $wp_customize, 'reviewx_template_two_filtering_bar_text_font_size', array(
            'type'              => 'reviewx-range-value',
            'section'           => 'reviewx_advanced_designs_page_settings',
            'settings'          => 'reviewx_template_two_filtering_bar_text_font_size',
            'label'             => __( 'Font Size', 'reviewx' ),
            'input_attrs'       => array(
                'min'    => 0,
                'max'    => 50,
                'step'   => 1,
                'suffix' => 'px', //optional suffix
            ),
            'priority' => 53,
        ) ) );
        
        $wp_customize->add_setting( 'reviewx_template_two_filtering_drowpdown_bg_color' , array(
            'default'           => $defaults['reviewx_template_two_filtering_drowpdown_bg_color'],
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );

        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_two_filtering_drowpdown_bg_color',
            array(
                'label'         => __( 'Dropdown Background Color', 'reviewx' ),
                'section'       => 'reviewx_advanced_designs_page_settings',
                'settings'      => 'reviewx_template_two_filtering_drowpdown_bg_color',
                'priority'      => 54,
            ) )
        );         

        $wp_customize->add_setting( 'reviewx_template_two_filtering_drowpdown_text_color' , array(
            'default'           => $defaults['reviewx_template_two_filtering_drowpdown_text_color'],
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );

        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_two_filtering_drowpdown_text_color',
            array(
                'label'         => __( 'Dropdown Text Color', 'reviewx' ),
                'section'       => 'reviewx_advanced_designs_page_settings',
                'settings'      => 'reviewx_template_two_filtering_drowpdown_text_color',
                'priority'      => 55,
            ) )
        );
        
        $wp_customize->add_setting( 'reviewx_template_two_filtering_drowpdown_icon_color' , array(
            'default'           => $defaults['reviewx_template_two_filtering_drowpdown_icon_color'],
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );

        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_two_filtering_drowpdown_icon_color',
            array(
                'label'         => __( 'Dropdown Selector Icon Color', 'reviewx' ),
                'section'       => 'reviewx_advanced_designs_page_settings',
                'settings'      => 'reviewx_template_two_filtering_drowpdown_icon_color',
                'priority'      => 56,
            ) )
        ); 
        
        $wp_customize->add_setting( 'reviewx_template_two_filtering_drowpdown_bar_color' , array(
            'default'           => $defaults['reviewx_template_two_filtering_drowpdown_bar_color'],
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );

        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_two_filtering_drowpdown_bar_color',
            array(
                'label'         => __( 'Dropdown Bar Color', 'reviewx' ),
                'section'       => 'reviewx_advanced_designs_page_settings',
                'settings'      => 'reviewx_template_two_filtering_drowpdown_bar_color',
                'priority'      => 57,
            ) )
        );
        
        $wp_customize->add_setting( 'reviewx_template_two_filtering_bg_color' , array(
            'default'           => $defaults['reviewx_template_two_filtering_bg_color'],
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );

        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_template_two_filtering_bg_color',
            array(
                'label'         => __( 'Filter Background Color', 'reviewx' ),
                'section'       => 'reviewx_advanced_designs_page_settings',
                'settings'      => 'reviewx_template_two_filtering_bg_color',
                'priority'      => 58,
            ) )
        );         

    }