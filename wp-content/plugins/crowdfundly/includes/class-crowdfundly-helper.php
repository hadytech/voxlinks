<?php

/**
 * Class Crowdfundly_Helper
 */
class Crowdfundly_Helper {

    public static $pages = [
        'dashboard' => 'crowdfundly-admin',
		'settings' => 'crowdfundly-settings',
		'logout' => 'crowdfundly-logout'
    ];

    private static $prefix = 'crowdfundly_meta_';

    public static function is_current_page($page)
    {
        return isset($_GET['page']) && sanitize_text_field($_GET['page'] === $page);
    }

    public static function buildUrl($url, $params = [])
    {
        $queries = [];
		$parseUrl = parse_url(esc_url($url));
        $queries = array_merge($queries, $params);
        $onlyUrl = strtok($url, '?');
        if (! empty($queries) ) {
            return $onlyUrl . '?' . http_build_query($queries);
		}
        return $onlyUrl;
    }

    /**
     * This function is responsible for the data sanitization
     *
     * @param array $field
     * @param string|array $value
     * @return string|array
     */
    public static function sanitize_field( $field, $value ) 
    {
        if ( isset( $field['sanitize'] ) && ! empty( $field['sanitize'] ) ) {
            if ( function_exists( $field['sanitize'] ) ) {
                $value = call_user_func( $field['sanitize'], $value );
            }
            return $value;
        }

        if( is_array( $field ) && isset( $field['type'] ) ) {
            switch ( $field['type'] ) {
                case 'text':
                    $value = sanitize_text_field( $value );
                    break;
                case 'textarea':
                    $value = sanitize_textarea_field( $value );
                    break;
                case 'email':
                    $value = sanitize_email( $value );
                    break;
                default:
                    return $value;
                    break;
            }
        } else {
            $value = sanitize_text_field( $value );
        }

        return $value;
    }    

    public static function sorter($data, $using = 'time_date', $way = 'DESC') 
    {
        if (!is_array($data)) {
            return $data;
        }
        $new_array = [];
        if ($using === 'key') {
            if ($way !== 'ASC') {
                krsort($data);
            } else {
                ksort($data);
            }
        } else {
            foreach ($data as $key => $value) {
                if (!is_array($value)) {
                    continue;
                }
                foreach ($value as $inner_key => $single) {
                    if ($inner_key == $using) {
                        $value[ 'tempid' ] = $key;
                        $single = self::numeric_key_gen($new_array, $single);
                        $new_array[ $single ] = $value;
                    }
                }
            }

            if ($way !== 'ASC') {
                krsort($new_array);
            } else {
                ksort($new_array);
            }

            if (!empty($new_array)) {
                foreach ($new_array as $array) {
                    $index = $array['tempid'];
                    unset($array['tempid']);
                    $new_data[ $index ] = $array;
                }
                $data = $new_data;
            }
        }

        return $data;
    }

    /**
     * This function is responsible for generate unique numeric key for a given array.
     *
     * @param  array   $data
     * @param  integer $index
     * @return integer
     */
    private static function numeric_key_gen($data, $index = 0) 
    {
        if (isset($data[ $index ])) {
            $index += 1;
            return self::numeric_key_gen($data, $index);
        }
        return $index;
    }

    /**
     * This function is responsible for render settings field
     *
     * @param  string $key
     * @param  array  $field
     * @return void
     */
    public static function render_field($prefix = null,  $key = '', $field = []) 
    {

        $post_id = '';
        $name    = isset($prefix) ? $prefix . $key : self::$prefix . $key;
        $id = self::get_row_id($key);
        $file_name = isset($field['type']) ? $field['type'] : 'text';

        if ('template' === $file_name) {
            $default = isset($field['defaults']) ? $field['defaults'] : [];
        } else {
            $default = isset($field['default']) ? $field['default'] : '';
        }

        $saved_value = self::get_settings();
        if (isset($saved_value[ $name ])) {
            $value = $saved_value[ $name ];
        } else {
            $value = $default;

            if( $name == 'crowdfundly_option_wc_payment' && self::check_exists_option( 'crowdfundly_option_wc_payment' ) == false ) {
                $value = $default;
            } else if( $name == 'crowdfundly_option_wc_payment' && self::check_exists_option_blank_value( 'crowdfundly_option_wc_payment' ) == '' ) {
               $crowdfundly_settings = get_option( 'crowdfundly_settings' );
               $value = $crowdfundly_settings[$name];
            } 
        }

        $class = 'crowdfundly-settings-field';
        $row_class = self::get_row_class($file_name);

        $attrs = '';

        if (isset($field['toggle']) && in_array($file_name, array('checkbox', 'select', 'toggle', 'theme'))) {
            $attrs .= ' data-toggle="' . esc_attr(json_encode($field['toggle'])) . '"';
        }

        if (isset($field['hide']) && $file_name == 'select') {
            $attrs .= ' data-hide="' . esc_attr(json_encode($field['hide'])) . '"';
        }

        $field_id = $name;

        include CROWDFUNDLY_ADMIN_DIR_PATH . 'partials/crowdfundly-field-display.php';
    }

