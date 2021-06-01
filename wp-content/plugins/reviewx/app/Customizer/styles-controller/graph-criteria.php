<?php 

    // Review Statistics
    $wp_customize->add_setting('reviewx_graph_criteria', array(
       // 'default'           => $defaults['reviewx_graph_criteria'],
        'sanitize_callback' => 'esc_html',
    ));	

    $wp_customize->add_control(new ReviewX_Separator_Custom_Control(
        $wp_customize, 'reviewx_graph_criteria', array(
        'label'	            => __( 'Graph of Review Criteria', 'reviewx' ),
        'settings'	        => 'reviewx_graph_criteria',
        'section'  	        => 'reviewx_advanced_designs_page_settings',
        'priority'          => 32
    )));
    
    $wp_customize->add_setting( 'reviewx_criteria_name_color' , array(
        'default'           => $defaults['reviewx_criteria_name_color'],
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_rgba',
    ) );

    $wp_customize->add_control(
        new ReviewX_Customizer_Alpha_Color_Control(
        $wp_customize,
        'reviewx_criteria_name_color',
        array(
            'label'         => __( 'Criteria Name Color', 'reviewx' ),
            'section'       => 'reviewx_advanced_designs_page_settings',
            'settings'      => 'reviewx_criteria_name_color',
            'priority'      => 33,
        ) )
    ); 
    
    $wp_customize->add_setting( 'reviewx_criteria_name_font_size', array(
        'default'           => $defaults['reviewx_criteria_name_font_size'],
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_integer'

    ) );

    $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
        $wp_customize, 'reviewx_criteria_name_font_size', array(
        'type'              => 'reviewx-range-value',
        'section'           => 'reviewx_advanced_designs_page_settings',
        'settings'          => 'reviewx_criteria_name_font_size',
        'label'             => __( 'Criteria Name Font Size', 'reviewx' ),
        'input_attrs'       => array(
            'min'    => 0,
            'max'    => 50,
            'step'   => 1,
            'suffix' => 'px', //optional suffix
        ),
        'priority' => 34,
    ) ) );  
    
    $wp_customize->add_setting( 'reviewx_progress_bar_bg_color' , array(
        'default'           => $defaults['reviewx_progress_bar_bg_color'],
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_rgba',
    ) );

    $wp_customize->add_control(
        new ReviewX_Customizer_Alpha_Color_Control(
        $wp_customize,
        'reviewx_progress_bar_bg_color',
        array(
            'label'         => __( 'Progress-bar Background Color', 'reviewx' ),
            'section'       => 'reviewx_advanced_designs_page_settings',
            'settings'      => 'reviewx_progress_bar_bg_color',
            'priority'      => 35,
        ) )
    );
    
    $wp_customize->add_setting( 'reviewx_progress_bar_text_color' , array(
        'default'           => $defaults['reviewx_progress_bar_text_color'],
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_rgba',
    ) );

    $wp_customize->add_control(
        new ReviewX_Customizer_Alpha_Color_Control(
        $wp_customize,
        'reviewx_progress_bar_text_color',
        array(
            'label'         => __( 'Progress-bar Text Color', 'reviewx' ),
            'section'       => 'reviewx_advanced_designs_page_settings',
            'settings'      => 'reviewx_progress_bar_text_color',
            'priority'      => 36,
        ) )
    );  
    
    $wp_customize->add_setting( 'reviewx_progress_bar_font_size', array(
        'default'           => $defaults['reviewx_progress_bar_font_size'],
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_integer'

    ) );

    $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
        $wp_customize, 'reviewx_progress_bar_font_size', array(
        'type'              => 'reviewx-range-value',
        'section'           => 'reviewx_advanced_designs_page_settings',
        'settings'          => 'reviewx_progress_bar_font_size',
        'label'             => __( 'Progress-bar Text Font Size', 'reviewx' ),
        'input_attrs'       => array(
            'min'    => 0,
            'max'    => 50,
            'step'   => 1,
            'suffix' => 'px', //optional suffix
        ),
        'priority' => 37,
    ) ) );

    if( $graph == 'graph_style_one' ) {
        $wp_customize->add_setting( 'reviewx_progress_bar_border_color' , array(
            'default'           => $defaults['reviewx_progress_bar_border_color'],
            'capability'        => 'edit_theme_options',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'reviewx_sanitize_rgba',
        ) );
    
        $wp_customize->add_control(
            new ReviewX_Customizer_Alpha_Color_Control(
            $wp_customize,
            'reviewx_progress_bar_border_color',
            array(
                'label'         => __( 'Progress-bar Border Color', 'reviewx' ),
                'section'       => 'reviewx_advanced_designs_page_settings',
                'settings'      => 'reviewx_progress_bar_border_color',
                'priority'      => 38,
            ) )
        );
    } 
    
    // Box-Shadow    
    $wp_customize->add_control(new ReviewX_Separator_Custom_Control(
        $wp_customize, 'reviewx_graph_box_shadow', array(
        'label'	    => esc_html__( 'Criteria Graph Box Shadow', 'reviewx' ),
        'settings'	=> 'reviewx_separator',
        'section'  	=> 'reviewx_advanced_designs_page_settings',
        'priority'  => 39
    ))); 

    $wp_customize->add_setting( 'reviewx_graph_box_shadow_color' , array(
        'default'     => $defaults['reviewx_graph_box_shadow_color'],
        'capability'    => 'edit_theme_options',
        'transport'   => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_rgba',
    ) );

    $wp_customize->add_control(
        new ReviewX_Customizer_Alpha_Color_Control(
        $wp_customize,
        'reviewx_graph_box_shadow_color',
        array(
            'label'      => __( 'Criteria Graph Box Shadow Color', 'reviewx' ),
            'section'    => 'reviewx_advanced_designs_page_settings',
            'settings'   => 'reviewx_graph_box_shadow_color',
            'priority' => 40,
        ) )
    );    

    $wp_customize->add_setting( 'reviewx_graph_box_shadow_horizontal', array(
        'default'       => $defaults['reviewx_graph_box_shadow_horizontal'],
        'capability'    => 'edit_theme_options',
        'transport' => 'postMessage',
        //'sanitize_callback' => 'reviewx_sanitize_integer'
    ) );    
    
    $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
        $wp_customize, 'reviewx_graph_box_shadow_horizontal', array(
        'type'     => 'reviewx-range-value',
        'section'  => 'reviewx_advanced_designs_page_settings',
        'settings' => 'reviewx_graph_box_shadow_horizontal',
        'label'    => __( 'Horizontal', 'reviewx' ),
        'input_attrs' => array(
            'min'    => -100,
            'max'    => 100,
            'step'   => 1,
            'suffix' => 'px', //optional suffix
        ),
        'priority' => 41,
    ) ) ); 

    $wp_customize->add_setting( 'reviewx_graph_box_shadow_vertical', array(
        'default'       => $defaults['reviewx_graph_box_shadow_vertical'],
        'capability'    => 'edit_theme_options',
        'transport' => 'postMessage',
       // 'sanitize_callback' => 'reviewx_sanitize_integer'
    ) );    
    
    $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
        $wp_customize, 'reviewx_graph_box_shadow_vertical', array(
        'type'     => 'reviewx-range-value',
        'section'  => 'reviewx_advanced_designs_page_settings',
        'settings' => 'reviewx_graph_box_shadow_vertical',
        'label'    => __( 'Vertical', 'reviewx' ),
        'input_attrs' => array(
            'min'    => -100,
            'max'    => 100,
            'step'   => 1,
            'suffix' => 'px', //optional suffix
        ),
        'priority' => 42,
    ) ) ); 
    
    $wp_customize->add_setting( 'reviewx_graph_box_shadow_blur', array(
        'default'       => $defaults['reviewx_graph_box_shadow_blur'],
        'capability'    => 'edit_theme_options',
        'transport' => 'postMessage',
      //  'sanitize_callback' => 'reviewx_sanitize_integer'
    ) );     
    
    $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
        $wp_customize, 'reviewx_graph_box_shadow_blur', array(
        'type'     => 'reviewx-range-value',
        'section'  => 'reviewx_advanced_designs_page_settings',
        'settings' => 'reviewx_graph_box_shadow_blur',
        'label'    => __( 'Blur', 'reviewx' ),
        'input_attrs' => array(
            'min'    => -100,
            'max'    => 100,
            'step'   => 1,
            'suffix' => 'px', //optional suffix
        ),
        'priority' => 43,
    ) ) );
    
    $wp_customize->add_setting( 'reviewx_graph_box_shadow_spread', array(
        'default'       => $defaults['reviewx_graph_box_shadow_spread'],
        'capability'    => 'edit_theme_options',
        'transport' => 'postMessage',
       // 'sanitize_callback' => 'reviewx_sanitize_integer'
    ) );     
    
    $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
        $wp_customize, 'reviewx_graph_box_shadow_spread', array(
        'type'     => 'reviewx-range-value',
        'section'  => 'reviewx_advanced_designs_page_settings',
        'settings' => 'reviewx_graph_box_shadow_spread',
        'label'    => __( 'Spread', 'reviewx' ),
        'input_attrs' => array(
            'min'    => -100,
            'max'    => 100,
            'step'   => 1,
            'suffix' => 'px', //optional suffix
        ),
        'priority' => 44,
    ) ) );

	$wp_customize->add_setting( 'reviewx_graph_box_shadow_position', array(
		'default'       => $defaults['reviewx_graph_box_shadow_position'],
		'capability'    => 'edit_theme_options',
		'transport' => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_select',
        'priority'  => 45
	) );    
    
	$wp_customize->add_control( new ReviewX_Select_Control(
		$wp_customize, 'reviewx_graph_box_shadow_position', array(
		'type'     => 'reviewx-select',
		'section'  => 'reviewx_advanced_designs_page_settings',
		'settings' => 'reviewx_graph_box_shadow_position',
		'label'    => __( 'Position', 'reviewx' ),
		'priority' => 46,
		'input_attrs' => array(
			'class' => 'reviewx_graph_box_shadow_position reviewx-select',
		),
		'choices'  => array(
			'inset'   	=> __( 'Inset', 'reviewx' ),
			''    => __( 'Outline', 'reviewx' ),
		)
    ) ) );

	$wp_customize->add_setting( 'reviewx_graph_border_style', array(
		'default'       => $defaults['reviewx_graph_border_style'],
		'capability'    => 'edit_theme_options',
		'transport' => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_select',
        'priority'  => 47
	) );    
    
	$wp_customize->add_control( new ReviewX_Select_Control(
		$wp_customize, 'reviewx_graph_border_style', array(
		'type'     => 'reviewx-select',
		'section'  => 'reviewx_advanced_designs_page_settings',
		'settings' => 'reviewx_graph_border_style',
		'label'    => __( 'Border Style', 'reviewx' ),
		'priority' => 48,
		'input_attrs' => array(
			'class' => 'reviewx_graph_border_style reviewx-select',
		),
		'choices'  => array(
			'solid'   	=> __( 'Solid', 'reviewx' ),
			'double'    => __( 'Double', 'reviewx' ),
			'dashed'    => __( 'Dashed', 'reviewx' ),
			'dotted'    => __( 'Dotted', 'reviewx' ),
		)
    ) ) );

    $wp_customize->add_setting( 'reviewx_graph_border_color' , array(
        'default'     => $defaults['reviewx_graph_border_color'],
        'capability'    => 'edit_theme_options',
        'transport'   => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_rgba',
    ) );

    $wp_customize->add_control(
        new ReviewX_Customizer_Alpha_Color_Control(
        $wp_customize,
        'reviewx_graph_border_color',
        array(
            'label'      => __( 'Border Color', 'reviewx' ),
            'section'    => 'reviewx_advanced_designs_page_settings',
            'settings'   => 'reviewx_graph_border_color',
            'priority' => 49,
        ) )
    );
    
    $wp_customize->add_setting( 'reviewx_graph_border_weight', array(
        'default'       => $defaults['reviewx_graph_border_weight'],
        'capability'    => 'edit_theme_options',
        'transport' => 'postMessage',
        'sanitize_callback' => 'reviewx_sanitize_integer'
    ) );     
    
    $wp_customize->add_control( new ReviewX_Customizer_Range_Value_Control(
        $wp_customize, 'reviewx_graph_border_weight', array(
        'type'     => 'reviewx-range-value',
        'section'  => 'reviewx_advanced_designs_page_settings',
        'settings' => 'reviewx_graph_border_weight',
        'label'    => __( 'Border Weight', 'reviewx' ),
        'input_attrs' => array(
            'min'    => 0,
            'max'    => 100,
            'step'   => 1,
            'suffix' => 'px', //optional suffix
        ),
        'priority' => 50,
    ) ) );        