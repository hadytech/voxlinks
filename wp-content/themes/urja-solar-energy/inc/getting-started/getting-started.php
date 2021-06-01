<?php
//about theme info
add_action( 'admin_menu', 'urja_solar_energy_gettingstarted' );
function urja_solar_energy_gettingstarted() {    	
	add_theme_page( esc_html__('About Theme', 'urja-solar-energy'), esc_html__('About Theme', 'urja-solar-energy'), 'edit_theme_options', 'urja_solar_energy_guide', 'urja_solar_energy_mostrar_guide');   
}

// Add a Custom CSS file to WP Admin Area
function urja_solar_energy_admin_theme_style() {
   wp_enqueue_style('custom-admin-style', esc_url(get_template_directory_uri()) . '/inc/getting-started/getting-started.css');
}
add_action('admin_enqueue_scripts', 'urja_solar_energy_admin_theme_style');

//guidline for about theme
function urja_solar_energy_mostrar_guide() { 
	//custom function about theme customizer
	$return = add_query_arg( array()) ;
	$theme = wp_get_theme( 'urja-solar-energy' );

?>

<div class="wrapper-info">
	<div class="col-left">
		<div class="intro">
			<h3><?php esc_html_e( 'Welcome to Urja Solar Energy WordPress Theme', 'urja-solar-energy' ); ?> <span>Version: <?php echo esc_html($theme['Version']);?></span></h3>
		</div>
		<div class="started">
			<hr>
			<div class="free-doc">
				<div class="lz-4">
					<h4><?php esc_html_e( 'Start Customizing', 'urja-solar-energy' ); ?></h4>
					<ul>
						<span><?php esc_html_e( 'Go to', 'urja-solar-energy' ); ?> <a target="_blank" href="<?php echo esc_url( admin_url('customize.php') ); ?>"><?php esc_html_e( 'Customizer', 'urja-solar-energy' ); ?> </a> <?php esc_html_e( 'and start customizing your website', 'urja-solar-energy' ); ?></span>
					</ul>
				</div>
				<div class="lz-4">
					<h4><?php esc_html_e( 'Support', 'urja-solar-energy' ); ?></h4>
					<ul>
						<span><?php esc_html_e( 'Send your query to our', 'urja-solar-energy' ); ?> <a href="<?php echo esc_url( URJA_SOLAR_ENERGY_SUPPORT ); ?>" target="_blank"> <?php esc_html_e( 'Support', 'urja-solar-energy' ); ?></a></span>
					</ul>
				</div>
			</div>
			<p><?php esc_html_e( 'Urja Solar Energy is a clean, green and energetically coloured solar energy WordPress theme. It is designed for solar panel manufacturer and distributor, Solar Panel Maintenance Company, renewable energy producer, recycling company, organic and bio-product selling stores, environment and nature protection non-profit organizations, nature and ecology conserving agencies and welfare community for protection of forests, water bodies, earth and other elements of environment. The theme can be used by people involved in organic farming and animal husbandry. Its design and use of colours, fonts and images serve the purpose for which it is made in the most appropriate manner. It is easy to use and readily understandable to quickly set up an efficient site. Strong Bootstrap framework foundation further eases its usage. This solar energy WP theme is fully responsive, cross-browser compatible, translation ready and SEO-friendly fulfilling all the needs of a modern website. It uses banners and sliders to make the site all the more stylish. It is integrated with social media links to get better exposure for your site. This solar energy theme can be customized to change its look and feel through various elements. It is written in clean and secure codes leading to a bug-free site.', 'urja-solar-energy')?></p>
			<hr>			
			<div class="col-left-inner">
				<h3><?php esc_html_e( 'Get started with Free Business Theme', 'urja-solar-energy' ); ?></h3>
				<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/customizer-image.png" alt="" />
			</div>
		</div>
	</div>
	<div class="col-right">
		<div class="col-left-area">
			<h3><?php esc_html_e('Premium Theme Information', 'urja-solar-energy'); ?></h3>
			<hr>
		</div>
		<div class="centerbold">
			<a href="<?php echo esc_url( URJA_SOLAR_ENERGY_LIVE_DEMO ); ?>" target="_blank"><?php esc_html_e('Live Demo', 'urja-solar-energy'); ?></a>
			<a href="<?php echo esc_url( URJA_SOLAR_ENERGY_BUY_NOW ); ?>"><?php esc_html_e('Buy Pro', 'urja-solar-energy'); ?></a>
			<a href="<?php echo esc_url( URJA_SOLAR_ENERGY_PRO_DOCS ); ?>" target="_blank"><?php esc_html_e('Pro Documentation', 'urja-solar-energy'); ?></a>
			<hr class="secondhr">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/urja-solar-energy2.jpg" alt="" />
		</div>
		<h3><?php esc_html_e( 'PREMIUM THEME FEATURES', 'urja-solar-energy'); ?></h3>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon01.png" alt="" />
			<h4><?php esc_html_e( 'Banner Slider', 'urja-solar-energy'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon02.png" alt="" />
			<h4><?php esc_html_e( 'Theme Options', 'urja-solar-energy'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon03.png" alt="" />
			<h4><?php esc_html_e( 'Custom Innerpage Banner', 'urja-solar-energy'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon04.png" alt="" />
			<h4><?php esc_html_e( 'Custom Colors and Images', 'urja-solar-energy'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon05.png" alt="" />
			<h4><?php esc_html_e( 'Fully Responsive', 'urja-solar-energy'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon06.png" alt="" />
			<h4><?php esc_html_e( 'Hide/Show Sections', 'urja-solar-energy'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon07.png" alt="" />
			<h4><?php esc_html_e( 'Woocommerce Support', 'urja-solar-energy'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon08.png" alt="" />
			<h4><?php esc_html_e( 'Limit to display number of Posts', 'urja-solar-energy'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon09.png" alt="" />
			<h4><?php esc_html_e( 'Multiple Page Templates', 'urja-solar-energy'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon10.png" alt="" />
			<h4><?php esc_html_e( 'Custom Read More link', 'urja-solar-energy'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon11.png" alt="" />
			<h4><?php esc_html_e( 'Code written with WordPress standard', 'urja-solar-energy'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon12.png" alt="" />
			<h4><?php esc_html_e( '100% Multi language', 'urja-solar-energy'); ?></h4>
		</div>
	</div>
</div>
<?php } ?>