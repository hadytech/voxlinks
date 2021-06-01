<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow; 
use Elementor\Group_Control_Typography; 
use Elementor\Core\Schemes\Typography;

class Crowdfundly_Single_Campaign_Widget extends Widget_Base {
	public function get_name() {
		return 'crowdfundly-single-campaign';
	}

	public function get_title() {
		return __( 'Crowdfundly Single Campaign', 'crowdfundly' );
	}

	public function get_icon() {
		return 'icon-Single-Camp';
	}

	public function get_keywords() {
		return [ 'crowdfundly', 'fund', 'donation', 'campaign', 'single campaign' ];
	}

	public function get_categories() {
		return [ 'crowdfundly_elementor_category' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'_single_campaign_common_settings',
			[
				'label' => __( 'Common Settings', 'crowdfundly' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_control(
			'single_camp_id',
			[
				'label' => __( 'Select Campaign', 'crowdfundly' ),
				'type' => Controls_Manager::SELECT,
				'options' => $this->get_camps(),
				// 'default' => isset( $this->get_camps() )
			]
		);

		$this->add_control(
			'camp_page_background_color',
			[
				'label' => __( 'Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#f3f4f8',
				'selectors' => [
					'{{WRAPPER}} .content-wrapper.template .content-body' => 'background-color: {{VALUE}}'
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'_single_campaign_detail',
			[
				'label' => __( 'Campaign Detail', 'crowdfundly' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'_heading_camp_gallery',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Gallery', 'crowdfundly' )
			]
		);

		$this->add_responsive_control(
            'camp_gallery_large_img_border_radius',
            [
                'label' => __( 'Large Image Border Radius', 'crowdfundly' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
					'{{WRAPPER}} .slide.slick-active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .slide__inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .slide__bg' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .slide__img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

		$this->add_control(
			'camp_gallery_large_img_background_color',
			[
				'label' => __( 'Large Image Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#F5F7FD',
				'selectors' => [
					'{{WRAPPER}} .slide__inner' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'camp_gallery_large_img_border_color',
			[
				'label' => __( 'Large Image Border Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .slide.slick-active' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
            'camp_gallery_thumbnail_border_radius',
            [
                'label' => __( 'Thumbnail Border Radius', 'crowdfundly' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .campaign__view .thumbnails .slide img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->add_control(
			'camp_gallery_thumbnail_background_color',
			[
				'label' => __( 'Thumbnail Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .campaign__view .thumbnails .slide img' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .campaign__view .thumbnails .slide iframe' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'camp_gallery_arrow_color',
			[
				'label' => __( 'Arrow Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .gallery-slider-nav .slick-prev:before' => 'color: {{VALUE}}',
					'{{WRAPPER}} .gallery-slider-nav .slick-next:before' => 'color: {{VALUE}}'
				],
			]
		);

		$this->add_control(
			'_heading_camp_title',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Campaign Title', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'camp_title_bottom_spacing',
			[
				'label' => __( 'Bottom Spacing', 'crowdfundly' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'selectors' => [
					'{{WRAPPER}} .campaign__title.campaign__title--status' => 'margin-bottom: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'cam_title_typography',
				'label' => __( 'Typography', 'crowdfundly' ),
				'selector' => '{{WRAPPER}} .campaign__title.campaign__title--status',
				'scheme' => Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_control(
			'cam_title_color',
			[
				'label' => __( 'Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#31375E',
				'selectors' => [
					'{{WRAPPER}} .campaign__title.campaign__title--status' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'_heading_camp_publish_status',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Campaign Status', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'cam_publish_status_bottom_spacing',
			[
				'label' => __( 'Bottom Spacing', 'crowdfundly' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'selectors' => [
					'{{WRAPPER}} .campaign__status' => 'margin-bottom: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_responsive_control(
			'cam_publish_status_font_size',
			[
				'label' => __( 'Font Size', 'crowdfundly' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'selectors' => [
					'{{WRAPPER}} .campaign__status span' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .campaign__status span i' => 'font-size: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_control(
			'cam_publish_status_color',
			[
				'label' => __( 'Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#3bc065',
				'selectors' => [
					'{{WRAPPER}} .campaign__status span' => 'color: {{VALUE}} !important',
					'{{WRAPPER}} .campaign__status span i' => 'color: {{VALUE}} !important',
				],
			]
		);

		$this->add_control(
			'_heading_camp_org_name',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Organization Name', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'cam_org_name_typography',
				'label' => __( 'Typography', 'crowdfundly' ),
				'selector' => '{{WRAPPER}} .campaign__fundraiser-name-link',
				'scheme' => Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_control(
			'cam_publish_org_name_color',
			[
				'label' => __( 'Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#666',
				'selectors' => [
					'{{WRAPPER}} .campaign__fundraiser-name-link' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'cam_publish_org_name_hover_color',
			[
				'label' => __( 'Hover Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#666',
				'selectors' => [
					'{{WRAPPER}} .campaign__fundraiser-name-link:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'_heading_camp_funding_goal',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Funding Goal', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'camp_fund_goal_box_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .funding-goal'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'cam_fund_goal_typography',
				'label' => __( 'Typography', 'crowdfundly' ),
				'selector' => '{{WRAPPER}} .funding-goal .funding-card__value, {{WRAPPER}} .funding-goal .funding-card__lavel',
				'scheme' => Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_control(
			'cam_fund_goal_background_color',
			[
				'label' => __( 'Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .funding-goal' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'cam_fund_goal_box_value_color',
			[
				'label' => __( 'Value Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#31375E',
				'selectors' => [
					'{{WRAPPER}} .funding-goal .funding-card__value' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'cam_fund_goal_label_color',
			[
				'label' => __( 'Label Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#666',
				'selectors' => [
					'{{WRAPPER}} .funding-goal .funding-card__lavel' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'_heading_camp_fund_raised',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Fund Raised', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'camp_fund_raised_box_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .fund-raised'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'cam_fund_raised_typography',
				'label' => __( 'Typography', 'crowdfundly' ),
				'selector' => '{{WRAPPER}} .fund-raised .funding-card__value, {{WRAPPER}} .fund-raised .funding-card__lavel',
				'scheme' => Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_control(
			'cam_fund_raised_background_color',
			[
				'label' => __( 'Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .fund-raised' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'cam_fund_raided_value_color',
			[
				'label' => __( 'Value Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#31375E',
				'selectors' => [
					'{{WRAPPER}} .fund-raised .funding-card__value' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'cam_fund_raised_label_color',
			[
				'label' => __( 'Label Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#666',
				'selectors' => [
					'{{WRAPPER}} .fund-raised .funding-card__lavel' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'_heading_camp_funding_days',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Funding Goal', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'camp_fund_days_box_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .funding-duration'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'cam_fund_days_typography',
				'label' => __( 'Typography', 'crowdfundly' ),
				'selector' => '{{WRAPPER}} .funding-duration .funding-card__value, {{WRAPPER}} .funding-duration .funding-card__lavel',
				'scheme' => Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_control(
			'cam_fund_days_background_color',
			[
				'label' => __( 'Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .funding-duration' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'cam_fund_days_value_color',
			[
				'label' => __( 'Value Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#31375E',
				'selectors' => [
					'{{WRAPPER}} .funding-duration .funding-card__value' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'cam_fund_days_label_color',
			[
				'label' => __( 'Label Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#666',
				'selectors' => [
					'{{WRAPPER}} .funding-duration .funding-card__lavel' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'_heading_camp_progress_bar',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Progress Bar', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'camp_progress_bar_height',
			[
				'label' => __( 'Height', 'crowdfundly' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 25,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .campaign__progress .progress.progress--sm' => 'height: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_control(
			'camp_progress_bar_background_color',
			[
				'label' => __( 'Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .campaign__progress .progress.progress--sm' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'camp_progress_bar_color',
			[
				'label' => __( 'Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#14C479',
				'selectors' => [
					'{{WRAPPER}} .campaign__progress .progress__bar--secondary' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'_heading_camp_donation_button',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Donation Button', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'camp_donation_button_padding',
			[
				'label' => __( 'Padding', 'crowdfundly' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .campaign__actions-btn' => 'padding: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'camp_contribute_butn_box_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .campaign__actions-btn'
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'camp_donation_button_border',
				'selector' => '{{WRAPPER}} .campaign__actions-btn',
			]
		);

		$this->add_control(
			'camp_donation_button_border_radius',
			[
				'label' => __( 'Border Radius', 'crowdfundly' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .campaign__actions-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'camp_donation_button_typography',
				'selector' => '{{WRAPPER}} .campaign__actions-btn',
				'scheme' => Typography::TYPOGRAPHY_4,
			]
		);

		$this->add_control(
			'camp_donation_hr',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->start_controls_tabs( '_camp_donation_tabs_button' );
		$this->start_controls_tab(
			'_camp_donation_tab_button_normal',
			[
				'label' => __( 'Normal', 'crowdfundly' ),
			]
		);

		$this->add_control(
			'camp_donation_button_color',
			[
				'label' => __( 'Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .campaign__actions-btn' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'camp_donation_button_bg_color',
			[
				'label' => __( 'Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#5777f3',
				'selectors' => [
					'{{WRAPPER}} .campaign__actions-btn' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'_camp_donation_tab_button_hover',
			[
				'label' => __( 'Hover', 'crowdfundly' ),
			]
		);

		$this->add_control(
			'camp_donation_button_hover_color',
			[
				'label' => __( 'Text Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .campaign__actions-btn:hover, {{WRAPPER}} .campaign__actions-btn:focus' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'camp_donation_button_hover_bg_color',
			[
				'label' => __( 'Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#0069d9',
				'selectors' => [
					'{{WRAPPER}} .campaign__actions-btn:hover, {{WRAPPER}} .campaign__actions-btn:focus' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'camp_donation_button_hover_border_color',
			[
				'label' => __( 'Border Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'camp_donation_button_border_border!' => '',
				],
				'default' => '#0069d9',
				'selectors' => [
					'{{WRAPPER}} .campaign__actions-btn:hover, {{WRAPPER}} .campaign__actions-btn:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'_single_campaign_tabs',
			[
				'label' => __( 'Tabs Common Settings', 'crowdfundly' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'_heading_camp_tabs_common_settings',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Common Settings', 'crowdfundly' )
			]
		);

		$this->add_control(
			'camp_tabs_tab_text_color',
			[
				'label' => __( 'Tab Text Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#666',
				'selectors' => [
					'{{WRAPPER}} #campaignTab .g-tab__nav-item .nav-link' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'camp_tabs_tab__count_text_color',
			[
				'label' => __( 'Tab Count Text Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#5777f3',
				'selectors' => [
					'{{WRAPPER}} #campaignTab .g-tab__nav-item .nav-link span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'camp_tabs_tab_color',
			[
				'label' => __( 'Active Tab Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#333',
				'selectors' => [
					'{{WRAPPER}} #campaignTab .g-tab__nav-item .nav-link.active' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'camp_tabs_ative_tab_bg_color',
			[
				'label' => __( 'Active Tab Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'transparent',
				'selectors' => [
					'{{WRAPPER}} #campaignTab .g-tab__nav-item:not(.active) .nav-link.active' => 'background-color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'camp_tabs_ative_tab_border_bottom_color',
			[
				'label' => __( 'Active Tab Border Bottom Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#5777f3',
				'selectors' => [
					'{{WRAPPER}} #campaignTab .g-tab__nav-item .nav-link.active' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} #campaignTab .g-tab__nav-item .nav-link:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'camp_tabs_content_color',
			[
				'label' => __( 'Tab Content Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tab-content .tab-pane' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'tabs_bg_color',
			[
				'label' => __( 'Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#f3f4f8',
				'selectors' => [
					'{{WRAPPER}} .tab-content.g-tab__body' => 'background-color: {{VALUE}};'
				],
			]
		);	
		
		$this->add_control(
			'tabs__border_bg_color',
			[
				'label' => __( 'Tab Border Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .campaign__view-tab .g-tab' => 'background-color: {{VALUE}};'
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'campaign_story_tab',
			[
				'label' => __( 'Campaign Story Tab', 'crowdfundly' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'campaign_story_tab_heading',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Heading', 'crowdfundly' )
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'campaign_story_tab_heading_color_typography',
				'label' => __( 'Typography', 'crowdfundly' ),
				'selector' => '{{WRAPPER}} #story .story-heading',
				'scheme' => Typography::TYPOGRAPHY_2,
			]
		);

		$this->add_control(
			'campaign_story_tab_heading_color',
			[
				'label' => __( 'Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #story .story-heading' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'campaign_story_tab_paragraph',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Paragraph', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'campaign_story_tab_paragraph_color_typography',
				'label' => __( 'Typography', 'crowdfundly' ),
				'selector' => '{{WRAPPER}} #story .story-paragraph',
				'scheme' => Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_control(
			'campaign_story_tab_paragraph_color',
			[
				'label' => __( 'Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #story .story-paragraph' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'campaign_story_tab_image',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Image', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'campaign_story_tab_image_width',
			[
				'label' => __( 'Width', 'crowdfundly' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 1500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} #story .story-image img' => 'width: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_responsive_control(
			'campaign_story_tab_image_height',
			[
				'label' => __( 'Height', 'crowdfundly' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 1500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} #story .story-image img' => 'height: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'update_tab',
			[
				'label' => __( 'Update Tab', 'crowdfundly' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'update_tab_line_color',
			[
				'label' => __( 'Line Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #public .campaign-update:first-child::before' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} #public .campaign-update:first-child::after' => 'background-color: {{VALUE}};'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'update_tab_date_typography',
				'label' => __( 'Description', 'crowdfundly' ),
				'selector' => '{{WRAPPER}} #public .campaign-update__date',
				'scheme' => Typography::TYPOGRAPHY_4,
			]
		);

		$this->add_control(
			'update_tab_date_color',
			[
				'label' => __( 'Date Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #public .campaign-update__date' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'update_tab_description_typography',
				'label' => __( 'Description', 'crowdfundly' ),
				'selector' => '{{WRAPPER}} .campaign-view-updates__single-text-line p > span',
				'scheme' => Typography::TYPOGRAPHY_4,
			]
		);

		$this->add_control(
			'update_tab_description_color',
			[
				'label' => __( 'Description Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .campaign-view-updates__single-text-line p > span' => 'color: {{VALUE}} !important;'
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'activites_tab',
			[
				'label' => __( 'Activites Tab', 'crowdfundly' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'activites_tab_card_bg_color',
			[
				'label' => __( 'Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .activities .activity' => 'background-color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'activites_tab_card_color',
			[
				'label' => __( 'Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .activities .activity' => 'color: {{VALUE}};',
					'{{WRAPPER}} .activity__name' => 'color: {{VALUE}};',
					'{{WRAPPER}} .activity__date' => 'color: {{VALUE}};',
					'{{WRAPPER}} .activity__label' => 'color: {{VALUE}};',
					'{{WRAPPER}} .activity__value' => 'color: {{VALUE}};',
					'{{WRAPPER}} .activity__message' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'_heading_activites_tab_avatar',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Avatar', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_control(
			'activites_tab_avatar_border_radius',
			[
				'label' => __( 'Avatar Border Radius', 'crowdfundly' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .activity__avatar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'activites_tab_avatar_box_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .activity__avatar'
			]
		);

		$this->add_control(
			'_heading_activites_tab_button',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Button', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'activites_tab_button_padding',
			[
				'label' => __( 'Padding', 'crowdfundly' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} #crowdfundly-activites-load-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} #crowdfundly-activites-load-more'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'selector' => '{{WRAPPER}} #crowdfundly-activites-load-more',
				'scheme' => Typography::TYPOGRAPHY_4,
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'button_border',
				'selector' => '{{WRAPPER}} #crowdfundly-activites-load-more',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label' => __( 'Border Radius', 'crowdfundly' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} #crowdfundly-activites-load-more' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
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
					'{{WRAPPER}} #crowdfundly-activites-load-more' => 'color: {{VALUE}} !important;',
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
					'{{WRAPPER}} #crowdfundly-activites-load-more' => 'background-color: {{VALUE}} !important;',
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
					'{{WRAPPER}} #crowdfundly-activites-load-more:hover, {{WRAPPER}} #crowdfundly-activites-load-more:focus' => 'color: {{VALUE}} !important;',
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
					'{{WRAPPER}} #crowdfundly-activites-load-more:hover, {{WRAPPER}} #crowdfundly-activites-load-more:focus' => 'background-color: {{VALUE}} !important;',
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
					'{{WRAPPER}} #crowdfundly-activites-load-more:hover, {{WRAPPER}} #crowdfundly-activites-load-more:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'endorsement_tab',
			[
				'label' => __( 'Endorsement Tab', 'crowdfundly' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'endorsement_tab_card_bg_color',
			[
				'label' => __( 'Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .endorsement' => 'background-color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'endorsement_tab_card_color',
			[
				'label' => __( 'Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .endorsement__name' => 'color: {{VALUE}};',
					'{{WRAPPER}} .endorsement__label' => 'color: {{VALUE}};',
					'{{WRAPPER}} .endorsement__message' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'_heading_endorsement_tab_avatar',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Avatar', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_control(
			'endorsement_tab_avatar_border_radius',
			[
				'label' => __( 'Avatar Border Radius', 'crowdfundly' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .endorsement__avatar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'endorsement_tab_avatar_box_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .endorsement__avatar'
			]
		);

		$this->add_control(
			'_heading_endorsement_tab_name',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Name', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'endorsment_name_typography',
				'label' => __( 'Typography', 'crowdfundly' ),
				'selector' => '{{WRAPPER}} .endorsement__name span:first-child',
				'scheme' => Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_control(
			'endorsement_tab_name_color',
			[
				'label' => __( 'Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .endorsement__name span:first-child' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'_heading_endorsement_tab_description',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Description', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'endorsment_description_typography',
				'label' => __( 'Typography', 'crowdfundly' ),
				'selector' => '{{WRAPPER}} .endorsement__message',
				'scheme' => Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_control(
			'endorsement_tab_description_color',
			[
				'label' => __( 'Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .endorsement__message' => 'color: {{VALUE}};'
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'top_contributors_tab',
			[
				'label' => __( 'Top Contributors Tab', 'crowdfundly' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'top_contributors_card_bg_color',
			[
				'label' => __( 'Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .donor-card' => 'background-color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'top_contributors_card_color',
			[
				'label' => __( 'Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .donor-card__name' => 'color: {{VALUE}};',
					'{{WRAPPER}} .donor-card__label' => 'color: {{VALUE}};',
					'{{WRAPPER}} .donor-card__value' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'_heading_top_contributors_tab_avatar',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Avatar', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_control(
			'top_contributors_avatar_border_radius',
			[
				'label' => __( 'Avatar Border Radius', 'crowdfundly' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .donor-card__avatar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'top_contributors_avatar_box_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .donor-card__avatar'
			]
		);

		$this->add_control(
			'_heading_top_contributors_name',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Name', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'top_contributors_name_typography',
				'label' => __( 'Typography', 'crowdfundly' ),
				'selector' => '{{WRAPPER}} .donor-card__name',
				'scheme' => Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_control(
			'top_contributors_name_color',
			[
				'label' => __( 'Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .donor-card__name' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'_heading_top_contributors_description',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Description', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'top_contributors_description_typography',
				'label' => __( 'Typography', 'crowdfundly' ),
				'selector' => '{{WRAPPER}} .donor-card__value',
				'scheme' => Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_control(
			'top_contributors_description_color',
			[
				'label' => __( 'Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .donor-card__value' => 'color: {{VALUE}};'
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'select_reward_tab',
			[
				'label' => __( 'Reward Tab', 'crowdfundly' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'select_reward_tab_button',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Tab Button', 'crowdfundly' )
			]
		);

		$this->add_responsive_control(
			'select_reward_tab_button_padding',
			[
				'label' => __( 'Padding', 'crowdfundly' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} #select-reward-tab .btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'select_reward_tab_button_box_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} #select-reward-tab .btn'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'select_reward_tab_button_typography',
				'selector' => '{{WRAPPER}} #select-reward-tab .btn',
				'scheme' => Typography::TYPOGRAPHY_4,
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'select_reward_tab_button_border',
				'selector' => '{{WRAPPER}} #select-reward-tab .btn',
			]
		);

		$this->add_control(
			'select_reward_tab_button_border_radius',
			[
				'label' => __( 'Border Radius', 'crowdfundly' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} #select-reward-tab .btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_control(
			'select_reward_tab_hr',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->start_controls_tabs( '_select_reward_tab_button' );

		$this->start_controls_tab(
			'_select_reward_tab_button_normal',
			[
				'label' => __( 'Normal', 'crowdfundly' ),
			]
		);

		$this->add_control(
			'select_reward_tab_button_color',
			[
				'label' => __( 'Text Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} #select-reward-tab .btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'select_reward_tab_button_bg_color',
			[
				'label' => __( 'Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #select-reward-tab .btn' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'select_reward_tab_button_hover',
			[
				'label' => __( 'Hover', 'crowdfundly' ),
			]
		);

		$this->add_control(
			'select_reward_tab_button_hover_color',
			[
				'label' => __( 'Text Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #select-reward-tab:hover, {{WRAPPER}} #select-reward-tab:focus' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'select_reward_tab_button_hover_bg_color',
			[
				'label' => __( 'Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #select-reward-tab .btn:hover, {{WRAPPER}} #select-reward-tab .btn:focus' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'select_reward_tab_button_hover_border_color',
			[
				'label' => __( 'Border Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'select_reward_tab_button_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} #select-reward-tab .btn:hover, {{WRAPPER}} #select-reward-tab .btn:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'select_reward_card',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Card', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_control(
			'select_reward_card_bg_color',
			[
				'label' => __( 'Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .offer-card' => 'background-color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'select_reward_card_offer_badge',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Badge', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_control(
			'select_reward_card_offer_badge_bg_color',
			[
				'label' => __( 'Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .offer-card__badge' => 'background-color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'select_reward_card_offer_badge_color',
			[
				'label' => __( 'Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .offer-card__badge' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'select_reward_card_title',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Product Name', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'select_reward_card_title_typography',
				'label' => __( 'Typography', 'crowdfundly' ),
				'selector' => '{{WRAPPER}} .offer-card__title',
				'scheme' => Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_control(
			'select_reward_card_title_color',
			[
				'label' => __( 'Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .offer-card__title' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'select_reward_card_stock_badge',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Stock Badge', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_control(
			'select_reward_card_stock_badge_bg_color',
			[
				'label' => __( 'Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .badge-warning' => 'background-color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'select_reward_card_stock_badge_color',
			[
				'label' => __( 'Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .badge-warning' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'select_reward_card_get_now_offered_price',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Offered Price', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'select_reward_card_get_now_offered_price_typography',
				'label' => __( 'Typography', 'crowdfundly' ),
				'selector' => '{{WRAPPER}} .offer-card__price-new',
				'scheme' => Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_control(
			'select_reward_card_get_now_offered_price_color',
			[
				'label' => __( 'Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .offer-card__price-new' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'select_reward_card_get_now',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Get Now Button', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'select_reward_card_get_now_button_padding',
			[
				'label' => __( 'Padding', 'crowdfundly' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .reward-get-product' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'select_reward_card_get_now_button_box_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .reward-get-product'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'select_reward_card_get_now_button_typography',
				'selector' => '{{WRAPPER}} .reward-get-product',
				'scheme' => Typography::TYPOGRAPHY_4,
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'select_reward_card_get_now_button_border',
				'selector' => '{{WRAPPER}} .reward-get-product',
			]
		);

		$this->add_control(
			'select_reward_card_get_now_button_border_radius',
			[
				'label' => __( 'Border Radius', 'crowdfundly' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .reward-get-product' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_control(
			'select_reward_card_get_now_hr',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->start_controls_tabs( '_select_reward_card_get_now_tabs_button' );

		$this->start_controls_tab(
			'_select_reward_card_get_now_tab_button_normal',
			[
				'label' => __( 'Normal', 'crowdfundly' ),
			]
		);

		$this->add_control(
			'select_reward_card_get_now_button_color',
			[
				'label' => __( 'Text Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .reward-get-product' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'select_reward_card_get_now_button_bg_color',
			[
				'label' => __( 'Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .reward-get-product' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'select_reward_card_get_now_tab_button_hover',
			[
				'label' => __( 'Hover', 'crowdfundly' ),
			]
		);

		$this->add_control(
			'select_reward_card_get_now_button_hover_color',
			[
				'label' => __( 'Text Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .reward-get-product:hover, {{WRAPPER}} .reward-get-product:focus' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'select_reward_card_get_now_button_hover_bg_color',
			[
				'label' => __( 'Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .reward-get-product:hover, {{WRAPPER}} .reward-get-product:focus' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'select_reward_card_get_now_button_hover_border_color',
			[
				'label' => __( 'Border Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'select_reward_card_get_now_button_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .reward-get-product:hover, {{WRAPPER}} .reward-get-product:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'_similar_camp_section',
			[
				'label' => __( 'Similar Campaign', 'crowdfundly' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'hide_similar_camps',
			[
				'label' => __( 'Hide Section', 'crowdfundly' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => false,
				'return_value' => 'yes',
				'selectors' => [
					'{{WRAPPER}} .campaign__view-related' => 'display: none;',
				]
			]
		);

		$this->add_control(
			'_heading_similar_camp_heading',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Heading', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_control(
			'similar_camps_heading_text',
			[
				'label' => __( 'Heading Text', 'crowdfundly' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => __( 'Similar Campaign', 'crowdfundly' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'similar_camp_heading_typography',
				'label' => __( 'Typography', 'crowdfundly' ),
				'selector' => '{{WRAPPER}} .campaign__view-related-title',
				'scheme' => Typography::TYPOGRAPHY_2,
			]
		);

		$this->add_control(
			'similar_camp_heading_color',
			[
				'label' => __( 'Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#31375E',
				'selectors' => [
					'{{WRAPPER}} .campaign__view-related-title' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'_heading_similar_camp_card',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Card', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_control(
			'similar_camp_card_columns',
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
                'name' => 'similar_camp_card_border',
                'selector' => '{{WRAPPER}} .campaign-card',
            ]
        );

		$this->add_responsive_control(
            'similar_camp_card_border_radius',
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
				'name' => 'similar_camp_card_box_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .campaign-card'
			]
		);

		$this->add_control(
			'similar_camp_card_bg_color',
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
				'name' => 'similar_camp_card_hover_box_shadow',
				'label' => __( 'Hover Box Shadow', 'crowdfundly' ),
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .campaign-card:hover'
			]
		);

		$this->add_control(
			'similar_camp_card_hover_bg_color',
			[
				'label' => __( 'Hover Background Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .campaign-card:hover' => 'background-color: {{VALUE}};'
				],
			]
		);

		$this->add_responsive_control(
            'similar_camp_card_padding',
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
			'similar_campaigns_card_detail_height',
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
			'_heading_similar_camp_card_image',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Campaign Image', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
            'similar_camp_image_border_radius',
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
			'_heading_similar_camp_card_image_bg_color',
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
			'_heading_similar_camp_card_image_bg_color_hover',
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
			'_heading_similar_camp_card_title',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Campaign Title', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'similar_camp_card_title_typography',
				'label' => __( 'Typography', 'crowdfundly' ),
				'selector' => '{{WRAPPER}} .campaign-card__title',
				'scheme' => Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_control(
			'similar_camp_card_title',
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
			'similar_camp_card_title_hover',
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
			'_heading_similar_camp_card_description',
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
				'name' => 'similar_camp_card_description_typography',
				'label' => __( 'Typography', 'crowdfundly' ),
				'selector' => '{{WRAPPER}} .campaign-card__description',
				'scheme' => Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_control(
			'similar_camp_card_description_color',
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
			'similar_camp_card_description_color_hover',
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
			'_heading_similar_camp_card_progress_bar',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Progress Bar', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'similar_campaigns_progress_bar_bottom_spaceing',
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
					'{{WRAPPER}} .campaign-card__footer .progress--slim' => 'margin-bottom: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_responsive_control(
			'similar_campaigns_progress_bar_height',
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
			'similar_camp_card_progress_bar_background_color',
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
			'similar_camp_card_progress_bar_background_color_hover',
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
			'similar_camp_card_progress_bar_color',
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
			'_heading_similar_camp_card_target_amount',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Target Amount', 'crowdfundly' ),
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
            'similar_camp_card_footer_padding',
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
				'name' => 'similar_camp_card_target_amount_typography',
				'label' => __( 'Typography', 'crowdfundly' ),
				'selector' => '{{WRAPPER}} .campaign-card__amount',
				'scheme' => Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_control(
			'similar_camp_card_target_amount_color',
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
			'similar_camp_card_raised_amount_color',
			[
				'label' => __( 'Raised Amount Color', 'crowdfundly' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#666',
				'selectors' => [
					'{{WRAPPER}} .campaign-card .campaign-card__amount strong' => 'color: {{VALUE}};'
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		add_filter( 'crowdfundly_single_camp', function( $data ) {
			return $this->share_settings();
		});
		\Crowdfundly_Public::load_css();
		\Crowdfundly_Public::load_js();
		echo do_shortcode( '[crowdfundly-campaign]' );
	}

	public function get_camps() {
		$campaign = \Crowdfundly_Shortcode::get_all_campaigns();	
		
		$camp_list = [];
		if (!$campaign) {
            return $camp_list;
        }

		foreach ( $campaign->data as $camp ) {
			$camp_list[$camp->slug] = $camp->name;
		}
		return $camp_list;
	}

	protected function share_settings() {
		$settings = $this->get_settings_for_display();
		$single_camp_settings = [];
		$single_camp_settings['camp_id'] = $settings['single_camp_id'];
		$single_camp_settings['similar_camps_heading_text'] = $settings['similar_camps_heading_text'];
		$single_camp_settings['similar_camp_card_columns'] = $settings['similar_camp_card_columns'];

		return $single_camp_settings;
	}
}
