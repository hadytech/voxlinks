<?php
/**
 * Display single product reviews (comments)
 *
 * @package WooCommerce 3.8.1
 * @version 1.0.0
 * @author WPDevelopers
 */
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }

    global $reviewx_shortcode;
    $divi_settings = get_post_meta( get_the_ID(), '_rx_option_divi_settings', true );

    //prepare review title
    $rx_wc_Reviews_title            = '';
    
    if( \ReviewX_Helper::check_post_type_availability( get_post_type() ) == TRUE ) {
        $count                      = \ReviewX_Helper::get_review_count_for_product( get_the_ID() );
        if( $count ) {
            $rx_wc_Reviews_title    = sprintf( esc_html( _n( '%1$s review for %2$s', '%1$s reviews for %2$s', $count, 'reviewx' ) ), esc_html( $count ), '<span>' . get_the_title() . '</span>' );        
        } else {
            $rx_wc_Reviews_title    = esc_html__( 'Reviews', 'reviewx' );
        }
        
    } else if( get_post_type() == 'product' ) {
        
        global $product;
        $count                      = $product->get_review_count();

        $rx_elementor_controller    = apply_filters( 'rx_load_elementor_style_controller', '' );
        $rx_review_title            = isset($rx_elementor_controller['rx_review_section_title']) ? $rx_elementor_controller['rx_review_section_title'] : null;

        $rx_oxygen_controller       = apply_filters( 'rx_load_oxygen_style_controller', '' );
        $rx_section_title           = isset($rx_oxygen_controller['rx_section_title']) ? $rx_oxygen_controller['rx_section_title'] : null;

        if( !empty( $rx_review_title ) ) {
            $rx_wc_reviews_title    = sprintf( __('%s', 'reviewx' ), $rx_review_title );
        } else if( ! empty( $rx_section_title ) ) {
            $rx_wc_reviews_title    = sprintf( __('%s', 'reviewx' ), $rx_section_title );                 
        } else if( ! empty( get_theme_mod('reviewx_section_title') ) ) {
            $rx_wc_reviews_title    = sprintf( __('%s', 'reviewx' ), get_theme_mod('reviewx_section_title') );  
        } else if(\ReviewX_Helper::reviewx_check_divi_active()) {            
            $rx_wc_reviews_title = $divi_settings['rvx_review_section_title'];            
        } else if ( $count && wc_review_ratings_enabled() ) {
            $reviews_title          = sprintf( esc_html( _n( '%1$s review for %2$s', '%1$s reviews for %2$s', $count, 'reviewx' ) ), esc_html( $count ), '<span>' . get_the_title() . '</span>' );
            $rx_wc_reviews_title    = apply_filters( 'woocommerce_reviews_title', $reviews_title, $count, $product );
        } else {
            $rx_wc_reviews_title    = esc_html__( 'Reviews', 'reviewx' );
        }

    }
?>
<div class="rx-flex-grid-container">
    <div class="rx-flex-grid-100">
        <h2 class="woocommerce-Reviews-title">
            <?php print $rx_wc_reviews_title; ?>
        </h2>
    </div>
</div>
<?php

    /**
     * Include product rating summery template
     */
    if( have_comments() ) {
        //Load review graph, pie chart template
        echo apply_filters( 'rx_load_review_graph_template', 1 );       
    }

    //Load review template
    echo apply_filters( 'rx_load_review_templates', 1 );
     
?>