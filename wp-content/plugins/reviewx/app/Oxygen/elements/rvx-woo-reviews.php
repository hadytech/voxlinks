<?php

namespace Oxygen\WooElements;

if ( ! class_exists('WooCommerce') ) {
    return;
}

if ( ! class_exists('OxyWooCommerce') ) {
    return;
}

class RvxWooReviews extends \RvxOxyWooEl {

    function name() {
        return 'ReviewX Woo Reviews';
    }

    function woo_button_place() {
        return "single";
    }

    function icon() {
        return plugin_dir_url(__FILE__) . 'assets/'.basename(__FILE__, '.php').'.svg';
    }

    function wooTemplate($options) {
        
        global $product;
        $product = wc_get_product();
        setup_postdata( $product->get_id() );
        
        add_filter( 'rx_load_oxygen_style_controller', function( $data ) use ($options) {           
            return $options;
        });

		return call_user_func( 'comments_template', 'reviews' );       

    }

    function controls() {

        /************************************
        *  
        *   Select Template
        * 
        *************************************/ 

        $this->addStyleControls(
            array(
                array(
                    "name" => __('Review Section Title', 'reviewx'),
                    'slug' => 'rx_section_title',
                    "selector" => '',
                    "property" => 'text',
                ),
                array(
                    "name" => __('Review Section Title Color', 'reviewx'),                    
                    'slug' => 'rx_section_title_color',
                    "selector" => '.woocommerce-Reviews-title',
                    "property" => 'color',
                    "control_type" => 'colorpicker',
                ), 
                array( 
                    "name" => __('Review Section Titles Font Size', 'reviewx'),
                    'slug' => 'rx_section_title_font_size',
                    "selector" => ".woocommerce-Reviews-title",
                    "property" => 'font-size',
                    "control_type" => "measurebox",
                    "unit" => "px"
                )                                            
            )
        ); 

        $reviewx_template = $this->addControlSection("reviewx_template", __("Template", 'reviewx'), "assets/icon.png", $this);
        $template = $reviewx_template->addControl("buttons-list", "rx_template_type", __("Graph Style"), 'slug', 'rx_template_type' );
        $template->setValue( array(
            "classic"		=> "Classic",
            "box" 	        => "Box Style", 
            ) 
        );

        // $this->addStyleControls(
        //     array(
        //         array(
        //             "name"          => __('Select Template', 'reviewx'),
        //             "property"      => 'rx_template_type',
        //             "control_type"  => 'buttons-list',
        //             "value"         => array('classic','box'),                         
        //         ),
        //     )
        // );      

        /************************************
        *  
        *   Review Statistics
        * 
        *************************************/         

        $reviewx_statistics = $this->addControlSection("reviewx_statistics", __("Review Statistics", 'reviewx'), "assets/icon.png", $this);   

        $reviewx_statistics->typographySection(
            __("Average Count Typography",'reviewx'),
            '.rx-temp-rating .rx-temp-rating-number p',
            $this);
        
        $reviewx_statistics->typographySection(
            __("Highest Rating Point Typography", 'reviewx'),
            '.rx-temp-rating .rx-temp-rating-number span',
            $this);  
        
        $reviewx_statistics->addStyleControls(
            array(
                array(
                    "name" => __('Star Rating Color', 'reviewx'),
                    "selector" => '.rx_avg_star_color',
                    "property" => 'fill',
                    "control_type" => 'colorpicker',
                ),
            )
        );

        $reviewx_statistics->addStyleControls(
            array(
                array(
                    "name" => __('Star Rating Height', 'reviewx'),
                    "selector" => '.rx-temp-rating-star svg',
                    "property" => 'height',                    
                    "control_type" => 'slider-measurebox',
                ),
            )
        );         

        $reviewx_statistics->addStyleControls(
            array(
                array(
                    "name" => __('Star Rating Width', 'reviewx'),
                    "selector" => '.rx-temp-rating-star svg',
                    "property" => 'width',                    
                    "control_type" => 'slider-measurebox',
                ),
            )
        );

        $reviewx_statistics->typographySection(
            __("Average Text Typography",'reviewx'),
            '.rx-temp-total-rating-count p',
            $this);

        $reviewx_statistics->typographySection(
            __("Recommendation Count Typography",'reviewx'),
            '.rx_recommended_box .rx_recommended_box_heading',
            $this); 

        $reviewx_statistics->typographySection(
            __("Recommendation Text Typography",'reviewx'),
            '.rx_recommended_box .rx_recommended_box_content',
            $this);
                    
        $reviewx_statistics->borderSection(
            __("Separator"),
            ".rx_recommended_wrapper hr",
            $this
        );

        $reviewx_box_shadow = $reviewx_statistics->addControlSection("reviewx_box_shadow", __("Box Shadow", 'reviewx'), "assets/icon.png", $this);
		
		$reviewx_box_shadow->addPreset(
            "box-shadow",
            "reviewx_shadow",
            __("Original Thumbs Shadow", 'reviewx'),
            ".rx_recommended_wrapper"
        ); 
        
        /************************************
        *  
        *   Graph of Review Criteria
        * 
        *************************************/
        
        $reviewx_graph_criteria = $this->addControlSection("reviewx_graph_criteria", __("Graph of Review Criteria", 'reviewx'), "assets/icon.png", $this);
        $graph_criteria = $reviewx_graph_criteria->addControl("buttons-list", "rx_graph_type", __("Graph Style", 'reviewx'), 'slug', 'rx_graph_type' );
        if( $this->is_pro() ) {            
            $graph_criteria->setValue( array(
                "graph_style_default"		=> "Horizontal Style One",
                "graph_style_one" 	        => "Horizontal Style Two", 
                "graph_style_two_free" 		=> "Horizontal Style Three",
                "graph_style_three" 		=> "Vertical Style One", 
                )        
            );
        } else {            
            $graph_criteria->setValue( array(
                "graph_style_default"		=> "Horizontal Style One",
                "graph_style_one" 	        => "Horizontal Style Two", 
                "graph_style_two_free" 		=> "Horizontal Style Three" 
                ) 
            );
        }

        $reviewx_graph_criteria->addStyleControls(
            array(
                array(
                    "name" => __("Criteria Name Color", 'reviewx'),
                    "selector" => '.rx-graph-style-2 .progress-bar-t, .rx_style_two_free_progress_bar .progressbar-title, .vertical .vertical_bar_label',
                    "property" => 'color',
                    "control_type" => 'colorpicker'
                ),
            )
        );
        
        $reviewx_graph_criteria->typographySection(
            __("Criteria Name Typography",'reviewx'),
            '.rx-graph-style-2 .progress-bar-t, .rx_style_two_free_progress_bar .progressbar-title, .vertical .vertical_bar_label',
            $this);

        $reviewx_graph_criteria->addStyleControls(
            array(
                array(
                    "name" => __("Progress-bar Background Color", 'reviewx'),
                    "selector" => '.rx-horizontal .progress-fill,
					 .rx_style_one_progress .rx_style_one_progress-bar,
					 .rx_style_two_free_progress_bar .progress .progress-bar,
					 .vertical .progress-fill',
                    "property" => 'background-color',
                    "control_type" => 'colorpicker'
                ),
            )
        ); 
        
        $reviewx_graph_criteria->addStyleControls(
            array(
                array(
                    "name" => __("Progress-bar Text Color", 'reviewx'),
                    "selector" => '.rx-horizontal .progress-fill span,
					 .rx_style_one_progress.orange .rx_style_one_progress-icon, 
					 .rx_style_one_progress.orange .rx_style_one_progress-value,
					 .rx_style_two_free_progress_bar .progress .progress-bar span,
					 .vertical .progress-fill',
                    "property" => 'color',
                    "control_type" => 'colorpicker'
                ),
            )
        );
        
        $reviewx_graph_criteria->typographySection(
            __("Progress-bar Text Typography",'reviewx'),
            '.rx-horizontal .progress-fill span,
            .rx_style_one_progress.orange .rx_style_one_progress-icon, 
            .rx_style_one_progress.orange .rx_style_one_progress-value,
            .rx_style_two_free_progress_bar .progress .progress-bar span,
            .vertical .progress-fill',
            $this);

        $reviewx_graph_criteria->borderSection(
            __("Horizontal Style Two Border", 'reviewx'),
            '.rx_style_one_progress.orange .rx_style_one_progress-icon, .rx_style_one_progress.orange .rx_style_one_progress-value',
            $this
        ); 
        
        // $reviewx_graph_criteria->addStyleControls(
        //     array(
        //         array(
        //             "name" => __("Progress-bar Border Color"),
        //             "selector" => '.rx_style_one_progress.orange .rx_style_one_progress-icon, .rx_style_one_progress.orange .rx_style_one_progress-value',
        //             "property" => 'border-color',
        //             "control_type" => 'colorpicker',
        //             "condition" => 'rx_graph_type=graph_style_one',
        //         ),
        //     )
        // ); 
        
        $review_criteria_graph_box_shadow = $reviewx_graph_criteria->addControlSection("reviewx_graph_criteria_box_shadow", __("Box Shadow"), "assets/icon.png", $this);        
        $review_criteria_graph_box_shadow->addPreset(
            "box-shadow",
            "rx_graph_shadow",
            __("Graph Criteria Box Shadow", 'reviewx'),
            ".rx_rating_graph_wrapper"
        );

        /************************************
        *  
        *   Filtering Bar
        * 
        *************************************/        

        $reviewx_filter_bar = $this->addControlSection("reviewx_filter_bar", __("Filtering Bar", 'reviewx'), "assets/icon.png", $this); 
        $reviewx_filter_bar->addStyleControls(
            array(
                array(
                    "name" => __('Text Color', 'reviewx'),
                    "selector" => '.rx-filter-bar .rx_filter_header h4, .rx-filter-bar .rx-short-by h4',
                    "property" => 'color',
                    "control_type" => 'colorpicker',
                    "condition" => 'rx_template_type=classic',
                ),
            )
        ); 

        $reviewx_filter_bar->addStyleControls(
            array(
                array(
                    "name" => __('Text Color', 'reviewx'),
                    "selector" => '.rx-filter-bar-style-2 .rx_filter_header h4, .rx-filter-bar-style-2 .rx-short-by h4',
                    "property" => 'color',
                    "control_type" => 'colorpicker',
                    "condition" => 'rx_template_type=box',
                ),
            )
        ); 

        $reviewx_filter_bar->typographySection(
            __("Text Typography",'reviewx'),
            '.rx-filter-bar .rx_filter_header h4, .rx-filter-bar .rx-short-by h4, 
            .rx-filter-bar-style-2 .rx_filter_header h4, .rx-filter-bar-style-2 .rx-short-by h4',
            $this);

        $reviewx_filter_bar->addStyleControls(
            array(
                array(
                    "name" => __('Dropdown Background Color', 'reviewx'),
                    "selector" => '.rx-filter-bar .rx_review_shorting_2 .box select',
                    "property" => 'background-color',
                    "control_type" => 'colorpicker',
                    "condition" => 'rx_template_type=classic',
                ),
            )
        ); 

        $reviewx_filter_bar->addStyleControls(
            array(
                array(
                    "name" => __('Dropdown Background Color', 'reviewx'),
                    "selector" => '.rx-filter-bar-style-2 .rx_review_shorting_2 .box select',
                    "property" => 'background-color',
                    "control_type" => 'colorpicker',
                    "condition" => 'rx_template_type=box',
                ),
            )
        );
        
        $reviewx_filter_bar->addStyleControls(
            array(
                array(
                    "name" => __('Dropdown Text Color', 'reviewx'),
                    "selector" => '.rx-filter-bar .rx_review_shorting_2 .box select',
                    "property" => 'color',
                    "control_type" => 'colorpicker',
                    "condition" => 'rx_template_type=classic',
                ),
            )
        ); 

        $reviewx_filter_bar->addStyleControls(
            array(
                array(
                    "name" => __('Dropdown Text Color', 'reviewx'),
                    "selector" => '.rx-filter-bar-style-2 .rx_review_shorting_2 .box select',
                    "property" => 'color',
                    "control_type" => 'colorpicker',
                    "condition" => 'rx_template_type=box',
                ),
            )
        );  
        
        $reviewx_filter_bar->addStyleControls(
            array(
                array(
                    "name" => __('Dropdown Bar Color', 'reviewx'),
                    "selector" => '.rx-filter-bar .rx_review_shorting_2 .box .rx-selection-arrow',
                    "property" => 'background-color',
                    "control_type" => 'colorpicker',
                    "condition" => 'rx_template_type=classic',
                ),
            )
        ); 

        $reviewx_filter_bar->addStyleControls(
            array(
                array(
                    "name" => __('Dropdown Bar Color', 'reviewx'),
                    "selector" => '.rx-filter-bar-style-2 .rx_review_shorting_2 .box .rx-selection-arrow',
                    "property" => 'background-color',
                    "control_type" => 'colorpicker',
                    "condition" => 'rx_template_type=box',
                ),
            )
        );  
        
        $reviewx_filter_bar->addStyleControls(
            array(
                array(
                    "name" => __('Filter Background Color', 'reviewx'),
                    "selector" => '.rx-filter-bar',
                    "property" => 'background-color',
                    "control_type" => 'colorpicker',
                    "condition" => 'rx_template_type=classic',
                ),
            )
        ); 

        $reviewx_filter_bar->addStyleControls(
            array(
                array(
                    "name" => __('Filter Background Color', 'reviewx'),
                    "selector" => '.rx-filter-bar-style-2',
                    "property" => 'background-color',
                    "control_type" => 'colorpicker',
                    "condition" => 'rx_template_type=box',
                ),
            )
        );
        
        $reviewx_filter_box = $reviewx_filter_bar->addControlSection("reviewx_filter_bar_shadow", __("Box Shadow", 'reviewx'), "assets/icon.png", $this); 
        $reviewx_filter_box->addPreset(
            "box-shadow",
            "rx_filter_bar_shadow",
            __("Box Shadow", 'reviewx'),
            ".rx-filter-bar, .rx-filter-bar-style-2"
        );

        /************************************
        *  
        *   Review Item
        * 
        *************************************/ 
        
        $reviewx_item = $this->addControlSection("reviewx_item", __("Review Item", 'reviewx'), "assets/icon.png", $this); 

        $reviewx_item->typographySection(
            __("Reviewer Name Typography",'reviewx'),
            '.rx_listing .rx_review_block .rx_author_info .rx_author_name h4, .rx_listing_style_2 .rx_review_block .rx_author_info .rx_author_name h4',
            $this);              

        $reviewx_avatar = $reviewx_item->addControlSection("reviewx_avatar", __("Avatar Box Shadow", 'reviewx'), "assets/icon.png", $this); 
        
        $reviewx_avatar->addPreset(
            "box-shadow",
            "rx_avatar_shadow",
            __("Avatar Box Shadow", 'reviewx'),
            ".rx_listing .rx_review_block .rx_thumb, .rx_listing_style_2 .rx_review_block .rx_thumb"
        );

        $reviewx_item->borderSection(
            __("Avatar Border", 'reviewx'),
            ".rx_listing .rx_review_block .rx_thumb, .rx_listing_style_2 .rx_review_block .rx_thumb",
            $this
        );

        $reviewx_item->addStyleControls(
            array(
                array(
                    "name" => __('Star Rating Color', 'reviewx'),
                    "selector" => '.rx_review_sort_list .rx_listing_container .rx_listing .rx_avg_star_color',
                    "property" => 'fill',
                    "control_type" => 'colorpicker',
                    "condition" => 'rx_template_type=classic',
                ),
            )
        ); 

        $reviewx_item->addStyleControls(
            array(
                array(
                    "name" => __('Star Rating Color', 'reviewx'),
                    "selector" => '.rx_review_sort_list .rx_listing_container_style_2 .rx_listing_style_2 .rx_avg_star_color',
                    "property" => 'fill',
                    "control_type" => 'colorpicker',
                    "condition" => 'rx_template_type=box',
                ),
            )
        ); 

        $reviewx_item->addStyleControls(
            array(
                array(
                    "name" => __('Star Rating Height', 'reviewx'),
                    "selector" => '.rx_listing .rx_review_block .rx_body .review_rating svg',
                    "property" => 'height',                    
                    "control_type" => 'slider-measurebox',
                    "condition" => 'rx_template_type=classic',
                ),
            )
        );         

        $reviewx_item->addStyleControls(
            array(
                array(
                    "name" => __('Star Rating Width', 'reviewx'),
                    "selector" => '.rx_listing .rx_review_block .rx_body .review_rating svg',
                    "property" => 'width',                    
                    "control_type" => 'slider-measurebox',
                    "condition" => 'rx_template_type=classic',
                ),
            )
        );  
        
        $reviewx_item->addStyleControls(
            array(
                array(
                    "name" => __('Star Rating Height', 'reviewx'),
                    "selector" => '.rx_listing_style_2 .rx_review_block .rx_body .review_rating svg',
                    "property" => 'height',                    
                    "control_type" => 'slider-measurebox',
                    "condition" => 'rx_template_type=box',
                ),
            )
        );         

        $reviewx_item->addStyleControls(
            array(
                array(
                    "name" => __('Star Rating Width', 'reviewx'),
                    "selector" => '.rx_listing_style_2 .rx_review_block .rx_body .review_rating svg',
                    "property" => 'width',                    
                    "control_type" => 'slider-measurebox',
                    "condition" => 'rx_template_type=box',
                ),
            )
        );

        $reviewx_item->typographySection(
            __("Review Title Typography",'reviewx'),
            '.rx_listing .rx_review_block .review_title, .rx_listing_style_2 .rx_review_block .review_title',
            $this);
        
        $reviewx_item->typographySection(
            __("Review Text Typography",'reviewx'),
            '.rx_listing .rx_review_block .rx_body p, .rx_listing_style_2 .rx_review_block .rx_body p',
            $this);  
            
        $reviewx_item->addStyleControls(
            array(
                array(
                    "name" => __('Review Background Color', 'reviewx'),
                    "selector" => '.rx_listing_style_2 .rx_review_block',
                    "property" => 'background-color',
                    "control_type" => 'colorpicker',
                    "condition" => 'rx_template_type=box',
                ),
            )
        );    
        
        $reviewx_item->addStyleControls(
            array(
                array(
                    "name" => __('Reply Background Color', 'reviewx'),
                    "selector" => '.rx_listing_style_2.rx_listing_filter_style_2 .children, .rx_listing_style_2 .children .rx_review_block',
                    "property" => 'background-color',
                    "control_type" => 'colorpicker',
                    "condition" => 'rx_template_type=box',
                ),
            )
        );

        $reviewx_item->addStyleControls(
            array(
                array(
                    "name" => __('Review Date Icon Color', 'reviewx'),
                    "selector" => '.rx_listing .rx_review_block .rx_body .rx_review_calender svg .st0',
                    "property" => 'fill',
                    "control_type" => 'colorpicker',
                    "condition" => 'rx_template_type=classic',
                ),
            )
        );  

        $reviewx_item->addStyleControls(
            array(
                array(
                    "name" => __('Review Date Icon Color', 'reviewx'),
                    "selector" => '.rx_listing_style_2 .rx_review_block .rx_body .rx_review_calender svg .st0',
                    "property" => 'fill',
                    "control_type" => 'colorpicker',
                    "condition" => 'rx_template_type=box',
                ),
            )
        );           
        
        $reviewx_item->typographySection(
            __("Review Date Typography",'reviewx'),
            '.rx_listing .rx_review_block .rx_body .rx_review_calender, .rx_listing_style_2 .rx_review_block .rx_body .rx_review_calender',
            $this);
            
        $reviewx_item->addStyleControls(
            array(
                array(
                    "name" => __('Verified Badge Icon Color', 'reviewx'),
                    "selector" => '.rx_listing .rx_review_block .rx_body .rx_varified .rx_varified_user svg .st0',
                    "property" => 'fill',
                    "control_type" => 'colorpicker',
                    "condition" => 'rx_template_type=classic',
                ),
            )
        );           
            
        $reviewx_item->addStyleControls(
            array(
                array(
                    "name" => __('Verified Badge Icon Color', 'reviewx'),
                    "selector" => '.rx_listing_style_2 .rx_review_block .rx_body .rx_varified .rx_varified_user svg .st0',
                    "property" => 'fill',
                    "control_type" => 'colorpicker',
                    "condition" => 'rx_template_type=box',
                ),
            )
        );          
        
        $reviewx_item->typographySection(
            __("Verified Badge Text Typography",'reviewx'),
            '.rx_listing .rx_review_block .rx_body .rx_varified .rx_varified_user span, .rx_listing_style_2 .rx_review_block .rx_body .rx_varified .rx_varified_user',
            $this); 
            
        $reviewx_attachment_align = $reviewx_item->addControl("buttons-list", "rx_attachment_align", __("Attachment Align", 'reviewx') );
    
        $reviewx_attachment_align->setValue( array(
            "left"		=> "Left", 
            "right" 	=> "Right" ) 
        );
        
		$reviewx_attachment_align->setValueCSS( array(
                "left" => "
                    .rx_listing .rx_review_block .rx_body .rx_photos,
                    .rx_listing_style_2 .rx_review_block .rx_body .rx_photos {
                    justify-content: flex-start;
                }
                ",

                "right" => "
                    .rx_listing .rx_review_block .rx_body .rx_photos,
                    .rx_listing_style_2 .rx_review_block .rx_body .rx_photos {
                    justify-content: flex-end;
                }
                "
            )
        ); 
        
        if( $this->is_pro() ) {

            $reviewx_item->addStyleControls(
                array(
                    array(
                        "name" => __('Helpful Button Background Color', 'reviewx'),
                        "selector" => '.rx_listing .rx_review_vote_icon .like',
                        "property" => 'background',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=classic',
                    ),
                )
            ); 
            
            $reviewx_item->addStyleControls(
                array(
                    array(
                        "name" => __('Helpful Thumbs-up Icon Color', 'reviewx'),
                        "selector" => '.rx_listing .rx_helpful_style_1_svg svg',
                        "property" => 'fill',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=classic',
                    ),
                )
            );             
                                   
            $reviewx_item->addStyleControls(
                array(
                    array(
                        "name" => __('Helpful Button Background Color', 'reviewx'),
                        "selector" => '.rx_listing_style_2 .rx_review_vote_icon .like',
                        "property" => 'background-color',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=box',
                    ),
                )
            ); 
            
            $reviewx_item->addStyleControls(
                array(
                    array(
                        "name" => __('Helpful Thumbs-up Icon Color', 'reviewx'),
                        "selector" => '.rx_listing_style_2 .rx_helpful_style_2_svg svg',
                        "property" => 'fill',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=box',
                    ),
                )
            ); 

            $reviewx_item->addStyleControls(
                array(
                    array(
                        "name" => __('Helpful Count Color', 'reviewx'),
                        "selector" => '.rx_listing .rx_review_vote_icon .like .rx_helpful_count_val',
                        "property" => 'color',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=classic',
                    ),
                )
            ); 
            
            $reviewx_item->addStyleControls(
                array(
                    array(
                        "name" => __('Helpful Count Color', 'reviewx'),
                        "selector" => '.rx_listing_style_2 .rx_review_vote_icon .like .rx_helpful_count_val',
                        "property" => 'color',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=box',
                    ),
                )
            );             
            
            $reviewx_item->typographySection(
                __("Helpful Text Typography",'reviewx'),
                '.rx_listing .rx_review_block .rx_body .rx_meta .rx_review_vote_icon p, .rx_listing_style_2 .rx_review_block .rx_body .rx_meta .rx_review_vote_icon p',
                $this); 
            
            $reviewx_item->addStyleControls(
                array(
                    array(
                        "name" => __('Share Icon Color', 'reviewx'),
                        "selector" => '.rx_listing .social-links .wc_rx_btns ul li:nth-child(1) svg',
                        "property" => 'fill',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=classic',
                    ),
                )
            );                  
                
            $reviewx_item->addStyleControls(
                array(
                    array(
                        "name" => __('Share Icon Color', 'reviewx'),
                        "selector" => '.rx_listing_style_2 .social-links .wc_rx_btns ul li:nth-child(1) svg',
                        "property" => 'fill',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=box',
                    ),
                )
            );             
            
            $reviewx_item->typographySection(
                __("Share Text Typography",'reviewx'),
                '.rx_listing .rx_review_block .rx_body .rx_meta .rx_share p, .rx_listing_style_2 .rx_review_block .rx_body .rx_meta .rx_share p',
                $this); 

            $reviewx_item->addStyleControls(
                array(
                    array(
                        "name" => __('Facebook Color', 'reviewx'),
                        "selector" => '.rx_listing .social-links .wc_rx_btns ul li:nth-child(2) a svg .st0',
                        "property" => 'fill',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=classic',
                    ),
                )
            );                      
                
            $reviewx_item->addStyleControls(
                array(
                    array(
                        "name" => __('Facebook Color', 'reviewx'),
                        "selector" => '.rx_listing_style_2 .social-links .wc_rx_btns ul li:nth-child(2) a svg .st0',
                        "property" => 'fill',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=box',
                    ),
                )
            );
            
            $reviewx_item->addStyleControls(
                array(
                    array(
                        "name" => __('Twitter Color', 'reviewx'),
                        "selector" => '.rx_listing .social-links .wc_rx_btns ul li:nth-child(3) a svg .st0',
                        "property" => 'fill',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=classic',
                    ),
                )
            );                      
                
            $reviewx_item->addStyleControls(
                array(
                    array(
                        "name" => __('Twitter Color', 'reviewx'),
                        "selector" => '.rx_listing_style_2 .social-links .wc_rx_btns ul li:nth-child(3) a svg .st0',
                        "property" => 'fill',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=box',
                    ),
                )
            ); 
            
            $reviewx_item->addStyleControls(
                array(
                    array(
                        "name" => __('Highlight Icon Color', 'reviewx'),
                        "selector" => '.rx_admin_heighlights span svg',
                        "property" => 'color',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=classic',
                    ),
                )
            );            
            
            $reviewx_item->addStyleControls(
                array(
                    array(
                        "name" => __('Highlight Icon Color', 'reviewx'),
                        "selector" => '.rx_listing_style_2 .rx_admin_heighlights span svg',
                        "property" => 'fill',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=box',
                    ),
                )
            ); 
            
            $reviewx_item->addStyleControls(
                array(
                    array(
                        "name" => __('Review Highlight Background Color', 'reviewx'),
                        "selector" => '.rx_listing_style_2 .reviewx_highlight_comment',
                        "property" => 'background-color',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=box',
                    ),
                )
            );  
            
            $reviewx_item->addStyleControls(
                array(
                    array(
                        "name" => __('Reply Highlight Background Color', 'reviewx'),
                        "selector" => '.rx_listing_style_2.rx_listing_filter_style_2 .reviewx_highlight_comment .children, .rx_listing_style_2 .reviewx_highlight_comment .children .rx_review_block',
                        "property" => 'background-color',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=box',
                    ),
                )
            );             

        }

        $reviewx_item->addStyleControls(
            array(
                array(
                    "name" => __('Review Container Background Color', 'reviewx'),
                    "selector" => '.rx_listing_container_style_1',
                    "property" => 'background-color',
                    "control_type" => 'colorpicker',
                    "condition" => 'rx_template_type=classic',
                ),
            )
        );

        /************************************
        *  
        *  Store Reply
        * 
        *************************************/  
        if( $this->is_pro() ) {

            $reviewx_reply = $this->addControlSection("reviewx_reply", __("Store Reply", 'reviewx'), "assets/icon.png", $this); 
            $reviewx_reply->addStyleControls(
                array(
                    array(
                        "name" => __('Store Logo Color', 'reviewx'),
                        "selector" => '.rx_listing .rx_review_block .children .rx_thumb svg .st0',
                        "property" => 'fill',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=classic',
                    ),
                )
            );

            $reviewx_reply->addStyleControls(
                array(
                    array(
                        "name" => __('Store Logo Color', 'reviewx'),
                        "selector" => '.rx_listing_style_2 .rx_review_block .children .rx_thumb svg .st0',
                        "property" => 'fill',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=box',
                    ),
                )
            ); 

            $reviewx_reply->addStyleControls(
                array(
                    array(
                        "name" => __('Store Logo Background Color', 'reviewx'),
                        "selector" => '.rx_listing .rx_review_block .children .rx_thumb',
                        "property" => 'background-color',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=classic',
                    ),
                )
            );

            $reviewx_reply->addStyleControls(
                array(
                    array(
                        "name" => __('Store Logo Background Color', 'reviewx'),
                        "selector" => '.rx_listing_style_2 .rx_review_block .children .rx_thumb',
                        "property" => 'background-color',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=box',
                    ),
                )
            ); 
            
            // $reviewx_reply->addStyleControls(
            //     array(
            //         array(
            //             "name" => __('Store Name Color', 'reviewx'),
            //             "selector" => '.rx_listing .rx_review_block .children .review_title',
            //             "property" => 'color',
            //             "control_type" => 'colorpicker',
            //             "condition" => 'rx_template_type=classic',
            //         ),
            //     )
            // );

            // $reviewx_reply->addStyleControls(
            //     array(
            //         array(
            //             "name" => __('Store Name Color', 'reviewx'),
            //             "selector" => '.rx_listing_style_2 .rx_review_block .children .review_title',
            //             "property" => 'color',
            //             "control_type" => 'colorpicker',
            //             "condition" => 'rx_template_type=box',
            //         ),
            //     )
            // ); 
            
            $reviewx_reply->typographySection(
                __("Store Name Typography",'reviewx'),
                '.rx_listing .rx_review_block .children .review_title, .rx_listing_style_2 .rx_review_block .children .review_title',
                $this);
            
            $reviewx_reply->addStyleControls(
                array(
                    array(
                        "name" => __('Reply Back Icon Color', 'reviewx'),
                        "selector" => '.rx_listing .rx_review_block .children .owner_arrow svg .st0',
                        "property" => 'fill',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=classic',
                    ),
                )
            );  
            
            $reviewx_reply->addStyleControls(
                array(
                    array(
                        "name" => __('Reply Back Icon Color', 'reviewx'),
                        "selector" => '.rx_listing_style_2 .rx_review_block .children .owner_arrow svg .st0',
                        "property" => 'fill',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=box',
                    ),
                )
            ); 
            
            // $reviewx_reply->addStyleControls(
            //     array(
            //         array(
            //             "name" => __('Reply Back Text Color', 'reviewx'),
            //             "selector" => '.rx_listing .rx_review_block .children .comment-content p',
            //             "property" => 'color',
            //             "control_type" => 'colorpicker',
            //             "condition" => 'rx_template_type=classic',
            //         ),
            //     )
            // );  
            
            // $reviewx_reply->addStyleControls(
            //     array(
            //         array(
            //             "name" => __('Reply Back Text Color', 'reviewx'),
            //             "selector" => '.rx_listing_style_2 .rx_review_block .children .comment-content p',
            //             "property" => 'color',
            //             "control_type" => 'colorpicker',
            //             "condition" => 'rx_template_type=box',
            //         ),
            //     )
            // );
            
            $reviewx_reply->typographySection(
                __("Store Reply Text Typography",'reviewx'),
                '.rx_listing .rx_review_block .children .comment-content p, .rx_listing_style_2 .rx_review_block .children .comment-content p',
                $this); 
                
            $reviewx_reply->addStyleControls(
                array(
                    array(
                        "name" => __('Date Color', 'reviewx'),
                        "selector" => '.rx_listing .rx_review_block .children .rx_review_calender',
                        "property" => 'color',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=classic',
                    ),
                )
            );  
            
            $reviewx_reply->addStyleControls(
                array(
                    array(
                        "name" => __('Date Color', 'reviewx'),
                        "selector" => '.rx_listing_style_2 .rx_review_block .children .rx_review_calender',
                        "property" => 'color',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=box',
                    ),
                )
            ); 
            
            $reviewx_reply->typographySection(
                __("Date Typography",'reviewx'),
                '.rx_listing .rx_review_block .children .rx_review_calender, .rx_listing_style_2 .rx_review_block .children .rx_review_calender',
                $this);  
                
            // $reviewx_reply->addStyleControls(
            //     array(
            //         array(
            //             "name" => __('Date Icon Color', 'reviewx'),
            //             "selector" => '.rx_listing .rx_review_block .children .rx_body .rx_review_calender svg .st0',
            //             "property" => 'fill',
            //             "control_type" => 'colorpicker',
            //             "condition" => 'rx_template_type=classic',
            //         ),
            //     )
            // );  
            
            // $reviewx_reply->addStyleControls(
            //     array(
            //         array(
            //             "name" => __('Date Icon Color', 'reviewx'),
            //             "selector" => '.rx_listing_style_2 .rx_review_block .rx_body .rx_review_calender svg .st0',
            //             "property" => 'fill',
            //             "control_type" => 'colorpicker',
            //             "condition" => 'rx_template_type=box',
            //         ),
            //     )
            // );  
            
            $reviewx_reply->addStyleControls(
                array(
                    array(
                        "name" => __('Reply Edit Icon Color', 'reviewx'),
                        "selector" => '.admin-reply-edit-icon svg',
                        "property" => 'fill',
                        "control_type" => 'colorpicker',
                    ),
                )
            );  
            
            $reviewx_reply->addStyleControls(
                array(
                    array(
                        "name" => __('Reply Delete Icon Color', 'reviewx'),
                        "selector" => '.admin-reply-delete-icon svg',
                        "property" => 'fill',
                        "control_type" => 'colorpicker',
                    ),
                )
            );

            $reviewx_reply->addStyleControls(
                array(
                    array(
                        "name" => __('Reply Button Text Color', 'reviewx'),
                        "selector" => '.rx_listing .rx_review_block .rx_meta .rx-admin-reply',
                        "property" => 'color',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=classic',
                    ),
                )
            );              
            
            $reviewx_reply->addStyleControls(
                array(
                    array(
                        "name" => __('Reply Button Text Color', 'reviewx'),
                        "selector" => '.rx_listing_style_2 .rx_review_block .rx_body .rx_meta .rx-admin-reply',
                        "property" => 'color',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=box',
                    ),
                )
            ); 
            
            $reviewx_reply->typographySection(
                __("Date Typography",'reviewx'),
                '.rx_listing .rx_review_block .children .rx_review_calender, .rx_listing_style_2 .rx_review_block .children .rx_review_calender',
                $this); 

            $reviewx_reply->addStyleControls(
                array(
                    array(
                        "name" => __('Reply Button Background Color', 'reviewx'),
                        "selector" => '.rx_listing .rx_review_block .rx_meta .rx-admin-reply',
                        "property" => 'background-color',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=classic',
                    ),
                )
            );                     
                
            $reviewx_reply->addStyleControls(
                array(
                    array(
                        "name" => __('Reply Button Background Color', 'reviewx'),
                        "selector" => '.rx_listing_style_2 .rx_review_block .rx_body .rx_meta .rx-admin-reply',
                        "property" => 'background-color',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=box',
                    ),
                )
            );  
            
            $reviewx_reply->addStyleControls(
                array(
                    array(
                        "name" => __('Reply Button Border Color', 'reviewx'),
                        "selector" => '.rx_listing .rx_review_block .rx_meta .rx-admin-reply',
                        "property" => 'border-color',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=classic',
                    ),
                )
            );                     
                
            $reviewx_reply->addStyleControls(
                array(
                    array(
                        "name" => __('Reply Button Border Color', 'reviewx'),
                        "selector" => '.rx_listing_style_2 .rx_review_block .rx_body .rx_meta .rx-admin-reply',
                        "property" => 'border-color',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=box',
                    ),
                )
            );  
            
            $reviewx_reply->addStyleControls(
                array(
                    array(
                        "name" => __('Reply Background Color', 'reviewx'),
                        "selector" => '.rx_listing .children',
                        "property" => 'background-color',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=classic',
                    ),
                )
            );                     
                
            $reviewx_reply->addStyleControls(
                array(
                    array(
                        "name" => __('Reply Background Color', 'reviewx'),
                        "selector" => '.rx_listing_container_style_2 .rx-admin-edit-reply-area, .rx_listing_container_style_2 .rx_review_block .rx_body .rx-admin-reply-area',
                        "property" => 'background-color',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=box',
                    ),
                )
            );  
            
            $reviewx_reply->addStyleControls(
                array(
                    array(
                        "name" => __('Reply Border Color', 'reviewx'),
                        "selector" => '.rx-admin-edit-reply-area, .rx-admin-reply-area',
                        "property" => 'border-color',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=classic',
                    ),
                )
            );                     
                
            $reviewx_reply->addStyleControls(
                array(
                    array(
                        "name" => __('Reply Border Color', 'reviewx'),
                        "selector" => '.rx_listing_container_style_2 .rx-admin-edit-reply-area, .rx_listing_container_style_2 .rx_review_block .rx_body .rx-admin-reply-area',
                        "property" => 'border-color',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=box',
                    ),
                )
            );  
            
            $reviewx_reply->addStyleControls(
                array(
                    array(
                        "name" => __('Reply Title Color', 'reviewx'),
                        "selector" => '.rx_listing_style_1 .rx_review_block .rx_body .admin-reply-form-title, .rx_listing_style_1 .rx-admin-edit-reply-area .admin-reply-form-title',
                        "property" => 'border-color',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=classic',
                    ),
                )
            );                     
                
            $reviewx_reply->addStyleControls(
                array(
                    array(
                        "name" => __('Reply Title Color', 'reviewx'),
                        "selector" => '.rx_listing_container_style_2 .rx_review_block .rx_body .rx-admin-reply-area .admin-reply-form-title, .rx_listing_container_style_2 .rx-admin-edit-reply-area .admin-reply-form-title',
                        "property" => 'color',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=box',
                    ),
                )
            ); 
            
            $reviewx_reply->typographySection(
                __("Reply Title Typography",'reviewx'),
                '.rx_listing .rx_review_block .rx_body .admin-reply-form-title, .rx_listing_style_1 .rx-admin-edit-reply-area .admin-reply-form-title, .rx_listing_container_style_2 .rx_review_block .rx_body .rx-admin-reply-area .admin-reply-form-title, .rx_listing_container_style_2 .rx-admin-edit-reply-area .admin-reply-form-title',
                $this);  
                
            $reviewx_reply->addStyleControls(
                array(
                    array(
                        "name" => __('Reply Text Area Background Color', 'reviewx'),
                        "selector" => '.rx_listing .rx_review_block .rx_body .rx-admin-reply-area .comment-form-comment textarea, .rx-admin-edit-reply-area .comment-form-comment textarea',
                        "property" => 'background-color',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=classic',
                    ),
                )
            ); 

            $reviewx_reply->addStyleControls(
                array(
                    array(
                        "name" => __('Reply Text Area Background Color', 'reviewx'),
                        "selector" => '.rx_listing_container_style_2 .rx_review_block .rx_body .rx-admin-reply-area .comment-form-comment .rx-admin-reply-text, .rx_listing_container_style_2 .rx-admin-edit-reply-area .comment-form-comment .rx-admin-reply-text',
                        "property" => 'background-color',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=box',
                    ),
                )
            ); 
            
			/*========================
			*	Reply Submit Button
            *========================*/  
            
            $reviewx_reply->addStyleControls(
                array(
                    array(
                        "name" => __('Reply Submit Button BG Color', 'reviewx'),
                        "selector" => '.rx-admin-edit-reply-area .form-submit .admin-review-edit-reply, .rx-admin-reply-area .form-submit .admin-review-reply',
                        "property" => 'background-color',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=classic',
                    ),
                )
            ); 

            $reviewx_reply->addStyleControls(
                array(
                    array(
                        "name" => __('Reply Submit Button BG Color', 'reviewx'),
                        "selector" => '.rx_listing_container_style_2 .rx-admin-edit-reply-area .form-submit .admin-review-edit-reply, 
						.rx_listing_container_style_2 .rx_review_block .rx_body .rx-admin-reply-area .form-submit .admin-review-reply',
                        "property" => 'background-color',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=box',
                    ),
                )
            ); 
            
            $reviewx_reply->addStyleControls(
                array(
                    array(
                        "name" => __('Reply Submit Button Text Color', 'reviewx'),
                        "selector" => '.rx-admin-edit-reply-area .form-submit .admin-review-edit-reply, .rx-admin-reply-area .form-submit .admin-review-reply',
                        "property" => 'color',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=classic',
                    ),
                )
            ); 

            $reviewx_reply->addStyleControls(
                array(
                    array(
                        "name" => __('Reply Submit Button Text Color', 'reviewx'),
                        "selector" => '.rx_listing_container_style_2 .rx-admin-edit-reply-area .form-submit .admin-review-reply, 
						.rx_listing_container_style_2 .rx_review_block .rx_body .rx-admin-reply-area .form-submit .admin-review-reply',
                        "property" => 'color',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=box',
                    ),
                )
            ); 
            
            $reviewx_reply->typographySection(
                __("Reply Submit Button Typography",'reviewx'),
                '.rx-admin-edit-reply-area .form-submit, .rx-admin-reply-area .form-submit, .rx_listing_container_style_2 .rx-admin-edit-reply-area .form-submit .admin-review-reply, 
             .rx_listing_container_style_2 .rx_review_block .rx_body .rx-admin-reply-area .form-submit .admin-review-reply',
                $this);  

			/*========================
			*	Reply Cancel Button
            *=========================*/  
            
            $reviewx_reply->addStyleControls(
                array(
                    array(
                        "name" => __('Reply Cancel Button BG Color', 'reviewx'),
                        "selector" => '.rx-admin-edit-reply-area .form-submit .cancel-admin-edit-reply, .rx-admin-reply-area .form-submit .cancel-admin-reply',
                        "property" => 'background-color',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=classic',
                    ),
                )
            ); 

            $reviewx_reply->addStyleControls(
                array(
                    array(
                        "name" => __('Reply Cancel Button BG Color', 'reviewx'),
                        "selector" => '.rx_listing_container_style_2 .rx-admin-edit-reply-area .form-submit .cancel-admin-edit-reply, .rx_review_block .rx_body .rx-admin-reply-area .form-submit .cancel-admin-reply',
                        "property" => 'background-color',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=box',
                    ),
                )
            ); 
            
            $reviewx_reply->addStyleControls(
                array(
                    array(
                        "name" => __('Reply Cancel Button Text Color', 'reviewx'),
                        "selector" => '.rx-admin-edit-reply-area .form-submit .cancel-admin-edit-reply, .rx-admin-reply-area .form-submit .cancel-admin-reply',
                        "property" => 'color',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=classic',
                    ),
                )
            ); 

            $reviewx_reply->addStyleControls(
                array(
                    array(
                        "name" => __('Reply Cancel Button Text Color', 'reviewx'),
                        "selector" => '.rx_listing_container_style_2 .rx-admin-edit-reply-area .form-submit .cancel-admin-edit-reply, .rx_review_block .rx_body .rx-admin-reply-area .form-submit .cancel-admin-reply',
                        "property" => 'color',
                        "control_type" => 'colorpicker',
                        "condition" => 'rx_template_type=box',
                    ),
                )
            );
            
            $reviewx_reply->typographySection(
                __("Reply Cancel Button Typography",'reviewx'),
                // '.rx-admin-edit-reply-area .form-submit .cancel-admin-reply, .rx-admin-reply-area .form-submit .cancel-admin-reply, .rx_listing_container_style_2 .rx-admin-edit-reply-area .form-submit .cancel-admin-reply, .rx_listing_container_style_2 .rx_review_block .rx_body .rx-admin-reply-area .form-submit .cancel-admin-reply',
                '.cancel-admin-edit-reply, .cancel-admin-reply',
                $this);  

        }

        /************************************
        *  
        *   Pagination
        * 
        *************************************/     
        
        $reviewx_pagination = $this->addControlSection("reviewx_pagination", __("Pagination", 'reviewx'), "assets/icon.png", $this);  
        
        $reviewx_pagination->addStyleControls(
            array(
                array(
                    "name" => __('Text Color', 'reviewx'),
                    "selector" => '.rx_listing_style_1 .rx_pagination a',
                    "property" => 'color',
                    "control_type" => 'colorpicker',
                    "condition" => 'rx_template_type=classic',
                ),
            )
        ); 

        $reviewx_pagination->addStyleControls(
            array(
                array(
                    "name" => __('Text Color', 'reviewx'),
                    "selector" => '.rx_listing_container_style_2 .rx_pagination a',
                    "property" => 'color',
                    "control_type" => 'colorpicker',
                    "condition" => 'rx_template_type=box',
                ),
            )
        ); 
        
        $reviewx_pagination->typographySection(
            __("Reply Cancel Button Typography",'reviewx'),
            '.rx_listing_style_1 .rx_pagination a, .rx_listing_container_style_2 .rx_pagination a',
            $this); 
            
        $reviewx_pagination->addStyleControls(
            array(
                array(
                    "name" => __('Background Color', 'reviewx'),
                    "selector" => '.rx_listing_style_1 .rx_pagination a',
                    "property" => 'background-color',
                    "control_type" => 'colorpicker',
                    "condition" => 'rx_template_type=classic',
                ),
            )
        ); 

        $reviewx_pagination->addStyleControls(
            array(
                array(
                    "name" => __('Background Color', 'reviewx'),
                    "selector" => '.rx_listing_container_style_2 .rx_pagination a',
                    "property" => 'background-color',
                    "control_type" => 'colorpicker',
                    "condition" => 'rx_template_type=box',
                ),
            )
        );  
        
        $reviewx_pagination->addStyleControls(
            array(
                array(
                    "name" => __('Active Text Color', 'reviewx'),
                    "selector" => '.rx_listing_style_1 .rx_pagination a.current',
                    "property" => 'color',
                    "control_type" => 'colorpicker',
                    "condition" => 'rx_template_type=classic',
                ),
            )
        ); 

        $reviewx_pagination->addStyleControls(
            array(
                array(
                    "name" => __('Active Text Color', 'reviewx'),
                    "selector" => '.rx_listing_container_style_2 .rx_pagination a.current',
                    "property" => 'color',
                    "control_type" => 'colorpicker',
                    "condition" => 'rx_template_type=box',
                ),
            )
        ); 

        $reviewx_pagination->addStyleControls(
            array(
                array(
                    "name" => __('Active Background Color', 'reviewx'),
                    "selector" => '.rx_listing_style_1 .rx_pagination .rx-page.active a',
                    "property" => 'background-color',
                    "control_type" => 'colorpicker',
                    "condition" => 'rx_template_type=classic',
                ),
            )
        ); 

        $reviewx_pagination->addStyleControls(
            array(
                array(
                    "name" => __('Active Background Color', 'reviewx'),
                    "selector" => '.rx_listing_container_style_2 .rx_pagination .rx-page.active a',
                    "property" => 'background-color',
                    "control_type" => 'colorpicker',
                    "condition" => 'rx_template_type=box',
                ),
            )
        );        
        
        $reviewx_pagination->addStyleControls(
            array(
                array(
                    "name" => __('Hover Text Color', 'reviewx'),
                    "selector" => '.rx_listing_style_1 .rx_pagination a:hover',
                    "property" => 'color',
                    "control_type" => 'colorpicker',
                    "condition" => 'rx_template_type=classic',
                ),
            )
        ); 

        $reviewx_pagination->addStyleControls(
            array(
                array(
                    "name" => __('Hover Text Color', 'reviewx'),
                    "selector" => '.rx_listing_container_style_2 .rx_pagination a:hover',
                    "property" => 'color',
                    "control_type" => 'colorpicker',
                    "condition" => 'rx_template_type=box',
                ),
            )
        );  
        
        /************************************
        *  
        *   Review Form
        * 
        *************************************/  
        
        $reviewx_form = $this->addControlSection("reviewx_form", __("Review Form", 'reviewx'), "assets/icon.png", $this);
        $rating = $reviewx_form->addControl("buttons-list", "rx_rating_style", __("Rating Style", 'reviewx'), 'slug', 'rx_rating_style' );
        if( $this->is_pro() ) {
            $rating->setValue( array(
                "rating_style_one"		=> "Star Rating",
                "rating_style_two" 	    => "Thumbs Rating", 
                "rating_style_three" 	=> "Faces Rating"            
                ) 
            ); 
        } else {
            $rating->setValue( array(
                "rating_style_one"		=> "Star Rating"          
                ) 
            );
        } 
        
        // $reviewx_form->addStyleControls(
        //     array(
        //         array(
        //             "name" => __('Criteria Text Color', 'reviewx'),
        //             "selector" => '.rx-review-form-area-style-1 .rx-criteria-table td, .rx-review-form-area-style-2 .rx-criteria-table td',
        //             "property" => 'color',
        //             "control_type" => 'colorpicker',
        //         ),
        //     )
        // );
        
        $reviewx_form->typographySection(
            __("Criteria Text Typography",'reviewx'),
            '.rx-review-form-area-style-1 .rx-criteria-table td, .rx-review-form-area-style-2 .rx-criteria-table td',
            $this); 
            
        $reviewx_form->addStyleControls(
            array(
                array(
                    "name" => __('Rating Icon Fill Color', 'reviewx'),
                    "selector" => '.rx-review-form-area-style-1 .rx_star_rating > input:checked ~ label .icon-star, .rx-review-form-area-style-1 .reviewx-thumbs-rating input[type="radio"]:checked + label svg, .rx-review-form-area-style-1 .reviewx-thumbs-rating input[type="radio"]:checked + label svg #rx_dislike path,
					.rx-review-form-area-style-1 .reviewx-face-rating fieldset input[type="radio"]:checked + label .happy_st0, .rx-review-form-area-style-1 .reviewx-face-rating fieldset input[type="radio"]:checked + label .st1',
                    "property" => 'fill',
                    "control_type" => 'colorpicker',
                    "condition" => 'rx_template_type=classic',
                ),
                array(
                    "name" => __('Rating Icon Stroke Color', 'reviewx'),
                    "selector" => '.rx-review-form-area-style-1 .rx_star_rating .icon-star,
					.rx-review-form-area-style-1 .rx_star_rating:not(:checked) > label:hover .icon-star, .rx_star_rating:not(:checked) > label:hover ~ label .icon-star',
                    "property" => 'stroke',
                    "control_type" => 'colorpicker',
                    "condition" => 'rx_template_type=classic',
                ),
                array(
                    "name" => __('Recommendation Icon Active Color', 'reviewx'),
                    "selector" => '.rx-review-form-area-style-1 .reviewx_recommended_list .reviewx_radio input[type="radio"]:checked + .radio-label svg .rx_happy, .rx-review-form-area-style-1 .reviewx_recommended_list .reviewx_radio input[type="radio"]:checked + .radio-label svg .st1',
                    "property" => 'fill',
                    "control_type" => 'colorpicker',
                    "condition" => 'rx_template_type=classic',
                ),
                array(
                    "name" => __('External Example Video Link Color', 'reviewx'),
                    "selector" => '.rx-review-form-area-style-1 #review_form .rx-note-video',
                    "property" => 'color',
                    "condition" => 'rx_template_type=classic',
                ), 
                array(
                    "name" => __('Submit Button Text Color', 'reviewx'),
                    "selector" => '.rx-review-form-area-style-1 #review_form input[type="submit"], .rx-review-form-area-style-1 #review_form input[type="submit"]:focus',
                    "property" => 'color',
                    "condition" => 'rx_template_type=classic',
                ), 
                array(
                    "name" => __('Submit Button Background Color', 'reviewx'),
                    "selector" => '.rx-review-form-area-style-1 #review_form input[type="submit"], 
					.rx-review-form-area-style-1 #review_form input[type="submit"]:focus',
                    "property" => 'background-color',
                    "condition" => 'rx_template_type=classic',
                ),  
                array(
                    "name" => __('Submit Button Border Radius', 'reviewx'),
                    "selector" => '.rx-review-form-area-style-1 #respond input#submit',
                    "property" => 'border-radius',
                    "condition" => 'rx_template_type=classic',
                ),                                                                                 
            )
        );

        $reviewx_form->addStyleControls(
            array(
                array(
                    "name" => __('Rating Icon Fill Color', 'reviewx'),
                    "selector" => '.rx-review-form-area-style-2 .rx_star_rating > input:checked ~ label .icon-star,.rx-review-form-area-style-2 .reviewx-thumbs-rating input[type="radio"]:checked + label svg, .rx-review-form-area-style-2 .reviewx-thumbs-rating input[type="radio"]:checked + label svg #rx_dislike path,
					.rx-review-form-area-style-2 .reviewx-face-rating fieldset input[type="radio"]:checked + label .happy_st0, .rx-review-form-area-style-2 .reviewx-face-rating fieldset input[type="radio"]:checked + label .st1',
                    "property" => 'fill',
                    "control_type" => 'colorpicker',
                    "condition" => 'rx_template_type=box',
                ),
                array(
                    "name" => __('Rating Icon Stroke Color', 'reviewx'),
                    "selector" => '.rx-review-form-area-style-2 .rx_star_rating .icon-star,
					.rx-review-form-area-style-2 .rx_star_rating:not(:checked) > label:hover .icon-star, .rx_star_rating:not(:checked) > label:hover ~ label .icon-star',
                    "property" => 'stroke',
                    "control_type" => 'colorpicker',
                    "condition" => 'rx_template_type=box',
                ),
                array(
                    "name" => __('Recommendation Icon Active Color', 'reviewx'),
                    "selector" => '.rx-review-form-area-style-2 .reviewx_recommended_list .reviewx_radio input[type="radio"]:checked + .radio-label svg .rx_happy, .rx-review-form-area-style-2 .reviewx_recommended_list .reviewx_radio input[type="radio"]:checked + .radio-label svg .st1',
                    "property" => 'fill',
                    "condition" => 'rx_template_type=box',
                ),
                array(
                    "name" => __('External Example Video Link Color', 'reviewx'),
                    "selector" => '.rx-review-form-area-style-2 #review_form .rx-note-video',
                    "property" => 'color',
                    "condition" => 'rx_template_type=box',
                ), 
                array(
                    "name" => __('Submit Button Text Color', 'reviewx'),
                    "selector" => '.rx-review-form-area-style-2 #review_form input[type="submit"], 
					.rx-review-form-area-style-2 #review_form input[type="submit"]:focus',
                    "property" => 'color',
                    "condition" => 'rx_template_type=box',
                ), 
                array(
                    "name" => __('Submit Button Background Color', 'reviewx'),
                    "selector" => '.rx-review-form-area-style-2 #review_form input[type="submit"], 
					.rx-review-form-area-style-2 #review_form input[type="submit"]:focus',
                    "property" => 'background-color',
                    "condition" => 'rx_template_type=box',
                ),  
                array(
                    "name" => __('Submit Button Border Radius', 'reviewx'),
                    "selector" => '.rx-review-form-area-style-2 #respond input#submit',
                    "property" => 'border-radius',
                    "condition" => 'rx_template_type=box',
                ),                                                                                 
            )
        ); 
        
        $reviewx_form->typographySection(
            __("Recommendation Text Typography",'reviewx'),
            '.rx-review-form-area-style-1 .reviewx_recommended_title, .rx-review-form-area-style-2 .reviewx_recommended_title',
            $this);        
        
        $reviewx_form->typographySection(
            __("External Example Video Link Typography",'reviewx'),
            '.rx-review-form-area-style-1 #review_form .rx-note-video, .rx-review-form-area-style-2 #review_form .rx-note-video',
            $this);

        $reviewx_form->typographySection(
            __("Anonymously Text Typography",'reviewx'),
            '.review_anonymouse_label',
            $this);            
            
        $reviewx_form->typographySection(
            __("Submit Button Text Typography",'reviewx'),
            '.rx-review-form-area-style-1 #review_form input[type="submit"], .rx-review-form-area-style-1 #review_form input[type="submit"]:focus, .rx-review-form-area-style-2 #review_form input[type="submit"], 
            .rx-review-form-area-style-2 #review_form input[type="submit"]:focus,
            .woocommerce #respond input#submit',
            $this);                        
          
    }    

    function defaultCSS() {

        return file_get_contents(__DIR__.'/assets/css/'.basename(__FILE__, '.php').'.css');
    }

    /**
     * @return bool
     */
	public static function is_pro()
    {
        return class_exists('ReviewXPro');
    }

}

new RvxWooReviews();