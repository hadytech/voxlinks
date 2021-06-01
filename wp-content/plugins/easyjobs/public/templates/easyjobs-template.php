<?php
/**
 * Template Name: Easyjobs Template
 * Description: Template for easyjobs pages
 *
 * @link       https://easy.jobs
 * @since      1.0.0
 *
 * @package    EasyJobs
 * @subpackage EasyJobs/public
 */
get_header();
global $post;
?>
<div class="easyjobs-frontend-wrapper <?php echo get_post_meta($post->ID,'easyjobs_job_id')[0] == 'all' ? 'easyjobs-landing-page' : 'easyjobs-single-page';?>">
    <div class="easyjobs-content-wrapper">
        <?php
        /**
         * Hooks anything before content
         * @since 1.0.0
         */
        do_action('easyjobs_before_content');
        ?>

        <?php if(have_posts()): ?>
            <?php while (have_posts()): the_post(); ?>
                <?php the_content(); ?>
            <?php endwhile;?>
        <?php endif; ?>

        <?php
        /**
         * Hooks anything after content
         * @since 1.0.0
         */
        do_action('easyjobs_after_content');
        ?>
    </div>
</div>

<?php get_footer();?>