    public static function get_settings( $name = '' )
    {

        $settings = get_option( 'crowdfundly_settings', true );
        if( ! empty( $name ) ) {
            if( isset( $settings[ $name ] ) ) {
                return $settings[ $name ];
            }
        }

        return is_array( $settings ) ? $settings : [];
    }

    /**
     * Get the row id ready
     *
     * @param  string $key
     * @return string
     */
    public static function get_row_id($key) 
    {
        return str_replace('_', '-', self::$prefix) . $key;
    }

    /**
     * Get the row id ready
     *
     * @param  string $key
     * @return string
     */
    public static function get_row_class($file) 
    {
        $prefix = str_replace('_', '-', self::$prefix);

        switch ($file) {
            case 'group':
                $row_class = $prefix . 'group-row';
                break;
            case 'colorpicker':
                $row_class = $prefix . 'colorpicker-row';
                break;
            case 'message':
                $row_class = $prefix . 'info-message-wrapper';
                break;
            case 'theme':
                $row_class = $prefix . 'theme-field-wrapper';
                break;
            default:
                $row_class = $prefix . $file;
                break;
        }

        return $row_class;
    }

    public static function get_landing_page()
    {
        $page = get_posts( array(
            'post_type'      => 'page',
            'posts_per_page' => 1,
            'meta_query'     => array(
                array(
                    'key'     => 'crowdfundly_job_id',
                    'value'   => 'all',
                    'compare' => '='
                ),
            ),
        ) );
        if(!empty($page))
            return $page[0];

        return null;
    }

    /**
     * Get campaign story
     * @author Mohiuddin
     * @date 13.01.2021 
     * @since 1.0.0
     * @return string
     */    
    public static function get_campaign_story($story, $wordCount)
    {

        $story = json_decode($story);
        $storyString = '';
        if ( $story && count($story) ) {
            foreach( $story as $key => $story_line ) {
                
                if( property_exists( $story_line, 'model' ) ) {
                    if( property_exists( $story_line->selectedElement, 'isFile') ) {
                        if( $story_line->selectedElement->isFile == true ) {
                            continue;
                        }
                    }
                    if( property_exists( $story_line->selectedElement, 'isIframe') == false || 
                       ( property_exists( $story_line->selectedElement, 'isIframe') && $story_line->selectedElement->isIframe == false) 
                    ) {
                        $storyString .= $story_line->model . ' ';
                    }
                }
            }
        }

       return self::get_slice_word_from_string($storyString, $wordCount);
    }
    
    /**
     * Get campaign excerpt
     * @author Mohiuddin
     * @date 13.01.2021
     * @since 1.0.0
     * @return string
     */    
    public static function get_slice_word_from_string($string, $wordCount, $separator = " ")
    {
        $excerpt = explode($separator, $string, $wordCount);
        if (  count( $excerpt ) >= $wordCount ) {
            array_pop($excerpt);
            $excerpt = implode(" ",$excerpt).'...';
        } else {
            $excerpt = implode(" ",$excerpt);
        }	
        $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
        return $excerpt;     
    } 
    
    /**
     * Get story details
     * @author Mohiuddin
     * @date 13.01.2021 
     * @since 1.0.0
     * @return string
     */    
    public static function get_campaign_story_details($story)
    {
        $html = '';
        foreach( $story as $key => $story_line ) {
            $html .= self::render($story_line);
        }
        return $html;
    }
    
    public static function render($el) {
        if(!$el->model) return '';

        $selected = $el->selectedElement;

        if( property_exists( $selected, 'isFile') && $selected->isFile)        
            return self::render_image($el);

        if( property_exists( $selected, 'isIframe') && $selected->isIframe) 
            return self::render_iframe($el);

        return self::render_base_element($el);
    }    
    
