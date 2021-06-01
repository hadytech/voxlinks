<?php
/**
 * Template part for displaying posts
 * 
 * @subpackage urja-solar-energy
 * @since 1.0
 * @version 1.4
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class('inner-service'); ?>>
  <div class="article_content">
    <?php the_post_thumbnail(); ?>
    <div class="article-text">
      <h1><?php the_title(); ?></h1>
      <div class="metabox">
        <span class="entry-date"><?php the_time( get_option( 'date_format' ) ); ?></span>
        <a href="<?php echo esc_url( get_permalink() );?>"><span class="entry-author"><?php the_author(); ?></span></a>
        <a href="<?php echo esc_url( get_permalink() );?>"><span class="entry-comments"><?php comments_number( __('0 Comments','urja-solar-energy'), __('0 Comments','urja-solar-energy'), __('% Comments','urja-solar-energy') ); ?></span></a>
      </div>
      <p><?php the_content(); ?></p>
    </div>
    <div class="clearfix"></div> 
  </div>
</article>