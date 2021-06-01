<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class BetterDocs_Elementor_Feedback extends Widget_Base {

    public function get_name () {
        return 'betterdocs-feedback';
    }

    public function get_title () {
        return __('Doc Feedback', 'betterdocs');
    }

    public function get_icon () {
        return 'betterdocs-icon-feedback';
    }

    public function get_categories () {
        return ['betterdocs-elements'];
    }

    public function get_keywords () {
        return ['betterdocs-elements', 'feedback', 'betterdocs', 'docs'];
    }

    public function get_custom_help_url() {
        return 'https://betterdocs.co/docs/single-doc-in-elementor';
    }

    protected function _register_controls () {

        /**
         * ----------------------------------------------------------
         * Section: Layout Options
         * ----------------------------------------------------------
         */
        $this->start_controls_section(
            'section_layout_options',
            [
                'label' => __('General ', 'betterdocs')
            ]
        );

        $this->add_control(
            'feedback_link_title',
            [
                'label'   => __('Content', 'betterdocs'),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__('Still stuck? How can we help?', 'betterdocs')
            ]
        );
        $this->add_control(
            'feedback_form_title',
            [
                'label'   => __('Feedback Form Title', 'betterdocs'),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__('How can we help?', 'betterdocs')
            ]
        );

        $this->add_control(
            'feedback_form_button_text',
            [
                'label'       => __('Button Text', 'betterdocs'),
                'type'        => Controls_Manager::TEXT,
                'default'     => 'Send',
                'placeholder' => __('Enter button text', 'betterdocs'),
                'title'       => __('Enter button text here', 'betterdocs'),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_card_settings_text',
            [
                'label' => __('Text', 'betterdocs'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'feedback_text_color',
            [
                'label'     => esc_html__('Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .feedback-form-link' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'feedback_text_typography',
                'selector' => '{{WRAPPER}} .feedback-form-link'
            ]
        );

        $this->end_controls_section();

        $this->icon_section();

        $this->feedback_form();

    }

    public function icon_section () {
        $this->start_controls_section(
            'section_icon_options',
            [
                'label' => __('Icon ', 'betterdocs'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'feedback_icon_color',
            [
                'label'     => esc_html__('Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR
            ]
        );

        $this->add_control(
            'feedback_text_icon_size',
            [
                'label'      => __('Size', 'betterdocs'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'max'  => 1000,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .feedback-form-icon svg' => 'width: {{SIZE}}px;height: {{SIZE}}px;'
                ]
            ]
        );

        $this->end_controls_section();
    }

    public function feedback_form () {
        /**
         * ----------------------------------------------------------
         * Section: Box Styles
         * ----------------------------------------------------------
         */
        $this->start_controls_section(
            'section_card_settings',
            [
                'label' => __('FeedBack Form', 'betterdocs'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'feedback_form_width',
            [
                'label'      => __('Width', 'betterdocs'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'max'  => 1000,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .betterdocs-modalwindow .modal-content' => 'width: {{SIZE}}px;'
                ],
            ]
        );

        $this->add_control(
            'feedback_form_height',
            [
                'label'      => __('Height', 'betterdocs'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'max'  => 1000,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .betterdocs-modalwindow .modal-content' => 'height: {{SIZE}}px;'
                ],
            ]
        );

        $this->add_control(
            'feedback_form_heading',
            [
                'label' => esc_html__('Heading', 'betterdocs'),
                'type'  => Controls_Manager::HEADING
            ]
        );

        $this->add_control(
            'feedback_form_heading_color',
            [
                'label'     => esc_html__('Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .betterdocs-modalwindow .modal-content .feedback-form-title' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'feedback_form_heading_typography',
                'selector' => '{{WRAPPER}} .betterdocs-modalwindow .modal-content .feedback-form-title'
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
                    '{{WRAPPER}} .betterdocs-modalwindow .modal-content .feedback-form-title' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'feedback_form_label',
            [
                'label' => esc_html__('Lable', 'betterdocs'),
                'type'  => Controls_Manager::HEADING
            ]
        );

        $this->add_control(
            'feedback_form_label_color',
            [
                'label'     => esc_html__('Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .betterdocs-modalwindow .betterdocs-feedback-form label' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'feedback_form_label_typography',
                'selector' => '{{WRAPPER}} .betterdocs-modalwindow .betterdocs-feedback-form label'
            ]
        );

        $this->add_control(
            'feedback_form_label_space',
            [
                'label'      => __('Space', 'betterdocs'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'max'  => 500,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .betterdocs-modalwindow .betterdocs-feedback-form label input,{{WRAPPER}} .betterdocs-modalwindow .betterdocs-feedback-form label textarea' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'feedback_form_button',
            [
                'label' => esc_html__('Button', 'betterdocs'),
                'type'  => Controls_Manager::HEADING
            ]
        );

        $this->add_control(
            'feedback_form_button_background',
            [
                'label'     => esc_html__('Background', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .betterdocs-modalwindow .betterdocs-feedback-form #feedback_form_submit_btn' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'feedback_form_button_color',
            [
                'label'     => esc_html__('Text Color', 'betterdocs'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .betterdocs-modalwindow .betterdocs-feedback-form #feedback_form_submit_btn' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'feedback_form_button_typography',
                'selector' => '{{WRAPPER}} .betterdocs-modalwindow .betterdocs-feedback-form #feedback_form_submit_btn'
            ]
        );

        $this->add_responsive_control(
            'feedback_form_button_width',
            [
                'label'      => esc_html__('Width', 'betterdocs'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 500,
                        'step' => 1,
                    ],
                    '%'  => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .betterdocs-modalwindow .betterdocs-feedback-form #feedback_form_submit_btn' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'feedback_form_button_padding',
            [
                'label'      => __('Padding', 'betterdocs'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .betterdocs-modalwindow .betterdocs-feedback-form #feedback_form_submit_btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'feedback_form_button_align',
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
                    '{{WRAPPER}} .betterdocs-modalwindow .betterdocs-feedback-form .feedback-from-button' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render () {
        $settings = $this->get_settings_for_display();
        $email_feedback = BetterDocs_DB::get_settings('email_feedback');
        if ($email_feedback == 1) {

            ?>
            <div class="feedback-form">
                <a class="feedback-form-link" href="#betterdocs-form-modal" name="betterdocs-form-modal">
                    <span class="feedback-form-icon">
                        <?php $this->feedback_icon(); ?>
                    </span>
                    <?php echo $settings['feedback_link_title']; ?></a>
                <div id="betterdocs-form-modal" class="betterdocs-modalwindow">
                    <div class="modal-inner">
                        <div class="modal-content">
                            <a href="#" class="close">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                     width="16px" viewBox="0 0 50 50" version="1.1">
                                    <g id="surface1">
                                        <path style=" "
                                              d="M 9.15625 6.3125 L 6.3125 9.15625 L 22.15625 25 L 6.21875 40.96875 L 9.03125 43.78125 L 25 27.84375 L 40.9375 43.78125 L 43.78125 40.9375 L 27.84375 25 L 43.6875 9.15625 L 40.84375 6.3125 L 25 22.15625 Z "></path>
                                    </g>
                                </svg>
                            </a>
                            <h2><?php echo $settings['feedback_form_title']; ?></h2>
                            <div class="modal-content-inner">
                                <?php echo do_shortcode("[betterdocs_feedback_form button_text='{$settings['feedback_form_button_text']}']"); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }

    public function feedback_icon () {
        $settings = $this->get_settings_for_display();
        // $color = $settings['feedback_icon_color'];
        $color = '';
        ?>
        <svg xmlns="http://www.w3.org/2000/svg" width="32px"
             viewBox="0 0 64 64">
            <linearGradient
                    id="zWPy7gPuySZ8fg4Y3QF24a" x1="26" x2="26" y1="630.833" y2="619.332"
                    gradientTransform="matrix(1 0 0 -1 0 654)" gradientUnits="userSpaceOnUse"
                    spreadMethod="reflect">
                <stop offset="0" stop-color="#6dc7ff"></stop>
                <stop offset="1"
                      stop-color="#e6abff"></stop>
            </linearGradient>
            <path
                    fill="<?php echo !empty($color)?$color:'url(#zWPy7gPuySZ8fg4Y3QF24a)' ?>"
                    d="M15.082,25.762l9.625,8.141c0.746,0.633,1.84,0.633,2.59,0l9.621-8.141 C37.629,25.16,37.203,24,36.27,24H15.73C14.797,24,14.371,25.16,15.082,25.762z"></path>
            <linearGradient
                    id="zWPy7gPuySZ8fg4Y3QF24b" x1="26" x2="26" y1="647.5" y2="596.439"
                    gradientTransform="matrix(1 0 0 -1 0 654)" gradientUnits="userSpaceOnUse"
                    spreadMethod="reflect">
                <stop offset="0" stop-color="#1a6dff"></stop>
                <stop offset="1"
                      stop-color="#c822ff"></stop>
            </linearGradient>
            <path
                    fill="<?php echo !empty($color)?$color:'url(#zWPy7gPuySZ8fg4Y3QF24b)' ?>" d="M18,49h16v2H18V49z"></path>
            <linearGradient
                    id="zWPy7gPuySZ8fg4Y3QF24c" x1="32" x2="32" y1="8.915" y2="55.387"
                    gradientUnits="userSpaceOnUse" spreadMethod="reflect">
                <stop offset="0"
                      stop-color="#1a6dff"></stop>
                <stop
                        offset="1" stop-color="#c822ff"></stop>
            </linearGradient>
            <path
                    fill="<?php echo !empty($color)?$color:'url(#zWPy7gPuySZ8fg4Y3QF24c)' ?>"
                    d="M48,9c-6.134,0-11.277,4.276-12.637,10H8c-2.758,0-5,2.242-5,5v26c0,2.758,2.242,5,5,5h36 c2.758,0,5-2.242,5-5V35h2v-2h-3c-6.066,0-11-4.934-11-11s4.934-11,11-11s11,4.934,11,11v3c0,1.102-0.898,2-2,2s-2-0.898-2-2v-3 c0-3.859-3.141-7-7-7s-7,3.141-7,7s3.141,7,7,7c2.125,0,4.027-0.953,5.312-2.453C53.918,27.984,55.344,29,57,29c2.207,0,4-1.793,4-4 v-3C61,14.832,55.168,9,48,9z M5,24.109L17.086,34L5,43.891V24.109z M47,50c0,1.652-1.348,3-3,3H8c-1.652,0-3-1.348-3-3v-3.527 l13.668-11.18l4.168,3.41c0.914,0.75,2.039,1.125,3.164,1.125s2.25-0.375,3.164-1.125l4.172-3.41L47,46.473V50z M47,34.949v8.941 L34.914,34l3.618-3.12C40.691,33.18,43.668,34.694,47,34.949z M37.264,29.317l-9.365,7.835c-1.102,0.902-2.699,0.902-3.801,0 L5.699,22.098C6.25,21.434,7.07,21,8,21h27.051C35.025,21.331,35,21.662,35,22C35,24.712,35.837,27.231,37.264,29.317z M48,27 c-2.758,0-5-2.242-5-5s2.242-5,5-5s5,2.242,5,5S50.758,27,48,27z"></path>
        </svg>
        <?php
    }
}
