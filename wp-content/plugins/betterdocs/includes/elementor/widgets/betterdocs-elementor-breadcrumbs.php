<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class BetterDocs_Elementor_Breadcrumbs extends Widget_Base
{

    public function get_name()
    {
        return 'betterdocs-breadcrumb';
    }

    public function get_title()
    {
        return __('Doc Breadcrumbs', 'betterdocs');
    }

    public function get_icon()
    {
        return 'betterdocs-icon-Breadcrumbs';
    }

    public function get_keywords()
    {
        return ['betterdocs-elements', 'breadcrumbs', 'internal links', 'docs', 'betterdocs'];
    }

    public function get_custom_help_url()
    {
        return 'https://betterdocs.co/docs/single-doc-in-elementor';
    }

    public function get_categories()
    {
        return ['betterdocs-elements', 'betterdocs-elements-single', 'docs-archive'];
    }

    protected function _register_controls()
    {

        $this->start_controls_section(
            'section_betterdocs_breadcrumbs_style',
            [
                'label' => __('Style', 'betterdocs'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'link_color',
            [
                'label' => __('Text Color', 'betterdocs'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .betterdocs-breadcrumb .betterdocs-breadcrumb-item > a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography',
                'selector' => '{{WRAPPER}} .betterdocs-breadcrumb .betterdocs-breadcrumb-item a,{{WRAPPER}} .betterdocs-breadcrumb .betterdocs-breadcrumb-item span',
            ]
        );

        $this->add_responsive_control(
            'alignment',
            [
                'label' => __('Alignment', 'betterdocs'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => __('Left', 'betterdocs'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'betterdocs'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => __('Right', 'betterdocs'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .betterdocs-breadcrumb .betterdocs-breadcrumb-list' => 'justify-content: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();


        $this->icon_style();
    }

    public function icon_style()
    {
        /**
         * ----------------------------------------------------------
         * Section: Icon Style
         * ----------------------------------------------------------
         */
        $this->start_controls_section(
            'section_article_settings',
            [
                'label' => __('Icon', 'betterdocs'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );


        $this->add_control(
            'breadcrumbs_icon_color',
            [
                'label'     => esc_html__('Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .betterdocs-breadcrumb .breadcrumb-delimiter' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->add_responsive_control(
            'breadcrumbs_icon_size',
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
                    '{{WRAPPER}} .betterdocs-breadcrumb .breadcrumb-delimiter .breadcrumb-delimiter-icon' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->end_controls_section(); # end of 'Column Settings'
    }

    protected function render()
    {
        global $wp_query;
        if ($wp_query->query === NULL || (isset($wp_query->query['post_type']) && $wp_query->query['post_type'] === 'post')) {
            $delimiter = '<div class="icon-container"><svg class="breadcrumb-delimiter-icon" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" class="svg-inline--fa fa-angle-right fa-w-8" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path fill="currentColor" d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"></path></svg><div>';
            echo '<nav class="betterdocs-breadcrumb">
                <ul class="betterdocs-breadcrumb-list">
                <li class="betterdocs-breadcrumb-item item-home"><a class="bread-link bread-home" href="#">Home</a></li>
                <li class="betterdocs-breadcrumb-item breadcrumb-delimiter">' . $delimiter . '</li>
                <li class="betterdocs-breadcrumb-item item-home"><a class="bread-link bread-home" href="#">Docs</a></li>
                </ul>
            </nav>';
        } else {
            betterdocs_breadcrumbs();
        }
    }

    public function render_plain_content()
    { }
}
