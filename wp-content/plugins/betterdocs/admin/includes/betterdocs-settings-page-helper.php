<?php
/**
 * Get all pages
 */
function betterdocs_get_pages() {
    $pages = [];
    $_pages = get_posts(array(
        'post_type' => 'page',
        'numberposts' => -1,
        'post_status' => 'publish',
        'posts_per_page' => -1
    ));

    if( ! empty( $_pages ) ) {
        $pages[0] = 'Select a Page';
        foreach( $_pages as $page ) {
            $pages[ $page->ID ] = $page->post_title;
        }
    }

    return $pages;
}
function betterdocs_settings_args(){
    $query['autofocus[panel]'] = 'betterdocs_customize_options';
    $query['return'] = admin_url( 'edit.php?post_type=docs' );
    $builtin_doc_page = BetterDocs_DB::get_settings('builtin_doc_page');
    $docs_slug = BetterDocs_DB::get_settings('docs_slug');
    $docs_page = BetterDocs_DB::get_settings('docs_page');
    if ( $builtin_doc_page == 1 && $docs_slug ) {
        $query['url'] = site_url( '/'.$docs_slug );
    } elseif ( $builtin_doc_page != 1 && $docs_page ) {
        $post_info = get_post( $docs_page );
        $query['url'] = site_url( '/'.$post_info->post_name );
    }
    $customizer_link = add_query_arg( $query, admin_url( 'customize.php' ) );
    return apply_filters('betterdocs_settings_tab', array(
        'general' => array(
            'title' => __( 'General', 'betterdocs' ),
            'priority' => 10,
            'button_text' => __( 'Save Settings' ),
            'sections' => apply_filters('betterdocs_general_settings_sections', array(
                'general_settings' => apply_filters('betterdocs_general_settings', array(
                    'title' => __( 'General Settings', 'betterdocs' ),
                    'priority' => 10,
                    'fields' => array(
                        'multiple_kb' => apply_filters( 'betterdocs_multi_kb_settings', array(
                            'type'        => 'checkbox',
                            'label'       => __('Enable Multiple Knowledge Base' , 'betterdocs'),
                            'default'     => '',
                            'priority'    => 10,
                            'disable' => true,
                        )),
                        'builtin_doc_page' => array(
                            'type'        => 'checkbox',
                            'label'       => __('Enable Built-in Documentation Page' , 'betterdocs'),
                            'default'     => 1,
                            'priority'    => 10,
                            'help'        => __('<strong>Note:</strong> if you disable built-in documentation page, you can use shortcode or page builder widgets to design your documentation page.' , 'betterdocs'),
                            'dependency' => array(
                                1 => array(
                                    'fields' => array( 'docs_slug' ),
                                ),
                                0 => array(
                                    'fields' => array( 'docs_page' ),
                                ),
                            ),
                        ),
                        'breadcrumb_doc_title' => array(
                            'type'      => 'text',
                            'label'     => __('Documentation Page Title' , 'betterdocs'),
                            'default'   => 'Docs',
                            'priority'	=> 10,
                        ),
                        'docs_slug' => array(
                            'type'      => 'text',
                            'label'     => __('BetterDocs Root Slug' , 'betterdocs'),
                            'default'   => 'docs',
                            'priority'	=> 10
                        ),
                        'docs_page' => array(
                            'label' => __( 'Docs Page', 'betterdocs' ),
                            'type'     => 'select',
                            'priority' => 10,
                            'options'  => betterdocs_get_pages(),
                            'help'  => __('Note: You will need to insert BetterDocs Shortcode inside the page. This page will be used as docs permalink.' , 'betterdocs'),
                        ),
                        'category_slug' => array(
                            'type'      => 'text',
                            'label'     => __('Custom Category Slug' , 'betterdocs'),
                            'default'   => 'docs-category',
                            'priority'	=> 10
                        ),
                        'tag_slug' => array(
                            'type'      => 'text',
                            'label'     => __('Custom Tag Slug' , 'betterdocs'),
                            'default'   => 'docs-tag',
                            'priority'	=> 10
                        ),
                        'permalink_structure' => array(
                            'type'     => 'text',
                            'label'    => __( 'Doc Permalink', 'betterdocs' ),
                            'default'  => apply_filters("betterdocs_doc_permalink_default", BetterDocs_Docs_Post_Type::$docs_slug),
                            'priority' => 10,
                            'help'     => betterdocs_permalink_structure_tags(),
                        ),
                    ),
                )),
                
            )),
        ),
        'layout' => array(
            'title' => __( 'Layout', 'betterdocs' ),
            'priority' => 10,
            'button_text' => __( 'Save Settings' ),
            'sections' => apply_filters('betterdocs_layout_settings_sections', array(
                
                'layout_inner_tab' => array(
                    'title' => __( 'Layout Tab' ),
                    'tabs' => array(
                        'documentation_page' => apply_filters('betterdocs_layout_documentation_page_settings', array(
                            'title' => __( 'Documentation Page', 'betterdocs' ),
                            'priority' => 10,
                            'fields' => array(
                                'doc_page' => array(
                                    'type'        => 'title',
                                    'label'       => __('Documentation Page' , 'betterdocs'),
                                    'priority'    => 10,
                                ),
                                'live_search' => array(
                                    'type'        => 'checkbox',
                                    'label'       => __('Enable Live Search' , 'betterdocs'),
                                    'default'     => 1,
                                    'priority'    => 10,
                                ),
                                'search_placeholder' => array(
                                    'type'        => 'text',
                                    'label'       => __('Search Placeholder' , 'betterdocs'),
                                    'default'     => 'Search..',
                                    'priority'    => 10,
                                ),
                                'search_not_found_text' => array(
                                    'type'        => 'text',
                                    'label'       => __('Search Not Found Text' , 'betterdocs'),
                                    'default'     => 'Sorry, no docs were found.',
                                    'priority'    => 10,
                                ),
                                'search_result_image' => array(
                                    'type'        => 'checkbox',
                                    'label'       => __('Search Result Image' , 'betterdocs'),
                                    'default'     => 1,
                                    'priority'    => 10,
                                ),
                                'kb_based_search' => apply_filters( 'betterdocs_kb_based_search_settings', array(
                                    'type'        => 'checkbox',
                                    'label'       => __('Search Result based on KB' , 'betterdocs'),
                                    'default'     => '',
                                    'priority'    => 10,
                                    'disable' => true,
                                )),
                                'masonry_layout' => array(
                                    'type'        => 'checkbox',
                                    'label'       => __('Enable Masonry' , 'betterdocs'),
                                    'default'     => 1,
                                    'priority'    => 10,
                                ),
                                'alphabetically_order_post' => array(
                                    'type'        => 'select',
                                    'label'       => __('Docs Order By' , 'betterdocs'),
                                    'default'     =>  apply_filters('betterdocs_post_order_default', 'none'),
                                    'options'     =>  apply_filters('betterdocs_post_order_options', array(
                                        'none'      => __('No order', 'betterdocs'),
                                        'ID'        => __('Post ID', 'betterdocs'),
                                        'author'    => __('Post Author', 'betterdocs'),
                                        '1'     => __('Title', 'betterdocs'), // value is 1 to cope up with existing user data
                                        'date'      => __('Date', 'betterdocs'),
                                        'modified'  => __('Last Modified Date', 'betterdocs'),
                                        'parent'    => __('Parent Id', 'betterdocs'),
                                        'rand'      => __('Random', 'betterdocs'),
                                        'comment_count' => __('Comment Count', 'betterdocs'),
                                        'menu_order'    => __('Menu Order', 'betterdocs')
                                    )),
                                    'priority'    => 10,
                                ),
                                'docs_order' => array(
                                    'type'        => 'select',
                                    'label'       => __('Docs Order' , 'betterdocs'),
                                    'default'     => 'ASC',
                                    'options' => [
                                        'ASC' => 'Ascending',
                                        'DESC' => 'Descending',
                                    ],
                                    'priority'    => 10,
                                ),
                                'alphabetically_order_term' => array(
                                    'type'        => 'checkbox',
                                    'label'       => __('Order Category Alphabetically' , 'betterdocs'),
                                    'default'     => '',
                                    'priority'    => 10,
                                ),
                                'nested_subcategory' => array(
                                    'type'        => 'checkbox',
                                    'label'       => __('Nested Subcategory' , 'betterdocs'),
                                    'default'     => '',
                                    'priority'    => 10,
                                ),
                                'column_number' => array(
                                    'type'      => 'number',
                                    'label'     => __('Number of Columns' , 'betterdocs'),
                                    'default'   => 3,
                                    'priority'	=> 10
                                ),
                                'posts_number' => array(
                                    'type'      => 'number',
                                    'label'     => __('Number of Posts' , 'betterdocs'),
                                    'default'   => 10,
                                    'priority'	=> 10
                                ),
                                'post_count' => array(
                                    'type'        => 'checkbox',
                                    'label'       => __('Enable Post Count' , 'betterdocs'),
                                    'default'     => 1,
                                    'priority'    => 10,
                                ),
                                'count_text' => array(
                                    'type'        => 'text',
                                    'label'       => __('Count Text' , 'betterdocs'),
                                    'default'     => __('articles' , 'betterdocs'),
                                    'priority'    => 10,
                                ),
                                'count_text_singular' => array(
                                    'type'        => 'text',
                                    'label'       => __('Count Text Singular' , 'betterdocs'),
                                    'default'     => __('article' , 'betterdocs'),
                                    'priority'    => 10,
                                ),
                                'exploremore_btn' => array(
                                    'type'      => 'checkbox',
                                    'label'     => __('Enable Explore More Button' , 'betterdocs'),
                                    'default'   => 1,
                                    'priority'	=> 10,
                                    'dependency'  => array(
                                        1 => array(
                                            'fields' => array( 'exploremore_btn_txt' )
                                        )
                                    ),
                                    'hide'  => array(
                                        0 => array(
                                            'fields' => array( 'exploremore_btn_txt' )
                                        )
                                    )
                                ),
                                'exploremore_btn_txt' => array(
                                    'type'      => 'text',
                                    'label'     => __('Button Text' , 'betterdocs'),
                                    'default'   => __('Explore More' , 'betterdocs'),
                                    'priority'	=> 10
                                ),
                            ),
                        )),
                        'single_doc' => apply_filters('betterdocs_layout_single_doc_settings', array(
                            'title' => __( 'Single Doc', 'betterdocs' ),
                            'priority' => 10,
                            'fields' => array(
                                'doc_single' => array(
                                    'type'        => 'title',
                                    'label'       => __('Single Doc' , 'betterdocs'),
                                    'priority'    => 10,
                                ),
                                'enable_toc' => array(
                                    'type'      => 'checkbox',
                                    'label'     => __('Enable Table of Contents (TOC)' , 'betterdocs'),
                                    'default'   => 1,
                                    'priority'	=> 10,
                                    'dependency'  => array(
                                        1 => array(
                                            'fields' => array( 'toc_title', 'enable_sticky_toc', 'toc_hierarchy', 'supported_heading_tag', 'toc_list_number' )
                                        )
                                    ),
                                    'hide'  => array(
                                        0 => array(
                                            'fields' => array( 'enable_sticky_toc', 'toc_hierarchy', 'supported_heading_tag' )
                                        )
                                    )
                                ),
                                'toc_title' => array(
                                    'type'      => 'text',
                                    'label'     => __('TOC Title' , 'betterdocs'),
                                    'default'   => __('Table of Contents' , 'betterdocs'),
                                    'priority'	=> 10,

                                ),
                                'toc_hierarchy' => array(
                                    'type'      => 'checkbox',
                                    'label'     => __('TOC Hierarchy' , 'betterdocs'),
                                    'default'   => 1,
                                    'priority'	=> 10
                                ),
                                'toc_list_number' => array(
                                    'type'      => 'checkbox',
                                    'label'     => __('TOC List Number' , 'betterdocs'),
                                    'default'   => 1,
                                    'priority'	=> 10
                                ),
                                'enable_sticky_toc' => array(
                                    'type'      => 'checkbox',
                                    'label'     => __('Enable Sticky TOC' , 'betterdocs'),
                                    'default'   => 1,
                                    'priority'	=> 10
                                ),
                                'sticky_toc_offset' => array(
                                    'type'      => 'number',
                                    'label'     => __('Content Offset' , 'betterdocs'),
                                    'default'   => 100,
                                    'priority'	=> 10,
                                    'description' => __('content offset from top on scroll.' , 'betterdocs'),
                                ),
                                'collapsible_toc_mobile' => array(
                                    'type'      => 'checkbox',
                                    'label'     => __('Collapsible TOC on small devices' , 'betterdocs'),
                                    'default'   => '',
                                    'priority'	=> 10
                                ),
                                'supported_heading_tag' => array(
                                    'label' => __( 'TOC Supported Heading Tag', 'betterdocs' ),
                                    'type'     => 'multi_checkbox',
                                    'priority' => 10,
                                    'default'  => array(1,2,3,4,5,6),
                                    'options'  => array(
                                        '1' => 'h1',
                                        '2' => 'h2',
                                        '3' => 'h3',
                                        '4' => 'h4',
                                        '5' => 'h5',
                                        '6' => 'h6'
                                    ),
                                ),
                                'enable_post_title' => array(
                                    'type'      => 'checkbox',
                                    'label'     => __('Enable Post Title' , 'betterdocs'),
                                    'default'   => 1,
                                    'priority'	=> 10
                                ),
                                'title_link_ctc' => array(
                                    'type'      => 'checkbox',
                                    'label'     => __('Title Link Copy To Clipboard' , 'betterdocs'),
                                    'default'   => 1,
                                    'priority'	=> 10
                                ),
                                'enable_breadcrumb' => array(
                                    'type'      => 'checkbox',
                                    'label'     => __('Enable Breadcrumb' , 'betterdocs'),
                                    'default'   => 1,
                                    'priority'	=> 10,
                                    'dependency'  => array(
                                        1 => array(
                                            'fields' => array('breadcrumb_home_text', 'breadcrumb_home_url', 'enable_breadcrumb_category', 'enable_breadcrumb_title')
                                        )
                                    ),
                                    'hide'  => array(
                                        0 => array(
                                            'fields' => array('breadcrumb_home_text', 'breadcrumb_home_url', 'enable_breadcrumb_category', 'enable_breadcrumb_title')
                                        )
                                    )
                                ),
                                'breadcrumb_home_text' => array(
                                    'type'      => 'text',
                                    'label'     => __('Breadcrumb Home Text' , 'betterdocs'),
                                    'default'   => __('Home' , 'betterdocs'),
                                    'priority'	=> 10,
                                    
                                ),
                                'breadcrumb_home_url' => array(
                                    'type'      => 'text',
                                    'label'     => __('Breadcrumb Home URL' , 'betterdocs'),
                                    'priority'	=> 10,
                                    'default'	=> get_home_url(),
                                ),
                                'enable_breadcrumb_category' => array(
                                    'type'      => 'checkbox',
                                    'label'     => __('Enable Category on Breadcrumb' , 'betterdocs'),
                                    'default'   => 1,
                                    'priority'	=> 10
                                ),
                                'enable_breadcrumb_title' => array(
                                    'type'      => 'checkbox',
                                    'label'     => __('Enable Title on Breadcrumb' , 'betterdocs'),
                                    'default'   => 1,
                                    'priority'	=> 10
                                ),
                                'enable_sidebar_cat_list' => array(
                                    'type'      => 'checkbox',
                                    'label'     => __('Enable Sidebar Category List' , 'betterdocs'),
                                    'default'   => 1,
                                    'priority'	=> 10
                                ),
                                'enable_print_icon' => array(
                                    'type'      => 'checkbox',
                                    'label'     => __('Enable Print Icon' , 'betterdocs'),
                                    'default'   => 1,
                                    'priority'	=> 10
                                ),
                                'enable_tags' => array(
                                    'type'      => 'checkbox',
                                    'label'     => __('Enable Tags' , 'betterdocs'),
                                    'default'   => 1,
                                    'priority'	=> 10
                                ),
                                'email_feedback' => array(
                                    'type'        => 'checkbox',
                                    'label'       => __('Enable Email Feedback' , 'betterdocs'),
                                    'default'     => 1,
                                    'priority'    => 10,
                                    'dependency'  => array(
                                        1 => array(
                                            'fields' => array( 'email_address', 'feedback_link_text', 'feedback_form_title' )
                                        )
                                    ),
                                    'hide'  => array(
                                        0 => array(
                                            'fields' => array( 'email_address', 'feedback_link_text', 'feedback_form_title' )
                                        )
                                    )
                                ),
                                'feedback_link_text' => array(
                                    'type'      => 'text',
                                    'label'     => __('Feedback Link Text' , 'betterdocs'),
                                    'default'   => esc_html__('Still stuck? How can we help?','betterdocs'),
                                    'priority'	=> 10
                                ),
                                'feedback_form_title' => array(
                                    'type'      => 'text',
                                    'label'     => __('Feedback Form Title' , 'betterdocs'),
                                    'default'   => esc_html__('How can we help?','betterdocs'),
                                    'priority'	=> 10
                                ),
                                'email_address' => array(
                                    'type'      => 'text',
                                    'label'     => __('Email Address' , 'betterdocs'),
                                    'default'   => get_option('admin_email'),
                                    'priority'	=> 10,
                                    'description' => __('The email address where the Feedback from will be sent' , 'betterdocs'),
                                ),
                                'show_last_update_time' => array(
                                    'type'      => 'checkbox',
                                    'label'     => __('Show Last Update Time' , 'betterdocs'),
                                    'default'   => 1,
                                    'priority'	=> 10
                                ),
                                'enable_navigation' => array(
                                    'type'      => 'checkbox',
                                    'label'     => __('Enable Navigation' , 'betterdocs'),
                                    'default'   => 1,
                                    'priority'	=> 10
                                ),
                                'enable_comment' => array(
                                    'type'      => 'checkbox',
                                    'label'     => __('Enable Comment' , 'betterdocs'),
                                    'default'   => '',
                                    'priority'	=> 10
                                ),
                                'enable_credit' => array(
                                    'type'      => 'checkbox',
                                    'label'     => __('Enable Credit' , 'betterdocs'),
                                    'default'   => 1,
                                    'priority'	=> 10
                                ),
                            ),
                        )),
                        'archive_page' => apply_filters('betterdocs_layout_archive_page_settings', array(
                            'title' => __( 'Archive Page', 'betterdocs' ),
                            'priority' => 10,
                            'fields' => array(
                                'archive_page_title' => array(
                                    'type'        => 'title',
                                    'label'       => __('Archive Page' , 'betterdocs'),
                                    'priority'    => 10,
                                ),
                                'enable_archive_sidebar' => array(
                                    'type'      => 'checkbox',
                                    'label'     => __('Enable Sidebar Category List' , 'betterdocs'),
                                    'default'   => 1,
                                    'priority'	=> 10,
                                ),
                                'archive_nested_subcategory' => array(
                                    'type'        => 'checkbox',
                                    'label'       => __('Nested Subcategory' , 'betterdocs'),
                                    'default'     => 1,
                                    'priority'    => 10,
                                ),
                            ),
                        )),
                    )
                )
                
            )),
        ),
        'design' => array(
            'title' => __( 'Design', 'betterdocs' ),
            'priority' => 10,
            'sections' => apply_filters('betterdocs_design_settings_sections', array(
                'design_settings' => apply_filters('betterdocs_design_settings', array(
                    'title' => __( 'Documentation Page', 'betterdocs' ),
                    'priority' => 10,
                    'fields' => array(
                        'customizer_link' => array(
                            'type'      => 'card',
                            'label'     => __('Customize BetterDocs','betterdocs'),
                            'url'   => esc_url($customizer_link),
                            'priority'	=> 10
                        ),
                    ),
                )), 
            )),
        ),
        'shortcodes' => array(
            'title' => __( 'Shortcodes', 'betterdocs' ),
            'priority' => 10,
            'sections' => apply_filters('betterdocs_shortcodes_settings_sections', array(
                'shortcodes_settings' => apply_filters('betterdocs_shortcodes_settings', array(
                    'title' => __( 'Shortcodes', 'betterdocs' ),
                    'priority' => 10,
                    'fields' => apply_filters('betterdocs_shortcode_fields', array(
                        'search_form' => array(
                            'type'      => 'text',
                            'label'     => __('Search Form' , 'betterdocs'),
                            'default'   => '[betterdocs_search_form]',
                            'readonly'	=> true,
                            'priority'	=> 10
                        ),
                        'feedback_form' => array(
                            'type'      => 'text',
                            'label'     => __('Feedback Form' , 'betterdocs'),
                            'default'   => '[betterdocs_feedback_form]',
                            'readonly'	=> true,
                            'priority'	=> 10
                        ),
                        'category_grid' => array(
                            'type'      => 'text',
                            'label'     => __('Category Grid- Layout 1' , 'betterdocs'),
                            'default'   => '[betterdocs_category_grid]',
                            'readonly'	=> true,
                            'priority'	=> 10,
                            'help'        => __('<strong>You can use:</strong> [betterdocs_category_grid post_counter="true" icon="true" masonry="true" column="3" posts_per_grid="5" nested_subcategory="true" terms="term_ID, term_ID" kb_slug=""]' , 'betterdocs'),
                        ),
                        'category_box' => array(
                            'type'      => 'text',
                            'label'     => __('Category Box- Layout 2' , 'betterdocs'),
                            'default'   => '[betterdocs_category_box]',
                            'readonly'	=> true,
                            'priority'	=> 10,
                            'help'      => __('<strong>You can use:</strong> [betterdocs_category_box column="3" terms="term_ID, term_ID"]' , 'betterdocs'),
                        ),
                        'category_list' => array(
                            'type'      => 'text',
                            'label'     => __('Category List' , 'betterdocs'),
                            'default'   => '[betterdocs_category_list]',
                            'readonly'	=> true,
                            'priority'	=> 10,
                            'help'      => __('<strong>You can use:</strong> [betterdocs_category_list terms="term_ID, term_ID"]' , 'betterdocs'),
                        ),
                    )),
                )), 
            )),
        ),
        'betterdocs_advanced_settings' => array(
            'title'       => __( 'Advanced Settings', 'betterdocs' ),
            'priority'    => 20,
            'button_text' => __( 'Save Settings' ),
            'sections' => apply_filters( 'betterdocs_advanced_settings_sections', array(
                'role_management_section' => array(
                    'title' => __('Role Management', 'betterdocs'),
                    'priority'    => 0,
                    'fields' => array(
                        'rms_title' => array(
                            'type'        => 'title',
                            'label'       => __('Role Management', 'betterdocs'),
                            'priority'    => 0,
                        ),
                        'article_roles' => array(
                            'type'        => 'select',
                            'label'       => __('Who Can Write Docs?', 'betterdocs'),
                            'priority'    => 1,
                            'multiple' => true,
                            'disable' => true,
                            'default' => 'administrator',
                            'options' => BetterDocs_Settings::get_roles()
                        ),
                        'settings_roles' => array(
                            'type'        => 'select',
                            'label'       => __('Who Can Edit Settings?', 'betterdocs'),
                            'priority'    => 1,
                            'multiple' => true,
                            'disable' => true,
                            'default' => 'administrator',
                            'options' => BetterDocs_Settings::get_roles()
                        ),
                        'analytics_roles' => array(
                            'type'        => 'select',
                            'label'       => __('Who Can Check Analytics?', 'betterdocs'),
                            'priority'    => 1,
                            'multiple'    => true,
                            'disable'     => true,
                            'default'     => 'administrator',
                            'options'     => BetterDocs_Settings::get_roles()
                        ),
                    )
                ),
                'internal_kb_section' => array(
                    'title' => __('Internal Knowledge Base', 'betterdocs'),
                    'priority'    => 0,
                    'fields' => array(
                        'content_restriction_title' => array(
                            'type'        => 'title',
                            'label'       => __('Internal Knowledge Base', 'betterdocs'),
                            'priority'    => 0,
                        ),
                        'enable_content_restriction_free' => array(
                            'type'      => 'checkbox',
                            'priority'  => 1,
                            'disable' => true,
                            'label'     => __( 'Enable/Disable', 'betterdocs' ),
                            'default'   => '',
                            'dependency' => array(
                                1 => array(
                                    'fields' => array( 'content_visibility', 'restrict_template', 'restrict_kb', 'restrict_category', 'restricted_redirect_url' ),
                                )
                            )
                        ),
                    )
                )
            ))
        ),
        'betterdocs_instant_answer' => array(
            'title'       => __( 'Instant Answer', 'betterdocs' ),
            'priority'    => 20,
            'pro'     => true,
            'sections'    => array(
                'enable_instant_answer' => array(
                    'title' => __('Enable/Disable Instant Answer', 'betterdocs-pro'),
                    'priority'    => 0,
                    'fields' => array(
                        'ia_title' => array(
                            'type'        => 'title',
                            'label'       => __('Enable/Disable Instant Answer' , 'betterdocs-pro'),
                            'priority'    => 0,
                        ),
                        'ia_description' => array(
                            'type' => 'html',
                            'priority' => 1,
                            'html' => __( 'Display a list of articles or categories in a chat-like widget to give your visitors a chance of self-learning about your website.', 'betterdocs-pro' )
                        ),
                        'enable_disable_free' => array(
                            'type' => 'checkbox',
                            'priority' => 2,
                            'label'    => __( 'Enable/Disable', 'betterdocs-pro' ),
                            'default' => '',
                            'disable' => true,
                        ),
                        'ia_enable_preview_free' => array(
                            'type'        => 'checkbox',
                            'label'       => __('Enable IA Live Preview' , 'betterdocs-pro'),
                            'priority'    => 3,
                            'default' => '',
                            'disable' => true,
                        ),
                        'ia_image' => array(
                            'type'        => 'image',
                            'url'       => BETTERDOCS_ADMIN_URL . 'assets/img/ia-preview.gif',
                            'priority'    => 3
                        ),
                    )
                ),
            )
        )
    ));
}

/**
 * Undocumented function
 *
 * @return string
 */
function betterdocs_permalink_structure_tags(){
    $tags = apply_filters("betterdocs_doc_permalink_tags", [
            '%doc_category%' => [
                'class'      => '',
                'aria-label' => __( 'Docs Categories', 'betterdocs' ),
                'data-added' => __( 'doc_category added to permalink structure', 'betterdocs' ),
                'data-used'  => __( 'doc_category (already used in permalink structure)', 'betterdocs' ),
            ],
        ]);

    $return = __( "<b>Available tags:</b>", 'betterdocs' );
    $return .= "
        <div class='form-table permalink-structure'>
            <div class='available-structure-tags hide-if-no-js'>
                <div id='custom_selection_updated' aria-live='assertive' class='screen-reader-text'></div>
                <ul role='list'>
    ";

    foreach($tags as $tag => $args){
        $return .= "
            <li class='{$args['class']}'>
                <button type='button' class='button button-secondary' aria-label='{$args['aria-label']}' data-added='{$args['data-added']}' data-used='{$args['data-used']}'>$tag</button>
            </li>
        ";
    }

    $return .= "
                </ul>
            </div>
        </div>
    ";
    return $return;
}