<?php

namespace ReviewX\Controllers\Admin\Core;

use ReviewX\Controllers\Controller;

/**
 * Class ReviewxMetaBox
 * @package ReviewX\Controllers\Admin\Core
 */
class ReviewxMetaBox extends Controller
{

    public static $args;
    public static $prefix = 'rx_option_';
    public static $meta_prefix = 'rx_meta_';
    public static $object_types;
    public static $post_id;
    public $defaults = array(
        'id'            => '',
        'title'         => '',
        'object_types'  => array(),
        'context'       => 'normal',
        'priority'      => 'low',
        'show_header'   => true,
        'prefix'        => ''
    );

    /**
     * This function is responsible for get all metabox arguments
     *
     * @return array
     */
    public static function get_args()
    {
        if( ! function_exists( 'reviewx_settings_metabox_args' ) ) {
            require_once REVIEWX_INCLUDE_PATH . 'admin/settings-metabox-helper.php';
        }
        do_action( 'rx_before_metabox_load' );
        return reviewx_settings_metabox_args();
        
    }

    /**
     * @return array
     */
    public static function get_builder_args()
    {
        if( ! function_exists( 'reviewx_builder_args' ) ) {
            require_once REVIEWX_INCLUDE_PATH . 'admin/builder-helper.php';
        }

        do_action( 'rx_before_builder_load' );
        return reviewx_builder_args();
    }

    /**
     * @return array
     */
    public static function get_quick_setup_args()
    {
        if( ! function_exists( 'reviewx_quick_setup_args' ) ) {
            require_once REVIEWX_INCLUDE_PATH . 'admin/builder-quick-setup.php';
        }

        do_action( 'rx_before_builder_load' );
        return reviewx_quick_setup_args();
    }

    /**
     * @return array
     */
    public static function get_review_email_args()
    {
        if( ! function_exists( 'reviewx_review_email_args' ) ) {
            require_once REVIEWX_INCLUDE_PATH . 'admin/builder-review-email.php';
        }

        do_action( 'rx_before_builder_load' );
        return reviewx_review_email_args();
    }

