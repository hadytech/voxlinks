<?php
use Elementor\Controls_Manager;
use ElementorPro\Plugin;
use ElementorPro\Modules\ThemeBuilder as ThemeBuilder;

/**
 * Working with elementor plugin
 *
 *
 * @since      1.3.0
 * @package    BetterDocs
 * @subpackage BetterDocs/elementor
 * @author     WPDeveloper <support@wpdeveloper.net>
 */
class BetterDocs_Elementor
{
    public static $pro_active;

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.3.0
     */
    public static function init()
    {
        self::$pro_active = is_plugin_active('betterdocs-pro/betterdocs-pro.php');
        add_action('elementor/editor/before_enqueue_scripts', [__CLASS__, 'editor_enqueue_scripts']);
        if (is_plugin_active('betterdocs/betterdocs.php')) {
            add_action('elementor/documents/register', [__CLASS__, 'register_singel_documents_page']);
            add_action('elementor/documents/register', [__CLASS__, 'register_doc_category_archive']);
            add_filter('elementor/theme/need_override_location', [__CLASS__, 'theme_template_include'], 10, 2);
            add_action('elementor/widgets/widgets_registered', [__CLASS__, 'register_widgets']);
            add_action('betterdocs/elementor/widgets/query', [__CLASS__, 'betterdocs_query'], 10, 2);
            add_filter('elementor/editor/localize_settings', [__CLASS__, 'promote_pro_elements']);
            add_action('wp_enqueue_scripts', [__CLASS__, 'editor_load_asset']);
            if (is_plugin_active('elementor-pro/elementor-pro.php')) {
                add_action('elementor/init', [__CLASS__, 'load_widget_file']);
                add_action('elementor/theme/register_conditions', [__CLASS__, 'register_conditions']);
            }
        }

        add_action('init', [__CLASS__, '__betterdocs_init'], -999);
    }

    /**
     *
     * Mange all widget for single docs
     *
     * @return string[]
     * @since  1.3.0
     */
    public static function get_widget_list()
    {
        $widget_arr = [
            'betterdocs-elementor-breadcrumbs' => 'BetterDocs_Elementor_Breadcrumbs',
            'betterdocs-elementor-title'       => 'BetterDocs_Elementor_Title',
            'betterdocs-elementor-content'     => 'BetterDocs_Elementor_Content',
            'betterdocs-elementor-sidebar'     => 'BetterDocs_Elementor_Sidebar',
            'betterdocs-elementor-navigation'  => 'BetterDocs_Elementor_Navigation',
            'betterdocs-elementor-doc-share'   => 'BetterDocs_Elementor_Doc_Share',
            'betterdocs-elementor-feedback'    => 'BetterDocs_Elementor_Feedback',
            'betterdocs-elementor-doc-date'    => 'BetterDocs_Elementor_Doc_Date',
            'betterdocs-elementor-search-form' => 'BetterDocs_Elementor_Search_Form',
            'betterdocs-elementor-toc'         => 'BetterDocs_Elementor_Toc',
            'betterdocs-elementor-category-archive-list' => 'BetterDocs_Category_Archive_List',
            'betterdocs-elementor-category-grid' => 'BetterDocs_Elementor_Category_Grid',
            'betterdocs-elementor-category-box' => 'BetterDocs_Elementor_Category_Box'
        ];

        return $widget_arr;
    }

    /**
     *
     * Load asset for elementor icon
     *
     * @since  1.3.0
     */
    public static function editor_enqueue_scripts()
    {
        if (BetterDocs_Helper::is_templates() == true) {
            wp_enqueue_style(
                'betterdocs-el-icon',
                BETTERDOCS_ADMIN_URL . 'assets/css/betterdocs-el-icon.css',
                false,
                BETTERDOCS_VERSION
            );
        }
    }

