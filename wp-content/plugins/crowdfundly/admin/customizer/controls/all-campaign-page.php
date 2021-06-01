<?php 

function all_campaign($wp_customize) {

	$wp_customize->add_setting( 'cf_all_campaign_heading', array(
		'sanitize_callback' => 'esc_html',
	) );	
	$wp_customize->add_control( new CrowdFundly_Heading_Control( $wp_customize, 'cf_all_campaign_heading', 
		array(
			'label'	            => __( 'All Campaigns', 'crowdfundly' ),
			'settings'	        => 'cf_all_campaign_heading',
			'section'  	        => 'cf_all_campaign_page',
			'priority'          => 2,
			'input_attrs' => array(
				'class' => 'crowdfundly-heading',
			),
		)
	) );

	$wp_customize->add_setting( 'crowdfundly_all_camp_page_background_color', array(
		'default' 			=> '#f3f4f8',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_all_camp_page_background_color', 
		array(
			'label'      => __( 'Page Background Color', 'crowdfundly' ),
			'section'    => 'cf_all_campaign_page',
			'settings'   => 'crowdfundly_all_camp_page_background_color',
			'priority'   => 2,
			'input_attrs' => array(
				'class' => 'crowdfundly-heading',
			),
		) 
	) );

	$wp_customize->add_setting( 'cf_all_campaign_search_bar', array(
		'sanitize_callback' => 'esc_html',
	) );	
	$wp_customize->add_control( new CrowdFundly_Heading_Control( $wp_customize, 'cf_all_campaign_search_bar', 
		array(
			'label'	            => __( 'Search Bar', 'crowdfundly' ),
			'settings'	        => 'cf_all_campaign_search_bar',
			'section'  	        => 'cf_all_campaign_page',
			'priority'          => 2,
			'input_attrs' => array(
				'class' => 'crowdfundly-heading',
			),
		)
	) );

	$wp_customize->add_setting( 'cf_all_camp_hide_search_bar', array(
        'default' => '',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'crowdfundly_sanitize_checkbox',
    ));
	$wp_customize->add_control(new Crowdfundly_Customizer_Switcher_Control( $wp_customize, 'cf_all_camp_hide_search_bar', 
		array(
			'label' => esc_html__('Hide Section', 'crowdfundly'),
			'section' => 'cf_all_campaign_page',
			'settings' => 'cf_all_camp_hide_search_bar',
			'type' => 'light',
			'priority' => 2
		)
	));

	$wp_customize->add_setting( 'cf_all_camp_title', array(
		'default' 			=> 'Campaigns',
		'sanitize_callback' => 'esc_html',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( 'cf_all_camp_title', 
		array(
			'label'		=> __( 'Title', 'crowdfundly' ),
			'type'		=> 'text',
            'section'	=> 'cf_all_campaign_page',
            'settings'	=> 'cf_all_camp_title',
			'priority'	=> 2
		) 
	);

	$wp_customize->add_setting( 'cf_all_camp_title_font_size', array(
		'default' 			=> '20',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'crowdfundly_sanitize_integer',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new Crowdfundly_Range_Value_Control( $wp_customize, 'cf_all_camp_title_font_size', 
		array(
			'type'              => 'crowdfundly-range-value',
            'section'           => 'cf_all_campaign_page',
            'settings'          => 'cf_all_camp_title_font_size',
			'label'             => __( 'Title Font Size', 'crowdfundly' ),
            'input_attrs'       => array(
                'min'    => 1,
                'max'    => 60,
                'step'   => 1,
                'suffix' => 'px'
            ),
			'priority' => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_all_camp_title_color', array(
		'default' 			=> '#31375E',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_all_camp_title_color', 
		array(
			'label'      => __( 'Title Color', 'crowdfundly' ),
			'section'    => 'cf_all_campaign_page',
			'settings'   => 'crowdfundly_all_camp_title_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_all_camp_search_bar_bg_color', array(
		'default' 			=> '#ffffff',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_all_camp_search_bar_bg_color', 
		array(
			'label'      => __( 'Search Bar Background Color', 'crowdfundly' ),
			'section'    => 'cf_all_campaign_page',
			'settings'   => 'crowdfundly_all_camp_search_bar_bg_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_all_camp_search_icon_color', array(
		'default' 			=> '#666666',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_all_camp_search_icon_color', 
		array(
			'label'      => __( 'Search Icon Color', 'crowdfundly' ),
			'section'    => 'cf_all_campaign_page',
			'settings'   => 'crowdfundly_all_camp_search_icon_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_all_camp_search_input_border_color', array(
		'default' 			=> '#39414d',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_all_camp_search_input_border_color', 
		array(
			'label'      => __( 'Search Input Border Color', 'crowdfundly' ),
			'section'    => 'cf_all_campaign_page',
			'settings'   => 'crowdfundly_all_camp_search_input_border_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_all_camp_search_input_placeholder_color', array(
		'default' 			=> '',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_all_camp_search_input_placeholder_color', 
		array(
			'label'      => __( 'Search Input Placeholder Color', 'crowdfundly' ),
			'section'    => 'cf_all_campaign_page',
			'settings'   => 'crowdfundly_all_camp_search_input_placeholder_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_all_camp_search_btn_color', array(
		'default' 			=> '#ffffff',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_all_camp_search_btn_color', 
		array(
			'label'      => __( 'Search Button Color', 'crowdfundly' ),
			'section'    => 'cf_all_campaign_page',
			'settings'   => 'crowdfundly_all_camp_search_btn_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_all_camp_search_btn_fontsize', array(
		'default' 			=> '22',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'crowdfundly_sanitize_integer',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new Crowdfundly_Range_Value_Control( $wp_customize, 'crowdfundly_all_camp_search_btn_fontsize', 
		array(
			'type'              => 'crowdfundly-range-value',
			'section'           => 'cf_all_campaign_page',
			'settings'          => 'crowdfundly_all_camp_search_btn_fontsize',
			'label'             => __( 'Search Button Text Font Size', 'crowdfundly' ),
			'input_attrs'       => array(
				'min'    => 5,
				'max'    => 30,
				'step'   => 1,
				'suffix' => 'px'
			),
			'priority' => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_all_camp_search_btn_bg_color', array(
		'default' 			=> '#5777f3',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_all_camp_search_btn_bg_color', 
		array(
			'label'      => __( 'Search Button Background Color', 'crowdfundly' ),
			'section'    => 'cf_all_campaign_page',
			'settings'   => 'crowdfundly_all_camp_search_btn_bg_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_all_camp_search_btn_border_color', array(
		'default' 			=> '#5777f3',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_all_camp_search_btn_border_color', 
		array(
			'label'      => __( 'Search Button Border Color', 'crowdfundly' ),
			'section'    => 'cf_all_campaign_page',
			'settings'   => 'crowdfundly_all_camp_search_btn_border_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_all_camp_search_btn_color_hover', array(
		'default' 			=> '#ffffff',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_all_camp_search_btn_color_hover', 
		array(
			'label'      => __( 'Search Button Hover Color', 'crowdfundly' ),
			'section'    => 'cf_all_campaign_page',
			'settings'   => 'crowdfundly_all_camp_search_btn_color_hover',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_all_camp_search_btn_bg_color_hover', array(
		'default' 			=> '#113eed',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_all_camp_search_btn_bg_color_hover', 
		array(
			'label'      => __( 'Search Button Hover Background Color', 'crowdfundly' ),
			'section'    => 'cf_all_campaign_page',
			'settings'   => 'crowdfundly_all_camp_search_btn_bg_color_hover',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_all_camp_search_btn_border_color_hover', array(
		'default' 			=> '#113eed',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_all_camp_search_btn_border_color_hover', 
		array(
			'label'      => __( 'Search Button Hover Border Color', 'crowdfundly' ),
			'section'    => 'cf_all_campaign_page',
			'settings'   => 'crowdfundly_all_camp_search_btn_border_color_hover',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'cf_all_campaign_card', array(
		'sanitize_callback' => 'esc_html',
	) );	
	$wp_customize->add_control( new CrowdFundly_Heading_Control( $wp_customize, 'cf_all_campaign_card', 
		array(
			'label'	            => __( 'Card', 'crowdfundly' ),
			'settings'	        => 'cf_all_campaign_card',
			'section'  	        => 'cf_all_campaign_page',
			'priority'          => 2,
			'input_attrs' => array(
				'class' => 'crowdfundly-heading',
			),
		)
	) );

	$wp_customize->add_setting( 'cf_all_camp_per_page', array(
		'default' 			=> '15',
		'sanitize_callback' => 'crowdfundly_sanitize_integer',
		'transport' 		=> 'postMessage'
	) );

	$wp_customize->add_control( new Crowdfundly_Number_Control(
		$wp_customize, 'cf_all_camp_per_page', array(
		'type'     => 'crowdfundly-number',
		'section'  => 'cf_all_campaign_page',
		'settings' => 'cf_all_camp_per_page',
		'label'    => __( 'Campaigns Per Page', 'crowdfundly' ),
		'priority'   => 2,
	) ) );

	$wp_customize->add_setting( 'cf_all_camp_card_column', array(
		'default'       => '3',
		'capability'    => 'edit_theme_options',
		'transport' => 'postMessage',
		'sanitize_callback' => 'crowdfundly_sanitize_select'
	) );
	$wp_customize->add_control( new Crowdfundly_Select_Control( $wp_customize, 'cf_all_camp_card_column', 
		array(
			'type'     => 'crowdfundly-select',
			'section'  => 'cf_all_campaign_page',
			'settings' => 'cf_all_camp_card_column',
			'label'    => __( 'Grid Column', 'crowdfundly' ),
			'priority' => 2,
			'choices'  => array(
				'' => __( 'Select Option', 'crowdfundly' ),
				'12'   	=> __( 'One Column', 'crowdfundly' ),
				'6'   	=> __( 'Two Column', 'crowdfundly' ),
				'4'   => __( 'Three Column', 'crowdfundly' ),
				'3'   => __( 'Four Column', 'crowdfundly' )
			)
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_all_camp_card_bg_color', array(
		'default' 			=> '#ffffff',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_all_camp_card_bg_color', 
		array(
			'label'      => __( 'Background Color', 'crowdfundly' ),
			'section'    => 'cf_all_campaign_page',
			'settings'   => 'crowdfundly_all_camp_card_bg_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_all_camp_card_bg_color_hover', array(
		'default' 			=> '',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_all_camp_card_bg_color_hover', 
		array(
			'label'      => __( 'Hover Background Color', 'crowdfundly' ),
			'section'    => 'cf_all_campaign_page',
			'settings'   => 'crowdfundly_all_camp_card_bg_color_hover',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'cf_all_camp_image_width', array(
		'default' 			=> '',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'crowdfundly_sanitize_integer',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new Crowdfundly_Range_Value_Control( $wp_customize, 'cf_all_camp_image_width', 
		array(
			'type'              => 'crowdfundly-range-value',
            'section'           => 'cf_all_campaign_page',
            'settings'          => 'cf_all_camp_image_width',
			'label'             => __( 'Image Width', 'crowdfundly' ),
            'input_attrs'       => array(
                'min'    => 50,
                'max'    => 600,
                'step'   => 1,
                'suffix' => 'px'
            ),
			'priority' => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_all_camp_name_color', array(
		'default' 			=> '#333333',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_all_camp_name_color', 
		array(
			'label'      => __( 'Campaign Name Color', 'crowdfundly' ),
			'section'    => 'cf_all_campaign_page',
			'settings'   => 'crowdfundly_all_camp_name_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_all_camp_name_fontsize', array(
		'default' 			=> '22',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'crowdfundly_sanitize_integer',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new Crowdfundly_Range_Value_Control( $wp_customize, 'crowdfundly_all_camp_name_fontsize', 
		array(
			'type'              => 'crowdfundly-range-value',
			'section'           => 'cf_all_campaign_page',
			'settings'          => 'crowdfundly_all_camp_name_fontsize',
			'label'             => __( 'Campaign Name Font Size', 'crowdfundly' ),
			'input_attrs'       => array(
				'min'    => 5,
				'max'    => 30,
				'step'   => 1,
				'suffix' => 'px'
			),
			'priority' => 2
		) 
	) );	

	$wp_customize->add_setting( 'crowdfundly_all_camp_description_color', array(
		'default' 			=> '#666666',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_all_camp_description_color', 
		array(
			'label'      => __( 'Campaign Description Color', 'crowdfundly' ),
			'section'    => 'cf_all_campaign_page',
			'settings'   => 'crowdfundly_all_camp_description_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_all_camp_description_fontsize', array(
		'default' 			=> '22',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'crowdfundly_sanitize_integer',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new Crowdfundly_Range_Value_Control( $wp_customize, 'crowdfundly_all_camp_description_fontsize', 
		array(
			'type'              => 'crowdfundly-range-value',
			'section'           => 'cf_all_campaign_page',
			'settings'          => 'crowdfundly_all_camp_description_fontsize',
			'label'             => __( 'Campaign Description Font Size', 'crowdfundly' ),
			'input_attrs'       => array(
				'min'    => 5,
				'max'    => 30,
				'step'   => 1,
				'suffix' => 'px'
			),
			'priority' => 2
		) 
	) );	

	$wp_customize->add_setting( 'crowdfundly_all_camp_progress_bg_color', array(
		'default' 			=> '#ffffff',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_all_camp_progress_bg_color', 
		array(
			'label'      => __( 'Progress Bar Background Color', 'crowdfundly' ),
			'section'    => 'cf_all_campaign_page',
			'settings'   => 'crowdfundly_all_camp_progress_bg_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_all_camp_progress_color', array(
		'default' 			=> '#14C479',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_all_camp_progress_color', 
		array(
			'label'      => __( 'Progress Color', 'crowdfundly' ),
			'section'    => 'cf_all_campaign_page',
			'settings'   => 'crowdfundly_all_camp_progress_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_all_camp_raised_amount_color', array(
		'default' 			=> '#000000',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_all_camp_raised_amount_color', 
		array(
			'label'      => __( 'Raised Amount Color', 'crowdfundly' ),
			'section'    => 'cf_all_campaign_page',
			'settings'   => 'crowdfundly_all_camp_raised_amount_color',
			'priority'   => 2
		)
	) );

	$wp_customize->add_setting( 'crowdfundly_all_camp_card_target_amount_color', array(
		'default' 			=> '#666666',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_all_camp_card_target_amount_color', 
		array(
			'label'      => __( 'Target Amount Color', 'crowdfundly' ),
			'section'    => 'cf_all_campaign_page',
			'settings'   => 'crowdfundly_all_camp_card_target_amount_color',
			'priority'   => 2
		)
	) );

	$wp_customize->add_setting( 'crowdfundly_all_camp_target_raised_amount_fontsize', array(
		'default' 			=> '22',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'crowdfundly_sanitize_integer',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new Crowdfundly_Range_Value_Control( $wp_customize, 'crowdfundly_all_camp_target_raised_amount_fontsize', 
		array(
			'type'              => 'crowdfundly-range-value',
            'section'           => 'cf_all_campaign_page',
            'settings'          => 'crowdfundly_all_camp_target_raised_amount_fontsize',
			'label'             => __( 'Target & Raised Amount Font Size', 'crowdfundly' ),
            'input_attrs'       => array(
                'min'    => 5,
                'max'    => 30,
                'step'   => 1,
                'suffix' => 'px'
            ),
			'priority' => 2
		) 
	) );

	$wp_customize->add_setting( 'cf_all_campaign_load_more', array(
		'sanitize_callback' => 'esc_html',
	) );	
	$wp_customize->add_control( new CrowdFundly_Heading_Control( $wp_customize, 'cf_all_campaign_load_more', 
		array(
			'label'	            => __( 'Load More Button', 'crowdfundly' ),
			'settings'	        => 'cf_all_campaign_load_more',
			'section'  	        => 'cf_all_campaign_page',
			'priority'          => 2,
			'input_attrs' => array(
				'class' => 'crowdfundly-heading',
			),
		)
	) );

	$wp_customize->add_setting( 'cf_all_campaign_load_more_hide', array(
        'default' => '',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'crowdfundly_sanitize_checkbox',
    ));
	$wp_customize->add_control( new Crowdfundly_Customizer_Switcher_Control( $wp_customize, 'cf_all_campaign_load_more_hide', 
		array(
			'label' => esc_html__('Hide Section', 'crowdfundly'),
			'section' => 'cf_all_campaign_page',
			'settings' => 'cf_all_campaign_load_more_hide',
			'type' => 'light',
			'priority' => 2
		)
	));

	$wp_customize->add_setting( 'cf_all_campaign_load_more_bg_color', array(
		'default' 			=> '#5777f3',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cf_all_campaign_load_more_bg_color', 
		array(
			'label'      => __( 'Background Color', 'crowdfundly' ),
			'section'    => 'cf_all_campaign_page',
			'settings'   => 'cf_all_campaign_load_more_bg_color',
			'priority'   => 2
		)
	) );

	$wp_customize->add_setting( 'cf_all_campaign_load_more_bg_color_hover', array(
		'default' 			=> '#5777f3',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cf_all_campaign_load_more_bg_color_hover', 
		array(
			'label'      => __( 'Hover Background Color', 'crowdfundly' ),
			'section'    => 'cf_all_campaign_page',
			'settings'   => 'cf_all_campaign_load_more_bg_color_hover',
			'priority'   => 2
		)
	) );

	$wp_customize->add_setting( 'cf_all_campaign_load_more_color', array(
		'default' 			=> '#fff',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cf_all_campaign_load_more_color', 
		array(
			'label'      => __( 'Color', 'crowdfundly' ),
			'section'    => 'cf_all_campaign_page',
			'settings'   => 'cf_all_campaign_load_more_color',
			'priority'   => 2
		)
	) );

	$wp_customize->add_setting( 'cf_all_campaign_load_more_color_hover', array(
		'default' 			=> '#fff',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cf_all_campaign_load_more_color_hover', 
		array(
			'label'      => __( 'Hover Color', 'crowdfundly' ),
			'section'    => 'cf_all_campaign_page',
			'settings'   => 'cf_all_campaign_load_more_color_hover',
			'priority'   => 2
		)
	) );

	$wp_customize->add_setting( 'cf_all_campaign_load_more_border_color', array(
		'default' 			=> '#5777f3',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cf_all_campaign_load_more_border_color', 
		array(
			'label'      => __( 'Border Color', 'crowdfundly' ),
			'section'    => 'cf_all_campaign_page',
			'settings'   => 'cf_all_campaign_load_more_border_color',
			'priority'   => 2
		)
	) );

	$wp_customize->add_setting( 'cf_all_campaign_load_more_border_color_hover', array(
		'default' 			=> '#5777f3',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cf_all_campaign_load_more_border_color_hover', 
		array(
			'label'      => __( 'Hover Border Color', 'crowdfundly' ),
			'section'    => 'cf_all_campaign_page',
			'settings'   => 'cf_all_campaign_load_more_border_color_hover',
			'priority'   => 2
		)
	) );
	
}
