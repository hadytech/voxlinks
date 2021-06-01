<?php
// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}

use \Elementor\Controls_Manager as Controls_Manager;
use \Elementor\Group_Control_Border as Group_Control_Border;
use \Elementor\Group_Control_Typography as Group_Control_Typography;
use \Elementor\Group_Control_Background;
use \Elementor\Widget_Base as Widget_Base;

class BetterDocs_Elementor_Search_Form extends Widget_Base
{

    public function get_name()
    {
        return 'betterdocs-search-form';
    }

    public function get_title()
    {
        return __('Doc Search Form', 'betterdocs');
    }

    public function get_categories()
    {
        return ['betterdocs-elements', 'docs-archive'];
    }

    public function get_icon()
    {
        return 'betterdocs-icon-search';
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @return array Widget keywords.
     * @since  3.5.2
     * @access public
     *
     */
    public function get_keywords()
    {
        return [
            'knowledgebase',
            'knowledge Base',
            'documentation',
            'doc',
            'kb',
            'betterdocs',
            'search',
            'search form',

        ];
    }

    public function get_custom_help_url()
    {
        return 'https://betterdocs.co/docs/single-doc-in-elementor';
    }


    protected function _register_controls()
    {

        /**
         * ----------------------------------------------------------
         * Section: Search Box
         * ----------------------------------------------------------
         */
        $this->start_controls_section(
            'section_search_box_settings',
            [
                'label' => __('Search Box', 'betterdocs'),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'search_box_bg',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .betterdocs-live-search'
            ]
        );

        $this->add_responsive_control(
            'search_box_padding',
            [
                'label'      => esc_html__('Padding', 'betterdocs'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default'    => [
                    'top'    => 50,
                    'right'  => 50,
                    'bottom' => 50,
                    'left'   => 50
                ],
                'selectors'  => [
                    '{{WRAPPER}} .betterdocs-live-search' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->end_controls_section(); # end of 'Search Box'

        /**
         * ----------------------------------------------------------
         * Section: Search Field
         * ----------------------------------------------------------
         */
        $this->start_controls_section(
            'section_search_field_settings',
            [
                'label' => __('Search Field', 'betterdocs'),
            ]
        );

        $this->add_control(
            'search_field_bg',
            [
                'label'     => esc_html__('Field Background Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .betterdocs-searchform' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'search_field_text_color',
            [
                'label'     => esc_html__('Text Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .betterdocs-searchform .betterdocs-search-field' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'search_field_text_typography',
                'selector' => '{{WRAPPER}} .betterdocs-searchform .betterdocs-search-field'
            ]
        );

        $this->add_responsive_control(
            'search_field_padding',
            [
                'label'      => __('Field Padding', 'betterdocs'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .betterdocs-searchform .betterdocs-search-field' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'search_field_padding_radius',
            [
                'label'      => esc_html__('Border Radius', 'betterdocs'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .betterdocs-searchform' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->add_control(
            'field_search_icon_heading',
            [
                'label'     => esc_html__('Search Icon', 'betterdocs'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'field_search_icon_color',
            [
                'label'     => esc_html__('Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .betterdocs-searchform svg.docs-search-icon' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'field_search_icon_size',
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
                    '{{WRAPPER}} .betterdocs-searchform svg.docs-search-icon' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
                ],
            ]
        );

        $this->add_control(
            'field_close_icon_heading',
            [
                'label'     => esc_html__('Close Icon', 'betterdocs'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'search_field_close_icon_color',
            [
                'label'     => esc_html__('Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .docs-search-close .close-line' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'search_field_close_icon_border_color',
            [
                'label'     => esc_html__('Border Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .docs-search-loader, {{WRAPPER}} .docs-search-close .close-border' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section(); # end of 'Search Field'


        /**
         * ----------------------------------------------------------
         * Section: Search Result Box
         * ----------------------------------------------------------
         */
        $this->start_controls_section(
            'section_search_result_settings',
            [
                'label' => __('Search Result Box', 'betterdocs'),
            ]
        );

        $this->add_responsive_control(
            'result_box_width',
            [
                'label'      => __('Width', 'betterdocs'),
                'type'       => Controls_Manager::SLIDER,
                'default'    => [
                    'size' => 100,
                    'unit' => '%',
                ],
                'size_units' => ['%', 'px', 'em'],
                'range'      => [
                    '%' => [
                        'max'  => 100,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .betterdocs-live-search .docs-search-result' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'result_box_max_width',
            [
                'label'      => __('Max Width', 'betterdocs'),
                'type'       => Controls_Manager::SLIDER,
                'default'    => [
                    'size' => 1600,
                    'unit' => 'px',
                ],
                'size_units' => ['px', 'em'],
                'range'      => [
                    'px' => [
                        'max'  => 1600,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .betterdocs-live-search .docs-search-result' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'result_box_bg',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .betterdocs-live-search .docs-search-result'
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'result_box_border',
                'label'    => esc_html__('Border', 'betterdocs'),
                'selector' => '{{WRAPPER}} .betterdocs-live-search .docs-search-result',
            ]
        );

        $this->end_controls_section(); # end of 'Search Result Box'

        /**
         * ----------------------------------------------------------
         * Section: Search Result Item
         * ----------------------------------------------------------
         */
        $this->start_controls_section(
            'section_search_result_item_settings',
            [
                'label' => __('Search Result List', 'betterdocs'),
            ]
        );

        $this->start_controls_tabs('item_settings_tab');

        // Normal State Tab
        $this->start_controls_tab(
            'item_normal',
            ['label' => esc_html__('Normal', 'betterdocs')]
        );

        $this->add_control(
            'result_box_item',
            [
                'label' => esc_html__('Item', 'betterdocs'),
                'type'  => Controls_Manager::HEADING
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'result_box_item_typography',
                'selector' => '{{WRAPPER}} .betterdocs-live-search .docs-search-result li a'
            ]
        );

        $this->add_control(
            'result_box_item_color',
            [
                'label'     => esc_html__('Item Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .betterdocs-live-search .docs-search-result li a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'result_item_border',
                'label'    => esc_html__('Border', 'betterdocs'),
                'selector' => '{{WRAPPER}} .betterdocs-live-search .docs-search-result li'
            ]
        );

        $this->add_responsive_control(
            'result_box_item_padding',
            [
                'label'      => __('Padding', 'betterdocs'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .betterdocs-live-search .docs-search-result li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'search_result_box_item_category',
            [
                'label'     => esc_html__('Category', 'betterdocs'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'result_box_item_category_typography',
                'selector' => '{{WRAPPER}} .betterdocs-live-search .docs-search-result li span'
            ]
        );

        $this->add_control(
            'result_box_item_category_color',
            [
                'label'     => esc_html__('Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .betterdocs-live-search .docs-search-result li span' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // Hover State Tab
        $this->start_controls_tab(
            'item_hover',
            ['label' => esc_html__('Hover', 'betterdocs')]
        );

        $this->add_responsive_control(
            'result_item_transition',
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
                    '{{WRAPPER}} .betterdocs-live-search .docs-search-result li, {{WRAPPER}} .betterdocs-live-search .docs-search-result li a, {{WRAPPER}} .betterdocs-live-search .docs-search-result li span, {{WRAPPER}} .betterdocs-live-search .docs-search-result' => 'transition: {{SIZE}}ms;',
                ],
            ]
        );

        $this->add_control(
            'result_box_item_hover_heading',
            [
                'label' => esc_html__('Item', 'betterdocs'),
                'type'  => Controls_Manager::HEADING
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'result_box_item_hover_bg',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .betterdocs-live-search .docs-search-result li:hover',
                'exclude'  => [
                    'image'
                ]
            ]
        );

        $this->add_control(
            'result_box_item_hover_color',
            [
                'label'     => esc_html__('Item Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .betterdocs-live-search .docs-search-result li:hover a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'result_item_hover_border',
                'label'    => esc_html__('Border', 'betterdocs'),
                'selector' => '{{WRAPPER}} .betterdocs-live-search .docs-search-result li:hover'
            ]
        );

        $this->add_control(
            'result_box_item_hover_count_heading',
            [
                'label'     => esc_html__('Count', 'betterdocs'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'result_box_item_hover_count_color',
            [
                'label'     => esc_html__('Item Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .betterdocs-live-search .docs-search-result li:hover span' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section(); # end of 'Search Result Item'


    }

    protected function render()
    {

        $settings = $this->get_settings_for_display();
        $shortcode = sprintf('[betterdocs_search_form]', apply_filters('eael_betterdocs_search_form_params', []));
        echo do_shortcode(shortcode_unautop($shortcode));
    }

    public function render_plain_content()
    {
        // In plain mode, render without shortcode
        echo '[betterdocs_search_form]';
    }
}