    /**
     * @param string $key
     * @param array $field
     * @param string $value
     * @param null $idd
     * @param bool $is_pro
     */
    public static function render_option_field( $key = '', $field = [], $value = '', $idd = null, $is_pro = false )
    {
        $attrs     = '';
        $name      = self::$prefix . $key;
        $id        = self::get_row_id( $key );
        $file_name = isset( $field['type'] ) ? $field['type'] : '';

        if( 'template' === $file_name ) {
            $default = isset( $field['defaults'] ) ? $field['defaults'] : [];
        } else {
            $default = isset( $field['default'] ) ? $field['default'] : '';
        }

        if( empty( $value ) ) {
            if( get_option( "_{$name}" ) ) {
                $value = get_option( "_{$name}" );           
            } else {  

                $value = $default;

                if( $name == 'rx_option_completed' && self::rx_exists_option( '_rx_option_completed' ) == false ) {
                    $value = $default;
                } else if( $name == 'rx_option_completed' && self::rx_exists_option_blank_value( '_rx_option_completed' ) == '' ) {                    
                    $value = get_option( "_{$name}" );
                } 
                
                // Allow filter keyword default
                if( $name == 'rx_option_filter_recent' && self::rx_exists_option( '_rx_option_filter_recent' ) == false ) {
                    $value = $default;
                } else if( $name == 'rx_option_filter_recent' && self::rx_exists_option_blank_value( '_rx_option_filter_recent' ) == '' ) {                    
                    $value = get_option( "_{$name}" );
                } 

                if( $name == 'rx_option_filter_photo' && self::rx_exists_option( '_rx_option_filter_photo' ) == false ) {
                    $value = $default;
                } else if( $name == 'rx_option_filter_photo' && self::rx_exists_option_blank_value( '_rx_option_filter_photo' ) == '' ) {                    
                    $value = get_option( "_{$name}" );
                } 
                
                if( $name == 'rx_option_filter_text' && self::rx_exists_option( '_rx_option_filter_text' ) == false ) {
                    $value = $default;
                } else if( $name == 'rx_option_filter_text' && self::rx_exists_option_blank_value( '_rx_option_filter_text' ) == '' ) {                    
                    $value = get_option( "_{$name}" );
                } 
                
                if( $name == 'rx_option_filter_rating' && self::rx_exists_option( '_rx_option_filter_rating' ) == false ) {
                    $value = $default;
                } else if( $name == 'rx_option_filter_rating' && self::rx_exists_option_blank_value( '_rx_option_filter_rating' ) == '' ) {                    
                    $value = get_option( "_{$name}" );
                }
                
                if( $name == 'rx_option_filter_low_rating' && self::rx_exists_option( '_rx_option_filter_low_rating' ) == false ) {
                    $value = $default;
                } else if( $name == 'rx_option_filter_low_rating' && self::rx_exists_option_blank_value( '_rx_option_filter_low_rating' ) == '' ) {                    
                    $value = get_option( "_{$name}" );
                }                

                if( $name == 'rx_option_allow_multi_criteria' && self::rx_exists_option( '_rx_option_allow_multi_criteria' ) == false ) {
                    $value = $default;
                } else if( $name == 'rx_option_allow_multi_criteria' && self::rx_exists_option_blank_value( '_rx_option_allow_multi_criteria' ) == '' ) {                    
                    $value = get_option( "_{$name}" );
                }                 

                if( $name == 'rx_option_allow_img' && self::rx_exists_option( '_rx_option_allow_img' ) == false ) {
                    $value = $default;
                } else if( $name == 'rx_option_allow_img' && self::rx_exists_option_blank_value( '_rx_option_allow_img' ) == '' ) {                    
                    $value = get_option( "_{$name}" );
                } 
                
                if( $name == 'rx_option_allow_recommendation' && self::rx_exists_option( '_rx_option_allow_recommendation' ) == false ) {
                    $value = $default;
                } else if( $name == 'rx_option_allow_recommendation' && self::rx_exists_option_blank_value( '_rx_option_allow_recommendation' ) == '' ) {
                    $value = get_option( "_{$name}" );
                }

                if( $name == 'rx_option_disable_auto_approval' && self::rx_exists_option( 'rx_option_disable_auto_approval' ) == false ) {
                    $value = get_option( "_{$name}" );
                }

                if( $name == 'rx_option_allow_review_title' && self::rx_exists_option( '_rx_option_allow_review_title' ) == false ) {
                    $value = $default;
                } else if( $name == 'rx_option_allow_review_title' && self::rx_exists_option_blank_value( '_rx_option_allow_review_title' ) == '' ) {
                    $value = get_option( "_{$name}" );
                }

                if( $name == 'rx_option_disable_richschema' && self::rx_exists_option( '_rx_option_disable_richschema' ) == false ) {
                    $value = $default;
                } else if( $name == 'rx_option_disable_richschema' && self::rx_exists_option_blank_value( '_rx_option_disable_richschema' ) == '' ) {                    
                    $value = get_option( "_{$name}" );
                } 
                
                if( $name == 'rx_option_allow_media_compliance' && self::rx_exists_option( '_rx_option_allow_media_compliance' ) == false ) {
                    $value = $default;
                } else if( $name == 'rx_option_allow_media_compliance' && self::rx_exists_option_blank_value( '_rx_option_allow_media_compliance' ) == '' ) {                    
                    $value = get_option( "_{$name}" );
                } 

                if( class_exists('ReviewXPro') ) {   
                    
                    if( $name == 'rx_option_filter_video' && self::rx_exists_option( '_rx_option_filter_video' ) == false ) {
                        $value = $default;
                    } else if( $name == 'rx_option_filter_video' && self::rx_exists_option_blank_value( '_rx_option_filter_video' ) == '' ) {                    
                        $value = get_option( "_{$name}" );
                    }                      

                    if( $name == 'rx_option_allow_video' && self::rx_exists_option( '_rx_option_allow_video' ) == false ) {
                        $value = 1;
                    } else if( $name == 'rx_option_allow_video' && self::rx_exists_option_blank_value( '_rx_option_allow_video' ) == '' ) {                   
                        $value = get_option( "_{$name}" );
                    }

                    if( $name == 'rx_option_allow_anonymouse' && self::rx_exists_option( '_rx_option_allow_anonymouse' ) == false ) {
                        $value = 1;
                    } else if( $name == 'rx_option_allow_anonymouse' && self::rx_exists_option_blank_value( '_rx_option_allow_anonymouse' ) == '' ) { 
                        $value = get_option( "_{$name}" );
                    }  
                    
                    if( $name == 'rx_option_allow_share_review' && self::rx_exists_option( '_rx_option_allow_share_review' ) == false ) {
                        $value = 1;
                    } else if( $name == 'rx_option_allow_share_review' && self::rx_exists_option_blank_value( '_rx_option_allow_share_review' ) == '' ) { 
                        $value = get_option( "_{$name}" );
                    } 
                    
                    if( $name == 'rx_option_allow_like_dislike' && self::rx_exists_option( '_rx_option_allow_like_dislike' ) == false ) {
                        $value = 1;
                    } else if( $name == 'rx_option_allow_like_dislike' && self::rx_exists_option_blank_value( '_rx_option_allow_like_dislike' ) == '' ) { 
                        $value = get_option( "_{$name}" );
                    }
                    
                    if( $name == 'rx_option_allow_multiple_review' && self::rx_exists_option( '_rx_option_allow_multiple_review' ) == false ) {
                        $value = 1;
                    } else if( $name == 'rx_option_allow_multiple_review' && self::rx_exists_option_blank_value( '_rx_option_allow_multiple_review' ) == '' ) { 
                        $value = get_option( "_{$name}" );
                    }                     

                }

            }        
        }

        $default_attr = is_array( $default ) ? json_encode( $default ) : $default;

        if( ! empty( $default_attr ) ) {
            $attrs .= ' data-default="' . esc_attr( $default_attr ) . '"';
        }

        $class  = 'rx-meta-field';
        $row_class = self::get_row_class( $file_name );

        if( isset( $field['toggle'] ) && in_array( $file_name, array( 'checkbox', 'select', 'toggle', 'theme', 'adv_checkbox' ) ) ) {
            $attrs .= ' data-toggle="' . esc_attr( json_encode( $field['toggle'] ) ) . '"';
        }

        if( isset( $field['hide'] ) && $file_name == 'select' ) {
            $attrs .= ' data-hide="' . esc_attr( json_encode( $field['hide'] ) ) . '"';
        }

        if( isset( $field['tab'] ) && $file_name == 'select' ) {
            $attrs .= ' data-tab="' . esc_attr( json_encode( $field['tab'] ) ) . '"';
        }

        include REVIEWX_PARTIALS_PATH . 'admin/field-display.php';
    }

