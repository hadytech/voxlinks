<?php
namespace ReviewX\Elementor\Elements;

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Plugin;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Utils;
use \Elementor\Widget_Base;
use ReviewX\Constants\Reviewx;

/**
 * Class Data_Tabs
 * @package ReviewX\Elementor\Elements
 */
class Data_Tabs extends Widget_Base
{

    /**
     * @return string
     */
    public function get_name()
    {
        return 'rx-review-data-tab';
    }

    /**
     * @return string|void
     */
    public function get_title()
    {
        return __('ReviewX Product Data Tabs', 'reviewx');
    }

    /**
     * @return string
     */
    public function get_icon()
    {
        return 'eicon-review';
    }

    /**
     * @return array|string[]
     */
    public function get_categories()
    {
        return ['rx-addons-elementor'];
    }

    /**
     * @return array
     */
    public function get_keywords()
    {
        return [
            'reviewx',
            'woo review',
            'woo',
            'woocommerce',
            'comment',
            'review',
            'addons',
            'ea',
            'essential addons'
        ];
    }

    /**
     * @return string
     */
    public function get_custom_help_url()
    {
        return esc_url('https://reviewx.io/docs');
	}

    /**
     * @param $styles
     * @param bool $group
     * @return array|array[]|mixed
     */
	private function get_options_by_groups( $styles, $group = false )
    {
		$groups = [
			'line' => [
				'label' => __( 'Line', 'reviewx' ),
				'options' => [
					'solid' => __( 'Solid', 'reviewx' ),
					'double' => __( 'Double', 'reviewx' ),
					'dotted' => __( 'Dotted', 'reviewx' ),
					'dashed' => __( 'Dashed', 'reviewx' ),
				],
			],
		];
		foreach ( $styles as $key => $style ) {
			if ( ! isset( $groups[ $style['group'] ] ) ) {
				$groups[ $style['group'] ] = [
					'label' => ucwords( str_replace( '_', '', $style['group'] ) ),
					'options' => [],
				];
			}
			$groups[ $style['group'] ]['options'][ $key ] = $style['label'];
		}

		if ( $group && isset( $groups[ $group ] ) ) {
			return $groups[ $group ];
		}
		return $groups;
	}

    /**
     * @param $array
     * @param $key
     * @param $value
     * @return array
     */
	private function filter_styles_by( $array, $key, $value )
    {
		return array_filter( $array, function( $style ) use ( $key, $value ) {
			return $value === $style[ $key ];
		} );
	}

