<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Icons_Manager;
use \Elementor\Widget_Base;
use \Elementor\Plugin;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Border as Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow as Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography as Group_Control_Typography;

class Easyjobs_Elementor_Job_List extends Widget_Base {
	use Easyjobs_Elementor_Template;

	protected $is_editor;

	public function __construct( $data = [], $args = null ) {
		parent::__construct( $data, $args );
		$this->is_editor = Plugin::$instance->editor->is_edit_mode();
	}

	public function get_name() {
		return 'easyjobs-job-list';
	}

	public function get_title() {
		return esc_html__( 'Easyjobs Job List', EASYJOBS_TEXTDOMAIN );
	}

	public function get_icon() {
		return 'eicon-post-list';
	}

	public function get_categories() {
		return [ 'easyjobs' ];
	}

	public function get_keywords() {
		return [
			'easyjobs',
			'jobs',
		];
	}

	public function get_custom_help_url() {
		return 'https://easy.jobs/docs/';
	}


	/**
	 * Get published job from api
	 *
	 * @param  array  $arg
	 *
	 * @return object|false
	 * @since 1.0.0
	 */
	private function get_published_jobs( $arg = [] ) {

		$query_param = wp_parse_args( $arg, [
			'limit'   => 10,
			'orderby' => 'id:desc'
		] );
		if ( ! $this->is_editor ) {
			$job_info = Easyjobs_Api::get( 'published_jobs', $query_param );

			return $job_info->status == 'success' ? $job_info->data : [];
		}

		//cache only editor mode
		$arg = [
			'key'     => $this->get_token(),
			'limit'   => $query_param['limit'],
			'orderby' => $query_param['orderby']
		];

		$key  = 'elej_job_' . md5( implode( '', $arg ) );
		$jobs = get_transient( $key );
		if ( empty( $jobs ) ) {
			$job_info = Easyjobs_Api::get( 'published_jobs', $query_param );
			if ( $job_info->status === 'success' ) {
				$jobs = $job_info->data;
				set_transient( $key, $jobs, 0.5 * HOUR_IN_SECONDS );
			}
		}

		return $jobs;
	}

	private function get_token() {
		$settings = EasyJobs_DB::get_settings();

		return ! empty( $settings['easyjobs_api_key'] ) ? $settings['easyjobs_api_key'] : false;
	}


	public function check_token() {

		$this->start_controls_section(
			'easyjobs_api_warning',
			[
				'label' => __( 'Warning!', EASYJOBS_TEXTDOMAIN ),
			]
		);

		$this->add_control(
			'easyjobs_api_warning_text',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => __( 'Please set your API key on the <strong style="color: #d30c5c"><a href="' . admin_url( 'admin.php?page=easyjobs-settings#general' ) . '" target="_blank">EasyJobs</a> </strong> settings page.',
					EASYJOBS_TEXTDOMAIN ),
				'content_classes' => 'elej-warning',
			]
		);

