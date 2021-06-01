<?php
/**
 * This class will provide all kind of helper methods.
 */
class BetterDocs_Helper
{
    /**
     * This function is responsible for the data sanitization
     *
     * @param array $field
     * @param string|array $value
     * @return string|array
     */
    public static function sanitize_field($field, $value)
    {
        if (isset($field['sanitize']) && !empty($field['sanitize'])) {
            if (function_exists($field['sanitize'])) {
                $value = call_user_func($field['sanitize'], $value);
            }
            return $value;
        }

        if (is_array($field) && isset($field['type'])) {
            switch ($field['type']) {
                case 'text':
                    $value = sanitize_text_field($value);
                    break;
                case 'textarea':
                    $value = sanitize_textarea_field($value);
                    break;
                case 'email':
                    $value = sanitize_email($value);
                    break;
                default:
                    return $value;
                    break;
            }
        } else {
            $value = sanitize_text_field($value);
        }

        return $value;
    }

    /**
     * This function is responsible for making an array sort by their key
     * @param array $data
     * @param string $using
     * @param string $way
     * @return array
     */
    public static function sorter($data, $using = 'time_date',  $way = 'DESC')
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
                if (!is_array($value)) continue;
                foreach ($value as $inner_key => $single) {
                    if ($inner_key == $using) {
                        $value['tempid'] = $key;
                        $single = self::numeric_key_gen($new_array, $single);
                        $new_array[$single] = $value;
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
                    $new_data[$index] = $array;
                }
                $data = $new_data;
            }
        }

        return $data;
    }

    /**
     * This function is responsible for generate unique numeric key for a given array.
     *
     * @param array $data
     * @param integer $index
     * @return integer
     */
    private static function numeric_key_gen($data, $index = 0)
    {
        if (isset($data[$index])) {
            $index += 1;
            return self::numeric_key_gen($data, $index);
        }
        return $index;
    }

    /**
     * Sorting Data 
     * by their type
     *
     * @param array $value
     * @param string $key
     * @return void
     */
    public static function sortBy(&$value, $key = 'comments')
    {
        switch ($key) {
            case 'comments':
                return self::sorter($value, 'key', 'DESC');
                break;
            default:
                return self::sorter($value, 'timestamp', 'DESC');
                break;
        }
    }

    /**
     * Human Readable Time Diff
     *
     * @param boolean $time
     * @return void
     */
    public static function get_timeago_html($time = false)
    {
        if (!$time) {
            return;
        }

        $offset = get_option('gmt_offset'); // Time offset in hours
        $local_time = $time + ($offset * 60 * 60); // added offset in seconds
        $time = human_time_diff($local_time, current_time('timestamp'));
        ob_start();
        echo '<small> ' . esc_html__('About', 'betterdocs') . ' ' . esc_html($time) . ' ' . esc_html__('ago', 'betterdocs') . ' </small>';
        $time_ago = ob_get_clean();
        return $time_ago;
    }

    /**
     * Get all post types
     *
     * @param array $exclude
     * @return void
     */
    public static function post_types($exclude = array())
    {
        $post_types = get_post_types(array(
            'public'    => true,
            'show_ui'    => true
        ), 'objects');

        unset($post_types['attachment']);

        if (count($exclude)) {
            foreach ($exclude as $type) {
                if (isset($post_types[$type])) {
                    unset($post_types[$type]);
                }
            }
        }

        return apply_filters('betterdocs_post_types', $post_types);
    }

    /**
     * Get all taxonomies
     *
     * @param string $post_type
     * @param array $exclude
     * @return void
     */
    public static function taxonomies($post_type = '', $exclude = array())
    {
        if (empty($post_type)) {
            $taxonomies = get_taxonomies(
                array(
                    'public'       => true,
                    '_builtin'     => false
                ),
                'objects'
            );
        } else {

            $taxonomies = get_object_taxonomies($post_type, 'objects');
        }

        $data = array();

        if (is_array($taxonomies)) {
            foreach ($taxonomies as $tax_slug => $tax) {
                if (!$tax->public || !$tax->show_ui) {
                    continue;
                }
                if (in_array($tax_slug, $exclude)) {
                    continue;
                }
                $data[$tax_slug] = $tax;
            }
        }

        return apply_filters('betterdocs_loop_taxonomies', $data, $taxonomies, $post_type);
    }

    public static function list_svg()
    {
        $html = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="0.86em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1536 1792"><path d="M1468 380q28 28 48 76t20 88v1152q0 40-28 68t-68 28H96q-40 0-68-28t-28-68V96q0-40 28-68T96 0h896q40 0 88 20t76 48zm-444-244v376h376q-10-29-22-41l-313-313q-12-12-41-22zm384 1528V640H992q-40 0-68-28t-28-68V128H128v1536h1280zM384 800q0-14 9-23t23-9h704q14 0 23 9t9 23v64q0 14-9 23t-23 9H416q-14 0-23-9t-9-23v-64zm736 224q14 0 23 9t9 23v64q0 14-9 23t-23 9H416q-14 0-23-9t-9-23v-64q0-14 9-23t23-9h704zm0 256q14 0 23 9t9 23v64q0 14-9 23t-23 9H416q-14 0-23-9t-9-23v-64q0-14 9-23t23-9h704z"/></svg>';
        return $html;
    }

    public static function arrow_right_svg()
    {
        $html = '<svg class="toggle-arrow arrow-right" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="0.48em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 608 1280"><g transform="translate(608 0) scale(-1 1)"><path d="M595 288q0 13-10 23L192 704l393 393q10 10 10 23t-10 23l-50 50q-10 10-23 10t-23-10L23 727q-10-10-10-23t10-23l466-466q10-10 23-10t23 10l50 50q10 10 10 23z"/></g></svg>';
        return $html;
    }

    public static function arrow_down_svg()
    {
        $html = '<svg class="toggle-arrow arrow-down" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="0.8em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1280"><path d="M1011 480q0 13-10 23L535 969q-10 10-23 10t-23-10L23 503q-10-10-10-23t10-23l50-50q10-10 23-10t23 10l393 393l393-393q10-10 23-10t23 10l50 50q10 10 10 23z"/></svg>';
        return $html;
    }

    public static function get_tax($tax = '')
    {
        global $wp_query;
        if (is_tax('knowledge_base')) {
            $get_tax = $wp_query->tax_query->queried_terms;
            if (array_key_exists("doc_category", $get_tax)) {
                $tax = 'doc_category';
            } else {
                $tax = 'knowledge_base';
            }
        } elseif (is_tax('doc_category')) {
            $tax = 'doc_category';
        }

        return $tax;
    }

    public static function list_query_arg($post_type, $multiple_kb, $tax_slug, $posts_per_grid, $orderby, $order = 'ASC', $kb_slug='')
    {
        $args = array(
            'post_type'   => $post_type
        );

        $tax_query = array(
            array(
                'taxonomy' => 'doc_category',
                'field'     => 'slug',
                'terms'    => $tax_slug,
                'operator' => 'AND',
                'include_children' => false
            ),
        );

        $args['tax_query'] = apply_filters('betterdocs_list_tax_query_arg', $tax_query, $multiple_kb, $tax_slug, $kb_slug);

        if ($posts_per_grid) {
            $args['posts_per_page'] = $posts_per_grid;
        }

        if ($orderby != 'betterdocs_order' || $orderby != 'none') {
            if ($orderby == '1') {
                $args['orderby'] = 'title';
            } else {
                $args['orderby'] = $orderby;
            }
            $args['order'] = $order;
        }
        return $args;
    }

    public static function count_kb()
    {
        $result = array();
        $kbs = get_terms(array(
            'taxonomy' => 'knowledge_base',
            'hide_empty' => false,
            'fields' => 'id=>slug'
        ));

        $cats = get_terms(array(
            'taxonomy' => 'doc_category',
            'hide_empty' => false,
            'fields' => 'id=>slug'
        ));

        foreach ($kbs as $kb) {
            foreach ($cats as $cat) {
                $args = array(
                    'post_type' => 'docs',
                    'post_status' => 'publish',
                    'tax_query' => array(
                        'relation' => 'AND',
                        array(
                            'taxonomy' => 'knowledge_base',
                            'field'    => 'slug',
                            'terms'    => array($kb),
                        ),
                        array(
                            'taxonomy' => 'doc_category',
                            'field'    => 'slug',
                            'terms'    => array($cat),
                        ),
                    ),
                );
                $query = new WP_Query($args);
                $result[$kb][$cat] = $query->post_count;
            }
        }
        return $result;
    }

    public static function count_category($kb_slug, $cat_slug)
    {
        $args = array(
            'post_type'   => 'docs',
            'post_status' => 'publish',
        );

        $taxes = array('knowledge_base', 'doc_category');
        foreach ($taxes as $tax) {
            $terms = get_terms($tax);

            foreach ($terms as $term)
                $tax_map[$tax][$term->slug] = $term->term_taxonomy_id;
        }

        $args['tax_query'] = array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'knowledge_base',
                'field' => 'term_taxonomy_id',
                'terms' => array($tax_map['knowledge_base'][$kb_slug]),
                'operator' => 'IN',
                'include_children'  => false,
            ),
            array(
                'taxonomy' => 'doc_category',
                'field' => 'term_taxonomy_id',
                'operator' => 'IN',
                'terms' => array($tax_map['doc_category'][$cat_slug]),
                'include_children'  => false,
            ),
        );

        $query = new WP_Query($args);
        $count = $query->found_posts;
        return $count;
    }

    public static function taxonomy_object($multiple_kb, $terms, $kb_slug='')
    {
        global $wp_query;
        $terms_object = array(
            'hide_empty' => true,
            'taxonomy' => 'doc_category',
            'orderby' => 'name',
            'parent' => 0
        );

        if ($wp_query->query === NULL || (isset($wp_query->query['post_type']) && $wp_query->query['post_type'] != 'docs')) {
            $terms_object['number'] = 4;
        }

        $meta_query = '';
        $terms_object['meta_query'] = apply_filters('betterdocs_taxonomy_object_meta_query', $meta_query, $multiple_kb, $kb_slug);

        if ($terms) {
            unset($terms_object['parent']);
        }

        if ($terms) {
            $terms_object['include'] = explode(',', $terms);
            $terms_object['orderby'] = 'include';
        }

        return get_terms($terms_object);
    }

    public static function child_taxonomy_terms($term_id, $multiple_kb, $orderby = "name", $order = "", $kb_slug = '')
    {
        global $wp_query;
        $terms_object = array(
            'parent' => $term_id
        );

        if ($orderby) {
            $terms_object['orderby'] = $orderby;
        }

        if ($order) {
            $terms_object['order'] = $order;
        }

        if ($wp_query->query === NULL || (isset($wp_query->query['post_type']) && $wp_query->query['post_type'] != 'docs')) {
            $terms_object['number'] = 1;
        }

        $meta_query = '';
        $terms_object['meta_query'] = apply_filters('betterdocs_child_taxonomy_meta_query', $meta_query, $multiple_kb, $kb_slug);
        return get_terms('doc_category', $terms_object);
    }

    public static function term_permalink($texanomy, $term_slug) {
        $get_term_link = get_term_link( $term_slug, $texanomy );
        return apply_filters( 'betterdocs_cat_term_permalink', $get_term_link, $term_slug, $texanomy );
    }

    public static function get_prev($array, $key) {
        $currentKey = array_search($key, $array);
        if ($currentKey > 0 || $currentKey != 0) {
            $nextKey = $currentKey - 1;
            $prev_post = $array[$nextKey];
            $nav = '<a rel="prev" class="next-post" href="'.get_post_permalink($prev_post).'"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="42px" viewBox="0 0 50 50" version="1.1"><g id="surface1"><path style=" " d="M 11.957031 13.988281 C 11.699219 14.003906 11.457031 14.117188 11.28125 14.308594 L 1.015625 25 L 11.28125 35.691406 C 11.527344 35.953125 11.894531 36.0625 12.242188 35.976563 C 12.589844 35.890625 12.867188 35.625 12.964844 35.28125 C 13.066406 34.933594 12.972656 34.5625 12.71875 34.308594 L 4.746094 26 L 48 26 C 48.359375 26.003906 48.695313 25.816406 48.878906 25.503906 C 49.058594 25.191406 49.058594 24.808594 48.878906 24.496094 C 48.695313 24.183594 48.359375 23.996094 48 24 L 4.746094 24 L 12.71875 15.691406 C 13.011719 15.398438 13.09375 14.957031 12.921875 14.582031 C 12.753906 14.203125 12.371094 13.96875 11.957031 13.988281 Z "></path></g></svg>'.get_the_title($prev_post).'</a>';
        } else {
            $nav = '';
        }
        return $nav;
    }

    public static function get_next($array, $key) {
        $currentKey = array_search($key, $array);
        if (end($array) != $array[$currentKey]) {
            $nextKey = $currentKey + 1;
            $next_post = $array[$nextKey];
            $nav = '<a rel="next" class="next-post" href="'.get_post_permalink($next_post).'">'.get_the_title($next_post).'<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="42px" viewBox="0 0 50 50" version="1.1"><g id="surface1"><path style=" " d="M 38.035156 13.988281 C 37.628906 13.980469 37.257813 14.222656 37.09375 14.59375 C 36.933594 14.96875 37.015625 15.402344 37.300781 15.691406 L 45.277344 24 L 2.023438 24 C 1.664063 23.996094 1.328125 24.183594 1.148438 24.496094 C 0.964844 24.808594 0.964844 25.191406 1.148438 25.503906 C 1.328125 25.816406 1.664063 26.003906 2.023438 26 L 45.277344 26 L 37.300781 34.308594 C 36.917969 34.707031 36.933594 35.339844 37.332031 35.722656 C 37.730469 36.105469 38.363281 36.09375 38.746094 35.691406 L 49.011719 25 L 38.746094 14.308594 C 38.5625 14.109375 38.304688 13.996094 38.035156 13.988281 Z "></path></g></svg></a>';
        } else {
            $nav = '';
        }
        return $nav;
    }

    public static function get_postcount($term, $multiple_kb, $total_term_count = 0)
    {
        $taxonomy = 'doc_category';
        $args = array(
            'child_of' => $term->term_id,
        );
        $tax_terms = get_terms($taxonomy, $args);

        if ($tax_terms) {
            foreach ($tax_terms as $tax_term) {
                $total_term_count += $tax_term->count;
            }
        }

        return apply_filters('betterdocs_postcount', $total_term_count, $multiple_kb, $term->term_id, $term->slug, $term->count);
    }

    const ALLOWED_HTML_TAGS = [
        'article',
        'aside',
        'div',
        'footer',
        'h1',
        'h2',
        'h3',
        'h4',
        'h5',
        'h6',
        'header',
        'main',
        'nav',
        'p',
        'section',
        'span',
    ];

    /**
     * validate_html_tag
     * @param $tag
     * @return mixed|string
     */
    public static function html_tag( $tag ){
        return in_array( strtolower( $tag ), self::ALLOWED_HTML_TAGS ) ? $tag : 'div';
    }

    public static function feedback_form(){
        $fform_title = BetterDocs_DB::get_settings('feedback_form_title');
        $output = betterdocs_generate_output();
        $html = '<'. $output['betterdocs_feedback_form_title_tag'] .' class="feedback-form-title">';
        $html .= ( $fform_title ) ? $fform_title : esc_html__( 'How can we help?', 'betterdocs' );
        $html .= '</'. $output['betterdocs_feedback_form_title_tag'] .'>';
        $html .= '<div class="modal-content-inner">';
        $html .= do_shortcode('[betterdocs_feedback_form]');
        $html .= '</div>';
        echo $html;
    }

    /**
     * return true if templates from BetterDocs to load assets
     */
    public static function is_templates() {
        if(is_plugin_active('elementor/elementor.php') && is_plugin_active('elementor-pro/elementor-pro.php')){
            $document = \Elementor\Plugin::$instance->documents->get( get_the_ID() );
            if (\Elementor\Plugin::instance()->editor->is_edit_mode() || (( get_post_meta(get_the_ID(), '_elementor_template_type', true)) && $document->is_built_with_elementor())) {
                return true;
            }
        }

        $tax = self::get_tax();
        if (is_post_type_archive('docs') || $tax === 'knowledge_base' || $tax === 'doc_category' || is_singular('docs')) {
            return true;
        }
        return false;
    }
}
