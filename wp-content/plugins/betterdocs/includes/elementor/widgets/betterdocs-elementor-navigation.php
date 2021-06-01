<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class BetterDocs_Elementor_Navigation extends Widget_Base {

    public function get_name () {
        return 'betterdocs-navigation';
    }

    public function get_title () {
        return __('Doc Navigation', 'betterdocs');
    }

    public function get_icon () {
        return 'betterdocs-icon-Navigation';
    }

    public function get_categories () {
        return ['betterdocs-elements'];
    }

    public function get_keywords () {
        return ['betterdocs-elements', 'navigation', 'betterdocs', 'docs'];
    }

    public function get_custom_help_url() {
        return 'https://betterdocs.co/docs/single-doc-in-elementor';
    }

    protected function _register_controls () {

        $this->start_controls_section(
            'section_column_settings',
            [
                'label' => __('Style', 'betterdocs'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'navigation_text_color',
            [
                'label'     => esc_html__('Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .docs-navigation a' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'navigation_text_typography',
                'selector' => '{{WRAPPER}} .docs-navigation a'
            ]
        );

        $this->add_control(
            'navigation_arrow_size',
            [
                'label'      => __('Size', 'betterdocs'),
                'type'       => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                    'size' => 35,
                ],
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'max'  => 500,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .docs-navigation svg' => 'width: {{SIZE}}px;height: {{SIZE}}px;',
                ],
            ]
        );

        $this->add_control(
            'navigation_arrow_color',
            [
                'label'     => esc_html__('Arrow Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .docs-navigation svg' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render () {
        $enable_navigation = BetterDocs_DB::get_settings('enable_navigation');
        if ($enable_navigation == 1) {
            echo '<div class="docs-navigation betterdocs-el-single-navigation">';
                $nav = get_previous_post_link( '%link', '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="42px" viewBox="0 0 50 50" version="1.1"><g id="surface1"><path style=" " d="M 11.957031 13.988281 C 11.699219 14.003906 11.457031 14.117188 11.28125 14.308594 L 1.015625 25 L 11.28125 35.691406 C 11.527344 35.953125 11.894531 36.0625 12.242188 35.976563 C 12.589844 35.890625 12.867188 35.625 12.964844 35.28125 C 13.066406 34.933594 12.972656 34.5625 12.71875 34.308594 L 4.746094 26 L 48 26 C 48.359375 26.003906 48.695313 25.816406 48.878906 25.503906 C 49.058594 25.191406 49.058594 24.808594 48.878906 24.496094 C 48.695313 24.183594 48.359375 23.996094 48 24 L 4.746094 24 L 12.71875 15.691406 C 13.011719 15.398438 13.09375 14.957031 12.921875 14.582031 C 12.753906 14.203125 12.371094 13.96875 11.957031 13.988281 Z "></path></g></svg> %title', TRUE, ' ', 'doc_category' );
                $nav .= get_next_post_link( '%link', '%title <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="42px" viewBox="0 0 50 50" version="1.1"><g id="surface1"><path style=" " d="M 38.035156 13.988281 C 37.628906 13.980469 37.257813 14.222656 37.09375 14.59375 C 36.933594 14.96875 37.015625 15.402344 37.300781 15.691406 L 45.277344 24 L 2.023438 24 C 1.664063 23.996094 1.328125 24.183594 1.148438 24.496094 C 0.964844 24.808594 0.964844 25.191406 1.148438 25.503906 C 1.328125 25.816406 1.664063 26.003906 2.023438 26 L 45.277344 26 L 37.300781 34.308594 C 36.917969 34.707031 36.933594 35.339844 37.332031 35.722656 C 37.730469 36.105469 38.363281 36.09375 38.746094 35.691406 L 49.011719 25 L 38.746094 14.308594 C 38.5625 14.109375 38.304688 13.996094 38.035156 13.988281 Z "></path></g></svg>', TRUE, ' ', 'doc_category' );
                echo apply_filters( 'betterdocs_single_post_nav', $nav );
            echo '</div>';
        }
    }
}