    /**
     * @param string $key
     * @param array $field
     * @param string $value
     * @param null $idd
     * @param bool $is_pro
     */
    public static function render_meta_field_email_setting( $key = '', $field = [], $value = '', $idd = null, $is_pro = false )
    {
        $attrs = '';
        $name      = self::$prefix . $key;
        $id        = self::get_row_id( $key );
        $file_name = isset( $field['type'] ) ? $field['type'] : '';

        if( 'template' === $file_name ) {
            $default = isset( $field['defaults'] ) ? $field['defaults'] : [];
        } else {
            $default = isset( $field['default'] ) ? $field['default'] : '';
        }

        if( empty( $value ) ) {
            if( get_option( "_{$name}" ) ) {
                $value = get_option( "_{$name}" );
            } else {
                $value = $default;
            }
        }

        $default_attr = is_array( $default ) ? json_encode( $default ) : $default;

        if( ! empty( $default_attr ) ) {
            $attrs .= ' data-default="' . esc_attr( $default_attr ) . '"';
        }

        $class  = 'rx-meta-field';
        $row_class = self::get_row_class( $file_name );

        if( isset( $field['toggle'] ) && in_array( $file_name, array( 'checkbox', 'select', 'toggle', 'theme', 'adv_checkbox' ) ) ) {
            $attrs .= ' data-toggle="' . esc_attr( json_encode( $field['toggle'] ) ) . '"';
        }

        if( isset( $field['hide'] ) && $file_name == 'select' ) {
            $attrs .= ' data-hide="' . esc_attr( json_encode( $field['hide'] ) ) . '"';
        }

        if( isset( $field['tab'] ) && $file_name == 'select' ) {
            $attrs .= ' data-tab="' . esc_attr( json_encode( $field['tab'] ) ) . '"';
        }

        include REVIEWX_PARTIALS_PATH . 'admin/email-setting-field-display.php';
    }

    public static function rx_exists_option( $arg ) {

        global $wpdb;
        $db_options = $wpdb->prefix.'options';
        $sql_query  = 'SELECT * FROM ' . $db_options . ' WHERE option_name LIKE "' . $arg . '"';
        $results    = $wpdb->get_results( $sql_query, OBJECT );
        if ( count( $results ) === 0 ) {
            return false;
        } else {
            return true;
        }

    }  
    
    public static function rx_exists_option_blank_value( $arg ) {

        global $wpdb;
        $db_options = $wpdb->prefix.'options';
        $sql_query  = 'SELECT * FROM ' . $db_options . ' WHERE option_name LIKE "' . $arg . '"';
        $results    = $wpdb->get_results( $sql_query, OBJECT );
        if ( count( $results ) === 0 ) {
            return false;
        } else {
            return $results[0]->option_value;
        }

    }    

