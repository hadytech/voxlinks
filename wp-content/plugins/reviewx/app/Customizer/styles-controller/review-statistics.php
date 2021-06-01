<?php 

    // Review Statistics
    $wp_customize->add_setting('reviewx_statistics', array(
        //'default'           => $defaults['reviewx_statistics'],
        'sanitize_callback' => 'esc_html',
    ));	

    $wp_customize->add_control(new ReviewX_Separator_Custom_Control(
        $wp_customize, 'reviewx_statistics', array(
        'label'	            => __( 'Review Statistics', 'reviewx' ),
        'settings'	        => 'reviewx_statistics',
        'section'  	        => 'reviewx_advanced_designs_page_settings',
        'priority'          => 1
    )));
    
    $wp_customize->add_setting( 'reviewx_section_title_color' , array(
        'default'           => $defaults['reviewx_section_title_color'],
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_rgba',
    ) );

    $wp_customize->add_control(
        new ReviewX_Customizer_Alpha_Color_Control(
        $wp_customize,
        'reviewx_section_title_color',
        array(
            'label'         => __( 'Review Section Title Color', 'reviewx' ),
            'section'       => 'reviewx_advanced_designs_page_settings',
            'settings'      => 'reviewx_section_title_color',
            'priority'      => 2,
        ) )
    );   
    
    $wp_customize->add_setting( 'reviewx_section_title_font_size', array(
        'default'           => $defaults['reviewx_section_title_font_size'],
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_integer'

    ) );

    $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
        $wp_customize, 'reviewx_section_title_font_size', array(
        'type'              => 'reviewx-range-value',
        'section'           => 'reviewx_advanced_designs_page_settings',
        'settings'          => 'reviewx_section_title_font_size',
        'label'             => __( 'Review Section Title Font Size', 'reviewx' ),
        'input_attrs'       => array(
            'min'    => 0,
            'max'    => 72,
            'step'   => 1,
            'suffix' => 'px', //optional suffix
        ),
        'priority' => 2,
    ) ) );    


    $wp_customize->add_setting( 'reviewx_average_count_color' , array(
        'default'           => $defaults['reviewx_average_count_color'],
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_rgba',
    ) );

    $wp_customize->add_control(
        new ReviewX_Customizer_Alpha_Color_Control(
        $wp_customize,
        'reviewx_average_count_color',
        array(
            'label'         => __( 'Average Count Color', 'reviewx' ),
            'section'       => 'reviewx_advanced_designs_page_settings',
            'settings'      => 'reviewx_average_count_color',
            'priority'      => 2,
        ) )
    );

    $wp_customize->add_setting( 'reviewx_average_count_font_size', array(
        'default'           => $defaults['reviewx_average_count_font_size'],
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_integer'

    ) );

    $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
        $wp_customize, 'reviewx_average_count_font_size', array(
        'type'              => 'reviewx-range-value',
        'section'           => 'reviewx_advanced_designs_page_settings',
        'settings'          => 'reviewx_average_count_font_size',
        'label'             => __( 'Average Count Font Size', 'reviewx' ),
        'input_attrs'       => array(
            'min'    => 0,
            'max'    => 50,
            'step'   => 1,
            'suffix' => 'px', //optional suffix
        ),
        'priority' => 3,
    ) ) );



    $wp_customize->add_setting( 'reviewx_heighest_rating_point_color' , array(
        'default'     => $defaults['reviewx_heighest_rating_point_color'],
        'capability'    => 'edit_theme_options',
        'transport'   => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_rgba',
    ) );

    $wp_customize->add_control(
        new ReviewX_Customizer_Alpha_Color_Control(
        $wp_customize,
        'reviewx_heighest_rating_point_color',
        array(
            'label'      => __( 'Highest Rating Point Color', 'reviewx' ),
            'section'    => 'reviewx_advanced_designs_page_settings',
            'settings'   => 'reviewx_heighest_rating_point_color',
            'priority' => 4,
        ) )
    );

    $wp_customize->add_setting( 'reviewx_heighest_rating_point_font_size', array(
        'default'       => $defaults['reviewx_heighest_rating_point_font_size'],
        'capability'    => 'edit_theme_options',
        'transport' => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_integer'

    ) );

    $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
        $wp_customize, 'reviewx_heighest_rating_point_font_size', array(
        'type'     => 'reviewx-range-value',
        'section'  => 'reviewx_advanced_designs_page_settings',
        'settings' => 'reviewx_heighest_rating_point_font_size',
        'label'    => __( 'Highest Rating Point Font Size', 'reviewx' ),
        'input_attrs' => array(
            'min'    => 0,
            'max'    => 50,
            'step'   => 1,
            'suffix' => 'px', //optional suffix
        ),
        'priority' => 5,
    ) ) );    


    $wp_customize->add_setting( 'reviewx_star_rating_color' , array(
        'default'     => $defaults['reviewx_star_rating_color'],
        'capability'    => 'edit_theme_options',
        'transport'   => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_rgba',
    ) );

    $wp_customize->add_control(
        new ReviewX_Customizer_Alpha_Color_Control(
        $wp_customize,
        'reviewx_star_rating_color',
        array(
            'label'      => __( 'Star Rating Color', 'reviewx' ),
            'section'    => 'reviewx_advanced_designs_page_settings',
            'settings'   => 'reviewx_star_rating_color',
            'priority' => 6,
        ) )
    );

    $wp_customize->add_setting( 'reviewx_star_rating_size', array(
        'default'       => $defaults['reviewx_star_rating_size'],
        'capability'    => 'edit_theme_options',
        'transport' => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_integer'

    ) );

    $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
        $wp_customize, 'reviewx_star_rating_size', array(
        'type'     => 'reviewx-range-value',
        'section'  => 'reviewx_advanced_designs_page_settings',
        'settings' => 'reviewx_star_rating_size',
        'label'    => __( 'Star Rating Size', 'reviewx' ),
        'input_attrs' => array(
            'min'    => 0,
            'max'    => 50,
            'step'   => 1,
            'suffix' => 'px', //optional suffix
        ),
        'priority' => 7,
    ) ) );    
    
    
    $wp_customize->add_setting( 'reviewx_average_text_color' , array(
        'default'     => $defaults['reviewx_average_text_color'],
        'capability'    => 'edit_theme_options',
        'transport'   => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_rgba',
    ) );

    $wp_customize->add_control(
        new ReviewX_Customizer_Alpha_Color_Control(
        $wp_customize,
        'reviewx_average_text_color',
        array(
            'label'      => __( 'Average Text Color', 'reviewx' ),
            'section'    => 'reviewx_advanced_designs_page_settings',
            'settings'   => 'reviewx_average_text_color',
            'priority' => 8,
        ) )
    );

    $wp_customize->add_setting( 'reviewx_average_text_font_size', array(
        'default'       => $defaults['reviewx_average_text_font_size'],
        'capability'    => 'edit_theme_options',
        'transport' => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_integer'

    ) );

    $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
        $wp_customize, 'reviewx_average_text_font_size', array(
        'type'     => 'reviewx-range-value',
        'section'  => 'reviewx_advanced_designs_page_settings',
        'settings' => 'reviewx_average_text_font_size',
        'label'    => __( 'Average Text Font Size', 'reviewx' ),
        'input_attrs' => array(
            'min'    => 0,
            'max'    => 50,
            'step'   => 1,
            'suffix' => 'px', //optional suffix
        ),
        'priority' => 9,
    ) ) );    

    $wp_customize->add_setting('reviewx_recommendation', array(
        //'default'           => $defaults['reviewx_recommendation'],
        'sanitize_callback' => 'esc_html',
    ));	

    $wp_customize->add_control(new ReviewX_Separator_Custom_Control(
        $wp_customize, 'reviewx_recommendation', array(
        'label'	    => esc_html__( 'Review Recommendation Count', 'reviewx' ),
        'settings'	=> 'reviewx_recommendation',
        'section'  	=> 'reviewx_advanced_designs_page_settings',
        'priority'  => 10
    )));

    $wp_customize->add_setting( 'reviewx_recommendation_count_color' , array(
        'default'     => $defaults['reviewx_recommendation_count_color'],
        'capability'    => 'edit_theme_options',
        'transport'   => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_rgba',
    ) );

    $wp_customize->add_control(
        new ReviewX_Customizer_Alpha_Color_Control(
        $wp_customize,
        'reviewx_recommendation_count_color',
        array(
            'label'      => __( 'Recommendation Count Color', 'reviewx' ),
            'section'    => 'reviewx_advanced_designs_page_settings',
            'settings'   => 'reviewx_recommendation_count_color',
            'priority' => 11,
        ) )
    );

    $wp_customize->add_setting( 'reviewx_recommendation_count_font_size', array(
        'default'       => $defaults['reviewx_recommendation_count_font_size'],
        'capability'    => 'edit_theme_options',
        'transport' => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_integer'

    ) );

    $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
        $wp_customize, 'reviewx_recommendation_count_font_size', array(
        'type'     => 'reviewx-range-value',
        'section'  => 'reviewx_advanced_designs_page_settings',
        'settings' => 'reviewx_recommendation_count_font_size',
        'label'    => __( 'Recommendation Count Font Size', 'reviewx' ),
        'input_attrs' => array(
            'min'    => 0,
            'max'    => 50,
            'step'   => 1,
            'suffix' => 'px', //optional suffix
        ),
        'priority' => 12,
    ) ) );

    $wp_customize->add_setting( 'reviewx_recommendation_text_color' , array(
        'default'     => $defaults['reviewx_recommendation_text_color'],
        'capability'    => 'edit_theme_options',
        'transport'   => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_rgba',
    ) );

    $wp_customize->add_control(
        new ReviewX_Customizer_Alpha_Color_Control(
        $wp_customize,
        'reviewx_recommendation_text_color',
        array(
            'label'      => __( 'Recommendation Text Color', 'reviewx' ),
            'section'    => 'reviewx_advanced_designs_page_settings',
            'settings'   => 'reviewx_recommendation_text_color',
            'priority' => 13,
        ) )
    );

    $wp_customize->add_setting( 'reviewx_recommendation_text_font_size', array(
        'default'       => $defaults['reviewx_recommendation_text_font_size'],
        'capability'    => 'edit_theme_options',
        'transport' => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_integer'

    ) );

    $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
        $wp_customize, 'reviewx_recommendation_text_font_size', array(
        'type'     => 'reviewx-range-value',
        'section'  => 'reviewx_advanced_designs_page_settings',
        'settings' => 'reviewx_recommendation_text_font_size',
        'label'    => __( 'Recommendation Text Font Size', 'reviewx' ),
        'input_attrs' => array(
            'min'    => 0,
            'max'    => 50,
            'step'   => 1,
            'suffix' => 'px', //optional suffix
        ),
        'priority' => 14,
    ) ) );

    $wp_customize->add_setting('reviewx_separator', array(
       // 'default'           => $defaults['reviewx_separator'],
        'sanitize_callback' => 'esc_html',
    ));	

    $wp_customize->add_control(new ReviewX_Separator_Custom_Control(
        $wp_customize, 'reviewx_separator', array(
        'label'	    => esc_html__( 'Review Statistics Separator', 'reviewx' ),
        'settings'	=> 'reviewx_separator',
        'section'  	=> 'reviewx_advanced_designs_page_settings',
        'priority'  => 15
    )));  

	$wp_customize->add_setting( 'reviewx_separator_border_style', array(
		'default'       => $defaults['reviewx_separator_border_style'],
		'capability'    => 'edit_theme_options',
		'transport' => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_select',
        'priority'  => 15
	) );    
    
	$wp_customize->add_control( new ReviewX_Select_Control(
		$wp_customize, 'reviewx_separator_border_style', array(
		'type'     => 'reviewx-select',
		'section'  => 'reviewx_advanced_designs_page_settings',
		'settings' => 'reviewx_separator_border_style',
		'label'    => __( 'Border Style', 'reviewx' ),
		'priority' => 16,
		'input_attrs' => array(
			'class' => 'reviewx_separator_border_style reviewx-select',
		),
		'choices'  => array(
			'solid'   	=> __( 'Solid', 'reviewx' ),
			'double'    => __( 'Double', 'reviewx' ),
			'dashed'    => __( 'Dashed', 'reviewx' ),
			'dotted'    => __( 'Dotted', 'reviewx' ),
		)
    ) ) );

    $wp_customize->add_setting( 'reviewx_separator_border_width', array(
        'default'       => $defaults['reviewx_separator_border_width'],
        'capability'    => 'edit_theme_options',
        'transport' => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_integer'

    ) );    
    
    $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
        $wp_customize, 'reviewx_separator_border_width', array(
        'type'     => 'reviewx-range-value',
        'section'  => 'reviewx_advanced_designs_page_settings',
        'settings' => 'reviewx_separator_border_width',
        'label'    => __( 'Width', 'reviewx' ),
        'input_attrs' => array(
            'min'    => 0,
            'max'    => 100,
            'step'   => 1,
            'suffix' => '%', //optional suffix
        ),
        'priority' => 17,
    ) ) ); 
    
    $wp_customize->add_setting( 'reviewx_separator_border_height', array(
        'default'       => $defaults['reviewx_separator_border_height'],
        'capability'    => 'edit_theme_options',
        'transport' => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_integer'

    ) );    
    
    $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
        $wp_customize, 'reviewx_separator_border_height', array(
        'type'     => 'reviewx-range-value',
        'section'  => 'reviewx_advanced_designs_page_settings',
        'settings' => 'reviewx_separator_border_height',
        'label'    => __( 'Height', 'reviewx' ),
        'input_attrs' => array(
            'min'    => 0,
            'max'    => 100,
            'step'   => 1,
            'suffix' => 'px', //optional suffix
        ),
        'priority' => 18,
    ) ) ); 
    
    $wp_customize->add_setting( 'reviewx_separator_border_color' , array(
        'default'     => $defaults['reviewx_separator_border_color'],
        'capability'    => 'edit_theme_options',
        'transport'   => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_rgba',
    ) );

    $wp_customize->add_control(
        new ReviewX_Customizer_Alpha_Color_Control(
        $wp_customize,
        'reviewx_separator_border_color',
        array(
            'label'      => __( 'Border Color', 'reviewx' ),
            'section'    => 'reviewx_advanced_designs_page_settings',
            'settings'   => 'reviewx_separator_border_color',
            'priority' => 19,
        ) )
    );  
    
    //Box Shadow
    
    $wp_customize->add_control(new ReviewX_Separator_Custom_Control(
        $wp_customize, 'reviewx_box_shadow', array(
        'label'	    => esc_html__( 'Review Statistics Box Shadow', 'reviewx' ),
        'settings'	=> 'reviewx_separator',
        'section'  	=> 'reviewx_advanced_designs_page_settings',
        'priority'  => 20
    ))); 

    $wp_customize->add_setting( 'reviewx_box_shadow_color' , array(
        'default'     => $defaults['reviewx_box_shadow_color'],
        'capability'    => 'edit_theme_options',
        'transport'   => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_rgba',
    ) );

    $wp_customize->add_control(
        new ReviewX_Customizer_Alpha_Color_Control(
        $wp_customize,
        'reviewx_box_shadow_color',
        array(
            'label'      => __( 'Box Shadow Color', 'reviewx' ),
            'section'    => 'reviewx_advanced_designs_page_settings',
            'settings'   => 'reviewx_box_shadow_color',
            'priority' => 21,
        ) )
    );    

    $wp_customize->add_setting( 'reviewx_box_shadow_horizontal', array(
        'default'       => $defaults['reviewx_box_shadow_horizontal'],
        'capability'    => 'edit_theme_options',
        'transport' => 'postMessage',
        //'sanitize_callback' => 'reviewx_sanitize_integer'
    ) );    
    
    $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
        $wp_customize, 'reviewx_box_shadow_horizontal', array(
        'type'     => 'reviewx-range-value',
        'section'  => 'reviewx_advanced_designs_page_settings',
        'settings' => 'reviewx_box_shadow_horizontal',
        'label'    => __( 'Horizontal', 'reviewx' ),
        'input_attrs' => array(
            'min'    => -100,
            'max'    => 100,
            'step'   => 1,
            'suffix' => 'px', //optional suffix
        ),
        'priority' => 22,
    ) ) ); 

    $wp_customize->add_setting( 'reviewx_box_shadow_vertical', array(
        'default'       => $defaults['reviewx_box_shadow_vertical'],
        'capability'    => 'edit_theme_options',
        'transport' => 'postMessage',
       // 'sanitize_callback' => 'reviewx_sanitize_integer'
    ) );    
    
    $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
        $wp_customize, 'reviewx_box_shadow_vertical', array(
        'type'     => 'reviewx-range-value',
        'section'  => 'reviewx_advanced_designs_page_settings',
        'settings' => 'reviewx_box_shadow_vertical',
        'label'    => __( 'Vertical', 'reviewx' ),
        'input_attrs' => array(
            'min'    => -100,
            'max'    => 100,
            'step'   => 1,
            'suffix' => 'px', //optional suffix
        ),
        'priority' => 23,
    ) ) ); 
    
    $wp_customize->add_setting( 'reviewx_box_shadow_blur', array(
        'default'       => $defaults['reviewx_box_shadow_blur'],
        'capability'    => 'edit_theme_options',
        'transport' => 'postMessage',
      //  'sanitize_callback' => 'reviewx_sanitize_integer'
    ) );     
    
    $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
        $wp_customize, 'reviewx_box_shadow_blur', array(
        'type'     => 'reviewx-range-value',
        'section'  => 'reviewx_advanced_designs_page_settings',
        'settings' => 'reviewx_box_shadow_blur',
        'label'    => __( 'Blur', 'reviewx' ),
        'input_attrs' => array(
            'min'    => -100,
            'max'    => 100,
            'step'   => 1,
            'suffix' => 'px', //optional suffix
        ),
        'priority' => 24,
    ) ) );
    
    $wp_customize->add_setting( 'reviewx_box_shadow_spread', array(
        'default'       => $defaults['reviewx_box_shadow_spread'],
        'capability'    => 'edit_theme_options',
        'transport' => 'postMessage',
       // 'sanitize_callback' => 'reviewx_sanitize_integer'
    ) );     
    
    $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
        $wp_customize, 'reviewx_box_shadow_spread', array(
        'type'     => 'reviewx-range-value',
        'section'  => 'reviewx_advanced_designs_page_settings',
        'settings' => 'reviewx_box_shadow_spread',
        'label'    => __( 'Spread', 'reviewx' ),
        'input_attrs' => array(
            'min'    => -100,
            'max'    => 100,
            'step'   => 1,
            'suffix' => 'px', //optional suffix
        ),
        'priority' => 25,
    ) ) );

	$wp_customize->add_setting( 'reviewx_box_shadow_position', array(
		'default'       => $defaults['reviewx_box_shadow_position'],
		'capability'    => 'edit_theme_options',
		'transport' => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_select',
        'priority'  => 26
	) );    
    
	$wp_customize->add_control( new ReviewX_Select_Control(
		$wp_customize, 'reviewx_box_shadow_position', array(
		'type'     => 'reviewx-select',
		'section'  => 'reviewx_advanced_designs_page_settings',
		'settings' => 'reviewx_box_shadow_position',
		'label'    => __( 'Position', 'reviewx' ),
		'priority' => 27,
		'input_attrs' => array(
			'class' => 'reviewx_box_shadow_position reviewx-select',
		),
		'choices'  => array(
			'inset'   	=> __( 'Inset', 'reviewx' ),
			''    => __( 'Outline', 'reviewx' ),
		)
    ) ) );

	$wp_customize->add_setting( 'reviewx_statistics_border_style', array(
		'default'       => $defaults['reviewx_statistics_border_style'],
		'capability'    => 'edit_theme_options',
		'transport' => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_select',
        'priority'  => 28
	) );    
    
	$wp_customize->add_control( new ReviewX_Select_Control(
		$wp_customize, 'reviewx_statistics_border_style', array(
		'type'     => 'reviewx-select',
		'section'  => 'reviewx_advanced_designs_page_settings',
		'settings' => 'reviewx_statistics_border_style',
		'label'    => __( 'Border Style', 'reviewx' ),
		'priority' => 29,
		'input_attrs' => array(
			'class' => 'reviewx_statistics_border_style reviewx-select',
		),
		'choices'  => array(
			'solid'   	=> __( 'Solid', 'reviewx' ),
			'double'    => __( 'Double', 'reviewx' ),
			'dashed'    => __( 'Dashed', 'reviewx' ),
			'dotted'    => __( 'Dotted', 'reviewx' ),
		)
    ) ) );

    $wp_customize->add_setting( 'reviewx_statistics_border_color' , array(
        'default'     => $defaults['reviewx_statistics_border_color'],
        'capability'    => 'edit_theme_options',
        'transport'   => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_rgba',
    ) );

    $wp_customize->add_control(
        new ReviewX_Customizer_Alpha_Color_Control(
        $wp_customize,
        'reviewx_statistics_border_color',
        array(
            'label'      => __( 'Border Color', 'reviewx' ),
            'section'    => 'reviewx_advanced_designs_page_settings',
            'settings'   => 'reviewx_statistics_border_color',
            'priority' => 30,
        ) )
    );
    
    $wp_customize->add_setting( 'reviewx_statistics_border_weight', array(
        'default'       => $defaults['reviewx_statistics_border_weight'],
        'capability'    => 'edit_theme_options',
        'transport' => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_integer'
    ) );     
    
    $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
        $wp_customize, 'reviewx_statistics_border_weight', array(
        'type'     => 'reviewx-range-value',
        'section'  => 'reviewx_advanced_designs_page_settings',
        'settings' => 'reviewx_statistics_border_weight',
        'label'    => __( 'Border Weight', 'reviewx' ),
        'input_attrs' => array(
            'min'    => 0,
            'max'    => 100,
            'step'   => 1,
            'suffix' => 'px', //optional suffix
        ),
        'priority' => 31,
    ) ) );    