<?php

namespace ReviewX\Controllers\Storefront;

use ReviewX\Constants\Filters;
use ReviewX\Controllers\Admin\Core\ReviewxMetaBox;
use ReviewX\Controllers\Controller;

/**
 * Class GraphTemplateLoader
 * @package ReviewX\Controllers\Storefront
 */
class GraphTemplateLoader extends Controller
{
    const MAP_STYLE_VIEW = [
        'default' => 'style-default',
        'divi' => [
            'graph_style_default'   => 'style-default',
            'graph_style_one'       => "style-one",
            'graph_style_two_free'  => "style-two-free",
        ],        
        'elementor' => [
            'graph_style_default'   => 'style-default',
            'graph_style_one'       => "style-one",
            'graph_style_two_free'  => "style-two-free",
        ],
        'reviewx' => [
            'graph_style_default'   => 'style-default',
            'graph_style_one'       => "style-one",
            'graph_style_two'       => "style-two",
            'graph_style_two_free'  => "style-two-free",
        ]
    ];

    public $settings;

    public $elementorController;
    public $diviController;

    public function __construct()
    {
        global $reviewx_shortcode;
        if( isset($reviewx_shortcode) && isset($reviewx_shortcode['rx_product_id']) && get_post_type( $reviewx_shortcode['rx_product_id'] ) == 'product' ){
            
            $settings = ReviewxMetaBox::get_option_settings();
  
        } else if( isset($reviewx_shortcode) && isset($reviewx_shortcode['rx_product_id']) && \ReviewX_Helper::check_post_type_availability( get_post_type( $reviewx_shortcode['rx_product_id'] ) ) == TRUE ){
        
            $reviewx_id = \ReviewX_Helper::get_reviewx_post_type_id( get_post_type( $reviewx_shortcode['rx_product_id'] ) );
            $settings = ReviewxMetaBox::get_metabox_settings( $reviewx_id ); 

        } else if( \ReviewX_Helper::check_post_type_availability( get_post_type() ) == TRUE ) { 

            $reviewx_id = \ReviewX_Helper::get_reviewx_post_type_id( get_post_type() );
            $settings = ReviewxMetaBox::get_metabox_settings( $reviewx_id );

        } else if( get_post_type() == 'product' ) {

            $settings = ReviewxMetaBox::get_option_settings();

        }
 
        $this->setSettings($settings);
        $this->setElementorController();

    }

    /**
     * @param mixed $settings
     */
    public function setSettings($settings)
    {
        $this->settings = $settings;
    }

    /**
     * @return mixed
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * @param $elementorController
     */
    public function setElementorController($elementorController = null)
    {      
        if( function_exists('oxygen_vsb_register_condition') ) {
            $this->elementorController = $elementorController ? : apply_filters(Filters::RX_LOAD_OXYGEN_STYLE_CONTROLLER, []) ;        
        } else {
            $this->elementorController = $elementorController ? : apply_filters(Filters::RX_LOAD_ELEMENTOR_STYLE_CONTROLLER, []) ;        
        }  
        
    }

    /**
     * @return mixed
     */
    public function getElementorController()
    {
        return $this->elementorController;
    }    

    /**
     * @param $property
     * @return |null
     */
    protected function getSettingsProperty($property)
    {
        if (isset($this->getSettings()->{$property})) {
            return $this->getSettings()->{$property};
        }
        return null;
    }

    /**
     * @return mixed|null
     */
    protected function elementorGraphStyle()
    {
        if (array_key_exists('rx_graph_type', $this->getElementorController())) {
            return array_get($this->getElementorController(), 'rx_graph_type', null);
        }
        return null;
    }

    /**
     * @return mixed|null
     */
    protected function diviGraphStyle()
    {
        if (array_key_exists('rvx_review_graph_criteria', $this->getElementorController())) {
            return array_get($this->getElementorController(), 'rvx_review_graph_criteria', null);
        }
        return null;
    }    

    /**
     * @return mixed
     */
    protected function getDefaultStyle()
    {
        return array_get(self::MAP_STYLE_VIEW, 'default', 'style-default');
    }

    /**
     * @param $key
     * @return mixed
     */
    protected function getStyleView($key)
    {
        return array_get(self::MAP_STYLE_VIEW, $key, []);
    }

    /**
     * @return mixed
     */
    protected function getStyle()
    {
        $default = $this->getDefaultStyle();

        if ($this->elementorGraphStyle()) {
            return  array_get(
                $this->getStyleView('elementor'),
                $this->elementorGraphStyle(),
                $default
            );
        }

        if( \ReviewX_Helper::reviewx_check_divi_active() ) {
            $rx_divi_settings   = get_post_meta( get_the_ID(), '_rx_option_divi_settings', true );
            $rx_divi_graph      = $rx_divi_settings['rvx_review_graph_criteria'];
            return  array_get(
                $this->getStyleView('divi'),
                $rx_divi_graph,
                $default
            );            
        }

        if ($this->getSettingsProperty('graph_style')) {
            return  array_get(
                $this->getStyleView('reviewx'),
                $this->getSettingsProperty('graph_style'),
                $default
            );
        }

        return $default;
    }