    /**
     * Get the row id ready
     *
     * @param string $key
     * @return string
     */
    public static function get_row_id( $key )
    {
        return str_replace( '_', '-', self::$prefix ) . $key;
    }

    /**
     * Get the row class
     *
     * @param $file
     * @return string
     */
    public static function get_row_class( $file )
    {
        $prefix = str_replace( '_', '-', self::$prefix );

        switch( $file ) {
            case 'group':
                $row_class = $prefix .'group-row';
                break;
            case 'colorpicker':
                $row_class = $prefix .'colorpicker-row';
                break;
            case 'message':
                $row_class = $prefix . 'info-message-wrapper';
                break;
            case 'theme':
                $row_class = $prefix . 'theme-field-wrapper';
                break;
            default :
                $row_class = $prefix . $file;
                break;
        }

        return $row_class;
    }

    /**
     * @param string $prefix
     * @return mixed|void
     */
    public static function get_option_fields( $prefix = '' )
    {
        $args       = self::get_args();
        $tabs       = $args['tabs'];

        $new_fields = []; 
           
        foreach( $tabs as $tab ) {
            $sections = $tab['sections'];
            $i        = 1;
            foreach( $sections as $section ) {
                if( isset( $section['is_multiple'] ) ) {                                        
                    foreach( $section as $key => $value ) {
                        if( $key == 'is_multiple' ) {                                                     
                            continue;
                        } else {                            
                            $field_key  = 'fields'.$i;  
                            $fields = isset($section[$field_key]) ? $section[$field_key] : []; 
                            foreach( $fields as $key => $field ) {
                                $new_fields[ $prefix . $key ] = $field;
                            }                         
                        }
                        $i++;
                    }
                } else {
                    $fields = $section['fields'];
                    foreach( $fields as $id => $field ) {
                        if( array_key_exists('disabled', $field) && !class_exists('ReviewXPro') ) {
                            continue;
                        }
                        $new_fields[ $prefix . $id ] = $field;
                    }                    
                }               
            }
        }    

        return apply_filters('rx_option_fields', $new_fields );
    }

    /**
     * Email settings 
     *
     * @param string $prefix
     * @return void
     */
    public static function get_option_review_email_fields( $prefix = '' )
    {
        $args = self::get_review_email_args();
        $tabs = $args['tabs'];

        $new_fields = [];

        foreach( $tabs as $tab ) {
            $sections = $tab['sections'];
            foreach( $sections as $section ) {
                $fields = $section['fields'];
                foreach( $fields as $id => $field ) {
                    $new_fields[ $prefix . $id ] = $field;
                }
            }
        }

        return $new_fields;
    }

    /**
     * Save data
     * @param $posts
     */
    public static function save_data( $posts , $form)
    {
        $mapFields = [
            'settings' => self::get_option_fields(),
            'quick_setup' => self::get_option_fields(),
            'review_email' => self::get_option_review_email_fields()
        ];

        $prefix       = self::$prefix;
        $fields       = $mapFields[$form];
        $data         = [];
        $new_settings = new \stdClass();

        foreach ( $fields as $name => $field ) {

            $field_id   = $prefix . $name;
            $value      = '';

            if ( isset( $posts[$field_id] ) ) { 
                $value = \ReviewX_Helper::sanitize_field( $field, $posts[$field_id] );
            } else {
                if ( 'checkbox' == $field['type'] ) {
                    $value = '0';
                }
            }

            update_option( "_{$field_id}", $value );
            $data[ "_{$field_id}" ] = $new_settings->{ $name } = $value;
        }

        if ($posts['rx_builder_from_where'] == "settings") {
            update_option( '_rx_builder_current_tab', $posts['rx_builder_current_tab'] );
        }

        if ($posts['rx_builder_from_where'] == "quick_setup") {
            update_option( '_rx_builder_quick_setup', $posts['rx_builder_current_tab'] );
        }

        if( get_option('_rx_option_disable_autocreate_unsubscribe_page') == 1 ) {
            $page_id = url_to_postid( get_option('_rx_option_unsubscribe_url') );
            wp_delete_post($page_id);
            delete_option('_rx_option_unsubscribe_url');
        }

    }

