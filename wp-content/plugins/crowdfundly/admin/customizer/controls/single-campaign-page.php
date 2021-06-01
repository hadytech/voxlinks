<?php 

function single_campaign($wp_customize) {
	$wp_customize->add_setting( 'cf_single_camp_heading', array(
		'sanitize_callback' => 'esc_html',
	) );	
	$wp_customize->add_control( new CrowdFundly_Heading_Control( $wp_customize, 'cf_single_camp_heading', 
		array(
			'label'	            => __( 'Campaign', 'crowdfundly' ),
			'settings'	        => 'cf_single_camp_heading',
			'section'  	        => 'cf_single_campaign_page',
			'priority'          => 2,
			'input_attrs' => array(
				'class' => 'crowdfundly-heading',
			),
		)
	) );

	$wp_customize->add_setting( 'crowdfundly_single_camp_page_background_color', array(
		'default' 			=> '#f3f4f8',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_single_camp_page_background_color', 
		array(
			'label'      => __( 'Page background Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'crowdfundly_single_camp_page_background_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'cf_single_camp_detail_heading', array(
		'sanitize_callback' => 'esc_html',
	) );
	$wp_customize->add_control( new CrowdFundly_Heading_Control( $wp_customize, 'cf_single_camp_detail_heading', 
		array(
			'label'	            => __( 'Campaign Detail', 'crowdfundly' ),
			'settings'	        => 'cf_single_camp_detail_heading',
			'section'  	        => 'cf_single_campaign_page',
			'priority'          => 2,
			'input_attrs' => array(
				'class' => 'crowdfundly-heading',
			),
		)
	) );

	$wp_customize->add_setting( 'crowdfundly_single_camp_gallery_img_border_color', array(
		'default' 			=> '#ffffff',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_single_camp_gallery_img_border_color', 
		array(
			'label'      => __( 'Campaign Gallery Image Border Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'crowdfundly_single_camp_gallery_img_border_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_single_camp_gallery_img_bg_color', array(
		'default' 			=> '#F5F7FD',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_single_camp_gallery_img_bg_color', 
		array(
			'label'      => __( 'Campaign Gallery Image Background Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'crowdfundly_single_camp_gallery_img_bg_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_single_camp_gallery_arrow_color', array(
		'default' 			=> '#ffffff',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_single_camp_gallery_arrow_color', 
		array(
			'label'      => __( 'Campaign Gallery Arrow Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'crowdfundly_single_camp_gallery_arrow_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_single_camp_name_color', array(
		'default' 			=> '#31375E',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_single_camp_name_color', 
		array(
			'label'      => __( 'Campaign Name Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'crowdfundly_single_camp_name_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'cf_single_camp_name_fontsize', array(
		'default' 			=> '22',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'crowdfundly_sanitize_integer',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new Crowdfundly_Range_Value_Control( $wp_customize, 'cf_single_camp_name_fontsize', 
		array(
			'type'              => 'crowdfundly-range-value',
            'section'           => 'cf_single_campaign_page',
            'settings'          => 'cf_single_camp_name_fontsize',
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

	$wp_customize->add_setting( 'cf_single_camp_name_text_transform', array(
		'default'       => 'capitalize',
		'capability'    => 'edit_theme_options',
		'transport' => 'postMessage',
		'sanitize_callback' => 'crowdfundly_sanitize_select'
	) );
	$wp_customize->add_control( new Crowdfundly_Select_Control( $wp_customize, 'cf_single_camp_name_text_transform', 
		array(
			'type'     => 'crowdfundly-select',
			'section'  => 'cf_single_campaign_page',
			'settings' => 'cf_single_camp_name_text_transform',
			'label'    => __( 'Campaign Name Text Transform', 'crowdfundly' ),
			'priority' => 2,
			'choices'  => array(
				'' => __( 'Select Option', 'crowdfundly' ),
				'uppercase'   	=> __( 'Uppercase', 'crowdfundly' ),
				'capitalize'   	=> __( 'Capitalize', 'crowdfundly' ),
				'lowercase'   => __( 'Lowercase', 'crowdfundly' )
			)
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_single_camp_status_color', array(
		'default' 			=> '#3bc065',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_single_camp_status_color', 
		array(
			'label'      => __( 'Campaign Status Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'crowdfundly_single_camp_status_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_single_camp_org_name_color', array(
		'default' 			=> '#666666',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_single_camp_org_name_color', 
		array(
			'label'      => __( 'Organization Name Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'crowdfundly_single_camp_org_name_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_single_camp_org_name_fontsize', array(
		'default' 			=> '22',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'crowdfundly_sanitize_integer',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new Crowdfundly_Range_Value_Control( $wp_customize, 'crowdfundly_single_camp_org_name_fontsize', 
		array(
			'type'              => 'crowdfundly-range-value',
			'section'           => 'cf_single_campaign_page',
			'settings'          => 'crowdfundly_single_camp_org_name_fontsize',
			'label'             => __( 'Organization Name Font Size', 'crowdfundly' ),
			'input_attrs'       => array(
				'min'    => 5,
				'max'    => 30,
				'step'   => 1,
				'suffix' => 'px'
			),
			'priority' => 2
		) 
	) );	

	$wp_customize->add_setting( 'crowdfundly_single_camp_org_name_by_color', array(
		'default' 			=> '#999999',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_single_camp_org_name_by_color', 
		array(
			'label'      => __( '"By" Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'crowdfundly_single_camp_org_name_by_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_single_camp_funding_goal_box_bg_color', array(
		'default' 			=> '#ffffff',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_single_camp_funding_goal_box_bg_color', 
		array(
			'label'      => __( 'Funding Goal background Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'crowdfundly_single_camp_funding_goal_box_bg_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_single_camp_funding_goal_box_color', array(
		'default' 			=> '',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_single_camp_funding_goal_box_color', 
		array(
			'label'      => __( 'Funding Goal Text Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'crowdfundly_single_camp_funding_goal_box_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_single_camp_funding_raised_bg_color', array(
		'default' 			=> '#ffffff',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_single_camp_funding_raised_bg_color', 
		array(
			'label'      => __( 'Funding Raised background Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'crowdfundly_single_camp_funding_raised_bg_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_single_camp_funding_raised_color', array(
		'default' 			=> '',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_single_camp_funding_raised_color', 
		array(
			'label'      => __( 'Funding Raised Text Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'crowdfundly_single_camp_funding_raised_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_single_camp_funding_duration_bg_color', array(
		'default' 			=> '#ffffff',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_single_camp_funding_duration_bg_color', 
		array(
			'label'      => __( 'Funding Duration background Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'crowdfundly_single_camp_funding_duration_bg_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_single_camp_funding_duration_color', array(
		'default' 			=> '',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_single_camp_funding_duration_color', 
		array(
			'label'      => __( 'Funding Duration Text Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'crowdfundly_single_camp_funding_duration_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_single_camp_progress_bar_bg_color', array(
		'default' 			=> '#ffffff',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_single_camp_progress_bar_bg_color', 
		array(
			'label'      => __( 'Progress Bar Background Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'crowdfundly_single_camp_progress_bar_bg_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_single_camp_progress_bar_color', array(
		'default' 			=> '#14C479',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_single_camp_progress_bar_color', 
		array(
			'label'      => __( 'Progress Bar Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'crowdfundly_single_camp_progress_bar_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_single_camp_contribute_btn_bg_color', array(
		'default' 			=> '#5777f3',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_single_camp_contribute_btn_bg_color', 
		array(
			'label'      => __( 'Contribute Button Background Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'crowdfundly_single_camp_contribute_btn_bg_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_single_camp_contribute_btn_color', array(
		'default' 			=> '#ffffff',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_single_camp_contribute_btn_color', 
		array(
			'label'      => __( 'Contribute Button Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'crowdfundly_single_camp_contribute_btn_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_single_camp_contribute_btn_border_color', array(
		'default' 			=> '#5777f3',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_single_camp_contribute_btn_border_color', 
		array(
			'label'      => __( 'Contribute Button Border Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'crowdfundly_single_camp_contribute_btn_border_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_single_camp_contribute_btn_hover_bg_color', array(
		'default' 			=> '#113eed',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_single_camp_contribute_btn_hover_bg_color', 
		array(
			'label'      => __( 'Contribute Button Hover Background Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'crowdfundly_single_camp_contribute_btn_hover_bg_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_single_camp_contribute_btn_hover_color', array(
		'default' 			=> '#ffffff',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_single_camp_contribute_btn_hover_color', 
		array(
			'label'      => __( 'Contribute Button Hover Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'crowdfundly_single_camp_contribute_btn_hover_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'crowdfundly_single_camp_contribute_btn_hover_border_color', array(
		'default' 			=> '#113eed',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crowdfundly_single_camp_contribute_btn_hover_border_color', 
		array(
			'label'      => __( 'Contribute Button Hover Border Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'crowdfundly_single_camp_contribute_btn_hover_border_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'cf_single_campn_donation_btn_texts', array(
		'default' 			=> __( 'Contribute', 'crowdfundly' ),
		'sanitize_callback' => 'esc_html',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( 'cf_single_campn_donation_btn_texts',  
		array(
			'label'		=> __( 'Contribute Button Text', 'crowdfundly' ),
			'type'		=> 'text',
            'section'	=> 'cf_single_campaign_page',
            'settings'	=> 'cf_single_campn_donation_btn_texts',
			'priority'	=> 2
		) 
	);

	$wp_customize->add_setting( 'cf_single_campn_donation_btn_text_transform', array(
		'default'       => 'capitalize',
		'capability'    => 'edit_theme_options',
		'transport' => 'postMessage',
		'sanitize_callback' => 'crowdfundly_sanitize_select'
	) );
	$wp_customize->add_control( new Crowdfundly_Select_Control( $wp_customize, 'cf_single_campn_donation_btn_text_transform', 
		array(
			'type'     => 'crowdfundly-select',
			'section'  => 'cf_single_campaign_page',
			'settings' => 'cf_single_campn_donation_btn_text_transform',
			'label'    => __( 'Contribute Button Text Transform', 'crowdfundly' ),
			'priority' => 2,
			'choices'  => array(
				'' => __( 'Select Option', 'crowdfundly' ),
				'uppercase'   	=> __( 'Uppercase', 'crowdfundly' ),
				'capitalize'   	=> __( 'Capitalize', 'crowdfundly' ),
				'lowercase'   => __( 'Lowercase', 'crowdfundly' )
			)
		) 
	) );

	$wp_customize->add_setting( 'cf_single_campn_donation_btn_text_fontsize', array(
		'default' 			=> '22',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'crowdfundly_sanitize_integer',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new Crowdfundly_Range_Value_Control( $wp_customize, 'cf_single_campn_donation_btn_text_fontsize', 
		array(
			'type'              => 'crowdfundly-range-value',
			'section'           => 'cf_single_campaign_page',
			'settings'          => 'cf_single_campn_donation_btn_text_fontsize',
			'label'             => __( 'Contribute Button Font Size', 'crowdfundly' ),
			'input_attrs'       => array(
				'min'    => 5,
				'max'    => 30,
				'step'   => 1,
				'suffix' => 'px'
			),
			'priority' => 2
		) 
	) );	

	$wp_customize->add_setting( 'cf_single_camp_donation_popup', array(
		'sanitize_callback' => 'esc_html',
	) );
	$wp_customize->add_control( new CrowdFundly_Heading_Control( $wp_customize, 'cf_single_camp_donation_popup', 
		array(
			'label'	            => __( 'Donation Popup', 'crowdfundly' ),
			'settings'	        => 'cf_single_camp_donation_popup',
			'section'  	        => 'cf_single_campaign_page',
			'priority'          => 2,
			'input_attrs' => array(
				'class' => 'crowdfundly-heading',
			),
		)
	) );

	$wp_customize->add_setting( 'cf_single_camp_donation_popup_bg_color', array(
		'default' 			=> '#ffffff',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cf_single_camp_donation_popup_bg_color', 
		array(
			'label'      => __( 'Popup Background Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'cf_single_camp_donation_popup_bg_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'cf_single_camp_donation_popup_presets_bg_color', array(
		'default' 			=> '#f3f4f8',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cf_single_camp_donation_popup_presets_bg_color', 
		array(
			'label'      => __( 'Popup Preset Background Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'cf_single_camp_donation_popup_presets_bg_color',
			'priority'   => 2
		)
	) );

	$wp_customize->add_setting( 'cf_single_camp_donation_popup_presets_bg_color_hover', array(
		'default' 			=> '#ffffff',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cf_single_camp_donation_popup_presets_bg_color_hover', 
		array(
			'label'      => __( 'Popup Preset Hover Background Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'cf_single_camp_donation_popup_presets_bg_color_hover',
			'priority'   => 2
		)
	) );

	$wp_customize->add_setting( 'cf_single_camp_donation_popup_presets_color', array(
		'default' 			=> '',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cf_single_camp_donation_popup_presets_color', 
		array(
			'label'      => __( 'Popup Preset Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'cf_single_camp_donation_popup_presets_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'cf_single_camp_donation_popup_input_bg_color', array(
		'default' 			=> '#ffffff',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cf_single_camp_donation_popup_input_bg_color', 
		array(
			'label'      => __( 'Popup Input Background Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'cf_single_camp_donation_popup_input_bg_color',
			'priority'   => 2
		)
	) );

	$wp_customize->add_setting( 'cf_single_camp_donation_popup_input_border_color', array(
		'default' 			=> '#5777f3',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cf_single_camp_donation_popup_input_border_color', 
		array(
			'label'      => __( 'Popup Input Border Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'cf_single_camp_donation_popup_input_border_color',
			'priority'   => 2
		)
	) );

	$wp_customize->add_setting( 'cf_single_camp_donation_popup_active_btn_bg_color', array(
		'default' 			=> '#5777f3',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cf_single_camp_donation_popup_active_btn_bg_color', 
		array(
			'label'      => __( 'Popup Active Button Background Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'cf_single_camp_donation_popup_active_btn_bg_color',
			'priority'   => 2
		)
	) );

	$wp_customize->add_setting( 'cf_single_camp_donation_popup_active_btn_color', array(
		'default' 			=> '#ffffff',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cf_single_camp_donation_popup_active_btn_color', 
		array(
			'label'      => __( 'Popup Active Button Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'cf_single_camp_donation_popup_active_btn_color',
			'priority'   => 2
		)
	) );	

	$wp_customize->add_setting( 'cf_single_camp_donation_popup_active_btn_border_color', array(
		'default' 			=> '#5777f3',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cf_single_camp_donation_popup_active_btn_border_color', 
		array(
			'label'      => __( 'Popup Active Button Border Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'cf_single_camp_donation_popup_active_btn_border_color',
			'priority'   => 2
		)
	) );

	$wp_customize->add_setting( 'cf_single_camp_donation_popup_active_btn_fontsize', array(
		'default' 			=> '22',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'crowdfundly_sanitize_integer',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new Crowdfundly_Range_Value_Control( $wp_customize, 'cf_single_camp_donation_popup_active_btn_fontsize', 
		array(
			'type'              => 'crowdfundly-range-value',
			'section'           => 'cf_single_campaign_page',
			'settings'          => 'cf_single_camp_donation_popup_active_btn_fontsize',
			'label'             => __( 'Popup Active Button Font Size', 'crowdfundly' ),
			'input_attrs'       => array(
				'min'    => 5,
				'max'    => 30,
				'step'   => 1,
				'suffix' => 'px'
			),
			'priority' => 2
		) 
	) );

	$wp_customize->add_setting( 'cf_single_camp_tabs', array(
		'sanitize_callback' => 'esc_html',
	) );	
	$wp_customize->add_control( new CrowdFundly_Heading_Control( $wp_customize, 'cf_single_camp_tabs', 
		array(
			'label'	            => __( 'Tabs', 'crowdfundly' ),
			'settings'	        => 'cf_single_camp_tabs',
			'section'  	        => 'cf_single_campaign_page',
			'priority'          => 2,
			'input_attrs' => array(
				'class' => 'crowdfundly-heading',
			),
		)
	) );

	$wp_customize->add_setting( 'cf_single_camp_tabs_bg_color', array(
		'default' 			=> '#ffffff',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cf_single_camp_tabs_bg_color', 
		array(
			'label'      => __( 'Tab Background Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'cf_single_camp_tabs_bg_color',
			'priority'   => 2
		) 
	) );

	$wp_customize->add_setting( 'cf_single_camp_tabs_nav_color', array(
		'default' 			=> '#31375E',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cf_single_camp_tabs_nav_color', 
		array(
			'label'      => __( 'Tab Text Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'cf_single_camp_tabs_nav_color',
			'priority'   => 2
		)
	) );

	$wp_customize->add_setting( 'cf_single_camp_tabs_nav_fontsize', array(
		'default' 			=> '22',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'crowdfundly_sanitize_integer',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new Crowdfundly_Range_Value_Control( $wp_customize, 'cf_single_camp_tabs_nav_fontsize', 
		array(
			'type'              => 'crowdfundly-range-value',
			'section'           => 'cf_single_campaign_page',
			'settings'          => 'cf_single_camp_tabs_nav_fontsize',
			'label'             => __( 'Tab Text Font Size', 'crowdfundly' ),
			'input_attrs'       => array(
				'min'    => 5,
				'max'    => 30,
				'step'   => 1,
				'suffix' => 'px'
			),
			'priority' => 2
		) 
	) );	

	$wp_customize->add_setting( 'cf_single_camp_tabs_active_tab_nav_bg_color', array(
		'default' 			=> '',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cf_single_camp_tabs_active_tab_nav_bg_color', 
		array(
			'label'      => __( 'Active Tab Background Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'cf_single_camp_tabs_active_tab_nav_bg_color',
			'priority'   => 2
		)
	) );

	$wp_customize->add_setting( 'cf_single_camp_tabs_active_tab_nav_color', array(
		'default' 			=> '#495057',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cf_single_camp_tabs_active_tab_nav_color', 
		array(
			'label'      => __( 'Active Tab Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'cf_single_camp_tabs_active_tab_nav_color',
			'priority'   => 2
		)
	) );

	$wp_customize->add_setting( 'cf_single_camp_tabs_active_tab_nav_border_color', array(
		'default' 			=> '#5777f3',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cf_single_camp_tabs_active_tab_nav_border_color', 
		array(
			'label'      => __( 'Active Tab Border Bottom Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'cf_single_camp_tabs_active_tab_nav_border_color',
			'priority'   => 2
		)
	) );

	$wp_customize->add_setting( 'cf_single_camp_tabs_content_background_color', array(
		'default' 			=> '#f3f4f8',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cf_single_camp_tabs_content_background_color', 
		array(
			'label'      => __( 'Tab Content Background Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'cf_single_camp_tabs_content_background_color',
			'priority'   => 2
		)
	) );

	$wp_customize->add_setting( 'cf_single_camp_tabs_content_card_bg_color', array(
		'default' 			=> '#ffffff',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cf_single_camp_tabs_content_card_bg_color', 
		array(
			'label'      => __( 'Tab Content Card Background Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'cf_single_camp_tabs_content_card_bg_color',
			'priority'   => 2
		)
	) );

	$wp_customize->add_setting( 'cf_single_camp_tabs_activity_tab_btn_bg_color', array(
		'default' 			=> '#5777f3',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cf_single_camp_tabs_activity_tab_btn_bg_color', 
		array(
			'label'      => __( 'Activity Tab Button Background Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'cf_single_camp_tabs_activity_tab_btn_bg_color',
			'priority'   => 2
		)
	) );

	$wp_customize->add_setting( 'cf_single_camp_tabs_activity_tab_btn_color', array(
		'default' 			=> '#ffffff',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cf_single_camp_tabs_activity_tab_btn_color', 
		array(
			'label'      => __( 'Activity Button Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'cf_single_camp_tabs_activity_tab_btn_color',
			'priority'   => 2
		)
	) );

	$wp_customize->add_setting( 'cf_single_camp_tabs_activity_tab_btn_fontsize', array(
		'default' 			=> '22',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'crowdfundly_sanitize_integer',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new Crowdfundly_Range_Value_Control( $wp_customize, 'cf_single_camp_tabs_activity_tab_btn_fontsize', 
		array(
			'type'              => 'crowdfundly-range-value',
			'section'           => 'cf_single_campaign_page',
			'settings'          => 'cf_single_camp_tabs_activity_tab_btn_fontsize',
			'label'             => __( 'Activity Button Font Size', 'crowdfundly' ),
			'input_attrs'       => array(
				'min'    => 5,
				'max'    => 30,
				'step'   => 1,
				'suffix' => 'px'
			),
			'priority' => 2
		) 
	) );	

	$wp_customize->add_setting( 'cf_single_camp_tabs_activity_tab_btn_border_color', array(
		'default' 			=> '#5777f3',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cf_single_camp_tabs_activity_tab_btn_border_color', 
		array(
			'label'      => __( 'Activity Tab Border Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'cf_single_camp_tabs_activity_tab_btn_border_color',
			'priority'   => 2
		)
	) );

	// similar campaigns
	$wp_customize->add_setting( 'cf_single_camp_similar_campaign', array(
		'sanitize_callback' => 'esc_html',
	) );	
	$wp_customize->add_control( new CrowdFundly_Heading_Control( $wp_customize, 'cf_single_camp_similar_campaign', 
		array(
			'label'	            => __( 'Similar Campaign', 'crowdfundly' ),
			'settings'	        => 'cf_single_camp_similar_campaign',
			'section'  	        => 'cf_single_campaign_page',
			'priority'          => 2,
			'input_attrs' => array(
				'class' => 'crowdfundly-heading',
			),
		)
	) );

	$wp_customize->add_setting( 'cf_single_camp_hide_similar_camps', array(
        'default' => '',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'crowdfundly_sanitize_checkbox',
    ));
	$wp_customize->add_control(new Crowdfundly_Customizer_Switcher_Control( $wp_customize, 'cf_single_camp_hide_similar_camps', 
		array(
			'label' => esc_html__('Hide Section', 'crowdfundly'),
			'section' => 'cf_single_campaign_page',
			'settings' => 'cf_single_camp_hide_similar_camps',
			'type' => 'light',
			'priority' => 2
		)
	));

	$wp_customize->add_setting( 'cf_single_camp_similar_campaign_heading', array(
		'default' 			=> 'Similar Campaign',
		'sanitize_callback' => 'esc_html',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( 'cf_single_camp_similar_campaign_heading', 
		array(
			'label'		=> __( 'Heading', 'crowdfundly' ),
			'type'		=> 'text',
            'section'	=> 'cf_single_campaign_page',
            'settings'	=> 'cf_single_camp_similar_campaign_heading',
			'priority'	=> 2
		) 
	);	

	$wp_customize->add_setting( 'cf_single_camp_similar_camp_heading_color', array(
		'default' 			=> '',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cf_single_camp_similar_camp_heading_color', 
		array(
			'label'      => __( 'Heading Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'cf_single_camp_similar_camp_heading_color',
			'priority'   => 2
		)
	) );

	$wp_customize->add_setting( 'cf_single_camp_heading_fontsize', array(
		'default' 			=> '28',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'crowdfundly_sanitize_integer',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new Crowdfundly_Range_Value_Control( $wp_customize, 'cf_single_camp_heading_fontsize', 
		array(
			'type'              => 'crowdfundly-range-value',
            'section'           => 'cf_single_campaign_page',
            'settings'          => 'cf_single_camp_heading_fontsize',
			'label'             => __( 'Heading Font Size', 'crowdfundly' ),
            'input_attrs'       => array(
                'min'    => 1,
                'max'    => 80,
                'step'   => 1,
                'suffix' => 'px'
            ),
			'priority' => 2
		) 
	) );	

	$wp_customize->add_setting( 'cf_similar_camp_heading_text_transform', array(
		'default'       => 'uppercase',
		'capability'    => 'edit_theme_options',
		'transport' => 'postMessage',
		'sanitize_callback' => 'crowdfundly_sanitize_select'
	) );
	$wp_customize->add_control( new Crowdfundly_Select_Control( $wp_customize, 'cf_similar_camp_heading_text_transform', 
		array(
			'type'     => 'crowdfundly-select',
			'section'  => 'cf_single_campaign_page',
			'settings' => 'cf_similar_camp_heading_text_transform',
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

	$wp_customize->add_setting( 'cf_single_camp_card', array(
		'sanitize_callback' => 'esc_html',
	) );	
	$wp_customize->add_control( new CrowdFundly_Heading_Control( $wp_customize, 'cf_single_camp_card', 
		array(
			'label'	            => __( 'Campaign Card', 'crowdfundly' ),
			'settings'	        => 'cf_single_camp_card',
			'section'  	        => 'cf_single_campaign_page',
			'priority'          => 2,
			'input_attrs' => array(
				'class' => 'crowdfundly-heading',
			),
		)
	) );

	$wp_customize->add_setting( 'cf_single_camp_card_column', array(
		'default'       => '',
		'capability'    => 'edit_theme_options',
		'transport' => 'postMessage',
		'sanitize_callback' => 'crowdfundly_sanitize_select'
	) );
	$wp_customize->add_control( new Crowdfundly_Select_Control( $wp_customize, 'cf_single_camp_card_column', 
		array(
			'type'     => 'crowdfundly-select',
			'section'  => 'cf_single_campaign_page',
			'settings' => 'cf_single_camp_card_column',
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

	$wp_customize->add_setting( 'cf_single_camp_similar_camp_card_bg_color', array(
		'default' 			=> '',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cf_single_camp_similar_camp_card_bg_color', 
		array(
			'label'      => __( 'Campaign Background Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'cf_single_camp_similar_camp_card_bg_color',
			'priority'   => 2
		)
	) );

	$wp_customize->add_setting( 'cf_single_camp_similar_camp_card_bg_color_hover', array(
		'default' 			=> '',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cf_single_camp_similar_camp_card_bg_color_hover', 
		array(
			'label'      => __( 'Campaign Hover Background Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'cf_single_camp_similar_camp_card_bg_color_hover',
			'priority'   => 2
		)
	) );

	$wp_customize->add_setting( 'cf_single_camp_similar_camp_card_image_bg_color', array(
		'default' 			=> '',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cf_single_camp_similar_camp_card_image_bg_color', 
		array(
			'label'      => __( 'Campaign Image Background Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'cf_single_camp_similar_camp_card_image_bg_color',
			'priority'   => 2
		)
	) );

	$wp_customize->add_setting( 'cf_single_camp_similar_camp_card_title_color', array(
		'default' 			=> '',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cf_single_camp_similar_camp_card_title_color', 
		array(
			'label'      => __( 'Campaign Title Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'cf_single_camp_similar_camp_card_title_color',
			'priority'   => 2
		)
	) );
	
	$wp_customize->add_setting( 'cf_single_camp_similar_camp_card_title_fontsize', array(
		'default' 			=> '22',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'crowdfundly_sanitize_integer',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new Crowdfundly_Range_Value_Control( $wp_customize, 'cf_single_camp_similar_camp_card_title_fontsize', 
		array(
			'type'              => 'crowdfundly-range-value',
			'section'           => 'cf_single_campaign_page',
			'settings'          => 'cf_single_camp_similar_camp_card_title_fontsize',
			'label'             => __( 'Campaign Title Font Size', 'crowdfundly' ),
			'input_attrs'       => array(
				'min'    => 5,
				'max'    => 30,
				'step'   => 1,
				'suffix' => 'px'
			),
			'priority' => 2
		) 
	) );	

	$wp_customize->add_setting( 'cf_single_camp_similar_camp_card_description_color', array(
		'default' 			=> '',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cf_single_camp_similar_camp_card_description_color', 
		array(
			'label'      => __( 'Campaign Description Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'cf_single_camp_similar_camp_card_description_color',
			'priority'   => 2
		)
	) );

	$wp_customize->add_setting( 'cf_single_camp_similar_camp_card_description_fontsize', array(
		'default' 			=> '22',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'crowdfundly_sanitize_integer',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new Crowdfundly_Range_Value_Control( $wp_customize, 'cf_single_camp_similar_camp_card_description_fontsize', 
		array(
			'type'              => 'crowdfundly-range-value',
            'section'           => 'cf_single_campaign_page',
            'settings'          => 'cf_single_camp_similar_camp_card_description_fontsize',
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

	$wp_customize->add_setting( 'cf_single_camp_similar_camp_card_progress_bar_bg_color', array(
		'default' 			=> '',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cf_single_camp_similar_camp_card_progress_bar_bg_color', 
		array(
			'label'      => __( 'Campaign Progress Bar Background Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'cf_single_camp_similar_camp_card_progress_bar_bg_color',
			'priority'   => 2
		)
	) );

	$wp_customize->add_setting( 'cf_single_camp_similar_camp_card_progress_color', array(
		'default' 			=> '',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cf_single_camp_similar_camp_card_progress_color', 
		array(
			'label'      => __( 'Campaign Progress Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'cf_single_camp_similar_camp_card_progress_color',
			'priority'   => 2
		)
	) );

	$wp_customize->add_setting( 'cf_single_camp_similar_camp_card_raised_amount_color', array(
		'default' 			=> '',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cf_single_camp_similar_camp_card_raised_amount_color', 
		array(
			'label'      => __( 'Raised Amount Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'cf_single_camp_similar_camp_card_raised_amount_color',
			'priority'   => 2
		)
	) );

	$wp_customize->add_setting( 'cf_single_camp_similar_camp_card_raised_amount_fontsize', array(
		'default' 			=> '22',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'crowdfundly_sanitize_integer',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new Crowdfundly_Range_Value_Control( $wp_customize, 'cf_single_camp_similar_camp_card_raised_amount_fontsize', 
		array(
			'type'              => 'crowdfundly-range-value',
            'section'           => 'cf_single_campaign_page',
            'settings'          => 'cf_single_camp_similar_camp_card_raised_amount_fontsize',
			'label'             => __( 'Raised Amount Font Size', 'crowdfundly' ),
            'input_attrs'       => array(
                'min'    => 5,
                'max'    => 30,
                'step'   => 1,
                'suffix' => 'px'
            ),
			'priority' => 2
		) 
	) );

	$wp_customize->add_setting( 'cf_single_camp_similar_camp_card_target_amount_color', array(
		'default' 			=> '',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cf_single_camp_similar_camp_card_target_amount_color', 
		array(
			'label'      => __( 'Target Amount Color', 'crowdfundly' ),
			'section'    => 'cf_single_campaign_page',
			'settings'   => 'cf_single_camp_similar_camp_card_target_amount_color',
			'priority'   => 2
		)
	) );

	$wp_customize->add_setting( 'cf_single_camp_similar_camp_card_target_amount_fontsize', array(
		'default' 			=> '22',
		'capability'    	=> 'edit_theme_options',
		'sanitize_callback' => 'crowdfundly_sanitize_integer',
		'transport' 		=> 'postMessage'
	) );
	$wp_customize->add_control( new Crowdfundly_Range_Value_Control( $wp_customize, 'cf_single_camp_similar_camp_card_target_amount_fontsize', 
		array(
			'type'              => 'crowdfundly-range-value',
            'section'           => 'cf_single_campaign_page',
            'settings'          => 'cf_single_camp_similar_camp_card_target_amount_fontsize',
			'label'             => __( 'Target Amount Font Size', 'crowdfundly' ),
            'input_attrs'       => array(
                'min'    => 5,
                'max'    => 30,
                'step'   => 1,
                'suffix' => 'px'
            ),
			'priority' => 2
		) 
	) );	
	
}
