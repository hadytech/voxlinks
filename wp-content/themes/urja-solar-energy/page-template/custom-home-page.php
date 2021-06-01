<?php
/**
 * Template Name: Custom Home
 */

get_header(); ?>

<?php do_action( 'urja_solar_energy_above_slider' ); ?>

<section id="slider">
  	<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel"> 
	    <?php $slider_pages = array();
	      	for ( $count = 1; $count <= 4; $count++ ) {
		        $mod = intval( get_theme_mod( 'urja_solar_energy_slider' . $count ));
		        if ( 'page-none-selected' != $mod ) {
		          $slider_pages[] = $mod;
		        }
	      	}
	      	if( !empty($slider_pages) ) :
	        $args = array(
	          	'post_type' => 'page',
	          	'post__in' => $slider_pages,
	          	'orderby' => 'post__in'
	        );
	        $query = new WP_Query( $args );
	        if ( $query->have_posts() ) :
	          $i = 1;
	    ?>     
	    <div class="carousel-inner" role="listbox">
	      	<?php  while ( $query->have_posts() ) : $query->the_post(); ?>
	        <div <?php if($i == 1){echo 'class="carousel-item active"';} else{ echo 'class="carousel-item"';}?>>
	          	<a href="<?php echo esc_url( get_permalink() );?>"><?php the_post_thumbnail(); ?></a>
	          	<div class="carousel-caption">
		            <div class="inner_carousel">
		              	<h1><?php the_title(); ?></h1>
		              	<hr>
		              	<p><?php $excerpt = get_the_excerpt(); echo esc_html( urja_solar_energy_string_limit_words( $excerpt,10 ) ); ?></p>
		              	<div class="read-btn">
				          <a href="<?php echo esc_url( get_permalink() );?>" class="blogbutton-small"><?php esc_html_e('Read More','urja-solar-energy'); ?><i class="fas fa-angle-right"></i><span class="screen-reader-text"><?php esc_html_e('Read More','urja-solar-energy'); ?></span>

				          </a>
				      	</div>	
		            </div>
	          	</div>
	        </div>
	      	<?php $i++; endwhile; 
	      	wp_reset_postdata();?>
	    </div>
	    <?php else : ?>
	    <div class="no-postfound"></div>
	      <?php endif;
	    endif;?>
	    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
	      <span class="carousel-control-prev-icon" aria-hidden="true"><i class="fas fa-chevron-left"></i></span>
	      <span class="screen-reader-text"><?php esc_html_e( 'Prev','urja-solar-energy' );?></span>
	    </a>
	    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
	      <span class="carousel-control-next-icon" aria-hidden="true"><i class="fas fa-chevron-right"></i></span>
	      <span class="screen-reader-text"><?php esc_html_e( 'Next','urja-solar-energy' );?></span>
	    </a>
  	</div>  
  	<div class="clearfix"></div>
</section>

<?php do_action('urja_solar_energy_below_slider'); ?>

<?php /*--our-services --*/?>
<section id="our-services">
	<div class="container">			
		<div class="service-box">
			<div class="service-title">
	    		<?php if( get_theme_mod('urja_solar_energy_our_services_title') != ''){ ?>
            		<h2><?php echo esc_html(get_theme_mod('urja_solar_energy_our_services_title','')); ?></h2>
            	<?php }?>
            </div>
            <div class="row">
	      		<?php 
	      		$catData=  get_theme_mod('urja_solar_energy_category_setting');
		          if($catData){
		          $page_query = new WP_Query(array( 'category_name' => esc_html( $catData ,'urja-solar-energy')));?>
	        		<?php while( $page_query->have_posts() ) : $page_query->the_post(); ?>     	
	          			<div class="col-md-4">
	          				<div class="service-img">
					      		<?php the_post_thumbnail(); ?>
					  		</div>
					  		<div class="content">
			            		<h3><a href="<?php echo esc_url( get_permalink() );?>"><?php the_title(); ?></a></h3>
			            		<p><?php $excerpt = get_the_excerpt(); echo esc_html( urja_solar_energy_string_limit_words( $excerpt,10 ) ); ?></p>
            				</div>
					    </div>    	
	          		<?php endwhile; 
	          	wp_reset_postdata();
	      		} ?>
      		</div>
		</div>
		<div class="clearfix"></div>
	</div>
</section>

<?php do_action('urja_solar_energy_below_our_service_section'); ?>

<div class="container lz-content">
  	<?php while ( have_posts() ) : the_post(); ?>
        <?php the_content(); ?>
    <?php endwhile; // end of the loop. ?>
</div>

<?php get_footer(); ?>