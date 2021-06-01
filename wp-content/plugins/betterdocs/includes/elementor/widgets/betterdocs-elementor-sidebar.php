<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border as Group_Control_Border;
use Elementor\Group_Control_Box_Shadow as Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class BetterDocs_Elementor_Sidebar extends Widget_Base
{

    public function get_name()
    {
        return 'betterdocs-sidebar';
    }

    public function get_title()
    {
        return __('Doc Sidebar', 'betterdocs');
    }

    public function get_icon()
    {
        return 'betterdocs-icon-Sidebar';
    }

    public function get_categories()
    {
        return ['betterdocs-elements', 'docs-archive'];
    }

    public function get_keywords()
    {
        return ['betterdocs-elements', 'sidebar', 'betterdocs', 'docs'];
    }

    public function get_custom_help_url()
    {
        return 'https://betterdocs.co/docs/single-doc-in-elementor';
    }

    protected function _register_controls()
    {
        do_action('betterdocs_elementor_sidebar_layout_select', $this);

        $this->sidebar_layout_select();

        if (!is_plugin_active('betterdocs-pro/betterdocs-pro.php')) {
            $this->start_controls_section(
                'betterdocs_section_pro',
                [
                    'label' => __('Go Premium for More Features', 'betterdocs'),
                ]
            );

            $this->add_control(
                'betterdocs_control_get_pro',
                [
                    'label'       => __('Unlock more possibilities', 'betterdocs'),
                    'type'        => Controls_Manager::CHOOSE,
                    'options'     => [
                        '1' => [
                            'title' => '',
                            'icon' => 'fa fa-unlock-alt',
                        ],
                    ],
                    'default'     => '1',
                    'description' => '<span class="pro-feature"> Get the  <a href="https://betterdocs.co/upgrade" target="_blank">Pro version</a> for more stunning layouts and customization options.</span>',
                ]
            );

            $this->end_controls_section();
        }

        $this->box_setting_style();

        $this->icon_style();

        $this->title_style();

        $this->count_style();

        $this->list_setting();

        $this->sub_list_setting();

        $this->sticky_toc();
    }

    public function sidebar_layout_select()
    {
        /**
         * ----------------------------------------------------------
         * Section: Select Layout
         * ----------------------------------------------------------
         */
        $this->start_controls_section(
            'section_layout_settings',
            [
                'label' => __('Layout', 'betterdocs')
            ]
        );

        $this->add_control(
            'betterdocs_sidebar_layout',
            [
                'label'       => esc_html__('Select layout', 'betterdocs'),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'layout-1',
                'label_block' => false,
                'options'     => [
                    'layout-1'    => esc_html__('Layout 1', 'betterdocs'),
                    'layout-2'    => esc_html__('Layout 2', 'betterdocs'),
                    'layout-3'    => esc_html__('Layout 3', 'betterdocs'),
                ],
            ]
        );

        if (!is_plugin_active('betterdocs-pro/betterdocs-pro.php')) {
            $this->add_control(
                'betterdocs_sidebar_layout_warning_text',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => __('This layout is available in pro version only!', 'betterdocs'),
                    'content_classes' => 'betterdocs-ea-warning',
                    'condition' => [
                        'betterdocs_sidebar_layout' => ['layout-2', 'layout-3'],
                    ],
                ]
            );
        }

        $this->add_control(
            'category_title_tag',
            [
                'label' => __('Category Title Tag', 'betterdocs'),
                'type' => Controls_Manager::SELECT,
                'default' => 'h2',
                'options' => [
                    'h1' => __('H1', 'betterdocs'),
                    'h2' => __('H2', 'betterdocs'),
                    'h3' => __('H3', 'betterdocs'),
                    'h4' => __('H4', 'betterdocs'),
                    'h5' => __('H5', 'betterdocs'),
                    'h6' => __('H6', 'betterdocs'),
                ]
            ]
        );

        $this->end_controls_section(); # end of 'Select Layout'

    }

    public function sticky_toc()
    {
        /**
         * ----------------------------------------------------------
         * Section: Box Styles
         * ----------------------------------------------------------
         */
        $this->start_controls_section(
            'section_sticky_toc',
            [
                'label' => __('Sticky TOC', 'betterdocs'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'enable_sticky_toc',
            [
                'label' => __('Enable Sticky TOC', 'betterdocs'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'betterdocs'),
                'label_off' => __('Hide', 'betterdocs'),
                'return_value' => '1',
                'default' => '',
            ]
        );

        $this->add_responsive_control(
            'toc_width',
            [
                'label'      => __('TOC Width', 'betterdocs'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range'      => [
                    'px' => [
                        'max'  => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'max'  => 100,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .sticky-toc-container .betterdocs-toc' => 'width: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'toc_zindex', // Legacy control id but new control
            [
                'label'      => __('Z index', 'betterdocs'),
                'type'       => Controls_Manager::NUMBER,
                'min'        => 0,
                'max'        => 1000,
                'step'       => 5,
                'default'    => 320,
                'selectors'  => [
                    '{{WRAPPER}} .sticky-toc-container .betterdocs-toc' => 'z-index: {{VALUE}}%;',
                ]
            ]
        );

        $this->end_controls_section(); # end of 'Card Settings'
    }

    public function box_setting_style()
    {
        /**
         * ----------------------------------------------------------
         * Section: Box Styles
         * ----------------------------------------------------------
         */
        $this->start_controls_section(
            'section_card_settings',
            [
                'label' => __('Box', 'betterdocs'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'column_space', // Legacy control id but new control
            [
                'label'      => __('Box Spacing', 'betterdocs'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .betterdocs-categories-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'column_padding',
            [
                'label'      => __('Box Padding', 'betterdocs'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .betterdocs-categories-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'box_seperator_color',
            [
                'label'     => esc_html__('Separator Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .betterdocs-categories-wrap' => 'background-color: {{VALUE}};'
                ],
            ]
        );

        $this->start_controls_tabs('card_settings_tabs');

        // Normal State Tab
        $this->start_controls_tab(
            'card_normal',
            ['label' => esc_html__('Normal', 'betterdocs')]
        );

        $this->add_control(
            'box_section_header',
            [
                'label'     => __('Header', 'betterdocs'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'card_bg_normal_header',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .betterdocs-categories-wrap .docs-single-cat-wrap .docs-cat-title-wrap, .docs-single-cat-wrap-2 .docs-cat-title-inner'
            ]
        );

        $this->add_control(
            'box_section_body',
            [
                'label'     => __('Body', 'betterdocs'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'card_bg_normal',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .betterdocs-categories-wrap .docs-single-cat-wrap .docs-item-container, .docs-single-cat-wrap-2 .docs-item-container'
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'card_border_normal',
                'label'    => esc_html__('Border', 'betterdocs'),
                'selector' => '{{WRAPPER}} .betterdocs-categories-wrap .docs-single-cat-wrap'
            ]
        );

        $this->add_responsive_control(
            'card_border_radius_normal',
            [
                'label'      => esc_html__('Border Radius', 'betterdocs'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .betterdocs-categories-wrap .docs-single-cat-wrap .docs-item-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'card_box_shadow_normal',
                'selector' => '{{WRAPPER}} .betterdocs-categories-wrap .docs-single-cat-wrap'
            ]
        );

        $this->end_controls_tab();

        // Hover State Tab
        $this->start_controls_tab(
            'card_hover',
            ['label' => esc_html__('Hover', 'betterdocs')]
        );

        $this->add_control(
            'card_transition',
            [
                'label'      => __('Transition', 'betterdocs'),
                'type'       => Controls_Manager::SLIDER,
                'default'    => [
                    'size' => 300,
                    'unit' => '%',
                ],
                'size_units' => ['%'],
                'range'      => [
                    '%' => [
                        'max'  => 2500,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .betterdocs-categories-wrap .docs-single-cat-wrap' => 'transition: {{SIZE}}ms;',
                ],
            ]
        );

        $this->add_control(
            'box_section_header_hover',
            [
                'label'     => __('Header', 'betterdocs'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'card_bg_hover_header',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .betterdocs-categories-wrap .docs-single-cat-wrap:hover .docs-cat-title-wrap, .docs-single-cat-wrap-2:hover .docs-cat-title-inner'
            ]
        );

        $this->add_control(
            'box_section_body_hover',
            [
                'label'     => __('Body', 'betterdocs'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'card_bg_hover',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .betterdocs-categories-wrap .docs-single-cat-wrap:hover .docs-item-container'
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'card_border_hover',
                'label'    => esc_html__('Border', 'betterdocs'),
                'selector' => '{{WRAPPER}} .betterdocs-categories-wrap .docs-single-cat-wrap:hover'
            ]
        );

        $this->add_responsive_control(
            'card_border_radius_hover',
            [
                'label'      => esc_html__('Border Radius', 'betterdocs'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .betterdocs-categories-wrap .docs-single-cat-wrap:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'card_box_shadow_hover',
                'selector' => '{{WRAPPER}} .betterdocs-categories-wrap .docs-single-cat-wrap:hover'
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section(); # end of 'Card Settings'
    }

    public function icon_style()
    {
        /**
         * ----------------------------------------------------------
         * Section: Icon Styles
         * ----------------------------------------------------------
         */
        $this->start_controls_section(
            'section_box_icon_style',
            [
                'label' => __('Icon', 'betterdocs'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'category_settings_icon_size_normal',
            [
                'label'      => esc_html__('Size', 'betterdocs'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range'      => [
                    'px' => [
                        'max' => 500,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .betterdocs-categories-wrap .docs-single-cat-wrap .docs-cat-icon' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
                ],
            ]
        );

        $this->start_controls_tabs('box_icon_styles_tab');

        // Normal State Tab
        $this->start_controls_tab(
            'icon_normal',
            ['label' => esc_html__('Normal', 'betterdocs')]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'icon_background_normal',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .betterdocs-categories-wrap .docs-single-cat-wrap .docs-cat-icon',
                'exclude'  => [
                    'image'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'icon_border_normal',
                'label'    => esc_html__('Border', 'betterdocs'),
                'selector' => '{{WRAPPER}} .betterdocs-categories-wrap .docs-single-cat-wrap .docs-cat-icon'
            ]
        );

        $this->add_responsive_control(
            'icon_border_radius_normal',
            [
                'label'      => esc_html__('Border Radius', 'betterdocs'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .betterdocs-categories-wrap .docs-single-cat-wrap .docs-cat-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_padding',
            [
                'label'      => esc_html__('Padding', 'betterdocs'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .betterdocs-categories-wrap .docs-single-cat-wrap .docs-cat-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_spacing',
            [
                'label'              => esc_html__('Spacing', 'betterdocs'),
                'type'               => Controls_Manager::DIMENSIONS,
                'size_units'         => ['px', 'em', '%'],
                'allowed_dimensions' => [
                    'top',
                    'bottom'
                ],
                'selectors'          => [
                    '{{WRAPPER}} .betterdocs-categories-wrap .docs-single-cat-wrap .docs-cat-icon' => 'margin: {{TOP}}{{UNIT}} auto {{BOTTOM}}{{UNIT}} auto;'
                ]
            ]
        );

        $this->end_controls_tab();

        // Hover State Tab
        $this->start_controls_tab(
            'icon_hover',
            ['label' => esc_html__('Hover', 'betterdocs')]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'icon_background_hover',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .betterdocs-categories-wrap .docs-single-cat-wrap .docs-cat-icon:hover'
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'icon_border_hover',
                'label'    => esc_html__('Border', 'betterdocs'),
                'selector' => '{{WRAPPER}} .betterdocs-categories-wrap .docs-single-cat-wrap .docs-cat-icon:hover'
            ]
        );

        $this->add_responsive_control(
            'icon_border_radius_hover',
            [
                'label'      => esc_html__('Border Radius', 'betterdocs'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .betterdocs-categories-wrap .docs-single-cat-wrap .docs-cat-icon:hover:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],

            ]
        );

        $this->add_control(
            'category_settings_icon_size_transition',
            [
                'label'      => __('Transition', 'betterdocs'),
                'type'       => Controls_Manager::SLIDER,
                'default'    => [
                    'size' => 300,
                    'unit' => '%',
                ],
                'size_units' => ['%'],
                'range'      => [
                    '%' => [
                        'max'  => 2500,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .betterdocs-categories-wrap .docs-single-cat-wrap .docs-cat-icon:hover' => 'transition: {{SIZE}}ms;'
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section(); # end of 'Icon Styles'
    }


    public function title_style()
    {
        /**
         * ----------------------------------------------------------
         * Section: Title Styles
         * ----------------------------------------------------------
         */
        $this->start_controls_section(
            'section_box_title_styles',
            [
                'label' => __('Title', 'betterdocs'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('box_title_styles_tab');

        // Normal State Tab
        $this->start_controls_tab(
            'title_normal',
            ['label' => esc_html__('Normal', 'betterdocs')]
        );

        $this->add_control(
            'cat_title_color_normal',
            [
                'label'     => esc_html__('Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .betterdocs-categories-wrap .docs-single-cat-wrap .docs-cat-title .docs-cat-heading, .docs-single-cat-wrap-2 .docs-cat-title-inner .docs-cat-heading' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'cat_title_typography_normal',
                'selector' => '{{WRAPPER}} .betterdocs-categories-wrap .docs-single-cat-wrap .docs-cat-title .docs-cat-heading, .docs-single-cat-wrap-2 .docs-cat-title-inner .docs-cat-heading'
            ]
        );

        $this->add_responsive_control(
            'title_spacing',
            [
                'label'      => __('Spacing', 'betterdocs'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .betterdocs-categories-wrap .docs-single-cat-wrap .docs-cat-title .docs-cat-heading, .docs-single-cat-wrap-2 .docs-cat-title-inner .docs-cat-heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_tab();

        // Hover State Tab
        $this->start_controls_tab(
            'title_hover',
            ['label' => esc_html__('Hover', 'betterdocs')]
        );

        $this->add_control(
            'cat_title_color_hover',
            [
                'label'     => esc_html__('Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .betterdocs-categories-wrap .docs-single-cat-wrap:hover .docs-cat-title .docs-cat-heading, .docs-single-cat-wrap-2 .docs-cat-title-inner .docs-cat-heading' => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->add_control(
            'category_title_transition',
            [
                'label'      => __('Transition', 'betterdocs'),
                'type'       => Controls_Manager::SLIDER,
                'default'    => [
                    'size' => 300,
                    'unit' => '%',
                ],
                'size_units' => ['%'],
                'range'      => [
                    '%' => [
                        'max'  => 2500,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .betterdocs-categories-wrap .docs-single-cat-wrap .docs-cat-title .docs-cat-heading, .docs-single-cat-wrap-2 .docs-cat-title-inner .docs-cat-heading' => 'transition: {{SIZE}}ms;',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section(); # end of 'Icon Styles'
    }

    public function count_style()
    {
        /**
         * ----------------------------------------------------------
         * Section: Count Styles
         * ----------------------------------------------------------
         */
        $this->start_controls_section(
            'section_box_count_styles',
            [
                'label' => __('Count', 'betterdocs'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'count_typography_normal',
                'selector' => '{{WRAPPER}} .docs-single-cat-wrap .docs-cat-title-wrap .docs-item-count span'
            ]
        );

        $this->start_controls_tabs('box_count_styles_tab');

        // Normal State Tab
        $this->start_controls_tab(
            'count_normal',
            ['label' => esc_html__('Normal', 'betterdocs')]
        );

        $this->add_control(
            'count_color_normal',
            [
                'label'     => esc_html__('Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .docs-single-cat-wrap .docs-cat-title-wrap .docs-item-count span' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'count_box_bg',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .docs-single-cat-wrap .docs-cat-title-wrap .docs-item-count',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'count_box_border',
                'label'    => esc_html__('Border', 'betterdocs'),
                'selector' => '{{WRAPPER}} .docs-single-cat-wrap .docs-cat-title-wrap .docs-item-count',
            ]
        );

        $this->add_responsive_control(
            'count_box_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'betterdocs'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .docs-single-cat-wrap .docs-cat-title-wrap .docs-item-count' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'count_box_box_shadow',
                'selector' => '{{WRAPPER}} .docs-single-cat-wrap .docs-cat-title-wrap .docs-item-count',
            ]
        );

        $this->add_responsive_control(
            'count_box_size',
            [
                'label'      => esc_html__('Size', 'betterdocs'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range'      => [
                    'px' => [
                        'max' => 500,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .docs-single-cat-wrap .docs-cat-title-wrap .docs-item-count' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'count_spacing',
            [
                'label'      => __('Spacing', 'betterdocs'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .docs-single-cat-wrap .docs-cat-title-wrap .docs-item-count' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_tab();

        // Hover State Tab
        $this->start_controls_tab(
            'count_hover',
            ['label' => esc_html__('Hover', 'betterdocs')]
        );

        $this->add_control(
            'count_color_hover',
            [
                'label'     => esc_html__('Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .docs-single-cat-wrap .docs-cat-title-wrap .docs-item-count:hover span' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'count_box_bg_hover',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .docs-single-cat-wrap .docs-cat-title-wrap .docs-item-count:hover',

            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'count_box_border_hover',
                'label'    => esc_html__('Border', 'betterdocs'),
                'selector' => '{{WRAPPER}} .docs-single-cat-wrap .docs-cat-title-wrap .docs-item-count:hover',

            ]
        );

        $this->add_responsive_control(
            'count_box_border_radius_hover',
            [
                'label'      => esc_html__('Border Radius', 'betterdocs'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .docs-single-cat-wrap .docs-cat-title-wrap .docs-item-count:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],

            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'count_box_box_shadow_hover',
                'selector' => '{{WRAPPER}} .docs-single-cat-wrap .docs-cat-title-wrap .docs-item-count:hover',
            ]
        );

        $this->add_control(
            'category_count_transition',
            [
                'label'      => __('Transition', 'betterdocs'),
                'type'       => Controls_Manager::SLIDER,
                'default'    => [
                    'size' => 300,
                    'unit' => '%',
                ],
                'size_units' => ['%'],
                'range'      => [
                    '%' => [
                        'max'  => 2500,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .docs-single-cat-wrap .docs-cat-title-wrap .docs-item-count:hover' => 'transition: {{SIZE}}ms;',

                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section(); # end of 'Count Styles'
    }

    public function list_setting()
    {
        /**
         * ----------------------------------------------------------
         * Section: List Settinggs
         * ----------------------------------------------------------
         */
        $this->start_controls_section(
            'section_article_settings',
            [
                'label' => __('Category List', 'betterdocs'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'list_item_typography',
                'selector' => '{{WRAPPER}} .docs-item-container ul li a',
            ]
        );

        $this->add_control(
            'list_color',
            [
                'label'     => esc_html__('Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .docs-item-container ul li a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'list_hover_color',
            [
                'label'     => esc_html__('Hover Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .docs-item-container ul li a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'list_margin',
            [
                'label'      => esc_html__('List Item Spacing', 'betterdocs'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .docs-item-container ul li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->add_responsive_control(
            'list_area_padding',
            [
                'label'              => esc_html__('List Area Padding', 'betterdocs'),
                'type'               => Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => 'vertical',
                'size_units'         => ['px', 'em', '%'],
                'selectors'          => [
                    '{{WRAPPER}} .docs-item-container' => 'padding-top: {{TOP}}{{UNIT}}; padding-bottom: {{BOTTOM}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_settings_heading',
            [
                'label'     => esc_html__('Icon', 'betterdocs'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );


        $this->add_control(
            'list_icon_color',
            [
                'label'     => esc_html__('Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .docs-item-container li svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'list_icon_size',
            [
                'label'      => __('Size', 'betterdocs'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range'      => [
                    '%' => [
                        'max'  => 100,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .docs-item-container li svg' => 'font-size: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'list_icon_spacing',
            [
                'label'      => esc_html__('Spacing', 'betterdocs'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .docs-item-container li svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section(); # end of 'Column Settings'

    }

    /**
     * ----------------------------------------------------------
     * Section: Sub List Settinggs
     * ----------------------------------------------------------
     */
    public function sub_list_setting()
    {

        $this->start_controls_section(
            'section_sub_list_settings',
            [
                'label' => __('Sub-Category List', 'betterdocs'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'sub_list_item_typography',
                'selector' => '{{WRAPPER}} .docs-item-container .docs-sub-cat-title a',
            ]
        );

        $this->add_control(
            'sub_list_color',
            [
                'label'     => esc_html__('Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .docs-item-container .docs-sub-cat-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'sub_list_hover_color',
            [
                'label'     => esc_html__('Hover Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .docs-item-container .docs-sub-cat-title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'sub_list_margin',
            [
                'label'      => esc_html__('List Item Spacing', 'betterdocs'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .docs-item-container .docs-sub-cat-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->add_responsive_control(
            'sub_list_area_padding',
            [
                'label'              => esc_html__('List Area Padding', 'betterdocs'),
                'type'               => Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => 'vertical',
                'size_units'         => ['px', 'em', '%'],
                'selectors'          => [
                    '{{WRAPPER}} .docs-item-container .docs-sub-cat-title' => 'padding-top: {{TOP}}{{UNIT}}; padding-bottom: {{BOTTOM}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'sub_list_icon_settings_heading',
            [
                'label'     => esc_html__('Icon', 'betterdocs'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'sub_list_icon_size',
            [
                'label'      => __('Size', 'betterdocs'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range'      => [
                    '%' => [
                        'max'  => 100,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .docs-item-container .docs-sub-cat-title svg' => 'font-size: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->add_control(
            'sub_list_icon_color',
            [
                'label'     => esc_html__('Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .docs-item-container .docs-sub-cat .sub-list svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'sub_list_icon_spacing',
            [
                'label'      => esc_html__('Spacing', 'betterdocs'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .docs-item-container .docs-sub-cat-title svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section(); # end of 'Column Settings'
    }

    public function button_setting()
    {
        /**
         * ----------------------------------------------------------
         * Section: Button Settings
         * ----------------------------------------------------------
         */
        $this->start_controls_section(
            'section_button_settings',
            [
                'label' => __('Button', 'betterdocs'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->start_controls_tabs(
            'button_settings_tabs'
        );

        // Normal State Tab
        $this->start_controls_tab(
            'button_normal',
            ['label' => esc_html__('Normal', 'betterdocs')]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'button_typography_normal',
                'selector' => '{{WRAPPER}} .docs-cat-link-btn',
            ]
        );

        $this->add_control(
            'button_color_normal',
            [
                'label'     => esc_html__('Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .docs-cat-link-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'button_background_normal',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .docs-cat-link-btn',
                'exclude'  => [
                    'image',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'button_border_normal',
                'label'    => esc_html__('Border', 'betterdocs'),
                'selector' => '{{WRAPPER}} .docs-cat-link-btn',
            ]
        );

        $this->add_responsive_control(
            'button_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'betterdocs'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .docs-cat-link-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label'      => esc_html__('Padding', 'betterdocs'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .docs-cat-link-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_area_margin',
            [
                'label'      => esc_html__('Area Spacing', 'betterdocs'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .docs-cat-link-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // Normal State Tab
        $this->start_controls_tab(
            'button_hover',
            ['label' => esc_html__('Hover', 'betterdocs')]
        );

        $this->add_control(
            'button_color_hover',
            [
                'label'     => esc_html__('Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .docs-cat-link-btn:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'button_background_hover',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .docs-cat-link-btn:hover',
                'exclude'  => [
                    'image',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'button_border_hover',
                'label'    => esc_html__('Border', 'betterdocs'),
                'selector' => '{{WRAPPER}} .docs-cat-link-btn:hover',
            ]
        );

        $this->add_responsive_control(
            'button_hover_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'betterdocs'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .docs-cat-link-btn:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'button_text_alignment',
            [
                'label'     => __('Text Alignment', 'betterdocs'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => __('Left', 'betterdocs'),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'betterdocs'),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right'  => [
                        'title' => __('Right', 'betterdocs'),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .docs-cat-link-btn' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_alignment',
            [
                'label'     => __('Button Alignment', 'betterdocs'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => __('Left', 'betterdocs'),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'betterdocs'),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right'  => [
                        'title' => __('Right', 'betterdocs'),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .docs-item-container .docs-cat-link-btn' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section(); # end of 'Button Settings'
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $sticky_toc = ($settings['enable_sticky_toc'] == '1') ? $this->get_toc() : '';
        $shortcode = do_shortcode('[betterdocs_category_grid disable_customizer_style="true" sidebar_list="true" posts_per_grid="-1" title_tag="'.$settings['category_title_tag'].'"]');
        $sidebar = '<aside id="betterdocs-sidebar" class="betterdocs-el-single-sidebar"><div class="betterdocs-sidebar-content">' . $shortcode . '</div>' . $sticky_toc . '</aside>';
        echo apply_filters('betterdocs_elementor_sidebar', $sidebar, $settings);
    }

    public function get_toc()
    {
        ob_start();
        echo '<div class="sticky-toc-container">
            <a class="close-toc" href="#">
                <svg xmlns="http://www.w3.org/2000/svg" width="16px" viewBox="0 0 24 24">
                    <path style="line-height:normal;text-indent:0;text-align:start;text-decoration-line:none;text-decoration-style:solid;text-decoration-color:#000;text-transform:none;block-progression:tb;isolation:auto;mix-blend-mode:normal" d="M 4.9902344 3.9902344 A 1.0001 1.0001 0 0 0 4.2929688 5.7070312 L 10.585938 12 L 4.2929688 18.292969 A 1.0001 1.0001 0 1 0 5.7070312 19.707031 L 12 13.414062 L 18.292969 19.707031 A 1.0001 1.0001 0 1 0 19.707031 18.292969 L 13.414062 12 L 19.707031 5.7070312 A 1.0001 1.0001 0 0 0 18.980469 3.9902344 A 1.0001 1.0001 0 0 0 18.292969 4.2929688 L 12 10.585938 L 5.7070312 4.2929688 A 1.0001 1.0001 0 0 0 4.9902344 3.9902344 z" font-weight="400" font-family="sans-serif" white-space="normal" overflow="visible"></path>
                </svg>
            </a>
        </div>';
        return ob_get_clean();
    }
}
