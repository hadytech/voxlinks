<?php

class RVX_Builder_Module_Woocommerce_Tabs extends ET_Builder_Module_Tabs {
	/**
	 * Define WooCommerce Tabs property.
	 */

	/**
	 * A stack of the current active theme builder layout post type.
	 *
	 * @var string[]
	 */

	public function init() {
		// Inherit tabs module property.
		parent::init();

		// Define WooCommerce Tabs module property; overwriting inherited property.
		$this->name   					= esc_html__( 'ReviewX Woo Tabs', 'reviewx' );
		$this->plural 					= esc_html__( 'ReviewX Woo Tabs', 'reviewx' );
		// $this->slug   					= 'rvx_et_pb_wc_tabs';	
		$this->slug   					= 'et_pb_wc_tabs_for_ReviewX';			
		$this->vb_support 				= 'on';
		$this->main_css_element         = '%%order_class%%.et_pb_toggle';

		/*
		 * Set property for holding rendering data so the data rendering via
		 * ET_Builder_Module_Woocommerce_Tabs::get_tabs() is only need to be done once.
		 */
		$this->rendered_tabs_data = array();

		// Remove module item.
		$this->child_slug      = 'rvx_et_pb_wc_tab';
		// $this->child_slug      = null;
		$this->child_item_text = null;

		// Set WooCommerce Tabs specific toggle / options group.
		$this->settings_modal_toggles['general']['toggles']['main_content'] = array(
			'title'    => et_builder_i18n( 'Content' ),
			'priority' => 10,
		);

		$this->advanced_fields['fonts']['tab']['font_size']   = array(
			'default' => '14px',
		);
		$this->advanced_fields['fonts']['tab']['line_height'] = array(
			'default' => '1.7em',
		);

		$pro_features = \ReviewX_Helper::is_pro() ? array(
			'rvx_review_helpful' => array(
				'label'           => esc_html__( 'Helpful Text', 'reviewx' ),
				'css'             => array(
					'main'      => ".rx_listing .rx_review_block .rx_body .rx_meta .rx_review_vote_icon p, 
					.rx_listing_style_2 .rx_review_block .rx_body .rx_meta .rx_review_vote_icon p",
					'important' => 'plugin_only',
				),
				'hide_text_color' => true,
				'default_from'    => 'title',
				'line_height'     => array(
					'default' => '1.7em',
				),
				'font_size'       => array(
					'default' => '16px',
				),
				'letter_spacing'  => array(
					'default' => '0px',
				),
			),

			'rvx_review_share' => array(
				'label'           => esc_html__( 'Share', 'reviewx' ),
				'css'             => array(
					'main'      => ".rx_listing .rx_review_block .rx_body .rx_meta .rx_share p,
					.rx_listing_style_2 .rx_review_block .rx_body .rx_meta .rx_share p",
					'important' => 'plugin_only',
				),
				'hide_text_color' => true,
				'default_from'    => 'title',
				'line_height'     => array(
					'default' => '1.7em',
				),
				'font_size'       => array(
					'default' => '16px',
				),
				'letter_spacing'  => array(
					'default' => '0px',
				),
			),
								
			'rvx_review_form_external_video_link' => array(
				'label'           => esc_html__( 'External Vide Link', 'reviewx' ),
				'css'             => array(
					'main'      => '.rx-review-form-area-style-1 #review_form .rx-note-video, .rx-review-form-area-style-2 #review_form .rx-note-video',
					'important' => 'plugin_only',
				),
				'hide_text_color' => true,
				'default_from'    => 'title',
				'line_height'     => array(
					'default' => '1.7em',
				),
				'font_size'       => array(
					'default' => '16px',
				),
				'letter_spacing'  => array(
					'default' => '0px',
				),
			),			
		) : [];

		$this->advanced_fields = array(
			'fonts'           => array_merge( $pro_features, 
				array(
					'rvx_review_section' => array(
						'label'           => esc_html__( 'Section Title', 'reviewx' ),
						'css'             => array(
							'main'      => ".woocommerce-Reviews-title",
							'important' => 'plugin_only',
						),
						'hide_text_color' => true,
						'default_from'    => 'title',
						'line_height'     => array(
							'default' => '1.7em',
						),
						'font_size'       => array(
							'default' => '16px',
						),
						'letter_spacing'  => array(
							'default' => '0px',
						),
					),

					'rvx_review_average_count' => array(
						'label'           => esc_html__( 'Average Count', 'reviewx' ),
						'css'             => array(
							'main'      => ".rx-temp-rating .rx-temp-rating-number p",
							'important' => 'plugin_only',
						),
						'hide_text_color' => true,
						'default_from'    => 'title',
						'line_height'     => array(
							'default' => '1.7em',
						),
						'font_size'       => array(
							'default' => '16px',
						),
						'letter_spacing'  => array(
							'default' => '0px',
						),
					),			
		
					'rvx_review_highest_rating' => array(
						'label'           => esc_html__( 'Highest Rating', 'reviewx' ),
						'css'             => array(
							'main'      => ".rx-temp-rating .rx-temp-rating-number span",
							'important' => 'plugin_only',
						),
						'hide_text_color' => true,
						'default_from'    => 'title',
						'line_height'     => array(
							'default' => '1.7em',
						),
						'font_size'       => array(
							'default' => '16px',
						),
						'letter_spacing'  => array(
							'default' => '0px',
						),
					),

					'rvx_review_average_text' => array(
						'label'           => esc_html__( 'Average Text', 'reviewx' ),
						'css'             => array(
							'main'      => ".rx-temp-total-rating-count p",
							'important' => 'plugin_only',
						),
						'hide_text_color' => true,
						'default_from'    => 'title',
						'line_height'     => array(
							'default' => '1.7em',
						),
						'font_size'       => array(
							'default' => '16px',
						),
						'letter_spacing'  => array(
							'default' => '0px',
						),
					),

					'rvx_review_recommendation_count' => array(
						'label'           => esc_html__( 'Recommendation Count', 'reviewx' ),
						'css'             => array(
							'main'      => ".rx_recommended_box .rx_recommended_box_heading",
							'important' => 'plugin_only',
						),
						'hide_text_color' => true,
						'default_from'    => 'title',
						'line_height'     => array(
							'default' => '1.7em',
						),
						'font_size'       => array(
							'default' => '16px',
						),
						'letter_spacing'  => array(
							'default' => '0px',
						),
					),

					'rvx_review_recommendation_text' => array(
						'label'           => esc_html__( 'Recommendation Text', 'reviewx' ),
						'css'             => array(
							'main'      => ".rx_recommended_box .rx_recommended_box_content",
							'important' => 'plugin_only',
						),
						'hide_text_color' => true,
						'default_from'    => 'title',
						'line_height'     => array(
							'default' => '1.7em',
						),
						'font_size'       => array(
							'default' => '16px',
						),
						'letter_spacing'  => array(
							'default' => '0px',
						),
					),

					'rvx_review_graph_criteria' => array(
						'label'           => esc_html__( 'Criteria Name', 'reviewx' ),
						'css'             => array(
							'main'      => ".rx-graph-style-2 .progress-bar-t, .rx_style_two_free_progress_bar .progressbar-title, .vertical .vertical_bar_label",
							'important' => 'plugin_only',
						),
						'hide_text_color' => true,
						'default_from'    => 'title',
						'line_height'     => array(
							'default' => '1.7em',
						),
						'font_size'       => array(
							'default' => '16px',
						),
						'letter_spacing'  => array(
							'default' => '0px',
						),
					),
					
					'rvx_review_progress_bar' => array(
						'label'           => esc_html__( 'Progress Bar Text', 'reviewx' ),
						'css'             => array(
							'main'      => ".rx-horizontal .progress-fill span, .rx_style_one_progress.orange .rx_style_one_progress-icon, .rx_style_one_progress.orange .rx_style_one_progress-value, .rx_style_two_free_progress_bar .progress .progress-bar span, .vertical .progress-fill",
							'important' => 'plugin_only',
						),
						'hide_text_color' => true,
						'default_from'    => 'title',
						'line_height'     => array(
							'default' => '1.7em',
						),
						'font_size'       => array(
							'default' => '16px',
						),
						'letter_spacing'  => array(
							'default' => '0px',
						),
					),
					
					'rvx_review_filtering_bar' => array(
						'label'           => esc_html__( 'Filter Bar Text', 'reviewx' ),
						'css'             => array(
							'main'      => ".rx-filter-bar .rx_filter_header h4, .rx-filter-bar .rx-short-by h4, 
							.rx-filter-bar-style-2 .rx_filter_header h4, .rx-filter-bar-style-2 .rx-short-by h4",
							'important' => 'plugin_only',
						),
						'hide_text_color' => true,
						'default_from'    => 'title',
						'line_height'     => array(
							'default' => '1.7em',
						),
						'font_size'       => array(
							'default' => '16px',
						),
						'letter_spacing'  => array(
							'default' => '0px',
						),
					),	
					
					'rvx_review_filtering_dropdown' => array(
						'label'           => esc_html__( 'Dropdown Text', 'reviewx' ),
						'css'             => array(
							'main'      => ".rx-filter-bar .rx_review_shorting_2 .box select, 
							.rx-filter-bar-style-2 .rx_review_shorting_2 .box select",
							'important' => 'plugin_only',
						),
						'hide_text_color' => true,
						'default_from'    => 'title',
						'line_height'     => array(
							'default' => '1.7em',
						),
						'font_size'       => array(
							'default' => '16px',
						),
						'letter_spacing'  => array(
							'default' => '0px',
						),
					),

					'rvx_review_author' => array(
						'label'           => esc_html__( 'Reviewer Name', 'reviewx' ),
						'css'             => array(
							'main'      => ".rx_listing .rx_review_block .rx_author_info .rx_author_name h4, 
							.rx_listing_style_2 .rx_review_block .rx_author_info .rx_author_name h4",
							'important' => 'plugin_only',
						),
						'hide_text_color' => true,
						'default_from'    => 'title',
						'line_height'     => array(
							'default' => '1.7em',
						),
						'font_size'       => array(
							'default' => '16px',
						),
						'letter_spacing'  => array(
							'default' => '0px',
						),
					),

					'rvx_review_title' => array(
						'label'           => esc_html__( 'Review Title', 'reviewx' ),
						'css'             => array(
							'main'      => ".rx_listing .rx_review_block .review_title, 
							.rx_listing_style_2 .rx_review_block .review_title",
							'important' => 'plugin_only',
						),
						'hide_text_color' => true,
						'default_from'    => 'title',
						'line_height'     => array(
							'default' => '1.7em',
						),
						'font_size'       => array(
							'default' => '16px',
						),
						'letter_spacing'  => array(
							'default' => '0px',
						),
					),

					'rvx_review_text' => array(
						'label'           => esc_html__( 'Review Text', 'reviewx' ),
						'css'             => array(
							'main'      => ".rx_listing .rx_review_block .rx_body p, 
							.rx_listing_style_2 .rx_review_block .rx_body p",
							'important' => 'plugin_only',
						),
						'hide_text_color' => true,
						'default_from'    => 'title',
						'line_height'     => array(
							'default' => '1.7em',
						),
						'font_size'       => array(
							'default' => '16px',
						),
						'letter_spacing'  => array(
							'default' => '0px',
						),
					),

					'rvx_review_date' => array(
						'label'           => esc_html__( 'Review Date', 'reviewx' ),
						'css'             => array(
							'main'      => ".rx_listing .rx_review_block .rx_body .rx_review_calender, 
							.rx_listing_style_2 .rx_review_block .rx_body .rx_review_calender",
							'important' => 'plugin_only',
						),
						'hide_text_color' => true,
						'default_from'    => 'title',
						'line_height'     => array(
							'default' => '1.7em',
						),
						'font_size'       => array(
							'default' => '16px',
						),
						'letter_spacing'  => array(
							'default' => '0px',
						),
					),
					
					'rvx_review_verified_badge' => array(
						'label'           => esc_html__( 'Verified Badge', 'reviewx' ),
						'css'             => array(
							'main'      => ".rx_listing .rx_review_block .rx_body .rx_varified .rx_varified_user span, 
							.rx_listing_style_2 .rx_review_block .rx_body .rx_varified .rx_varified_user",
							'important' => 'plugin_only',
						),
						'hide_text_color' => true,
						'default_from'    => 'title',
						'line_height'     => array(
							'default' => '1.7em',
						),
						'font_size'       => array(
							'default' => '16px',
						),
						'letter_spacing'  => array(
							'default' => '0px',
						),
					),
					
					'rvx_review_pagination' => array(
						'label'           => esc_html__( 'Pagination', 'reviewx' ),
						'css'             => array(
							'main'      => ".rx_listing_style_1 .rx_pagination a, 
							.rx_listing_container_style_2 .rx_pagination a",
							'important' => 'plugin_only',
						),
						'hide_text_color' => true,
						'default_from'    => 'title',
						'line_height'     => array(
							'default' => '1.7em',
						),
						'font_size'       => array(
							'default' => '16px',
						),
						'letter_spacing'  => array(
							'default' => '0px',
						),
					),
					
					'rvx_review_form_criteria_text' => array(
						'label'           => esc_html__( 'Criteria Text', 'reviewx' ),
						'css'             => array(
							'main'      => '.rx-review-form-area-style-1 .rx-criteria-table td, .rx-review-form-area-style-2 .rx-criteria-table td',
							'important' => 'plugin_only',
						),
						'hide_text_color' => true,
						'default_from'    => 'title',
						'line_height'     => array(
							'default' => '1.7em',
						),
						'font_size'       => array(
							'default' => '16px',
						),
						'letter_spacing'  => array(
							'default' => '0px',
						),
					),
											
					'rvx_review_form_submit_button' => array(
						'label'           => esc_html__( 'Submit Button', 'reviewx' ),
						'css'             => array(
							'main'      => '.rx-review-form-area-style-1 #review_form input[type="submit"], 
							.rx-review-form-area-style-1 #review_form input[type="submit"]:focus, .rx-review-form-area-style-2 #review_form input[type="submit"], 
							.rx-review-form-area-style-2 #review_form input[type="submit"]:focus',
							'important' => 'plugin_only',
						),
						'hide_text_color' => true,
						'default_from'    => 'title',
						'line_height'     => array(
							'default' => '1.7em',
						),
						'font_size'       => array(
							'default' => '16px',
						),
						'letter_spacing'  => array(
							'default' => '0px',
						),
					),
				)			
			)
		);

		$this->help_videos = array(
			array(
				'id'   => '7X03vBPYJ1o',
				'name' => esc_html__( 'Divi WooCommerce Modules', 'reviewx' ),
			),
		);

	}

