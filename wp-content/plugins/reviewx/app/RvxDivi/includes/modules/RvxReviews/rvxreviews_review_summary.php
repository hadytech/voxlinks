<?php 

/********** Review Summary ***********/
$rvx_review_section_title_color	= $this->props['rvx_review_section_title_color'];
$rvx_review_section_title_font_size	= $this->props['rvx_review_section_title_font_size'];

$rvx_average_count_color	= $this->props['rvx_average_count_color'];
$rvx_average_count_font_size	= $this->props['rvx_average_count_font_size'];

$rvx_highest_rating_color	= $this->props['rvx_highest_rating_color'];
$rvx_highest_rating_font_size	= $this->props['rvx_highest_rating_font_size'];

$rvx_review_star_rating_color	= $this->props['rvx_review_star_rating_color'];
$rvx_review_star_rating_size	= $this->props['rvx_review_star_rating_size'];

$rvx_average_text_color	= $this->props['rvx_average_text_color'];
$rvx_recommendation_count_color	= $this->props['rvx_recommendation_count_color'];
$rvx_recommendation_text	= $this->props['rvx_recommendation_text'];

$rvx_review_graph_criteria_color	= $this->props['rvx_review_graph_criteria_color'];

$rvx_review_progressbar_text_color	= $this->props['rvx_review_progressbar_text_color'];
$rvx_review_progressbar_bg_color	= $this->props['rvx_review_progressbar_bg_color'];

if($rvx_review_section_title_color!=''){
    $echo_review_section_title = '';
    $echo_review_section_title .='color:'.$rvx_review_section_title_color.';';
    $echo_review_section_title .='font-size:'.$rvx_review_section_title_font_size.';';
    
    //Styles for current text
    ET_Builder_Element::set_style( 'et_pb_wc_review_for_ReviewX', array(
        'selector'    => '%%order_class%% .woocommerce-Reviews-title',
        'declaration' => sprintf('%1$s',esc_attr($echo_review_section_title)),
    ) );		
}

if($rvx_average_count_color!=''){
    $echo_average_count = '';
    $echo_average_count .='color:'.$rvx_average_count_color.';';
    $echo_average_count .='font-size:'.$rvx_average_count_font_size.';';
    
    //Styles for current text
    ET_Builder_Element::set_style( 'et_pb_wc_review_for_ReviewX', array(
        'selector'    => '%%order_class%% .rx-temp-rating .rx-temp-rating-number p',
        'declaration' => sprintf('%1$s',esc_attr($echo_average_count)),
    ) );		
}

if($rvx_highest_rating_color!=''){
    $echo_highest_rating = '';
    $echo_highest_rating .='color:'.$rvx_highest_rating_color.' !important;';
    $echo_highest_rating .='font-size:'.$rvx_highest_rating_font_size.' !important;';
    
    //Styles for current text
    ET_Builder_Element::set_style( 'et_pb_wc_review_for_ReviewX', array(
        'selector'    => '%%order_class%% .rx-temp-rating .rx-temp-rating-number span',
        'declaration' => sprintf('%1$s',esc_attr($echo_highest_rating)),
    ) );		
}

if($rvx_review_star_rating_color!=''){
    $echo_star_rating = '';
    $echo_star_rating .='fill:'.$rvx_review_star_rating_color.'!important;';    
    //Styles for current text
    ET_Builder_Element::set_style( 'et_pb_wc_review_for_ReviewX', array(
        'selector'    => '%%order_class%% .rx_avg_star_color',
        'declaration' => sprintf('%1$s',esc_attr($echo_star_rating)),
    ) );		
}

if($rvx_review_star_rating_color!=''){
    $echo_star_rating = '';
    $echo_star_rating .='fill:'.$rvx_review_star_rating_color.'!important;';
    $echo_star_rating .='width:'.$rvx_review_star_rating_size.' !important;height:'.$rvx_review_star_rating_size.' !important;';
    
    //Styles for current text
    ET_Builder_Element::set_style( 'et_pb_wc_review_for_ReviewX', array(
        'selector'    => '%%order_class%% .rx-temp-rating-star svg',
        'declaration' => sprintf('%1$s',esc_attr($echo_star_rating)),
    ) );		
}

if($rvx_average_text_color!=''){
    $echo_average_text = '';
    $echo_average_text .='color:'.$rvx_average_text_color.'!important;';
        
    //Styles for current text
    ET_Builder_Element::set_style( 'et_pb_wc_review_for_ReviewX', array(
        'selector'    => '%%order_class%% .rx-temp-total-rating-count p',
        'declaration' => sprintf('%1$s',esc_attr($echo_average_text)),
    ) );		
}

if($rvx_recommendation_count_color!=''){
    $echo_recommendation_count = '';
    $echo_recommendation_count .='color:'.$rvx_recommendation_count_color.'!important;';
        
    //Styles for current text
    ET_Builder_Element::set_style( 'et_pb_wc_review_for_ReviewX', array(
        'selector'    => '%%order_class%% .rx_recommended_box .rx_recommended_box_heading',
        'declaration' => sprintf('%1$s',esc_attr($echo_recommendation_count)),
    ) );		
}

if($rvx_recommendation_text!=''){
    $echo_recommendation_text = '';
    $echo_recommendation_text .='color:'.$rvx_recommendation_text.'!important;';
        
    //Styles for current text
    ET_Builder_Element::set_style( 'et_pb_wc_review_for_ReviewX', array(
        'selector'    => '%%order_class%% .rx_recommended_box .rx_recommended_box_content',
        'declaration' => sprintf('%1$s',esc_attr($echo_recommendation_text)),
    ) );		
}

if($rvx_review_graph_criteria_color!=''){
    $echo_graph_criteria_color = '';
    $echo_graph_criteria_color .='color:'.$rvx_review_graph_criteria_color.'!important;';     
        
    //Styles for current text
    ET_Builder_Element::set_style( 'et_pb_wc_review_for_ReviewX', array(
        'selector'    => '%%order_class%% .rx-graph-style-2 .progress-bar-t, .rx_style_two_free_progress_bar .progressbar-title, .vertical .vertical_bar_label',
        'declaration' => sprintf('%1$s',esc_attr($echo_graph_criteria_color)),
    ) );		
}

if($rvx_review_progressbar_text_color!=''){
    $echo_progress_bar_color = '';
    $echo_progress_bar_color .='color:'.$rvx_review_progressbar_text_color.'!important;';
        
    //Styles for current text
    ET_Builder_Element::set_style( 'et_pb_wc_review_for_ReviewX', array(
        'selector'    => '.rx-horizontal .progress-fill span,
        .rx_style_one_progress.orange .rx_style_one_progress-icon, 
        .rx_style_one_progress.orange .rx_style_one_progress-value,
        .rx_style_two_free_progress_bar .progress .progress-bar span,
        .vertical .progress-fill',
        'declaration' => sprintf('%1$s',esc_attr($echo_progress_bar_color)),
    ) );		
}


if($rvx_review_progressbar_bg_color!=''){
    $echo_progressbar_bg_color = '';
    $echo_progressbar_bg_color .='background-color:'.$rvx_review_progressbar_bg_color.'!important;';
        
    //Styles for current text
    ET_Builder_Element::set_style( 'et_pb_wc_review_for_ReviewX', array(
        'selector'    => '.rx-horizontal .progress-fill, .rx_style_one_progress .rx_style_one_progress-bar, .rx_style_two_free_progress_bar .progress .progress-bar, .vertical .progress-fill',
        'declaration' => sprintf('%1$s',esc_attr($echo_progressbar_bg_color)),
    ) );		
}