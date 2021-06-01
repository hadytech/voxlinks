<?php
/**
 * Template Name: Crowdfundly Template
 * Description: Template for Crowdfundly pages
 *
 * @link       https://wpdeveloper.net/
 * @since      1.0.0
 *
 * @package    Crowdfundly
 * @subpackage Crowdfundly/admin
 */
get_header();
global $post;
?>

<div class="crowdfundly-frontend-wrapper crowdfundly-page-id-<?php echo esc_attr( $post->ID ); ?>">
    <div class="crowdfundly-content-wrapper">

		<?php if ( have_posts() ): ?>
			
            <?php while ( have_posts() ): the_post(); ?>
                <?php the_content(); ?>
			<?php endwhile; ?>

        <?php else : ?>
            <p>
                <?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'crowdfundly' ); ?>
            </p>
            <?php get_search_form(); ?>		
        <?php endif; ?>

    </div>
</div>

<?php get_footer();?>
