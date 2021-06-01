<?php 
    $settings    = \ReviewX\Controllers\Admin\Core\ReviewxMetaBox::get_option_settings();
    $color_theme = $settings->color_theme;
    if( $color_theme ) {
?>
	<style id="custom-style">
		.swal2-styled.swal2-confirm {
            background-color: <?php echo esc_attr( $color_theme ); ?> !important;
            border-left-color: <?php echo esc_attr( $color_theme ); ?> !important;
            border-right-color: <?php echo esc_attr( $color_theme ); ?> !important;
        }
	</style>
<?php } ?>

<?php 
    $screen = get_current_screen();
    $review_email_tab = get_option( '_rx_review_email_current_tab' );
    if( $screen->base == 'reviewx_page_reviewx-review-email' ) {
        if( $review_email_tab == 'scheduled_emails' ) { ?>
    <style id="review-email-custom-style">   
        .rx-license-section{
            display: none;
        }
        .rx-form-builder-section {
            flex: 0 0 100%;
        } 
        .rx_review_email_content_wrap .rx_review_email_content{
            background-color:#fff;
        }  
        .rx_review_email_content_wrap{
            padding: 0;
        } 
        .rx_review_email_content .rx-meta-section table tr td{
            padding: 0;
        }
        .rx_review_email_content .rx-meta-section table table tr td{
            padding: 5px 30px;
        }    
    </style>
<?php 
        } else if( $review_email_tab == 'content_tab' ) { ?>
    <style id="review-email-custom-style">   

        .rx-form-builder-section {
            flex: 0 0 70%;
        } 
       
    </style>        
<?php
        }
    }
?>