    public static function editor_load_asset()
    {
        if (BetterDocs_Helper::is_templates() == true) {
            wp_enqueue_style(
                'betterdocs-el-edit',
                BETTERDOCS_ADMIN_URL . 'assets/css/betterdocs-el-edit.css',
                false,
                BETTERDOCS_VERSION
            );

            wp_enqueue_script(
                'betterdocs-el-promotion',
                BETTERDOCS_ADMIN_URL . 'assets/js/promotion.js',
                ['jquery'],
                BETTERDOCS_VERSION,
                true
            );

            if (!self::$pro_active) {
                wp_enqueue_script(
                    'betterdocs-el-editor',
                    BETTERDOCS_ADMIN_URL . 'assets/js/betterdocs-el-editor.js',
                    ['jquery'],
                    BETTERDOCS_VERSION,
                    true
                );
            }
        }
    }

    public static function load_widget_file()
    {
        require_once BETTERDOCS_DIR_PATH . 'includes/elementor/template-query.php';
        require_once BETTERDOCS_DIR_PATH . 'includes/elementor/betterdocs-single-docs.php';
        require_once BETTERDOCS_DIR_PATH . 'includes/elementor/betterdocs-doc-archive.php';
        require_once BETTERDOCS_DIR_PATH . 'includes/elementor/betterdocs-archive-condition.php';
        require_once BETTERDOCS_DIR_PATH . 'includes/elementor/docs-page.php';
        self::__register_tag();

        //load widget file
        foreach (self::get_widget_list() as $key => $value) {
            require_once BETTERDOCS_DIR_PATH . "includes/elementor/widgets/$key.php";
        }
    }

    public static function register_singel_documents_page($documents_manager)
    {
        if (class_exists('BetterDocs_Single_Docs')) {
            $documents_manager->register_document_type('docs', BetterDocs_Single_Docs::get_class_full_name());
        }
    }

    public static function register_doc_category_archive($documents_manager)
    {
        if (class_exists('Betterdocs_Doc_Archive')) {
            $documents_manager->register_document_type('doc-archive', Betterdocs_Doc_Archive::get_class_full_name());
        }
    }

    /**
     * @param Conditions_Manager $conditions_manager
     */
    public static function register_conditions($conditions_manager)
    {
        $betterdocs_condition = new Betterdocs_Archive_Condition();

        $conditions_manager->get_condition('general')->register_sub_condition($betterdocs_condition);
    }

    public static function theme_template_include($need_override_location, $location)
    {
        if (is_singular(['docs']) && 'single' === $location) {
            $need_override_location = true;
        }

        return $need_override_location;
    }

    public static function register_widgets($widgets_manager)
    {
        foreach (self::get_widget_list() as $value) {
            if (class_exists($value)) {
                $widgets_manager->register_widget_type(new $value);
            }
        }
    }

    public static function __register_tag()
    {
        require_once BETTERDOCS_DIR_PATH . 'includes/elementor/widgets/betterdocs-elementor-title-tag.php';

        $module = Plugin::elementor()->dynamic_tags;
        $module->register_tag(new BetterDocs_Elementor_Title_Tag());
    }

    public static function promote_pro_elements($config)
    {
        if (is_plugin_active('betterdocs-pro/betterdocs-pro.php')) {
            return $config;
        }

        $promotion_widgets = [];

        if (isset($config['promotionWidgets'])) {
            $promotion_widgets = $config['promotionWidgets'];
        }

        $combine_array = array_merge($promotion_widgets, [
            [
                'name'       => 'betterdocs-elementor-reactions',
                'title'      => __('Doc Reactions', 'betterdocs'),
                'icon'       => 'betterdocs-icon-Reactions',
                'categories' => '["betterdocs-elements"]',
            ],
            [
                'name'       => 'betterdocs-multiple-kb',
                'title'      => __('BetterDocs Multiple KB', 'betterdocs'),
                'icon'       => 'betterdocs-icon-category-box',
                'categories' => '["docs-archive"]',
            ],
        ]);

        $config['promotionWidgets'] = $combine_array;

        return $config;
    }

    public static function __betterdocs_init()
    {
        add_action('elementor/init', array(__CLASS__, 'register_bd_template_instance'), 20);
        if (defined('Elementor\Api::LIBRARY_OPTION_KEY')) {
            add_filter('option_' . Elementor\Api::LIBRARY_OPTION_KEY, array(__CLASS__, 'prepend_categories'));
        }
        add_action('elementor/ajax/register_actions', array(__CLASS__, 'modified_ajax_action'), 20);
    }