    /**
     * @return string
     */
    protected function getStylePath()
    {
        return "storefront/review-summery/" . $this->getStyle() . ".php";
    }

    /**
     * Load View
     */
    public function loadView()
    {

        global $reviewx_shortcode; 
        if( isset($reviewx_shortcode) && !empty($reviewx_shortcode['rx_product_id']) ) {
            $prod_id = $reviewx_shortcode['rx_product_id'];
        } else {
            $prod_id = get_the_ID();
        }

        $review_criteria = $this->getSettingsProperty('review_criteria');
        $arg = array(
            'post_type' 			=> get_post_type( $prod_id ),
            'post_id' 				=> $prod_id,
            'type'  				=> array( 'comment', 'review' ),
            'status'                =>'approve'
        );
        
        $comment_lists 				= get_comments($arg);
        $get_all_recommended_query	= reviewx_product_recommendation_count_meta($prod_id);
        $criteria_arr 				= array();
        $criteria_count 			= array();
        $total_review_count 		= array();
        $rx_total_rating_sum        = 0;

        foreach( $comment_lists as $comment_list ) {

            $get_criteria 			= get_comment_meta( $comment_list->comment_ID, 'reviewx_rating', true );
            $criteria_query_array 	= $get_criteria;
            $get_rating_val 	    = get_comment_meta( $comment_list->comment_ID, 'rating', true );
            if ( !empty( $get_rating_val ) ) {
                $rx_total_rating_count = array_push( $total_review_count, $get_rating_val );
                $rx_total_rating_sum += $get_rating_val;
            }

            if( is_array($review_criteria) ) {
                foreach( $review_criteria as $key => $single_criteria ) {
                    $hasKey = array_key_exists($key, $criteria_query_array);
                    if ($hasKey) {
                        if (isset($criteria_arr[$key])) {
                            $criteria_arr[$key] += !empty($criteria_query_array[$key])?$criteria_query_array[$key]:0;
                        } else {
                            $criteria_arr[$key] = !empty($criteria_query_array[$key])?$criteria_query_array[$key]:0;
                        }
                    }
                    if($hasKey) {
                        if (isset($criteria_count[$key])) {
                            $criteria_count[$key] += 1;
                        } else {
                            $criteria_count[$key] = 1;
                        }
                    }
                }
            }

        }

        $rx_count_total_rating_avg = round( $rx_total_rating_sum / $rx_total_rating_count, 2); 
        if( is_nan($rx_count_total_rating_avg) ){
            $rx_count_total_rating_avg = 5;
        }      
        $cri = apply_filters(Filters::REVIEWX_ADD_CRITERIA, $this->getSettingsProperty('review_criteria'));
        $allow_recommendation = get_option( '_rx_option_allow_recommendation' );

        if( isset($reviewx_shortcode) && $reviewx_shortcode['shortcode_type'] == 'recommendation' ) {
            $data = array();
            $data['cri'] = $cri;
            $data['rx_count_total_rating_avg']= $rx_count_total_rating_avg;
            $data['rx_total_rating_count']= $rx_total_rating_count;
            $data['allow_recommendation']= $allow_recommendation;
            $data['criteria_arr']= $criteria_arr;
            $data['criteria_count']= $criteria_count;
            $data['prod_id']= $prod_id;
            return $data;

        } else if( isset($reviewx_shortcode) && $reviewx_shortcode['shortcode_type'] == 'graph' ) {
            $data   = array();
            $data['template'] =  get_option( '_rx_option_graph_style' );
            $data['cri'] = $cri;
            $data['rx_count_total_rating_avg']= $rx_count_total_rating_avg;
            $data['rx_total_rating_count']= $rx_total_rating_count;
            $data['allow_recommendation']= $allow_recommendation;
            $data['criteria_arr']= $criteria_arr;
            $data['criteria_count']= $criteria_count;
            $data['prod_id']= $prod_id;
            return $data;            

        } else if( isset($reviewx_shortcode) && $reviewx_shortcode['shortcode_type'] == 'summary' ) {  

            return view_v1($this->getStylePath(), compact(
                'prod_id',
                'cri',
                'rx_count_total_rating_avg',
                'rx_total_rating_count',
                'allow_recommendation',
                'criteria_arr',
                'criteria_count'
            ));
        } else {
            return view_v1($this->getStylePath(), compact(
                'prod_id',
                'cri',
                'rx_count_total_rating_avg',
                'rx_total_rating_count',
                'allow_recommendation',
                'criteria_arr',
                'criteria_count'
            ));
        }
        
    }


}