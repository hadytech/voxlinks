<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border as Group_Control_Border;
use Elementor\Group_Control_Box_Shadow as Group_Control_Box_Shadow;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class BetterDocs_Elementor_Doc_Share extends Widget_Base {

    public function get_name () {
        return 'betterdocs-doc-share';
    }

    public function get_title () {
        return __('Doc Share', 'betterdocs');
    }

    public function get_icon () {
        return 'betterdocs-icon-Social-Share';
    }

    public function get_categories () {
        return ['betterdocs-elements'];
    }

    public function get_keywords () {
        return ['betterdocs-elements', 'share', 'betterdocs', 'heading', 'docs'];
    }

    public function get_custom_help_url() {
        return 'https://betterdocs.co/docs/single-doc-in-elementor';
    }

    protected function _register_controls () {

        $this->share_controls();

        $this->start_controls_section(
            'section_column_settings',
            [
                'label' => __('Box Style', 'betterdocs'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'share_box_width',
            [
                'label'      => __('Width', 'betterdocs'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 2000,
                        'step' => 1
                    ],
                    '%' => [
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1
                    ],
                    'em' => [
                        'min'  => 100,
                        'max'  => 100,
                        'step' => 1
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 100
                ],
                'selectors'  => [
                    '{{WRAPPER}} .betterdocs-social-share' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'share_box_height',
            [
                'label'      => __('Height', 'betterdocs'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'max'  => 500,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .betterdocs-social-share' => 'height: {{SIZE}}px;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'share_box_background',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .betterdocs-social-share'
            ]
        );

        $this->add_responsive_control(
            'share_box_space', // Legacy control id but new control
            [
                'label'      => __('Box Spacing', 'betterdocs'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .betterdocs-social-share' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'share_box_padding',
            [
                'label'      => __('Box Padding', 'betterdocs'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .betterdocs-social-share' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'share_box_border_normal',
                'label'    => esc_html__('Border', 'betterdocs'),
                'selector' => '{{WRAPPER}} .betterdocs-social-share'
            ]
        );

        $this->add_responsive_control(
            'share_box_radius_normal',
            [
                'label'      => esc_html__('Border Radius', 'betterdocs'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .betterdocs-social-share' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'share_box_shadow_normal',
                'selector' => '{{WRAPPER}} .betterdocs-social-share'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_title_settings',
            [
                'label' => __('Title', 'betterdocs'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'share_box_title_color',
            [
                'label'     => esc_html__('Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .betterdocs-social-share-heading h5' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'share_box_title_typography',
                'selector' => '{{WRAPPER}} .betterdocs-social-share-heading h5'
            ]
        );

        $this->end_controls_section();

        $this->icon_style();
    }

    public function share_controls()
    {
        $this->start_controls_section(
            'section_options',
            [
                'label' => __('Controls', 'betterdocs')
            ]
        );

        $this->add_control(
			'share_title',
			[
				'label' => __( 'Title', 'betterdocs' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Share This Article :', 'betterdocs' ),
				'placeholder' => __( 'Type share title here', 'betterdocs' ),
			]
        );
        
        $this->add_control(
			'facebook',
			[
				'label' => __( 'Facebook', 'betterdocs' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'betterdocs' ),
				'label_off' => __( 'Hide', 'betterdocs' ),
				'return_value' => '1',
				'default' => '1',
			]
		);
        
        $this->add_control(
			'twitter',
			[
				'label' => __( 'Twitter', 'betterdocs' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'betterdocs' ),
				'label_off' => __( 'Hide', 'betterdocs' ),
				'return_value' => '1',
				'default' => '1',
			]
		);
        
        $this->add_control(
			'linkedin',
			[
				'label' => __( 'Linkedin', 'betterdocs' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'betterdocs' ),
				'label_off' => __( 'Hide', 'betterdocs' ),
				'return_value' => '1',
				'default' => '1',
			]
		);
        
        $this->add_control(
			'pinterest',
			[
				'label' => __( 'Pinterest', 'betterdocs' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'betterdocs' ),
				'label_off' => __( 'Hide', 'betterdocs' ),
				'return_value' => '1',
				'default' => '1',
			]
		);

        $this->end_controls_section();
    }

    public function icon_style(){
        $this->start_controls_section(
            'section_icon_settings',
            [
                'label' => __('Icon', 'betterdocs'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'share_icon_space', // Legacy control id but new control
            [
                'label'      => __('Spacing', 'betterdocs'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .betterdocs-social-share-links li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'share_icon_padding',
            [
                'label'      => __('Padding', 'betterdocs'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .betterdocs-social-share-links li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'share_share_icon_area',
            [
                'label'      => __('Size', 'betterdocs'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'max'  => 500,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .betterdocs-social-share-links li a img' => 'height: {{SIZE}}px;width: {{SIZE}}px;',
                ],
            ]
        );


        $this->end_controls_section();
    }

    protected function render () {
        $settings = $this->get_settings_for_display();
        echo '<div class="betterdocs-el-single-share">';
        echo do_shortcode(
            "[betterdocs_social_share
            title='{$settings['share_title']}'
            facebook_sharing='{$settings['facebook']}'
            twitter_sharing='{$settings['twitter']}'
            linkedin_sharing='{$settings['linkedin']}'
            pinterest_sharing='{$settings['pinterest']}']" 
        );
        echo '</div>';
    }
}
