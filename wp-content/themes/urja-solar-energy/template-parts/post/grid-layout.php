<?php
/**
 * Template part for displaying posts
 * 
 * @subpackage urja-solar-energy
 * @since 1.0
 * @version 1.4
 */

?>
<article class="col-lg-4 col-md-4">
	<div id="post-<?php the_ID(); ?>" <?php post_class('inner-service'); ?>>
    <div class="article_content">
      <?php the_post_thumbnail(); ?>
      <div class="article-text">
        <h3><?php the_title(); ?></h3>
        <div class="metabox">
         <span class="entry-date"><?php the_time( get_option( 'date_format' ) ); ?></span>
          <a href="<?php echo esc_url( get_permalink() );?>"><span class="entry-author"><?php the_author(); ?></span></a>
          <a href="<?php echo esc_url( get_permalink() );?>"><span class="entry-comments"><?php comments_number( __('0 Comments','urja-solar-energy'), __('0 Comments','urja-solar-energy'), __('% Comments','urja-solar-energy') ); ?></span></a>
        </div>
        <p><?php $excerpt = get_the_excerpt();echo esc_html( urja_solar_energy_string_limit_words( $excerpt,30 ) ); ?></p>
        <div class="read-btn">
          <a href="<?php echo esc_url( get_permalink() );?>" class="blogbutton-small"><?php esc_html_e('READ MORE','urja-solar-energy'); ?><i class="fas fa-angle-right"></i><span class="screen-reader-text"><?php esc_html_e('READ MORE','urja-solar-energy'); ?></span></a>
        </div>
      </div>
      <div class="clearfix"></div> 
    </div>
  </div>
</article>