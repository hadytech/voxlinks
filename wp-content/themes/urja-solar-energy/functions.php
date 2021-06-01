<?php
/**
 * urja-solar-energy functions and definitions
 *
 * 
 * @subpackage urja-solar-energy
 * @since 1.0
 */

function urja_solar_energy_setup() {
	
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-background', $defaults = array(
    'default-color'          => '',
    'default-image'          => '',
    'default-repeat'         => '',
    'default-position-x'     => '',
    'default-attachment'     => '',
    'wp-head-callback'       => '_custom_background_cb',
    'admin-head-callback'    => '',
    'admin-preview-callback' => ''
	));

	add_image_size( 'urja-solar-energy-featured-image', 2000, 1200, true );

	add_image_size( 'urja-solar-energy-thumbnail-avatar', 100, 100, true );

	$GLOBALS['content_width'] = 525;
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'urja-solar-energy' ),
		'footer'	=> __('Footer Menu', 'urja-solar-energy'),
	) );

	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Add theme support for Custom Logo.
	add_theme_support( 'custom-logo', array(
		'width'       => 250,
		'height'      => 250,
		'flex-width'  => true,
	) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, and column width.
 	 */
	add_editor_style( array( 'assets/css/editor-style.css', urja_solar_energy_fonts_url() ) );

	// Theme Activation Notice
	global $pagenow;

		if ( is_admin() && ('themes.php' == $pagenow) && isset( $_GET['activated'] ) ) {
		add_action( 'admin_notices', 'urja_solar_energy_activation_notice' );
	}

}
add_action( 'after_setup_theme', 'urja_solar_energy_setup' );

// Notice after Theme Activation
function urja_solar_energy_activation_notice() {
	echo '<div class="notice notice-success is-dismissible start-notice">';
		echo '<h3>'. esc_html__( 'Welcome to Luzuk!!', 'urja-solar-energy' ) .'</h3>';
		echo '<p>'. esc_html__( 'Thank you for choosing Urja Solar Energy theme. It will be our pleasure to have you on our Welcome page to serve you better.', 'urja-solar-energy' ) .'</p>';
		echo '<p><a href="'. esc_url( admin_url( 'themes.php?page=urja_solar_energy_guide' ) ) .'" class="button button-primary">'. esc_html__( 'GET STARTED', 'urja-solar-energy' ) .'</a></p>';
	echo '</div>';
}

