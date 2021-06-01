<?php
/**
 * This class responsible for database work
 * using wordpress functionality 
 * get_option and update_option.
 */
class BetterDocs_DB {
    /**
     * Get all default settings value.
     *
     * @param string $name
     * @return array
     */
    public static function default_settings(){
        return apply_filters('betterdocs_option_default_settings', array(
            'builtin_doc_page' => 1,
            'docs_slug' => 'docs',
            'doc_page' => '',
            'category_slug' => 'docs-category',
            'tag_slug' => 'docs-tag',
            'live_search' => 1,
            'search_placeholder' => esc_html__('Search..', 'betterdocs'),
            'search_not_found_text' => esc_html__('Sorry, no docs were found.', 'betterdocs'),
            'search_result_image' => 1,
            'masonry_layout' => 1,
            'alphabetically_order_post' => '',
            'alphabetically_order_term' => '',
            'nested_subcategory' => '',
            'column_number' => 3,
            'posts_number' => 10,
            'post_count' => 1,
            'count_text_singular' => esc_html__('article', 'betterdocs'),
            'count_text' => esc_html__('articles', 'betterdocs'),
            'exploremore_btn' => 1,
            'exploremore_btn_txt' => esc_html__('Explore More', 'betterdocs'),
            'doc_single' => 1,
            'enable_toc' => 1,
            'toc_title' => esc_html__('Table of Contents', 'betterdocs'),
            'toc_hierarchy' => 1,
            'toc_list_number' => 1,
            'enable_sticky_toc' => 1,
            'sticky_toc_offset' => 100,
            'collapsible_toc_mobile' => '',
            'enable_post_title' => 1,
            'title_link_ctc' => 1,
            'enable_breadcrumb' => 1,
            'breadcrumb_doc_title' => esc_html__('Docs', 'betterdocs'),
            'breadcrumb_home_text' => esc_html__('Home', 'betterdocs'),
            'breadcrumb_home_url' => get_home_url(),
            'enable_breadcrumb_category' => 1,
            'enable_breadcrumb_title' => 1,
            'enable_sidebar_cat_list' => 1,
            'enable_print_icon' => 1,
            'enable_tags' => 1,
            'email_feedback' => 1,
            'feedback_link_text' => esc_html__('Still stuck? How can we help?', 'betterdocs'),
            'feedback_form_title' => esc_html__('How can we help?', 'betterdocs'),
            'email_address' => get_option('admin_email'),
            'enable_navigation' => 1,
            'show_last_update_time' => 1,
            'enable_comment' => 1,
            'enable_credit' => 1,
            'enable_archive_sidebar' => 1,
            'archive_nested_subcategory' => 1,
            'customizer_link' => '',
            'category_grid' => '[betterdocs_category_grid]',
            'category_box' => '[betterdocs_category_box]',
            'search_form' => '[betterdocs_search_form]',
            'feedback_form' => '[betterdocs_feedback_form]',
            'supported_heading_tag' => array( 1,2,3,4,5,6 ),
            'display_ia_pages' => array('all'),
            'display_ia_archives' => array('all'),
            'display_ia_texonomy' => array('all'),
            'display_ia_single' => array('all'),
            'enable_content_restriction' => '',
            'restrict_template' => array('all'),
            'restrict_category' => array('all'),
            'restrict_kb' => array('all')
        ));
    }
    /**
     * Get all settings value from options table.
     *
     * @param string $name
     * @return array
     */
    public static function get_settings( $name = '' ){
        $settings = get_option( 'betterdocs_settings', true );
        $default = self::default_settings();
        if( ! empty( $name ) && isset( $settings[ $name ] ) ) {
            return $settings[ $name ];
        }
        
        if( ! empty( $name ) && ! isset( $settings[ $name ] ) && isset( $default[ $name ] ) ) {
            return $default[ $name ];
        }
        
        if( ! empty( $name ) && ! isset( $settings[ $name ] )  && ! isset( $default[ $name ] ) ) {
            return '';
        }

        return is_array( $settings ) ? $settings : [];
    }
    /**
     * Update settings 
     * @param array $value
     * @return boolean
     */
    public static function update_settings( $value, $key = '' ){
        if( ! empty( $key ) ) {
            return update_option( $key, $value );
        }
        return update_option( 'betterdocs_settings', $value );
    }
}