    /**
     * Register Controls
     * @return void
     */
    protected function _register_controls()
    {

		$styles = '';
        $this->start_controls_section(
			'rx_section_review_tabs_style',
			[
				'label' => __( 'Tabs', 'reviewx' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'rx_wc_style_warning',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => __( 'The style of this widget is often affected by your theme and plugins. If you experience any such issue, try to switch to a basic theme and deactivate related plugins.', 'reviewx' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);

		$this->start_controls_tabs( 'tabs_style' );

		$this->start_controls_tab( 'normal_tabs_style',
			[
				'label' => __( 'Normal', 'reviewx' ),
			]
		);

		$this->add_control(
			'rx_tab_text_color',
			[
				'label' => __( 'Text Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rx_tab_bg_color',
			[
				'label' => __( 'Background Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'alpha' => false,
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rx_tabs_border_color',
			[
				'label' => __( 'Border Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-tabs .woocommerce-Tabs-panel' => 'border-color: {{VALUE}}',
					'.woocommerce {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'active_tabs_style',
			[
				'label' => __( 'Active', 'reviewx' ),
			]
		);

		$this->add_control(
			'rx_active_tab_text_color',
			[
				'label' => __( 'Text Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li.active a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rx_active_tab_bg_color',
			[
				'label' => __( 'Background Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'alpha' => false,
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-tabs .woocommerce-Tabs-panel, .woocommerce {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li.active' => 'background-color: {{VALUE}}',
					'.woocommerce {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li.active' => 'border-bottom-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rx_active_tabs_border_color',
			[
				'label' => __( 'Border Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-tabs .woocommerce-Tabs-panel' => 'border-color: {{VALUE}}',
					'.woocommerce {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li.active' => 'border-color: {{VALUE}} {{VALUE}} {{active_tab_bg_color.VALUE}} {{VALUE}}',
					'.woocommerce {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li:not(.active)' => 'border-bottom-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'rx_separator_tabs_style',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'rx_tab_typography',
				'label' => __( 'Typography', 'reviewx' ),
				'selector' => '.woocommerce {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li a',
			]
		);

		$this->add_control(
			'rx_tab_border_radius',
			[
				'label' => __( 'Border Radius', 'reviewx' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li' => 'border-radius: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0 0',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'rx_section_product_panel_style',
			[
				'label' => __( 'Panel', 'reviewx' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'rx_text_color',
			[
				'label' => __( 'Text Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'rx_content_typography',
				'label' => __( 'Typography', 'reviewx' ),
				'selector' => '.woocommerce {{WRAPPER}} .woocommerce-tabs .woocommerce-Tabs-panel',
			]
		);

		$this->add_control(
			'rx_heading_panel_heading_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Heading', 'reviewx' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'rx_heading_color',
			[
				'label' => __( 'Text Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel h2' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'rx_content_heading_typography',
				'label' => __( 'Typography', 'reviewx' ),
				'selector' => '.woocommerce {{WRAPPER}} .woocommerce-tabs .woocommerce-Tabs-panel h2',
			]
		);

		$this->add_control(
			'rx_separator_panel_style',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'rx_panel_border_width',
			[
				'label' => __( 'Border Width', 'reviewx' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-tabs .woocommerce-Tabs-panel' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; margin-top: -{{TOP}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'rx_panel_border_radius',
			[
				'label' => __( 'Border Radius', 'reviewx' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-tabs .woocommerce-Tabs-panel' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					'.woocommerce {{WRAPPER}} .woocommerce-tabs ul.wc-tabs' => 'margin-left: {{TOP}}{{UNIT}}; margin-right: {{RIGHT}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'rx_panel_box_shadow',
				'selector' => '.woocommerce {{WRAPPER}} .woocommerce-tabs .woocommerce-Tabs-panel',
			]
		);

		$this->end_controls_section();		

		/*========================== 
		*
		* Review Style Controller Begin
		*
		============================*/

		$this->start_controls_section(
			'rx_section_title',
			[
				'label' => __( 'Review Section Title', 'reviewx' ),
			]
		);

		$this->add_control(
			'rx_review_section_title',
			[
				'label' => __( 'Section Title', 'reviewx' ),
				'type' => Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'rx_review_section_title_color',
			[
				'label' => __( 'Section Title Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#333333',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .woocommerce-Reviews-title' => 'color: {{VALUE}}',					
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'rx_review_section_title_typography',
				'label' => __( 'Section Title Typography', 'reviewx' ),
				'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .woocommerce-Reviews-title',
			]
		);	

		$this->end_controls_section();		

		$this->start_controls_section(
			'section_product',
			[
				'label' => __( 'Review Template', 'reviewx' ),
			]
		);

		$this->add_control(
			'rx_template_type',
			[
				'label' => __( 'Select Template', 'reviewx' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'template_style_one',
				'options' => [
					'' => '— ' . __( 'Select', 'reviewx' ) . ' —',
					'template_style_one' => __( 'Classic', 'reviewx' ),
					'template_style_two' => __( 'Box Style', 'reviewx' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'rx_section_summary_style',
			[
				'label' => __( 'Review Statistics', 'reviewx' ),
			]
		);

		$this->start_controls_tabs( 'summary_style' );
		
        $this->add_control(
			'rx_average_block_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Average Ratting Section', 'reviewx' ),
				'separator' => 'after',
			]
		);		

		$this->add_control(
			'rx_summary_average_count_color_color',
			[
				'label' => __( 'Average Count Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#333333',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-temp-rating .rx-temp-rating-number p' => 'color: {{VALUE}}',					
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'rx_summary_average_count_typography',
				'label' => __( 'Average Count Typography', 'reviewx' ),
				'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-temp-rating .rx-temp-rating-number p',
			]
		);		
		
		$this->add_control(
			'rx_summary_heighest_rating_point_color',
			[
				'label' => __( 'Highest Rating Point Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#9e9e9e',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-temp-rating .rx-temp-rating-number span' => 'color: {{VALUE}}',					
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'rx_summary_rating_point_typography',
				'label' => __( 'Highest Rating Point Typography', 'reviewx' ),
				'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-temp-rating .rx-temp-rating-number span',
			]
		);
		
		$this->add_control(
			'rx_summary_average_star_rating_color',
			[
				'label' => __( 'Star Rating Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFAF22',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_avg_star_color' => 'fill: {{VALUE}}',					
				],
			]
		);
		
		$this->add_control(
			'rx_summary_star_rating_size',
			[
				'label' => __( 'Star Rating Size', 'reviewx' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
					'size' => 14,
				],
				'selectors' => [					
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-temp-rating-star svg' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}} !important;',					
				],
			]
		);
		
		$this->add_control(
			'rx_summary_average_text_color',
			[
				'label' => __( 'Average Text Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#444',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-temp-total-rating-count p' => 'color: {{VALUE}}',					
				],
			]
		);	
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'rx_summary_average_text_typography',
				'label' => __( 'Average Text Typography', 'reviewx' ),
				'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-temp-total-rating-count p',
			]
		);

        $this->add_control(
			'rx_recommendation_block_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Recommendation Count Section', 'reviewx' ),
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'rx_summary_recommendation_count_color',
			[
				'label' => __( 'Recommendation Count Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#444',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_recommended_box .rx_recommended_box_heading' => 'color: {{VALUE}}',					
				],
			]
		);		
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'rx_summary_recommendation_count_typography',
				'label' => __( 'Recommendation Count Typography', 'reviewx' ),
				'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_recommended_box .rx_recommended_box_heading',
			]
		);

		$this->add_control(
			'rx_summary_recommendation_text_color',
			[
				'label' => __( 'Recommendation Text Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#444',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_recommended_box .rx_recommended_box_content' => 'color: {{VALUE}}',					
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'rx_summary_recommendation_text_typography',
				'label' => __( 'Recommendation Text Typography', 'reviewx' ),
				'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_recommended_box .rx_recommended_box_content',
			]
		);
		
		$this->add_control(
			'rx_summary_separator_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Separator', 'reviewx' ),
				'separator' => 'before',
			]
		);	

		$this->add_control(
			'rx_summary_separator_border_style',
			[
				'label' => __( 'Style', 'reviewx' ),
				'type' => Controls_Manager::SELECT,
				'groups' => array_values( $this->get_options_by_groups( $styles ) ),
				'render_type' => 'template',
				'default' => 'solid',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_recommended_wrapper hr' => 'border-style: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rx_summary_separator_type',
			[
				'type' => Controls_Manager::HIDDEN,
				'default' => 'pattern',
				'prefix_class' => 'elementor-widget-divider--separator-type-',
				'condition' => [
					'style!' => [
						'',
						'solid',
						'double',
						'dotted',
						'dashed',
					],
				],
				'render_type' => 'template',
			]
		);
		
		$this->add_responsive_control(
			'rx_summary_separator_width',
			[
				'label' => __( 'Width', 'reviewx' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range' => [
					'px' => [
						'max' => 1000,
					],
				],
				'default' => [
					'size' => 100,
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_recommended_wrapper hr' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);	
		
		$this->add_control(
			'rx_summary_separator_color',
			[
				'label' => __( 'Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#000',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_recommended_wrapper hr' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rx_summary_separator_weight',
			[
				'label' => __( 'Height', 'reviewx' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 10,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_recommended_wrapper hr' => 'border-width: {{SIZE}}{{UNIT}}',
				],
			]
		);	
		
		$this->add_control(
			'rx_summary_box_shadow_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Section Design', 'reviewx' ),
				'separator' => 'before',
			]
		);				
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'rx_summary_box_shadow_',
				'selector' => '{{WRAPPER}} .woocommerce-Tabs-panel .rx_recommended_wrapper',
			]
		);
		
		$this->add_control(
			'rx_summary_box_border_style',
			[
				'label' => __( 'Border Style', 'reviewx' ),
				'type' => Controls_Manager::SELECT,
				'groups' => array_values( $this->get_options_by_groups( $styles ) ),
				'render_type' => 'template',
				'default' => 'solid',
				'selectors' => [
					'{{WRAPPER}} .woocommerce-Tabs-panel .rx_recommended_wrapper' => 'border-style: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'rx_summary_box_border_color',
			[
				'label' => __( 'Border Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#000',
				'selectors' => [
					'{{WRAPPER}} .woocommerce-Tabs-panel .rx_recommended_wrapper' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rx_summary_box_border_weight',
			[
				'label' => __( 'Border Weight', 'reviewx' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 10,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .woocommerce-Tabs-panel .rx_recommended_wrapper' => 'border-width: {{SIZE}}{{UNIT}}',
				],
			]
		);		

		$this->end_controls_tabs();
		
		$this->end_controls_section();				

		/********************************* 
		* 	Average End
		* *********************************/

		$this->start_controls_section(
			'rx_section_graph_style',
			[
				'label' => __( 'Graph of Review Criteria', 'reviewx' )
			]
		);

		$this->start_controls_tabs( 'graph_style' );

		if( $this->is_pro() ) {

			$this->add_control(
				'rx_graph_type',
				[
					'label' => __( 'Select Graph Style', 'reviewx' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'graph_style_default',
					'options' => [
						'' => '— ' . __( 'Select', 'reviewx' ) . ' —',
						'graph_style_default' => __( 'Horizontal Style One', 'reviewx' ),
						'graph_style_one' => __( 'Horizontal Style Two', 'reviewx' ),
						'graph_style_two_free' => __( 'Horizontal Style Three', 'reviewx' ),
						'graph_style_three' => __( 'Vertical Style One', 'reviewx' ),
						//'graph_style_two' => __( 'Pie Chart Style', 'reviewx' ),
					],
				]
			);

		} else {

			$this->add_control(
				'rx_graph_type',
				[
					'label' => __( 'Select Graph Style', 'reviewx' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'graph_style_default',
					'options' => [
						'' => '— ' . __( 'Select', 'reviewx' ) . ' —',
						'graph_style_default' => __( 'Horizontal Style One', 'reviewx' ),
						'graph_style_one' => __( 'Horizontal Style Two', 'reviewx' ),
						'graph_style_two_free' => __( 'Horizontal Style Three', 'reviewx' ),
										
					],
				]
			);

		}
		
		$this->add_control(
			'rx_summary_graph_text_color',
			[
				'label' => __( 'Criteria Name Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1a1a1a',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-graph-style-2 .progress-bar-t' => 'color: {{VALUE}}', 
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_style_two_free_progress_bar .progressbar-title' => 'color: {{VALUE}}',
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .vertical .vertical_bar_label' => 'color: {{VALUE}}',										
				],
				'condition' => [
					'rx_graph_type' => [ 'graph_style_default', 'graph_style_one', 'graph_style_two_free', 'graph_style_three' ],
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'rx_summary_graph_text_typography',
				'label' => __( 'Criteria Name Typography', 'reviewx' ),
				'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-graph-style-2 .progress-bar-t, 
							   .woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_style_two_free_progress_bar .progressbar-title,
							   .woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .vertical .vertical_bar_label',
				'condition' => [
								'rx_graph_type' => [ 'graph_style_default', 'graph_style_one', 'graph_style_two_free', 'graph_style_three' ],
				],
			]
		);
		
		$this->add_control(
			'rx_summary_graph_color',
			[
				'label' => __( 'Progress-bar Background Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#2f4fff',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-horizontal .progress-fill,
					.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_style_one_progress .rx_style_one_progress-bar,
					.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_style_two_free_progress_bar .progress .progress-bar,
					.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .vertical .progress-fill
					' => 'background-color: {{VALUE}} !important'											
				],
				'condition' => [
					'rx_graph_type' => [ 'graph_style_default', 'graph_style_one', 'graph_style_two_free', 'graph_style_three' ],
				],
			]
		);

		$this->add_control(
			'rx_summary_progress_bar_text_color',
			[
				'label' => __( 'Progress-bar Text Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-horizontal .progress-fill span,
					.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_style_one_progress.orange .rx_style_one_progress-icon, 
					.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_style_one_progress.orange .rx_style_one_progress-value,
					.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_style_two_free_progress_bar .progress .progress-bar span,
					.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .vertical .progress-fill
					' => 'color: {{VALUE}} !important'				
				],
				'condition' => [
					'rx_graph_type' => [ 'graph_style_default', 'graph_style_one', 'graph_style_two_free', 'graph_style_three' ],
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'rx_summary_progress_bar_text_typography',
				'label' => __( 'Progress-bar Text Typography', 'reviewx' ),
				'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-horizontal .progress-fill span,
							.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_style_one_progress.orange .rx_style_one_progress-icon, 
							.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_style_one_progress.orange .rx_style_one_progress-value,
							.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_style_two_free_progress_bar .progress .progress-bar span,
							.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .vertical .progress-fill',
				'condition' => [
					'rx_graph_type' => [ 'graph_style_default', 'graph_style_one', 'graph_style_two_free', 'graph_style_three' ],
				],
			]			
		);
		
		$this->add_control(
			'rx_summary_progress_bar_border_color',
			[
				'label' => __( 'Progress-bar Border Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#2f4fff',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .rx_style_one_progress.orange .rx_style_one_progress-icon, 
					.woocommerce {{WRAPPER}} .rx_style_one_progress.orange .rx_style_one_progress-value
					' => 'border-color: {{VALUE}} !important'				
				],
				'condition' => [
					'rx_graph_type' => [ 'graph_style_one' ],
				],
			]
		);
		
		// $review_criteria	= get_option( '_rx_option_review_criteria' );

		// foreach ( $review_criteria as $key => $single_criteria ) {
		// 	$this->add_control(
		// 		'rx_criteria_color_'.$key.'',
		// 		[
		// 			'label' 	=> $single_criteria,
		// 			'type' 		=> Controls_Manager::COLOR,
		// 			'default' 	=> '#4054B2',
		// 			'selectors' => [
		// 				'rx_criteria_pie' => 'color: {{VALUE}} !important'
		// 			],
		// 			'condition' => [
		// 				'rx_graph_type' => [ 'graph_style_two' ],
		// 			],
		// 		]
		// 	);			

		// }		

		$this->add_control(
			'rx_summary_progress_bar_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Section Design', 'reviewx' ),
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'rx_summary_progress_bar_box_shadow',
				'selector' => '{{WRAPPER}} .woocommerce-Tabs-panel .rx_rating_graph_wrapper',
			]
		);

		$this->add_control(
			'rx_summary_progress_bar_box_border_style',
			[
				'label' => __( 'Border Style', 'reviewx' ),
				'type' => Controls_Manager::SELECT,
				'groups' => array_values( $this->get_options_by_groups( $styles ) ),
				'render_type' => 'template',
				'default' => 'solid',
				'selectors' => [
					'{{WRAPPER}} .woocommerce-Tabs-panel .rx_rating_graph_wrapper' => 'border-style: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'rx_summary_progress_bar_box_border_color',
			[
				'label' => __( 'Border Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#000',
				'selectors' => [
					'{{WRAPPER}} .woocommerce-Tabs-panel .rx_rating_graph_wrapper' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rx_summary_progress_bar_box_border_weight',
			[
				'label' => __( 'Border Weight', 'reviewx' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 10,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .woocommerce-Tabs-panel .rx_rating_graph_wrapper' => 'border-width: {{SIZE}}{{UNIT}}',
				],
			]
		);		
		
		$this->end_controls_tabs();
		
		$this->end_controls_section();

		/********************************* 
		* 	Graph End
		* *********************************/

		/*=======================
		* Call template style
		* 
		=========================*/	
		 
		$this->template_one_style();
		$this->template_two_style();		

	}

    /**
     * @return bool
     */
	public static function is_pro()
    {
        return class_exists('ReviewXPro');
    }

    /**
     * Template One Style
     * @return void
     */
	protected function template_one_style()
    {
		$this->start_controls_section(
			'rx_template_one_section_filter',
			[
				'label' => __( 'Filtering Bar', 'reviewx' ),
				'condition' => [
					'rx_template_type' => [ 'template_style_one' ],
				],
			]
		);

		$this->start_controls_tabs( 'template_one_filter' );

		$this->add_control(
			'rx_template_one_filter_text_color',
			[
				'label' => __( 'Text Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#676767',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-filter-bar .rx_filter_header h4, 
					.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-filter-bar .rx-short-by h4' => 'color: {{VALUE}}',										
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'rx_template_one_filter_text_typography',
				'label' => __( 'Text Typography', 'reviewx' ),
				'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-filter-bar .rx_filter_header h4,
							   .woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-filter-bar .rx-short-by h4',
			]
		);

		$this->add_control(
			'rx_template_one_dropdown_bg_color',
			[
				'label' => __( 'Dropdown Background Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-filter-bar .rx_review_shorting_2 .box select' => 'background-color: {{VALUE}} !important',					
				],
			]
		);
		
		$this->add_control(
			'rx_template_one_dropdown_text_color',
			[
				'label' => __( 'Dropdown Text Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#373747',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-filter-bar .rx_review_shorting_2 .box select' => 'color: {{VALUE}} !important',					
				],
			]
		);		
		
		$this->add_control(
			'rx_template_one_dropdown_icon_color',
			[
				'label' => __( 'Dropdown Selector Icon Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-filter-bar .rx_review_shorting_2 .box .rx-selection-arrow b' => 'border-color: {{VALUE}} transparent transparent transparent !important',					
				],
			]
		);			
		
		$this->add_control(
			'rx_template_one_filter_bar_color',
			[
				'label' => __( 'Dropdown Bar Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#2f4fff',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-filter-bar .rx_review_shorting_2 .box .rx-selection-arrow' => 'background-color: {{VALUE}} !important',					
				],
			]
		);
		
		$this->add_control(
			'rx_template_one_filter_bg_color',
			[
				'label' => __( 'Filter Background Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ececec',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-filter-bar' => 'background-color: {{VALUE}}',					
				],
			]
		);		
		
		$this->add_control(
			'rx_template_one_filter_box_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Section Design', 'reviewx' ),
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'rx_template_one_filter_box_shadow',
				'selector' => '{{WRAPPER}} .woocommerce-Tabs-panel .rx-filter-bar',
			]
		);


		$this->end_controls_tabs();

		$this->end_controls_section();

		/*=======================
		* End Filter Style
		* Start Review Style
		=========================*/	

		$this->start_controls_section(
			'rx_template_one_section_review_style',
			[
				'label' => __( 'Review Item', 'reviewx' ),
				'condition' => [
					'rx_template_type' => [ 'template_style_one' ],
				],
			]
		);

		$this->start_controls_tabs( 'template_one_review_style' );

		$this->add_control(
			'rx_template_one_author_block_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Reviewer Information', 'reviewx' ),
				'separator' => 'after',
			]
		);
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'rx_template_one_author_box_shadow',
				'selector' => '.woocommerce {{WRAPPER}} .woocommerce-tabs .woocommerce-Tabs-panel .rx_listing .rx_review_block .rx_thumb',
			]
		);
		
		$this->add_control(
			'rx_template_one_author_border_style',
			[
				'label' => __( 'Avatar Border Style', 'reviewx' ),
				'type' => Controls_Manager::SELECT,
				'groups' => array_values( $this->get_options_by_groups( $styles ) ),
				'render_type' => 'template',
				'default' => 'solid',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-tabs .woocommerce-Tabs-panel .rx_listing .rx_review_block .rx_thumb' => 'border-style: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'rx_template_one_author_border_color',
			[
				'label' => __( 'Avatar Border Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#000',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-tabs .woocommerce-Tabs-panel .rx_listing .rx_review_block .rx_thumb' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rx_template_one_author_border_weight',
			[
				'label' => __( 'Avatar Border Weight', 'reviewx' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 10,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-tabs .woocommerce-Tabs-panel .rx_listing .rx_review_block .rx_thumb' => 'border-width: {{SIZE}}{{UNIT}}',
				],
			]
		);		

		$this->add_control(
			'rx_template_one_author_color',
			[
				'label' => __( 'Reviewer Name Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#373747',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .rx_review_block .rx_author_info .rx_author_name h4' => 'color: {{VALUE}}',					
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'rx_template_one_author_typography',
				'label' => __( 'Reviewer Name Typography', 'reviewx' ),
				'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .rx_review_block .rx_author_info .rx_author_name h4',
			]
		);
		
		/********************************* 
		* 	Author End
		* *********************************/
		
		$this->add_control(
			'rx_template_one_main_content_block_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Main Content', 'reviewx' ),
				'separator' => 'before',
			]
		);		


		$this->add_control(
			'rx_template_one_rating_color',
			[
				'label' => __( 'Rating Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFAF22',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_review_sort_list .rx_listing_container .rx_listing .rx_avg_star_color' => 'fill: {{VALUE}}',					
				],
			]
		);	
		
		$this->add_control(
			'rx_template_one_rating_size',
			[
				'label' => __( 'Star Rating Size', 'reviewx' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
					'size' => 14,
				],
				'selectors' => [					
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .rx_review_block .rx_body .review_rating svg' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}} !important;',					
				],
			]
		);		

		$this->add_control(
			'rx_template_one_title_color',
			[
				'label' => __( 'Review Title Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#373747',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .rx_review_block .review_title' => 'color: {{VALUE}}',					
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'rx_template_one_title_typography',
				'label' => __( 'Review Title Typography', 'reviewx' ),
				'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .rx_review_block .review_title',
			]
		);

		$this->add_control(
			'rx_template_one_text_color',
			[
				'label' => __( 'Review Comments Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#9B9B9B',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .rx_review_block .rx_body p' => 'color: {{VALUE}}',					
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'rx_template_one_text_typography',
				'label' => __( 'Review Comments Typography', 'reviewx' ),
				'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .rx_review_block .rx_body p',
			]
		);		

		/********************************* 
		* 	Review Comments End
		* *********************************/			
		
		$this->add_control(
			'rx_template_one_text_block_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Meta Information', 'reviewx' ),
				'separator' => 'before',
			]
		);	

		$this->add_control(
			'rx_template_one_date_icon_color',
			[
				'label' => __( 'Reviewed Date Icon Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#707070',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .rx_review_block .rx_body .rx_review_calender svg .st0' => 'fill: {{VALUE}} !important',
				],
			]
		);		
		
		$this->add_control(
			'rx_template_one_date_color',
			[
				'label' => __( 'Reviewed Date Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#6d6d6d',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .rx_review_block .rx_body .rx_review_calender' => 'color: {{VALUE}}',					
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'rx_template_one_date_typography',
				'label' => __( 'Reviewed Date Typography', 'reviewx' ),
				'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .rx_review_block .rx_body .rx_review_calender',
			]
		);

		$this->add_control(
			'rx_template_one_verified_icon_color',
			[
				'label' => __( 'Verified Badge Icon Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#12D585',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .rx_review_block .rx_body .rx_varified .rx_varified_user svg .st0' => 'fill: {{VALUE}}',
				],
			]
		);					
		
		$this->add_control(
			'rx_template_one_verified_color',
			[
				'label' => __( 'Verified Text Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#12D585',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .rx_review_block .rx_body .rx_varified .rx_varified_user span' => 'color: {{VALUE}}',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'rx_template_one_verified_typography',
				'label' => __( 'Verified Text Typography', 'reviewx' ),
				'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .rx_review_block .rx_body .rx_varified .rx_varified_user span',

			]
		);		

		if( $this->is_pro() ) {
		
			$this->add_control(
				'rx_template_one_helpful_color',
				[
					'label' => __( 'Helpful Text Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#333',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .rx_review_block .rx_body .rx_meta .rx_review_vote_icon p' => 'color: {{VALUE}}',					
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'rx_template_one_helpful_typography',
					'label' => __( 'Helpful Typography', 'reviewx' ),
					'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .rx_review_block .rx_body .rx_meta .rx_review_vote_icon p',
				]
			);

			$this->add_control(
				'rx_template_one_helpful_bg_color',
				[
					'label' => __( 'Helpful Button Background Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#eaeaea',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .rx_review_vote_icon .like' => 'background-color: {{VALUE}}',					
					],
				]
			);				

			$this->add_control(
				'rx_template_one_helpful_icon_color',
				[
					'label' => __( 'Helpful Thumbs-up Icon Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#A4A4A4',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .rx_helpful_style_1_svg svg' => 'fill: {{VALUE}} !important',					
					],
				]
			);		
			
			$this->add_control(
				'rx_template_one_helpful_count_color',
				[
					'label' => __( 'Helpful Thumbs-up Count Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#696969',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .rx_review_vote_icon .like .rx_helpful_count_val' => 'color: {{VALUE}} !important',				
					],
				]
			);			
			
			$this->add_control(
				'rx_template_one_share_color',
				[
					'label' => __( 'Share Text Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#333',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .rx_review_block .rx_body .rx_meta .rx_share p' => 'color: {{VALUE}}',					
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'rx_template_one_share_typography',
					'label' => __( 'Share Typography', 'reviewx' ),
					'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .rx_review_block .rx_body .rx_meta .rx_share p',
				]
			);
			
			$this->add_control(
				'rx_template_one_share_icon_color',
				[
					'label' => __( 'Share Icon Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#000',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .social-links .wc_rx_btns ul li:nth-child(1) svg' => 'fill: {{VALUE}}',
					],
				]
			);		

			$this->add_control(
				'rx_template_one_facebook_color',
				[
					'label' => __( 'Facebook Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#B7B7B8',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .social-links .wc_rx_btns ul li:nth-child(2) a svg .st0' => 'fill: {{VALUE}}',					
					],
				]
			);	
			
			$this->add_control(
				'rx_template_one_twitter_color',
				[
					'label' => __( 'Twitter Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#B7B7B8',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .social-links .wc_rx_btns ul li:nth-child(3) a svg .st0' => 'fill: {{VALUE}}',					
					],
				]
			);			

			$this->add_control(
				'rx_template_one_top_border_color',
				[
					'label' => __( 'Review Top border Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#ececec',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .rx_review_block + .rx_review_block' => 'border-top: 2px solid {{VALUE}}',					
					],
				]
			);
			
			$this->add_control(
				'rx_template_one_highlight_color',
				[
					'label' => __( 'Highlight Border Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#ececec',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .reviewx_highlight_comment' => 'border-color: {{VALUE}} !important',					
					],
				]
			);
		
		}
		
		$this->add_control(
			'rx_template_one_attachement_block_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Review Attachment', 'reviewx' ),
				'separator' => 'before',
			]
		);	
		
		$this->add_responsive_control(
			'rx_template_one_attachement_position',
			[
				'label' => __( 'Select Attachment Position', 'reviewx' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => __( 'Left', 'reviewx' ),
						'icon' => 'eicon-text-align-left',
					],
					'flex-end' => [
						'title' => __( 'Right', 'reviewx' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .rx_review_block .rx_body .rx_photos' => 'justify-content: {{VALUE}} !important;',
				],
			]
		);	
		
		$this->add_control(
			'rx_template_one_background_block_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Review Background', 'reviewx' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'rx_template_one_review_bg_color',
			[
				'label' => __( 'Review Container Background Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_container' => 'background-color: {{VALUE}}',					
				],
			]
		);		

		$this->add_control(
			'rx_template_one_review_border_color',
			[
				'label' => __( 'Review Container Border Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ececec',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_container' => 'border-color: {{VALUE}}',					
				],
			]
		);

		$this->end_controls_tabs();

		$this->end_controls_section();

		/********************************* 
		* 	Review Meta Info End (Date, Verified, Helpful)
		* *********************************/
		
		if( $this->is_pro() ) {

			$this->start_controls_section(
				'rx_template_one_section_reply_style',
				[
					'label' => __( 'Store Reply', 'reviewx' ),
					'condition' => [
						'rx_template_type' => [ 'template_style_one' ],
					],
				]
			);
	
			$this->start_controls_tabs( 'template_one_reply_style' );	
			
			$this->add_control(
				'rx_template_one_reply_block_style',
				[
					'type' => Controls_Manager::HEADING,
					'label' => __( 'Reply Item', 'reviewx' ),
					'separator' => 'after',
				]
			);	
			
			$this->add_control(
				'rx_template_one_reply_icon_color',
				[
					'label' => __( 'Store Logo Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#2f4fff',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .rx_review_block .children .rx_thumb svg .st0' => 'fill: {{VALUE}} !important',															
					],
				]
			);
			
			$this->add_control(
				'rx_template_one_reply_icon_bdcolor',
				[
					'label' => __( 'Store Logo Background Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#fff',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .rx_review_block .children .rx_thumb' => 'background-color: {{VALUE}}',
					],
				]
			);
			
			$this->add_control(
				'rx_template_one_reply_icon_border',
				[
					'label' => __( 'Store Logo Border Radius', 'reviewx' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'default' => [
						'unit' => 'px',
						'size' => 15,
					],	
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .rx_review_block .children .rx_thumb' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					],
				]
			);		
			
			$this->add_control(
				'rx_template_one_reply_title_color',
				[
					'label' => __( 'Store Name Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#373747',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .rx_review_block .children .review_title' => 'color: {{VALUE}} !important',					
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'rx_template_one_reply_title_typography',
					'label' => __( 'Store Name Typography', 'reviewx' ),
					'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .rx_review_block .children .review_title',
				]
			);
	
			$this->add_control(
				'rx_template_one_reply_back_icon_color',
				[
					'label' => __( 'Reply Back Icon Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#707070',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .rx_review_block .children .owner_arrow svg .st0' => 'fill: {{VALUE}} !important',					
					],
				]
			);		
			
			$this->add_control(
				'rx_template_one_reply_text_color',
				[
					'label' => __( 'Reply Text Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#707070',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .rx_review_block .children .comment-content p' => 'color: {{VALUE}} !important',					
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'rx_template_one_reply_text_typography',
					'label' => __( 'Reply Text Typography', 'reviewx' ),
					'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .rx_review_block .children .comment-content p',
				]
			);		
			
			$this->add_control(
				'rx_template_one_reply_date_color',
				[
					'label' => __( 'Date Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#373747',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .rx_review_block .children .rx_review_calender' => 'color: {{VALUE}} !important',					
					],
				]
			);		
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'rx_template_one_reply_date_typography',
					'label' => __( 'Date Typography', 'reviewx' ),
					'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .rx_review_block .children .rx_review_calender',
				]
			);
	
			$this->add_control(
				'rx_template_one_reply_date_icon_color',
				[
					'label' => __( 'Date Icon Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#373747',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .rx_review_block .children .rx_body .rx_review_calender svg .st0' => 'fill: {{VALUE}} !important',					
					],
				]
			);		
	
			$this->add_control(
				'rx_template_one_reply_edit_icon_color',
				[
					'label' => __( 'Reply Edit Icon Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#000',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .admin-reply-edit-icon svg' => 'fill: {{VALUE}} !important',					
					],
				]
			);
			
			$this->add_control(
				'rx_template_one_reply_delete_icon_color',
				[
					'label' => __( 'Reply Delete Icon Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#000',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .admin-reply-delete-icon svg' => 'fill: {{VALUE}} !important',					
					],
				]
			);		
			
	
			$this->add_control(
				'rx_template_one_reply_button_text_color',
				[
					'label' => __( 'Reply Button Text Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#fff',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .rx_review_block .rx_meta .rx-admin-reply' => 'color: {{VALUE}} !important',					
					],
				]
			);		
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'rx_template_one_reply_button_text_typography',
					'label' => __( 'Reply Button Text Typography', 'reviewx' ),
					'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .rx_review_block .rx_meta .rx-admin-reply',
				]
			);
	
			$this->add_control(
				'rx_template_one_reply_button_color',
				[
					'label' => __( 'Reply Button Background Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#097afa',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .rx_review_block .rx_meta .rx-admin-reply' => 'background-color: {{VALUE}} !important'										
					],
				]
			);
	
			$this->add_control(
				'rx_template_one_reply_button_border_color',
				[
					'label' => __( 'Reply Button Border Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#097afa',
					'selectors' => [					
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .rx_review_block .rx_meta .rx-admin-reply' => 'border-color: {{VALUE}} !important',										
					],
				]
			);		
			
			$this->add_control(
				'rx_template_one_reply_bgcolor',
				[
					'label' => __( 'Reply Background Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#fff',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .children' => 'background-color: {{VALUE}}',					
					],
				]
			);	
			
			$this->add_control(
				'rx_template_one_reply_form_block_style',
				[
					'type' => Controls_Manager::HEADING,
					'label' => __( 'Reply Form', 'reviewx' ),
					'separator' => 'after',
				]
			);
	
			$this->add_control(
				'rx_template_one_reply_form_bgcolor',
				[
					'label' => __( 'Background Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#fff',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-admin-edit-reply-area, .woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-admin-reply-area' => 'background-color: {{VALUE}} !important',										
					],
				]
			);
			
			$this->add_control(
				'rx_template_one_reply_form_border_color',
				[
					'label' => __( 'Border Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#f7f7f7',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-admin-edit-reply-area, .woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-admin-reply-area' => 'border-color: {{VALUE}} !important',										
					],
				]
			);
			
			$this->add_control(
				'rx_template_one_reply_form_border_radius',
				[
					'label' => __( 'Border Radius', 'reviewx' ),
					'type' => Controls_Manager::SLIDER,
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-admin-edit-reply-area, .woocommerce {{WRAPPER}} .woocommerce-Tabs-panel  .rx-admin-reply-area' => 'border-radius: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}}',
					],
				]
			);
			
			$this->add_control(
				'rx_template_one_reply_form_title_color',
				[
					'label' => __( 'Title Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#f7f7f7',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_1 .rx_review_block .rx_body .admin-reply-form-title,
						.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_1 .rx-admin-edit-reply-area .admin-reply-form-title
						' => 'color: {{VALUE}} !important',										
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'rx_template_one_reply_form_title_typography',
					'label' => __( 'Title Typography', 'reviewx' ),
					'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .rx_review_block .rx_body .admin-reply-form-title,
					.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_1 .rx-admin-edit-reply-area .admin-reply-form-title',
				]
			);
	
			$this->add_control(
				'rx_template_one_reply_form_field',
				[
					'label' => __( 'Text Area Background Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#EBEBF3',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing .rx_review_block .rx_body .rx-admin-reply-area .comment-form-comment textarea, .woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-admin-edit-reply-area .comment-form-comment textarea' => 'background-color: {{VALUE}} !important',										
					],
				]
			);
	
			/*========================
			*	Reply Submit Button
			*========================*/
			$this->add_control(
				'rx_template_one_reply_submit_button',
				[
					'label' => __( 'Submit Button Background Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#2f4fff',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-admin-edit-reply-area .form-submit .admin-review-edit-reply, 
						.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-admin-reply-area .form-submit .admin-review-reply' => 'background-color: {{VALUE}} !important',										
					],
				]
			);		
			
			$this->add_control(
				'rx_template_one_reply_submit_color',
				[
					'label' => __( 'Submit Button Text Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#fff',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-admin-edit-reply-area .form-submit .admin-review-edit-reply, .woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-admin-reply-area .form-submit .admin-review-reply' => 'color: {{VALUE}} !important',										
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'rx_template_one_reply_submit_typography',
					'label' => __( 'Submit Button Typography', 'reviewx' ),
					'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-admin-edit-reply-area .form-submit, .woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-admin-reply-area .form-submit',
				]
			);
		
			/*========================
			*	Reply Cancel Button
			*========================*/
			$this->add_control(
				'rx_template_one_reply_cancel_button',
				[
					'label' => __( 'Cancel Button Background Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#eeeeee',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-admin-edit-reply-area .form-submit .cancel-admin-edit-reply, .woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-admin-reply-area .form-submit .cancel-admin-reply
						' => 'background-color: {{VALUE}} !important',										
					],
				]
			);				
			
			$this->add_control(
				'rx_template_one_reply_cancel_color',
				[
					'label' => __( 'Cancel Button Text Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#333',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-admin-edit-reply-area .form-submit .cancel-admin-edit-reply, .woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-admin-reply-area .form-submit .cancel-admin-reply' => 'color: {{VALUE}} !important',										
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'rx_template_one_reply_cancel_typography',
					'label' => __( 'Cancel Button Typography', 'reviewx' ),
					'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-admin-edit-reply-area .form-submit .cancel-admin-reply, .woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-admin-reply-area .form-submit .cancel-admin-reply',
				]
			);		
	
			$this->end_controls_tabs();
	
			$this->end_controls_section();
			
			/********************************* 
			* 	Review Reply & Reply Form End
			* *********************************/

		}        
		
        $this->start_controls_section(
            'rx_template_one_section_pagination_style',
            [
                'label' => __( 'Pagination', 'reviewx' ),
                'condition' => [
                    'rx_template_type' => [ 'template_style_one' ],
                ],
            ]
        );

        $this->start_controls_tabs( 'template_one_pagination_style' );

        $this->add_control(
            'rx_template_one_pagination_text_color',
            [
                'label' => __( 'Text Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#6f7484',
                'selectors' => [
                    '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_1 .rx_pagination a' => 'color: {{VALUE}} !important',
                ],
            ]
		);
		
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'rx_template_one_pagination_text_typography',
                'label' => __( 'Text Typography', 'reviewx' ),
                'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_1 .rx_pagination a',
            ]
        );		

        $this->add_control(
            'rx_template_one_pagination_bg_color',
            [
                'label' => __( 'Background Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#F3F3F7',
                'selectors' => [
                    '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_1 .rx_pagination a' => 'background-color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_control(
            'rx_template_one_pagination_text_active_color',
            [
                'label' => __( 'Active Text Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
                'selectors' => [
                    '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_1 .rx_pagination .rx-page.active a' => 'color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_control(
            'rx_template_one_pagination_bg_active_color',
            [
                'label' => __( 'Active Background Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#2f4fff',
                'selectors' => [
                    '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_1 .rx_pagination .rx-page.active a' => 'background-color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_control(
            'rx_template_one_pagination_text_hover_color',
            [
                'label' => __( 'Hover Text Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#23527c',
                'selectors' => [
                    '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_1 .rx_pagination a:hover' => 'color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_control(
            'rx_template_one_pagination_bg_hover_color',
            [
                'label' => __( 'Hover Background Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#2f4fff',
                'selectors' => [
                    '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_1 .rx_pagination a:hover' => 'background-color: {{VALUE}} !important',
                ],
            ]
        );

        $this->end_controls_tabs();

        $this->end_controls_section();

        /*********************************
         * 	Pagination End
         * *********************************/
        $this->start_controls_section(
            'rx_template_one_section_form_style',
            [
                'label' => __( 'Review Form', 'reviewx' ),
                'condition' => [
                    'rx_template_type' => [ 'template_style_one' ],
                ],
            ]
        );

		$this->start_controls_tabs( 'template_one_form_style' );

		if( $this->is_pro() ) {

			$this->add_control(
				'rx_template_one_form_rating_type',
				[
					'label' => __( 'Select Rating Style', 'reviewx' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'rating_style_one',
					'options' => [
						'' => '— ' . __( 'Select', 'reviewx' ) . ' —',
						'rating_style_one' => __( 'Star Rting', 'reviewx' ),
						'rating_style_two' => __( 'Thumbs Rating', 'reviewx' ),
						'rating_style_three' => __( 'Faces Rating', 'reviewx' ),
					],
				]
			);			

		} else {

			$this->add_control(
				'rx_template_one_form_rating_type',
				[
					'label' => __( 'Select Rating Style', 'reviewx' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'rating_style_one',
					'options' => [
						'' => '— ' . __( 'Select', 'reviewx' ) . ' —',
						'rating_style_one' => __( 'Star Rating', 'reviewx' ),
					],
				]
			);

		}

		$this->add_control(
			'rx_template_one_form_criteria_color',
			[
				'label' => __( 'Criteria Text Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1a1a1a',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-review-form-area-style-1 .rx-criteria-table td' => 'color: {{VALUE}}',
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-review-form-area-style-2 .rx-criteria-table td' => 'color: {{VALUE}}',			
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'rx_template_one_form_criteria_typography',
				'label' => __( 'Criteria Text Typography', 'reviewx' ),
				'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-review-form-area-style-1 .rx-criteria-table td,
							   .woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-review-form-area-style-2 .rx-criteria-table td',
			]
		);		
		
		$this->add_control(
			'rx_template_one_form_separator_one',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);		

		$this->add_control(
			'rx_template_one_form_rating_color',
			[
				'label' => __( 'Rating Icon Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFAF22',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .rx-review-form-area-style-1 .rx_star_rating > input:checked ~ label .icon-star,
					.woocommerce {{WRAPPER}} .rx-review-form-area-style-1 .reviewx-thumbs-rating input[type="radio"]:checked + label svg, .rx-review-form-area-style-1 .reviewx-thumbs-rating input[type="radio"]:checked + label svg #rx_dislike path,
					.rx-review-form-area-style-1 .reviewx-face-rating fieldset input[type="radio"]:checked + label .happy_st0, .rx-review-form-area-style-1 .reviewx-face-rating fieldset input[type="radio"]:checked + label .st1' => 'fill: {{VALUE}} !important',
					'.woocommerce {{WRAPPER}} .rx-review-form-area-style-1 .rx_star_rating .icon-star,
					.woocommerce {{WRAPPER}} .rx-review-form-area-style-1 .rx_star_rating:not(:checked) > label:hover .icon-star, .rx_star_rating:not(:checked) > label:hover ~ label .icon-star
					' => 'stroke: {{VALUE}} !important',
					'.woocommerce {{WRAPPER}} .rx-review-form-area-style-1 .rx_star_rating:not(:checked)>label:hover .icon-star, .woocommerce {{WRAPPER}} .rx-review-form-area-style-1 .rx_star_rating:not(:checked)>label:hover~label .icon-star' => 'fill: {{VALUE}} !important',					
				],
			]
		);

        $this->add_control(
            'rx_template_one_form_recommendation_icon_active_color',
            [
                'label' => __( 'Recommendation Icon Active Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#3797FF',
                'selectors' => [
                    '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-review-form-area-style-1 .reviewx_recommended_list .reviewx_radio input[type="radio"]:checked + .radio-label svg .rx_happy, .rx-review-form-area-style-1 .reviewx_recommended_list .reviewx_radio input[type="radio"]:checked + .radio-label svg .st1 ' => 'fill: {{VALUE}} !important',
                ],
            ]
		);
		
		$this->add_control(
			'rx_template_one_form_separator_two',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);	
		
		$this->add_control(
            'rx_template_one_form_external_video_link_color',
            [
                'label' => __( 'External Example Video Link Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#6d6d6d',
                'selectors' => [
                    '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-review-form-area-style-1 #review_form .rx-note-video' => 'color: {{VALUE}} !important',
                ],
            ]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'rx_template_one_form_external_video_link_typography',
				'label' => __( 'External Example Video Link Typography', 'reviewx' ),
				'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-review-form-area-style-1 #review_form .rx-note-video',
			]
		);		
		
		$this->add_control(
			'rx_template_one_form_separator_three',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);		

        $this->add_control(
            'rx_template_one_form_submit_button_text_color',
            [
                'label' => __( 'Submit Button Text Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
                'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-review-form-area-style-1 #review_form input[type="submit"], 
					.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-review-form-area-style-1 #review_form input[type="submit"]:focus ' => 'color: {{VALUE}} !important',
                ],
            ]
		);
		
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'rx_template_one_form_submit_button_text_typography',
                'label' => __( 'Submit Button Text Typography', 'reviewx' ),
				'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-review-form-area-style-1 #review_form input[type="submit"], 
				.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-review-form-area-style-1 #review_form input[type="submit"]:focus',
            ]
        );		

        $this->add_control(
            'rx_template_one_form_submit_button_bg_color',
            [
                'label' => __( 'Submit Button Background Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#2f4fff',
                'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-review-form-area-style-1 #review_form input[type="submit"], 
					.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-review-form-area-style-1 #review_form input[type="submit"]:focus ' => 'background-color: {{VALUE}} !important',
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-review-form-area-style-1 #review_form input[type="submit"], 
					.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-review-form-area-style-1 #review_form input[type="submit"]:focus ' => 'border-color: {{VALUE}} !important',
                ],
            ]
		);
	
		$this->add_control(
			'rx_template_one_form_submit_button_border_radius',
			[
				'label' => __( 'Submit Button Border Radius', 'reviewx' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-review-form-area-style-1 #respond input#submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);		

        $this->end_controls_tabs();

        $this->end_controls_section();
        /*********************************
         * 	Review Form End
         * *********************************/
	}

    /**
     * Template Two Style
     * @return void
     */
	protected function template_two_style()
    {
		$this->start_controls_section(
			'rx_template_two_section_filter',
			[
				'label' => __( 'Filtering Bar', 'reviewx' ),
				'condition' => [
					'rx_template_type' => [ 'template_style_two' ],
				],
			]
		);

		$this->start_controls_tabs( 'template_two_filter' );

		$this->add_control(
			'rx_template_two_filter_text_color',
			[
				'label' => __( 'Text Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#676767',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-filter-bar-style-2 .rx_filter_header h4, 
					.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-filter-bar-style-2 .rx-short-by h4' => 'color: {{VALUE}}',		
				],
			]
		);		
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'rx_template_two_filter_text_typography',
				'label' => __( 'Text Typography', 'reviewx' ),
				'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-filter-bar-style-2 .rx_filter_header h4, 
							   .woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-filter-bar-style-2 .rx-short-by h4',
			]
		);
		
		$this->add_control(
			'rx_template_two_dropdown_bg_color',
			[
				'label' => __( 'Dropdown Background Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-filter-bar-style-2 .rx_review_shorting_2 .box select' => 'background-color: {{VALUE}} !important',					
				],
			]
		);
		
		$this->add_control(
			'rx_template_two_dropdown_text_color',
			[
				'label' => __( 'Dropdown Text Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#333',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-filter-bar-style-2 .rx_review_shorting_2 .box select' => 'color: {{VALUE}} !important',					
				],
			]
		);
		
		$this->add_control(
			'rx_template_two_dropdown_icon_color',
			[
				'label' => __( 'Dropdown Selector Icon Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-filter-bar-style-2 .rx_review_shorting_2 .box .rx-selection-arrow b' => 'border-color: {{VALUE}} transparent transparent transparent !important',					
				],
			]
		);
		
		$this->add_control(
			'rx_template_two_filter_bar_color',
			[
				'label' => __( 'Dropdown Bar Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#2f4fff',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-filter-bar-style-2 .rx_review_shorting_2 .box .rx-selection-arrow' => 'background-color: {{VALUE}} !important',					
				],
			]
		);

		$this->add_control(
			'rx_template_two_filter_bg_color',
			[
				'label' => __( 'Filter Background Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#f5f6f9',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-filter-bar-style-2' => 'background-color: {{VALUE}}',					
				],
			]
		);		
		
		$this->add_control(
			'rx_template_two_filter_box_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Section Design', 'reviewx' ),
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'rx_template_two_filter_box_shadow',
				'selector' => '{{WRAPPER}} .woocommerce-Tabs-panel .rx-filter-bar-style-2',
			]
		);		

		$this->end_controls_tabs();

		$this->end_controls_section();

		/*=======================
		* End Filter Style
		* Start Review Style
		=========================*/		

		$this->start_controls_section(
			'rx_template_two_section_review_style',
			[
				'label' => __( 'Review Item', 'reviewx' ),
				'condition' => [
					'rx_template_type' => [ 'template_style_two' ],
				],
			]
		);

		$this->start_controls_tabs( 'template_two_review_style' );		

		$this->add_control(
			'rx_template_two_author_block_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Reviewer Information', 'reviewx' ),
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'rx_template_two_author_box_shadow',
				'selector' => '.woocommerce {{WRAPPER}} .woocommerce-tabs .woocommerce-Tabs-panel .rx_listing_style_2 .rx_review_block .rx_thumb',
			]
		);
		
		$this->add_control(
			'rx_template_two_author_border_style',
			[
				'label' => __( 'Avatar Border Style', 'reviewx' ),
				'type' => Controls_Manager::SELECT,
				'groups' => array_values( $this->get_options_by_groups( $styles ) ),
				'render_type' => 'template',
				'default' => 'solid',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-tabs .woocommerce-Tabs-panel .rx_listing_style_2 .rx_review_block .rx_thumb' => 'border-style: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'rx_template_two_author_border_color',
			[
				'label' => __( 'Avatar Border Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#000',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-tabs .woocommerce-Tabs-panel .rx_listing_style_2 .rx_review_block .rx_thumb' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rx_template_two_author_border_weight',
			[
				'label' => __( 'Avatar Border Weight', 'reviewx' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 10,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-tabs .woocommerce-Tabs-panel .rx_listing_style_2 .rx_review_block .rx_thumb' => 'border-width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'rx_template_two_author_color',
			[
				'label' => __( 'Reviewer Name Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#373747',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2 .rx_review_block .rx_author_info .rx_author_name h4' => 'color: {{VALUE}}',					
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'rx_template_two_author_typography',
				'label' => __( 'Reviewer Name Typography', 'reviewx' ),
				'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2 .rx_review_block .rx_author_info .rx_author_name h4',
			]
		);
		
		/********************************* 
		* 	Author End
		* *********************************/	
		
		$this->add_control(
			'rx_template_two_main_content_block_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Main Content', 'reviewx' ),
				'separator' => 'before',
			]
		);	

		$this->add_control(
			'rx_template_two_rating_color',
			[
				'label' => __( 'Rating Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFAF22',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_review_sort_list .rx_listing_container_style_2 .rx_listing_style_2 .rx_avg_star_color' => 'fill: {{VALUE}}',					
				],
			]
		);	
		
		$this->add_control(
			'rx_template_two_rating_size',
			[
				'label' => __( 'Star Rating Size', 'reviewx' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
					'size' => 14,
				],
				'selectors' => [					
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2 .rx_review_block .rx_body .review_rating svg' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}} !important;',					
				],
			]
		);		

		$this->add_control(
			'rx_template_two_title_color',
			[
				'label' => __( 'Review Title Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#373747',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2 .rx_review_block .review_title' => 'color: {{VALUE}}',	
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'rx_template_two_title_typography',
				'label' => __( 'Review Title Typography', 'reviewx' ),
				'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2 .rx_review_block .review_title',
			]
		);

		$this->add_control(
			'rx_template_two_text_color',
			[
				'label' => __( 'Review Comments Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#9B9B9B',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2 .rx_review_block .rx_body p' => 'color: {{VALUE}}',					
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'rx_template_two_text_typography',
				'label' => __( 'Review Comments Typography', 'reviewx' ),
				'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2 .rx_review_block .rx_body p',
			]
		);	
		
		$this->add_control(
			'rx_template_two_review_bg_color',
			[
				'label' => __( 'Review Background Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#F5F6F9',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2 .rx_review_block' => 'background-color: {{VALUE}}',					
				],
			]
		);
		
		$this->add_control(
			'rx_template_two_reply_bg_color',
			[
				'label' => __( 'Reply Background Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2.rx_listing_filter_style_2 .children, .woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2 .children .rx_review_block' => 'background-color: {{VALUE}}',					
				],
			]
		);		

		/********************************* 
		* 	Review Comments End
		* *********************************/			
		
		$this->add_control(
			'rx_template_two_text_block_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Meta Information', 'reviewx' ),
				'separator' => 'before',
			]
		);		

		$this->add_control(
			'rx_template_two_date_icon_color',
			[
				'label' => __( 'Reviewed Date Icon Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#707070',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2 .rx_review_block .rx_body .rx_review_calender svg .st0' => 'fill: {{VALUE}}',
				],
			]
		);		
		
		$this->add_control(
			'rx_template_two_date_color',
			[
				'label' => __( 'Reviewed Date Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#707070',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2 .rx_review_block .rx_body .rx_review_calender' => 'color: {{VALUE}}',					
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'rx_template_two_date_typography',
				'label' => __( 'Reviewed Date Typography', 'reviewx' ),
				'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2 .rx_review_block .rx_body .rx_review_calender',
			]
		);
		
		$this->add_control(
			'rx_template_two_verified_icon_color',
			[
				'label' => __( 'Verified Badge Icon Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#12D585',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2 .rx_review_block .rx_body .rx_varified .rx_varified_user svg .st0' => 'fill: {{VALUE}}',
				],
			]
		);		
		
		$this->add_control(
			'rx_template_two_verified_color',
			[
				'label' => __( 'Verified Text Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#12D585',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2 .rx_review_block .rx_body .rx_varified .rx_varified_user' => 'color: {{VALUE}}',					
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'rx_template_two_verified_typography',
				'label' => __( 'Verified Text Typography', 'reviewx' ),
				'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2 .rx_review_block .rx_body .rx_varified .rx_varified_user',
			]
		);
		
		if( $this->is_pro() ) {
	
			$this->add_control(
				'rx_template_two_helpful_color',
				[
					'label' => __( 'Helpful Text Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#333',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2 .rx_review_block .rx_body .rx_meta .rx_review_vote_icon p' => 'color: {{VALUE}}',					
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'rx_template_two_helpful_typography',
					'label' => __( 'Helpful Typography', 'reviewx' ),
					'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2 .rx_review_block .rx_body .rx_meta .rx_review_vote_icon p',
				]
			);

			$this->add_control(
				'rx_template_two_helpful_bg_color',
				[
					'label' => __( 'Helpful Button Background Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#eaeaea',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2 .rx_review_vote_icon .like' => 'background-color: {{VALUE}}',					
					],
				]
			);		

			$this->add_control(
				'rx_template_two_helpful_icon_color',
				[
					'label' => __( 'Helpful Thumbs-up Icon Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#A4A4A4',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2 .rx_helpful_style_2_svg svg' => 'fill: {{VALUE}}',					
					],
				]
			);	

			$this->add_control(
				'rx_template_two_helpful_count_color',
				[
					'label' => __( 'Helpful Thumbs-up Count Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#696969',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2 .rx_review_vote_icon .like .rx_helpful_count_val' => 'color: {{VALUE}} !important',				
					],
				]
			);		
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'rx_template_two_share_typography',
					'label' => __( 'Share Typography', 'reviewx' ),
					'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2 .rx_review_block .rx_body .rx_meta .rx_share p',
				]
			);	
			
			$this->add_control(
				'rx_template_two_share_color',
				[
					'label' => __( 'Share Text Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#333',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2 .rx_review_block .rx_body .rx_meta .rx_share p' => 'color: {{VALUE}}',					
					],
				]
			);

			$this->add_control(
				'rx_template_two_share_icon_color',
				[
					'label' => __( 'Share Icon Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#000',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2 .social-links .wc_rx_btns ul li:nth-child(1) svg' => 'fill: {{VALUE}}',
					],
				]
			);		
			
			$this->add_control(
				'rx_template_two_facebook_color',
				[
					'label' => __( 'Facebook Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#B7B7B8',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2 .social-links .wc_rx_btns ul li:nth-child(2) a svg .st0' => 'fill: {{VALUE}}'	
					],
				]
			);	
			
			$this->add_control(
				'rx_template_two_twitter_color',
				[
					'label' => __( 'Twitter Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#B7B7B8',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2 .social-links .wc_rx_btns ul li:nth-child(3) a svg .st0' => 'fill: {{VALUE}}',					
					],
				]
			);

			$this->add_control(
				'rx_template_two_highlighter_color',
				[
					'label' => __( 'Highlight Icon Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#2f4fff',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2 .rx_admin_heighlights span svg' => 'fill: {{VALUE}} !important',		
					],
				]
			);

			$this->add_control(
				'rx_template_two_hightlight_bgcolor',
				[
					'label' => __( 'Review Highlight Background Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#fff4df',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .rx_listing_style_2 .reviewx_highlight_comment' => 'background-color: {{VALUE}} !important',					
					],
				]
			);				

			$this->add_control(
				'rx_template_two_reply_hightlight_bgcolor',
				[
					'label' => __( 'Reply Highlight Background Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#FFE3AF',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2.rx_listing_filter_style_2 .reviewx_highlight_comment .children, .woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2 .reviewx_highlight_comment .children .rx_review_block' => 'background-color: {{VALUE}} !important',					
					],
				]
			);

		}
		
		$this->add_control(
			'rx_template_two_attachement_block_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Review Attachment', 'reviewx' ),
				'separator' => 'before',
			]
		);	
		
		$this->add_responsive_control(
			'rx_template_two_attachement_position',
			[
				'label' => __( 'Select Attachment Position', 'reviewx' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => __( 'Left', 'reviewx' ),
						'icon' => 'eicon-text-align-left',
					],
					'flex-end' => [
						'title' => __( 'Right', 'reviewx' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2 .rx_review_block .rx_body .rx_photos' => 'justify-content: {{VALUE}} !important;',
				],
			]
		);		

		$this->end_controls_tabs();

		$this->end_controls_section();		

		/********************************* 
		* 	Review Meta Info End (Date, Verified, Helpful)
		* *********************************/

		if( $this->is_pro() ) {

			$this->start_controls_section(
				'rx_template_two_section_reply_style',
				[
					'label' => __( 'Store Reply', 'reviewx' ),
					'condition' => [
						'rx_template_type' => [ 'template_style_two' ],
					],
				]
			);
	
			$this->start_controls_tabs( 'template_two_reply_style' );
	
			$this->add_control(
				'rx_template_two_reply_block_style',
				[
					'type' => Controls_Manager::HEADING,
					'label' => __( 'Reply Item', 'reviewx' ),
					'separator' => 'after',
				]
			);
			
			$this->add_control(
				'rx_template_two_reply_icon_color',
				[
					'label' => __( 'Store Logo Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#2f4fff',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2 .rx_review_block .children .rx_thumb svg .st0' => 'fill: {{VALUE}} !important',															
					],
				]
			);
			
			$this->add_control(
				'rx_template_two_reply_icon_bdcolor',
				[
					'label' => __( 'Store Logo Background Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#fff',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2 .rx_review_block .children .rx_thumb' => 'background-color: {{VALUE}}',
					],
				]
			);	
			
			$this->add_control(
				'rx_template_two_reply_icon_border',
				[
					'label' => __( 'Store Logo Border Radius', 'reviewx' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'default' => [
						'unit' => 'px',
						'size' => 15,
					],				
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2 .rx_review_block .children .rx_thumb' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					],
				]
			);		
			
			$this->add_control(
				'rx_template_two_reply_title_color',
				[
					'label' => __( 'Store Name Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#373747',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2 .rx_review_block .children .review_title' => 'color: {{VALUE}} !important',					
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'rx_template_two_reply_title_typography',
					'label' => __( 'Store Name Typography', 'reviewx' ),
					'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2 .rx_review_block .children .review_title',
				]
			);
	
			$this->add_control(
				'rx_template_two_reply_back_icon_color',
				[
					'label' => __( 'Reply Back Icon Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#707070',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2 .rx_review_block .children .owner_arrow svg .st0' => 'fill: {{VALUE}} !important',					
					],
				]
			);		
			
			$this->add_control(
				'rx_template_two_reply_text_color',
				[
					'label' => __( 'Reply Text Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#707070',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2 .rx_review_block .children .comment-content p' => 'color: {{VALUE}} !important',					
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'rx_template_two_reply_text_typography',
					'label' => __( 'Reply Text Typography', 'reviewx' ),
					'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2 .rx_review_block .children .comment-content p',
				]
			);		
			
			$this->add_control(
				'rx_template_two_reply_date_color',
				[
					'label' => __( 'Date Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#373747',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2 .rx_review_block .children .rx_review_calender' => 'color: {{VALUE}} !important',					
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'rx_template_two_reply_date_typography',
					'label' => __( 'Date Typography', 'reviewx' ),
					'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2 .rx_review_block .children .rx_review_calender',
				]
			);
	
			$this->add_control(
				'rx_template_two_reply_date_icon_color',
				[
					'label' => __( 'Date Icon Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#373747',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2 .rx_review_block .rx_body .rx_review_calender svg .st0' => 'fill: {{VALUE}} !important',					
					],
				]
			);		
	
			$this->add_control(
				'rx_template_two_reply_edit_icon_color',
				[
					'label' => __( 'Reply Edit Icon Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#000',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .admin-reply-edit-icon svg' => 'fill: {{VALUE}} !important',					
					],
				]
			);
			
			$this->add_control(
				'rx_template_two_reply_delete_icon_color',
				[
					'label' => __( 'Reply Delete Icon Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#000',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .admin-reply-delete-icon svg' => 'fill: {{VALUE}} !important',					
					],
				]
			);		
	
			$this->add_control(
				'rx_template_two_reply_button_text_color',
				[
					'label' => __( 'Reply Button Text Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#fff',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2 .rx_review_block .rx_body .rx_meta .rx-admin-reply' => 'color: {{VALUE}} !important',
					],
				]
			);		
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'rx_template_two_reply_button_text_typography',
					'label' => __( 'Reply Button Text Typography', 'reviewx' ),
					'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2 .rx_review_block .rx_body .rx_meta .rx-admin-reply',
				]
			);
	
			$this->add_control(
				'rx_template_two_reply_button_color',
				[
					'label' => __( 'Reply Button Background Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#097afa',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2 .rx_review_block .rx_body .rx_meta .rx-admin-reply' => 'background-color: {{VALUE}} !important',					
					],
				]
			);	
			
	
			$this->add_control(
				'rx_template_two_reply_button_border_color',
				[
					'label' => __( 'Reply Button Border Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#097afa',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_style_2 .rx_review_block .rx_body .rx_meta .rx-admin-reply' => 'border-color: {{VALUE}} !important',				
					],
				]
			);
			
			$this->add_control(
				'rx_template_two_reply_form_block_style',
				[
					'type' => Controls_Manager::HEADING,
					'label' => __( 'Reply Form', 'reviewx' ),
					'separator' => 'after',
				]
			);
			
			$this->add_control(
				'rx_template_two_reply_form_bgcolor',
				[
					'label' => __( 'Background Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#fff',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_container_style_2 .rx-admin-edit-reply-area, 
						.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_container_style_2 .rx_review_block .rx_body .rx-admin-reply-area' => 'background-color: {{VALUE}} !important',										
					],
				]
			);
			
			$this->add_control(
				'rx_template_two_reply_form_border_color',
				[
					'label' => __( 'Border Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#f7f7f7',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_container_style_2.rx-admin-edit-reply-area, 
						.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_container_style_2 .rx_review_block .rx_body .rx-admin-reply-area' => 'border-color: {{VALUE}} !important',										
					],
				]
			);
			
			$this->add_control(
				'rx_template_two_reply_form_border_radius',
				[
					'label' => __( 'Border Radius', 'reviewx' ),
					'type' => Controls_Manager::SLIDER,
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_container_style_2 .rx-admin-reply-area,
						.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_container_style_2 .rx_review_block .rx_body .rx-admin-edit-reply-area' => 'border-radius: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} !important',
					],
				]
			);
			
			$this->add_control(
				'rx_template_two_reply_form_title_color',
				[
					'label' => __( 'Title Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#373747',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_container_style_2 .rx_review_block .rx_body .rx-admin-reply-area .admin-reply-form-title,
						.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_container_style_2 .rx-admin-edit-reply-area .admin-reply-form-title
						' => 'color: {{VALUE}} !important',										
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'rx_template_two_reply_form_title_typography',
					'label' => __( 'Title Typography', 'reviewx' ),
					'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_container_style_2 .rx_review_block .rx_body .rx-admin-reply-area .admin-reply-form-title,
								   .woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_container_style_2 .rx-admin-edit-reply-area .admin-reply-form-title',
				]
			);
	
			$this->add_control(
				'rx_template_two_reply_form_field',
				[
					'label' => __( 'Text Area Background Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#EBEBF3',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_container_style_2 .rx_review_block .rx_body .rx-admin-reply-area .comment-form-comment .rx-admin-reply-text, 
						 .woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_container_style_2 .rx-admin-edit-reply-area .comment-form-comment .rx-admin-reply-text' => 'background-color: {{VALUE}} !important',										
					],
				]
			);
	
			/*========================
			*	Reply Submit Button
			*========================*/
			$this->add_control(
				'rx_template_two_reply_submit_button',
				[
					'label' => __( 'Submit Button Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#2f4fff',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_container_style_2 .rx-admin-edit-reply-area .form-submit .admin-review-edit-reply, 
						.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_container_style_2 .rx_review_block .rx_body .rx-admin-reply-area .form-submit .admin-review-reply' => 'background-color: {{VALUE}} !important',										
					],
				]
			);		
			
			$this->add_control(
				'rx_template_two_reply_submit_color',
				[
					'label' => __( 'Submit Button Text Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#fff',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_container_style_2 .rx-admin-edit-reply-area .form-submit .admin-review-reply, 
						.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_container_style_2 .rx_review_block .rx_body .rx-admin-reply-area .form-submit .admin-review-reply' => 'color: {{VALUE}} !important',										
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'rx_template_two_reply_submit_typography',
					'label' => __( 'Submit Button Typography', 'reviewx' ),
					'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_container_style_2 .rx-admin-edit-reply-area .form-submit .admin-review-reply, 
								.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_container_style_2 .rx_review_block .rx_body .rx-admin-reply-area .form-submit .admin-review-reply',
				]
			);
		
			/*========================
			*	Reply Cancel Button
			*=========================*/
			$this->add_control(
				'rx_template_two_reply_cancel_button',
				[
					'label' => __( 'Cancel Button Background Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#eeeeee',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_container_style_2 .rx-admin-edit-reply-area .form-submit .cancel-admin-edit-reply, .woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_review_block .rx_body .rx-admin-reply-area .form-submit .cancel-admin-reply' => 'background-color: {{VALUE}} !important',										
					],
				]
			);	
			
			$this->add_control(
				'rx_template_two_reply_cancel_border_color',
				[
					'label' => __( 'Cancel Button Border Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#333',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_container_style_2 .rx-admin-edit-reply-area .form-submit .cancel-admin-edit-reply, .woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_review_block .rx_body .rx-admin-reply-area .form-submit .cancel-admin-reply' => 'border-color: {{VALUE}} !important',										
					],
				]
			);		
			
			$this->add_control(
				'rx_template_two_reply_cancel_color',
				[
					'label' => __( 'Cancel Button Text Color', 'reviewx' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#333',
					'selectors' => [
						'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_container_style_2 .rx-admin-edit-reply-area .form-submit .cancel-admin-edit-reply, .woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_review_block .rx_body .rx-admin-reply-area .form-submit .cancel-admin-reply' => 'color: {{VALUE}} !important',										
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'rx_template_two_reply_cancel_typography',
					'label' => __( 'Cancel Button Typography', 'reviewx' ),
					'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_container_style_2 .rx-admin-edit-reply-area .form-submit .cancel-admin-reply, .woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_container_style_2 .rx_review_block .rx_body .rx-admin-reply-area .form-submit .cancel-admin-reply',
				]
			);		
	
			$this->end_controls_tabs();
	
			$this->end_controls_section();
			
			/********************************* 
			* 	Review Reply & Reply Form End
			* *********************************/	

		}

		$this->start_controls_section(
			'rx_template_two_section_pagination_style',
			[
				'label' => __( 'Pagination', 'reviewx' ),
				'condition' => [
					'rx_template_type' => [ 'template_style_two' ],
				],
			]
		);

		$this->start_controls_tabs( 'template_two_pagination_style' );

        $this->add_control(
            'rx_template_two_pagination_text_color',
            [
                'label' => __( 'Text Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#6f7484',
                'selectors' => [
                    '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_container_style_2 .rx_pagination a' => 'color: {{VALUE}} !important',
                ],
            ]
		);
		
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'rx_template_two_pagination_text_typography',
                'label' => __( 'Text Typography', 'reviewx' ),
                'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_container_style_2 .rx_pagination a',
            ]
        );		

        $this->add_control(
            'rx_template_two_pagination_bg_color',
            [
                'label' => __( 'Background Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#F3F3F7',
                'selectors' => [
                    '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_container_style_2 .rx_pagination a' => 'background-color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_control(
            'rx_template_two_pagination_text_active_color',
            [
                'label' => __( 'Active Text Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
                'selectors' => [
                    '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_container_style_2 .rx_pagination a.current' => 'color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_control(
            'rx_template_two_pagination_bg_active_color',
            [
                'label' => __( 'Active Background Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#2f4fff',
                'selectors' => [
                    '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_container_style_2 .rx_pagination a.current' => 'background-color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_control(
            'rx_template_two_pagination_text_hover_color',
            [
                'label' => __( 'Hover Text Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#23527c',
                'selectors' => [
                    '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_container_style_2 .rx_pagination a:hover' => 'color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_control(
            'rx_template_two_pagination_bg_hover_color',
            [
                'label' => __( 'Hover Background Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#2f4fff',
                'selectors' => [
                    '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx_listing_container_style_2 .rx_pagination a:hover' => 'background-color: {{VALUE}} !important',
                ],
            ]
        );
			
		$this->end_controls_tabs();

		$this->end_controls_section();	

		/********************************* 
		* 	Pagination End
		* *********************************/

        $this->start_controls_section(
            'rx_template_two_section_form_style',
            [
                'label' => __( 'Review Form', 'reviewx' ),
                'condition' => [
                    'rx_template_type' => [ 'template_style_two' ],
                ],
            ]
        );

		$this->start_controls_tabs( 'template_two_form_style' );

		if( $this->is_pro() ) {

			$this->add_control(
				'rx_template_two_form_rating_type',
				[
					'label' => __( 'Select Rating Style', 'reviewx' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'rating_style_one',
					'options' => [
						'' => '— ' . __( 'Select', 'reviewx' ) . ' —',
						'rating_style_one' => __( 'Star Rating', 'reviewx' ),
						'rating_style_two' => __( 'Thumbs Rating', 'reviewx' ),
						'rating_style_three' => __( 'Faces Rating', 'reviewx' ),
					],
				]
			);

		} else {
			
			$this->add_control(
				'rx_template_two_form_rating_type',
				[
					'label' => __( 'Select Rating Style', 'reviewx' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'rating_style_one',
					'options' => [
						'' => '— ' . __( 'Select', 'reviewx' ) . ' —',
						'rating_style_one' => __( 'Star Rating', 'reviewx' ),
					],
				]
			);

		}

		$this->add_control(
			'rx_template_two_form_criteria_color',
			[
				'label' => __( 'Criteria Text Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1a1a1a',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-review-form-area-style-1 .rx-criteria-table td' => 'color: {{VALUE}}',
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-review-form-area-style-2 .rx-criteria-table td' => 'color: {{VALUE}}',		
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'rx_template_two_form_criteria_typography',
				'label' => __( 'Criteria Text Typography', 'reviewx' ),
				'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-review-form-area-style-1 .rx-criteria-table td,
							   .woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-review-form-area-style-2 .rx-criteria-table td',
			]
		);		
		
		$this->add_control(
			'rx_template_two_form_separator_one',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);		

		$this->add_control(
			'rx_template_two_form_rating_color',
			[
				'label' => __( 'Rating Icon Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFAF22',
				'selectors' => [
					'.woocommerce {{WRAPPER}} .rx-review-form-area-style-2 .rx_star_rating > input:checked ~ label .icon-star,
					.rx-review-form-area-style-2 .reviewx-thumbs-rating input[type="radio"]:checked + label svg, .rx-review-form-area-style-2 .reviewx-thumbs-rating input[type="radio"]:checked + label svg #rx_dislike path,
					.rx-review-form-area-style-2 .reviewx-face-rating fieldset input[type="radio"]:checked + label .happy_st0, .rx-review-form-area-style-2 .reviewx-face-rating fieldset input[type="radio"]:checked + label .st1' => 'fill: {{VALUE}} !important',
					'.woocommerce {{WRAPPER}} .rx-review-form-area-style-2 .rx_star_rating .icon-star,
					.woocommerce {{WRAPPER}} .rx-review-form-area-style-2 .rx_star_rating:not(:checked) > label:hover .icon-star, .rx_star_rating:not(:checked) > label:hover ~ label .icon-star
					' => 'stroke: {{VALUE}} !important',
					'.woocommerce {{WRAPPER}} .rx-review-form-area-style-2 .rx_star_rating:not(:checked)>label:hover .icon-star, .woocommerce {{WRAPPER}} .rx-review-form-area-style-2 .rx_star_rating:not(:checked)>label:hover~label .icon-star' => 'fill: {{VALUE}} !important',	
				],
			]
		);

        $this->add_control(
            'rx_template_two_form_recommendation_icon_active_color',
            [
                'label' => __( 'Recommendation Icon Active Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#3797FF',
                'selectors' => [
                    '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-review-form-area-style-2 .reviewx_recommended_list .reviewx_radio input[type="radio"]:checked + .radio-label svg .rx_happy, .rx-review-form-area-style-2 .reviewx_recommended_list .reviewx_radio input[type="radio"]:checked + .radio-label svg .st1 ' => 'fill: {{VALUE}} !important',
                ],
            ]
		);
		
		$this->add_control(
			'rx_template_two_form_separator_two',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);
		
		$this->add_control(
            'rx_template_two_form_external_video_link_color',
            [
                'label' => __( 'External Example Video Link Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#6d6d6d',
                'selectors' => [
                    '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-review-form-area-style-2 #review_form .rx-note-video' => 'color: {{VALUE}} !important',
                ],
            ]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'rx_template_two_form_external_video_link_typography',
				'label' => __( 'External Example Video Link Typography', 'reviewx' ),
				'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-review-form-area-style-2 #review_form .rx-note-video',
			]
		);		
		
		$this->add_control(
			'rx_template_two_form_separator_three',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

        $this->add_control(
            'rx_template_two_form_submit_button_text_color',
            [
                'label' => __( 'Submit Button Text Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
                'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-review-form-area-style-2 #review_form input[type="submit"], 
					.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-review-form-area-style-2 #review_form input[type="submit"]:focus' => 'color: {{VALUE}} !important',
                ],
            ]
		);
		
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'rx_template_two_form_submit_button_text_typography',
                'label' => __( 'Submit Button Text Typography', 'reviewx' ),
				'selector' => '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-review-form-area-style-2 #review_form input[type="submit"], 
						       .woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-review-form-area-style-2 #review_form input[type="submit"]:focus',
            ]
        );		

        $this->add_control(
            'rx_template_two_form_submit_button_bg_color',
            [
                'label' => __( 'Submit Button Background Color', 'reviewx' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#2f4fff',
                'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-review-form-area-style-2 #review_form input[type="submit"], 
					.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-review-form-area-style-2 #review_form input[type="submit"]:focus' => 'background-color: {{VALUE}} !important',
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-review-form-area-style-2 #review_form input[type="submit"], 
					.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-review-form-area-style-2 #review_form input[type="submit"]:focus' => 'border-color: {{VALUE}} !important',
                ],
            ]
		);
		
		$this->add_control(
			'rx_template_two_form_submit_button_border_radius',
			[
				'label' => __( 'Submit Button Border Radius', 'reviewx' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel .rx-review-form-area-style-2 #respond input#submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);		

        $this->end_controls_tabs();

        $this->end_controls_section();
        /*********************************
         * 	Review Form End
         * *********************************/
	}

    /**
     * Render
     * @return void
     */
    protected function render()
    {
		global $product;

        $product = wc_get_product();

		if ( empty( $product ) ) {
			echo '<h3>'.__('This widget only works for the product page. In order to achieve, follow the steps: this  Dashboard >  Template  > Theme Builder > Add New > Choose Template Type \'Single Product\' > Create Template', 'reviewx').'</h3>';
			return;
		}
		
		add_filter( 'rx_load_elementor_style_controller', function( $data ) {
			return $this->get_settings_for_display();
		});

		$rx_template_type = $this->get_settings_for_display();
		update_option('rx_template_type', $rx_template_type['rx_template_type'] );		
	
		setup_postdata( $product->get_id() );
		wc_get_template( 'single-product/tabs/tabs.php' );

		// On render widget from Editor - trigger the init manually.
		if ( wp_doing_ajax() ) {
			?>
			<script>
				jQuery( '.wc-tabs-wrapper, .woocommerce-tabs, #rating' ).trigger( 'init' );
			</script>
			<?php
		}
	}

    /**
     *
     */
	public function render_plain_content() {}
}