	/**
	 * Get product all possible tabs data
	 *
	 * @since 3.29
	 * @since 4.4.2   Fix to include Custom tabs.
	 *
	 * @global WP_Post    $post    WordPress Post.
	 * @global WC_Product $product WooCommerce Product.
	 *
	 * @return array
	 */
	public function get_product_tabs() {
		static $tabs = null;

		if ( ! is_null( $tabs ) ) {
			return $tabs;
		}

		global $post, $product;

		// Save existing $post and $product global.
		$original_post    = $post;
		$original_product = $product;

		$post_id = 'product' === $this->get_post_type()
			? ET_Builder_Element::get_current_post_id()
			: ET_Builder_Module_Helper_Woocommerce_Modules::get_product_id( 'latest' );

		// Overwriting global $post is necessary as WooCommerce relies on it.
		$post    = get_post( $post_id );
		$product = wc_get_product( $post_id );

		/*
		 * Get relevant product tabs data. Product tabs hooks use global based conditional
		 * for adding / removing product tabs data via filter hoook callback, hence the
		 * need to overwrite the global for determining product tabs data
		 */
		$tabs = is_object( $product )
			? apply_filters( 'woocommerce_product_tabs', array() )
			: ET_Builder_Module_Helper_Woocommerce_Modules::get_default_product_tabs();

		// Reset $post and $product global.
		$post    = $original_post;
		$product = $original_product;

		/*
		 * Always return all possible tabs
		 */
		return $tabs;
	}

	/**
	 * Get product tabs options; product data formatted for checkbox control's options
	 *
	 * @since 3.29
	 *
	 * @return array
	 */
	public function get_tab_options() {
		$tabs    = $this->get_product_tabs();
		$options = array();

		foreach ( $tabs as $name => $tab ) {
			if ( ! isset( $tab['title'] ) ) {
				continue;
			}

			$options[ $name ] = array(
				'value' => $name,
				'label' => 'reviews' === $name ? esc_html__( 'Reviews', 'reviewx' ) :
					esc_html( $tab['title'] ),
			);
		}

		return $options;
	}

	/**
	 * Get product tabs default based on product tabs options
	 *
	 * @since 3.29
	 *
	 * @return string
	 */
	public function get_tab_defaults() {
		return implode( '|', array_keys( $this->get_product_tabs() ) );
	}