    /**
     * Get all the meta settings
     *
     * @return \stdClass
     */
    public static function get_option_settings()
    {
        $fields     = self::get_option_fields();
        $prefix     = self::$prefix;
        $settings   = new \stdClass();

        foreach ( $fields as $name => $field ) {
            $field_id   = $prefix . $name;
            $default    = isset( $field['default'] ) ? $field['default'] : '';

            if( isset( $field['type'] ) && $field['type'] == 'template' ) {
                $default    = isset( $field['defaults'] ) ? $field['defaults'] : [];
            }

            if ( get_option( "_{$field_id}" ) ) {
                $value  = get_option( "_{$field_id}" );
            } else {
               $value  = $default;
            }

            if( $field_id == 'rx_option_allow_multi_criteria' && self::rx_exists_option( '_rx_option_allow_multi_criteria' ) == false ) {
                $value = $default;
            } else if( $field_id == 'rx_option_allow_multi_criteria' && self::rx_exists_option_blank_value( '_rx_option_allow_multi_criteria' ) == '' ) {                    
                $value = get_option( "_{$field_id}" );
            }
            
            $settings->{$name} = $value;
        }

        return $settings;
    }

    /**
     * @return array
     */
    public static function get_review_cpt_metabox_args()
    {
        if( ! function_exists( 'reviewx_cpt_metabox_args' ) ) {
            require_once REVIEWX_INCLUDE_PATH . 'admin/cpt-metabox-helper.php';
        }

        do_action( 'rx_before_builder_load' );
        return reviewx_cpt_metabox_args();
    }    

    public static function render_metabox( $post = null ) {

        self::$post_id = $post->ID;

        $tabs       = self::$args['tabs'];
        $prefix     = self::$prefix;
        $metabox_id = self::$args['id'];

        $tabnumber	= isset( self::$args['tabnumber'] ) && self::$args['tabnumber'] ? true : false;
        
        wp_nonce_field( $metabox_id, $metabox_id . '_nonce' );
        include_once REVIEWX_PARTIALS_PATH . 'admin/rx-cpt-metabox-display.php';
    }    

    /**
     * Add the metabox to the posts
     *
     * @return void
     */
	public function add_meta_boxes() {        
        self::$args         = wp_parse_args( self::get_review_cpt_metabox_args(), $this->defaults );
        self::$object_types = (array)self::$args['object_types'];
        add_meta_box( self::$args['id'], self::$args['title'], __CLASS__ . '::render_metabox', self::$object_types, self::$args['context'], self::$args['priority'] );
    }
    
    /**
     * Get the metabox from posts
     *
     * @return void
     */    
    public static function get_metabox_fields( $prefix = '' ) {
        $args = self::get_review_cpt_metabox_args();
        $tabs = $args['tabs'];

        $new_fields = [];
        
        foreach( $tabs as $tab ) {
            $sections = $tab['sections'];
            $i        = 1;
            foreach( $sections as $section ) {
                if( isset( $section['is_multiple'] ) ) {                                        
                    foreach( $section as $key => $value ) {
                        if( $key == 'is_multiple' ) {                                                     
                            continue;
                        } else {                            
                            $field_key  = 'fields'.$i;  
                            $fields = isset($section[$field_key])? $section[$field_key]: []; 
                            foreach( $fields as $key => $field ) {
                                $new_fields[ $prefix . $key ] = $field;
                            }                         
                        }
                        $i++;
                    }
                } else {
                    $fields = $section['fields'];
                    foreach( $fields as $id => $field ) {
                        $new_fields[ $prefix . $id ] = $field;
                    }                    
                }               
            }
        }         

        return apply_filters('rx_meta_fields', $new_fields );
    }
    
    /**
     * Save metabox
     *
     * @return void
     */      
    public static function save_metabox( $post_id ) {

        $args = self::get_review_cpt_metabox_args();

        $metabox_id     = $args['id'];
        $object_types   = $args['object_types'];

        // Verify the nonce.
        if ( ! isset( $_POST[$metabox_id . '_nonce'] ) || ! wp_verify_nonce( $_POST[$metabox_id . '_nonce'], $metabox_id ) ) {
            return $post_id;
        }

        // Verify if this is an auto save routine.
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
            return $post_id;
        }
        
        // Check permissions to edit pages and/or posts
        if ( in_array( $_POST['post_type'], $object_types ) ) {
            if ( ! current_user_can( 'edit_page', $post_id ) || ! current_user_can( 'edit_post', $post_id ) ) {
                return $post_id;
            }
        }
        /**
         * Save all meta!
         */ 
        self::save_post_data( $_POST, $post_id);
        do_action('rx_save_post');