		$this->end_controls_section();

	}

	protected function _register_controls() {

		if ( ! $this->get_token() ) {
			$this->check_token();

			return;
		}

		//content tab
		$this->content_job_list_general();
		$this->content_job_list_control();

		//style tab
		$this->style_general_controls();
		$this->style_section_controls();
		$this->style_job_list_control();
	}

	public function content_job_list_general() {
		$this->start_controls_section(
			'section_easyjobs_info_box',
			[
				'label' => __( 'General', EASYJOBS_TEXTDOMAIN ),
			]
		);

		$this->add_control(
			'easyjobs_job_list_title_control',
			[
				'label'        => __( 'Hide Title', EASYJOBS_TEXTDOMAIN ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', EASYJOBS_TEXTDOMAIN ),
				'label_off'    => __( 'No', EASYJOBS_TEXTDOMAIN ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'easyjobs_job_list_title',
			[
				'label'       => __( 'Title', EASYJOBS_TEXTDOMAIN ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Open Job Positions', EASYJOBS_TEXTDOMAIN ),
				'placeholder' => __( 'Type your title here', EASYJOBS_TEXTDOMAIN ),
				'condition'   => [
					'easyjobs_job_list_title_control!' => 'yes'
				]
			]
		);

		$this->add_control(
			'easyjobs_job_list_heading_icon_control',
			[
				'label'        => __( 'Hide Icon', EASYJOBS_TEXTDOMAIN ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', EASYJOBS_TEXTDOMAIN ),
				'label_off'    => __( 'No', EASYJOBS_TEXTDOMAIN ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'easyjobs_job_list_heading_icon',
			[
				'label'     => __( 'Icon', EASYJOBS_TEXTDOMAIN ),
				'type'      => Controls_Manager::ICONS,
				'condition' => [
					'easyjobs_job_list_heading_icon_control!' => 'yes'
				]
			]
		);

		$this->add_control(
			'easyjobs_joblist_apply_button_text',
			[
				'label'       => __( 'Apply Button Text', EASYJOBS_TEXTDOMAIN ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Apply', EASYJOBS_TEXTDOMAIN ),
				'placeholder' => __( 'Apply', EASYJOBS_TEXTDOMAIN ),
			]
		);

		$this->end_controls_section();
	}

	public function content_job_list_control() {
		$this->start_controls_section(
			'easyjobs_job_list_query',
			[
				'label' => __( 'Job List', EASYJOBS_TEXTDOMAIN ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);


		$this->add_control(
			'easyjobs_job_list_order_by',
			[
				'label'   => __( 'Order BY', EASYJOBS_TEXTDOMAIN ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'id',
				'options' => [
					'id'           => __( 'ID', EASYJOBS_TEXTDOMAIN ),
					'title'        => __( 'Title', EASYJOBS_TEXTDOMAIN ),
					'vacancies'    => __( 'Vacancies', EASYJOBS_TEXTDOMAIN ),
					'salary'       => __( 'Salary', EASYJOBS_TEXTDOMAIN ),
					'published_at' => __( 'Published Date', EASYJOBS_TEXTDOMAIN ),
					'created_at'   => __( 'Created Date', EASYJOBS_TEXTDOMAIN ),
					'updated_at'   => __( 'Updated Date', EASYJOBS_TEXTDOMAIN ),
				],
			]
		);

		$this->add_control(
			'easyjobs_job_list_sort_by',
			[
				'label'   => __( 'Sort BY', EASYJOBS_TEXTDOMAIN ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'asc',
				'options' => [
					'asc'  => __( 'ASC', EASYJOBS_TEXTDOMAIN ),
					'desc' => __( 'DESC', EASYJOBS_TEXTDOMAIN )
				],
			]
		);

		$this->add_control(
			'easyjobs_jobs_per_page',
			[
				'label'   => esc_html__( 'Show Jobs', EASYJOBS_TEXTDOMAIN ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 2,
				]
			] );

		$this->add_control(
			'easyjobs_show_open_job',
			[
				'label'        => __( 'Show Open Job Only', EASYJOBS_TEXTDOMAIN ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', EASYJOBS_TEXTDOMAIN ),
				'label_off'    => __( 'No', EASYJOBS_TEXTDOMAIN ),
				'return_value' => 'yes',
				'default'      => 'yes',

			]
		);

		$this->end_controls_section();
	}

	/**
	 * It prints controls for managing general style of Easyjobs landing page
	 */
	public function style_general_controls() {
		$this->start_controls_section( 'section_style_general', [
			'label' => __( 'General', EASYJOBS_TEXTDOMAIN ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );


		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'easyjobs_job_list_section_background',
				'label'    => __( 'Background', EASYJOBS_TEXTDOMAIN ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .easyjobs-elementor,{{WRAPPER}} .easyjobs-elementor  .ej-job-list-item',
			]
		);

		$this->add_responsive_control(
			'easyjobs_job_list_section_alignment',
			[
				'label'        => esc_html__( 'Alignment', EASYJOBS_TEXTDOMAIN ),
				'type'         => Controls_Manager::CHOOSE,
				'label_block'  => true,
				'options'      => [
					'left'   => [
						'title' => esc_html__( 'Left', EASYJOBS_TEXTDOMAIN ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', EASYJOBS_TEXTDOMAIN ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', EASYJOBS_TEXTDOMAIN ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'prefix_class' => 'ej-landingpage-alignment-',
				'default'      => 'center',
			]
		);

		$this->add_responsive_control(
			'easyjobs_job_list_section_width',
			[
				'label'      => esc_html__( 'Width', EASYJOBS_TEXTDOMAIN ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [
					'px',
					'%',
				],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1300,
						'step' => 5,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => '%',
					'size' => 100,
				],
				'selectors'  => [
					'{{WRAPPER}} .easyjobs-elementor' => 'width: {{SIZE}}{{UNIT}};',
				]
			] );

		$this->add_control(
			"easyjobs_job_list_section_margin",
			[
				'label'      => __( 'Margin', EASYJOBS_TEXTDOMAIN ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [
					'px',
					'em',
					'%',
				],
				'selectors'  => [
					"{{WRAPPER}} .easyjobs-elementor" => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			] );

		$this->add_control(
			"easyjobs_job_list_section__padding",
			[
				'label'      => __( 'Form Padding', EASYJOBS_TEXTDOMAIN ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [
					'px',
					'em',
					'%',
				],
				'selectors'  => [
					"{{WRAPPER}} .easyjobs-elementor" => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			] );

		$this->add_control(
			'easyjobs_job_list_border_radius',
			[
				'label'      => __( 'Border Radius', EASYJOBS_TEXTDOMAIN ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .easyjobs-elementor' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'easyjobs_job_list_section_boxshadow',
				'selector' => '{{WRAPPER}} .easyjobs-elementor',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * It prints controls for managing section heading
	 */
	public function style_section_controls() {
		$this->start_controls_section( 'style_easyjobs_section', [
			'label' => __( 'Section', EASYJOBS_TEXTDOMAIN ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control(
			"easyjobs_section_heading_margin",
			[
				'label'      => __( 'Margin', EASYJOBS_TEXTDOMAIN ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [
					'px',
					'em',
					'%',
				],
				'selectors'  => [
					"{{WRAPPER}} .ej-section-title" => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			] );

		$this->add_control(
			"easyjobs_section_heading_padding",
			[
				'label'      => __( 'Padding', EASYJOBS_TEXTDOMAIN ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [
					'px',
					'em',
					'%',
				],
				'selectors'  => [
					"{{WRAPPER}} .ej-section-title" => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			] );

		$this->add_control(
			'easyjobs_landingpage_section_heading',
			[
				'label'     => __( 'Section Heading', EASYJOBS_TEXTDOMAIN ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'easyjobs_section_heading_color',
			[
				'label'     => esc_html__( 'Color', EASYJOBS_TEXTDOMAIN ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ej-section-title .ej-section-title-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'easyjobs_section_heading_typography',
				'label'    => __( 'Typography', EASYJOBS_TEXTDOMAIN ),
				'selector' => '{{WRAPPER}} .ej-section-title .ej-section-title-text',
			]
		);

		$this->add_control(
			'easyjobs_job_list_el_section_icon',
			[
				'label'     => __( 'Section Icon', EASYJOBS_TEXTDOMAIN ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'easyjobs_job_list_el_section_icon_width',
			[
				'label'     => __( 'Width', EASYJOBS_TEXTDOMAIN ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 5,
					],
				],
				'default'   => [
					'unit' => 'px',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .ej-section-title-icon' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'easyjobs_job_list_el_section_icon_height',
			[
				'label'     => __( 'Height', EASYJOBS_TEXTDOMAIN ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 5,
					],
				],
				'default'   => [
					'unit' => 'px',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .ej-section-title-icon' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'easyjobs_section_icon_background',
			[
				'label'     => esc_html__( 'Background', EASYJOBS_TEXTDOMAIN ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ej-section-title span.ej-section-title-icon' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'easyjobs_section_icon_color',
			[
				'label'     => esc_html__( 'Color', EASYJOBS_TEXTDOMAIN ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ej-section-title span.ej-section-title-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'easyjobs_job_list_el_section_icon_size',
			[
				'label'     => __( 'Icon Size', EASYJOBS_TEXTDOMAIN ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 5,
					],
				],
				'default'   => [
					'unit' => 'px',
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .ej-section-title i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}


	/**
	 * prints controls for managing Job list box
	 */
	public function style_job_list_control() {

		$this->start_controls_section( 'section_style_job_list', [
			'label' => __( 'Job List', EASYJOBS_TEXTDOMAIN ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );


		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'easyjobs_joblist_background_color',
				'label'    => __( 'Background', EASYJOBS_TEXTDOMAIN ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item',
			]
		);

		$this->add_control(
			'easyjobs_joblist_bar_color',
			[
				'label'     => __( 'Separator Color ', EASYJOBS_TEXTDOMAIN ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner .ej-job-list-item-col' => 'border-right-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'easyjobs_joblist_box_padding',
			[
				'label'      => __( 'Padding', EASYJOBS_TEXTDOMAIN ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'easyjobs_joblist_box_margin',
			[
				'label'      => __( 'Margin', EASYJOBS_TEXTDOMAIN ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'easyjobs_joblist_border',
				'selector' => '{{WRAPPER}} .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item',
			]
		);

		$this->add_control(
			'easyjobs_joblist__border_radius',
			[
				'label'      => __( 'Border Radius', EASYJOBS_TEXTDOMAIN ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'easyjobs_joblist_box_shadow',
				'selector'  => '{{WRAPPER}} .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item',
				'separator' => 'before',
			]
		);

		//Title section
		$this->add_control(
			'easyjobs_joblist_title_section',
			[
				'label'     => __( 'Job Title', EASYJOBS_TEXTDOMAIN ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'easyjobs_joblist_title_color',
			[
				'label'     => __( 'Color', EASYJOBS_TEXTDOMAIN ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-title a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'easyjobs_joblist_title_typography',
				'label'    => __( 'Typography', EASYJOBS_TEXTDOMAIN ),
				'selector' => '{{WRAPPER}} .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-title a',
			]
		);

		$this->add_responsive_control(
			'easyjobs_joblist_title_space',
			[
				'label'      => __( 'Space', EASYJOBS_TEXTDOMAIN ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-title' => 'padding-bottom:{{BOTTOM}}{{UNIT}};',
				],
				'separator'  => 'after',
			]
		);

		//Category section
		$this->add_control(
			'easyjobs_joblist_category_section',
			[
				'label'     => __( 'Company Name', EASYJOBS_TEXTDOMAIN ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'easyjobs_joblist_company_name_color',
			[
				'label'     => __( 'Color', EASYJOBS_TEXTDOMAIN ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner .ej-job-list-info-block.ej-job-list-company-name i,{{WRAPPER}} .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner .ej-job-list-info-block.ej-job-list-company-name a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'easyjobs_joblist_company_name_typography',
				'label'    => __( 'Typography', EASYJOBS_TEXTDOMAIN ),
				'selector' => '{{WRAPPER}} .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner .ej-job-list-info-block.ej-job-list-company-name i,{{WRAPPER}} .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner .ej-job-list-info-block.ej-job-list-company-name a',
			]
		);

		//Location section
		$this->add_control(
			'easyjobs_joblist_location_section',
			[
				'label'     => __( 'Job Location', EASYJOBS_TEXTDOMAIN ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'easyjobs_joblist_location_color',
			[
				'label'     => __( 'Color', EASYJOBS_TEXTDOMAIN ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner .ej-job-list-info-block.ej-job-list-location i,{{WRAPPER}} .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner .ej-job-list-info-block.ej-job-list-location span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'easyjobs_joblist_location_typography',
				'label'    => __( 'Typography', EASYJOBS_TEXTDOMAIN ),
				'selector' => '{{WRAPPER}} .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner .ej-job-list-info-block.ej-job-list-location i,{{WRAPPER}} .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner .ej-job-list-info-block.ej-job-list-location span',
			]
		);

		//Deadline section
		$this->add_control(
			'easyjobs_joblist_deadline_section',
			[
				'label'     => __( 'Job Deadline', EASYJOBS_TEXTDOMAIN ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'easyjobs_joblist_deadline_color',
			[
				'label'     => __( 'Color', EASYJOBS_TEXTDOMAIN ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .easyjobs-shortcode-wrapper .ej-job-list-item-col .ej-deadline' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'easyjobs_joblist_deadline_typography',
				'label'    => __( 'Typography', EASYJOBS_TEXTDOMAIN ),
				'selector' => '{{WRAPPER}} .easyjobs-shortcode-wrapper .ej-job-list-item-col .ej-deadline',
			]
		);

		//vacancies section
		$this->add_control(
			'easyjobs_joblist_vacancies_section',
			[
				'label'     => __( 'Job Vacancies', EASYJOBS_TEXTDOMAIN ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'easyjobs_joblist_vacancies_color',
			[
				'label'     => __( 'Color', EASYJOBS_TEXTDOMAIN ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner .ej-job-list-item-col .ej-list-sub' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'easyjobs_joblist_vacancies_typography',
				'label'    => __( 'Typography', EASYJOBS_TEXTDOMAIN ),
				'selector' => '{{WRAPPER}} .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner .ej-job-list-item-col .ej-list-sub',
			]
		);

		$this->style_job_apply_button();

		$this->end_controls_section();
	}

	/**
	 * prints controls for managing Job list apply button
	 */
	public function style_job_apply_button() {

		$this->add_control(
			"easyjobs_job_apply_button",
			[
				'label'     => __( 'Job Apply Button', EASYJOBS_TEXTDOMAIN ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => "easyjobs_job_apply_button_typography",
				'label'    => __( 'Typography', EASYJOBS_TEXTDOMAIN ),
				'selector' => '{{WRAPPER}} .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-apply-btn .ej-info-btn-light',
			]
		);

		$this->add_responsive_control(
			'easyjobs_job_apply_btn_alignment',
			[
				'label'        => esc_html__( 'Alignment', EASYJOBS_TEXTDOMAIN ),
				'type'         => Controls_Manager::CHOOSE,
				'label_block'  => true,
				'options'      => [
					'left'   => [
						'title' => esc_html__( 'Left', EASYJOBS_TEXTDOMAIN ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', EASYJOBS_TEXTDOMAIN ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', EASYJOBS_TEXTDOMAIN ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'prefix_class' => 'ej-job-apply-btn-alignment-',
				'default'      => 'center',
			]
		);

		$this->start_controls_tabs( "easyjobs_job_apply_tabs_button_style" );

		$this->start_controls_tab(
			'easyjobs_job_apply_tab_button_normal',
			[
				'label' => __( 'Normal', EASYJOBS_TEXTDOMAIN ),
			]
		);

		$this->add_control(
			'easyjobs_job_apply_button_color',
			[
				'label'     => __( 'Text Color', EASYJOBS_TEXTDOMAIN ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-apply-btn .ej-info-btn-light' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'easyjobs_job_apply_background_color',
			[
				'label'     => __( 'Background Color', EASYJOBS_TEXTDOMAIN ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-apply-btn .ej-info-btn-light' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'easyjobs_job_apply_tab_button_hover',
			[
				'label' => __( 'Hover', EASYJOBS_TEXTDOMAIN ),
			]
		);

		$this->add_control(
			'easyjobs_job_apply_button_color_hover',
			[
				'label'     => __( 'Text Color', EASYJOBS_TEXTDOMAIN ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-apply-btn .ej-info-btn-light:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'easyjobs_job_apply_button_background_color_hover',
			[
				'label'     => __( 'Background Color', EASYJOBS_TEXTDOMAIN ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-apply-btn .ej-info-btn-light:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'easyjobs_job_apply_button_border',
				'selector'  => '{{WRAPPER}} .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-apply-btn .ej-info-btn-light',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'easyjobs_job_apply_button_border_radius',
			[
				'label'      => __( 'Border Radius', EASYJOBS_TEXTDOMAIN ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-apply-btn .ej-info-btn-light' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'easyjobs_job_apply_button_box_shadow',
				'selector' => '{{WRAPPER}} .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-apply-btn .ej-info-btn-light',
			]
		);

		$this->add_responsive_control(
			'easyjobs_job_apply_button_box_padding',
			[
				'label'      => __( 'Padding', EASYJOBS_TEXTDOMAIN ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-apply-btn .ej-info-btn-light' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);
	}


	protected function render() {
		if ( ! $this->get_token() ) {
			printf( "<h2 class='elej-error-msg'>%s</h2>", 'Please add API key' );

			return;
		}
		$settings = $this->get_settings_for_display();
		$this->add_render_attribute(
			'easyjobs-job-list',
			'class',
			[
				'ej-job-body',
				'easyjobs-elementor',
				'easyjobs-elementor-job-list'
			]
		);
		$icon = '<i class="eicon e-briefcase"></i>';
		if ( ! empty( $settings['easyjobs_job_list_heading_icon']['value'] ) ) {
			ob_start();
			Icons_Manager::render_icon( $settings['easyjobs_job_list_heading_icon'] );
			$icon = ob_get_clean();
		}
		?>

        <div <?php echo $this->get_render_attribute_string( 'easyjobs-job-list' ); ?>>
            <div class="ej-section">
                <div class="ej-section-title">
					<?php if ( $settings['easyjobs_job_list_heading_icon_control'] !== 'yes' ): ?>
                        <span class="ej-section-title-icon"><?php echo $icon; ?></span>
					<?php endif; ?>
					<?php if ( $settings['easyjobs_job_list_title_control'] !== 'yes' ): ?>
                        <span class="ej-section-title-text"><?php echo $settings['easyjobs_job_list_title']; ?></span>
					<?php endif; ?>
                </div>
                <div class="ej-section-content">
					<?php $this->job_list_template(); ?>
                </div>
            </div>
        </div>
		<?php
	}
}