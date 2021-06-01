/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

    /********** Easyjobs started *************/

    /**
     * Landing page
     */

    wp.customize( 'easyjobs_landing_container_width', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-frontend-wrapper.easyjobs-landing-page' ).css( 'width', to + '%' );
        } );
    });
    wp.customize( 'easyjobs_landing_container_max_width', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-frontend-wrapper.easyjobs-landing-page' ).css( 'max-width', to + 'px' );
        } );
    });

    wp.customize( 'easyjobs_landing_container_padding_top', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-frontend-wrapper.easyjobs-landing-page' ).css( 'padding-top', to + 'px' );
        } );
    });
    wp.customize( 'easyjobs_landing_container_padding_right', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-frontend-wrapper.easyjobs-landing-page' ).css( 'padding-right', to + 'px' );
        } );
    });
    wp.customize( 'easyjobs_landing_container_padding_bottom', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-frontend-wrapper.easyjobs-landing-page' ).css( 'padding-bottom', to + 'px' );
        } );
    });
    wp.customize( 'easyjobs_landing_container_padding_left', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-frontend-wrapper.easyjobs-landing-page' ).css( 'padding-left', to + 'px' );
        } );
    });

    wp.customize( 'easyjobs_landing_page_bg_color', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-frontend-wrapper.easyjobs-landing-page' ).css( 'background-color', to );
        } );
    });

    wp.customize( 'easyjobs_landing_section_heading_color', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-landing-page .ej-section .ej-section-title .ej-section-title-text' ).css( 'color', to );
        } );
    });
    wp.customize( 'easyjobs_landing_section_heading_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-landing-page .ej-section .ej-section-title .ej-section-title-text' ).css( 'font-size', to + 'px');
        } );
    });

    wp.customize( 'easyjobs_landing_section_heading_icon_color', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-landing-page .ej-section .ej-section-title .ej-section-title-icon' ).css( 'color', to );
        } );
    });
    wp.customize( 'easyjobs_landing_section_heading_icon_bg_color', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-landing-page .ej-section .ej-section-title .ej-section-title-icon' ).css( 'background-color', to );
        } );
    });

    wp.customize( 'easyjobs_landing_company_overview_bg_color', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-frontend-wrapper.easyjobs-landing-page .ej-header' ).css( 'background-color', to );
        } );
    });

    wp.customize( 'easyjobs_landing_company_overview_padding_top', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-frontend-wrapper.easyjobs-landing-page .ej-header' ).css( 'padding-top', to + 'px' );
        } );
    });
    wp.customize( 'easyjobs_landing_company_overview_padding_right', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-frontend-wrapper.easyjobs-landing-page .ej-header' ).css( 'padding-right', to + 'px' );
        } );
    });
    wp.customize( 'easyjobs_landing_company_overview_padding_bottom', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-frontend-wrapper.easyjobs-landing-page .ej-header' ).css( 'padding-bottom', to + 'px' );
        } );
    });
    wp.customize( 'easyjobs_landing_company_overview_padding_left', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-frontend-wrapper.easyjobs-landing-page .ej-header' ).css( 'padding-left', to + 'px' );
        } );
    });

    wp.customize( 'easyjobs_landing_company_name_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-landing-page .ej-company-info .info .name' ).css( 'font-size', to + 'px' );
        } );
    });

    wp.customize( 'easyjobs_landing_company_location_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-landing-page .ej-company-info .info .location' ).css( 'font-size', to + 'px' );
        } );
    });

    wp.customize( 'easyjobs_landing_company_website_btn_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-landing-page .ej-header .ej-header-tools .ej-btn' ).css( 'font-size', to + 'px' );
        } );
    });

    wp.customize( 'easyjobs_landing_company_website_btn_font_color', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-landing-page .ej-header .ej-header-tools .ej-btn' ).css( 'color', to );
        } );
    });

    wp.customize( 'easyjobs_landing_company_website_btn_bg_color', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-landing-page .ej-header .ej-header-tools .ej-btn' ).css( 'background-color', to );
        } );
    });

    wp.customize( 'easyjobs_landing_company_website_btn_hover_font_color', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-landing-page .ej-header .ej-header-tools .ej-btn:hover' ).css( 'color', to );
        } );
    });

    wp.customize( 'easyjobs_landing_company_website_btn_hover_bg_color', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-landing-page .ej-header .ej-header-tools .ej-btn:hover' ).css( 'background-color', to );
        } );
    });

    wp.customize( 'easyjobs_landing_company_description_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-landing-page .ej-company-description, .easyjobs-landing-page .ej-company-description p, .easyjobs-landing-page .ej-company-description p span, .easyjobs-landing-page .ej-company-description ul li, .easyjobs-landing-page .ej-company-description a, .easyjobs-landing-page .ej-company-description p strong' ).css( 'font-size', to + 'px' );
        } );
    });

    wp.customize( 'easyjobs_landing_company_description_color', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-landing-page .ej-company-description, .easyjobs-landing-page .ej-company-description p, .easyjobs-landing-page .ej-company-description p span, .easyjobs-landing-page .ej-company-description ul li, .easyjobs-landing-page .ej-company-description a, .easyjobs-landing-page .ej-company-description p strong' ).css( 'color', to );
        } );
    });

    wp.customize( 'easyjobs_landing_job_list_column_padding_top', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-landing-page .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner .ej-job-list-item-col' ).css( 'padding-top', to + 'px' );
        } );
    });
    wp.customize( 'easyjobs_landing_job_list_column_padding_right', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-landing-page .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner .ej-job-list-item-col' ).css( 'padding-right', to + 'px' );
        } );
    });
    wp.customize( 'easyjobs_landing_job_list_column_padding_bottom', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-landing-page .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner .ej-job-list-item-col' ).css( 'padding-bottom', to + 'px' );
        } );
    });
    wp.customize( 'easyjobs_landing_job_list_column_padding_left', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-landing-page .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner .ej-job-list-item-col').css( 'padding-left', to + 'px' );
        } );
    });

    wp.customize( 'easyjobs_landing_job_column_separator_color', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-landing-page .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner .ej-job-list-item-col').css( 'border-color', to );
        } );
    });

    wp.customize( 'easyjobs_landing_job_title_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-landing-page .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner .ej-job-list-item-col .ej-job-title' ).css( 'font-size', to + 'px' );
        } );
    });

    wp.customize( 'easyjobs_landing_job_title_color', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-landing-page .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner .ej-job-list-item-col .ej-job-title a' ).css( 'color', to );
        } );
    });
    wp.customize( 'easyjobs_landing_job_title_hover_color', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-landing-page .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner .ej-job-list-item-col .ej-job-title a:hover' ).css( 'color', to );
        } );
    });

    wp.customize( 'easyjobs_landing_job_meta_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-landing-page .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner .ej-job-list-item-col .ej-job-list-info .ej-job-list-info-block' ).css( 'font-size', to + 'px' );
        } );
    });
    wp.customize( 'easyjobs_landing_job_meta_company_link_color', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-landing-page .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner .ej-job-list-item-col .ej-job-list-info .ej-job-list-info-block a' ).css( 'color', to );
        } );
    });

    wp.customize( 'easyjobs_landing_job_meta_location_color', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-landing-page .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner .ej-job-list-item-col .ej-job-list-info .ej-job-list-info-block' ).css( 'color', to );
        } );
    });

    wp.customize( 'easyjobs_landing_job_deadline_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-landing-page .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner .ej-job-list-item-col .ej-deadline' ).css( 'font-size', to + 'px' );
        } );
    });

    wp.customize( 'easyjobs_landing_job_deadline_color', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-landing-page .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner .ej-job-list-item-col .ej-deadline' ).css( 'color', to);
        } );
    });
    wp.customize( 'easyjobs_landing_job_vacancy_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-landing-page .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner .ej-job-list-item-col .ej-list-sub' ).css( 'font-size', to + 'px' );
        } );
    });

    wp.customize( 'easyjobs_landing_job_vacancy_color', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-landing-page .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner .ej-job-list-item-col .ej-list-sub' ).css( 'color', to);
        } );
    });

    wp.customize( 'easyjobs_landing_apply_btn_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-landing-page .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner .ej-job-list-item-col .ej-btn.ej-info-btn-light' ).css( 'font-size', to + 'px' );
        } );
    });

    wp.customize( 'easyjobs_landing_apply_btn_color', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-landing-page .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner .ej-job-list-item-col .ej-btn.ej-info-btn-light' ).css( 'color', to);
        } );
    });

    wp.customize( 'easyjobs_landing_apply_btn_bg_color', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-landing-page .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner .ej-job-list-item-col .ej-btn.ej-info-btn-light' ).css( 'background-color', to);
        } );
    });

    wp.customize( 'easyjobs_landing_apply_btn_hover_color', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-landing-page .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner .ej-job-list-item-col .ej-btn.ej-info-btn-light:hover' ).css( 'color', to);
        });
    });

    wp.customize( 'easyjobs_landing_apply_btn_hover_bg_color', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-landing-page .easyjobs-shortcode-wrapper .ej-job-list .ej-job-list-item .ej-job-list-item-inner .ej-job-list-item-col .ej-btn.ej-info-btn-light:hover' ).css( 'background-color', to);
        } );
    });



    /**
     * Details page
     */

    wp.customize( 'easyjobs_single_container_width', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-frontend-wrapper.easyjobs-single-page' ).css( 'width', to + '%' );
        } );
    });
    wp.customize( 'easyjobs_single_container_max_width', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-frontend-wrapper.easyjobs-single-page' ).css( 'max-width', to + 'px' );
        } );
    });

    wp.customize( 'easyjobs_single_container_padding_top', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-frontend-wrapper.easyjobs-single-page' ).css( 'padding-top', to + 'px' );
        } );
    });
    wp.customize( 'easyjobs_single_container_padding_right', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-frontend-wrapper.easyjobs-single-page' ).css( 'padding-right', to + 'px' );
        } );
    });
    wp.customize( 'easyjobs_single_container_padding_bottom', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-frontend-wrapper.easyjobs-single-page' ).css( 'padding-bottom', to + 'px' );
        } );
    });
    wp.customize( 'easyjobs_single_container_padding_left', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-frontend-wrapper.easyjobs-single-page' ).css( 'padding-left', to + 'px' );
        } );
    });

    wp.customize( 'easyjobs_single_page_bg_color', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-frontend-wrapper.easyjobs-single-page' ).css( 'background-color', to );
        } );
    });

    wp.customize( 'easyjobs_single_job_overview_bg_color', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-single-page .easyjobs-details .ej-job-header .ej-job-header-left .ej-job-overview' ).css( 'background-color', to );
        } );
    });

    wp.customize( 'easyjobs_single_job_overview_padding_top', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-single-page .easyjobs-details .ej-job-header .ej-job-header-left .ej-job-overview' ).css( 'padding-top', to + 'px' );
        } );
    });

    wp.customize( 'easyjobs_single_job_overview_padding_right', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-single-page .easyjobs-details .ej-job-header .ej-job-header-left .ej-job-overview' ).css( 'padding-right', to + 'px' );
        } );
    });

    wp.customize( 'easyjobs_single_job_overview_padding_bottom', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-single-page .easyjobs-details .ej-job-header .ej-job-header-left .ej-job-overview' ).css( 'padding-bottom', to + 'px' );
        } );
    });

    wp.customize( 'easyjobs_single_job_overview_padding_left', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-single-page .easyjobs-details .ej-job-header .ej-job-header-left .ej-job-overview' ).css( 'padding-left', to + 'px' );
        } );
    });

    wp.customize( 'easyjobs_single_company_name_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-single-page .ej-company-info .info .name' ).css( 'font-size', to + 'px' );
        } );
    });
    wp.customize( 'easyjobs_single_company_location_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-single-page .ej-company-info .info .location' ).css( 'font-size', to + 'px' );
        } );
    });
    wp.customize( 'easyjobs_single_job_info_list_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-single-page .easyjobs-details .ej-job-header .ej-job-header-left .ej-job-overview .ej-job-highlights .ej-job-highlights-item' ).css( 'font-size', to + 'px' );
        } );
    });
    wp.customize( 'easyjobs_single_job_info_list_label_color', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-single-page .easyjobs-details .ej-job-header .ej-job-header-left .ej-job-overview .ej-job-highlights .ej-job-highlights-item .ej-job-highlights-item-label' ).css( 'color', to );
        } );
    });

    wp.customize( 'easyjobs_single_job_info_list_value_color', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-single-page .easyjobs-details .ej-job-header .ej-job-header-left .ej-job-overview .ej-job-highlights .ej-job-highlights-item .ej-job-highlights-item-value' ).css( 'color', to );
        } );
    });

    wp.customize( 'easyjobs_single_apply_btn_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-single-page .ej-apply-link .ej-btn.ej-info-btn' ).css( 'font-size', to + 'px' );
        } );
    });

    wp.customize( 'easyjobs_single_apply_btn_bg_color', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-single-page .ej-apply-link .ej-btn.ej-info-btn' ).css( 'background-color', to );
        } );
    });

    wp.customize( 'easyjobs_single_apply_btn_text_color', function( value ) {
        value.bind( function( to ) {
            $('.easyjobs-single-page .ej-apply-link .ej-btn.ej-info-btn' ).css( 'color', to );
        } );
    });

    wp.customize( 'easyjobs_single_apply_btn_hover_bg_color', function( value ) {
        value.bind( function( to ) {
            $( '.easyjobs-single-page .ej-apply-link .ej-btn.ej-info-btn:hover' ).css( 'background-color', to );
        } );
    });

    wp.customize( 'easyjobs_single_apply_btn_hover_text_color', function( value ) {
        value.bind( function( to ) {
            $('.easyjobs-single-page .ej-apply-link .ej-btn.ej-info-btn:hover' ).css( 'color', to );
        } );
    });

    wp.customize( 'easyjobs_single_social_sharing_icon_bg_size', function( value ) {
        value.bind( function( to ) {
            $('.easyjobs-single-page .easyjobs-details .ej-job-header .ej-job-header-left .ej-job-overview-footer .ej-social-share ul li a' ).css( 'height', to + 'px' );
            $('.easyjobs-single-page .easyjobs-details .ej-job-header .ej-job-header-left .ej-job-overview-footer .ej-social-share ul li a' ).css( 'width', to + 'px' );
        } );
    });
    wp.customize( 'easyjobs_single_social_sharing_icon_size', function( value ) {
        value.bind( function( to ) {
            $('.easyjobs-single-page .easyjobs-details .ej-job-header .ej-job-header-left .ej-job-overview-footer .ej-social-share ul li a svg' ).css( 'height', to + 'px' );
            $('.easyjobs-single-page .easyjobs-details .ej-job-header .ej-job-header-left .ej-job-overview-footer .ej-social-share ul li a svg' ).css( 'width', to + 'px' );
        } );
    });
    wp.customize( 'easyjobs_single_h1_font_size', function( value ) {
        value.bind( function( to ) {
            $('.easyjobs-single-page .easyjobs-details .ej-content-block h1' ).css( 'font-size', to + 'px' );
            $('.easyjobs-single-page .ej-section .ej-section-title .ej-section-title-text' ).css( 'font-size', to + 'px' );

        } );
    });
    wp.customize( 'easyjobs_single_h2_font_size', function( value ) {
        value.bind( function( to ) {
            $('.easyjobs-single-page .easyjobs-details .ej-content-block h2' ).css( 'font-size', to + 'px' );

        } );
    });
    wp.customize( 'easyjobs_single_h3_font_size', function( value ) {
        value.bind( function( to ) {
            $('.easyjobs-single-page .easyjobs-details .ej-content-block h3' ).css( 'font-size', to + 'px' );

        } );
    });
    wp.customize( 'easyjobs_single_h4_font_size', function( value ) {
        value.bind( function( to ) {
            $('.easyjobs-single-page .easyjobs-details .ej-content-block h4' ).css( 'font-size', to + 'px' );

        } );
    });
    wp.customize( 'easyjobs_single_h5_font_size', function( value ) {
        value.bind( function( to ) {
            $('.easyjobs-single-page .easyjobs-details .ej-content-block h5' ).css( 'font-size', to + 'px' );

        } );
    });
    wp.customize( 'easyjobs_single_h6_font_size', function( value ) {
        value.bind( function( to ) {
            $('.easyjobs-single-page .easyjobs-details .ej-content-block h6' ).css( 'font-size', to + 'px' );

        } );
    });
    wp.customize( 'easyjobs_single_text_font_size', function( value ) {
        value.bind( function( to ) {
            $('.easyjobs-single-page .easyjobs-details .ej-content-block p' ).css( 'font-size', to + 'px' );
            $('.easyjobs-single-page .easyjobs-details .ej-content-block ul li' ).css( 'font-size', to + 'px' );
            $('.easyjobs-single-page .easyjobs-details .ej-content-block ol li' ).css( 'font-size', to + 'px' );
            $('.easyjobs-single-page .easyjobs-details .ej-label' ).css( 'font-size', to + 'px' );

        } );
    });
    wp.customize( 'easyjobs_single_section_heading_font_size', function( value ) {
        value.bind( function( to ) {
            $('.easyjobs-single-page .ej-section .ej-section-title .ej-section-title-text' ).css( 'font-size', to + 'px' );        } );
    });

    /*********** end easyjobs ********/


} )( jQuery );
