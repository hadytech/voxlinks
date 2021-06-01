<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border; 
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;

class Crowdfundly_All_Campaign_Widget extends Widget_Base {
	public function get_name() {
		return 'crowdfundly-all-campaign';
	}

	public function get_title() {
		return __( 'Crowdfundly All Campaign', 'crowdfundly' ); 
	}

	public function get_icon() {
		return 'icon-Camp';
	}

	public function get_keywords() {
		return [ 'crowdfundly', 'fund', 'donation', 'campaign' ];
	}

	public function get_categories() {
		return [ 'crowdfundly_elementor_category' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'_all_campaigns_common',
			[
				'label' => __( 'Crowdfundly', 'crowdfundly' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
            'common_background_color',
            [
                'label' => __( 'Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '#f3f4f8',
                'selectors' => [
                    '{{WRAPPER}} .content-wrapper.template .content-body' => 'background-color: {{VALUE}}',
                ],
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'_all_campaigns_header',
			[
				'label' => __( 'Search Bar', 'crowdfundly' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'hide_search_bar',
			[
				'label' => __( 'Hide Section', 'crowdfundly' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => false,
				'return_value' => 'yes',
				'selectors' => [
					'{{WRAPPER}} .all-campaign__header' => 'display: none;',
				]
			]
		);

		$this->add_control(
            'search_bar_background_color',
            [
                'label' => __( 'Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '#fff',
                'selectors' => [
                    '{{WRAPPER}} .all-campaign__filter' => 'background-color: {{VALUE}}',
                ],
            ]
        );

		$this->add_control(
			'_heading_search_heading',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Heading', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_control(
			'search_bar_heading_text',
			[
				'label' => __( 'Heading Text', 'crowdfundly' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => __( 'Campaigns', 'crowdfundly' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'search_heading_typography',
                'label' => __( 'Typography', 'crowdfundly' ),
                'selector' => '{{WRAPPER}} .all-campaign__title',
                'scheme' => Typography::TYPOGRAPHY_2
            ]
        );

        $this->add_control(
            'search_heading_color',
            [
                'label' => __( 'Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '#31375E',
                'selectors' => [
                    '{{WRAPPER}} .all-campaign__title' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->add_control(
			'_heading_search_icon',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Search Icon', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'search_icon_font_size',
			[
				'label' => __( 'Font Size', 'crowdfundly' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'selectors' => [
					'{{WRAPPER}} .all-campaign__filter-search-icon' => 'font-size: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_control(
            'search_icon_color',
            [
                'label' => __( 'Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '#666',
                'selectors' => [
                    '{{WRAPPER}} .all-campaign__filter-search-icon' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->add_control(
			'_heading_search_input',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Search Input', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
            'field_padding',
            [
                'label' => __( 'Padding', 'crowdfundly' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .all-campaign__filter-search-input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'field_border_radius',
            [
                'label' => __( 'Border Radius', 'crowdfundly' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .all-campaign__filter-search-input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'field_typography',
                'label' => __( 'Typography', 'crowdfundly' ),
                'selector' => '{{WRAPPER}} .all-campaign__filter-search-input',
                'scheme' => Typography::TYPOGRAPHY_3
            ]
        );

        $this->add_control(
            'field_color',
            [
                'label' => __( 'Text Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '#43454b',
                'selectors' => [
                    '{{WRAPPER}} .all-campaign__filter-search-input' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'field_placeholder_color',
            [
                'label' => __( 'Placeholder Text Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '#43454b',
                'selectors' => [
                    '{{WRAPPER}} ::-webkit-input-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} ::-moz-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} ::-ms-input-placeholder' => 'color: {{VALUE}};',
                ],
            ]
		);

		$this->start_controls_tabs( 'tabs_field_state' );

        $this->start_controls_tab(
            'tab_field_normal',
            [
                'label' => __( 'Normal', 'crowdfundly' ),
            ]
		);

		$this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'field_border',
                'selector' => '{{WRAPPER}} .all-campaign__filter-search-input',
            ]
        );

		$this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'field_box_shadow',
                'selector' => '{{WRAPPER}} .all-campaign__filter-search-input',
            ]
        );

        $this->add_control(
            'field_bg_color',
            [
				'label' => __( 'Background Color', 'crowdfundly' ),				
				'type' => Controls_Manager::COLOR,
				'default'=> '#f2f2f2',
                'selectors' => [
                    '{{WRAPPER}} .all-campaign__filter-search-input' => 'background-color: {{VALUE}}',
                ],
            ]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
            'tab_field_focus',
            [
                'label' => __( 'Focus', 'crowdfundly' ),
            ]
		);

		$this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'field_focus_border',
                'selector' => '{{WRAPPER}} .all-campaign__filter-search-input:focus',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'field_focus_box_shadow',
                'exclude' => [
                    'box_shadow_position',
                ],
                'selector' => '{{WRAPPER}} .all-campaign__filter-search-input:focus',
            ]
		);

		$this->add_control(
            'field_focus_bg_color',
            [
                'label' => __( 'Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '#f2f2f2',
                'selectors' => [
                    '{{WRAPPER}} .all-campaign__filter-search-input:focus' => 'background-color: {{VALUE}}',
                ],
            ]
        );

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'_heading_search_button',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Button', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label' => __( 'Padding', 'crowdfundly' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .all-campaign__filter-search-btn-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'selector' => '{{WRAPPER}} .all-campaign__filter-search-btn-submit',
				'scheme' => Typography::TYPOGRAPHY_4,
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'button_border',
				'selector' => '{{WRAPPER}} .all-campaign__filter-search-btn-submit',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label' => __( 'Border Radius', 'crowdfundly' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .all-campaign__filter-search-btn-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_control(
			'hr-two',
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
				'default'=> '#fff',
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .all-campaign__filter-search-btn-submit' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'button_bg_color',
			[
				'label' => __( 'Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '#5777f3',				
				'selectors' => [
					'{{WRAPPER}} .all-campaign__filter-search-btn-submit' => 'background-color: {{VALUE}} !important;',
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
				'label' => __( 'Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '#fff',
				'selectors' => [
					'{{WRAPPER}} .all-campaign__filter-search-btn-submit:hover, {{WRAPPER}} .all-campaign__filter-search-btn-submit:focus' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'button_hover_bg_color',
			[
				'label' => __( 'Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,				
				'default'=> '#113eed',
				'selectors' => [
					'{{WRAPPER}} .all-campaign__filter-search-btn-submit:hover, {{WRAPPER}} .all-campaign__filter-search-btn-submit:focus' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label' => __( 'Border Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '#113eed',
				'condition' => [
					'button_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .all-campaign__filter-search-btn-submit:hover, {{WRAPPER}} .all-campaign__filter-search-btn-submit:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'_heading_search_sort_by',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'SortBy Dropdown', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'search_sort_by_typography',
				'selector' => '{{WRAPPER}} .all-campaign__filter-select option',
				'scheme' => Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_control(
			'search_sort_by_bg_color',
			[
				'label' => __( 'Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '#fff',
				'selectors' => [
					'{{WRAPPER}} .all-campaign__filter-select option' => 'bacground-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'search_sort_by_color',
			[
				'label' => __( 'Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '#666',	
				'selectors' => [
					'{{WRAPPER}} .all-campaign__filter-select' => 'color: {{VALUE}};',
					'{{WRAPPER}} .all-campaign__filter-select option' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'_all_campaigns_grid',
			[
				'label' => __( 'Campaigns', 'crowdfundly' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'all_camp_per_page',
			[
				'label' => __( 'Per Page', 'crowdfundly' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 200,
				'step' => 1,
				'default' => 15,
			]
		);

		$this->add_control(
			'_heading_all_camp_card',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Card', 'crowdfundly' ),
				'separator' => 'before'
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
                'name' => 'all_camp_card_border',
                'selector' => '{{WRAPPER}} .campaign-card',
            ]
        );

		$this->add_responsive_control(
            'all_camp_card_border_radius',
            [
                'label' => __( 'Border Radius', 'crowdfundly' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .campaign-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->add_control(
			'all_camp_card_columns',
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
			'all_campaigns_space_between_camps',
			[
				'label' => __( 'Space Between Campaigns', 'crowdfundly' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 80,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .all-campaign__inner .col-12.col-sm-6.col-md-4.col-lg-2' => 'padding-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .all-campaign__inner .col-12.col-sm-6.col-md-4.col-lg-2' => 'padding-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .all-campaign__inner .col-12.col-sm-6.col-md-4.col-lg-3' => 'padding-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .all-campaign__inner .col-12.col-sm-6.col-md-4.col-lg-3' => 'padding-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .all-campaign__inner .col-12.col-sm-6.col-md-4.col-lg-4' => 'padding-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .all-campaign__inner .col-12.col-sm-6.col-md-4.col-lg-4' => 'padding-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'all_campaigns_card_box_shadow',
				'selector' => '{{WRAPPER}} .campaign-card'
			]
		);

		$this->add_control(
			'all_campaigns_card_bg_color',
			[
				'label' => __( 'Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '#fff',
				'selectors' => [
					'{{WRAPPER}} .campaign-card' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'all_campaigns_card_bg_color_hover',
			[
				'label' => __( 'Hover Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '#fff',
				'selectors' => [
					'{{WRAPPER}} .campaign-card:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'all_campaigns_card_box_shadow_hover',
				'label' => __( 'Hover Box Shadow', 'crowdfundly' ),
				'selector' => '{{WRAPPER}} .campaign-card:hover'
			]
		);

		$this->add_responsive_control(
            'all_camp_card_detail_padding',
            [
                'label' => __( 'Detail Section Padding', 'crowdfundly' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .campaign-card__details' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

		$this->add_responsive_control(
			'all_campaigns_card_detail_height',
			[
				'label' => __( 'Detail Section Height', 'crowdfundly' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'selectors' => [
					'{{WRAPPER}} .campaign-card__details' => 'height: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_control(
			'_heading_all_camp_card_image',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Image', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
            'all_camp_card__image_border_radius',
            [
                'label' => __( 'Border Radius', 'crowdfundly' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
					'{{WRAPPER}} .campaign-card__top' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .campaign-card__bg' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .campaign-card__img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

		$this->add_responsive_control(
			'all_campaigns_image_width',
			[
				'label' => __( 'Width', 'crowdfundly' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'unit' => '%',
					'size' => 92,
				],
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 400,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .campaign-card__img' => 'width: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_control(
			'_heading_all_camp_card_name',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Name', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'all_campaigns_name_typography',
				'label' => __( 'Typography', 'crowdfundly' ),
				'selector' => '{{WRAPPER}} .campaign-card__title',
				'scheme' => Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_control(
			'all_campaigns_name_color',
			[
				'label' => __( 'Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '#333',
				'selectors' => [
					'{{WRAPPER}} .campaign-card__title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'all_campaigns_name_color_hover',
			[
				'label' => __( 'Hover Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '#333',
				'selectors' => [
					'{{WRAPPER}} .campaign-card:hover .campaign-card__title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'_heading_all_camp_card_description',
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
				'name' => 'all_campaigns_description_typography',
				'label' => __( 'Typography', 'crowdfundly' ),
				'selector' => '{{WRAPPER}} .campaign-card__description',
				'scheme' => Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_control(
			'all_campaigns_description_color',
			[
				'label' => __( 'Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '#666',
				'selectors' => [
					'{{WRAPPER}} .campaign-card__description' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'all_campaigns_description_color_hover',
			[
				'label' => __( 'Hover Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '#666',
				'selectors' => [
					'{{WRAPPER}} .campaign-card:hover .campaign-card__description' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'_heading_all_camp_card_progress_bar',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Progress Bar', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'all_campaigns_progress_bar_bottom_spaceing',
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
			'all_campaigns_progress_bar_height',
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
					'{{WRAPPER}} .progress.progress--slim' => 'height: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_control(
			'all_campaigns_progress_bar_bg_color',
			[
				'label' => __( 'Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '#fff',
				'selectors' => [
					'{{WRAPPER}} .progress.progress--slim' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'all_campaigns_progress_bar_bg_color_hover',
			[
				'label' => __( 'Hover Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '#fff',
				'selectors' => [
					'{{WRAPPER}} .campaign-card:hover .progress.progress--slim' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'all_campaigns_progress_bar_color',
			[
				'label' => __( 'Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '#fff',
				'selectors' => [
					'{{WRAPPER}} .progress__bar' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'_heading_all_camp_card_target_amount',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Target amount', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
            'all_camp_target_amount_footer_padding',
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
				'name' => 'all_campaigns_target_amount_typography',
				'label' => __( 'Typography', 'crowdfundly' ),
				'selector' => '{{WRAPPER}} .campaign-card__amount',
				'scheme' => Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_control(
			'all_campaigns_target_amount_color',
			[
				'label' => __( 'Targe Amount Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '#666',
				'selectors' => [
					'{{WRAPPER}} .campaign-card__amount' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'all_campaigns_raised_amount_color',
			[
				'label' => __( 'Raised Amount Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '#666',
				'selectors' => [
					'{{WRAPPER}} .campaign-card__amount strong' => 'color: {{VALUE}}'
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'_all_campaigns_load_more',
			[
				'label' => __( 'Load More', 'crowdfundly' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'load_more_button_hide',
			[
				'label' => __( 'Hide Button', 'crowdfundly' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => false,
				'return_value' => 'yes',
				'selectors' => [
					'{{WRAPPER}} #crowdfundly-all-camp-loadmore' => 'display: none;',
				]
			]
		);

		$this->add_responsive_control(
			'load_more_button_padding',
			[
				'label' => __( 'Padding', 'crowdfundly' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} #crowdfundly-all-camp-loadmore' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'load_more_button_typography',
				'selector' => '{{WRAPPER}} #crowdfundly-all-camp-loadmore',
				'scheme' => Typography::TYPOGRAPHY_4,
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'load_more_button_border',
				'selector' => '{{WRAPPER}} #crowdfundly-all-camp-loadmore',
			]
		);

		$this->add_control(
			'load_more_button_border_radius',
			[
				'label' => __( 'Border Radius', 'crowdfundly' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} #crowdfundly-all-camp-loadmore' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_control(
			'load_more_hr-two',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->start_controls_tabs( '_tabs_load_more_button' );

		$this->start_controls_tab(
			'_tab_load_more_button_normal',
			[
				'label' => __( 'Normal', 'crowdfundly' ),
			]
		);

		$this->add_control(
			'load_more_button_color',
			[
				'label' => __( 'Text Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '#fff',
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} #crowdfundly-all-camp-loadmore' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'load_more_button_bg_color',
			[
				'label' => __( 'Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '#5777f3',				
				'selectors' => [
					'{{WRAPPER}} #crowdfundly-all-camp-loadmore' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'_tab_load_more_button_hover',
			[
				'label' => __( 'Hover', 'crowdfundly' ),
			]
		);

		$this->add_control(
			'load_more_button_hover_color',
			[
				'label' => __( 'Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '#fff',
				'selectors' => [
					'{{WRAPPER}} #crowdfundly-all-camp-loadmore:hover, {{WRAPPER}} #crowdfundly-all-camp-loadmore:focus' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'load_more_button_hover_bg_color',
			[
				'label' => __( 'Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,				
				'default'=> '#113eed',
				'selectors' => [
					'{{WRAPPER}} #crowdfundly-all-camp-loadmore:hover, {{WRAPPER}} #crowdfundly-all-camp-loadmore:focus' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'load_more_button_hover_border_color',
			[
				'label' => __( 'Border Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default'=> '#113eed',
				'condition' => [
					'load_more_button_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} #crowdfundly-all-camp-loadmore:hover, {{WRAPPER}} #crowdfundly-all-camp-loadmore:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	protected function render() {
		add_filter( 'crowdfundly_all_camps', function( $data ) {
			return $this->share_settings();
		});
		\Crowdfundly_Public::load_css();
		\Crowdfundly_Public::load_js();
		echo do_shortcode( '[crowdfundly-all-campaigns]' );
	}

	protected function share_settings() {
		$settings = $this->get_settings_for_display();
		$all_camp_settings = [];
		$all_camp_settings['all_camp_card_columns'] = $settings['all_camp_card_columns'];
		$all_camp_settings['search_bar_heading_text'] = $settings['search_bar_heading_text'];
		$all_camp_settings['all_camp_per_page'] = $settings['all_camp_per_page'];

		return $all_camp_settings;
	}
}
