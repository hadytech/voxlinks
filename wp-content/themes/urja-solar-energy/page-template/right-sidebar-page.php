<?php
/*
*
Template Name: Page right sidebar
*/
get_header(); ?>

<?php do_action( 'urja_solar_energy_above_header_right_page' ); ?>

<div class="container">
	<div class="content-area">
		<main id="main" class="site-main" role="main">
			<div class="row">
				<div class="content_area col-md-8">	
					<?php while ( have_posts() ) : the_post();

						get_template_part( 'template-parts/page/content', 'page' );

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;

					endwhile; // End of the loop.	?>
				</div>
				<div id="sidebar" class="col-md-4">
					<?php dynamic_sidebar('sidebar-2'); ?> 
				</div>
			</div>
		</main>
	</div>
</div>

<?php do_action( 'urja_solar_energy_above_footer_right_page' ); ?>

<?php get_footer();