<?php

/**
 * Rvx Component Class
 * 
 * @since 2.0
 */

class RVX_Oxygen_Summary extends CT_Component {

    public $param_array;
    public $css_util;
    public $query;

    function __construct($options) {

        // run initialization
        $this->init( $options );

        // $this->register_properties();

        // Add shortcodes
       add_shortcode( $this->options['tag'], array( $this, 'add_shortcode' ) );

        // change component button place
        remove_action("ct_toolbar_fundamentals_list", array( $this, "component_button" ) );
        add_action("oxy_folder_wordpress_components", array( $this, "component_button" ) );
        
    }
    
    /**
     * Add a [oxy_comment_form] shortcode to WordPress
     *
     * @since 2.0
     * @author Louis & Ilya
     */

    function add_shortcode( $atts, $content, $name ) {

        if ( ! $this->validate_shortcode( $atts, $content, $name ) ) {
            return '';
        }
        
        $atts = $this->set_options( $atts );

        $this->param_array = shortcode_atts(
            array(
                'product_id' => "",
            ), $atts, $this->options['tag'] );

        $this->param_array["product_id"] = esc_attr($atts['product_id']);
        echo do_shortcode("[rvx-summary product_id='".$atts['product_id']."']");

    }

	function component_button() { 
		$icon = str_replace(" ", "", (strtolower($this->options['name']))); ?>

		<div class='oxygen-add-section-element'
			data-searchid="<?php echo strtolower( preg_replace('/\s+/', '_', sanitize_text_field( $this->options['name'] ) ) ) ?>"
			ng-click="iframeScope.addComponent('<?php echo esc_attr( $this->options['tag'] ); ?>')">
			<img src='<?php echo plugin_dir_url(__FILE__) . 'assets/'. $icon .'.svg'; ?>' />
			<img src='<?php echo plugin_dir_url(__FILE__) . 'assets/'. $icon; ?>-active.svg' />
			<?php echo sanitize_text_field( $this->options['name'] ); ?>
		</div>
	
	<?php }    

    /**
     * Map parameters to CSS properties
     *
     * @since 2.0
     * @author Louis
     */

    function register_properties() {

        $this->cssutil = new Oxygen_VSB_CSS_Util;

        $this->cssutil->register_selector('input, textarea');
        $this->cssutil->map_property('product_id', 'border-color', 'input, textarea');
    }


    /**
     * Output CSS based on user params
     *
     * @since 2.0
     * @author Louis
     */

    function css() {

        if(is_array($this->param_array)) {
            echo $this->cssutil->generate_css($this->param_array);
        }
    }

}

// Create component instance
global $oxygen_vsb_components;
$oxygen_vsb_components['rvx_summary'] = new RVX_Oxygen_Summary( array(
            'name'  => __('ReviewX Summary','reviewx'),
            'tag'   => 'oxy_rvx_summary',
            'params' 	=> array(
                array(
                    "param_name" 	=> "product_id",
                    "value" 		=> "",
                    "type" 			=> "textfield",
                    "heading" 		=> __("Product Id","reviewx"),
                    "css" 			=> false,
                ),
            ), 
            'advanced'  => array(
                "positioning" => array(
                        "values"    => array (
                            'width'      => '100',
                            'width-unit' => '%',
                            )
                    ),
                "other" => array(
                    "values" => array(
                        'product_id' => "",
                    )
                )
            ),
            'not_css_params' => array(
                        'product_id',
            )
        ));