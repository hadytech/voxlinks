<?php
/**
 * Easyjobs Theme Customizer outout for layout settings
 *
 * @package Easyjobs
 */

/**
 * This function adds some styles to the WordPress Customizer
 */
function easyjobs_customizer_styles() { ?>
	<style type="text/css">
		.customize-control-easyjobs-title .easyjobs-select,
		.customize-control-easyjobs-title .easyjobs-dimension{
			display: flex;
		}
		.customize-control-easyjobs-range-value {
			display: flex;
		}
		.customize-control-easyjobs-range-value .customize-control-title,
		.customize-control-easyjobs-number .customize-control-title {
			float: left;
		}
		.easyjobs-customize-control-separator {
			display: block;
			margin: 0 -12px;
			border: 1px solid #ddd;
			border-left: 0;
			border-right: 0;
			padding: 15px;
			font-size: 11px;
			font-weight: 600;
			letter-spacing: 2px;
			line-height: 1;
			text-transform: uppercase;
			color: #555;
			background-color: #fff;
		}
		.customize-control.customize-control-easyjobs-dimension,
		.customize-control-easyjobs-select {
			width: 25%;
			float: left !important;
			clear: none !important;
			margin-top: 0;
			margin-bottom: 12px;
		}
		.customize-control.customize-control-easyjobs-dimension .customize-control-title,
		.customize-control-easyjobs-select .customize-control-title{
			font-size: 11px;
			font-weight: normal;
			color: #888b8c;
			margin-top: 0;
		}
		.easyjobs-customizer-reset {
			font-size: 22px;
    		line-height: 26px;
    		margin-left: 5px;
			transition: unset;
		}
		.easyjobs-customizer-reset svg {
			width: 16px;
			fill: #FE1F4A;
		}
		.customize-control-title .customize-control-title {
			margin-bottom: 0;
		}
	</style>
	<?php

}
add_action( 'customize_controls_print_styles', 'easyjobs_customizer_styles', 999 );

