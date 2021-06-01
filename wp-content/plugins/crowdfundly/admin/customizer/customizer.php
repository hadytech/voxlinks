<?php 
/**
 * WordPress theme Customizer Class.
 *
 * @since      1.0.0
 * @package    Crowdfundly
 * @author     WPDeveloper 
 */
class CrowdFundly_Customize {

	function __construct() {
		add_action( 'customize_register', [ $this, 'crowdfundly_customizer_settings' ] );
		require_once( CROWDFUNDLY_CUSTOMIZER_DIR_PATH . 'styles.php' );
	}

	/**
	 * callback function for customize_register
     *
     * @param object $wp_customize
	 */
	public function crowdfundly_customizer_settings( $wp_customize ) {
		add_action( 'customize_preview_init', [ $this, 'enqueue_live_edit_js' ] );

		// custom design for pages
		$this->create_sections($wp_customize);

		// custom panel for Crowd Fundly
		$this->create_panel($wp_customize);
	}

	private function create_sections($wp_customize) {
		require_once( CROWDFUNDLY_CUSTOMIZER_DIR_PATH . 'sanitize.php' );

		require_once( CROWDFUNDLY_CUSTOMIZER_DIR_PATH . 'custom-controls/heading-control.php' );
		require_once( CROWDFUNDLY_CUSTOMIZER_DIR_PATH . 'custom-controls/range-control.php' );
		require_once( CROWDFUNDLY_CUSTOMIZER_DIR_PATH . 'custom-controls/switcher.php' );
		require_once( CROWDFUNDLY_CUSTOMIZER_DIR_PATH . 'custom-controls/dimension-control.php' );
		require_once( CROWDFUNDLY_CUSTOMIZER_DIR_PATH . 'custom-controls/select-control.php' );
		require_once( CROWDFUNDLY_CUSTOMIZER_DIR_PATH . 'custom-controls/number-control.php' );

		require_once( CROWDFUNDLY_CUSTOMIZER_DIR_PATH . 'controls/organization-page.php' );
		require_once( CROWDFUNDLY_CUSTOMIZER_DIR_PATH . 'controls/all-campaign-page.php' );
		require_once( CROWDFUNDLY_CUSTOMIZER_DIR_PATH . 'controls/single-campaign-page.php' );

		$wp_customize->add_section( 'cf_organizaton_page' , array(
			'title'      => __( 'Organization Page','crowdfundly' ),
			'priority'   => 30
		) );	
		organization_page($wp_customize);

		$wp_customize->add_section( 'cf_all_campaign_page' , array(
			'title'      => __( 'All Campaign Page','crowdfundly' ),
			'priority'   => 31
		) );	
		all_campaign($wp_customize);

		$wp_customize->add_section( 'cf_single_campaign_page' , array(
			'title'      => __( 'Single Campaign Page','crowdfundly' ),
			'priority'   => 32
		) );	
		single_campaign($wp_customize);
	}

	private function create_panel($wp_customize) {
		$wp_customize->add_panel( 'cf_customize_option', array(
			'priority' 			=> 30,
			'theme_supports' 	=> '',
			'title' 			=> __( 'Crowdfundly', 'crowdfundly' ),
			'description' 		=> __( 'Crowdfundly Pages design.', 'crowdfundly' ),
		) );
		$wp_customize->get_section('cf_organizaton_page')->panel = 'cf_customize_option';
		$wp_customize->get_section('cf_all_campaign_page')->panel = 'cf_customize_option';
		$wp_customize->get_section('cf_single_campaign_page')->panel = 'cf_customize_option';
	}

	public function enqueue_live_edit_js() {
		wp_enqueue_script( 
			'crowdfundly-customizer-js', CROWDFUNDLY_URL . 'admin/customizer/assets/js/customizer.js', array( 'jquery', 'customize-preview' ), CROWDFUNDLY_VERSION . time(), true 
		);
	}

}