function urja_solar_energy_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Blog Sidebar', 'urja-solar-energy' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'urja-solar-energy' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget_container"><h3 class="widget-title">',
		'after_title'   => '</h3></div>',
	) );

	register_sidebar( array(
		'name'          => __( 'Sidebar 2', 'urja-solar-energy' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Add widgets here to appear in your pages and posts', 'urja-solar-energy' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget_container"><h3 class="widget-title">',
		'after_title'   => '</h3></div>',
	) );

	register_sidebar( array(
		'name'          => __( 'Sidebar 3', 'urja-solar-energy' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Add widgets here to appear in your pages and posts', 'urja-solar-energy' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget_container"><h3 class="widget-title">',
		'after_title'   => '</h3></div>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 1', 'urja-solar-energy' ),
		'id'            => 'footer-1',
		'description'   => __( 'Add widgets here to appear in your footer.', 'urja-solar-energy' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 2', 'urja-solar-energy' ),
		'id'            => 'footer-2',
		'description'   => __( 'Add widgets here to appear in your footer.', 'urja-solar-energy' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 3', 'urja-solar-energy' ),
		'id'            => 'footer-3',
		'description'   => __( 'Add widgets here to appear in your footer.', 'urja-solar-energy' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 4', 'urja-solar-energy' ),
		'id'            => 'footer-4',
		'description'   => __( 'Add widgets here to appear in your footer.', 'urja-solar-energy' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'urja_solar_energy_widgets_init' );

function urja_solar_energy_fonts_url(){
	$font_url = '';
	$font_family = array();
	$font_family[] = 'Open Sans:300,300i,400,400i,600,600i,700,700i,800,800i';
	$font_family[] = 'Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i';

	$query_args = array(
		'family'	=> rawurlencode(implode('|',$font_family)),
	);
	$font_url = add_query_arg($query_args,'//fonts.googleapis.com/css');
	return $font_url;
}

//Enqueue scripts and styles.
function urja_solar_energy_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'urja-solar-energy-fonts', urja_solar_energy_fonts_url(), array(), null );
	
	//Bootstarp 
	wp_enqueue_style( 'bootstrap', esc_url(get_template_directory_uri()).'/assets/css/bootstrap.css' );
	
	// Theme stylesheet.
	wp_enqueue_style( 'urja-solar-energy-style', get_stylesheet_uri() );

	// Load the Internet Explorer 9 specific stylesheet, to fix display issues in the Customizer.
	if ( is_customize_preview() ) {
		wp_enqueue_style( 'urja-solar-energy-ie9', get_theme_file_uri( '/assets/css/ie9.css' ), array( 'urja-solar-energy-style' ), '1.0' );
		wp_style_add_data( 'urja-solar-energy-ie9', 'conditional', 'IE 9' );
	}
	// Load the Internet Explorer 8 specific stylesheet.
	wp_enqueue_style( 'urja-solar-energy-ie8', get_theme_file_uri( '/assets/css/ie8.css' ), array( 'urja-solar-energy-style' ), '1.0' );
	wp_style_add_data( 'urja-solar-energy-ie8', 'conditional', 'lt IE 9' );

	//font-awesome
	wp_enqueue_style( 'font-awesome', esc_url(get_template_directory_uri()).'/assets/css/fontawesome-all.css' );
	// Load the html5 shiv.
	wp_enqueue_script( 'html5', get_theme_file_uri( '/assets/js/html5.js' ), array(), '3.7.3' );
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'urja-solar-energy-navigation-jquery', get_theme_file_uri( '/assets/js/navigation.js' ), array( 'jquery' ), '2.1.2', true );
	wp_enqueue_script( 'bootstrap', esc_url(get_template_directory_uri()) . '/assets/js/bootstrap.js', array('jquery') );
	wp_enqueue_script( 'jquery-superfish', esc_url(get_template_directory_uri()) . '/assets/js/jquery.superfish.js', array('jquery') ,'',true);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'urja_solar_energy_scripts' );

function urja_solar_energy_front_page_template( $template ) {
	return is_home() ? '' : $template;
}
add_filter( 'frontpage_template',  'urja_solar_energy_front_page_template' );

function urja_solar_energy_sanitize_dropdown_pages( $page_id, $setting ) {
  // Ensure $input is an absolute integer.
  $page_id = absint( $page_id );
  // If $page_id is an ID of a published page, return it; otherwise, return the default.
  return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
}

function urja_solar_energy_sanitize_choices( $input, $setting ) {
    global $wp_customize; 
    $control = $wp_customize->get_control( $setting->id ); 
    if ( array_key_exists( $input, $control->choices ) ) {
        return $input;
    } else {
        return $setting->default;
    }
}

//footer Link
define('URJA_SOLAR_ENERGY_LIVE_DEMO',__('https://luzukdemo.com/demo/solar-energy/','urja-solar-energy'));
define('URJA_SOLAR_ENERGY_PRO_DOCS',__('https://luzukdemo.com/demo/solar-energy/documentation/','urja-solar-energy'));
define('URJA_SOLAR_ENERGY_BUY_NOW',__('https://www.luzuk.com/product/solar-energy-wordpress-theme/','urja-solar-energy'));
define('URJA_SOLAR_ENERGY_SUPPORT',__('https://wordpress.org/support/theme/urja-solar-energy/','urja-solar-energy'));
define('URJA_SOLAR_ENERGY_CREDIT',__('https://www.luzuk.com/themes/free-solar-energy-wordpress-theme/','urja-solar-energy'));

if ( ! function_exists( 'urja_solar_energy_credit' ) ) {
	function urja_solar_energy_credit(){
		echo "<a href=".esc_url(URJA_SOLAR_ENERGY_CREDIT)." target='_blank'>".esc_html__('Solar Energy WordPress Theme','urja-solar-energy')."</a>";
	}
}

/* Excerpt Limit Begin */
function urja_solar_energy_string_limit_words($string, $word_limit) {
	$words = explode(' ', $string, ($word_limit + 1));
	if(count($words) > $word_limit)
	array_pop($words);
	return implode(' ', $words);
}

// Change number or products per row to 3
add_filter('loop_shop_columns', 'urja_solar_energy_loop_columns');
	if (!function_exists('urja_solar_energy_loop_columns')) {
		function urja_solar_energy_loop_columns() {
	return 3; // 3 products per row
	}
}

function urja_solar_energy_sanitize_checkbox( $input ) {
	return ( ( isset( $input ) && true == $input ) ? true : false );
}

function urja_solar_energy_sanitize_phone_number( $phone ) {
	return preg_replace( '/[^\d+]/', '', $phone );
}

function urja_solar_energy_sanitize_email( $email, $setting ) {
	$email = sanitize_email( $email );
	return ( ! is_null( $email ) ? $email : $setting->default );
}


require get_parent_theme_file_path( '/inc/custom-header.php' );

require get_parent_theme_file_path( '/inc/template-tags.php' );

require get_parent_theme_file_path( '/inc/template-functions.php' );

require get_parent_theme_file_path( '/inc/customizer.php' );

require get_parent_theme_file_path( '/inc/getting-started/getting-started.php' );