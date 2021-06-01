<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;

class Crowdfundly_Organization_Widget extends Widget_Base {
	public function get_name() {
		return 'crowdfundly-organization';
	}

	public function get_title() {
		return __( 'Crowdfundly Organization', 'crowdfundly' );
	}

	public function get_icon() {
		return 'icon-org';
	}

	public function get_keywords() {
		return [ 'crowdfundly', 'fund', 'donation', 'organization' ];
	}

	public function get_categories() {
		return [ 'crowdfundly_elementor_category' ];
	}

	protected function get_social_info(){
		$organization = \Crowdfundly_Settings::get('organization');
        $username 	  = isset($organization->username)?$organization->username:''; 
        $orgs_info    = \Crowdfundly_Api::get('organization', [], $username);
        if( !empty( $orgs_info ) ){
            return $orgs_info->socialProfiles;
		}
		return false;
	}

	protected function get_social_control(){
		if( $this->get_social_info() ){
			foreach($this->get_social_info() as $profile):
				if( !empty($profile->link) ):
				$this->add_control(
					'hide_'.$profile->social_network->name,
					[
						'label' => sprintf(__("Hide %s", 'crowdfundly'), ucfirst($profile->social_network->name) ),
						'type' => Controls_Manager::SWITCHER,
						'default' => false,
						'return_value' => 'yes',
						'selectors' => [
							'{{WRAPPER}} .organization__social-item--'.$profile->social_network->name => 'display: none;',
						]
					]
				);
				endif;
			endforeach;	
		}
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'_common_settings_section',
			[
				'label' => __( 'Crowdfundly', 'crowdfundly' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'common_section_background_color',
			[
				'label' => __( 'Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#f3f4f8',
				'selectors' => [
					'{{WRAPPER}} .content-wrapper.template .content-body' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'_slider_section',
			[
				'label' => __( 'Slider', 'crowdfundly' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'hide_slider',
			[
				'label' => __( 'Hide Section', 'crowdfundly' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => false,
				'return_value' => 'yes',
				'selectors' => [
					'{{WRAPPER}} .organization__slider' => 'display: none;',
				]
			]
		);

		$this->add_responsive_control(
			'image_width',
			[
				'label' => __( 'Width', 'crowdfundly' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'default' => [
					'unit' => 'px',
					'size' => 500
				],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 150,
						'max' => 1200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .organization__slider .slide' => 'height: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'_organization_detail_section',
			[
				'label' => __( 'Organization Detail', 'crowdfundly' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'org_detail_background_color',
			[
				'label' => __( 'Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .organization__details' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'org_detail_box_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .organization__details'
			]
		);

		$this->add_control(
			'_heading_logo',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Logo', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'logo_width',
			[
				'label' => __( 'Width', 'crowdfundly' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 10,
						'max' => 400,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .organization__info-logo-img' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .organization__info-logo' => 'width: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_responsive_control(
			'logo_height',
			[
				'label' => __( 'Height', 'crowdfundly' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 10,
						'max' => 400,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .organization__info-logo-img' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .organization__info-logo' => 'height: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'logo_border',
				'selector' => '{{WRAPPER}} .organization__info-logo',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'logo_box_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .organization__info-logo'
			]
		);

		$this->add_control(
			'_heading_org_name',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Organization Name', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'org_name_typography',
				'label' => __( 'Typography', 'crowdfundly' ),
				'exclude' => [
					'line_height'
				],
				'selector' => '{{WRAPPER}} .organization__info-name',
				'scheme' => Typography::TYPOGRAPHY_2,
			]
		);

		$this->add_control(
			'org_name_color',
			[
				'label' => __( 'Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#31375E',
				'selectors' => [
					'{{WRAPPER}} .organization__info-name' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'_heading_org_address',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Address', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'org_short_description_typography',
				'label' => __( 'Typography', 'crowdfundly' ),
				'exclude' => [
					'line_height'
				],
				'selector' => '{{WRAPPER}} .organization__info-address',
				'scheme' => Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_control(
			'org_short_description_color',
			[
				'label' => __( 'Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#7D8091',
				'selectors' => [
					'{{WRAPPER}} .organization__info-address' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'_heading_org_title',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Title', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'org_title_typography',
				'label' => __( 'Typography', 'crowdfundly' ),
				'selector' => '{{WRAPPER}} .organization__details-title',
				'scheme' => Typography::TYPOGRAPHY_2,
			]
		);

		$this->add_control(
			'org_title_color',
			[
				'label' => __( 'Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#31375E',
				'selectors' => [
					'{{WRAPPER}} .organization__details-title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'_heading_org_description',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Description', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'org_description_typography',
				'label' => __( 'Typography', 'crowdfundly' ),
				'selector' => '{{WRAPPER}} .organization__details-description > p',
				'scheme' => Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_control(
			'org_description_color',
			[
				'label' => __( 'Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#31375E',
				'selectors' => [
					'{{WRAPPER}} .organization__details-description > p' => 'color: {{VALUE}}',
					'{{WRAPPER}} .organization__details-description > p > *' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'_organization_social_media',
			[
				'label' => __( 'Social Media', 'crowdfundly' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->get_social_control();

		$this->add_control(
			'_heading_org_social_heading',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Heading', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'social_heading_space_bottom',
			[
				'label' => __( 'Bottom Spacing', 'crowdfundly' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 80,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .organization__social-title' => 'margin-bottom: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_responsive_control(
			'social_media_space_between',
			[
				'label' => __( 'Space Between Icon & Text', 'crowdfundly' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 60,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .organization__social-item-details' => 'padding-left: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'social_heading_typography',
				'label' => __( 'Heading Typography', 'crowdfundly' ),
				'selector' => '{{WRAPPER}} .organization__social-title',
				'scheme' => Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_control(
			'social_heading_color',
			[
				'label' => __( 'Heading Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#31375E',
				'selectors' => [
					'{{WRAPPER}} .organization__social-title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'social_media_icon_size',
			[
				'label' => __( 'Icon Size', 'crowdfundly' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'separator' => 'before',
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 80,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .organization__social-item-icon' => 'font-size: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'social_name_typography',
				'label' => __( 'Media Name Typography', 'crowdfundly' ),
				'selector' => '{{WRAPPER}} .organization__social-item-title',
				'scheme' => Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_control(
			'social_name_color',
			[
				'label' => __( 'Media Name Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#31375E',
				'selectors' => [
					'{{WRAPPER}} .organization__social-item-title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'social_link_typography',
				'label' => __( 'Media Link Typography', 'crowdfundly' ),
				'selector' => '{{WRAPPER}} .organization__social-item-subtitle',
				'scheme' => Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_control(
			'social_link_color',
			[
				'label' => __( 'Media Link Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#7D8091',
				'selectors' => [
					'{{WRAPPER}} .organization__social-item-subtitle' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'_organization_recent_campaign',
			[
				'label' => __( 'Recent Campaign', 'crowdfundly' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'hide_recent_camp',
			[
				'label' => __( 'Hide Section', 'crowdfundly' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => false,
				'return_value' => 'yes',
				'selectors' => [
					'{{WRAPPER}} .organization__campaigns' => 'display: none;',
				]
			]
		);

		$this->add_control(
			'_heading_recent_camp_heading',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Heading', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_control(
			'recent_camps_heading_text',
			[
				'label' => __( 'Heading Text', 'crowdfundly' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => __( 'Recent Campaign', 'crowdfundly' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'recent_camps_heading_text_typography',
				'label' => __( 'Typography', 'crowdfundly' ),
				'selector' => '{{WRAPPER}} .organization__campaigns-title',
				'scheme' => Typography::TYPOGRAPHY_2,
			]
		);

		$this->add_control(
			'recent_camps_heading_text_color',
			[
				'label' => __( 'Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#31375E',
				'selectors' => [
					'{{WRAPPER}} .organization__campaigns-title' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'_heading_recent_camp_card',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Campaign Card', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_control(
			'camp_card_columns',
			[
				'label' => __( 'Select Column', 'crowdfundly' ),
				'type' => Controls_Manager::SELECT,
				'default' => '3',
				'options' => [
					'12' => __( 'One Column', 'crowdfundly' ),
					'6' => __( 'Two Column', 'crowdfundly' ),
					'4' => __( 'Three Column', 'crowdfundly' ),
					'3' => __( 'Four Column', 'crowdfundly' )
				]
			]
		);

		$this->add_responsive_control(
			'card_align',
			[
				'label' => __( 'Content Alignment', 'happy-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'happy-elementor-addons' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'happy-elementor-addons' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'happy-elementor-addons' ),
						'icon' => 'eicon-text-align-right',
					]
				],
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .campaign-card' => 'text-align: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'recent_camp_card_border',
                'selector' => '{{WRAPPER}} .campaign-card',
            ]
        );

		$this->add_responsive_control(
            'recent_camp_card_padding',
            [
                'label' => __( 'Detail Section Padding', 'crowdfundly' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .campaign-card__details' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->add_responsive_control(
			'recent_campaigns_card_detail_height',
			[
				'label' => __( 'Detail Section Height', 'crowdfundly' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'selectors' => [
					'{{WRAPPER}} .campaign-card__details' => 'height: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_responsive_control(
            'recent_camp_card_border_radius',
            [
                'label' => __( 'Border Radius', 'crowdfundly' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .campaign-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'recent_camp_card_box_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .campaign-card'
			]
		);

		$this->add_control(
			'recent_camp_card_bg_color',
			[
				'label' => __( 'Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .campaign-card' => 'background-color: {{VALUE}};'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'recent_camp_card_hover_box_shadow',
				'label' => __( 'Hover Box Shadow', 'crowdfundly' ),
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .campaign-card:hover'
			]
		);

		$this->add_control(
			'recent_camp_card_hover_bg_color',
			[
				'label' => __( 'Hover Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .campaign-card:hover' => 'background-color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'_heading_recent_camp_card_image',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Campaign Image', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
            'recent_camp_image_border_radius',
            [
                'label' => __( 'Border Radius', 'crowdfundly' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .campaign-card__img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .campaign-card__bg' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .campaign-card__top' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

		$this->add_control(
			'_heading_recent_camp_card_image_bg_color',
			[
				'label' => __( 'Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#F5F7FD',
				'selectors' => [
					'{{WRAPPER}} .campaign-card__top' => 'background-color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'_heading_recent_camp_card_image_bg_color_hover',
			[
				'label' => __( 'Hover Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#F5F7FD',
				'selectors' => [
					'{{WRAPPER}} .campaign-card:hover .campaign-card__top' => 'background-color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'_heading_recent_camp_card_title',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Campaign Title', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'recent_camp_card_title_typography',
				'label' => __( 'Typography', 'crowdfundly' ),
				'selector' => '{{WRAPPER}} .campaign-card__title',
				'scheme' => Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_control(
			'recent_camp_card_title',
			[
				'label' => __( 'Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#333',
				'selectors' => [
					'{{WRAPPER}} .campaign-card__title' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'recent_camp_card_title_hover',
			[
				'label' => __( 'Hover Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#333',
				'selectors' => [
					'{{WRAPPER}} .campaign-card:hover .campaign-card__title' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'_heading_recent_camp_card_description',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Description', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_control(
			'all_camp_card_description_hide_section',
			[
				'label' => __( 'Hide Description', 'crowdfundly' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => false,
				'return_value' => 'yes',
				'selectors' => [
					'{{WRAPPER}} .campaign-card__description' => 'display: none;',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'recent_camp_card_description_typography',
				'label' => __( 'Typography', 'crowdfundly' ),
				'selector' => '{{WRAPPER}} .campaign-card__description',
				'scheme' => Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_control(
			'recent_camp_card_description_color',
			[
				'label' => __( 'Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#666',
				'selectors' => [
					'{{WRAPPER}} .campaign-card__description' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'recent_camp_card_description_color_hover',
			[
				'label' => __( 'Hover Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#666',
				'selectors' => [
					'{{WRAPPER}} .campaign-card:hover .campaign-card__description' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'_heading_recent_camp_card_progress_bar',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Progress Bar', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'recent_campaigns_progress_bar_bottom_spaceing',
			[
				'label' => __( 'Bottom Spacing', 'crowdfundly' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 80,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .progress.progress--slim' => 'margin-bottom: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_responsive_control(
			'recent_campaigns_progress_bar_height',
			[
				'label' => __( 'Height', 'crowdfundly' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'unit' => 'px',
					'size' => 4,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .campaign-card__footer .progress--slim' => 'height: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_control(
			'recent_camp_card_progress_bar_background_color',
			[
				'label' => __( 'Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .campaign-card__footer .progress.progress--slim' => 'background-color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'recent_camp_card_progress_bar_background_color_hover',
			[
				'label' => __( 'Hover Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .campaign-card:hover .campaign-card__footer .progress.progress--slim' => 'background-color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'recent_camp_card_progress_bar_color',
			[
				'label' => __( 'Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#14C479',
				'selectors' => [
					'{{WRAPPER}} .campaign-card__footer .progress__bar' => 'background-color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'_heading_recent_camp_card_target_amount',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Target Amount', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
            'recent_camp_card_footer_padding',
            [
                'label' => __( 'Padding', 'crowdfundly' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .campaign-card__footer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'recent_camp_card_target_amount_typography',
				'label' => __( 'Typography', 'crowdfundly' ),
				'selector' => '{{WRAPPER}} .campaign-card__amount',
				'scheme' => Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_control(
			'recent_camp_card_target_amount_color',
			[
				'label' => __( 'Target Amount Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#666',
				'selectors' => [
					'{{WRAPPER}} .campaign-card__amount' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'recent_camp_card_raised_amount_color',
			[
				'label' => __( 'Raised Amount Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#000',
				'selectors' => [
					'{{WRAPPER}} .campaign-card .campaign-card__amount strong' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'_heading_camp_button',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Button', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_control(
			'hide_all_camp_btn',
			[
				'label' => __( 'Hide Button', 'crowdfundly' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => false,
				'return_value' => 'yes',
				'selectors' => [
					'{{WRAPPER}} .org-all-campaign-btn-wrap' => 'display: none !important;',
				]
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label' => __( 'Padding', 'crowdfundly' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .organization__campaigns .btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'recent_camp_button_box_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .organization-all-camp-btn'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'selector' => '{{WRAPPER}} .organization-all-camp-btn',
				'scheme' => Typography::TYPOGRAPHY_4,
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'button_border',
				'selector' => '{{WRAPPER}} .organization-all-camp-btn',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label' => __( 'Border Radius', 'crowdfundly' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => '5',
					'right' => '5',
					'bottom' => '5',
					'left' => '5',
				],
				'selectors' => [
					'{{WRAPPER}} .organization-all-camp-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_control(
			'hr',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->start_controls_tabs( '_tabs_button' );

		$this->start_controls_tab(
			'_tab_button_normal',
			[
				'label' => __( 'Normal', 'crowdfundly' ),
			]
		);

		$this->add_control(
			'button_color',
			[
				'label' => __( 'Text Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .organization-all-camp-btn' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'button_bg_color',
			[
				'label' => __( 'Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#5777f3',
				'selectors' => [
					'{{WRAPPER}} .organization-all-camp-btn' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'_tab_button_hover',
			[
				'label' => __( 'Hover', 'crowdfundly' ),
			]
		);

		$this->add_control(
			'button_hover_color',
			[
				'label' => __( 'Text Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .organization-all-camp-btn:hover, {{WRAPPER}} .organization-all-camp-btn:focus' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'button_hover_bg_color',
			[
				'label' => __( 'Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#113eed',
				'selectors' => [
					'{{WRAPPER}} .organization-all-camp-btn:hover, {{WRAPPER}} .organization-all-camp-btn:focus' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label' => __( 'Border Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'button_border_border!' => '',
				],
				'default' => '#113eed',
				'selectors' => [
					'{{WRAPPER}} .organization-all-camp-btn:hover, {{WRAPPER}} .organization-all-camp-btn:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		add_filter( 'crowdfundly_org_camp', function( $data ) {
			return $this->share_settings();
		});
		\Crowdfundly_Public::load_css();
		\Crowdfundly_Public::load_js();
		echo do_shortcode( '[crowdfundly-organization]' );
	}

	protected function share_settings() {
		$settings = $this->get_settings_for_display();
		$org_settings = [];
		$org_settings['recent_camps_heading_text'] = $settings['recent_camps_heading_text'];
		$org_settings['camp_card_columns'] = $settings['camp_card_columns'];

		return $org_settings;
	}
}