function easyjobs_customize_css() {
	$output = easyjobs_generate_output();
    ?>
	<style type="text/css">

        /*********** Easyjobs dynamic css started *************/
        .easyjobs-frontend-wrapper.easyjobs-landing-page{
            background-color: <?php echo $output['easyjobs_landing_page_bg_color'] ?>;
            width: <?php echo $output['easyjobs_landing_container_width'] ?>%;
            max-width: <?php echo $output['easyjobs_landing_container_max_width'] ?>%;
            padding-top: <?php echo $output['easyjobs_landing_container_padding_top'] ?>px;
            padding-right: <?php echo $output['easyjobs_landing_container_padding_right'] ?>px;
            padding-bottom: <?php echo $output['easyjobs_landing_container_padding_bottom'] ?>px;
            padding-left: <?php echo $output['easyjobs_landing_container_padding_left'] ?>px;
        }

        .easyjobs-frontend-wrapper.easyjobs-landing-page .ej-header{
            background-color: <?php echo $output['easyjobs_landing_company_overview_bg_color'] ?>;
            padding-top: <?php echo $output['easyjobs_landing_company_overview_padding_top'] ?>px;
            padding-right: <?php echo $output['easyjobs_landing_company_overview_padding_right'] ?>px;
            padding-bottom: <?php echo $output['easyjobs_landing_company_overview_padding_bottom'] ?>px;
            padding-left: <?php echo $output['easyjobs_landing_company_overview_padding_right'] ?>px;
        }

        .easyjobs-landing-page .ej-header .ej-company-info .info .name{
            font-size: <?php echo $output['easyjobs_landing_company_name_font_size']?>px;
        }
        .easyjobs-landing-page .ej-header .ej-company-info .info .location{
            font-size: <?php echo $output['easyjobs_landing_company_location_font_size']?>px;
        }

        .easyjobs-landing-page .ej-header .ej-header-tools .ej-btn{
            font-size: <?php echo $output['easyjobs_landing_company_website_btn_font_size'];?>px;
            color: <?php echo $output['easyjobs_landing_company_website_btn_font_color'];?>;
            background-color: <?php echo $output['easyjobs_landing_company_website_btn_bg_color'];?>;
        }
        .easyjobs-landing-page .ej-header .ej-header-tools .ej-btn:hover{
            color: <?php echo $output['easyjobs_landing_company_website_btn_hover_font_color'];?>;
            background-color: <?php echo $output['easyjobs_landing_company_website_btn_hover_bg_color'];?>;
        }
        .easyjobs-landing-page .ej-company-description, .easyjobs-landing-page .ej-company-description p, .easyjobs-landing-page .ej-company-description p span, .easyjobs-landing-page .ej-company-description ul li, .easyjobs-landing-page .ej-company-description a{
            font-size: <?php echo $output['easyjobs_landing_company_description_font_size'];?>px;
            color: <?php echo $output['easyjobs_landing_company_description_color'];?>;
        }
        .easyjobs-landing-page .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner
        .ej-job-list-item-col{
            padding-top: <?php echo $output['easyjobs_landing_job_list_column_padding_top'] ?>px;
            padding-right: <?php echo $output['easyjobs_landing_job_list_column_padding_right'] ?>px;
            padding-bottom: <?php echo $output['easyjobs_landing_job_list_column_padding_bottom'] ?>px;
            padding-left: <?php echo $output['easyjobs_landing_job_list_column_padding_left'] ?>px;
            border-color: <?php echo $output['easyjobs_landing_job_column_separator_color'] ?>;
        }
        .easyjobs-landing-page .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner
        .ej-job-list-item-col .ej-job-title{
            font-size: <?php echo $output['easyjobs_landing_job_title_font_size']?>px;
        }
        .easyjobs-landing-page .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner
        .ej-job-list-item-col .ej-job-title a{
            color: <?php echo $output['easyjobs_landing_job_title_color']?>;
        }
        .easyjobs-landing-page .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner
        .ej-job-list-item-col .ej-job-title a:hover{
            color: <?php echo $output['easyjobs_landing_job_title_hover_color']?>;
        }
        .easyjobs-landing-page .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner
        .ej-job-list-item-col .ej-job-list-info .ej-job-list-info-block{
            font-size: <?php echo $output['easyjobs_landing_job_meta_font_size']?>px;
        }
        .easyjobs-landing-page .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner
        .ej-job-list-item-col .ej-job-list-info .ej-job-list-info-block a{
            color: <?php echo $output['easyjobs_landing_job_meta_company_link_color']?>
        }
        .easyjobs-landing-page .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner
        .ej-job-list-item-col .ej-job-list-info .ej-job-list-info-block{
            color: <?php echo $output['easyjobs_landing_job_meta_location_color']?>
        }
        .easyjobs-landing-page .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner
        .ej-job-list-item-col .ej-deadline{
            font-size: <?php echo $output['easyjobs_landing_job_deadline_font_size']?>px;
            color: <?php echo $output['easyjobs_landing_job_deadline_color']?>;
        }
        .easyjobs-landing-page .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner
        .ej-job-list-item-col .ej-list-sub{
            font-size: <?php echo $output['easyjobs_landing_job_vacancy_font_size']?>px;
            color: <?php echo $output['easyjobs_landing_job_vacancy_color']?>;
        }

        .easyjobs-landing-page .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner
        .ej-job-list-item-col .ej-btn.ej-info-btn-light{
            font-size: <?php echo $output['easyjobs_landing_apply_btn_font_size']?>px;
            color: <?php echo $output['easyjobs_landing_apply_btn_color']?>;
            background-color: <?php echo $output['easyjobs_landing_apply_btn_bg_color']?>;
        }

        .easyjobs-landing-page .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner
        .ej-job-list-item-col .ej-btn.ej-info-btn-light:hover{
            color: <?php echo $output['easyjobs_landing_apply_btn_hover_color']?>;
            background-color: <?php echo $output['easyjobs_landing_apply_btn_hover_bg_color']?>;
        }

        .easyjobs-landing-page .ej-section .ej-section-title .ej-section-title-text{
            color: <?php echo $output['easyjobs_landing_section_heading_color']?>;
            font-size: <?php echo $output['easyjobs_landing_section_heading_font_size']?>px;
        }
        .easyjobs-landing-page .ej-section .ej-section-title .ej-section-title-icon{
            color: <?php echo $output['easyjobs_landing_section_heading_icon_color']?>;
            background-color: <?php echo $output['easyjobs_landing_section_heading_icon_bg_color']?>;
        }
        /* Details page */
        
        .easyjobs-frontend-wrapper.easyjobs-single-page{
            background-color: <?php echo $output['easyjobs_single_page_bg_color'] ?>;
            width: <?php echo $output['easyjobs_single_container_width'] ?>%;
            max-width: <?php echo $output['easyjobs_single_container_max_width'] ?>%;
            padding-top: <?php echo $output['easyjobs_single_container_padding_top'] ?>px;
            padding-right: <?php echo $output['easyjobs_single_container_padding_right'] ?>px;
            padding-bottom: <?php echo $output['easyjobs_single_container_padding_bottom'] ?>px;
            padding-left: <?php echo $output['easyjobs_single_container_padding_left'] ?>px;
        }

        .easyjobs-single-page .easyjobs-details .ej-job-header .ej-job-header-left .ej-job-overview {
			<?php if(!empty(get_theme_mod('easyjobs_single_job_overview_bg_color'))) { ?>
			background-color: <?php echo get_theme_mod('easyjobs_single_job_overview_bg_color') ?>;
			<?php } elseif ($output['easyjobs_single_job_overview_bg_color']) { ?>
			background-color: <?php echo $output['easyjobs_single_job_overview_bg_color'] ?>;
			<?php } ?>
            padding-top: <?php echo $output['easyjobs_single_job_overview_padding_top'] ?>px;
            padding-right: <?php echo $output['easyjobs_single_job_overview_padding_right'] ?>px;
            padding-bottom: <?php echo $output['easyjobs_single_job_overview_padding_bottom'] ?>px;
            padding-left: <?php echo $output['easyjobs_single_job_overview_padding_left'] ?>px;
		}
        .easyjobs-single-page .ej-company-info .info .name{
            font-size: <?php echo $output['easyjobs_single_company_name_font_size'];?>px;
        }

        .easyjobs-single-page.ej-company-info .info .location{
            font-size: <?php echo $output['easyjobs_single_company_location_font_size'];?>px;
        }

        .easyjobs-single-page .easyjobs-details .ej-job-header .ej-job-header-left .ej-job-overview .ej-job-highlights .ej-job-highlights-item{
            font-size: <?php echo $output['easyjobs_single_job_info_list_font_size'];?>px;
        }
        .easyjobs-single-page .easyjobs-details .ej-job-header .ej-job-header-left .ej-job-overview .ej-job-highlights .ej-job-highlights-item .ej-job-highlights-item-label{
            color: <?php echo $output['easyjobs_single_job_info_list_label_color'];?>;
        }
        .easyjobs-single-page.easyjobs-details .ej-job-header .ej-job-header-left .ej-job-overview .ej-job-highlights .ej-job-highlights-item .ej-job-highlights-item-value{
            color: <?php echo $output['easyjobs_single_job_info_list_value_color'];?>;
        }
        .easyjobs-single-page .ej-apply-link .ej-btn.ej-info-btn{
            font-size: <?php echo $output['easyjobs_single_apply_btn_font_size'];?>px;
            background-color: <?php echo $output['easyjobs_single_apply_btn_bg_color'];?>;
            color: <?php echo $output['easyjobs_single_apply_btn_text_color'];?>;
        }
        .easyjobs-single-page .ej-apply-link .ej-btn.ej-info-btn:hover{
            background-color: <?php echo $output['easyjobs_single_apply_btn_hover_bg_color'];?>;
            color: <?php echo $output['easyjobs_single_apply_btn_hover_text_color'];?>;
        }
        .easyjobs-single-page .easyjobs-details .ej-job-header .ej-job-header-left .ej-job-overview-footer .ej-social-share ul li a{
            width: <?php echo $output['easyjobs_single_social_sharing_icon_bg_size'];?>px;
            height: <?php echo $output['easyjobs_single_social_sharing_icon_bg_size'];?>px;
        }
        .easyjobs-single-page .easyjobs-details .ej-job-header .ej-job-header-left .ej-job-overview-footer .ej-social-share ul li a svg{
            width: <?php echo $output['easyjobs_single_social_sharing_icon_size'];?>px;
            height: <?php echo $output['easyjobs_single_social_sharing_icon_size'];?>px;
        }

        .easyjobs-single-page .easyjobs-details .ej-content-block h1{
            font-size: <?php echo $output['easyjobs_single_h1_font_size']?>px;
        }
        .easyjobs-single-page .easyjobs-details .ej-content-block h2{
            font-size: <?php echo $output['easyjobs_single_h2_font_size']?>px;
        }
        .easyjobs-single-page .easyjobs-details .ej-content-block h3{
            font-size: <?php echo $output['easyjobs_single_h3_font_size']?>px;
        }
        .easyjobs-single-page .easyjobs-details .ej-content-block h4{
            font-size: <?php echo $output['easyjobs_single_h4_font_size']?>px;
        }
        .easyjobs-single-page .easyjobs-details .ej-content-block h5{
            font-size: <?php echo $output['easyjobs_single_h5_font_size']?>px;
        }
        .easyjobs-single-page .easyjobs-details .ej-content-block h6{
            font-size: <?php echo $output['easyjobs_single_h6_font_size']?>px;
        }
        .easyjobs-single-page .easyjobs-details .ej-content-block p,
        .easyjobs-single-page .easyjobs-details .ej-content-block ul li,
        .easyjobs-single-page .easyjobs-details .ej-content-block ol li,
        .easyjobs-single-page .easyjobs-details .ej-label{
            font-size: <?php echo $output['easyjobs_single_text_font_size']?>px;
        }
        .easyjobs-single-page .ej-section .ej-section-title .ej-section-title-text{
            font-size: <?php echo $output['easyjobs_single_section_heading_font_size']?>px;
        }
        
        

        /****** end easy jobs dynamic css *******/
	</style>
    <?php
}
add_action( 'wp_head', 'easyjobs_customize_css');