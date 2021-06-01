<?php
/**
 * The header for our theme
 *
 * @subpackage urja-solar-energy
 * @since 1.0
 * @version 0.1
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php if ( function_exists( 'wp_body_open' ) ) {
    wp_body_open();
} else {
    do_action( 'wp_body_open' );
}?>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'urja-solar-energy' ); ?></a>

	<div class="top-header">
		<div class="container">	
			<?php get_template_part( 'template-parts/header/header', 'image' ); ?>	
			<div class="row">
				<div class="col-md-6 p-0">
					<div class="top">
						<?php if( get_theme_mod( 'urja_solar_energy_welcome') != '') { ?>	
						 <span class="col-org"><?php echo esc_html( get_theme_mod('urja_solar_energy_welcome','') ); ?></span>
					    <?php } ?>
					</div>
				</div>
				<div class="col-md-6 p-0">
					<div class="social-icons">
						<span class="col-org"><?php esc_html_e('Follow us:','urja-solar-energy'); ?></span>
						<?php if( get_theme_mod( 'urja_solar_energy_facebook_url') != '') { ?>
			              <a href="<?php echo esc_url( get_theme_mod( 'urja_solar_energy_facebook_url','' ) ); ?>"><i class="fab fa-facebook-f" aria-hidden="true"></i><span class="screen-reader-text"><?php esc_html_e( 'Facebook','urja-solar-energy' );?></span></a>
			            <?php } ?>
			            <?php if( get_theme_mod( 'urja_solar_energy_twitter_url') != '') { ?>
			              <a href="<?php echo esc_url( get_theme_mod( 'urja_solar_energy_twitter_url','' ) ); ?>" ><i class="fab fa-twitter"></i><span class="screen-reader-text"><?php esc_html_e( 'Twitter','urja-solar-energy' );?></span></a>
			            <?php } ?>
			            <?php if( get_theme_mod( 'urja_solar_energy_linkedin_url') != '') { ?>
			              <a href="<?php echo esc_url( get_theme_mod( 'urja_solar_energy_linkedin_url','' ) ); ?>"><i class="fab fa-linkedin-in"></i><span class="screen-reader-text"><?php esc_html_e( 'Linkedin','urja-solar-energy' );?></span></a>
			            <?php } ?>
			             <?php if( get_theme_mod( 'urja_solar_energy_pinterest_url') != '') { ?>
			              <a href="<?php echo esc_url( get_theme_mod( 'urja_solar_energy_pinterest_url','' ) ); ?>"><i class="fab fa-pinterest-p"></i><span class="screen-reader-text"><?php esc_html_e( 'Pinterest','urja-solar-energy' );?></span></a>
			            <?php } ?>
			            <?php if( get_theme_mod( 'urja_solar_energy_insta_url') != '') { ?>
			              <a href="<?php echo esc_url( get_theme_mod( 'urja_solar_energy_insta_url','' ) ); ?>"><i class="fab fa-instagram"></i><span class="screen-reader-text"><?php esc_html_e( 'Instagram','urja-solar-energy' );?></span></a>
			            <?php } ?>
			            
					</div>	
				</div>
			</div>
		</div>
	</div>
	<div id="contact">
		<div class="container">
			<div class="row padd0">
				<div class="col-md-3">
					<div class="logo">
				        <?php if ( has_custom_logo() ) : ?>
					        <div class="site-logo"><?php the_custom_logo(); ?></div>
					    <?php endif; ?>
			            <?php if (get_theme_mod('urja_solar_energy_show_site_title',true)) {?>
					        <?php $blog_info = get_bloginfo( 'name' ); ?>
					        <?php if ( ! empty( $blog_info ) ) : ?>
					            <?php if ( is_front_page() && is_home() ) : ?>
						            <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					        	<?php else : ?>
				            		<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					            <?php endif; ?>
					        <?php endif; ?>
					    <?php }?>
			        	<?php if (get_theme_mod('urja_solar_energy_show_tagline',true)) {?>
					        <?php
					        $description = get_bloginfo( 'description', 'display' );
					        if ( $description || is_customize_preview() ) :
					          ?>
						        <p class="site-description">
						            <?php echo esc_html($description); ?>
						        </p>
					        <?php endif; ?>
					    <?php }?>
				    </div>
				</div>
				<div class="col-md-9">
					<div class="contact-details">
						<div class="row">
							<div class="col-md-4">
								<div class="call">
									<div class="row">
										<div class="col-md-2">
											<?php if( get_theme_mod( 'urja_solar_energy_call') != '') { ?>
											<i class="fas fa-phone"></i>
											<?php } ?>
										</div>
										<div class="col-md-10">
											<?php if( get_theme_mod( 'urja_solar_energy_call') != '') { ?>	
											 <p class="col-org"><a href="tel:<?php echo esc_attr( get_theme_mod('urja_solar_energy_call','') ); ?>"><?php echo esc_html( get_theme_mod('urja_solar_energy_call','') ); ?></a></p>
											<?php } ?>
											<?php if( get_theme_mod( 'urja_solar_energy_mail') != '') { ?>
										     <p class="col-org"><a href="mailto:<?php echo esc_attr( get_theme_mod('urja_solar_energy_mail','') ); ?>"><?php echo esc_html( get_theme_mod('urja_solar_energy_mail','') ); ?></a></p>
										    <?php } ?>
									    </div>		
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="address">
									<div class="row">
										<div class="col-md-2">
											<?php if( get_theme_mod( 'urja_solar_energy_address') != '') { ?>
											<i class="fas fa-map-marker-alt"></i>
											<?php } ?>
										</div>
										<div class="col-md-10">
											<?php if( get_theme_mod( 'urja_solar_energy_address') != '') { ?>	
											 <p class="col-org"><?php echo esc_html( get_theme_mod('urja_solar_energy_address','') ); ?></p>
										    <?php } ?>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="timing">
									<div class="row">
										<div class="col-md-2">
											<?php if( get_theme_mod( 'urja_solar_energy_timing') != '') { ?>
											<i class="far fa-clock"></i>
											<?php } ?>
										</div>
										<div class="col-md-10">
											<?php if( get_theme_mod( 'urja_solar_energy_timing') != '') { ?>	
											 <p class="col-org"><?php echo esc_html( get_theme_mod('urja_solar_energy_timing','') ); ?></p>
										    <?php } ?>
										</div>
									</div>
								</div>	
							</div>
						</div>	
					</div>
				</div>
		     	<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<header role="banner" id="header">
	    <div class="menu-section">
			<div class="container">
				<div class="main-top">
					<div class="row">
						<div class="col-lg-11 col-md-11 col-10">
							<?php if (has_nav_menu('primary')){ ?>
								<div class="toggle-menu responsive-menu">
						            <button onclick="urja_solar_energy_open()" role="tab" class="mobile-menu"><i class="fas fa-bars"></i><span class="screen-reader-text"><?php esc_html_e('Open Menu','urja-solar-energy'); ?></span></button>
						        </div>
								<div id="sidelong-menu" class="nav sidenav">
					                <nav id="primary-site-navigation" class="nav-menu" role="navigation" aria-label="<?php esc_attr_e( 'Top Menu', 'urja-solar-energy' ); ?>">
					                  	<?php 
						                    wp_nav_menu( array( 
						                      	'theme_location' => 'primary',
						                      	'container_class' => 'main-menu-navigation clearfix' ,
						                      	'menu_class' => 'clearfix',
						                      	'items_wrap' => '<ul id="%1$s" class="%2$s mobile_nav">%3$s</ul>',
						                      	'fallback_cb' => 'wp_page_menu',
						                    ) ); 
					                  	?>
					                  	<a href="javascript:void(0)" class="closebtn responsive-menu" onclick="urja_solar_energy_close()"><i class="fas fa-times"></i><span class="screen-reader-text"><?php esc_html_e('Close Menu','urja-solar-energy'); ?></span></a>
					                </nav>
					            </div>
					        <?php }?>
						</div>
						<div class="search-box col-lg-1 col-md-1 col-2">
	          				<button  onclick="suraksha_security_guard_search_open()" class="search-toggle"><i class="fas fa-search"></i></button>
	        			</div> 
					</div>
					<div class="search-outer">
						<div class="search-inner">
				        	<?php get_search_form(); ?>
			        	</div>
			        	<button onclick="suraksha_security_guard_search_close()" class="search-close"><i class="fas fa-times"></i></button>
			        </div>  
				</div>
			</div>
		</div>
	</header>

	<div class="site-content-contain">
		<div id="content" class="site-content">