<?php
use Elementor\Controls_Manager;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Box_Shadow;
use Elementor\Widget_Base;
use ElementorPro\Base\Base_Widget_Trait;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class BetterDocs_Elementor_Category_Grid extends Widget_Base {

    use Base_Widget_Trait;
    use \Better_Docs_Elementor\Traits\Template_Query;

    public function get_name () {
        return 'betterdocs-category-grid';
    }

    public function get_title () {
        return __('BetterDocs Category Grid', 'betterdocs');
    }

    public function get_icon () {
        return 'betterdocs-icon-category-grid';
    }

    public function get_categories () {
        return ['docs-archive'];
    }

    public function get_keywords () {
        return [
            'knowledgebase',
            'knowledge base',
            'documentation',
            'Doc',
            'kb',
            'betterdocs', 
            'docs', 
            'category-grid'
        ];
    }

    public function get_style_depends()
    {
        return ['betterdocs-category-grid'];
    }

    public function get_script_depends() {
        return [ 'masonry', 'betterdocs-category-grid' ];
    }

    public function get_custom_help_url() {
        return 'https://betterdocs.co/docs/betterdocs-category-grid';
    }

    protected function _register_controls()
    {
        /**
         * Query  Controls!
         * @source includes/elementor-helper.php
         */
        do_action('betterdocs/elementor/widgets/query', $this, 'doc_category');

        /**
         * ----------------------------------------------------------
         * Section: Layout Options
         * ----------------------------------------------------------
         */
        $this->start_controls_section(
            'select_layout',
            [
                'label' => __('Layout Options', 'betterdocs'),
            ]
        );

        $this->add_control(
            'layout_template',
            [
                'label' => __('Select Layout', 'betterdocs'),
                'type' => Controls_Manager::SELECT2,
                'options'   => $this->template_options(),
                'default' => $this->get_default(),
                'label_block' => true
            ]
        );

        $this->add_control(
            'layout_mode',
            [
                'label' => __('Layout Mode', 'betterdocs'),
                'type' => Controls_Manager::SELECT2,
                'options' => [
                    'grid'  => __('Grid', 'betterdocs'),
                    'fit-to-screen'  => __( 'Fit to Screen', 'betterdocs' ),
                    'masonry' => __('Masonry', 'betterdocs'),
                ],
                'default' => 'grid',
                'label_block' => true,
            ]
        );

        $this->add_responsive_control(
            'grid_column',
            [
                'label' => __('Grid Column', 'betterdocs'),
                'type' => Controls_Manager::SELECT,
                'default' => '3',
                'tablet_default' => '2',
                'mobile_default' => '1',
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                ],
                'prefix_class' => 'elementor-grid%s-',
                'frontend_available' => true,
                'label_block' => true
            ]
        );

        $this->add_responsive_control(
            'grid_space',
            [
                'label' => __('Grid Space', 'betterdocs'),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => 10,
                'condition' => [
                    'layout_mode'   => 'masonry'
                ]
            ]
        );

        $this->add_control(
            'show_header',
            [
                'label' => __('Show Header', 'betterdocs'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'betterdocs'),
                'label_off' => __('Hide', 'betterdocs'),
                'return_value' => 'true',
                'default' => 'true',
            ]
        );


        $this->add_control(
            'show_icon',
            [
                'label' => __('Show Icon', 'betterdocs'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'betterdocs'),
                'label_off' => __('Hide', 'betterdocs'),
                'return_value' => 'true',
                'default' => 'true',
                'condition' => [
                    'show_header'   => 'true'
                ]
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label' => __('Show Title', 'betterdocs'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'betterdocs'),
                'label_off' => __('Hide', 'betterdocs'),
                'return_value' => 'true',
                'default' => 'true',
                'condition' => [
                    'show_header'   => 'true'
                ]
            ]
        );

        $this->add_control(
            'title_tag',
            [
                'label' => __('Select Tag', 'betterdocs'),
                'type' => Controls_Manager::SELECT,
                'default' => 'h2',
                'options' => [
                    'h1' => __('H1', 'betterdocs'),
                    'h2' => __('H2', 'betterdocs'),
                    'h3' => __('H3', 'betterdocs'),
                    'h4' => __('H4', 'betterdocs'),
                    'h5' => __('H5', 'betterdocs'),
                    'h6' => __('H6', 'betterdocs'),
                    'span' => __('Span', 'betterdocs'),
                    'p' => __('P', 'betterdocs'),
                    'div' => __('Div', 'betterdocs'),
                ],
                'condition' => [
                    'show_title' => 'true',
                    'show_header'   => 'true'
                ],
            ]
        );

        $this->add_control(
            'show_count',
            [
                'label' => __('Show Count', 'betterdocs'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'betterdocs'),
                'label_off' => __('Hide', 'betterdocs'),
                'return_value' => 'true',
                'default' => 'true',
                'condition' => [
                    'show_header'   => 'true'
                ]
            ]
        );


        $this->add_control(
            'show_list',
            [
                'label' => __('Show List', 'betterdocs'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'betterdocs'),
                'label_off' => __('Hide', 'betterdocs'),
                'return_value' => 'true',
                'default' => 'true',
            ]
        );

        $this->add_control(
            'show_button',
            [
                'label' => __('Show Button', 'betterdocs'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'betterdocs'),
                'label_off' => __('Hide', 'betterdocs'),
                'return_value' => 'true',
                'default' => 'true',
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => __('Button Text', 'betterdocs'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => __('Explore More', 'betterdocs'),
                'condition' => [
                    'show_button' => 'true',
                ],
            ]
        );

        $this->end_controls_section(); #end of section 'Layout Options'

        /**
         * ----------------------------------------------------------
         * Section: Column Settings
         * ----------------------------------------------------------
         */
        $this->start_controls_section(
            'section_column_settings',
            [
                'label' => __('Grid', 'betterdocs'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->start_controls_tabs('grid_style_tab');

            // Normal State Tab
            $this->start_controls_tab(
                'grid_normal',
                ['label' => esc_html__('Normal', 'betterdocs')]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name'     => 'grid_bg', // Legacy control id 'content_area_bg'
                    'types'    => ['classic', 'gradient'],
                    'selector' => '{{WRAPPER}} .el-betterdocs-category-grid-post .el-betterdocs-cg-inner',
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'grid_box_shadow',
                    'label' => __( 'Box Shadow', 'betterdocs' ),
                    'selector' => '{{WRAPPER}} .el-betterdocs-category-grid-post .el-betterdocs-cg-inner',
                ]
            );


            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'grid_border',
                    'label' => __( 'Border', 'betterdocs' ),
                    'selector' => '{{WRAPPER}} .el-betterdocs-category-grid-post .el-betterdocs-cg-inner',
                ]
            );

            $this->add_responsive_control(
                'grid_border_radius',
                [
                    'label' => __( 'Border Radius', 'betterdocs' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .el-betterdocs-category-grid-post .el-betterdocs-cg-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ]
                ]
            );

            $this->end_controls_tab();

            // Hover State Tab
            $this->start_controls_tab(
                'grid_hover',
                ['label' => esc_html__('Hover', 'betterdocs')]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name'     => 'grid_bg_hover',
                    'types'    => ['classic', 'gradient'],
                    'selector' => '{{WRAPPER}} .el-betterdocs-category-grid-post .el-betterdocs-cg-inner:hover',
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'grid_hover_box_shadow',
                    'label' => __( 'Box Shadow', 'betterdocs' ),
                    'selector' => '{{WRAPPER}} .el-betterdocs-category-grid-post .el-betterdocs-cg-inner:hover',
                ]
            );


            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'grid_hover_border',
                    'label' => __( 'Border', 'betterdocs' ),
                    'selector' => '{{WRAPPER}} .el-betterdocs-category-grid-post .el-betterdocs-cg-inner:hover',
                ]
            );

            $this->add_responsive_control(
                'grid_hover_border_radius',
                [
                    'label' => __( 'Border Radius', 'betterdocs' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .el-betterdocs-category-grid-post .el-betterdocs-cg-inner:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ]
                ]
            );

            $this->end_controls_tab();

        $this->end_controls_tabs(); # end of $this->start_controls_tabs('grid_style_tab');

        $this->add_responsive_control(
            'grid_padding',
            [
                'label' => __( 'Grid Padding', 'betterdocs' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-category-grid-post .el-betterdocs-cg-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'column_padding', // Legacy control id
            [
                'label' => __( 'Grid Spacing', 'betterdocs' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-category-grid-post .el-betterdocs-cg-inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'layout_mode'   => ['grid', 'fit-to-screen']
                ]
            ]
        );

        $this->end_controls_section(); # end of 'Column Settings'


        $this->start_controls_section(
            'section_icon_settings',
            [
                'label' => __('Icon', 'betterdocs'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_icon'    => 'true',
                    'layout_template' => 'Layout_Default'
                ]
            ]
        );

        $this->start_controls_tabs('icon_settings_tabs');

        // Normal State Tab
        $this->start_controls_tab(
            'icon_normal',
            ['label' => esc_html__('Normal', 'betterdocs')]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'header_icon_bg',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .el-betterdocs-cg-header .el-betterdocs-cat-icon',
                'exclude'   => [
                    'image'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'header_icon_border', // Legacy control name change it with 'border_size' if anything happens.
                'label' => __( 'Border', 'betterdocs' ),
                'selector' => '{{WRAPPER}} .el-betterdocs-cg-header .el-betterdocs-cat-icon',
            ]
        );

        $this->add_control(
            'header_icon_border_radius',
            [
                'label' => __( 'Border Radius', 'betterdocs' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-cg-header .el-betterdocs-cat-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
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
                'name' => 'header_icon_bg_hover',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .el-betterdocs-cg-header .el-betterdocs-cat-icon:hover',
                'exclude'   => [
                    'image'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'header_icon_border_hover', // Legacy control name change it with 'border_size' if anything happens.
                'label' => __( 'Border', 'betterdocs' ),
                'selector' => '{{WRAPPER}} .el-betterdocs-cg-header .el-betterdocs-cat-icon:hover',
            ]
        );

        $this->add_control(
            'header_icon_border_radius_hover',
            [
                'label' => __( 'Border Radius', 'betterdocs' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-cg-header .el-betterdocs-cat-icon:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'header_icon_size',
            [
                'label' => __('Size', 'betterdocs'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range' => [
                    '%' => [
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-cg-header .el-betterdocs-cat-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'header_icon_padding',
            [
                'label' => esc_html__('Padding', 'betterdocs'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-cg-header .el-betterdocs-cat-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'header_icon_margin',
            [
                'label' => esc_html__('Margin', 'betterdocs'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-cg-header .el-betterdocs-cat-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->end_controls_section(); # end of 'Column Settings'

        /**
         * ----------------------------------------------------------
         * Section: Title Settinggs
         * ----------------------------------------------------------
         */
        $this->start_controls_section(
            'section_title_settings',
            [
                'label' => __('Title', 'betterdocs'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_title'    => 'true'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'cat_list_typography',
                'selector' => '{{WRAPPER}} .el-betterdocs-cat-title',
            ]
        );

        $this->start_controls_tabs('title_settings_tabs');

        // Normal State Tab
        $this->start_controls_tab(
            'title_normal',
            ['label' => esc_html__('Normal', 'betterdocs')]
        );

        $this->add_control(
            'cat_title_color',
            [
                'label' => esc_html__('Color', 'betterdocs'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-cat-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'cat_title_bg',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .el-betterdocs-category-grid-post:not(.layout-2) .el-betterdocs-cg-header, {{WRAPPER}} .el-betterdocs-category-grid-post.layout-2 .el-betterdocs-cat-title',
                'exclude'   => [
                    'image'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'title_border', // Legacy control name change it with 'border_size' if anything happens.
                'label' => __( 'Border', 'betterdocs' ),
                'selector' => '{{WRAPPER}} .el-betterdocs-cg-header-inner, {{WRAPPER}} .layout-2 .el-betterdocs-cat-title',
            ]
        );

        $this->add_control(
            'title_border_radius',
            [
                'label' => __( 'Border Radius', 'betterdocs' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .layout-2 .el-betterdocs-cat-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .el-betterdocs-cg-header'   => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .el-betterdocs-cg-header .el-betterdocs-cg-header-inner'   => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
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
                'label' => esc_html__('Color', 'betterdocs'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-cat-title:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'cat_title_bg_hover',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .el-betterdocs-category-grid-post:not(.layout-2) .el-betterdocs-cg-header:hover, {{WRAPPER}} .el-betterdocs-category-grid-post.layout-2 .el-betterdocs-cat-title:hover',
                'exclude'   => [
                    'image'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'title_border_hover', // Legacy control name change it with 'border_size' if anything happens.
                'label' => __( 'Border', 'betterdocs' ),
                'selector' => '{{WRAPPER}} .el-betterdocs-cg-header-inner:hover, {{WRAPPER}} .layout-2 .el-betterdocs-cat-title:hover',
            ]
        );

        $this->add_control(
            'title_border_radius_hover',
            [
                'label' => __( 'Border Radius', 'betterdocs' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .layout-2 .el-betterdocs-cat-title:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'layout_template' => 'Layout_2'
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();


        $this->add_responsive_control(
            'cat_title_padding',
            [
                'label' => esc_html__('Padding', 'betterdocs'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-cg-header-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .el-betterdocs-category-grid-post.layout-2 .el-betterdocs-cat-title'  => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'cat_title_margin',
            [
                'label' => esc_html__('Margin', 'betterdocs'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-cg-header' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .el-betterdocs-category-grid-post.layout-2 .el-betterdocs-cat-title'    => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section(); # end of 'Title Settings'


        /**
         * ----------------------------------------------------------
         * Section: Count Settinggs
         * ----------------------------------------------------------
         */
        $this->start_controls_section(
            'section_count_settings',
            [
                'label' => __('Count', 'betterdocs'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_count'    => 'true'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'count_font_size',
                'selector' => '{{WRAPPER}} .el-betterdocs-item-count',
            ]
        );

        $this->add_responsive_control(
            'count_size',
            [
                'label' => __('Size', 'betterdocs'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range' => [
                    '%' => [
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-item-count' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'layout_template!' => 'Layout_2'
                ]
            ]
        );

        $this->start_controls_tabs( 'count_settings_tabs' );

        // Normal State Tab
        $this->start_controls_tab(
            'count_normal',
            ['label' => esc_html__('Normal', 'betterdocs')]
        );

        $this->add_control(
            'count_color',
            [
                'label' => esc_html__('Color', 'betterdocs'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-item-count' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'count_bg',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .el-betterdocs-item-count, {{WRAPPER}} .layout-2 .el-betterdocs-item-count:before',
                'exclude' => [
                    'image',
                ],
            ]
        );

        $this->add_control(
            'count_ticker_color',
            [
                'label' => esc_html__('Ticker Background', 'betterdocs'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .layout-2 .el-betterdocs-item-count:after' => 'border-top-color: {{VALUE}};',
                ],
                'condition' => [
                    'layout_template' => 'Layout_2'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'count_border', // Legacy control name change it with 'border_size' if anything happens.
                'label' => __( 'Border', 'betterdocs' ),
                'selector' => '{{WRAPPER}} .el-betterdocs-item-count',
                'condition' => [
                    'layout_template!' => 'Layout_2'
                ]
            ]
        );

        $this->add_control(
            'count_border_radius',
            [
                'label' => __( 'Border Radius', 'betterdocs' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-item-count' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'layout_template!' => 'Layout_2'
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
            'count_transition',
            [
                'label'                 => __( 'Transition', 'essential-addons-elementor' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [
                    'size'      => '300',
                    'unit'      => 'px',
                ],
                'range'                 => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 10000,
                        'step'  => 100,
                    ],
                ],
                'size_units'            => [ 'px' ],
                'selectors'             => [
                    '{{WRAPPER}} .el-betterdocs-item-count' => 'transition: {{SIZE}}ms;',
                    '{{WRAPPER}} .el-betterdocs-item-count:after' => 'transition: {{SIZE}}ms;',
                    '{{WRAPPER}} .el-betterdocs-item-count:after' => 'transition: {{SIZE}}ms;',
                ]
            ]
        );

        $this->add_control(
            'count_color_hover',
            [
                'label' => esc_html__('Color', 'betterdocs'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-item-count:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'count_bg_hover',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .el-betterdocs-item-count:hover, {{WRAPPER}} .layout-2 .el-betterdocs-item-count:hover:before',
                'exclude' => [
                    'image',
                ],
            ]
        );

        $this->add_control(
            'count_ticker_color_hover',
            [
                'label' => esc_html__('Ticker Background', 'betterdocs'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .layout-2 .el-betterdocs-item-count:hover:after' => 'border-top-color: {{VALUE}};',
                ],
                'condition' => [
                    'layout_template' => 'Layout_2'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'count_border_hover', // Legacy control name change it with 'border_size' if anything happens.
                'label' => __( 'Border', 'betterdocs' ),
                'selector' => '{{WRAPPER}} .el-betterdocs-item-count:hover',
                'condition' => [
                    'layout_template!' => 'Layout_2'
                ]
            ]
        );

        $this->add_control(
            'count_border_radius_hover',
            [
                'label' => __( 'Border Radius', 'betterdocs' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-item-count:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'layout_template!' => 'Layout_2'
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();


        $this->end_controls_section(); # end of 'Count Settings'

        /**
         * ----------------------------------------------------------
         * Section: List Settinggs
         * ----------------------------------------------------------
         */
        $this->start_controls_section(
            'section_article_settings',
            [
                'label' => __('List', 'betterdocs'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_list' => 'true'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'list_item_typography',
                'selector' => '{{WRAPPER}} .el-betterdocs-cg-body ul li a',
            ]
        );

        $this->add_control(
            'list_color',
            [
                'label' => esc_html__('Color', 'betterdocs'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-cg-body ul li a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'list_hover_color',
            [
                'label' => esc_html__('Hover Color', 'betterdocs'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-cg-body ul li a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'list_margin',
            [
                'label' => esc_html__('List Item Spacing', 'betterdocs'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-cg-body ul li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'list_bg',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .el-betterdocs-cg-body',
                'exclude' => [
                    'image',
                ],
            ]
        );

        $this->add_responsive_control(
            'list_area_padding',
            [
                'label' => esc_html__('List Area Padding', 'betterdocs'),
                'type' => Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => 'vertical',
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-cg-body' => 'padding-top: {{TOP}}{{UNIT}}; padding-bottom: {{BOTTOM}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_settings_heading',
            [
                'label' => esc_html__('Icon', 'betterdocs'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'list_icon',
            [
                'label' => __( 'Icon', 'betterdocs' ),
                'type' => Controls_Manager::ICONS,
                'default'   => [
                    'value'     => 'far fa-file-alt',
                    'library'   => 'fa-regular'
                ]
            ]
        );

        $this->add_control(
            'list_icon_color',
            [
                'label' => esc_html__('Color', 'betterdocs'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-cg-body .el-betterdocs-cg-post-list-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'list_icon_size',
            [
                'label' => __('Size', 'betterdocs'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range' => [
                    '%' => [
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-cg-body .el-betterdocs-cg-post-list-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .el-betterdocs-cg-body img.el-betterdocs-cg-post-list-icon' => 'width: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'list_icon_spacing',
            [
                'label' => esc_html__('Spacing', 'betterdocs'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-cg-body .el-betterdocs-cg-post-list-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section(); # end of 'Column Settings'

        /**
         * ----------------------------------------------------------
         * Section: Nested List Settinggs
         * ----------------------------------------------------------
         */
        $this->start_controls_section(
            'section_nested_list_settings',
            [
                'label' => __('Nested List', 'betterdocs'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'nested_subcategory' => 'true'
                ]
            ]
        );

        $this->add_control(
            'section_nested_list_title',
            [
                'label' => esc_html__('Title', 'betterdocs'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'nested_list_title_typography',
                'selector' => '{{WRAPPER}} .el-betterdocs-grid-sub-cat-title a',
            ]
        );

        $this->add_control(
            'nested_list_title_color',
            [
                'label' => esc_html__('Color', 'betterdocs'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-grid-sub-cat-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'nested_list_title_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .el-betterdocs-grid-sub-cat-title',
                'exclude' => [
                    'image',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'nested_list_title_border',
                'label' => esc_html__('Border', 'betterdocs'),
                'selector' => '{{WRAPPER}} .el-betterdocs-grid-sub-cat-title'
            ]
        );

        $this->add_responsive_control(
            'nested_list_title_spacing',
            [
                'label' => esc_html__('Spacing', 'betterdocs'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-grid-sub-cat-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'section_nested_list_icon',
            [
                'label' => esc_html__('Icon', 'betterdocs'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'nested_list_title_closed_icon',
            [
                'label' => __( 'Collapse Icon', 'betterdocs' ),
                'type' => Controls_Manager::ICONS,
                'default'   => [
                    'value'     => 'fas fa-angle-right',
                    'library'   => 'fa-regular'
                ]
            ]
        );

        $this->add_control(
            'nested_list_title_open_icon',
            [
                'label' => __( 'Open Icon', 'betterdocs' ),
                'type' => Controls_Manager::ICONS,
                'default'   => [
                    'value'     => 'fas fa-angle-down',
                    'library'   => 'fa-regular'
                ]
            ]
        );

        $this->add_control(
            'nested_list_icon_color',
            [
                'label' => esc_html__('Color', 'betterdocs'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-grid-sub-cat-title .toggle-arrow' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'nested_list_icon_size',
            [
                'label' => __('Size', 'betterdocs'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range' => [
                    '%' => [
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-grid-sub-cat-title .toggle-arrow' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .el-betterdocs-grid-sub-cat-title img.toggle-arrow' => 'width: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'nested_list_icon_margin',
            [
                'label' => esc_html__('Area Spacing', 'betterdocs'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-grid-sub-cat-title .toggle-arrow' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );



        $this->end_controls_section(); # end of 'Column Settings'

        /**
         * ----------------------------------------------------------
         * Section: Button Settings
         * ----------------------------------------------------------
         */
        $this->start_controls_section(
            'section_button_settings',
            [
                'label' => __('Button', 'betterdocs'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_button'   => 'true'
                ]
            ]
        );

        $this->add_control(
            'show_button_icon',
            [
                'label' => __('Show Icon', 'betterdocs'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'betterdocs'),
                'label_off' => __('Hide', 'betterdocs'),
                'return_value' => 'true',
                'default' => 'true'
            ]
        );

        $this->add_control(
            'button_icon',
            [
                'label' => __( 'Icon', 'betterdocs' ),
                'type' => Controls_Manager::ICONS,
                'default'   => [
                    'value' => 'fas fa-angle-right',
                    'library'   => 'fa-solid'
                ],
                'condition' => [
                    'show_button_icon'  => 'true'
                ]
            ]
        );

        $this->add_control(
            'icon_position',
            [
                'label' => __('Icon Position', 'betterdocs'),
                'type' => Controls_Manager::SELECT,
                'default' => 'after',
                'options' => [
                    'before' => __( 'Before', 'betterdocs' ),
                    'after' => __( 'After', 'betterdocs' )
                ],
                'condition' => [
                    'show_button_icon'  => 'true'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography_normal',
                'selector' => '{{WRAPPER}} .el-betterdocs-cg-button',
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

        $this->add_control(
            'button_color_normal',
            [
                'label' => esc_html__('Color', 'betterdocs'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-cg-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'button_background_normal',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .el-betterdocs-cg-button',
                'exclude' => [
                    'image',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border_normal',
                'label' => esc_html__('Border', 'betterdocs'),
                'selector' => '{{WRAPPER}} .el-betterdocs-cg-button',
            ]
        );

        $this->add_responsive_control(
            'button_border_radius',
            [
                'label' => esc_html__('Border Radius', 'betterdocs'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-cg-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label' => esc_html__('Padding', 'betterdocs'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-cg-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_area_margin',
            [
                'label' => esc_html__('Area Spacing', 'betterdocs'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-cg-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
            'button_transition',
            [
                'label'                 => __( 'Transition', 'essential-addons-elementor' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [
                    'size'      => '300',
                    'unit'      => 'px',
                ],
                'range'                 => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 10000,
                        'step'  => 100,
                    ],
                ],
                'size_units'            => [ 'px' ],
                'selectors'             => [
                    '{{WRAPPER}} .el-betterdocs-cg-button' => 'transition: {{SIZE}}ms;',
                ]
            ]
        );

        $this->add_control(
            'button_color_hover',
            [
                'label' => esc_html__('Color', 'betterdocs'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-cg-button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'button_background_hover',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .el-betterdocs-cg-button:hover',
                'exclude' => [
                    'image',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border_hover',
                'label' => esc_html__('Border', 'betterdocs'),
                'selector' => '{{WRAPPER}} .el-betterdocs-cg-button:hover',
            ]
        );

        $this->add_responsive_control(
            'button_hover_border_radius',
            [
                'label' => esc_html__('Border Radius', 'betterdocs'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-cg-button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'button_text_alignment',
            [
                'label' => __('Text Alignment', 'betterdocs'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'betterdocs'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'betterdocs'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'betterdocs'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-cg-footer .el-betterdocs-cg-button' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_alignment',
            [
                'label' => __('Button Alignment', 'betterdocs'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'betterdocs'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'betterdocs'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'betterdocs'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .el-betterdocs-cg-footer' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section(); # end of 'Button Settings'
	}


	protected function render()
    {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute(
            'bd_category_grid_wrapper',
            [
                'id' => 'el-betterdocs-cat-grid-' . esc_attr($this->get_id()),
                'class' => [
                    'betterdocs-category-grid-wrapper',
                ],
            ]
        );

        $this->add_render_attribute(
            'bd_category_grid_inner',
            [
                'class' => [
                    'betterdocs-category-grid',
                    $settings['layout_mode']
                ],
                'data-layout-mode'  => $settings['layout_mode']
            ]
        );

        $terms_object = array(
            'taxonomy' => 'doc_category',
            'order' => $settings['order'],
            'offset'    => $settings['offset'],
            'number'    => $settings['grid_per_page'],
            'parent' => 0
        );

        if($settings['orderby'] != 'betterdocs_order') {
            $terms_object['orderby'] =  $settings['orderby'];
        }

        if ( $settings['include'] ) {
            $terms_object['include'] = array_diff($settings['include'], (array) $settings['exclude']);
        }

        if($settings['exclude']) {
            $terms_object['exclude'] =  $settings['exclude'];
        }

        $default_multiple_kb = BetterDocs_Elementor::get_betterdocs_multiple_kb_status();

        if ($settings['layout_template'] == 'Layout_2') {
            $settings['layout_template'] = 'layout-2';
        }
        
        if($default_multiple_kb) {
            $object = get_queried_object();
            if (empty($settings['selected_knowledge_base']) && is_tax('knowledge_base')) {
                $meta_value = $object->slug;
            } else {
                $meta_value = $settings['selected_knowledge_base'];
            }

            $terms_object['meta_query'] =  array(
                array(
                    'relation' => 'OR',
                    array(
                        'key'       => 'doc_category_knowledge_base',
                        'value'     => $meta_value,
                        'compare'   => 'LIKE'
                    )
                ),
            );

            $taxonomy_objects = get_terms($terms_object);

            $html = '<div ' . $this->get_render_attribute_string('bd_category_grid_wrapper') . '>';
                $html .= '<div '.$this->get_render_attribute_string('bd_category_grid_inner').' data-column="'.$settings['grid_column'].'" data-column-space="'.$settings['grid_space'].'">';
                if (file_exists($this->get_template($settings['layout_template']))) {
                    if($taxonomy_objects && ! is_wp_error( $taxonomy_objects )) {
                        foreach($taxonomy_objects as $term) {
                            $term_id = $term->term_id;
                            $term_slug = $term->slug;
                            $count = $term->count;
                            $get_term_count = betterdocs_get_postcount($count, $term_id);
                            $term_count = apply_filters('betterdocs_postcount', $get_term_count, $default_multiple_kb, $term_id, $term_slug, $count);
                            if ($term_count > 0) {
                                $html .= BetterDocs_Elementor::include_with_variable($this->get_template($settings['layout_template']), ['term' => $term, 'term_count' => $term_count, 'settings' => $settings, 'default_multiple_kb' => $default_multiple_kb]);
                            }
                        }
                    } else {
                        $html .= '<p class="no-posts-found">' . __('No posts found!', 'betterdocs') . '</p>';
                    }

                    wp_reset_postdata();
                } else {
                    $html .= '<h4>'.__( 'File Not Found', 'betterdocs' ).'</h4>';
                }
                $html .= '</div>';
                $html .= '<div class="clearfix"></div>';

                if (\Elementor\Plugin::instance()->editor->is_edit_mode()) {
                    $this->render_editor_script();
                }
            $html .= '</div>';

            echo $html;


        } else {
            $taxonomy_objects = get_terms($terms_object);

            $html = '<div ' . $this->get_render_attribute_string('bd_category_grid_wrapper') . '>';
                $html .= '<div '.$this->get_render_attribute_string('bd_category_grid_inner').' data-column="'.$settings['grid_column'].'" data-column-space="'.$settings['grid_space'].'">';
                
                if (file_exists($this->get_template($settings['layout_template']))) {
                    if($taxonomy_objects && ! is_wp_error( $taxonomy_objects )) {
                        foreach($taxonomy_objects as $term) {
                            $term_id = $term->term_id;
                            $term_slug = $term->slug;
                            $count = $term->count;
                            $get_term_count = betterdocs_get_postcount($count, $term_id);
                            $term_count = apply_filters('betterdocs_postcount', $get_term_count, $default_multiple_kb, $term_id, $term_slug, $count);
                            if ($term_count > 0) {
                                $html .= BetterDocs_Elementor::include_with_variable($this->get_template($settings['layout_template']), ['term' => $term, 'term_count' => $term_count, 'settings' => $settings, 'default_multiple_kb' => $default_multiple_kb]);
                            }
                        }
                    } else {
                        $html .= '<p class="no-posts-found">' . __('No posts found!', 'betterdocs') . '</p>';
                    }
                    wp_reset_postdata();
                } else {
                    $html .= '<h4>'.__( 'File Not Found', 'betterdocs' ).'</h4>';
                }
                $html .= '</div>';
                $html .= '<div class="clearfix"></div>';

                if (\Elementor\Plugin::instance()->editor->is_edit_mode()) {
                    $this->render_editor_script();
                }
            $html .= '</div>';

            echo $html;
        }
    }

    protected function render_editor_script()
    {
    ?>
        <script>
            jQuery(document).ready(function($) {
                $('.betterdocs-category-grid').each(function () {
                    let $grid = $(this),
                        $layout_mode = $grid.data('layout-mode'),
                        $column = $grid.data('column'),
                        $column_space = $grid.data('column-space');
                    if($layout_mode === 'masonry') {
                        let masonryItem = $(".el-betterdocs-category-grid-post", $grid);
                        let total_margin = $column * $column_space;
                        masonryItem.css("width", "calc((100% - " + total_margin + "px) / " + parseInt($column) + ")");
                        $grid.masonry({
                            itemSelector: ".el-betterdocs-category-grid-post",
                            percentPosition: true,
                            gutter: $column_space
                        });
                    }
                });
            });
        </script>
    <?php
    }
}
