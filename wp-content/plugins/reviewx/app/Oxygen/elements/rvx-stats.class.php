<?php

/**
 * Rvx Component Class
 * 
 * @since 2.0
 */

class RVX_Oxygen_Stats extends CT_Component {

    public $param_array;
    public $css_util;
    public $query;

    function __construct($options) {

        // run initialization
        $this->init( $options );

        // $this->register_properties();

        // change component button place
        remove_action("ct_toolbar_fundamentals_list", array( $this, "component_button" ) );
        add_action("oxy_folder_wordpress_components", array( $this, "component_button" ) );

        // add_filter( 'template_include', array( $this, 'ct_shortcode_single_template'), 100 );

        // Add shortcodes
       add_shortcode( $this->options['tag'], array( $this, 'add_shortcode' ) );
        
        // render preveiew with AJAX
        add_filter("template_include", array( $this, "single_template"), 100 );
        
    }

    function ct_shortcode_single_template( $template ) {

		$new_template = '';

		if(isset($_REQUEST['action']) && stripslashes($_REQUEST['action']) == 'ct_render_shortcode') {
			$nonce  	= $_REQUEST['nonce'];
			$post_id 	= $_REQUEST['post_id'];
			
			// check nonce
			if ( ! wp_verify_nonce( $nonce, 'oxygen-nonce-' . $post_id ) ) {
			    // This nonce is not valid.
			    die( 'Security check' );
			}
            
            
			if ( file_exists('oxygen/component-framework/components/layouts/shortcode.php') ) {
				$new_template = 'oxygen/component-framework/components/layouts/shortcode.php';
			}
		}

		if ( '' != $new_template ) {
				return $new_template ;
			}

		return $template;
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

        ob_start();
        echo do_shortcode("[rvx-stats product_id='".$atts['product_id']."']");
        return ob_get_clean();

    }


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
$oxygen_vsb_components['rvx_stats'] = new RVX_Oxygen_Stats( array(
            'name'  => __('ReviewX Stats','reviewx'),
            'tag'   => 'oxy_rvx_stats',
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