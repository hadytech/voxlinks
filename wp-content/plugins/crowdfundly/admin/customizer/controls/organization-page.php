<?php 

function organization_page($wp_customize) {

	$wp_customize->add_setting( 'crowdfundly_org_common', array(
		'sanitize_callback' => 'esc_html',
	) );	
	$wp_customize->add_control( new CrowdFundly_Heading_Control( $wp_customize, 'crowdfundly_org_common', 
		array(
			'label'	            => __( 'Organization', 'crowdfundly' ),
			'settings'	        => 'crowdfundly_org_common',
			'section'  	        => 'cf_organizaton_page',
			'priority'          => 2,
			'input_attrs' => array(
				'class' => 'crowdfundly-heading',
			),
		)
	) );

	$wp_customize->add_setting( 'crowdfundly_organization_background_color', array(
		'default' 			=> '#f3f4f8',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_organization_background_color', 
		array(
			'label'      => __( 'Page Background Color', 'crowdfundly' ),
			'section'    => 'cf_organizaton_page',
			'settings'   => 'crowdfundly_organization_background_color',
			'priority'   => 2
		)
	) );

	// organization slider
	$wp_customize->add_setting( 'cf_org_slider', array(
		'sanitize_callback' => 'esc_html',
	) );	
	$wp_customize->add_control( new CrowdFundly_Heading_Control( $wp_customize, 'cf_org_slider', 
		array(
			'label'	            => __( 'Slider', 'crowdfundly' ),
			'settings'	        => 'cf_org_slider',
			'section'  	        => 'cf_organizaton_page',
			'priority'          => 2,
			'input_attrs' => array(
				'class' => 'crowdfundly-heading',
			),
		)
	) );

	$wp_customize->add_setting( 'cf_org_hide_slider', array(
        'default' => '',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'crowdfundly_sanitize_checkbox',
    ));
	$wp_customize->add_control(new Crowdfundly_Customizer_Switcher_Control( $wp_customize, 'cf_org_hide_slider', 
		array(
			'label' => esc_html__('Hide Section', 'crowdfundly'),
			'section' => 'cf_organizaton_page',
			'settings' => 'cf_org_hide_slider',
			'type' => 'light', // light, ios, flat
			'priority' => 2
		)
	));

	$wp_customize->add_setting( 'cf_org_slider_height', array(
		'default' 			=> '500',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'crowdfundly_sanitize_integer',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new Crowdfundly_Range_Value_Control( $wp_customize, 'cf_org_slider_height', 
		array(
			'type'              => 'crowdfundly-range-value',
            'section'           => 'cf_organizaton_page',
            'settings'          => 'cf_org_slider_height',
			'label'             => __( 'Height', 'crowdfundly' ),
            'input_attrs'       => array(
                'min'    => 100,
                'max'    => 1500,
                'step'   => 1,
                'suffix' => 'px'
            ),
			'priority' => 2
		) 
	) );

	// organization name controls
	$wp_customize->add_setting( 'crowdfundly_org_detail', array(
		'sanitize_callback' => 'esc_html',
	) );
	$wp_customize->add_control( new CrowdFundly_Heading_Control( $wp_customize, 'crowdfundly_org_detail', 
		array(
			'label'	            => __( 'Organization Detail', 'crowdfundly' ),
			'settings'	        => 'crowdfundly_org_detail',
			'section'  	        => 'cf_organizaton_page',
			'priority'          => 2,
			'input_attrs' => array(
				'class' => 'crowdfundly-heading',
			),
		)
	) );

	$wp_customize->add_setting( 'crowdfundly_org_section_bg_color', array(
		'default' 			=> '#ffffff',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_org_section_bg_color', 
		array(
			'label'      => __( 'Section Background Color', 'crowdfundly' ),
			'section'    => 'cf_organizaton_page',
			'settings'   => 'crowdfundly_org_section_bg_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'cf_org_logo_width', array(
		'default' 			=> '90',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'crowdfundly_sanitize_integer',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new Crowdfundly_Range_Value_Control( $wp_customize, 'cf_org_logo_width', 
		array(
			'type'              => 'crowdfundly-range-value',
            'section'           => 'cf_organizaton_page',
            'settings'          => 'cf_org_logo_width',
			'label'             => __( 'Organization Logo Size', 'crowdfundly' ),
            'input_attrs'       => array(
                'min'    => 10,
                'max'    => 200,
                'step'   => 1,
                'suffix' => 'px'
            ),
			'priority' => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_org_name_color', array(
		'default' 			=> '#31375E',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_org_name_color', 
		array(
			'label'      => __( 'Name Color', 'crowdfundly' ),
			'section'    => 'cf_organizaton_page',
			'settings'   => 'crowdfundly_org_name_color',
			'priority'   => 2
		)
	) );

	$wp_customize->add_setting( 'cf_organization_name_fontsize', array(
		'default' 			=> '18',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'crowdfundly_sanitize_integer',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new Crowdfundly_Range_Value_Control( $wp_customize, 'cf_organization_name_fontsize', 
		array(
			'type'              => 'crowdfundly-range-value',
            'section'           => 'cf_organizaton_page',
            'settings'          => 'cf_organization_name_fontsize',
			'label'             => __( 'Name Font Size', 'crowdfundly' ),
            'input_attrs'       => array(
                'min'    => 1,
                'max'    => 40,
                'step'   => 1,
                'suffix' => 'px'
            ),
			'priority' => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_org_info_color', array(
		'default' 			=> '#7D8091',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_org_info_color', 
		array(
			'label'      => __( 'Address Color', 'crowdfundly' ),
			'section'    => 'cf_organizaton_page',
			'settings'   => 'crowdfundly_org_info_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_organization_social_media_heading_color', array(
		'default' 			=> '#31375E',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_organization_social_media_heading_color', 
		array(
			'label'      => __( 'Social Media Heading Color', 'crowdfundly' ),
			'section'    => 'cf_organizaton_page',
			'settings'   => 'crowdfundly_organization_social_media_heading_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_organization_social_media_name_color', array(
		'default' 			=> '#31375E',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_organization_social_media_name_color', 
		array(
			'label'      => __( 'Social Media Name Color', 'crowdfundly' ),
			'section'    => 'cf_organizaton_page',
			'settings'   => 'crowdfundly_organization_social_media_name_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_organization_social_media_link_color', array(
		'default' 			=> '#7D8091',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_organization_social_media_link_color', 
		array(
			'label'      => __( 'Social Media Link Color', 'crowdfundly' ),
			'section'    => 'cf_organizaton_page',
			'settings'   => 'crowdfundly_organization_social_media_link_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'cf_org_social_media_icon_size', array(
		'default' 			=> '22',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'crowdfundly_sanitize_integer',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new Crowdfundly_Range_Value_Control( $wp_customize, 'cf_org_social_media_icon_size', 
		array(
			'type'              => 'crowdfundly-range-value',
            'section'           => 'cf_organizaton_page',
            'settings'          => 'cf_org_social_media_icon_size',
			'label'             => __( 'Social Icon Size', 'crowdfundly' ),
            'input_attrs'       => array(
                'min'    => 5,
                'max'    => 35,
                'step'   => 1,
                'suffix' => 'px'
            ),
			'priority' => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_organization_title_color', array(
		'default' 			=> '#31375E',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_organization_title_color', 
		array(
			'label'      => __( 'Title Color', 'crowdfundly' ),
			'section'    => 'cf_organizaton_page',
			'settings'   => 'crowdfundly_organization_title_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'cf_organization_title_fontsize', array(
		'default' 			=> '20',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'crowdfundly_sanitize_integer',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new Crowdfundly_Range_Value_Control( $wp_customize, 'cf_organization_title_fontsize', 
		array(
			'type'              => 'crowdfundly-range-value',
            'section'           => 'cf_organizaton_page',
            'settings'          => 'cf_organization_title_fontsize',
			'label'             => __( 'Title Font Size', 'crowdfundly' ),
            'input_attrs'       => array(
                'min'    => 0,
                'max'    => 50,
                'step'   => 1,
                'suffix' => 'px'
            ),
			'priority' => 2
		) 
	) );

	$wp_customize->add_setting( 'cf_organization_title_text_transform', array(
		'default'       => 'uppercase',
		'capability'    => 'edit_theme_options',
		'transport' => 'postMessage',
		'sanitize_callback' => 'crowdfundly_sanitize_select'
	) );
	$wp_customize->add_control( new Crowdfundly_Select_Control( $wp_customize, 'cf_organization_title_text_transform', 
		array(
			'type'     => 'crowdfundly-select',
			'section'  => 'cf_organizaton_page',
			'settings' => 'cf_organization_title_text_transform',
			'label'    => __( 'Title Text Transform', 'crowdfundly' ),
			'priority' => 2,
			'choices'  => array(
				'' => __( 'Select Option', 'crowdfundly' ),
				'uppercase'   	=> __( 'Uppercase', 'crowdfundly' ),
				'capitalize'   	=> __( 'Capitalize', 'crowdfundly' ),
				'lowercase'   => __( 'Lowercase', 'crowdfundly' )
			)
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_organization_desciption_color', array(
		'default' 			=> '#32404e',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_organization_desciption_color', 
		array(
			'label'      => __( 'Description Color', 'crowdfundly' ),
			'section'    => 'cf_organizaton_page',
			'settings'   => 'crowdfundly_organization_desciption_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'cf_organization_description_fontsize', array(
		'default' 			=> '',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'crowdfundly_sanitize_integer',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new Crowdfundly_Range_Value_Control( $wp_customize, 'cf_organization_description_fontsize', 
		array(
			'type'              => 'crowdfundly-range-value',
            'section'           => 'cf_organizaton_page',
            'settings'          => 'cf_organization_description_fontsize',
			'label'             => __( 'Description Font Size', 'crowdfundly' ),
            'input_attrs'       => array(
                'min'    => 0,
                'max'    => 30,
                'step'   => 1,
                'suffix' => 'px'
            ),
			'priority' => 2
		) 
	) );

	// Recent Campaign
	$wp_customize->add_setting( 'cf_org_recent_campaign', array(
		'sanitize_callback' => 'esc_html',
	) );	
	$wp_customize->add_control( new CrowdFundly_Heading_Control( $wp_customize, 'cf_org_recent_campaign', 
		array(
			'label'	            => __( 'Recent Campaign', 'crowdfundly' ),
			'settings'	        => 'cf_org_recent_campaign',
			'section'  	        => 'cf_organizaton_page',
			'priority'          => 2,
			'input_attrs' => array(
				'class' => 'crowdfundly-heading',
			),
		)
	) );

	$wp_customize->add_setting( 'cf_org_hide_recent_camps', array(
        'default' => '',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'crowdfundly_sanitize_checkbox',
    ));
	$wp_customize->add_control(new Crowdfundly_Customizer_Switcher_Control( $wp_customize, 'cf_org_hide_recent_camps', 
		array(
			'label' => esc_html__('Hide Section', 'crowdfundly'),
			'section' => 'cf_organizaton_page',
			'settings' => 'cf_org_hide_recent_camps',
			'type' => 'light',
			'priority' => 2
		)
	));

	$wp_customize->add_setting( 'cf_org_recent_campaign_title', array(
		'default' 			=> 'Recent Campaigns',
		'sanitize_callback' => 'esc_html',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( 'cf_org_recent_campaign_title', 
		array(
			'label'		=> __( 'Heading', 'crowdfundly' ),
			'type'		=> 'text',
            'section'	=> 'cf_organizaton_page',
            'settings'	=> 'cf_org_recent_campaign_title',
			'priority'	=> 2
		) 
	);

	$wp_customize->add_setting( 'cf_org_heading_font_size', array(
		'default' 			=> '20',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'crowdfundly_sanitize_integer',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new Crowdfundly_Range_Value_Control( $wp_customize, 'cf_org_heading_font_size', 
		array(
			'type'              => 'crowdfundly-range-value',
            'section'           => 'cf_organizaton_page',
            'settings'          => 'cf_org_heading_font_size',
			'label'             => __( 'Heading Font Size', 'crowdfundly' ),
            'input_attrs'       => array(
                'min'    => 5,
                'max'    => 60,
                'step'   => 1,
                'suffix' => 'px'
            ),
			'priority' => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_organization_heading_color', array(
		'default' 			=> '#31375E',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_organization_heading_color', 
		array(
			'label'      => __( 'Heading Color', 'crowdfundly' ),
			'section'    => 'cf_organizaton_page',
			'settings'   => 'crowdfundly_organization_heading_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'cf_org_recent_camp_heading_text_transform', array(
		'default'       => 'uppercase',
		'capability'    => 'edit_theme_options',
		'transport' => 'postMessage',
		'sanitize_callback' => 'crowdfundly_sanitize_select'
	) );
	$wp_customize->add_control( new Crowdfundly_Select_Control( $wp_customize, 'cf_org_recent_camp_heading_text_transform', 
		array(
			'type'     => 'crowdfundly-select',
			'section'  => 'cf_organizaton_page',
			'settings' => 'cf_org_recent_camp_heading_text_transform',
			'label'    => __( 'Heading Text Transform', 'crowdfundly' ),
			'priority' => 2,
			'choices'  => array(
				'' => __( 'Select Option', 'crowdfundly' ),
				'uppercase'   	=> __( 'Uppercase', 'crowdfundly' ),
				'capitalize'   	=> __( 'Capitalize', 'crowdfundly' ),
				'lowercase'   => __( 'Lowercase', 'crowdfundly' )
			)
		) 
	) );

	$wp_customize->add_setting( 'cf_org_recent_camp_card', array(
		'sanitize_callback' => 'esc_html',
	) );
	$wp_customize->add_control( new CrowdFundly_Heading_Control( $wp_customize, 'cf_org_recent_camp_card', 
		array(
			'label'	            => __( 'Campaign Card', 'crowdfundly' ),
			'settings'	        => 'cf_org_recent_camp_card',
			'section'  	        => 'cf_organizaton_page',
			'priority'          => 2,
			'input_attrs' => array(
				'class' => 'crowdfundly-heading'
			),
		)
	) );

	$wp_customize->add_setting( 'cf_org_recent_camp_card_column', array(
		'default'       => '3',
		'capability'    => 'edit_theme_options',
		'transport' => 'postMessage',
		'sanitize_callback' => 'crowdfundly_sanitize_select'
	) );
	$wp_customize->add_control( new Crowdfundly_Select_Control( $wp_customize, 'cf_org_recent_camp_card_column', 
		array(
			'type'     => 'crowdfundly-select',
			'section'  => 'cf_organizaton_page',
			'settings' => 'cf_org_recent_camp_card_column',
			'label'    => __( 'Campaign Grid Column', 'crowdfundly' ),
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

	$wp_customize->add_setting( 'crowdfundly_org_card_bg_color', array(
		'default' 			=> '#ffffff',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_org_card_bg_color', 
		array(
			'label'      => __( 'Campaign Background Color', 'crowdfundly' ),
			'section'    => 'cf_organizaton_page',
			'settings'   => 'crowdfundly_org_card_bg_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_org_card_bg_color_hover', array(
		'default' 			=> '',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_org_card_bg_color_hover', 
		array(
			'label'      => __( 'Campaign Hover Background Color', 'crowdfundly' ),
			'section'    => 'cf_organizaton_page',
			'settings'   => 'crowdfundly_org_card_bg_color_hover',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_org_card_image_bg_color', array(
		'default' 			=> '#F5F7FD',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_org_card_image_bg_color', 
		array(
			'label'      => __( 'Campaign Image Background Color', 'crowdfundly' ),
			'section'    => 'cf_organizaton_page',
			'settings'   => 'crowdfundly_org_card_image_bg_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_org_card_name_color', array(
		'default' 			=> '#333333',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_org_card_name_color', 
		array(
			'label'      => __( 'Campaign Name Color', 'crowdfundly' ),
			'section'    => 'cf_organizaton_page',
			'settings'   => 'crowdfundly_org_card_name_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_org_card_name_fontsize', array(
		'default' 			=> '22',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'crowdfundly_sanitize_integer',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new Crowdfundly_Range_Value_Control( $wp_customize, 'crowdfundly_org_card_name_fontsize', 
		array(
			'type'              => 'crowdfundly-range-value',
			'section'           => 'cf_organizaton_page',
			'settings'          => 'crowdfundly_org_card_name_fontsize',
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

	$wp_customize->add_setting( 'crowdfundly_org_card_description_color', array(
		'default' 			=> '#666666',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_org_card_description_color', 
		array(
			'label'      => __( 'Campaign Description Color', 'crowdfundly' ),
			'section'    => 'cf_organizaton_page',
			'settings'   => 'crowdfundly_org_card_description_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_org_card_description_fontsize', array(
		'default' 			=> '22',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'crowdfundly_sanitize_integer',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new Crowdfundly_Range_Value_Control( $wp_customize, 'crowdfundly_org_card_description_fontsize', 
		array(
			'type'              => 'crowdfundly-range-value',
			'section'           => 'cf_organizaton_page',
			'settings'          => 'crowdfundly_org_card_description_fontsize',
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

	$wp_customize->add_setting( 'crowdfundly_org_card_progress_bg_color', array(
		'default' 			=> '#ffffff',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_org_card_progress_bg_color', 
		array(
			'label'      => __( 'Campaign Progress Bar Background Color', 'crowdfundly' ),
			'section'    => 'cf_organizaton_page',
			'settings'   => 'crowdfundly_org_card_progress_bg_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_org_card_progress_color', array(
		'default' 			=> '#5777f3',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_org_card_progress_color', 
		array(
			'label'      => __( 'Campaign Progress Color', 'crowdfundly' ),
			'section'    => 'cf_organizaton_page',
			'settings'   => 'crowdfundly_org_card_progress_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_org_card_raised_amount_color', array(
		'default' 			=> '#000000',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_org_card_raised_amount_color', 
		array(
			'label'      => __( 'Campaign Raised Amount Color', 'crowdfundly' ),
			'section'    => 'cf_organizaton_page',
			'settings'   => 'crowdfundly_org_card_raised_amount_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_org_card_raised_amount_fontsize', array(
		'default' 			=> '22',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'crowdfundly_sanitize_integer',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new Crowdfundly_Range_Value_Control( $wp_customize, 'crowdfundly_org_card_raised_amount_fontsize', 
		array(
			'type'              => 'crowdfundly-range-value',
			'section'           => 'cf_organizaton_page',
			'settings'          => 'crowdfundly_org_card_raised_amount_fontsize',
			'label'             => __( 'Campaign Raised Amount Font Size', 'crowdfundly' ),
			'input_attrs'       => array(
				'min'    => 5,
				'max'    => 30,
				'step'   => 1,
				'suffix' => 'px'
			),
			'priority' => 2
		) 
	) );	

	$wp_customize->add_setting( 'crowdfundly_org_card_target_amount_color', array(
		'default' 			=> '#666666',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_org_card_target_amount_color', 
		array(
			'label'      => __( 'Campaign Target Amount Color', 'crowdfundly' ),
			'section'    => 'cf_organizaton_page',
			'settings'   => 'crowdfundly_org_card_target_amount_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'cf_org_all_camp_btn', array(
		'sanitize_callback' => 'esc_html',
	) );	
	$wp_customize->add_control( new CrowdFundly_Heading_Control( $wp_customize, 'cf_org_all_camp_btn', 
		array(
			'label'	            => __( 'All Campaign Button', 'crowdfundly' ),
			'settings'	        => 'cf_org_all_camp_btn',
			'section'  	        => 'cf_organizaton_page',
			'priority'          => 2,
			'input_attrs' => array(
				'class' => 'crowdfundly-heading',
			),
		)
	) );

	$wp_customize->add_setting( 'cf_org_hide_btn', array(
        'default' => '',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'crowdfundly_sanitize_checkbox',
    ));
	$wp_customize->add_control(new Crowdfundly_Customizer_Switcher_Control( $wp_customize, 'cf_org_hide_btn', 
		array(
			'label' => esc_html__('Hide Button', 'crowdfundly'),
			'section' => 'cf_organizaton_page',
			'settings' => 'cf_org_hide_btn',
			'type' => 'light',
			'priority' => 2
		)
	));

	$wp_customize->add_setting( 'cf_org_camp_button_padding', array(
		'default' 			=> '',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'crowdfundly_sanitize_integer',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new Crowdfundly_Range_Value_Control( $wp_customize, 'cf_org_camp_button_padding', 
		array(
			'type'              => 'crowdfundly-range-value',
            'section'           => 'cf_organizaton_page',
            'settings'          => 'cf_org_camp_button_padding',
			'label'             => __( 'Padding', 'crowdfundly' ),
            'input_attrs'       => array(
                'min'    => 0,
                'max'    => 80,
                'step'   => 1,
                'suffix' => 'px'
            ),
			'priority' => 2
		) 
	) );

	$wp_customize->add_setting( 'cf_org_all_camp_btn_border_radius_heading', array(
		'sanitize_callback' => 'esc_html',
	) );	
	$wp_customize->add_control( new CrowdFundly_Heading_Control( $wp_customize, 'cf_org_all_camp_btn_border_radius_heading', 
		array(
			'label'	            => __( 'Border Radius', 'crowdfundly' ),
			'settings'	        => 'cf_org_all_camp_btn_border_radius_heading',
			'section'  	        => 'cf_organizaton_page',
			'priority'          => 2,
			'input_attrs' => array(
				'class' => 'crowdfundly-general-heading',
			),
		)
	) );

	$ids = [ 
		'cf_org_all_camp_btn_border_radius_top', 
		'cf_org_all_camp_btn_border_radius_right', 
		'cf_org_all_camp_btn_border_radius_bottom',
		'cf_org_all_camp_btn_border_radius_left'
	];
	Crowdfundly_Dimension_Control::four_horse_men($wp_customize, 'cf_organizaton_page', $ids);

	$wp_customize->add_setting( 'crowdfundly_org_btn_bg_color', array(
		'default' 			=> '#5777f3',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_org_btn_bg_color', 
		array(
			'label'      => __( 'Background Color', 'crowdfundly' ),
			'section'    => 'cf_organizaton_page',
			'settings'   => 'crowdfundly_org_btn_bg_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_org_btn_bg_color_hover', array(
		'default' 			=> '#113eed',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_org_btn_bg_color_hover', 
		array(
			'label'      => __( 'Hover Background Color', 'crowdfundly' ),
			'section'    => 'cf_organizaton_page',
			'settings'   => 'crowdfundly_org_btn_bg_color_hover',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_org_btn_color', array(
		'default' 			=> '#ffffff',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_org_btn_color', 
		array(
			'label'      => __( 'Color', 'crowdfundly' ),
			'section'    => 'cf_organizaton_page',
			'settings'   => 'crowdfundly_org_btn_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_org_btn_color_hover', array(
		'default' 			=> '',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_org_btn_color_hover', 
		array(
			'label'      => __( 'Hover Color', 'crowdfundly' ),
			'section'    => 'cf_organizaton_page',
			'settings'   => 'crowdfundly_org_btn_color_hover',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_org_btn_border_color', array(
		'default' 			=> '#5777f3',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_org_btn_border_color', 
		array(
			'label'      => __( 'Border Color', 'crowdfundly' ),
			'section'    => 'cf_organizaton_page',
			'settings'   => 'crowdfundly_org_btn_border_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_org_btn_border_color_hover', array(
		'default' 			=> '#113eed',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_org_btn_border_color_hover', 
		array(
			'label'      => __( 'Hover Border Color', 'crowdfundly' ),
			'section'    => 'cf_organizaton_page',
			'settings'   => 'crowdfundly_org_btn_border_color_hover',
			'priority'   => 2
		) 
	) );

}
