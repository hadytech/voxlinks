/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	// Container width
    wp.customize( 'reviewx_doc_page_background_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-wraper.reviewx-main-wraper' ).css( 'background-color', to );
        } );
    });

    wp.customize( 'reviewx_doc_page_background_image', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-wraper.reviewx-main-wraper' ).css( 'background-image', 'url('+to+')');
        } );
    });
    
    wp.customize( 'reviewx_doc_page_background_size', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-wraper.reviewx-main-wraper' ).css( 'background-size', to);
        } );
    });
    
    wp.customize( 'reviewx_doc_page_background_repeat', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-wraper.reviewx-main-wraper' ).css( 'background-repeat', to);
        } );
    });
    
    wp.customize( 'reviewx_doc_page_background_attachment', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-wraper.reviewx-main-wraper' ).css( 'background-attachment', to);
        } );
    });
    
    wp.customize( 'reviewx_doc_page_background_position', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-wraper.reviewx-main-wraper' ).css( 'background-position', to);
        } );
    });

    wp.customize( 'reviewx_doc_page_content_padding_top', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-archive-wrap.reviewx-archive-main' ).css( 'padding-top', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_page_content_padding_right', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-archive-wrap.reviewx-archive-main' ).css( 'padding-right', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_page_content_padding_bottom', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-archive-wrap.reviewx-archive-main' ).css( 'padding-bottom', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_page_content_padding_left', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-archive-wrap.reviewx-archive-main' ).css( 'padding-left', to + 'px' );
        } );
    });
    
    wp.customize( 'reviewx_doc_page_content_max_width', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-archive-main .reviewx-categories-wrap' ).css( 'max-width', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_page_content_width', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-archive-main .reviewx-categories-wrap' ).css( 'width', to + '%' );
        } );
    });

    wp.customize( 'reviewx_doc_page_column_space', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-categories-wrap.reviewx-archive-main .docs-single-cat-wrap' ).css( 'margin', to + 'px' );
            $( '.reviewx-categories-wrap.reviewx-archive-main.layout-flex .docs-single-cat-wrap' ).css( 'margin', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_page_column_padding_top', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-archive-main .reviewx-categories-wrap .docs-single-cat-wrap .docs-cat-title-wrap,.reviewx-categories-wrap.reviewx-category-box .docs-single-cat-wrap,.reviewx-categories-wrap .docs-single-cat-wrap.docs-cat-list-2-box' ).css( 'padding-top', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_page_column_padding_right', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-archive-main .reviewx-categories-wrap .docs-single-cat-wrap .docs-cat-title-wrap,.docs-item-container,.reviewx-categories-wrap.reviewx-category-box .docs-single-cat-wrap,.reviewx-categories-wrap .docs-single-cat-wrap.docs-cat-list-2-box' ).css( 'padding-right', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_page_column_padding_bottom', function( value ) {
        value.bind( function( to ) {
            $( '.docs-item-container,.reviewx-archive-main .reviewx-categories-wrap.reviewx-category-box .docs-single-cat-wrap,.reviewx-categories-wrap .docs-single-cat-wrap.docs-cat-list-2-box' ).css( 'padding-bottom', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_page_column_padding_left', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-archive-main .reviewx-categories-wrap .docs-single-cat-wrap .docs-cat-title-wrap,.docs-item-container,.reviewx-categories-wrap.reviewx-category-box .docs-single-cat-wrap,.reviewx-categories-wrap .docs-single-cat-wrap.docs-cat-list-2-box' ).css( 'padding-left', to + 'px' );
        } );
    });

    // Container width
    wp.customize( 'reviewx_doc_page_column_bg_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-category-list .white-bg .docs-single-cat-wrap,.reviewx-category-box.white-bg .docs-single-cat-wrap,.reviewx-categories-wrap.white-bg .docs-single-cat-wrap' ).css( 'background-color', to );
        } );
    });

    wp.customize( 'reviewx_doc_page_column_bg_color2', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-archive-main .reviewx-category-box.ash-bg .docs-single-cat-wrap' ).css( 'background-color', to );
        } );
    });

    wp.customize( 'reviewx_doc_page_column_borderr_topleft', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-archive-wrap.reviewx-archive-main .reviewx-categories-wrap .docs-single-cat-wrap, .reviewx-archive-main .reviewx-category-list .reviewx-categories-wrap .docs-single-cat-wrap .docs-cat-title-wrap' ).css( 'border-top-left-radius', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_page_column_borderr_topright', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-archive-wrap.reviewx-archive-main .reviewx-categories-wrap .docs-single-cat-wrap, .reviewx-archive-main .reviewx-category-list .reviewx-categories-wrap .docs-single-cat-wrap .docs-cat-title-wrap' ).css( 'border-top-right-radius', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_page_column_borderr_bottomright', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-archive-wrap.reviewx-archive-main .reviewx-categories-wrap .docs-single-cat-wrap, .reviewx-archive-main .reviewx-category-list .reviewx-categories-wrap .docs-single-cat-wrap .docs-item-container' ).css( 'border-bottom-right-radius', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_page_column_borderr_bottomleft', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-archive-wrap.reviewx-archive-main .reviewx-categories-wrap .docs-single-cat-wrap, .reviewx-archive-main .reviewx-category-list .reviewx-categories-wrap .docs-single-cat-wrap .docs-item-container' ).css( 'border-bottom-left-radius', to + 'px' );
        } );
    });
    
    wp.customize( 'reviewx_doc_page_cat_icon_size_layout1', function( value ) {
        value.bind( function( to ) {
            $( '.docs-cat-title > img' ).css( 'height', to + 'px' );
        } );
    });
    
    wp.customize( 'reviewx_doc_page_cat_icon_size_layout2', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-archive-main .reviewx-category-box .docs-single-cat-wrap img' ).css( 'height', to + 'px' );
        } );
    });
    
    wp.customize( 'reviewx_doc_page_column_content_space_image', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-archive-main .reviewx-category-box .docs-single-cat-wrap img' ).css( 'margin-bottom', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_page_column_content_space_title', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-archive-main .reviewx-category-box .docs-single-cat-wrap .docs-cat-title, .reviewx-archive-main .pro-layout-4 .docs-cat-list-2-box-content .docs-cat-title' ).css( 'margin-bottom', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_page_column_content_space_desc', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-archive-main .reviewx-category-box .docs-single-cat-wrap p' ).css( 'margin-bottom', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_page_column_content_space_counter', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-archive-main .reviewx-category-box .docs-single-cat-wrap span' ).css( 'margin-bottom', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_page_cat_title_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-archive-main .docs-cat-title-inner h3, .reviewx-archive-main .reviewx-category-box .docs-single-cat-wrap .docs-cat-title' ).css( 'font-size', to + 'px' );
        } );
    });
    
    wp.customize( 'reviewx_doc_page_cat_title_color', function( value ) {
        value.bind( function( to ) {
            $( '.docs-cat-title-inner h3' ).css( 'color', to );
        } );
    });

    wp.customize( 'reviewx_doc_page_cat_title_color2', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-archive-main .reviewx-category-box .docs-single-cat-wrap .docs-cat-title, .reviewx-archive-main .docs-cat-list-2 .docs-cat-title' ).css( 'color', to );
        } );
    });
    
    wp.customize( 'reviewx_doc_page_cat_title_border_color', function( value ) {
        value.bind( function( to ) {
            $( '.docs-cat-title-inner' ).css( 'border-color', to );
        } );
    });

    wp.customize( 'reviewx_doc_page_cat_desc_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-category-box .docs-single-cat-wrap p' ).css( 'color', to );
        } );
    });
    
    wp.customize( 'reviewx_doc_page_item_count_color', function( value ) {
        value.bind( function( to ) {
            $( '.docs-cat-title-inner span' ).css( 'color', to );
        } );
    });

    wp.customize( 'reviewx_doc_page_item_count_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.docs-cat-title-inner span,.reviewx-categories-wrap.reviewx-category-box .docs-single-cat-wrap span' ).css( 'font-size', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_page_item_count_color_layout2', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-categories-wrap.reviewx-category-box .docs-single-cat-wrap span,.docs-cat-list-2-box .title-count span' ).css( 'color', to );
        } );
    });
    
    wp.customize( 'reviewx_doc_page_item_count_bg_color', function( value ) {
        value.bind( function( to ) {
            $( '.docs-item-count' ).css( 'background-color', to );
        } );
    });
    
    wp.customize( 'reviewx_doc_page_item_count_inner_bg_color', function( value ) {
        value.bind( function( to ) {
            $( '.docs-item-count span' ).css( 'background-color', to );
        } );
    });

    wp.customize( 'reviewx_doc_page_item_counter_size', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-archive-wrap .reviewx-categories-wrap .docs-cat-title-inner span' ).css( 'width', to + 'px' );
            $( '.reviewx-archive-wrap .reviewx-categories-wrap .docs-cat-title-inner span' ).css( 'height', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_page_article_list_bg_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-archive-wrap .reviewx-categories-wrap .docs-item-container' ).css( 'background-color', to );
        } );
    });

    wp.customize( 'reviewx_doc_page_article_list_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-archive-wrap .reviewx-categories-wrap .docs-item-container li a' ).css( 'color', to );
        } );
    });

    wp.customize( 'reviewx_doc_page_article_list_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-archive-wrap .reviewx-categories-wrap .docs-item-container li a' ).css( 'font-size', to + 'px' );
            
        } );
    });

    wp.customize( 'reviewx_doc_page_list_icon_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-archive-wrap .reviewx-categories-wrap .docs-item-container li svg' ).css( 'fill', to );
        } );
    });

    wp.customize( 'reviewx_doc_page_list_icon_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-archive-wrap .reviewx-categories-wrap .docs-item-container li svg' ).css( 'font-size', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_page_article_subcategory_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-archive-wrap .reviewx-categories-wrap .docs-item-container .docs-sub-cat-title a' ).css( 'color', to );
        } );
    });

    wp.customize( 'reviewx_doc_page_article_subcategory_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-archive-wrap .reviewx-categories-wrap .docs-item-container .docs-sub-cat-title a' ).css( 'font-size', to + 'px' );
            
        } );
    });

    wp.customize( 'reviewx_doc_page_subcategory_icon_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-archive-wrap .reviewx-categories-wrap .docs-item-container .docs-sub-cat-title svg' ).css( 'fill', to );
        } );
    });

    wp.customize( 'reviewx_doc_page_subcategory_icon_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-archive-wrap .reviewx-categories-wrap .docs-item-container .docs-sub-cat-title svg' ).css( 'font-size', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_page_article_list_margin_top', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-archive-wrap .reviewx-categories-wrap .docs-item-container li' ).css( 'margin-top', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_page_article_list_margin_right', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-archive-wrap .reviewx-categories-wrap .docs-item-container li' ).css( 'margin-right', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_page_article_list_margin_bottom', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-archive-wrap .reviewx-categories-wrap .docs-item-container li' ).css( 'margin-bottom', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_page_article_list_margin_left', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-archive-wrap .reviewx-categories-wrap .docs-item-container li' ).css( 'margin-left', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_page_subcategory_article_list_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-archive-wrap .reviewx-categories-wrap .docs-item-container .docs-sub-cat li a' ).css( 'color', to );
        } );
    });

    wp.customize( 'reviewx_doc_page_subcategory_article_list_icon_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-archive-wrap .reviewx-categories-wrap .docs-item-container .docs-sub-cat li svg' ).css( 'color', to );
        } );
    });

    wp.customize( 'reviewx_doc_page_explore_btn_bg_color', function( value ) {
        value.bind( function( to ) {
            $( '.docs-cat-link-btn' ).css( 'background-color', to );
        } );
    });
    
    wp.customize( 'reviewx_doc_page_explore_btn_color', function( value ) {
        value.bind( function( to ) {
            $( '.docs-cat-link-btn' ).css( 'color', to );
        } );
    });
    
    wp.customize( 'reviewx_doc_page_explore_btn_border_color', function( value ) {
        value.bind( function( to ) {
            $( '.docs-cat-link-btn' ).css( 'border-color', to );
        } );
    });
    
    wp.customize( 'reviewx_doc_page_explore_btn_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.docs-cat-link-btn' ).css( 'font-size', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_page_explore_btn_padding_top', function( value ) {
        value.bind( function( to ) {
            $( '.docs-cat-link-btn' ).css( 'padding-top', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_page_explore_btn_padding_right', function( value ) {
        value.bind( function( to ) {
            $( '.docs-cat-link-btn' ).css( 'padding-right', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_page_explore_btn_padding_bottom', function( value ) {
        value.bind( function( to ) {
            $( '.docs-cat-link-btn' ).css( 'padding-bottom', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_page_explore_btn_padding_left', function( value ) {
        value.bind( function( to ) {
            $( '.docs-cat-link-btn' ).css( 'padding-left', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_page_explore_btn_borderr_topleft', function( value ) {
        value.bind( function( to ) {
            $( '.docs-cat-link-btn' ).css( 'border-top-left-radius', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_page_explore_btn_borderr_topright', function( value ) {
        value.bind( function( to ) {
            $( '.docs-cat-link-btn' ).css( 'border-top-right-radius', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_page_explore_btn_borderr_bottomright', function( value ) {
        value.bind( function( to ) {
            $( '.docs-cat-link-btn' ).css( 'border-bottom-right-radius', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_page_explore_btn_borderr_bottomleft', function( value ) {
        value.bind( function( to ) {
            $( '.docs-cat-link-btn' ).css( 'border-bottom-left-radius', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_single_content_area_bg_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-single-bg .reviewx-content-area' ).css( 'background-color', to );
        } );
    });

    wp.customize( 'reviewx_doc_single_content_area_padding_top', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-single-wraper .reviewx-content-area' ).css( 'padding-top', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_single_content_area_padding_right', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-single-wraper .reviewx-content-area' ).css( 'padding-right', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_single_content_area_padding_bottom', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-single-wraper .reviewx-content-area' ).css( 'padding-bottom', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_single_content_area_padding_left', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-single-wraper .reviewx-content-area' ).css( 'padding-left', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_single_post_content_padding_top', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-single-wraper .reviewx-content-area .docs-single-main' ).css( 'padding-top', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_single_post_content_padding_right', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-single-wraper .reviewx-content-area .docs-single-main' ).css( 'padding-right', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_single_post_content_padding_bottom', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-single-wraper .reviewx-content-area .docs-single-main' ).css( 'padding-bottom', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_single_post_content_padding_left', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-single-wraper .reviewx-content-area .docs-single-main' ).css( 'padding-left', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_single_2_post_content_padding_top', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-single-layout2 .docs-content-full-main .doc-single-content-wrapper' ).css( 'padding-top', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_single_2_post_content_padding_right', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-single-layout2 .docs-content-full-main .doc-single-content-wrapper' ).css( 'padding-right', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_single_2_post_content_padding_bottom', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-single-layout2 .docs-content-full-main .doc-single-content-wrapper' ).css( 'padding-bottom', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_single_2_post_content_padding_left', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-single-layout2 .docs-content-full-main .doc-single-content-wrapper' ).css( 'padding-left', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_single_3_post_content_padding_top', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-single-layout3 .docs-content-full-main .doc-single-content-wrapper' ).css( 'padding-top', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_single_3_post_content_padding_right', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-single-layout3 .docs-content-full-main .doc-single-content-wrapper' ).css( 'padding-right', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_single_3_post_content_padding_bottom', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-single-layout3 .docs-content-full-main .doc-single-content-wrapper' ).css( 'padding-bottom', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_single_3_post_content_padding_left', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-single-layout3 .docs-content-full-main .doc-single-content-wrapper' ).css( 'padding-left', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_single_doc_title_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.docs-single-title .reviewx-entry-title' ).css( 'font-size', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_single_doc_title_color', function( value ) {
        value.bind( function( to ) {
            $( '.docs-single-title .reviewx-entry-title' ).css( 'color', to );
        } );
    });

    wp.customize( 'reviewx_single_doc_breadcrumb_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-breadcrumb .reviewx-breadcrumb-item a' ).css( 'color', to );
        } );
    });
    
    wp.customize( 'reviewx_single_doc_breadcrumbs_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-breadcrumb .reviewx-breadcrumb-item a' ).css( 'font-size', to + 'px' );
            $( '.reviewx-breadcrumb-item.current span' ).css( 'font-size', to + 'px' );
            $( '.reviewx-breadcrumb .breadcrumb-delimiter' ).css( 'font-size', to + 'px' );
        } );
    });
    
    wp.customize( 'reviewx_single_doc_breadcrumb_speretor_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-breadcrumb .breadcrumb-delimiter' ).css( 'color', to );
        } );
    });
    
    wp.customize( 'reviewx_single_doc_breadcrumb_active_item_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-breadcrumb-item.current span' ).css( 'color', to );
        } );
    });
    
    wp.customize( 'reviewx_sticky_toc_width', function( value ) {
        value.bind( function( to ) {
            $( '.sticky-toc-container' ).css( 'width', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_sticky_toc_zindex', function( value ) {
        value.bind( function( to ) {
            $( '.sticky-toc-container' ).css( 'z-index', to );
        } );
    });
    
    wp.customize( 'reviewx_sticky_toc_margin_top', function( value ) {
        value.bind( function( to ) {
            $( '.sticky-toc-container.toc-sticky' ).css( 'margin-top', to + 'px');
        } );
    });
    
    wp.customize( 'reviewx_toc_bg_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-toc,.right-sidebar-toc-wrap' ).css( 'background-color', to );
        } );
    });

    wp.customize( 'reviewx_doc_single_toc_padding_top', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-toc,.right-sidebar-toc-wrap' ).css( 'padding-top', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_single_toc_padding_right', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-toc,.right-sidebar-toc-wrap' ).css( 'padding-right', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_single_toc_padding_bottom', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-toc,.right-sidebar-toc-wrap' ).css( 'padding-bottom', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_single_toc_padding_left', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-toc,.right-sidebar-toc-wrap' ).css( 'padding-left', to + 'px' );
        } );
    });
    
    wp.customize( 'reviewx_toc_title_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-toc > .toc-title,.reviewx-entry-content .reviewx-toc.collapsible-sm .angle-icon' ).css( 'color', to );
        } );
    });
    
    wp.customize( 'reviewx_toc_title_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-toc > .toc-title' ).css( 'font-size', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_toc_list_item_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-toc > .toc-list a' ).css( 'color', to );
        } );
    });

    wp.customize( 'reviewx_toc_active_item_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-toc > .toc-list a.active' ).css( 'color', to );
        } );
    });
    
    wp.customize( 'reviewx_toc_list_item_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-toc > .toc-list a' ).css( 'font-size', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_single_toc_list_margin_top', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-toc > .toc-list a' ).css( 'margin-top', to + 'px' );
        } );
    });
    
    wp.customize( 'reviewx_doc_single_toc_list_margin_top', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-toc > .toc-list li:before' ).css( 'padding-top', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_single_toc_list_margin_right', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-toc > .toc-list a' ).css( 'margin-right', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_single_toc_list_margin_bottom', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-toc > .toc-list a' ).css( 'margin-bottom', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_doc_single_toc_list_margin_left', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-toc > .toc-list a' ).css( 'margin-left', to + 'px' );
        } );
    });
    
    wp.customize( 'reviewx_toc_margin_bottom', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-entry-content .reviewx-toc' ).css( 'margin-bottom', to + 'px' );
        } );
    });
    
    wp.customize( 'reviewx_single_content_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-content' ).css( 'font-size', to + 'px' );
        } );
    });
    
    wp.customize( 'reviewx_single_content_font_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-content' ).css( 'color', to );
        } );
    });
    
    wp.customize( 'reviewx_post_social_share_text_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-social-share .reviewx-social-share-heading h5' ).css( 'color', to );
        } );
    });

    wp.customize( 'reviewx_single_doc_feedback_icon_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.feedback-form-link .feedback-form-icon svg, .feedback-form-link .feedback-form-icon img' ).css( 'width', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_single_doc_feedback_link_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-entry-footer .feedback-form-link' ).css( 'color', to );
        } );
    });

    wp.customize( 'reviewx_single_doc_feedback_link_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-entry-footer .feedback-form-link' ).css( 'font-size', to + 'px' );
        } );
    });
    
    wp.customize( 'reviewx_single_doc_feedback_link_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-entry-footer .feedback-form-link' ).css( 'color', to );
        } );
    });

    wp.customize( 'reviewx_single_doc_feedback_link_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-entry-footer .feedback-form-link' ).css( 'font-size', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_single_doc_navigation_color', function( value ) {
        value.bind( function( to ) {
            $( '.docs-navigation a' ).css( 'color', to );
        } );
    });

    wp.customize( 'reviewx_single_doc_navigation_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.docs-navigation a' ).css( 'font-size', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_single_doc_navigation_arrow_color', function( value ) {
        value.bind( function( to ) {
            $( '.docs-navigation a svg' ).css( 'fill', to );
        } );
    });

    wp.customize( 'reviewx_single_doc_navigation_arrow_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.docs-navigation a svg' ).css( 'width', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_single_doc_lu_time_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-entry-footer .update-date' ).css( 'color', to );
        } );
    });

    wp.customize( 'reviewx_single_doc_lu_time_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-entry-footer .update-date' ).css( 'font-size', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_single_doc_powered_by_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-credit p' ).css( 'color', to );
        } );
    });

    wp.customize( 'reviewx_single_doc_powered_by_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-credit p' ).css( 'font-size', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_single_doc_powered_by_link_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-credit p a' ).css( 'color', to );
        } );
    });
    
    wp.customize( 'reviewx_sidebar_bg_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-sidebar-content .reviewx-categories-wrap,.reviewx-full-sidebar-left' ).css( 'background-color', to );
        } );
    });

    wp.customize( 'reviewx_sidebar_padding_top', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-sidebar-content .reviewx-categories-wrap, .reviewx-full-sidebar-left .reviewx-categories-wrap' ).css( 'padding-top', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_sidebar_padding_right', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-sidebar-content .reviewx-categories-wrap, .reviewx-full-sidebar-left .reviewx-categories-wrap' ).css( 'padding-right', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_sidebar_padding_bottom', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-sidebar-content .reviewx-categories-wrap, .reviewx-full-sidebar-left .reviewx-categories-wrap' ).css( 'padding-bottom', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_sidebar_padding_left', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-sidebar-content .reviewx-categories-wrap, .reviewx-full-sidebar-left .reviewx-categories-wrap' ).css( 'padding-left', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_sidebar_borderr_topleft', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-single-layout1 .reviewx-sidebar-content .reviewx-categories-wrap' ).css( 'border-top-left-radius', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_sidebar_borderr_topright', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-single-layout1 .reviewx-sidebar-content .reviewx-categories-wrap' ).css( 'border-top-right-radius', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_sidebar_borderr_bottomright', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-single-layout1 .reviewx-sidebar-content .reviewx-categories-wrap' ).css( 'border-bottom-right-radius', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_sidebar_borderr_bottomleft', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-single-layout1 .reviewx-sidebar-content .reviewx-categories-wrap' ).css( 'border-bottom-left-radius', to + 'px' );
        } );
    });
    
    wp.customize( 'reviewx_sidebar_icon_size', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-sidebar-content .docs-cat-title > img' ).css( 'height', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_sidebar_title_bg_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-sidebar-content .docs-single-cat-wrap .docs-cat-title-wrap' ).css( 'background-color', to );
        } );
    });
    
    wp.customize( 'reviewx_sidebar_title_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-sidebar-content .docs-cat-title-inner h3,.reviewx-sidebar-content .docs-cat-title-inner .cat-list-arrow-down' ).css( 'color', to );
        } );
    });
    
    wp.customize( 'reviewx_sidebar_active_title_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-sidebar-content .docs-single-cat-wrap .active-title .docs-cat-title-inner h3,.reviewx-sidebar-content .active-title .docs-cat-title-inner h3,.reviewx-full-sidebar-left .docs-cat-title-wrap::after').css( 'color', to );
        } );
    });
    
    wp.customize( 'reviewx_sidebar_title_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-sidebar-content .docs-cat-title-inner h3' ).css( 'font-size', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_sidebar_title_padding_top', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-sidebar-content .reviewx-categories-wrap .docs-single-cat-wrap .docs-cat-title-wrap' ).css( 'padding-top', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_sidebar_title_padding_right', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-sidebar-content .reviewx-categories-wrap .docs-single-cat-wrap .docs-cat-title-wrap' ).css( 'padding-right', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_sidebar_title_padding_bottom', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-sidebar-content .reviewx-categories-wrap .docs-single-cat-wrap .docs-cat-title-wrap' ).css( 'padding-bottom', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_sidebar_title_padding_left', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-sidebar-content .reviewx-categories-wrap .docs-single-cat-wrap .docs-cat-title-wrap' ).css( 'padding-left', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_sidebar_title_margin_top', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-sidebar-content .reviewx-categories-wrap .docs-single-cat-wrap' ).css( 'margin-top', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_sidebar_title_margin_right', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-sidebar-content .reviewx-categories-wrap .docs-single-cat-wrap' ).css( 'margin-right', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_sidebar_title_margin_bottom', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-sidebar-content .reviewx-categories-wrap .docs-single-cat-wrap' ).css( 'margin-bottom', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_sidebar_title_margin_left', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-sidebar-content .reviewx-categories-wrap .docs-single-cat-wrap' ).css( 'margin-left', to + 'px' );
        } );
    });
    
    wp.customize( 'reviewx_sidbebar_item_list_bg_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-sidebar-content .docs-item-container' ).css( 'background-color', to );
        } );
    });
    
    wp.customize( 'reviewx_sidbebar_item_count_bg_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-sidebar-content .docs-item-count' ).css( 'background-color', to );
        } );
    });
    
    wp.customize( 'reviewx_sidbebar_item_count_inner_bg_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-sidebar-content .docs-item-count span' ).css( 'background-color', to );
        } );
    });

    wp.customize( 'reviewx_sidebar_item_counter_size', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-sidebar-content .docs-item-count span' ).css( 'width', to + 'px' );
            $( '.reviewx-sidebar-content .docs-item-count span' ).css( 'height', to + 'px' );
        } );
    });
    
    wp.customize( 'reviewx_sidebar_item_count_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-sidebar-content .docs-item-count span' ).css( 'color', to );
        } );
    });

    wp.customize( 'reviewx_sidebat_item_count_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-sidebar-content .docs-item-count span' ).css( 'font-size', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_sidebar_active_cat_background_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-sidebar-content .docs-single-cat-wrap .docs-cat-title-wrap.active-title' ).css( 'background-color', to );
        } );
    });

    wp.customize( 'reviewx_sidebar_active_cat_border_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-sidebar-content .docs-single-cat-wrap .docs-cat-title-wrap.active-title' ).css( 'border-color', to );
        } );
    });

    wp.customize( 'reviewx_sidebar_list_item_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-sidebar-content .reviewx-categories-wrap li a' ).css( 'color', to );
        } );
    });
    
    wp.customize( 'reviewx_sidebar_active_list_item_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-sidebar-content .reviewx-categories-wrap li a.active, .reviewx-sidebar-content .reviewx-categories-wrap li.sub-list a.active' ).css( 'color', to );
        } );
    });

    wp.customize( 'reviewx_sidebar_list_item_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-sidebar-content .reviewx-categories-wrap li a' ).css( 'font-size', to + 'px');
        } );
    });

    wp.customize( 'reviewx_sidebar_list_item_margin_top', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-sidebar-content .reviewx-categories-wrap .docs-item-container li' ).css( 'margin-top', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_sidebar_list_item_margin_right', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-sidebar-content .reviewx-categories-wrap .docs-item-container li' ).css( 'margin-right', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_sidebar_list_item_margin_bottom', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-sidebar-content .reviewx-categories-wrap .docs-item-container li' ).css( 'margin-bottom', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_sidebar_list_item_margin_left', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-sidebar-content .reviewx-categories-wrap .docs-item-container li' ).css( 'margin-left', to + 'px' );
        } );
    });
    
    wp.customize( 'reviewx_sidebar_list_icon_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-sidebar-content .reviewx-categories-wrap .docs-item-container li svg' ).css( 'fill', to );
        } );
    });
    
    wp.customize( 'reviewx_sidebar_list_icon_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-sidebar-content .reviewx-categories-wrap .docs-item-container li svg' ).css( 'font-size', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_archive_page_background_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-category-wraper.reviewx-single-wraper' ).css( 'background-color', to);
        } );
    });

    wp.customize( 'reviewx_archive_page_background_image', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-category-wraper.reviewx-single-wraper' ).css( 'background-image', 'url('+to+')');
        } );
    });
    
    wp.customize( 'reviewx_archive_page_background_size', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-category-wraper.reviewx-single-wraper' ).css( 'background-size', to);
        } );
    });
    
    wp.customize( 'reviewx_archive_page_background_repeat', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-category-wraper.reviewx-single-wraper' ).css( 'background-repeat', to);
        } );
    });
    
    wp.customize( 'reviewx_archive_page_background_attachment', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-category-wraper.reviewx-single-wraper' ).css( 'background-attachment', to);
        } );
    });

    wp.customize( 'reviewx_archive_page_background_position', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-category-wraper.reviewx-single-wraper' ).css( 'background-position', to);
        } );
    });
    
    wp.customize( 'reviewx_archive_content_background_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-category-wraper.reviewx-single-wraper .docs-listing-main .docs-category-listing' ).css( 'background-color', to);
        } );
    });

    wp.customize( 'reviewx_archive_content_margin_top', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-category-wraper.reviewx-single-wraper .docs-listing-main .docs-category-listing' ).css( 'margin-top', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_archive_content_margin_right', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-category-wraper.reviewx-single-wraper .docs-listing-main .docs-category-listing' ).css( 'margin-right', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_archive_content_margin_bottom', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-category-wraper.reviewx-single-wraper .docs-listing-main .docs-category-listing' ).css( 'margin-bottom', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_archive_content_margin_left', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-category-wraper.reviewx-single-wraper .docs-listing-main .docs-category-listing' ).css( 'margin-left', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_archive_content_padding_top', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-category-wraper.reviewx-single-wraper .docs-listing-main .docs-category-listing' ).css( 'padding-top', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_archive_content_padding_right', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-category-wraper.reviewx-single-wraper .docs-listing-main .docs-category-listing' ).css( 'padding-right', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_archive_content_padding_bottom', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-category-wraper.reviewx-single-wraper .docs-listing-main .docs-category-listing' ).css( 'padding-bottom', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_archive_content_padding_left', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-category-wraper.reviewx-single-wraper .docs-listing-main .docs-category-listing' ).css( 'padding-left', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_archive_content_border_radius', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-category-wraper.reviewx-single-wraper .docs-listing-main .docs-category-listing' ).css( 'border-radius', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_archive_title_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-category-wraper .docs-category-listing .docs-cat-title h3' ).css( 'color', to );
        } );
    });

    wp.customize( 'reviewx_archive_title_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-category-wraper .docs-category-listing .docs-cat-title h3' ).css( 'font-size', to + 'px');
        } );
    });

    wp.customize( 'reviewx_archive_title_margin_top', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-category-wraper .docs-category-listing .docs-cat-title h3' ).css( 'margin-top', to + 'px');
        } );
    });

    wp.customize( 'reviewx_archive_title_margin_right', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-category-wraper .docs-category-listing .docs-cat-title h3' ).css( 'margin-right', to + 'px');
        } );
    });

    wp.customize( 'reviewx_archive_title_margin_bottom', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-category-wraper .docs-category-listing .docs-cat-title h3' ).css( 'margin-bottom', to + 'px');
        } );
    });

    wp.customize( 'reviewx_archive_title_margin_left', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-category-wraper .docs-category-listing .docs-cat-title h3' ).css( 'margin-left', to + 'px');
        } );
    });

    wp.customize( 'reviewx_archive_description_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-category-wraper .docs-category-listing .docs-cat-title p' ).css( 'color', to );
        } );
    });

    wp.customize( 'reviewx_archive_description_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-category-wraper .docs-category-listing .docs-cat-title p' ).css( 'font-size', to + 'px');
        } );
    });

    wp.customize( 'reviewx_archive_description_margin_top', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-category-wraper .docs-category-listing .docs-cat-title p' ).css( 'margin-top', to + 'px');
        } );
    });

    wp.customize( 'reviewx_archive_description_margin_right', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-category-wraper .docs-category-listing .docs-cat-title p' ).css( 'margin-right', to + 'px');
        } );
    });

    wp.customize( 'reviewx_archive_description_margin_bottom', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-category-wraper .docs-category-listing .docs-cat-title p' ).css( 'margin-bottom', to + 'px');
        } );
    });

    wp.customize( 'reviewx_archive_description_margin_left', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-category-wraper .docs-category-listing .docs-cat-title p' ).css( 'margin-left', to + 'px');
        } );
    });

    wp.customize( 'reviewx_archive_article_list_margin_top', function( value ) {
        value.bind( function( to ) {
            $( '.docs-category-listing .docs-list ul li, .docs-category-listing .docs-list .docs-sub-cat-title' ).css( 'margin-top', to + 'px');
        } );
    });

    wp.customize( 'reviewx_archive_article_list_margin_right', function( value ) {
        value.bind( function( to ) {
            $( '.docs-category-listing .docs-list ul li, .docs-category-listing .docs-list .docs-sub-cat-title' ).css( 'margin-right', to + 'px');
        } );
    });

    wp.customize( 'reviewx_archive_article_list_margin_bottom', function( value ) {
        value.bind( function( to ) {
            $( '.docs-category-listing .docs-list ul li, .docs-category-listing .docs-list .docs-sub-cat-title' ).css( 'margin-bottom', to + 'px');
        } );
    });

    wp.customize( 'reviewx_archive_article_list_margin_left', function( value ) {
        value.bind( function( to ) {
            $( '.docs-category-listing .docs-list ul li, .docs-category-listing .docs-list .docs-sub-cat-title' ).css( 'margin-left', to + 'px');
        } );
    });

    wp.customize( 'reviewx_archive_list_icon_color', function( value ) {
        value.bind( function( to ) {
            $( '.docs-category-listing .docs-list ul li svg' ).css( 'fill', to );
        } );
    });

    wp.customize( 'reviewx_archive_list_icon_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.docs-category-listing .docs-list ul li svg' ).css( 'font-size', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_archive_list_item_color', function( value ) {
        value.bind( function( to ) {
            $( '.docs-category-listing .docs-list ul li a' ).css( 'color', to );
        } );
    });

    wp.customize( 'reviewx_archive_list_item_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.docs-category-listing .docs-list ul li a' ).css( 'font-size', to + 'px');
        } );
    });

    wp.customize( 'reviewx_live_search_heading_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-search-heading h2' ).css( 'font-size', to + 'px');
        } );
    });

    wp.customize( 'reviewx_live_search_heading_font_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-search-heading h2' ).css( 'color', to );
        } );
    });

    wp.customize( 'reviewx_live_search_subheading_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-search-heading h3' ).css( 'font-size', to + 'px');
        } );
    });
    
    wp.customize( 'reviewx_live_search_subheading_font_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-search-heading h3' ).css( 'color', to );
        } );
    });

    wp.customize( 'reviewx_search_heading_margin_top', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-search-heading h2' ).css( 'margin-top', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_search_heading_margin_right', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-search-heading h2' ).css( 'margin-right', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_search_heading_margin_bottom', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-search-heading h2' ).css( 'margin-bottom', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_search_heading_margin_left', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-search-heading h2' ).css( 'margin-left', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_search_subheading_margin_top', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-search-heading h3' ).css( 'margin-top', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_search_subheading_margin_right', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-search-heading h3' ).css( 'margin-right', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_search_subheading_margin_bottom', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-search-heading h3' ).css( 'margin-bottom', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_search_subheading_margin_left', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-search-heading h3' ).css( 'margin-left', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_live_search_background_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-search-form-wrap' ).css( 'background-color', to);
        } );
    });

    wp.customize( 'reviewx_live_search_background_image', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-search-form-wrap' ).css( 'background-image', 'url('+to+')');
        } );
    });
    
    wp.customize( 'reviewx_live_search_background_size', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-search-form-wrap' ).css( 'background-size', to);
        } );
    });
    
    wp.customize( 'reviewx_live_search_background_repeat', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-search-form-wrap' ).css( 'background-repeat', to);
        } );
    });
    
    wp.customize( 'reviewx_live_search_background_attachment', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-search-form-wrap' ).css( 'background-attachment', to);
        } );
    });

    wp.customize( 'reviewx_live_search_background_position', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-search-form-wrap' ).css( 'background-position', to);
        } );
    });

    wp.customize( 'reviewx_live_search_padding_top', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-search-form-wrap' ).css( 'padding-top', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_live_search_padding_right', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-search-form-wrap' ).css( 'padding-right', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_live_search_padding_bottom', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-search-form-wrap' ).css( 'padding-bottom', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_live_search_padding_left', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-search-form-wrap' ).css( 'padding-left', to + 'px' );
        } );
    });
    
    wp.customize( 'reviewx_search_field_background_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-searchform' ).css( 'background-color', to );
        } );
    });
    
    wp.customize( 'reviewx_search_field_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-searchform .reviewx-search-field' ).css( 'font-size', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_search_field_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-searchform .reviewx-search-field' ).css( 'color', to );
        } );
    });

    wp.customize( 'reviewx_search_field_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-searchform .reviewx-search-field::placeholder' ).css( 'color', to );
        } );
    });

    wp.customize( 'reviewx_search_field_padding_top', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-searchform' ).css( 'padding-top', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_search_field_padding_right', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-searchform' ).css( 'padding-right', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_search_field_padding_bottom', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-searchform' ).css( 'padding-bottom', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_search_field_padding_left', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-searchform' ).css( 'padding-left', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_search_field_border_radius', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-searchform' ).css( 'border-radius', to + 'px' );
        } );
    });
    
    wp.customize( 'reviewx_search_icon_size', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-searchform svg.docs-search-icon' ).css( 'height', to + 'px' );
        } );
    });
    
    wp.customize( 'reviewx_search_icon_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-searchform svg.docs-search-icon' ).css( 'fill', to );
        } );
    });
    
    wp.customize( 'reviewx_search_close_icon_color', function( value ) {
        value.bind( function( to ) {
            $( '.docs-search-close .close-line' ).css( 'fill', to );
        } );
    });

    wp.customize( 'reviewx_search_close_icon_border_color', function( value ) {
        value.bind( function( to ) {
            $( '.docs-search-close .close-border' ).css( 'fill', to );
        } );
    });

    wp.customize( 'reviewx_search_close_icon_border_color', function( value ) {
        value.bind( function( to ) {
            $( '.docs-search-loader' ).css( 'stroke', to );
        } );
    });

    wp.customize( 'reviewx_search_result_width', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-live-search .docs-search-result' ).css( 'width', to + '%' );
        } );
    });

    wp.customize( 'reviewx_search_result_max_width', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-live-search .docs-search-result' ).css( 'max-width', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_search_result_background_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-live-search .docs-search-result' ).css( 'background-color', to );
        } );
    });

    wp.customize( 'reviewx_search_result_border_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-live-search .docs-search-result' ).css( 'border-color', to );
        } );
    });

    wp.customize( 'reviewx_search_result_item_font_size', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-live-search .docs-search-result li a,.reviewx-live-search .docs-search-result li:only-child' ).css( 'font-size', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_search_result_item_font_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-live-search .docs-search-result li a,.reviewx-live-search .docs-search-result li:only-child' ).css( 'color', to );
        } );
    });

    wp.customize( 'reviewx_search_result_item_padding_top', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-live-search .docs-search-result li a' ).css( 'padding-top', to + 'px' );
        } );
    });
    
    wp.customize( 'reviewx_search_result_item_padding_right', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-live-search .docs-search-result li a' ).css( 'padding-right', to + 'px' );
        } );
    });
    
    wp.customize( 'reviewx_search_result_item_padding_bottom', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-live-search .docs-search-result li a' ).css( 'padding-bottom', to + 'px' );
        } );
    });
    
    wp.customize( 'reviewx_search_result_item_padding_left', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-live-search .docs-search-result li a' ).css( 'padding-left', to + 'px' );
        } );
    });

    wp.customize( 'reviewx_search_result_item_border_color', function( value ) {
        value.bind( function( to ) {
            $( '.reviewx-live-search .docs-search-result li' ).css( 'border-color', to );
        } );
    });


} )( jQuery );