    /**
     * Redner video URL
     * @author Mohiuddin
     * @date 13.01.2021 
     * @since 1.0.0
     * @return string
     */    
    public static function get_video_url($url)
    {
        if (!$url) return null;

        $vimeo = "vimeo.com";
        $youtube = "www.youtube.com";        
        $url_parsed_arr = parse_url($url);
        if ( $url_parsed_arr['host'] == $youtube ) {
            $videType = [
                'watch'     => 'watch?v=',
                'youtuBe'   => 'youtu.be',
                'list'      => '&list',
                't'         => '&t',
                'feature'   => '&feature',
                'embed'     => 'embed/'
            ];
             
            if( strpos($url, '&feature=emb_logo') ){
                $url = str_replace( '&feature=emb_logo', '', $url );
            }

            if ( strpos($url, $videType['list']) ) {
                $embedUrl = str_replace( $videType['watch'], $videType['embed'], $url );
                return $embedUrl;
            }

            if ( strpos($url, $videType['feature']) ) {  
                $embedUrl = str_replace( $videType['watch'], $videType['embed'], $url );
                return $embedUrl;
            }

            if ( strpos($url, $videType['t']) ) {
                $embedUrl = str_replace( $videType['watch'], $videType['embed'], $url ); 
                return $embedUrl;                  
            }

            if ( strpos($url, $videType['watch']) ) {  
                $embedUrl = str_replace( $videType['watch'], $videType['embed'], $url );
                return $embedUrl;                  
            }            

            if ( strpos($url, $videType['youtuBe']) ) { 
                $embedLink = "youtube.com/embed/"; 
                $embedUrl = str_replace( $videType['youtuBe'], $embedLink, $url );
                return $embedUrl;                  
            }            

            return esc_url($url);

        }

        if ( $url_parsed_arr['host'] == $vimeo ) {
            $vimeoCode = explode('/', $url); 
            return esc_url('https://player.vimeo.com/video/' . $vimeoCode[3]);
        }
        return esc_url($url);       
    }
    
    /**
     * Render base element
     * @author Mohiuddin
     * @date 13.01.2021 
     * @since 1.0.0
     * @return string
     */    
    public static function render_base_element($el)
    {
        return '<div class="'.$el->selectedElement->class.'">'.$el->model.'</div>';
    } 
    
    /**
     * Render story images
     * @author Mohiuddin
     * @date 13.01.2021 
     * @since 1.0.0
     * @return string
     */     
    public static function render_image($el) {
        return '<div class="'.$el->selectedElement->class.'"><img src='.$el->model.'></div>';
    }

    /**
     * Render iframe
     * @author Mohiuddin
     * @date 13.01.2021 
     * @since 1.0.0
     * @return string
     */     
    public static function render_iframe($el) 
    {
        
        if (!$el->model) return;

        if ( !self::is_valid_video_url($el->model) ) {
            return '<p class="text-danger mt-2 mb-2">'.__("Invalid video URL !", "crowdfundly").'</p>';
        }

        $source = self::get_video_url($el->model);

        $iframe = "<div class='story-video-wrapper text-center'>
                    <iframe class='iframe' width='770' height='425' src='$source?controls=0' frameborder='0' allow='accelerometer;autoplay;encrypted-media;gyroscope;picture-in-picture' allowfullscreen></iframe>
                </div>
            ";
        return $iframe;
    }

    /**
     * Check is valid url
     * @author Mohiuddin
     * @date 13.01.2021 
     * @since 1.0.0
     * @return false|string
     */     
    public static function is_valid_video_url( $url ) 
    {

       $bool = false;

       $yt_rx = '/^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$/';
       $has_match_youtube = preg_match($yt_rx, esc_url($url), $yt_matches);
   
       $vm_rx = '/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([‌​0-9]{6,11})[?]?.*/';
       $has_match_vimeo = preg_match($vm_rx, esc_url($url), $vm_matches);
   
       //Then we want the video id which is:
       if($has_match_youtube) {
        $bool = true;
       } elseif($has_match_vimeo) {
        $bool = true;
       } else {
        $bool = false;
       }
   
       return $bool;

    }

    /**
	* Generate the builder data acording to default meta data
	*
	* @param array $data
	* @return array
	*/
    public static function builder_data( $data, $prefix = null ) 
    {

		$post_data   = [];
		$prefix      = isset($prefix) ? $prefix : self::$prefix;
		$meta_fields = self::get_option_fields( $prefix );
		foreach( $meta_fields as $meta_key => $meta_field ) {
            if( $meta_field['type'] == 'func'){
                continue;
            }
			if( in_array( $meta_key, array_keys($data) ) ) {
				$post_data[ $meta_key ] = $data[ $meta_key ];
			} else {
				$post_data[ $meta_key ] = '';

				if( isset( $meta_field['defaults'] ) ) {
					$post_data[ $meta_key ] = $meta_field['defaults'];
				}
				if( isset( $meta_field['default'] ) ) {
                    $post_data[ $meta_key ] = $meta_field['default'];
                    if( $meta_key == 'crowdfundly_option_wc_payment' ){
                        $post_data[ $meta_key ] = '';
                    }
				}
			}
		}

		return array_merge( $post_data, $data );
	}
    