        //Rating average calculation is here
        wp_clear_scheduled_hook( 'rx_assign_rating_old_comment' );
        if ( ! wp_next_scheduled( 'rx_assign_rating_old_comment' ) ) {
            wp_schedule_single_event( time() + 60, 'rx_assign_rating_old_comment', array($post_id) );
        }
    }
    
    public static function save_post_data( $posts, $post_id ) {

        $prefix       = self::$meta_prefix;
        $fields       = self::get_metabox_fields();
        $old_settings = self::get_metabox_settings( $post_id );
        $data         = [];
        $new_settings = new \stdClass();

        foreach ( $fields as $name => $field ) {
            $field_id = $prefix . $name;
            $value = '';

            if ( isset( $posts[$field_id] ) ) {
                $value = \ReviewX_Helper::sanitize_field( $field, $posts[$field_id] );
            } else {
                if ( 'checkbox' == $field['type'] ) {
                    $value = '0';
                }
            }

            if( strrpos( $field_id, 'template_new' ) !== false && strrpos( $field_id, 'template_new' ) >= 0 ) {
                $template_string = self::template_generate( $posts[ $field_id ], $posts );
                update_post_meta( $post_id, "_{$field_id}_string", $template_string );
            }
            update_post_meta( $post_id, "_{$field_id}", $value );
            $data[ "_{$field_id}" ] = $new_settings->{ $name } = $value;
        }

        $is_created = true;
        $is_created_meta = get_post_meta( $post_id, '_rx_meta_active_check', true );
        if ( $is_created_meta != '' ) {
            $is_created = $is_created_meta;
        }

        if( isset( $posts['post_status'] ) && $posts['post_status'] != 'publish' ) {
            $is_created = false;
        }

        global $wpdb;
        $post_type = $posts['rx_meta_custom_post_types'];
        $wpdb->query( $wpdb->prepare("UPDATE $wpdb->posts SET comment_status = 'open' WHERE post_type = '$post_type'") ); // Enable comments

        update_post_meta( $post_id, '_rx_meta_active_check', $is_created );
        update_post_meta( $post_id, '_rx_builder_current_tab', $posts['rx_builder_current_tab'] );
    } 
    
    /**
     * Get all the meta settings of a reviewx post
     *
     * @param int $id
     * @return stdClass object
     */
    public static function get_metabox_settings( $id ){
        $fields     = self::get_metabox_fields();
        $prefix     = self::$meta_prefix;
        $settings   = new \stdClass();

        if( empty( $id ) ) {
            return;
        }

        foreach ( $fields as $name => $field ) {
            $field_id   = $prefix . $name;
            $default    = isset( $field['default'] ) ? $field['default'] : '';

            if( isset( $field['type'] ) && $field['type'] == 'template' ) {
                $default    = isset( $field['defaults'] ) ? $field['defaults'] : [];
                if( strrpos( $name, 'template_new' ) >= 0 && metadata_exists( 'post', $id, "_{$field_id}_string" ) ) {
                    $value  = get_post_meta( $id, "_{$field_id}_string", true );
                    $settings->{ "{$name}_string" } = $value;
                } else {
                    $value  = get_post_meta( $id, "_{$field_id}", true );
                    $settings->{ "{$name}" } = $value;
                }
            } else {
                if ( metadata_exists( 'post', $id, "_{$field_id}" ) ) {
                    $value  = get_post_meta( $id, "_{$field_id}", true );
                } else {
                    $value  = $default;
                }
            }

            $settings->{$name} = $value;
        }
        
        $settings->id = $id;

        return $settings;
    }
    
    /**
     * @param string $key
     * @param array $field
     * @param string $value
     * @param null $idd
     * @param bool $is_pro
     */
    public static function render_meta_field( $key = '', $field = [], $value = '', $idd = null, $is_pro = false )
    {
        global $pagenow;
        $post_id   = self::$post_id;
        $attrs = '';
        $name      = self::$meta_prefix . $key;
        $id        = self::get_row_id( $key );
        $file_name = isset( $field['type'] ) ? $field['type'] : '';

        if( 'template' === $file_name ) {
            $default = isset( $field['defaults'] ) ? $field['defaults'] : [];
        } else {
            $default = isset( $field['default'] ) ? $field['default'] : '';
        }

        if( empty( $value ) ) {
            if( metadata_exists( 'post', $post_id, "_{$name}" ) ) {
                $value = get_post_meta( $post_id, "_{$name}", true );
            } else {
                $value = $default;
            }
        } else {
            $value = $value;

            // Allow filter keyword default
            if( $name == 'rx_meta_filter_recent' && metadata_exists( 'post', $post_id, "_rx_meta_filter_recent" ) == false ) {
                $value = $default;
            } else if( $name == 'rx_meta_filter_recent' && get_post_meta( $post_id, "_{$name}", true ) == '' ) {                    
                $value = get_post_meta( $post_id, "_{$name}", true );
            } 

            if( $name == 'rx_meta_filter_photo' && metadata_exists( 'post', $post_id, "_rx_meta_filter_photo" ) == false ) {
                $value = $default;
            } else if( $name == 'rx_meta_filter_photo' && get_post_meta( $post_id, "_{$name}", true ) == '' ) {                    
                $value = get_post_meta( $post_id, "_{$name}", true );
            } 

            if( $name == 'rx_meta_filter_text' && metadata_exists( 'post', $post_id, "_rx_meta_filter_text" ) == false ) {
                $value = $default;
            } else if( $name == 'rx_meta_filter_text' && get_post_meta( $post_id, "_{$name}", true ) == '' ) {                    
                $value = get_post_meta( $post_id, "_{$name}", true );
            } 

            if( $name == 'rx_meta_filter_rating' && metadata_exists( 'post', $post_id, "_rx_meta_filter_rating" ) == false ) {
                $value = $default;
            } else if( $name == 'rx_meta_filter_rating' && get_post_meta( $post_id, "_{$name}", true ) == '' ) {                    
                $value = get_post_meta( $post_id, "_{$name}", true );
            }

            if( $name == 'rx_meta_filter_low_rating' && metadata_exists( 'post', $post_id, "_rx_meta_filter_low_rating" ) == false ) {
                $value = $default;
            } else if( $name == 'rx_meta_filter_low_rating' && get_post_meta( $post_id, "_{$name}", true ) == '' ) {                    
                $value = get_post_meta( $post_id, "_{$name}", true );
            }            

            if( $name == 'rx_meta_allow_multi_criteria' && metadata_exists( 'post', $post_id, "_rx_meta_allow_multi_criteria" ) == false ) {
                $value = $default;
            } else if( $name == 'rx_meta_allow_multi_criteria' && get_post_meta( $post_id, "_{$name}", true ) == '' ) {                 
                $value = get_post_meta( $post_id, "_{$name}", true );
            }                 

            if( $name == 'rx_meta_allow_img' && metadata_exists( 'post', $post_id, "_rx_meta_allow_img" ) == false ) {
                $value = $default;
            } else if( $name == 'rx_meta_allow_img' && get_post_meta( $post_id, "_{$name}", true ) == '' ) {                    
                $value = get_post_meta( $post_id, "_{$name}", true );
            } 
            
            if( $name == 'rx_meta_allow_recommendation' && metadata_exists( 'post', $post_id, "_rx_meta_allow_recommendation" ) == false ) {
                $value = $default;
            } else if( $name == 'rx_meta_allow_recommendation' && get_post_meta( $post_id, "_{$name}", true ) == '' ) {
                $value = get_post_meta( $post_id, "_{$name}", true );
            }

            if( $name == 'rx_meta_disable_auto_approval' && metadata_exists( 'post', $post_id, "_rx_meta_disable_auto_approval" ) == false ) {
                $value = get_post_meta( $post_id, "_{$name}", true );
            }

            if( $name == 'rx_meta_allow_review_title' && metadata_exists( 'post', $post_id, "_rx_meta_allow_review_title" ) == false ) {
                $value = $default;
            } else if( $name == 'rx_meta_allow_review_title' && get_post_meta( $post_id, "_{$name}", true ) == '' ) {
                $value = get_post_meta( $post_id, "_{$name}", true );
            }

            if( $name == 'rx_meta_allow_media_compliance' && metadata_exists( 'post', $post_id, "_rx_meta_allow_media_compliance" ) == false ) {
                $value = $default;
            } else if( $name == 'rx_meta_allow_media_compliance' && get_post_meta( $post_id, "_{$name}", true ) == '' ) {
                $value = get_post_meta( $post_id, "_{$name}", true );
            }

            if( class_exists('ReviewXPro') ) {

                if( $name == 'rx_meta_filter_video' && metadata_exists( 'post', $post_id, "_rx_meta_filter_video" ) == false ) {
                    $value = $default;
                } else if( $name == 'rx_meta_filter_video' && get_post_meta( $post_id, "_{$name}", true ) == '' ) {                    
                    $value = get_post_meta( $post_id, "_{$name}", true );
                } 

                if( $name == 'rx_meta_allow_video' && metadata_exists( 'post', $post_id, "_rx_meta_allow_video" ) == false ) {
                    $value = 1;
                } else if( $name == 'rx_meta_allow_video' && get_post_meta( $post_id, "_{$name}", true ) == '' ) {                   
                    $value = get_post_meta( $post_id, "_{$name}", true );
                }

                if( $name == 'rx_meta_allow_anonymouse' && metadata_exists( 'post', $post_id, "_rx_meta_allow_anonymouse" ) == false ) {
                    $value = 1;
                } else if( $name == 'rx_meta_allow_anonymouse' && get_post_meta( $post_id, "_{$name}", true ) == '' ) { 
                    $value = get_post_meta( $post_id, "_{$name}", true );
                }  
                
                if( $name == 'rx_meta_allow_share_review' && metadata_exists( 'post', $post_id, "_rx_meta_allow_share_review" ) == false ) {
                    $value = 1;
                } else if( $name == 'rx_meta_allow_share_review' && get_post_meta( $post_id, "_{$name}", true ) == '' ) { 
                    $value = get_post_meta( $post_id, "_{$name}", true );
                } 
                
                if( $name == 'rx_meta_allow_like_dislike' && metadata_exists( 'post', $post_id, "_rx_meta_allow_like_dislike" ) == false ) {
                    $value = 1;
                } else if( $name == 'rx_meta_allow_like_dislike' && get_post_meta( $post_id, "_{$name}", true ) == '' ) { 
                    $value = get_post_meta( $post_id, "_{$name}", true );
                }
                
                if( $name == 'rx_meta_allow_multiple_review' && metadata_exists( 'post', $post_id, "_rx_meta_allow_multiple_review" ) == false ) {
                    $value = 1;
                } else if( $name == 'rx_meta_allow_multiple_review' && get_post_meta( $post_id, "_{$name}", true ) == '' ) { 
                    $value = get_post_meta( $post_id, "_{$name}", true );
                }                     

            }            
        }

        $default_attr = is_array( $default ) ? json_encode( $default ) : $default;

        if( ! empty( $default_attr ) ) {
            $attrs .= ' data-default="' . esc_attr( $default_attr ) . '"';
        }

        $class  = 'rx-meta-field';
        $row_class = self::get_row_class( $file_name );

        if( isset( $field['toggle'] ) && in_array( $file_name, array( 'checkbox', 'select', 'toggle', 'theme', 'adv_checkbox' ) ) ) {
            $attrs .= ' data-toggle="' . esc_attr( json_encode( $field['toggle'] ) ) . '"';
        }

        if( isset( $field['hide'] ) && $file_name == 'select' ) {
            $attrs .= ' data-hide="' . esc_attr( json_encode( $field['hide'] ) ) . '"';
        }

        if( isset( $field['tab'] ) && $file_name == 'select' ) {
            $attrs .= ' data-tab="' . esc_attr( json_encode( $field['tab'] ) ) . '"';
        }

        include REVIEWX_PARTIALS_PATH . 'admin/field-display.php';
    }
    
    public function rx_assign_rating_old_comment( $post_id ) {

        $rating    = [];
        $criteria  = get_post_meta($post_id, '_rx_meta_review_criteria', true );
        $post_type = get_post_meta($post_id, '_rx_meta_custom_post_types', true );
        if( is_array($criteria) ) {
            foreach( $criteria as $key => $value ) {
                $rating[$key] = 5;
            }
        }        

        $args = array(
            'post_type'   => $post_type,
            'meta_query'  => array(
                array(
                    array(
                        'key'   => 'reviewx_rating',
                        'compare' => 'NOT EXISTS'
                    ),
                ),
            ),                   
        );

        $comments = get_comments( $args );
        update_option('check_cron_data', $comments);
        foreach( $comments as $comment ) {
            update_comment_meta( $comment->comment_ID, 'reviewx_rating',  $rating );
            update_comment_meta( $comment->comment_ID, 'rating', 5 );
            update_comment_meta( $comment->comment_ID, 'reviewx_recommended', 1 );            
        }  

    }

    /**
     * @return array
     */
    public static function get_general_settings_args()
    {
        if( ! function_exists( 'reviewx_general_settings_args' ) ) {
            require_once REVIEWX_INCLUDE_PATH . 'admin/general-builder-helper.php';
        }

        do_action( 'rx_general_settings_args' );
        return reviewx_general_settings_args();
    }    


}