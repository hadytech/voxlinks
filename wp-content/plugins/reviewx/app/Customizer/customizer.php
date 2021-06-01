<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * ReviewX Theme Customizer
 *
 * @package ReviewX
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */

/**
 * Check for WP_Customizer_Control existence before adding custom control because WP_Customize_Control
 * is loaded on customizer page only
 *
 * @see _wp_customize_include()
 */


function reviewx_customize_register( $wp_customize ) {

	// Get default customizer values
	$defaults = reviewx_get_option_defaults();
	$template = get_option( '_rx_option_template_style' );
	$graph    = get_option( '_rx_option_graph_style' );

	// Load custom controls
	require_once( REVIEWX_ROOT_DIR_PATH . 'app/Customizer/controls.php' );
	require_once( REVIEWX_ROOT_DIR_PATH . 'app/Customizer/sanitize.php' );

	// Advanced Design
	$wp_customize->add_section( 'reviewx_advanced_designs_page_settings' , array(
		'title'      => __('Advance Designs','reviewx'),
		'priority'   => 100
	) );	
	
	// Review Statistics
	require_once( REVIEWX_ROOT_DIR_PATH . 'app/Customizer/styles-controller/review-statistics.php' );
	require_once( REVIEWX_ROOT_DIR_PATH . 'app/Customizer/styles-controller/graph-criteria.php' );
	require_once( REVIEWX_ROOT_DIR_PATH . 'app/Customizer/styles-controller/filtering-bar.php' );	
	require_once( REVIEWX_ROOT_DIR_PATH . 'app/Customizer/styles-controller/review-item.php' );		


	$wp_customize->add_section( 'reviewx_modify_label_settings' , array(
		'title'      => __('Modify Labels','reviewx'),
		'priority'   => 101
	) );
	require_once( REVIEWX_ROOT_DIR_PATH . 'app/Customizer/labels/form.php' );		


	// Create custom panels
	$wp_customize->add_panel( 'reviewx_customize_options', array(
		'priority' 			=> 30,
		'theme_supports' 	=> '',
		'title' 			=> __( 'ReviewX', 'reviewx' ),
		'description' 		=> __( 'Controls the design settings for the theme.', 'reviewx' ),
	) );

	// Assign sections to panels
	$wp_customize->get_section('reviewx_advanced_designs_page_settings')->panel = 'reviewx_customize_options';
	$wp_customize->get_section('reviewx_modify_label_settings')->panel = 'reviewx_customize_options';

}
add_action( 'customize_register', 'reviewx_customize_register' );

require_once( REVIEWX_ROOT_DIR_PATH . 'app/Customizer/output-css.php' );