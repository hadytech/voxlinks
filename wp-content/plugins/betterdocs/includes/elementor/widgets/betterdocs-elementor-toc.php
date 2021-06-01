<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Text_Shadow;
use ElementorPro\Plugin;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class BetterDocs_Elementor_Toc extends Widget_Base
{

    public function get_name()
    {
        return 'betterdocs-toc';
    }

    public function get_title()
    {
        return __('Doc Table of Contents', 'betterdocs');
    }

    public function get_icon()
    {
        return 'betterdocs-icon-Sidebar';
    }

    public function get_categories()
    {
        return ['betterdocs-elements'];
    }

    public function get_keywords()
    {
        return ['betterdocs-elements', 'toc', 'table-of-content', 'betterdocs', 'docs'];
    }

    public function get_custom_help_url()
    {
        return 'https://betterdocs.co/docs/single-doc-in-elementor';
    }

    protected function _register_controls()
    {
        $this->list_options();

        $this->box_setting_style();

        $this->title_settings();

        $this->list_settings();
    }

    public function list_options()
    {
        $this->start_controls_section(
            'section_options',
            [
                'label' => __('Controls', 'betterdocs')
            ]
        );

        $this->add_control(
            'htags',
            [
                'label' => __('Supported Heading Tags', 'betterdocs'),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => [
                    '1' => __('H1', 'betterdocs'),
                    '2' => __('H2', 'betterdocs'),
                    '3' => __('H3', 'betterdocs'),
                    '4' => __('H4', 'betterdocs'),
                    '5' => __('H5', 'betterdocs'),
                    '6' => __('H6', 'betterdocs'),
                ],
                'default' => ['1', '2', '3', '4', '5', '6'],
            ]
        );

        $this->add_control(
            'list_hierarchy',
            [
                'label' => __('List Hierarchy', 'betterdocs'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'betterdocs'),
                'label_off' => __('Hide', 'betterdocs'),
                'return_value' => '1',
                'default' => '1',
            ]
        );

        $this->add_control(
            'list_number',
            [
                'label' => __('List Number', 'betterdocs'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'betterdocs'),
                'label_off' => __('Hide', 'betterdocs'),
                'return_value' => '1',
                'default' => '1',
            ]
        );

        $this->add_control(
            'collapsible_toc_mobile',
            [
                'label' => __('Collapsible on small devices', 'betterdocs'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'betterdocs'),
                'label_off' => __('Hide', 'betterdocs'),
                'return_value' => '1',
                'default' => '',
            ]
        );

        $this->end_controls_section();
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
            'column_width', // Legacy control id but new control
            [
                'label'      => __('Box Width (%)', 'betterdocs'),
                'type'       => Controls_Manager::NUMBER,
                'min'        => 0,
                'max'        => 100,
                'step'       => 5,
                'default'    => 100,
                'selectors'  => [
                    '{{WRAPPER}} .betterdocs-toc' => 'width: {{VALUE}}%;',
                ]
            ]
        );

        $this->add_responsive_control(
            'column_background',
            [
                'label'     => esc_html__('Background Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .betterdocs-toc' => 'background-color: {{VALUE}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'column_space', // Legacy control id but new control
            [
                'label'      => __('Box Spacing', 'betterdocs'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .betterdocs-toc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .betterdocs-toc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'column_border_radius',
            [
                'label'      => esc_html__('Box Border Radius', 'betterdocs'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .betterdocs-toc' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label'     => __('Alignment', 'betterdocs'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'    => [
                        'title' => __('Left', 'betterdocs'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center'  => [
                        'title' => __('Center', 'betterdocs'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'   => [
                        'title' => __('Right', 'betterdocs'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => __('Justified', 'betterdocs'),
                        'icon'  => 'eicon-text-align-justify',
                    ],
                ],
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section(); # end of 'Card Settings'
    }

    public function title_settings()
    {
        $this->start_controls_section(
            'section_title',
            [
                'label' => __('Title', 'betterdocs'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => __('Text Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .betterdocs-toc .toc-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'typography',
                'scheme'   => Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .betterdocs-toc .toc-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'text_shadow',
                'selector' => '{{WRAPPER}} .betterdocs-toc .toc-title',
            ]
        );

        $this->add_control(
            'blend_mode',
            [
                'label'     => __('Blend Mode', 'betterdocs'),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    ''            => __('Normal', 'betterdocs'),
                    'multiply'    => 'Multiply',
                    'screen'      => 'Screen',
                    'overlay'     => 'Overlay',
                    'darken'      => 'Darken',
                    'lighten'     => 'Lighten',
                    'color-dodge' => 'Color Dodge',
                    'saturation'  => 'Saturation',
                    'color'       => 'Color',
                    'difference'  => 'Difference',
                    'exclusion'   => 'Exclusion',
                    'hue'         => 'Hue',
                    'luminosity'  => 'Luminosity',
                ],
                'selectors' => [
                    '{{WRAPPER}} .betterdocs-toc .toc-title' => 'mix-blend-mode: {{VALUE}}',
                ],
                'separator' => 'none',
            ]
        );

        $this->end_controls_section();

        $this->update_control(
            'title',
            [
                'dynamic' => [
                    'default' => Plugin::elementor()->dynamic_tags->tag_data_to_tag_text(null, 'betterdocs-title-tag'),
                ],
            ],
            [
                'recursive' => true,
            ]
        );
    }

    public function list_settings()
    {
        /**
         * ----------------------------------------------------------
         * Section: List Settinggs
         * ----------------------------------------------------------
         */
        $this->start_controls_section(
            'section_article_settings',
            [
                'label' => __('Toc List', 'betterdocs'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'list_item_typography',
                'selector' => '{{WRAPPER}} .betterdocs-toc ul li a',
            ]
        );

        $this->add_control(
            'list_word_wrap',
            [
                'label' => __('Word Wrap', 'betterdocs'),
                'type' => Controls_Manager::SELECT2,
                'multiple' => false,
                'options' => [
                    'normal' => 'normal',
                    'break-word' => 'break-word',
                    'initial' => 'initial',
                    'inherit' => 'inherit',
                ],
                'default' => 'normal',
                'selectors' => [
                    '{{WRAPPER}} .betterdocs-toc ul li a' => 'word-wrap: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'list_color',
            [
                'label'     => esc_html__('Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .betterdocs-toc ul li a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'list_hover_color',
            [
                'label'     => esc_html__('Hover Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .betterdocs-toc ul li a:hover' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .betterdocs-toc ul li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section(); # end of 'Column Settings'

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $toc_setting = [
            'htags'       => $settings['htags'],
            'hierarchy'   => $settings['list_hierarchy'],
            'list_number' => $settings['list_number'],
        ];
        if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
            set_transient('betterdocs_toc_setting', $toc_setting);
        }
        $htags = implode(',', $settings['htags']);
        $shortcode = do_shortcode(
            "[betterdocs_toc
            htags='{$htags}'
            hierarchy='{$settings['list_hierarchy']}'
            list_number='{$settings['list_number']}'
            collapsible_on_mobile='{$settings['collapsible_toc_mobile']}']"
        );

        echo apply_filters('betterdocs_elementor_toc', $shortcode);
    }
}
