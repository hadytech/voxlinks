<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Widget_Base;
use \Elementor\Plugin;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Border as Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow as Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography as Group_Control_Typography;

class Easyjobs_Elementor_Landingpage extends Widget_Base {
	use Easyjobs_Elementor_Template;

	protected $is_editor;
	protected $company_info;

	public function __construct( $data = [], $args = null ) {
		parent::__construct( $data, $args );
		$this->is_editor = Plugin::$instance->editor->is_edit_mode();
	}

	public function get_name() {
		return 'easyjobs-landingpage';
	}

	public function get_title() {
		return esc_html__( 'Easyjobs Landing Page', 'easyjobs' );
	}

	public function get_icon() {
		return 'eicon-post-info';
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
	 * Get company info from api
	 *
	 * @return object|bool
	 * @since 1.0.0
	 */
	private function get_company_info() {

		if ( ! $this->is_editor ) {
			$company_info = Easyjobs_Api::get( 'company' );

			return ( ! empty( $company_info ) && $company_info->status == 'success' ) ? $company_info->data : [];
		}

		//cache only editor mode
		$key     = 'elej_company_' . md5( $this->get_token() );
		$company = get_transient( $key );
		if ( empty( $company ) ) {
			$company_info = Easyjobs_Api::get( 'company' );
			if ( ! empty( $company_info ) && $company_info->status == 'success' ) {
				$company = $company_info->data;
				set_transient( $key, $company, 0.5 * HOUR_IN_SECONDS );
			}
		}

		return $company;
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
		$this->content_company_image_control();
		$this->content_job_list_control();
		$this->content_cange_text();

		//style tab
		$this->style_general_controls();
		$this->style_section_controls();
		$this->style_company_info_control();
		$this->style_job_list_control();
	}

	public function content_company_image_control() {
		$this->start_controls_section(
			'section_easyjobs_info_box',
			[
				'label' => __( 'EasyJobs', EASYJOBS_TEXTDOMAIN ),
			]
		);

		$this->add_control(
			'easyjobs_company_details_control',
			[
				'label'        => __( 'Hide Company Details', EASYJOBS_TEXTDOMAIN ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', EASYJOBS_TEXTDOMAIN ),
				'label_off'    => __( 'No', EASYJOBS_TEXTDOMAIN ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'easyjobs_cover_image_control',
			[
				'label'        => __( 'Change Cover Image', EASYJOBS_TEXTDOMAIN ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', EASYJOBS_TEXTDOMAIN ),
				'label_off'    => __( 'No', EASYJOBS_TEXTDOMAIN ),
				'return_value' => 'yes',
				'condition'    => [
					'easyjobs_company_details_control!' => 'yes'
				]
			]
		);

		$this->add_control(
			'easyjobs_cover_image',
			[
				'label'     => __( 'Upload Cover Image', EASYJOBS_TEXTDOMAIN ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'easyjobs_cover_image_control'      => 'yes',
					'easyjobs_company_details_control!' => 'yes'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'easyjobs_cover_image',
				'default'   => 'large',
				'separator' => 'none',
				'condition' => [
					'easyjobs_cover_image_control'      => 'yes',
					'easyjobs_company_details_control!' => 'yes'
				]
			]
		);

		$this->add_control(
			'easyjobs_logo_control',
			[
				'label'        => __( 'Change Logo', EASYJOBS_TEXTDOMAIN ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', EASYJOBS_TEXTDOMAIN ),
				'label_off'    => __( 'No', EASYJOBS_TEXTDOMAIN ),
				'return_value' => 'yes',
				'condition'    => [
					'easyjobs_company_details_control!' => 'yes'
				]
			]
		);
		$this->add_control(
			'easyjobs_logo',
			[
				'label'     => __( 'Upload Cover Image', EASYJOBS_TEXTDOMAIN ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'easyjobs_logo_control'             => 'yes',
					'easyjobs_company_details_control!' => 'yes'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'easyjobs_logo',
				'default'   => 'large',
				'separator' => 'none',
				'condition' => [
					'easyjobs_logo_control'             => 'yes',
					'easyjobs_company_details_control!' => 'yes'
				]
			]
		);

		$this->add_control(
			'easyjobs_job_list_control',
			[
				'label'        => __( 'Hide Job List', EASYJOBS_TEXTDOMAIN ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', EASYJOBS_TEXTDOMAIN ),
				'label_off'    => __( 'No', EASYJOBS_TEXTDOMAIN ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'easyjobs_company_gallery_control',
			[
				'label'        => __( 'Hide Company Gallery', EASYJOBS_TEXTDOMAIN ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', EASYJOBS_TEXTDOMAIN ),
				'label_off'    => __( 'No', EASYJOBS_TEXTDOMAIN ),
				'return_value' => 'yes',
			]
		);

		$this->end_controls_section();
	}

	public function content_job_list_control() {
		$this->start_controls_section(
			'easyjobs_job_list_query',
			[
				'label'     => __( 'Job List', EASYJOBS_TEXTDOMAIN ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'easyjobs_job_list_control!' => 'yes'
				]
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
				'default'      => 'no',

			]
		);

		$this->end_controls_section();
	}

	public function content_cange_text() {
		$this->start_controls_section(
			'easyjobs_section_text_cahnge',
			[
				'label' => __( 'Text Change', EASYJOBS_TEXTDOMAIN ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'easyjobs_company_name',
			[
				'label'       => __( 'Company Name', EASYJOBS_TEXTDOMAIN ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( '', EASYJOBS_TEXTDOMAIN ),
				'placeholder' => __( 'Enter Company Name', EASYJOBS_TEXTDOMAIN ),
			]
		);

		$this->add_control(
			'easyjobs_website_link_text',
			[
				'label'       => __( 'Website Link Text', EASYJOBS_TEXTDOMAIN ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Explore company website', EASYJOBS_TEXTDOMAIN ),
				'placeholder' => __( 'Explore company website', EASYJOBS_TEXTDOMAIN ),
			]
		);

		$this->add_control(
			'easyjobs_joblist_heading',
			[
				'label'       => __( 'Job List Section Title', EASYJOBS_TEXTDOMAIN ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Open job positions', EASYJOBS_TEXTDOMAIN ),
				'placeholder' => __( 'Open job positions', EASYJOBS_TEXTDOMAIN ),
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

		$this->add_control(
			'easyjobs_gallery_section_text',
			[
				'label'       => __( 'Gallery Section Title', EASYJOBS_TEXTDOMAIN ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Life at', EASYJOBS_TEXTDOMAIN ),
				'placeholder' => __( 'Life at', EASYJOBS_TEXTDOMAIN ),
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
				'name'     => 'easyjobs_landingpage_background',
				'label'    => __( 'Background', EASYJOBS_TEXTDOMAIN ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .easyjobs-elementor,{{WRAPPER}} .easyjobs-elementor .ej-header,{{WRAPPER}} .easyjobs-elementor .ej-job-list-item',
			]
		);

		$this->add_responsive_control(
			'easyjobs_landingpage_alignment',
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
			'easyjobs_landingpage_width',
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
			"easyjobs_landingpage_margin",
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
			"easyjobs_landingpage_padding",
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

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'easyjobs_landingpage_boxshadow',
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
			'easyjobs_landingpage_section_icon',
			[
				'label'     => __( 'Section Icon', EASYJOBS_TEXTDOMAIN ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'easyjobs_landingpage_section_icon_width',
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
			'easyjobs_landingpage_section_icon_height',
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
			'easyjobs_landingpage_section_icon_size',
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
	 * prints controls for managing Company details
	 */
	public function style_company_info_control() {
		$this->start_controls_section( 'section_style_company_info', [
			'label' => __( 'Company Info', EASYJOBS_TEXTDOMAIN ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );
		$this->add_control(
			'easyjobs_landingpage_company_title',
			[
				'label'     => __( 'Title', EASYJOBS_TEXTDOMAIN ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'easyjobs_company_title_text_color',
			[
				'label'     => esc_html__( 'Text Color', EASYJOBS_TEXTDOMAIN ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ej-company-info .name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'easyjobs_company_title_text_typography',
				'label'    => __( 'Typography', EASYJOBS_TEXTDOMAIN ),
				'selector' => '{{WRAPPER}} .ej-company-info .name',
			]
		);

		$this->add_control(
			'easyjobs_landingpage_company_location',
			[
				'label'     => __( 'Location', EASYJOBS_TEXTDOMAIN ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'easyjobs_company_location_color',
			[
				'label'     => esc_html__( 'Color', EASYJOBS_TEXTDOMAIN ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ej-company-info .location' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'easyjobs_company_location_typography',
				'label'    => __( 'Typography', EASYJOBS_TEXTDOMAIN ),
				'selector' => '{{WRAPPER}} .ej-company-info .location',
			]
		);

		$this->style_company_link_button();

		$this->add_control(
			'easyjobs_landingpage_company_description',
			[
				'label'     => __( 'Description', EASYJOBS_TEXTDOMAIN ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'easyjobs_company_description_align',
			[
				'label'     => __( 'Alignment', EASYJOBS_TEXTDOMAIN ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'    => [
						'title' => __( 'Left', EASYJOBS_TEXTDOMAIN ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'  => [
						'title' => __( 'Center', EASYJOBS_TEXTDOMAIN ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'   => [
						'title' => __( 'Right', EASYJOBS_TEXTDOMAIN ),
						'icon'  => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', EASYJOBS_TEXTDOMAIN ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ej-company-description' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'easyjobs_company_description_text_color',
			[
				'label'     => esc_html__( 'Color', EASYJOBS_TEXTDOMAIN ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ej-company-description' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'easyjobs_company_description_text_typography',
				'label'    => __( 'Typography', EASYJOBS_TEXTDOMAIN ),
				'selector' => '{{WRAPPER}} .ej-company-description',
			]
		);

		$this->end_controls_section();
	}


	/**
	 * prints controls for managing Button style
	 */
	public function style_company_link_button() {

		$this->add_control(
			"easyjobs_landingpage_company_button",
			[
				'label'     => __( 'Website Link Button', EASYJOBS_TEXTDOMAIN ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => "easyjobs_company_button_typography",
				'label'    => __( 'Typography', EASYJOBS_TEXTDOMAIN ),
				'selector' => '{{WRAPPER}} .ej-header-tools .ej-info-btn',
			]
		);

		$this->start_controls_tabs( "easyjobs_company_tabs_button_style" );

		$this->start_controls_tab(
			'easyjobs_company_tab_button_normal',
			[
				'label' => __( 'Normal', EASYJOBS_TEXTDOMAIN ),
			]
		);

		$this->add_control(
			'easyjobs_company_button_color',
			[
				'label'     => __( 'Text Color', EASYJOBS_TEXTDOMAIN ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .ej-header-tools .ej-info-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label'     => __( 'Background Color', EASYJOBS_TEXTDOMAIN ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1fb6d7',
				'selectors' => [
					'{{WRAPPER}} .ej-header-tools .ej-info-btn' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'easyjobs_company_tab_button_hover',
			[
				'label' => __( 'Hover', EASYJOBS_TEXTDOMAIN ),
			]
		);

		$this->add_control(
			'easyjobs_company_button_color_hover',
			[
				'label'     => __( 'Text Color', EASYJOBS_TEXTDOMAIN ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .ej-header-tools .ej-info-btn:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'easyjobs_company_button_background_color_hover',
			[
				'label'     => __( 'Background Color', EASYJOBS_TEXTDOMAIN ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1fb6d7',
				'selectors' => [
					'{{WRAPPER}} .ej-header-tools .ej-info-btn:hover' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'easyjobs_company_button_border',
				'selector'  => '{{WRAPPER}} .ej-header-tools .ej-info-btn',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'easyjobs_company_button_border_radius',
			[
				'label'      => __( 'Border Radius', EASYJOBS_TEXTDOMAIN ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ej-header-tools .ej-info-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'easyjobs_company_button_box_shadow',
				'selector' => '{{WRAPPER}} .ej-header-tools .ej-info-btn',
			]
		);

		$this->add_responsive_control(
			'easyjobs_company_button_box_padding',
			[
				'label'      => __( 'Padding', EASYJOBS_TEXTDOMAIN ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ej-header-tools .ej-info-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);
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
				'size_units' => [ 'px', 'em', '%' ],
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
					'{{WRAPPER}} .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-title a' => 'color: {{VALUE}};',
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
			'easyjobs_joblist_category_color',
			[
				'label'     => __( 'Color', EASYJOBS_TEXTDOMAIN ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner .ej-job-list-info-block.ej-job-list-company-name i,{{WRAPPER}} .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner .ej-job-list-info-block.ej-job-list-company-name a' => 'color: {{VALUE}} !important',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'easyjobs_joblist_category_typography',
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
					'{{WRAPPER}} .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner .ej-job-list-info-block.ej-job-list-location i,{{WRAPPER}} .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner .ej-job-list-info-block.ej-job-list-location span' => 'color: {{VALUE}} !important;',
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
					'{{WRAPPER}} .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner .ej-job-list-item-col .ej-list-sub' => 'color: {{VALUE}} !important;',
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
		$error_msg = __( 'No Jobs Found', EASYJOBS_TEXTDOMAIN );
		if ( ! $this->get_token() ) {
			printf( "<h2 class='elej-error-msg'>%s</h2>", 'Please add API key' );

			return;
		}
		$settings = $this->get_settings_for_display();
		$company  = $this->get_company_info();
		if ( empty( $company ) ) {
			printf( "<h2 class='elej-error-msg'>%s</h2>", $error_msg );

			return;
		}
		$this->add_render_attribute( 'easyjobs-elementor', 'class', 'easyjobs-elementor' );

		//change cover image
		if ( $settings['easyjobs_cover_image_control'] === 'yes' && $settings['easyjobs_cover_image']['url'] !== '' ) {
			$company->cover_photo[0] = Group_Control_Image_Size::get_attachment_image_src( $settings['easyjobs_cover_image']['id'],
				'easyjobs_cover_image', $settings );
		}

		//change logo
		if ( $settings['easyjobs_logo_control'] === 'yes' && $settings['easyjobs_logo']['url'] !== '' ) {
			$company->logo = Group_Control_Image_Size::get_attachment_image_src( $settings['easyjobs_logo']['id'],
				'easyjobs_logo', $settings );
		}

		$this->company_info = $company;
		$content            = "<div {$this->get_render_attribute_string('easyjobs-elementor')}>";
		ob_start();
		$this->company_info_template();
		$content .= ob_get_clean();
		$content .= "</div>";
		echo $content;
	}
}