<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use ElementorPro\Base\Base_Widget_Trait;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class BetterDocs_Category_Archive_List extends Widget_Base
{

    use Base_Widget_Trait;

    public function get_name()
    {
        return 'betterdocs-category-archive-list';
    }

    public function get_title()
    {
        return __('Doc Category Archive List', 'betterdocs');
    }

    public function get_icon()
    {
        return 'eicon-post-list betterdocs-eicon-post-list';
    }

    public function get_categories()
    {
        return ['betterdocs-elements', 'docs-archive'];
    }

    public function get_keywords()
    {
        return ['betterdocs-elements', 'title', 'heading', 'betterdocs', 'docs', 'doc-category', 'doc-category-archive'];
    }

    public function get_custom_help_url()
    {
        return 'https://betterdocs.co/docs/docs-archive-in-elementor/';
    }

    protected function _register_controls()
    {
        $this->section_content();
        $this->list_settings();
        $this->subcat_list_settings();
    }

    public function section_content()
    {
        $this->start_controls_section(
            'section_title',
            [
                'label' => __('Controls', 'betterdocs'),
            ]
        );

        $this->add_control(
            'alphabetic_order',
            [
                'label' => __('Order By', 'betterdocs'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'name' => __('Name', 'betterdocs'),
                    'slug' => __('Slug', 'betterdocs'),
                    'term_group' => __('Term Group', 'betterdocs'),
                    'term_id' => __('Term ID', 'betterdocs'),
                    'id' => __('ID', 'betterdocs'),
                    'description' => __('Description', 'betterdocs'),
                    'parent' => __('Parent', 'betterdocs'),
                    'betterdocs_order' => __('BetterDocs Order', 'betterdocs'),
                ],
                'default' => 'name',
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => __('Order', 'betterdocs'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'asc' => 'Ascending',
                    'desc' => 'Descending',
                ],
                'default' => 'asc',

            ]
        );

        $this->add_control(
            'nested_subcategory',
            [
                'label' => __('Nested Subcategory', 'betterdocs'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'betterdocs'),
                'label_off' => __('Hide', 'betterdocs'),
                'return_value' => '1',
                'default' => '1',
            ]
        );

        $this->add_control(
			'important_note',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => __( 'Note: This is the preview only for Elementor Editor. You will see the real view in the archive page itself.', 'betterdocs' ),
				'content_classes' => 'betterdocs-elementor-note elementor-panel-alert elementor-panel-alert-info',
			]
		);

        $this->end_controls_section();
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
                'label' => __('Category List', 'betterdocs'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'list_item_typography',
                'selector' => '{{WRAPPER}} .docs-category-listing .docs-list ul li a',
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
                    '{{WRAPPER}} .docs-category-listing .docs-list ul li a' => 'word-wrap: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'list_color',
            [
                'label'     => esc_html__('Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .docs-category-listing .docs-list ul li a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'list_hover_color',
            [
                'label'     => esc_html__('Hover Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .docs-category-listing .docs-list ul li a:hover' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .docs-category-listing .docs-list ul li, .docs-category-listing .docs-list .docs-sub-cat-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_settings_heading',
            [
                'label'     => esc_html__('List Icon', 'betterdocs'),
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
                    '{{WRAPPER}} .docs-category-listing .docs-list ul li svg' => 'fill: {{VALUE}};',
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
                    '{{WRAPPER}} .docs-category-listing .docs-list ul li svg' => 'font-size: {{SIZE}}{{UNIT}};'
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
                    '{{WRAPPER}} .docs-category-listing .docs-list ul li svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section(); # end of 'Column Settings'

    }

    public function subcat_list_settings()
    {
        /**
         * ----------------------------------------------------------
         * Section: List Settinggs
         * ----------------------------------------------------------
         */
        $this->start_controls_section(
            'section_sub_category_settings',
            [
                'label' => __('Sub Category', 'betterdocs'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'subcat_color',
            [
                'label'     => esc_html__('Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'default' => '#3f5876',
                'selectors' => [
                    '{{WRAPPER}} .docs-category-listing .docs-list .docs-sub-cat-title > a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'subcat_hover_color',
            [
                'label'     => esc_html__('Hover Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'default' => '#3f5876',
                'selectors' => [
                    '{{WRAPPER}} .docs-category-listing .docs-list .docs-sub-cat-title > a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'subcat_font_size',
            [
                'label'      => __('Font Size', 'betterdocs'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range'      => [
                    '%' => [
                        'max'  => 100,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .docs-category-listing .docs-list .docs-sub-cat-title > a' => 'font-size: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->add_control(
            'subcat_icon_color',
            [
                'label'     => esc_html__('Icon Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'default' => '#3f5876',
                'selectors' => [
                    '{{WRAPPER}} .docs-category-listing .docs-list .docs-sub-cat-title > svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'subcat_icon_size',
            [
                'label'      => __('Icon Size', 'betterdocs'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range'      => [
                    '%' => [
                        'max'  => 100,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .docs-category-listing .docs-list .docs-sub-cat-title > svg' => 'font-size: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->add_control(
            'subcategory_list_heading',
            [
                'label'     => esc_html__('Subcategory List', 'betterdocs'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'subcat_list_item_typography',
                'selector' => '{{WRAPPER}} .docs-category-listing .docs-list ul ul.docs-sub-cat li a',
            ]
        );

        $this->add_control(
            'subcat_list_word_wrap',
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
                    '{{WRAPPER}} .docs-category-listing .docs-list ul ul.docs-sub-cat li a' => 'word-wrap: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'subcat_list_color',
            [
                'label'     => esc_html__('Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .docs-category-listing .docs-list ul ul.docs-sub-cat li a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'subcat_list_hover_color',
            [
                'label'     => esc_html__('Hover Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .docs-category-listing .docs-list ul ul.docs-sub-cat li a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'subcat_list_margin',
            [
                'label'      => esc_html__('List Item Spacing', 'betterdocs'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .docs-category-listing .docs-list ul ul.docs-sub-cat li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'subcat_icon_settings_heading',
            [
                'label'     => esc_html__('List Icon', 'betterdocs'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'subcat_list_icon_color',
            [
                'label'     => esc_html__('Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .docs-category-listing .docs-list ul ul.docs-sub-cat li svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'subcat_list_icon_size',
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
                    '{{WRAPPER}} .docs-category-listing .docs-list ul ul.docs-sub-cat li svg' => 'font-size: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'subcat_list_icon_spacing',
            [
                'label'      => esc_html__('Spacing', 'betterdocs'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .docs-category-listing .docs-list ul ul.docs-sub-cat li svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section(); # end of 'Column Settings'

    }

    protected function render()
    {
        global $wp_query;
        $query_cat = isset($wp_query->query) && array_key_exists('doc_category', $wp_query->query) ? $wp_query->query['doc_category'] : '';
        $term = get_term_by('slug', $query_cat, 'doc_category');
        $post_limit = $term == false ? 5 : -1;
        $term_slug = isset($term->slug) ? $term->slug : '';
        $term_id = isset($term->term_id) ? $term->term_id : '';
        $settings = $this->get_settings_for_display();

        echo '<div id="main" class="docs-listing-main">
            <div class="docs-category-listing">
                <div class="docs-list">';
        $multikb = apply_filters('betterdocs_cat_template_multikb', false);
        $args = BetterDocs_Helper::list_query_arg('docs', $multikb, $term_slug, $post_limit, $settings['alphabetic_order'], $settings['order'], '');
        $args = apply_filters('betterdocs_articles_args', $args, $term_id);
        $post_query = new WP_Query($args);

        if ($post_query->have_posts()) :
            echo '<ul>';
            while ($post_query->have_posts()) : $post_query->the_post();
                echo '<li>' . BetterDocs_Helper::list_svg() . '<a href="' . get_the_permalink() . '">' . get_the_title() . '</a></li>';
            endwhile;
        endif;
        wp_reset_query();
        // Sub category query
        if ($settings['nested_subcategory'] == 1) {
            echo nested_category_list(
                $term_id,
                $multikb,
                [],
                'docs',
                $settings['alphabetic_order'],
                $settings['order'],
                '',
                ''
            );
        }
        echo '</ul>';
        echo '</div>
            </div>
        </div>';
    }

    public function render_plain_content()
    {}
}