    /**
	* Get option fields
	*
	* @param array $data
	* @return array
	*/    
    public static function get_option_fields( $prefix = '' ) 
    {
        $args = Crowdfundly_Settings::settings_args();
        $new_fields = [];

        foreach( $args as $tab ) {
            $sections = $tab['sections'];
            foreach( $sections as $section ) {
                $fields = $section['fields'];
                foreach( $fields as $id => $field ) {
                    $new_fields[ $prefix . $id ] = $field;
                }
            }
        }

        return apply_filters('crowdfundly_option_fields', $new_fields );
	}
	
    /**
	* Get option fields
	*
	* @param array $posts, integer, array
	* @return void
	*/ 
    public static function save_data( $posts, $prefix = null, $form = null)
    {
        $data         = [];
        $fields       = self::get_option_fields( $prefix );

        foreach ( $fields as $name => $field ) {
            $field_id = $name;
            $value = '';

            if ( isset( $posts[$field_id] ) ) {
                $value = self::sanitize_field( $field, $posts[$field_id] );
                $data[$field_id] = $value;
            } else {
                if ( 'checkbox' == $field['type'] ) {
                    $value = '0';
                    $data[$field_id] = $value;
                }
            }
            
        }

        $resp = array_merge( Crowdfundly_Settings::get(), $data );
        Crowdfundly_Settings::update($resp);
    }    
    
    /**
	* Check existing option
	*
	* @param array
	* @return void
	*/     
    public static function check_exists_option( $arg ) 
    {

        global $wpdb;
        $db_options = $wpdb->prefix.'options';        
        $results    = $wpdb->get_results( $wpdb->prepare('SELECT * FROM ' . $db_options . ' WHERE option_name LIKE "%s"', $arg), OBJECT );
        if ( count( $results ) === 0 ) {
            return false;
        } else {
            return true;
        }

    }

    /**
	* Check existing option blank value
	*
	* @param array
	* @return void
	*/         
    public static function check_exists_option_blank_value( $arg ) 
    {
        global $wpdb;
        $db_options = $wpdb->prefix.'options';
        $results    = $wpdb->get_results( $wpdb->prepare('SELECT * FROM ' . $db_options . ' WHERE option_name LIKE "%s"', $arg), OBJECT );
        if ( count( $results ) === 0 ) {
            return false;
        } else {
            return $results[0]->option_value;
        }

    }
    
    /**
	* Retrieve crowdfundly campaign product id
	*
	* @param none
	* @return int
	*/         
    public static function get_crowdfundly_product_id() 
    {
        $prod_id = 0;
        $product_obj = get_page_by_path( 'crowdfundly-campaign-product', OBJECT, 'product' );
        if( isset($product_obj) ){
            $prod_id = $product_obj->ID; 
        }        
        return (int) $prod_id;
    }    

    /**
	* Get server URL
	*
	* @param none
	* @return int
	*/         
    public static function get_organization_url() 
    {
        $organization   = get_option('crowdfundly_user');
        $username 		= isset($organization->username)?$organization->username:''; 
        if( !empty($username) ){
            return esc_url('https://'.$username.'.crowdfundly.io');
        }

        return esc_url('https://crowdfundly.io');        
    } 
    
    /**
	* Get slider video
	*
	* @param string
	* @return string
	*/ 
    public static function render_slider_iframe($url)
    {
        if (!$url) return;
        if ( !self::is_valid_video_url($url) ) return;

        $source = self::get_video_url($url);
        return '<iframe src="'.$source.'" allow="clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="allowfullscreen" id="v-player-iframe" class="v-player__iframe"></iframe>';

    }
    
    /**
	* Check campaign product is in cart
	*
	* @param none
	* @return boolean
	*/     
	public static function campaign_product_is_in_cart() {
        $product_id = self::get_crowdfundly_product_id();
		global $woocommerce;
		foreach($woocommerce->cart->get_cart() as $key => $val ) {
			$_product = $val['data'];
			if($product_id == $_product->get_id() ) {
				return true;
			}
		}
		return false;
	}    



}