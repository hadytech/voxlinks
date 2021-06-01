<?php
/*
 * Template Name: ReviewX Schedule Email Unsubscriber
 * Description: A Page Template with reviewx unsubscribe functionality.
 */
get_header();

if ( have_posts() ) {
    while ( have_posts() ) {
        the_post();
    ?>
        <div class="rx-scheduled-email-unsubscribe-content">
            <?php the_content(); ?>
        </div>
    <?php     
    }
}

get_sidebar();
get_footer();