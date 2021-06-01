<?php 
    $settings    = \ReviewX\Controllers\Admin\Core\ReviewxMetaBox::get_option_settings();
    $color_theme = $settings->color_theme;
    if( $color_theme ) {
?>
	<style id="custom-style">
        .rx_review_shorting_2 .box .rx-selection-arrow{
            background-color: <?php echo esc_attr( $color_theme ); ?> !important;
        }
        .rx_listing .rx_review_block .children .rx_thumb svg{
            fill: <?php echo esc_attr( $color_theme ); ?> !important;
        }
        .woocommerce-page div.product div.summary .star-rating,
        .woocommerce-page div.product div.summary .star-rating span:before,
        ul.products li.product .woocommerce-loop-product__link .star-rating,
        ul.products li.product .woocommerce-loop-product__link .star-rating span:before{
            color: <?php echo esc_attr( $color_theme ); ?>;
        }

		.rx-horizontal .progress-fill{
			background-color: <?php echo esc_attr( $color_theme ); ?>;
		}

        .reviewx_recommended_list .reviewx_radio input[type="radio"]:checked + .radio-label svg .rx_happy,
        .reviewx_recommended_list .reviewx_radio input[type="radio"]:checked + .radio-label svg .st1{
            fill: <?php echo esc_attr( $color_theme ); ?>;
        }
	    
        a.play-btn{
	        color: <?php echo esc_attr( $color_theme ); ?>;
	    }

        #review_form input[type="submit"],
        #review_form input[type="submit"]:focus{
            background-color: <?php echo esc_attr( $color_theme ); ?>;
            border-color: <?php echo esc_attr( $color_theme ); ?>;
            outline-color: <?php echo esc_attr( $color_theme ); ?>;
        }
        /*Theme Oshine*/
        .theme-oshin.woocommerce #respond .reviewx_front_end_from input#submit,
        .theme-oshin.woocommerce-page #respond .reviewx_front_end_from input#submit{
            background-color: <?php echo esc_attr( $color_theme ); ?>!important;
            border-color: <?php echo esc_attr( $color_theme ); ?>!important;
            outline-color: <?php echo esc_attr( $color_theme ); ?>!important;
        }
        .theme-jupiter.woocommerce #respond .reviewx_front_end_from input#submit,
        .theme-jupiter.woocommerce-page #respond .reviewx_front_end_from input#submit{
            background-color: <?php echo esc_attr( $color_theme ); ?>!important;
            border-color: <?php echo esc_attr( $color_theme ); ?>!important;
            outline-color: <?php echo esc_attr( $color_theme ); ?>!important;
        }

	    .reviewx-rating .rx-star-rating > label:before{
	        background-color: <?php echo esc_attr( $color_theme ); ?>;
	        -webkit-background-clip: text;
	    }

		/*-------Pagination----------*/
		.rx_pagination .rx-page.active a{
			background-color: <?php echo esc_attr( $color_theme ); ?>;
		}

        /*---------My Account Page-------*/
        .swal2-modal button.styled{
            background-color: <?php echo esc_attr( $color_theme ); ?>!important;
        }
        .woocommerce-orders .woocommerce-orders-table__cell p .rx_my_account_view_review,
        .woocommerce-orders .woocommerce-orders-table__cell p .rx_my_account_edit_review,
        .woocommerce-orders .woocommerce-orders-table__cell p .rx_my_account_submit_review{
            background-color: <?php echo esc_attr( $color_theme ); ?>;
        }
        .woocommerce-orders .woocommerce-orders-table__cell p .rx_my_account_view_review:hover,
        .woocommerce-orders .woocommerce-orders-table__cell p .rx_my_account_edit_review:hover,
        .woocommerce-orders .woocommerce-orders-table__cell p .rx_my_account_submit_review:hover{
            background-color: <?php echo esc_attr( $color_theme ); ?>;
            color: #fff !important;
        }
        .rx_myaccount-review_form .rx-form-btn.rv-btn {
            background-color: <?php echo esc_attr( $color_theme ); ?>;
            border: 1px solid <?php echo esc_attr( $color_theme ); ?>;
        }
        /*-------Style one review summery progress bar-------*/
        .rx_style_one_progress.orange .rx_style_one_progress-icon,
        .rx_style_one_progress.orange .rx_style_one_progress-value{
            color: <?php echo esc_attr( $color_theme ); ?>;
            border-color: <?php echo esc_attr( $color_theme ); ?>;
        }
        
        .rx-cancel-btn{
			color: <?php echo esc_attr( $color_theme ); ?>!important;
			border-color: <?php echo esc_attr( $color_theme ); ?>!important;
        }
        .rx_double_spinner > div {
            border-color: <?php echo esc_attr( $color_theme ); ?> transparent <?php echo esc_attr( $color_theme ); ?> transparent;
        }

        .rx_double_spinner > div:nth-child(2) div:before, .rx_double_spinner > div:nth-child(2) div:after { 
            background: <?php echo esc_attr( $color_theme ); ?> !important;
            box-shadow: 0 64px 0 0 <?php echo esc_attr( $color_theme ); ?> !important;
        }

        .rx_double_spinner > div:nth-child(2) div:after { 
            box-shadow: 64px 0 0 0 <?php echo esc_attr( $color_theme ); ?> !important;
        }

        .rx_listing .rx_review_block .children .rx_thumb svg .st0 {
            fill: <?php echo esc_attr( $color_theme ); ?>;
        }

        .reviewx_highlight_comment{
            border-color: <?php echo esc_attr( $color_theme ); ?> !important;
        }

        .rx_review_shorting .box .rx-selection-arrow{
            background-color:  <?php echo esc_attr( $color_theme ); ?>;
        }

        /* Single Order Page*/
        .rx_listing .rx_review_block .rx_body .rx_photos .rx_photo.rx_video .rx_overlay i {
            color: <?php echo esc_attr( $color_theme ); ?> !important;
        }

        .rx-form-btn {
            background: <?php echo esc_attr( $color_theme ); ?>;
            border: 1px solid <?php echo esc_attr( $color_theme ); ?>;
        }

        .rx_video .rx_overlay .st0 {
            fill: <?php echo esc_attr( $color_theme ); ?> !important;
        }

        .rx_style_one_progress .rx_style_one_progress-bar{
            background: <?php echo esc_attr( $color_theme ); ?>;
        }

        .rx_style_two_free_progress_bar .progress .progress-bar{
            background: <?php echo esc_attr( $color_theme ); ?>;
        }
        
	</style>
<?php }

    if( class_exists('Kirki') ) { ?>
    <style>
        .single-product .site-content .col-full {
            background-color: transparent !important;
        }
    </style>
<?php } ?>