	/**
	 * Define Woo Tabs fields
	 *
	 * @since 3.29
	 *
	 * @return array
	 */
	public function get_fields() {		

		$fields = array_merge(
			parent::get_fields(),
			array(
				'product'      => ET_Builder_Module_Helper_Woocommerce_Modules::get_field(
					'product',
					array(
						'default'          => ET_Builder_Module_Helper_Woocommerce_Modules::get_product_default(),
						'computed_affects' => array(
							'__tabs',
							'include_tabs',
						),
					)
				),
				'include_tabs' => array(
					'label'               => esc_html__( 'Include Tabs', 'et_builder' ),
					'type'                => 'checkboxes_advanced_woocommerce',
					'option_category'     => 'configuration',
					'default'             =>
						ET_Builder_Module_Helper_Woocommerce_Modules::get_woo_default_tabs(),
					'description'         => esc_html__( 'Here you can select the tabs that you would like to display.', 'et_builder' ),
					'toggle_slug'         => 'main_content',
					'mobile_options'      => true,
					'hover'               => 'tabs',
					'computed_depends_on' => array(
						'product',
					),
				),
				'__tabs'       => array(
					'type'                => 'computed',
					'computed_callback'   => array(
						'RVX_Builder_Module_Woocommerce_Tabs',
						'get_tabs',
					),
					'computed_depends_on' => array(
						'product',
					),
					'computed_minimum'    => array(
						'product',
					),
				),				
				'rvx_review_summary'             => array(
					'label'            => esc_html__( 'Review Summary', 'reviewx' ),
					'description'      => esc_html__( 'If you would like to show the review summary, you must first enable this option.', 'reviewx' ),
					'type'             => 'yes_no_button',
					'options'          => array(
						'off' => et_builder_i18n( 'No' ),
						'on'  => et_builder_i18n( 'Yes' ),
					),
					'default_on_front' => 'on',
					'toggle_slug'      => 'rvx_review_settings',
					'option_category'  => 'basic_option',
				),
				'rvx_review_list'             => array(
					'label'            => esc_html__( 'Review List', 'reviewx' ),
					'description'      => esc_html__( 'If you would like to show the review list, you must first enable this option.', 'reviewx' ),
					'type'             => 'yes_no_button',
					'options'          => array(
						'off' => et_builder_i18n( 'No' ),
						'on'  => et_builder_i18n( 'Yes' ),
					),
					'default_on_front' => 'on',
					'affects'          => array(
						'rvx_review_filter',
					),
					'depends_show_if'  => 'on',
					'toggle_slug'      => 'rvx_review_settings',
					'option_category'  => 'basic_option',
				),	
				'rvx_review_filter'             => array(
					'label'            => esc_html__( 'Review Filter', 'reviewx' ),
					'description'      => esc_html__( 'If you would like to show the review filter, you must first enable this option.', 'reviewx' ),
					'type'             => 'yes_no_button',
					'options'          => array(
						'off' => et_builder_i18n( 'No' ),
						'on'  => et_builder_i18n( 'Yes' ),
					),
					'default_on_front' => 'on',
					'depends_show_if'  => 'on',
					'toggle_slug'      => 'rvx_review_settings',
					'option_category'  => 'basic_option',
				),
				'rvx_review_form'             => array(
					'label'            => esc_html__( 'Review Form', 'reviewx' ),
					'description'      => esc_html__( 'If you would like to show the review form, you must first enable this option.', 'reviewx' ),
					'type'             => 'yes_no_button',
					'options'          => array(
						'off' => et_builder_i18n( 'No' ),
						'on'  => et_builder_i18n( 'Yes' ),
					),
					'default_on_front' => 'on',
					'toggle_slug'      => 'rvx_review_settings',
					'option_category'  => 'basic_option',
				),					
				'rvx_review_section_title'  => array(
					'label'           		=> esc_html__( '', 'reviewx' ),
					'type'            		=> 'text',
					'option_category' 		=> 'basic_option',
					'description' 			=> esc_html__('', 'reviewx'),
					'toggle_slug' 			=> 'rvx_review_section',					
				),				
				
				'rvx_template_type'  => array(
					'label'           		=> esc_html__( '', 'reviewx' ),
					'type'            		=> 'select',
					'option_category'   	=> 'basic_option',
					'options'         		=> array(
						'template_style_one'  	=> et_builder_i18n( 'Classic' ),
						'template_style_two' 	=> et_builder_i18n( 'Box Style' ),
					),
					'default'        		=> 'template_style_one',
					'toggle_slug'     		=> 'rvx_review_template',
					'description'     		=> esc_html__( '', 'reviewx' ),
					'mobile_options'  		=> true,
					'hover'               	=> 'tabs',									
				),
				'rvx_review_section_title_color' => array(
					'label'          		=> esc_html__( 'Section Title Text Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_section',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
				),
				'rvx_review_section_title_font_size' => array(
					'label'            => esc_html__( 'Section Title Font Size', 'reviewx' ),
					'description'      => esc_html__( '', 'reviewx' ),
					'type'             => 'range',
					'option_category'  => 'font_option',
					'tab_slug'         => 'advanced',
					'toggle_slug'      => 'rvx_review_section',
					'default'          => '16px',
					'default_unit'     => 'px',
					'default_on_front' => '',
					'range_settings'   => array(
						'min'  => '1',
						'max'  => '120',
						'step' => '1',
					),
					'mobile_options'   => true,
					'sticky'           => true,
					'depends_show_if'  => 'on',
					'hover'            => 'tabs',
				),				
				// Review Statistics 
				'rvx_average_count_color'       => array(
					'label'          => esc_html__( 'Average Count Color ', 'reviewx' ),
					'description'    => esc_html__( '', 'reviewx' ),
					'type'           => 'color-alpha',
					'custom_color'   => true,
					'tab_slug'       => 'advanced',
					'toggle_slug'    => 'rvx_review_average_count',
					'hover'          => 'tabs',
					'mobile_options' => true,
					'sticky'         => true,
				),				
				'rvx_average_count_font_size' => array(
					'label'            => esc_html__( 'Average Count Font Size', 'reviewx' ),
					'description'      => esc_html__( '', 'reviewx' ),
					'type'             => 'range',
					'option_category'  => 'font_option',
					'tab_slug'         => 'advanced',
					'toggle_slug'      => 'rvx_review_average_count',
					'default'          => '16px',
					'default_unit'     => 'px',
					'default_on_front' => '',
					'range_settings'   => array(
						'min'  => '1',
						'max'  => '120',
						'step' => '1',
					),
					'mobile_options'   => true,
					'sticky'           => true,
					'depends_show_if'  => 'on',
					'hover'            => 'tabs',
				),					
				'rvx_highest_rating_color'       => array(
					'label'          => esc_html__( 'Highest Color ', 'reviewx' ),
					'description'    => esc_html__( '', 'reviewx' ),
					'type'           => 'color-alpha',
					'custom_color'   => true,
					'tab_slug'       => 'advanced',
					'toggle_slug'    => 'rvx_review_highest_rating',
					'hover'          => 'tabs',
					'mobile_options' => true,
					'sticky'         => true,
				),				
				'rvx_highest_rating_font_size' => array(
					'label'            => esc_html__( 'Highest Font Size', 'reviewx' ),
					'description'      => esc_html__( '', 'reviewx' ),
					'type'             => 'range',
					'option_category'  => 'font_option',
					'tab_slug'         => 'advanced',
					'toggle_slug'      => 'rvx_review_highest_rating',
					'default'          => '16px',
					'default_unit'     => 'px',
					'default_on_front' => '',
					'range_settings'   => array(
						'min'  => '1',
						'max'  => '120',
						'step' => '1',
					),
					'mobile_options'   => true,
					'sticky'           => true,
					'depends_show_if'  => 'on',
					'hover'            => 'tabs',
				),				
				//Star rating
				'rvx_review_star_rating_color' => array(
					'label'          		=> esc_html__( 'Star Rating Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_average_rating',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
				),
				'rvx_review_star_rating_size' => array(
					'label'            => esc_html__( 'Star Rating Size', 'reviewx' ),
					'description'      => esc_html__( '', 'reviewx' ),
					'type'             => 'range',
					'option_category'  => 'font_option',
					'tab_slug'         => 'advanced',
					'toggle_slug'      => 'rvx_review_average_rating',
					'default'          => '16px',
					'default_unit'     => 'px',
					'default_on_front' => '',
					'range_settings'   => array(
						'min'  => '1',
						'max'  => '120',
						'step' => '1',
					),
					'mobile_options'   => true,
					'sticky'           => true,
					'depends_show_if'  => 'on',
					'hover'            => 'tabs',
				),				
				'rvx_average_text_color'       => array(
					'label'          => esc_html__( 'Average Text Color ', 'reviewx' ),
					'description'    => esc_html__( '', 'reviewx' ),
					'type'           => 'color-alpha',
					'custom_color'   => true,
					'tab_slug'       => 'advanced',
					'toggle_slug'    => 'rvx_review_average_text',
					'hover'          => 'tabs',
					'mobile_options' => true,
					'sticky'         => true,
				),				
				'rvx_recommendation_count_color'       => array(
					'label'          => esc_html__( 'Recommendation Count Color ', 'reviewx' ),
					'description'    => esc_html__( '', 'reviewx' ),
					'type'           => 'color-alpha',
					'custom_color'   => true,
					'tab_slug'       => 'advanced',
					'toggle_slug'    => 'rvx_review_recommendation_count',
					'hover'          => 'tabs',
					'mobile_options' => true,
					'sticky'         => true,
				),				
				'rvx_recommendation_text'       => array(
					'label'          => esc_html__( 'Recommendation Text Color', 'reviewx' ),
					'description'    => esc_html__( '', 'reviewx' ),
					'type'           => 'color-alpha',
					'custom_color'   => true,
					'tab_slug'       => 'advanced',
					'toggle_slug'    => 'rvx_review_recommendation_text',
					'hover'          => 'tabs',
					'mobile_options' => true,
					'sticky'         => true,
				),					
				'rvx_review_graph_criteria' => array(
					'label'           		=> esc_html__('', 'reviewx'),
					'type'            		=> 'select',
					'option_category' 		=> 'basic_option',
					'description'     		=> esc_html__( '', 'reviewx' ),
					'toggle_slug'     		=> 'rvx_review_graph_criteria',
					'options'         		=> \ReviewX_Helper::is_pro() ? array(
						'graph_style_default'  		=> et_builder_i18n( 'Horizontal Style One' ),
						'graph_style_one' 			=> et_builder_i18n( 'Horizontal Style Two' ),
						'graph_style_two_free'  	=> et_builder_i18n( 'Horizontal Style Three' ),
						'graph_style_three' 		=> et_builder_i18n( 'Vertical Style One' ),													
					): array(
						'graph_style_default'  		=> et_builder_i18n( 'Horizontal Style One' ),
						'graph_style_one' 			=> et_builder_i18n( 'Horizontal Style Two' ),
						'graph_style_two_free'  	=> et_builder_i18n( 'Horizontal Style Three' ),												
					),
					'default'        		=> 'graph_style_two_free',
					'mobile_options'  		=> true,
					'hover'               	=> 'tabs'
				),				
				'rvx_review_graph_criteria_color' => array(
					'label'          		=> esc_html__( 'Criteria Name Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_graph_criteria',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
				),					
				'rvx_review_progressbar_text_color' => array(
					'label'          		=> esc_html__( 'Progress-bar Text Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_progress_bar',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
				),
				'rvx_review_progressbar_bg_color' => array(
					'label'          		=> esc_html__( 'Progress-bar BG Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_progress_bar',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
				),
				'rvx_review_progressbar_border_color' => array(
					'label'          		=> esc_html__( 'Progress-bar Border Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_progress_bar',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_review_graph_criteria' => 'graph_style_one'
					),
				),								
			),
			array( //Template One			
				'rvx_template_one_filter_background_color' => array(
					'label'          		=> esc_html__( 'Filter Background Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_filtering_bar',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				),								
				'rvx_template_one_filtering_bar_color' => array(
					'label'          		=> esc_html__( 'Filter Bar Text Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_filtering_bar',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				),	
				'rvx_template_one_filtering_dropdown_color' => array(
					'label'          		=> esc_html__( 'Dropdown Background Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_filtering_dropdown',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				),				
				'rvx_template_one_filtering_dropdown_text_color' => array(
					'label'          		=> esc_html__( 'Dropdown Text Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_filtering_dropdown',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				),					
				'rvx_template_one_filtering_dropdown_selector_color' => array(
					'label'          		=> esc_html__( 'Dropdown Icon Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_filtering_dropdown',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				),				
				'rvx_template_one_filtering_dropdown_bar_color' => array(
					'label'          		=> esc_html__( 'Dropdown Bar Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_filtering_dropdown',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				),
				'rvx_template_one_author_text_color' => array(
					'label'          		=> esc_html__( 'Reviewer Name Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_author',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				),				
				'rvx_template_one_rating_color' => array(
					'label'          		=> esc_html__( 'Star Rating Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_rating',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				),				
				'rvx_template_one_rating_size' => array(
					'label'            => esc_html__( 'Star Rating Size', 'reviewx' ),
					'description'      => esc_html__( '', 'reviewx' ),
					'type'             => 'range',
					'option_category'  => 'font_option',
					'tab_slug'         => 'advanced',
					'toggle_slug'      => 'rvx_review_rating',
					'default'          => '16px',
					'default_unit'     => 'px',
					'default_on_front' => '',
					'range_settings'   => array(
						'min'  => '1',
						'max'  => '120',
						'step' => '1',
					),
					'mobile_options'   => true,
					'sticky'           => true,
					'depends_show_if'  => 'on',
					'hover'            => 'tabs',
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				),				
				'rvx_template_one_title_color' => array(
					'label'          		=> esc_html__( 'Review Title Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_title',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				),
				'rvx_template_one_text_color' => array(
					'label'          		=> esc_html__( 'Review Text Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_text',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				),
				'rvx_template_one_date_color' => array(
					'label'          		=> esc_html__( 'Review Date Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_date',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				),				
				'rvx_template_one_date_icon_color' => array(
					'label'          		=> esc_html__( 'Review Date Icon Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_date',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				),
				'rvx_template_one_attachment_position' => array(
					'label'           		=> esc_html__('', 'reviewx'),
					'type'            		=> 'select',
					'option_category' 		=> 'advanced',
					'description'     		=> esc_html__( '', 'reviewx' ),
					'toggle_slug'     		=> 'rvx_review_attachment',
					'options'         		=> array(
						'left'  			=> et_builder_i18n( 'Left' ),
						'right' 			=> et_builder_i18n( 'Right' ),											
					),
					'default'        		=> 'left',
					'mobile_options'  		=> true,
					'hover'               	=> 'tabs',
					'show_if' 				=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				),				
				'rvx_template_one_verified_badge_color' => array(
					'label'          		=> esc_html__( 'Verified Text Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_verified_badge',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				),					
				'rvx_template_one_verified_badge_icon_color' => array(
					'label'          		=> esc_html__( 'Verified Badge Icon Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_verified_badge',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				),
				'rvx_template_one_helpful_text_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Helpful Text Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_helpful',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				) : '',				
				'rvx_template_one_helpful_button_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Helpful Button BG Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_helpful',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				) : '', 								
				'rvx_template_one_helpful_thumbsup_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Helpful Thumbs-up Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_helpful',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				) : '',	
				'rvx_template_one_helpful_thumbsup_count_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Helpful Thumbs-up Count Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_helpful',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				) : '',								
				'rvx_template_one_share_text_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Share Text Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_share',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				) : '',				
				'rvx_template_one_share_icon_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Share Icon Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_share',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),
				) : '',				
				'rvx_template_one_facebook_icon_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Facebook Icon Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_share',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				) : '',	
				'rvx_template_one_twitter_icon_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Twitter Icon Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_share',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				) : '',
				'rvx_template_one_highlight_icon_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Highlight Icon Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_highlight',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				) : '',				
				
				'rvx_template_one_highlight_border_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Highlight Border Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_highlight',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				) : '',	

				'rvx_template_one_container_bg_color' => array(
					'label'          		=> esc_html__( 'Background Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_container',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				),	

				'rvx_template_one_top_border_color' => array(
					'label'          		=> esc_html__( 'Top Border Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_container',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				),								
				'rvx_template_one_container_border_color' => array(
					'label'          		=> esc_html__( 'Border Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_container',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				),	

				/*********Pagination*************/
				'rvx_template_one_pagination_text_color' => array(
					'label'          		=> esc_html__( 'Text Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_pagination',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				),

				'rvx_template_one_pagination_bg_color' => array(
					'label'          		=> esc_html__( 'Background Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_pagination',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				),

				'rvx_template_one_pagination_active_color' => array(
					'label'          		=> esc_html__( 'Active Text Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_pagination',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				),

				'rvx_template_one_pagination_active_bg_color' => array(
					'label'          		=> esc_html__( 'Active Background Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_pagination',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				),				

				'rvx_template_one_pagination_hover_text_color' => array(
					'label'          		=> esc_html__( 'Hover Text Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_pagination',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				),

				'rvx_template_one_pagination_hover_bg_color' => array(
					'label'          		=> esc_html__( 'Hover BG Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_pagination',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,					
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				),
			),
            array(  //Template One - Store reply (PRO)
				'rvx_template_one_store_logo_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Store Logo Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_store_reply',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one',
					),	
				) : '',
				'rvx_template_one_store_logo_bg_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Store Logo Background Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_store_reply',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				) : '',				
				'rvx_template_one_store_logo_border_radius' => \ReviewX_Helper::is_pro() ? array(
					'label'            => esc_html__( 'Store Logo Border Radius', 'reviewx' ),
					'description'      => esc_html__( '', 'reviewx' ),
					'type'             => 'range',
					'option_category'  => 'font_option',
					'tab_slug'         => 'advanced',
					'toggle_slug'      => 'rvx_review_store_reply',
					'default'          => '16px',
					'default_unit'     => 'px',
					'default_on_front' => '',
					'range_settings'   => array(
						'min'  => '1',
						'max'  => '120',
						'step' => '1',
					),
					'mobile_options'   => true,
					'sticky'           => true,
					'depends_show_if'  => 'on',
					'hover'            => 'tabs',
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),
				) : '',
				'rvx_template_one_store_name_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Store Name Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_store_reply',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				) : '',	
				'rvx_template_one_store_reply_back_icon_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Reply Back Icon Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_store_reply',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				) : '',
				'rvx_template_one_store_reply_text_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Reply Text Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_store_reply',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				) : '',
				'rvx_template_one_store_reply_date_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Reply Date Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_store_reply',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				) : '',
				'rvx_template_one_store_reply_date_icon_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Reply Date Icon Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_store_reply',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				) : '',
				'rvx_template_one_store_reply_date_edit_icon_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Reply Edit Icon Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_store_reply',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				) : '',
				'rvx_template_one_store_reply_date_delete_icon_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Reply Delete Icon Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_store_reply',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				) : '',
				'rvx_template_one_store_reply_button_text_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Reply Button Text Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_store_reply',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				) : '',	
				'rvx_template_one_store_reply_button_bg_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Reply Button BG Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_store_reply',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				) : '',	
				'rvx_template_one_store_reply_button_border_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Reply Button Border Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_store_reply',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				) : '',
				'rvx_template_one_store_reply_form_bgcolor' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Background Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_store_reply_form',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				) : '',
				'rvx_template_one_store_reply_form_border_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Border Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_store_reply_form',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				) : '',	
				'rvx_template_one_store_reply_form_border_radius' => \ReviewX_Helper::is_pro() ? array(
					'label'            => esc_html__( 'Reply Form Border Radius', 'reviewx' ),
					'description'      => esc_html__( '', 'reviewx' ),
					'type'             => 'range',
					'option_category'  => 'font_option',
					'tab_slug'         => 'advanced',
					'toggle_slug'      => 'rvx_review_store_reply_form',
					'default'          => '16px',
					'default_unit'     => 'px',
					'default_on_front' => '',
					'range_settings'   => array(
						'min'  => '1',
						'max'  => '120',
						'step' => '1',
					),
					'mobile_options'   => true,
					'sticky'           => true,
					'depends_show_if'  => 'on',
					'hover'            => 'tabs',
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				) : '',
				'rvx_template_one_store_reply_form_title_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Reply Form Title Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_store_reply_form',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				) : '',
				'rvx_template_one_store_reply_form_textarea_bgcolor' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Text Area Background Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_store_reply_form',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				) : '',
				'rvx_template_one_store_reply_form_button_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Submit Button Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_store_reply_form',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				) : '',
				'rvx_template_one_store_reply_form_button_text_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Submit Button Text Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_store_reply_form',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				) : '',
				'rvx_template_one_store_reply_form_cancel_button_bg_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Cancel Button BG Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_store_reply_form',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				) : '',																														
				'rvx_template_one_store_reply_form_cancel_button_border_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Cancel Button Border Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_store_reply_form',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				) : '',
				'rvx_template_one_store_reply_form_cancel_button_text_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Cancel Button Text Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_store_reply_form',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				) : '',																
			),
			array(//Template One -Review Form
				'rvx_template_one_form_rating_type' => array(
					'label'           		=> esc_html__('', 'reviewx'),
					'type'            		=> 'select',
					'option_category' 		=> 'basic_option',
					'description'     		=> esc_html__( '', 'reviewx' ),
					'toggle_slug'     		=> 'rvx_review_rating_type',
					'options'         		=> \ReviewX_Helper::is_pro() ? array(
						'rating_style_one'  	=> et_builder_i18n( 'Star Rating' ),
						'rating_style_two' 		=> et_builder_i18n( 'Thumbs Rating' ),
						'rating_style_three'  	=> et_builder_i18n( 'Faces Rating' ),
												
					): array(
						'rating_style_one'  	=> et_builder_i18n( 'Star Rating' ),											
					),
					'default'        		=> 'rating_style_one',
					'mobile_options'  		=> true,
					'hover'               	=> 'tabs',
					'show_if' 				=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				),
				'rvx_template_one_form_criteria_color' => array(
					'label'          		=> esc_html__( 'Criteria Text Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_form_criteria_text',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				),
				'rvx_template_one_form_rating_color' => array(
					'label'          		=> esc_html__( 'Rating Icon Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_form_rating_icon_color',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				),
				'rvx_template_one_form_recommendation_label_color' => array(
					'label'          		=> esc_html__( 'Recommendation Label Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_form_recommendation_label',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				),				
				'rvx_template_one_form_icon_active_color' => array(
					'label'          		=> esc_html__( 'Recommendation Icon Active Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_form_recommendation_icon',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				),
				'rvx_template_one_form_external_video_link_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'External Example Video Link Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_form_external_video_link',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				) : '',	
				'rvx_template_one_form_submit_button_text_color' => array(
					'label'          		=> esc_html__( 'Submit Button Text Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_form_submit_button',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				),	
				'rvx_template_one_form_submit_button_bg_color' => array(
					'label'          		=> esc_html__( 'Submit Button Background Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_form_submit_button',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),	
				),
				'rvx_template_one_form_submit_button_border_radius' => array(
					'label'            => esc_html__( 'Submit Button Border Radius', 'reviewx' ),
					'description'      => esc_html__( '', 'reviewx' ),
					'type'             => 'range',
					'option_category'  => 'font_option',
					'tab_slug'         => 'advanced',
					'toggle_slug'      => 'rvx_review_form_submit_button',
					'default'          => '16px',
					'default_unit'     => 'px',
					'default_on_front' => '',
					'range_settings'   => array(
						'min'  => '1',
						'max'  => '120',
						'step' => '1',
					),
					'mobile_options'   => true,
					'sticky'           => true,
					'depends_show_if'  => 'on',
					'hover'            => 'tabs',
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_one'
					),
				),																																		
			),						
			array(//Template Two 
				'rvx_template_two_filter_background_color' => array(
					'label'          		=> esc_html__( 'Filter Background Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_filtering_bar',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				),								
				'rvx_template_two_filtering_bar_color' => array(
					'label'          		=> esc_html__( 'Filter Bar Text Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_filtering_bar',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				),	
				'rvx_template_two_filtering_dropdown_color' => array(
					'label'          		=> esc_html__( 'Dropdown Background Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_filtering_dropdown',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				),				
				'rvx_template_two_filtering_dropdown_text_color' => array(
					'label'          		=> esc_html__( 'Dropdown Text Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_filtering_dropdown',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				),					
				'rvx_template_two_filtering_dropdown_selector_color' => array(
					'label'          		=> esc_html__( 'Dropdown Icon Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_filtering_dropdown',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				),				
				'rvx_template_two_filtering_dropdown_bar_color' => array(
					'label'          		=> esc_html__( 'Dropdown Bar Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_filtering_dropdown',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				),
				'rvx_template_two_author_text_color' => array(
					'label'          		=> esc_html__( 'Reviewer Name Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_author',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				),				
				'rvx_template_two_rating_color' => array(
					'label'          		=> esc_html__( 'Star Rating Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_rating',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				),				
				'rvx_template_two_rating_size' => array(
					'label'            => esc_html__( 'Star Rating Size', 'reviewx' ),
					'description'      => esc_html__( '', 'reviewx' ),
					'type'             => 'range',
					'option_category'  => 'font_option',
					'tab_slug'         => 'advanced',
					'toggle_slug'      => 'rvx_review_rating',
					'default'          => '16px',
					'default_unit'     => 'px',
					'default_on_front' => '',
					'range_settings'   => array(
						'min'  => '1',
						'max'  => '120',
						'step' => '1',
					),
					'mobile_options'   => true,
					'sticky'           => true,
					'depends_show_if'  => 'on',
					'hover'            => 'tabs',
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				),				
				'rvx_template_two_title_color' => array(
					'label'          		=> esc_html__( 'Review Title Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_title',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				),
				'rvx_template_two_text_color' => array(
					'label'          		=> esc_html__( 'Review Text Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_text',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				),
				'rvx_template_two_background_color' => array(
					'label'          		=> esc_html__( 'Review Background Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_text',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				),				
				'rvx_template_two_date_color' => array(
					'label'          		=> esc_html__( 'Review Date Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_date',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				),				
				'rvx_template_two_date_icon_color' => array(
					'label'          		=> esc_html__( 'Review Date Icon Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_date',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				),
				'rvx_template_two_attachment_position' => array(
					'label'           		=> esc_html__('', 'reviewx'),
					'type'            		=> 'select',
					'option_category' 		=> 'advanced',
					'description'     		=> esc_html__( '', 'reviewx' ),
					'toggle_slug'     		=> 'rvx_review_attachment',
					'options'         		=> array(
						'left'  			=> et_builder_i18n( 'Left' ),
						'right' 			=> et_builder_i18n( 'Right' ),											
					),
					'default'        		=> 'left',
					'mobile_options'  		=> true,
					'hover'               	=> 'tabs',
					'show_if' 				=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				),				
				'rvx_template_two_verified_badge_color' => array(
					'label'          		=> esc_html__( 'Verified Text Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_verified_badge',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				),					
				'rvx_template_two_verified_badge_icon_color' => array(
					'label'          		=> esc_html__( 'Verified Badge Icon Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_verified_badge',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				),
				'rvx_template_two_helpful_text_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Helpful Text Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_helpful',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				) : '',				
				'rvx_template_two_helpful_button_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Helpful Button Bg Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_helpful',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				) : '',								
				'rvx_template_two_helpful_thumbsup_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Helpful Thumbs-up Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_helpful',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				) : '',	
				'rvx_template_two_helpful_thumbsup_count_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Helpful Thumbs-up Count Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_helpful',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				) : '',								
				'rvx_template_two_share_text_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Share Text Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_share',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				) : '',				
				'rvx_template_two_share_icon_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Share Icon Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_share',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),
				) : '',				
				'rvx_template_two_facebook_icon_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Facebook Icon Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_share',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				) : '',	
				'rvx_template_two_twitter_icon_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Twitter Icon Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_share',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				) : '',
				'rvx_template_two_highlight_icon_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Highlight Icon Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_highlight',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				) : '',

				'rvx_template_two_highlight_bg_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Highlight Background Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_highlight',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				) : '',				
				'rvx_template_two_reply_highlight_bg_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Reply Highlight Background Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_highlight',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				) : '',	
				
				/*********Template Two Pagination*************/
				'rvx_template_two_pagination_text_color' => array(
					'label'          		=> esc_html__( 'Text Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_pagination',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				),
				
				'rvx_template_two_pagination_bg_color' => array(
					'label'          		=> esc_html__( 'Background Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_pagination',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				),
				
				'rvx_template_two_pagination_active_color' => array(
					'label'          		=> esc_html__( 'Active Text Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_pagination',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				),
				
				'rvx_template_two_pagination_active_bg_color' => array(
					'label'          		=> esc_html__( 'Active Background Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_pagination',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				),				
				
				'rvx_template_two_pagination_hover_text_color' => array(
					'label'          		=> esc_html__( 'Hover Text Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_pagination',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				),
				
				'rvx_template_two_pagination_hover_bg_color' => array(
					'label'          		=> esc_html__( 'Hover BG Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_pagination',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				),	
			),
            array( //Template Two -Store reply (PRO)
				'rvx_template_two_store_logo_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Store Logo Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_store_reply',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				) : '',
				'rvx_template_two_store_logo_bg_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Store Logo Background Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_store_reply',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				) : '',				
				'rvx_template_two_store_logo_border_radius' => \ReviewX_Helper::is_pro() ? array(
					'label'            => esc_html__( 'Store Logo Border Radius', 'reviewx' ),
					'description'      => esc_html__( '', 'reviewx' ),
					'type'             => 'range',
					'option_category'  => 'font_option',
					'tab_slug'         => 'advanced',
					'toggle_slug'      => 'rvx_review_store_reply',
					'default'          => '16px',
					'default_unit'     => 'px',
					'default_on_front' => '',
					'range_settings'   => array(
						'min'  => '1',
						'max'  => '120',
						'step' => '1',
					),
					'mobile_options'   => true,
					'sticky'           => true,
					'depends_show_if'  => 'on',
					'hover'            => 'tabs',
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),
				) : '',
				'rvx_template_two_store_name_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Store Name Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_store_reply',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				) : '',	
				'rvx_template_two_store_reply_back_icon_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Reply Back Icon Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_store_reply',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				) : '',
				'rvx_template_two_store_reply_text_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Reply Text Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_store_reply',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				) : '',
				'rvx_template_two_store_reply_date_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Reply Date Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_store_reply',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				) : '',
				'rvx_template_two_store_reply_date_icon_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Reply Date Icon Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_store_reply',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				) : '',
				'rvx_template_two_store_reply_date_edit_icon_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Reply Edit Icon Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_store_reply',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				) : '',
				'rvx_template_two_store_reply_date_delete_icon_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Reply Delete Icon Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_store_reply',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				) : '',
				'rvx_template_two_store_reply_button_text_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Reply Button Text Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_store_reply',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				) : '',	
				'rvx_template_two_store_reply_button_bg_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Reply Button BG Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_store_reply',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				) : '',	
				'rvx_template_two_store_reply_button_border_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Reply Button Border Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_store_reply',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				) : '',
				'rvx_template_two_store_reply_form_bgcolor' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Background Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_store_reply_form',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				) : '',
				'rvx_template_two_store_reply_form_border_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Border Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_store_reply_form',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				) : '',	
				'rvx_template_two_store_reply_form_border_radius' => \ReviewX_Helper::is_pro() ? array(
					'label'            => esc_html__( 'Reply Form Border Radius', 'reviewx' ),
					'description'      => esc_html__( '', 'reviewx' ),
					'type'             => 'range',
					'option_category'  => 'font_option',
					'tab_slug'         => 'advanced',
					'toggle_slug'      => 'rvx_review_store_reply_form',
					'default'          => '16px',
					'default_unit'     => 'px',
					'default_on_front' => '',
					'range_settings'   => array(
						'min'  => '1',
						'max'  => '120',
						'step' => '1',
					),
					'mobile_options'   => true,
					'sticky'           => true,
					'depends_show_if'  => 'on',
					'hover'            => 'tabs',
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				) : '',
				'rvx_template_two_store_reply_form_title_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Reply Form Title Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_store_reply_form',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				) : '',
				'rvx_template_two_store_reply_form_textarea_bgcolor' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Text Area Background Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_store_reply_form',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				) : '',
				'rvx_template_two_store_reply_form_button_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Submit Button Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_store_reply_form',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				) : '',
				'rvx_template_two_store_reply_form_button_text_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Submit Button Text Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_store_reply_form',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				) : '',
				'rvx_template_two_store_reply_form_cancel_button_bg_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Cancel Button BG Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_store_reply_form',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				) : '',																														
				'rvx_template_two_store_reply_form_cancel_button_border_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Cancel Button Border Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_store_reply_form',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				) : '',
				'rvx_template_two_store_reply_form_cancel_button_text_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'Cancel Button Text Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_store_reply_form',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				) : '',								
			),
			array(//Template Two -Review Form
				'rvx_template_two_form_rating_type' => array(
					'label'           		=> esc_html__('', 'reviewx'),
					'type'            		=> 'select',
					'option_category' 		=> 'basic_option',
					'description'     		=> esc_html__( '', 'reviewx' ),
					'toggle_slug'     		=> 'rvx_review_rating_type',
					'options'         		=> \ReviewX_Helper::is_pro() ? array(
						'rating_style_one'  	=> et_builder_i18n( 'Star Rating' ),
						'rating_style_two' 		=> et_builder_i18n( 'Thumbs Rating' ),
						'rating_style_three'  	=> et_builder_i18n( 'Faces Rating' ),
												
					): array(
						'rating_style_one'  	=> et_builder_i18n( 'Star Rating' ),											
					),
					'default'        		=> 'rating_style_one',
					'mobile_options'  		=> true,
					'hover'               	=> 'tabs',
					'show_if' 				=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				),
				'rvx_template_two_form_criteria_color' => array(
					'label'          		=> esc_html__( 'Criteria Text Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_form_criteria_text',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				),
				'rvx_template_two_form_rating_color' => array(
					'label'          		=> esc_html__( 'Rating Icon Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_form_rating_icon_color',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				),
				'rvx_template_two_form_recommendation_label_color' => array(
					'label'          		=> esc_html__( 'Recommendation Label Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_form_recommendation_label',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				),					
				'rvx_template_two_form_icon_active_color' => array(
					'label'          		=> esc_html__( 'Recommendation Icon Active Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_form_recommendation_icon',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				),
				'rvx_template_two_form_external_video_link_color' => \ReviewX_Helper::is_pro() ? array(
					'label'          		=> esc_html__( 'External Example Video Link Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_form_external_video_link',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				) : '',	
				'rvx_template_two_form_submit_button_text_color' => array(
					'label'          		=> esc_html__( 'Submit Button Text Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_form_submit_button',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				),	
				'rvx_template_two_form_submit_button_bg_color' => array(
					'label'          		=> esc_html__( 'Submit Button Background Color', 'reviewx' ),
					'description'    		=> esc_html__( '', 'reviewx' ),
					'type'           		=> 'color-alpha',
					'custom_color'   		=> true,
					'tab_slug'       		=> 'advanced',
					'toggle_slug'    		=> 'rvx_review_form_submit_button',
					'hover'          		=> 'tabs',
					'mobile_options' 		=> true,
					'sticky'         		=> true,
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),	
				),
				'rvx_template_two_form_submit_button_border_radius' => array(
					'label'            => esc_html__( 'Submit Button Border Radius', 'reviewx' ),
					'description'      => esc_html__( '', 'reviewx' ),
					'type'             => 'range',
					'option_category'  => 'font_option',
					'tab_slug'         => 'advanced',
					'toggle_slug'      => 'rvx_review_form_submit_button',
					'default'          => '16px',
					'default_unit'     => 'px',
					'default_on_front' => '',
					'range_settings'   => array(
						'min'  => '1',
						'max'  => '120',
						'step' => '1',
					),
					'mobile_options'   => true,
					'sticky'           => true,
					'depends_show_if'  => 'on',
					'hover'            => 'tabs',
					'show_if' 	=> array(
						'rvx_template_type' => 'template_style_two'
					),
				),																																		
			)					
		);

		return $fields;
	}

	public function get_settings_modal_toggles() {
		return array(
		  'advanced' 	=> array(
			'toggles' 	=> array(
			  'rvx_review_template'  => array(
				'tabbed_subtoggles' => true,
				'title' 			=> esc_html__('Review Template', 'reviewx'),
			  ),				
			  'rvx_review_section'  => array(
				'tabbed_subtoggles' => true,
				'title' 			=> esc_html__('Review Section Title', 'reviewx'),
			  ),
			  'rvx_review_average_count'  => array(
				'tabbed_subtoggles' => true,
				'title' 			=> esc_html__('Average Count', 'reviewx'),
			  ),
			  'rvx_review_highest_rating'  => array(
				'tabbed_subtoggles' => true,
				'title' 			=> esc_html__('Highest Rating', 'reviewx'),
			  ),
			  'rvx_review_average_rating'  => array(
				'tabbed_subtoggles' => true,
				'title' 			=> esc_html__('Star Rating', 'reviewx'),
			  ),
			  'rvx_review_average_text'  => array(
				'tabbed_subtoggles' => true,
				'title' 			=> esc_html__('Average Text', 'reviewx'),
			  ),
			  'rvx_review_recommendation_count'  => array(
				'tabbed_subtoggles' => true,
				'title' 			=> esc_html__('Recommendation Count', 'reviewx'),
			  ),	
			  'rvx_review_recommendation_text'  => array(
				'tabbed_subtoggles' => true,
				'title' 			=> esc_html__('Recommendation Text', 'reviewx'),
			  ),
			  'rvx_review_graph_criteria'  => array(
				'tabbed_subtoggles' => true,
				'title' 			=> esc_html__('Graph of Review Criteria', 'reviewx'),
			  ),
			  'rvx_review_progress_bar'  => array(
				'tabbed_subtoggles' => true,
				'title' 			=> esc_html__('Progress Bar', 'reviewx'),
			  ),
			  'rvx_review_filtering_bar'  => array(
				'tabbed_subtoggles' => true,
				'title' 			=> esc_html__('Filter Bar', 'reviewx'),
			  ),
			  'rvx_review_filtering_dropdown'  => array(
				'tabbed_subtoggles' => true,
				'title' 			=> esc_html__('Filter Dropdown', 'reviewx'),
			  ),
			  'rvx_review_author'  => array(
				'tabbed_subtoggles' => true,
				'title' 			=> esc_html__('Reviewer Information', 'reviewx'),
			  ),			  
			  'rvx_review_rating'  => array(
				'tabbed_subtoggles' => true,
				'title' 			=> esc_html__('Review Rating', 'reviewx'),
			  ),
			  'rvx_review_title'  => array(
				'tabbed_subtoggles' => true,
				'title' 			=> esc_html__('Review Title', 'reviewx'),
			  ),
			  'rvx_review_text'  => array(
				'tabbed_subtoggles' => true,
				'title' 			=> esc_html__('Review Text', 'reviewx'),
			  ),
			  'rvx_review_date'  => array(
				'tabbed_subtoggles' => true,
				'title' 			=> esc_html__('Review Date', 'reviewx'),
			  ),
			  'rvx_review_attachment'  => array(
				'tabbed_subtoggles' => true,
				'title' 			=> esc_html__('Attachment Position', 'reviewx'),
			  ),			  	
			  'rvx_review_verified_badge'  => array(
				'tabbed_subtoggles' => true,
				'title' 			=> esc_html__('Verified Badge', 'reviewx'),
			  ),
			  'rvx_review_helpful'  => array(
				'tabbed_subtoggles' => true,
				'title' 			=> esc_html__('Helpful Text', 'reviewx'),
			  ),	
			  'rvx_review_highlight'  => array(
				'tabbed_subtoggles' => true,
				'title' 			=> esc_html__('Review Highlight', 'reviewx'),
			  ),			  
			  'rvx_review_container'  => array(
				'tabbed_subtoggles' => true,
				'title' 			=> esc_html__('Review Container', 'reviewx'),
			  ),
			  'rvx_review_store_reply'  => array(
				'tabbed_subtoggles' => true,
				'title' 			=> esc_html__('Store Reply', 'reviewx'),
			  ),
			  'rvx_review_store_reply_form'  => array(
				'tabbed_subtoggles' => true,
				'title' 			=> esc_html__('Store Reply Form', 'reviewx'),
			  ),
			  'rvx_review_pagination'  => array(
				'tabbed_subtoggles' => true,
				'title' 			=> esc_html__('Pagination', 'reviewx'),
			  ),	
			  'rvx_review_rating_type'  => array(
				'tabbed_subtoggles' => true,
				'title' 			=> esc_html__('Review Rating Type', 'reviewx'),
			  ),			  
			  'rvx_review_form_criteria_text'  => array(
				'tabbed_subtoggles' => true,
				'title' 			=> esc_html__('Criteria Text', 'reviewx'),
			  ),			  
			  'rvx_review_form_rating_icon_color'  => array(
				'tabbed_subtoggles' => true,
				'title' 			=> esc_html__('Rating Icon Color', 'reviewx'),
			  ),
			  'rvx_review_form_recommendation_label'  => array(
				'tabbed_subtoggles' => true,
				'title' 			=> esc_html__('Recommendation Label Color', 'reviewx'),
			  ),			  
			  'rvx_review_form_recommendation_icon'  => array(
				'tabbed_subtoggles' => true,
				'title' 			=> esc_html__('Recomm. Icon Active Color', 'reviewx'),
			  ),			  			  
			  'rvx_review_form_external_video_link'  => array(
				'tabbed_subtoggles' => true,
				'title' 			=> esc_html__('External Video Link', 'reviewx'),
			  ),
			  'rvx_review_form_submit_button'  => array(
				'tabbed_subtoggles' => true,
				'title' 			=> esc_html__('Submit Button', 'reviewx'),
			  ),			  		  			  
			),
		  ),		  
		);
	}	

	/**
	 * Get tabs nav output
	 *
	 * @since 3.29
	 *
	 * @return string
	 */
	public function get_tabs_nav() {
		$nav   = '';
		$index = 0;

		// get_tabs_content() method is called earlier so get_tabs_nav() can reuse tabs data.
		if ( ! empty( $this->rendered_tabs_data ) ) {
			foreach ( $this->rendered_tabs_data as $name => $tab ) {
				$index ++;

				$nav .= sprintf(
					'<li class="%3$s%1$s"><a href="#">%2$s</a></li>',
					( 1 === $index ? ' et_pb_tab_active' : '' ),
					esc_html( $tab['title'] ),
					sprintf( '%1$s_tab', esc_attr( $name ) )
				);
			}
		}

		return $nav;
	}

	/**
	 * Get tabs content output
	 *
	 * @since 4.4.1 Fix [embed][/embed] shortcodes not working in tab content
	 * @since 3.29
	 *
	 * @return string
	 */
	public function get_tabs_content() {
		// Get tabs data.				
		$this->rendered_tabs_data = self::get_tabs(
			array(
				'product'      => $this->props['product'],
				'include_tabs' => $this->props['include_tabs'],
			)
		);

		// Add tabs module classname.
		$this->add_classname( 'et_pb_tabs' );

		include_once 'rvxtabs_review_summary.php';
		include_once 'rvxtabs_template_one_styles.php';
		include_once 'rvxtabs_template_two_styles.php';

		// Render tabs content output.
		$index   = 0;
		$content = '';

		foreach ( $this->rendered_tabs_data as $name => $tab ) {
			$index ++;

			$content .= sprintf(
				'<div class="et_pb_tab clearfix%2$s">
					<div class="et_pb_tab_content">
						%1$s
					</div><!-- .et_pb_tab_content" -->
				</div>',
				$tab['content'],
				1 === $index ? ' et_pb_active_content' : ''
			);
		}
	
		$product_id = apply_filters('rx_product_id_for_divi', true);
		update_post_meta($product_id, '_rx_option_divi_settings', $this->props);
		
		return $content;
	}

	/**
	 * Load comments template.
	 *
	 * @param string $template template to load.
	 * @return string
	 */
	public static function comments_template_loader( $template ) {
		if ( ! et_builder_tb_enabled() ) {
			return $template;
		}

		$check_dirs = array(
			trailingslashit( get_stylesheet_directory() ) . WC()->template_path(),
			trailingslashit( get_template_directory() ) . WC()->template_path(),
			trailingslashit( get_stylesheet_directory() ),
			trailingslashit( get_template_directory() ),
			trailingslashit( WC()->plugin_path() ) . 'templates/',
		);

		if ( WC_TEMPLATE_DEBUG_MODE ) {
			$check_dirs = array( array_pop( $check_dirs ) );
		}

		foreach ( $check_dirs as $dir ) {
			if ( file_exists( trailingslashit( $dir ) . 'single-product-reviews.php' ) ) {
				return trailingslashit( $dir ) . 'single-product-reviews.php';
			}
		}
	}

	/**
	 * Get tabs data
	 *
	 * @since 4.0.9 Avoid fetching Tabs content using `the_content` when editing TB layout.
	 *
	 * @param array $args Additional args.
	 *
	 * @return array
	 */
	public static function get_tabs( $args = array() ) {
		global $product, $post, $wp_query;
		/*
		 * Visual builder fetches all tabs data and filter the included tab on the app to save
		 * app to server request for faster user experience. Frontend passes `includes_tab` to
		 * this method so it only process required tabs
		 */
		$defaults = array(
			'product' => 'current',
		);
		$args['product'] = 'current';
		$args     = wp_parse_args( $args, $defaults );

		// Get actual product id based on given `product` attribute.
		$product_id = ET_Builder_Module_Helper_Woocommerce_Modules::get_product_id( $args['product'] );
		add_filter( 'rx_product_id_for_divi', function( $args ) {
			global $product;
			return $product->get_id();
		});

		// Determine whether current tabs data needs global variable overwrite or not.
		$overwrite_global = et_builder_wc_need_overwrite_global( $args['product'] );

		// Check if TB is used
		$is_tb = et_builder_tb_enabled();

		if ( $is_tb ) {
			et_theme_builder_wc_set_global_objects();
		} elseif ( $overwrite_global ) {
			// Save current global variable for later reset.
			$original_product  = $product;
			$original_post     = $post;
			$original_wp_query = $wp_query;

			// Overwrite global variable.
			$post     = get_post( $product_id );
			$product  = wc_get_product( $product_id );
			$wp_query = new WP_Query( array( 'p' => $product_id ) );
		}

		// Get product tabs.
		$all_tabs    = apply_filters( 'woocommerce_product_tabs', array() );
		$active_tabs = isset( $args['include_tabs'] ) ? explode( '|', $args['include_tabs'] ) : false;
		$tabs        = array();

		// Get product tabs data.
		foreach ( $all_tabs as $name => $tab ) {
			// Skip if current tab is not included, based on `include_tabs` attribute value.
			if ( $active_tabs && ! in_array( $name, $active_tabs, true ) ) {
				continue;
			}

			if ( 'description' === $name ) {
				if ( ! et_builder_tb_enabled() && ! et_pb_is_pagebuilder_used( $product_id ) ) {
					// If selected product doesn't use builder, retrieve post content.
					if ( et_theme_builder_overrides_layout( ET_THEME_BUILDER_BODY_LAYOUT_POST_TYPE ) ) {
						$tab_content = apply_filters( 'et_builder_wc_description', $post->post_content );
					} else {
						$tab_content = $post->post_content;
					}
				} else {
					/*
					 * Description can't use built in callback data because it gets `the_content`
					 * which might cause infinite loop; get Divi's long description from
					 * post meta instead.
					 */
					if ( et_builder_tb_enabled() ) {
						$placeholders = et_theme_builder_wc_placeholders();

						$tab_content = $placeholders['description'];
					} else {
						$tab_content = get_post_meta( $product_id, ET_BUILDER_WC_PRODUCT_LONG_DESC_META_KEY, true );

						// Cannot use `the_content` filter since it adds content wrapper.
						// Content wrapper added at
						// `includes/builder/core.php`::et_builder_add_builder_content_wrapper()
						// This filter is documented at
						// includes/builder/feature/woocommerce-modules.php
						$tab_content = apply_filters( 'et_builder_wc_description', $tab_content );
					}
				}
			} else {
				// Get tab value based on defined product tab's callback attribute.
				ob_start();
				// @phpcs:ignore Generic.PHP.ForbiddenFunctions.Found
				call_user_func( $tab['callback'], $name, $tab );
				$tab_content = ob_get_clean();
			}

			// Populate product tab data.
			$tabs[ $name ] = array(
				'name'    => $name,
				'title'   => $tab['title'],
				'content' => $tab_content,
			);
		}

		// Reset overwritten global variable.
		if ( $is_tb ) {
			et_theme_builder_wc_reset_global_objects();
		} elseif ( $overwrite_global ) {
			$product  = $original_product;
			$post     = $original_post;
			$wp_query = $original_wp_query;
		}

		return $tabs;
	}

	/**
	 * Gets Multi view attributes to the Outer wrapper.
	 *
	 * Since we do not have control over the WooCommerce Breadcrumb markup, we inject Multi view
	 * attributes on to the Outer wrapper.
	 *
	 * @used-by ET_Builder_Module_Tabs::render()
	 *
	 * @return string
	 */
	public function get_multi_view_attrs() {
		$multi_view = et_pb_multi_view_options( $this );

		$multi_view_attrs = $multi_view->render_attrs(
			array(
				'attrs'  => array(
					'data-include_tabs' => '{{include_tabs}}',
				),
				'target' => '%%order_class%%',
			)
		);

		return $multi_view_attrs;
	}

	/**
	 * Get current post's post type.
	 *
	 * @return string
	 */
	public function get_post_type() {
		global $post, $et_builder_post_type;

		// phpcs:disable WordPress.Security.NonceVerification -- This function does not change any state, and is therefore not susceptible to CSRF.
		if ( isset( $_POST['et_post_type'] ) && ! $et_builder_post_type ) {
			$et_builder_post_type = sanitize_text_field( $_POST['et_post_type'] );
		}
		// phpcs:enable

		if ( is_a( $post, 'WP_POST' ) && ( is_admin() || ! isset( $et_builder_post_type ) ) ) {
			return $post->post_type;
		} else {
			$layout_type = ET_Builder_Element::get_theme_builder_layout_type();

			if ( $layout_type ) {
				return $layout_type;
			}

			return isset( $et_builder_post_type ) ? $et_builder_post_type : 'post';
		}
	}
	
	/**
	 * Get the current theme builder layout.
	 * Returns 'default' if no layout has been started.
	 *
	 * @since 4.0
	 *
	 * @return string
	 */
	public static function get_theme_builder_layout_type() {
		$count = count( ET_Builder_Element::$theme_builder_layout );

		if ( $count > 0 ) {
			return ET_Builder_Element::$theme_builder_layout[ $count - 1 ]['type'];
		}

		return 'default';
	}
}

new RVX_Builder_Module_Woocommerce_Tabs();