    public static function register_bd_template_instance()
    {
        require_once BETTERDOCS_DIR_PATH . 'includes/elementor/betterdocs-template-source.php';

        $elementor = Elementor\Plugin::instance();
        $elementor->templates_manager->register_source('BetterDocs_Template_Source');
    }

    public static function modified_ajax_action($ajax)
    {
        if (!isset($_REQUEST['actions'])) {
            return;
        }

        $actions = json_decode(stripslashes($_REQUEST['actions']), true);
        $data    = false;

        foreach ($actions as $id => $action_data) {
            if (!isset($action_data['get_template_data'])) {
                $data = $action_data;
            }
        }


        if (!$data) {
            return;
        }

        if (!isset($data['data'])) {
            return;
        }

        $data = $data['data'];

        if (empty($data['template_id'])) {
            return;
        }

        if (false === strpos($data['template_id'], 'betterdocs_')) {
            return;
        }
        $ajax->register_ajax_action('get_template_data', array(__CLASS__, 'get_bd_template_data'));
    }

    public static function prepend_categories($library_data)
    {
        $categories = self::get_template_categories();
        if (!empty($categories)) {
            $library_data['types_data']['block']['categories'] = array_merge($categories, $library_data['types_data']['block']['categories']);
        }
        return $library_data;
    }

    public static function get_template_categories()
    {
        return [
            'Single Docs', 'Docs Archive'
        ];
    }

    public static function get_bd_template_data($args)
    {
        $source = Elementor\Plugin::instance()->templates_manager->get_source('betterdocs-templates');

        return $source->get_data($args);
    }

    /**
     * Include a file with variables
     *
     * @param $file_path
     * @param $variables
     *
     * @return string
     * @since  4.2.2
     */
    public static function include_with_variable( $file_path, $variables = [])
    {
        if (file_exists($file_path)) {
            extract($variables);

            ob_start();

            include $file_path;

            return ob_get_clean();
        }

        return '';
    }

    /**
     * This function is responsible for counting doc post under a category.
     *
     * @param int $term_count
     * @param int $term_id
     * @return int $term_count;
     */
    public static function get_doc_post_count($term_count = 0, $term_id)
    {
        $tax_terms = get_terms('doc_category', ['child_of' => $term_id]);

        foreach ($tax_terms as $tax_term) {
            $term_count += $tax_term->count;
        }

        return $term_count;
    }

    public static function get_multiple_kb_terms($prettify = false, $term_id = true)
    {
        $args = [
            'taxonomy' => 'knowledge_base',
            'hide_empty' => true,
            'parent' => 0,
        ];

        $terms = get_terms($args);

        if (is_wp_error($terms)) {
            return [];
        }

        if ($prettify) {
            $pretty_taxonomies = [];

            foreach ($terms as $term) {
                $pretty_taxonomies[$term_id ? $term->term_id : $term->slug] = $term->name;
            }

            return $pretty_taxonomies;
        }

        return $terms;
    }

    public static function get_betterdocs_multiple_kb_status()
    {
        if (\BetterDocs_DB::get_settings('multiple_kb') == 1) {
            return 'true';
        }

        return '';
    }

    /**
     * POst Orderby Options
     *
     * @return array
     */
    public static function get_post_orderby_options()
    {
        $orderby = array(
            'ID' => 'Post ID',
            'author' => 'Post Author',
            'title' => 'Title',
            'date' => 'Date',
            'modified' => 'Last Modified Date',
            'parent' => 'Parent Id',
            'rand' => 'Random',
            'comment_count' => 'Comment Count',
            'menu_order' => 'Menu Order',
            'betterdocs_order' => 'BetterDocs Order',
        );

        return $orderby;
    }

    /**
     * Get Post Categories
     *
     * @return array
     */
    public static function get_terms_list($taxonomy = 'category', $key = 'term_id')
    {
        $options = [];
        $terms = get_terms([
            'taxonomy' => $taxonomy,
            'hide_empty' => true,
        ]);

        if (!empty($terms) && !is_wp_error($terms)) {
            foreach ($terms as $term) {
                $options[$term->{$key}] = $term->name;
            }
        }

        return $options;
    }

