<?php
/**
 * The template for displaying all single posts
 * 
 * @subpackage urja-solar-energy
 * @since 1.0
 * @version 0.1
 */

get_header(); ?>

<div class="container">
	<div class="content-area">
		<main id="main" class="site-main" role="main">
			<?php
			    $layout_option = get_theme_mod( 'urja_solar_energy_theme_options',__( 'Right Sidebar','urja-solar-energy' ) );
			    if($layout_option == 'Left Sidebar'){ ?>
			    	<div class="row">
				        <div id="sidebar" class="col-lg-4 col-md-4"><?php dynamic_sidebar('sidebar-1'); ?></div>
				        <div id="" class="content_area col-lg-8 col-md-8">
					    	<section id="post_section">
								<?php
								/* Start the Loop */
								while ( have_posts() ) : the_post();

									get_template_part( 'template-parts/post/content-single' );

									// If comments are open or we have at least one comment, load up the comment template.
									if ( comments_open() || get_comments_number() ) :
										comments_template();
									endif;

									the_post_navigation( array(
										'prev_text' => '<span class="screen-reader-text">' . __( 'Previous Post', 'urja-solar-energy' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Previous', 'urja-solar-energy' ) . '</span>',
										'next_text' => '<span class="screen-reader-text">' . __( 'Next Post', 'urja-solar-energy' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Next', 'urja-solar-energy' ) . '</span> ',
									) );

								endwhile; // End of the loop.
								?>
							</section>
						</div>
						<div class="clearfix"></div>
					</div>			
			<?php }else if($layout_option == 'Right Sidebar'){ ?>
				<div class="row">
					<div id="" class="content_area col-lg-8 col-md-8">
						<section id="post_section">
							<?php
							/* Start the Loop */
							while ( have_posts() ) : the_post();

								get_template_part( 'template-parts/post/content-single' );

								// If comments are open or we have at least one comment, load up the comment template.
								if ( comments_open() || get_comments_number() ) :
									comments_template();
								endif;

								the_post_navigation( array(
									'prev_text' => '<span class="screen-reader-text">' . __( 'Previous Post', 'urja-solar-energy' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Previous', 'urja-solar-energy' ) . '</span>',
									'next_text' => '<span class="screen-reader-text">' . __( 'Next Post', 'urja-solar-energy' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Next', 'urja-solar-energy' ) . '</span> ',
								) );

							endwhile; // End of the loop.
							?>
						</section>
					</div>
					<div id="sidebar" class="col-lg-4 col-md-4"><?php dynamic_sidebar('sidebar-1'); ?></div>
				</div>
			<?php }else if($layout_option == 'One Column'){ ?>
					<div id="" class="content_area">
						<section id="post_section">
							<?php
							/* Start the Loop */
							while ( have_posts() ) : the_post();

								get_template_part( 'template-parts/post/content-single' );

								// If comments are open or we have at least one comment, load up the comment template.
								if ( comments_open() || get_comments_number() ) :
									comments_template();
								endif;

								the_post_navigation( array(
									'prev_text' => '<span class="screen-reader-text">' . __( 'Previous Post', 'urja-solar-energy' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Previous', 'urja-solar-energy' ) . '</span>',
									'next_text' => '<span class="screen-reader-text">' . __( 'Next Post', 'urja-solar-energy' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Next', 'urja-solar-energy' ) . '</span> ',
								) );

							endwhile; // End of the loop.
							?>
						</section>
					</div>			
			<?php }else if($layout_option == 'Three Columns'){ ?>	
				<div class="row">
					<div id="sidebar" class="col-lg-3 col-md-3"><?php dynamic_sidebar('sidebar-1'); ?></div>	
					<div id="" class="content_area col-lg-6 col-md-6">
						<section id="post_section">
							<?php
							/* Start the Loop */
							while ( have_posts() ) : the_post();

								get_template_part( 'template-parts/post/content-single' );

								// If comments are open or we have at least one comment, load up the comment template.
								if ( comments_open() || get_comments_number() ) :
									comments_template();
								endif;

								the_post_navigation( array(
									'prev_text' => '<span class="screen-reader-text">' . __( 'Previous Post', 'urja-solar-energy' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Previous', 'urja-solar-energy' ) . '</span>',
									'next_text' => '<span class="screen-reader-text">' . __( 'Next Post', 'urja-solar-energy' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Next', 'urja-solar-energy' ) . '</span> ',
								) );

							endwhile; // End of the loop.
							?>
						</section>
					</div>
					<div id="sidebar" class="col-lg-3 col-md-3"><?php dynamic_sidebar('sidebar-2'); ?></div>
				</div>
			<?php }else if($layout_option == 'Four Columns'){ ?>
				<div class="row">
					<div id="sidebar" class="col-lg-3 col-md-3"><?php dynamic_sidebar('sidebar-1'); ?></div>
					<div id="" class="content_area col-lg-3 col-md-3">
						<section id="post_section">
								<?php
								/* Start the Loop */
								while ( have_posts() ) : the_post();

									get_template_part( 'template-parts/post/content-single' );

									// If comments are open or we have at least one comment, load up the comment template.
									if ( comments_open() || get_comments_number() ) :
										comments_template();
									endif;

									the_post_navigation( array(
										'prev_text' => '<span class="screen-reader-text">' . __( 'Previous Post', 'urja-solar-energy' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Previous', 'urja-solar-energy' ) . '</span>',
										'next_text' => '<span class="screen-reader-text">' . __( 'Next Post', 'urja-solar-energy' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Next', 'urja-solar-energy' ) . '</span> ',
									) );

								endwhile; // End of the loop.
								?>
						</section>
					</div>
					<div id="sidebar" class="col-lg-3 col-md-3"><?php dynamic_sidebar('sidebar-2'); ?></div>
			        <div id="sidebar" class="col-lg-3 col-md-3"><?php dynamic_sidebar('sidebar-3'); ?></div>
		        </div>
	    	<?php }else if($layout_option == 'Grid Layout'){ ?>
		    	<div class="row">
			    	<div id="" class="content_area col-lg-8 col-md-8">
						<section id="post_section">
							<div class="row">
								<?php
								/* Start the Loop */
								while ( have_posts() ) : the_post();

									get_template_part( 'template-parts/post/content-single' );

									// If comments are open or we have at least one comment, load up the comment template.
									if ( comments_open() || get_comments_number() ) :
										comments_template();
									endif;

									the_post_navigation( array(
										'prev_text' => '<span class="screen-reader-text">' . __( 'Previous Post', 'urja-solar-energy' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Previous', 'urja-solar-energy' ) . '</span>',
										'next_text' => '<span class="screen-reader-text">' . __( 'Next Post', 'urja-solar-energy' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Next', 'urja-solar-energy' ) . '</span> ',
									) );

								endwhile; // End of the loop.
								?>
							</div>
						</section>
					</div>
					<div id="sidebar" class="col-lg-4 col-md-4"><?php dynamic_sidebar('sidebar-1'); ?></div>	
				</div>		
			<?php } else { ?>
				<div class="row">
					<div id="" class="content_area col-lg-8 col-md-8">
						<section id="post_section">
							<?php
								/* Start the Loop */
								while ( have_posts() ) : the_post();

									get_template_part( 'template-parts/post/content-single' );

									// If comments are open or we have at least one comment, load up the comment template.
									if ( comments_open() || get_comments_number() ) :
										comments_template();
									endif;

									the_post_navigation( array(
										'prev_text' => '<span class="screen-reader-text">' . __( 'Previous Post', 'urja-solar-energy' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Previous', 'urja-solar-energy' ) . '</span>',
										'next_text' => '<span class="screen-reader-text">' . __( 'Next Post', 'urja-solar-energy' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Next', 'urja-solar-energy' ) . '</span> ',
									) );

								endwhile; // End of the loop.
								?>
						</section>
					</div>
					<div id="sidebar" class="col-lg-4 col-md-4"><?php dynamic_sidebar('sidebar-1'); ?>
					</div>
				</div>
			<?php } ?>
		</main>
	</div>
</div>

<?php get_footer();