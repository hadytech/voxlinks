(function ($) {
	'use strict';
	/**
	 * Run function when customizer is ready.
	 */
	function customizer_controls_show(setting,controler_name,controler_val){
		wp.customize.control( controler_name, function( control ) { 
			var controler_array = controler_val.split(',');
			var visibility = function() {
				if ( $.inArray(setting.get(), controler_array) > -1 ) {
					control.container.slideDown( 180 );
				} else {
					control.container.slideUp( 180 );
				}
			};           
			visibility();         
			setting.bind( visibility ); 
		});	
	}

	function customizer_controls_hide(setting,controler_name,controler_val){
		wp.customize.control( controler_name, function( control ) {
			var controler_array = controler_val.split(',');
			var visibility = function() {
				if ( $.inArray(setting.get(), controler_array) > -1 ) {
					control.container.slideUp( 180 );
				} else {
					control.container.slideDown( 180 );
				}
			};   
			visibility();   
			setting.bind( visibility ); 
		});	
	}

	function customizer_conditional_setting_return_toggle(setting,controler_name,controler_val){
		wp.customize.control( controler_name, function( control ) { 
			var visibility = function() {
				if ( setting.get() == true ) { 
					control.container.slideDown( 180 );     
				} else {
					control.container.slideUp( 180 );
				}
			};           
			visibility();         
			setting.bind( visibility ); 
		});	
	}

	

	$(document).ready(function () {
		wp.customize.bind( 'ready', function() {
			var dimensionReset  = jQuery('.reviewx-dimension .reviewx-customizer-reset');
			dimensionReset.each(function() {
				$(dimensionReset).on( 'click', function (e) {
					e.preventDefault();
					var dimensionId = $(this).parent('.reviewx-dimension').attr('id');
					$('.'+dimensionId).each(function() {
						var dimensionDefaultVal = $(this).data('default-val');
						$(this).val(dimensionDefaultVal).trigger('change');
					});
				});
			});
			var selectReset  = jQuery('.reviewx-select .reviewx-customizer-reset');
			selectReset.each(function() {
				$(selectReset).on( 'click', function (e) {
					e.preventDefault();
					var dimensionId = $(this).parent('.reviewx-select').attr('id');
					console.log(dimensionId);
					$('.'+dimensionId).each(function() {
						var dimensionDefaultVal = $(this).data('default-val');
						$(this).val(dimensionDefaultVal).trigger('change');
					});
				});
			});
			var numberReset = jQuery('.reviewx-customizer-reset.reviewx-number');
			numberReset.each(function() {
				$(numberReset).on( 'click', function (e) {
					e.preventDefault();
					var nextNumber = $(this).next('.reviewx-number');
					var nextNumberDefaultVal = $(this).next('.reviewx-number').data('default-val');
					$(nextNumber).val(nextNumberDefaultVal).trigger('change');
				});
			});
			wp.customize( 'reviewx_docs_layout_select', function( setting ) {                  
				customizer_controls_show(setting,'reviewx_doc_page_cat_icon_size_layout1','layout-1');
				customizer_controls_show(setting,'reviewx_doc_page_cat_icon_size_layout2','layout-2');
				customizer_controls_show(setting,'reviewx_doc_page_cat_title_border_color','layout-1');
				customizer_controls_show(setting,'reviewx_doc_page_cat_title_color','layout-1');
				customizer_controls_show(setting,'reviewx_doc_page_cat_title_color2', 'layout-2, layout-3, layout-4');
				customizer_controls_show(setting,'reviewx_doc_page_item_count_color','layout-1');
				customizer_controls_show(setting,'reviewx_doc_page_item_count_color_layout2','layout-2,layout-3,layout-4');
				customizer_controls_show(setting,'reviewx_doc_page_item_count_bg_color','layout-1');
				customizer_controls_show(setting,'reviewx_doc_page_item_counter_size','layout-1');
				customizer_controls_show(setting,'reviewx_doc_page_item_count_inner_bg_color','layout-1');
				customizer_controls_show(setting,'reviewx_doc_page_cat_desc','layout-2');
				customizer_controls_show(setting,'reviewx_doc_page_article_list_settings','layout-1,layout-4');
				customizer_controls_show(setting,'reviewx_doc_page_article_list_color','layout-1,layout-4');
				customizer_controls_show(setting,'reviewx_doc_page_article_list_hover_color','layout-1,layout-4');
				customizer_controls_show(setting,'reviewx_doc_page_article_list_bg_color','layout-1,layout-4');
				customizer_controls_show(setting,'reviewx_doc_page_article_list_font_size','layout-1,layout-4');
				customizer_controls_show(setting,'reviewx_doc_page_list_icon_color','layout-1');
				customizer_controls_show(setting,'reviewx_doc_page_list_icon_font_size','layout-1');
				customizer_controls_show(setting,'reviewx_doc_page_article_list_margin','layout-1,layout-4');
				customizer_controls_show(setting,'reviewx_doc_page_article_list_margin_top','layout-1,layout-4');
				customizer_controls_show(setting,'reviewx_doc_page_article_list_margin_right','layout-1,layout-4');
				customizer_controls_show(setting,'reviewx_doc_page_article_list_margin_bottom','layout-1,layout-4');
				customizer_controls_show(setting,'reviewx_doc_page_article_list_margin_left','layout-1,layout-4');
				customizer_controls_show(setting,'reviewx_doc_page_explore_btn','layout-1,layout-4');
				customizer_controls_show(setting,'reviewx_doc_page_explore_btn_bg_color','layout-1,layout-4');
				customizer_controls_show(setting,'reviewx_doc_page_explore_btn_color','layout-1,layout-4');
				customizer_controls_show(setting,'reviewx_doc_page_explore_btn_border_color','layout-1,layout-4');
				customizer_controls_show(setting,'reviewx_doc_page_explore_btn_font_size','layout-1,layout-4');
				customizer_controls_show(setting,'reviewx_doc_page_explore_btn_padding','layout-1,layout-4');
				customizer_controls_show(setting,'reviewx_doc_page_explore_btn_padding_top','layout-1,layout-4');
				customizer_controls_show(setting,'reviewx_doc_page_explore_btn_padding_right','layout-1,layout-4');
				customizer_controls_show(setting,'reviewx_doc_page_explore_btn_padding_bottom','layout-1,layout-4');
				customizer_controls_show(setting,'reviewx_doc_page_explore_btn_borderr','layout-1,layout-4');
				customizer_controls_show(setting,'reviewx_doc_page_explore_btn_borderr_topleft','layout-1,layout-4');
				customizer_controls_show(setting,'reviewx_doc_page_explore_btn_borderr_topright','layout-1,layout-4');
				customizer_controls_show(setting,'reviewx_doc_page_explore_btn_borderr_bottomright','layout-1,layout-4');
				customizer_controls_show(setting,'reviewx_doc_page_explore_btn_borderr_bottomleft','layout-1,layout-4');
				customizer_controls_show(setting,'reviewx_doc_page_explore_btn_padding_left','layout-1,layout-4');
				customizer_controls_show(setting,'reviewx_doc_page_explore_btn_hover_bg_color','layout-1,layout-4');
				customizer_controls_show(setting,'reviewx_doc_page_explore_btn_hover_color','layout-1,layout-4');
				customizer_controls_show(setting,'reviewx_doc_page_explore_btn_hover_border_color','layout-1,layout-4');

				customizer_controls_show(setting,'reviewx_doc_page_column_bg_color','layout-1,layout-4');
				customizer_controls_show(setting,'reviewx_doc_page_column_bg_color2','layout-2,layout-3');
				customizer_controls_hide(setting,'reviewx_doc_page_column_hover_bg_color','layout-1');

				customizer_controls_show(setting,'reviewx_doc_page_column_content_space','layout-2,layout-3,layout-4');
				customizer_controls_show(setting,'reviewx_doc_page_column_content_space_image','layout-2,layout-3,layout-4');
				customizer_controls_show(setting,'reviewx_doc_page_column_content_space_title','layout-2,layout-3,layout-4');
				customizer_controls_show(setting,'reviewx_doc_page_column_content_space_desc','layout-2,layout-3,layout-4');
				customizer_controls_show(setting,'reviewx_doc_page_column_content_space_counter','layout-2,layout-3,layout-4');
				
				customizer_controls_show(setting,'reviewx_doc_page_article_subcategory_color','layout-1');
				customizer_controls_show(setting,'reviewx_doc_page_article_subcategory_hover_color','layout-1');
				customizer_controls_show(setting,'reviewx_doc_page_article_subcategory_font_size','layout-1');
				customizer_controls_show(setting,'reviewx_doc_page_subcategory_icon_color','layout-1');
				customizer_controls_show(setting,'reviewx_doc_page_subcategory_icon_font_size','layout-1');
			});
			wp.customize( 'reviewx_single_layout_select', function( setting ) {
				customizer_controls_show(setting,'reviewx_sidebar_borderr','layout-1');
				customizer_controls_show(setting,'reviewx_sidebar_borderr_topleft','layout-1');
				customizer_controls_show(setting,'reviewx_sidebar_borderr_topright','layout-1');
				customizer_controls_show(setting,'reviewx_sidebar_borderr_bottomright','layout-1');
				customizer_controls_show(setting,'reviewx_sidebar_item_counter_title','layout-1');
				customizer_controls_show(setting,'reviewx_sidbebar_item_count_bg_color','layout-1');
				customizer_controls_show(setting,'reviewx_sidebar_item_counter_size','layout-1');
				customizer_controls_show(setting,'reviewx_sidebar_item_count_color','layout-1');
				customizer_controls_show(setting,'reviewx_sidebat_item_count_font_size','layout-1');
				customizer_controls_show(setting,'reviewx_sidebar_borderr_bottomleft','layout-1');
				customizer_controls_show(setting,'reviewx_doc_single_post_content_padding','layout-1');
				customizer_controls_show(setting,'reviewx_doc_single_post_content_padding_top','layout-1');
				customizer_controls_show(setting,'reviewx_doc_single_post_content_padding_right','layout-1');
				customizer_controls_show(setting,'reviewx_doc_single_post_content_padding_bottom','layout-1');
				customizer_controls_show(setting,'reviewx_doc_single_post_content_padding_left','layout-1');
				customizer_controls_show(setting,'reviewx_doc_single_2_post_content_padding','layout-2');
				customizer_controls_show(setting,'reviewx_doc_single_2_post_content_padding_top','layout-2');
				customizer_controls_show(setting,'reviewx_doc_single_2_post_content_padding_right','layout-2');
				customizer_controls_show(setting,'reviewx_doc_single_2_post_content_padding_bottom','layout-2');
				customizer_controls_show(setting,'reviewx_doc_single_2_post_content_padding_left','layout-2');
				customizer_controls_show(setting,'reviewx_doc_single_3_post_content_padding','layout-3');
				customizer_controls_show(setting,'reviewx_doc_single_3_post_content_padding_top','layout-3');
				customizer_controls_show(setting,'reviewx_doc_single_3_post_content_padding_right','layout-3');
				customizer_controls_show(setting,'reviewx_doc_single_3_post_content_padding_bottom','layout-3');
				customizer_controls_show(setting,'reviewx_doc_single_3_post_content_padding_left','layout-3');
			});
			wp.customize( 'reviewx_post_reactions', function( setting ) {
				customizer_conditional_setting_return_toggle(setting,'reviewx_post_reactions_text',true);
				customizer_conditional_setting_return_toggle(setting,'reviewx_post_reactions_text_color',true);
				customizer_conditional_setting_return_toggle(setting,'reviewx_post_reactions_icon_color',true);
			});
			wp.customize( 'reviewx_post_social_share', function( setting ) {
				customizer_conditional_setting_return_toggle(setting,'reviewx_social_sharing_text',true);
				customizer_conditional_setting_return_toggle(setting,'reviewx_post_social_share_text_color',true);
				customizer_conditional_setting_return_toggle(setting,'reviewx_post_social_share_facebook',true);
				customizer_conditional_setting_return_toggle(setting,'reviewx_post_social_share_twitter',true);
				customizer_conditional_setting_return_toggle(setting,'reviewx_post_social_share_linkedin',true);
				customizer_conditional_setting_return_toggle(setting,'reviewx_post_social_share_pinterest',true);
			});
			wp.customize( 'reviewx_doc_page_cat_desc', function( setting ) {
				customizer_conditional_setting_return_toggle(setting,'reviewx_doc_page_cat_desc_color',true);
			});
			wp.customize( 'reviewx_live_search_heading_switch', function( setting ) {
				customizer_conditional_setting_return_toggle(setting,'reviewx_live_search_heading',true);
				customizer_conditional_setting_return_toggle(setting,'reviewx_live_search_heading_font_color',true);
				customizer_conditional_setting_return_toggle(setting,'reviewx_live_search_heading_font_size',true);
				customizer_conditional_setting_return_toggle(setting,'reviewx_live_search_subheading',true);
				customizer_conditional_setting_return_toggle(setting,'reviewx_live_search_subheading_font_size',true);
				customizer_conditional_setting_return_toggle(setting,'reviewx_live_search_subheading_font_color',true);
				customizer_conditional_setting_return_toggle(setting,'reviewx_search_heading_margin',true);
				customizer_conditional_setting_return_toggle(setting,'reviewx_search_heading_margin_top',true);
				customizer_conditional_setting_return_toggle(setting,'reviewx_search_heading_margin_right',true);
				customizer_conditional_setting_return_toggle(setting,'reviewx_search_heading_margin_bottom',true);
				customizer_conditional_setting_return_toggle(setting,'reviewx_search_heading_margin_left',true);
				customizer_conditional_setting_return_toggle(setting,'reviewx_search_subheading_margin',true);
				customizer_conditional_setting_return_toggle(setting,'reviewx_search_subheading_margin_top',true);
				customizer_conditional_setting_return_toggle(setting,'reviewx_search_subheading_margin_right',true);
				customizer_conditional_setting_return_toggle(setting,'reviewx_search_subheading_margin_bottom',true);
				customizer_conditional_setting_return_toggle(setting,'reviewx_search_subheading_margin_left',true);
			});
			
		});
	});
})(jQuery);