    /**
     * Query Controls
     *
     */
    public static function betterdocs_query($wb, $taxonomy)
    {
        $wb->start_controls_section(
            'eael_section_post__filters',
            [
                'label' => __('Query', 'betterdocs'),
            ]
        );

        $default_multiple_kb = self::get_betterdocs_multiple_kb_status();

        if ($default_multiple_kb && $taxonomy != 'knowledge_base') {
            $multiple_kb_terms = self::get_multiple_kb_terms(true, false);
            $default_slug = count($multiple_kb_terms) > 0 ? array_keys($multiple_kb_terms)[0] : '';

            $wb->add_control(
                'selected_knowledge_base',
                [
                    'label' => __('Knowledge Bases', 'betterdocs'),
                    'label_block' => true,
                    'type' => Controls_Manager::SELECT2,
                    'options' => $multiple_kb_terms,
                    'multiple' => false,
                    'default' => '',
                    'select2options' => [
                        'placeholder' => __('All Knowledge Base', 'betterdocs'),
                        'allowClear' => true,
                    ],
                ]
            );
        }

        if ($wb->get_name() === 'betterdocs-category-grid') {
            $wb->add_control(
                'grid_query_heading',
                [
                    'label' => __('Category Grid', 'betterdocs'),
                    'type' => Controls_Manager::HEADING,
                ]
            );
        }

        $wb->add_control(
            'include',
            [
                'label' => __('Include', 'betterdocs'),
                'label_block' => true,
                'type' => Controls_Manager::SELECT2,
                'options' => self::get_terms_list($taxonomy, 'term_id'),
                'multiple' => true,
                'default' => [],
            ]
        );

        $wb->add_control(
            'exclude',
            [
                'label' => __('Exclude', 'betterdocs'),
                'type' => Controls_Manager::SELECT2,
                'options' => self::get_terms_list($taxonomy, 'term_id'),
                'label_block' => true,
                'post_type' => '',
                'multiple' => true,
            ]
        );

        if ($wb->get_name() === 'betterdocs-category-grid') {
            $wb->add_control(
                'grid_per_page',
                [
                    'label' => __('Grid Per Page', 'betterdocs'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => '8',
                ]
            );
        } else {
            $wb->add_control(
                'box_per_page',
                [
                    'label' => __('Box Per Page', 'betterdocs'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => '8',
                ]
            );
        }

        $wb->add_control(
            'offset',
            [
                'label' => __('Offset', 'betterdocs'),
                'type' => Controls_Manager::NUMBER,
                'default' => '0',
            ]
        );

        $wb->add_control(
            'orderby',
            [
                'label' => __('Order By', 'betterdocs'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'name' => __('Name', 'betterdocs'),
                    'slug' => __('Slug', 'betterdocs'),
                    'term_group' => __('Term Group', 'betterdocs'),
                    'term_id' => __('Term ID', 'betterdocs'),
                    'id' => __('ID', 'betterdocs'),
                    'description' => __('Description', 'betterdocs'),
                    'parent' => __('Parent', 'betterdocs'),
                    'betterdocs_order' => __('BetterDocs Order', 'betterdocs'),
                ],
                'default' => 'name',
            ]
        );

        $wb->add_control(
            'order',
            [
                'label' => __('Order', 'betterdocs'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'asc' => 'Ascending',
                    'desc' => 'Descending',
                ],
                'default' => 'asc',

            ]
        );

        if ($wb->get_name() === 'betterdocs-category-grid') {
            $wb->add_control(
                'grid_posts_query_heading',
                [
                    'label' => __('Grid List Posts', 'betterdocs'),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $wb->add_control(
                'post_per_page',
                [
                    'label' => __('Post Per Page', 'betterdocs'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => '6',
                ]
            );

            $wb->add_control(
                'post_orderby',
                [
                    'label' => __('Order By', 'betterdocs'),
                    'type' => Controls_Manager::SELECT,
                    'options' => self::get_post_orderby_options(),
                    'default' => 'date',
                ]
            );

            $wb->add_control(
                'post_order',
                [
                    'label' => __('Order', 'betterdocs'),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        'asc' => 'Ascending',
                        'desc' => 'Descending',
                    ],
                    'default' => 'desc',
                ]
            );

            $wb->add_control(
                'nested_subcategory',
                [
                    'label' => __('Enable Nested Subcategory', 'betterdocs'),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __('Yes', 'betterdocs'),
                    'label_off' => __('No', 'betterdocs'),
                    'return_value' => 'true',
                    'default' => '',
                ]
            );

            $wb->add_control(
                'post_per_subcat',
                [
                    'label' => __('Post Per Subcategory', 'betterdocs'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => '6',
                    'condition' => [
                        'nested_subcategory'   => 'true'
                    ]
                ]
            );
        }

        $wb->end_controls_section();
    }

    public function nested_subcategory($term_id, $settings, $multiple_kb) {
        $html='';
        $sub_categories = BetterDocs_Helper::child_taxonomy_terms($term_id, $multiple_kb, $settings['orderby'], $settings['order'], '');
        if ($sub_categories) {
            foreach ($sub_categories as $sub_category) {
                $html .= '<span class="el-betterdocs-grid-sub-cat-title">';

                if (isset($settings['nested_list_title_closed_icon']['value']['url']) && !empty($settings['nested_list_title_closed_icon']['value']['url'])) {
                    $html .= '<img class="toggle-arrow arrow-right" src="' . $settings['nested_list_title_closed_icon']['value']['url'] . '" />';
                } else {
                    $html .= '<i class="' . $settings['nested_list_title_closed_icon']['value'] . ' toggle-arrow arrow-right"></i>';
                }

                if (isset($settings['nested_list_title_open_icon']['value']['url']) && !empty($settings['nested_list_title_open_icon']['value']['url'])) {
                    $html .= '<img class="toggle-arrow arrow-down" src="' . $settings['nested_list_title_open_icon']['value']['url'] . '" />';
                } else {
                    $html .= '<i class="' . $settings['nested_list_title_open_icon']['value'] . ' toggle-arrow arrow-down"></i>';
                }

                $html .= '<a href="#">' . $sub_category->name . '</a></span>';
                $html .= '<ul class="docs-sub-cat-list">';

                $sub_args = array(
                    'post_type' => 'docs',
                    'post_status' => 'publish'
                );

                $tax_query = array(
                    array(
                        'taxonomy' => 'doc_category',
                        'field'     => 'slug',
                        'terms'    => $sub_category->slug,
                        'operator' => 'AND',
                        'include_children' => false
                    ),
                );

                $sub_args['posts_per_page'] = $settings['post_per_subcat'];

                $sub_args['tax_query'] = apply_filters('betterdocs_list_tax_query_arg', $tax_query, $multiple_kb, $sub_category->slug, '');

                $sub_post_query = new \WP_Query($sub_args);
                if ($sub_post_query->have_posts()):
                    while ($sub_post_query->have_posts()): $sub_post_query->the_post();
                        $sub_attr = ['href="' . get_the_permalink() . '"'];
                        $html .= '<li class="sub-list">';
                        if (isset($settings['list_icon']['value']['url']) && !empty($settings['list_icon']['value']['url'])) {
                            $html .= '<img class="el-betterdocs-cg-post-list-icon" src="' . $settings['list_icon']['value']['url'] . '" />';
                        } else {
                            $html .= '<i class="' . $settings['list_icon']['value'] . ' el-betterdocs-cg-post-list-icon"></i>';
                        }
                        $html .= '<a ' . implode(' ', $sub_attr) . '>' . get_the_title() . '</a></li>';
                    endwhile;
                endif;
                wp_reset_query();
                $html .= $this->nested_subcategory($sub_category->term_id, $settings, $multiple_kb);
                $html .= '</ul>';
            }
        }
        return $html;
    }

    const ELBD_ALLOWED_HTML_TAGS = [
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
     * elbd_validate_html_tag
     * @param $tag
     * @return mixed|string
     */
    public static function elbd_validate_html_tag( $tag ){
        return in_array( strtolower( $tag ), self::ELBD_ALLOWED_HTML_TAGS ) ? $tag : 'div';
    }
}

BetterDocs_Elementor::init();
