<?php

use ElementorPro\Modules\ThemeBuilder as ThemeBuilder;
use ElementorPro\Modules\Woocommerce\Conditions\Docs_Page;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Betterdocs_Archive_Condition extends ThemeBuilder\Conditions\Condition_Base
{
    private $post_type = 'docs';
    private $post_taxonomies;

    public function __construct(array $data = [])
    {
        $taxonomies = get_object_taxonomies($this->post_type, 'objects');

        $this->post_taxonomies = wp_filter_object_list($taxonomies, [
            'public' => true,
            'show_in_nav_menus' => true,
        ]);

        parent::__construct($data);
    }

    public static function get_type()
    {
        return 'archive';
    }

    public function get_name()
    {
        return 'doc_archive';
    }

    public function get_label()
    {
        return __('Docs Archive', 'betterdocs');
    }

    public function get_all_label()
    {
        return __('All Docs Archive', 'betterdocs');
    }

    public function register_sub_conditions()
    {
        $this->register_sub_condition(new Docs_Page());
        foreach ($this->post_taxonomies as $slug => $object) {
            $condition = new ThemeBuilder\Conditions\Taxonomy([
                'object' => $object,
            ]);
            $this->register_sub_condition($condition);
        }
    }

    public function check($args)
    {
        return is_post_type_archive('docs') || is_archive('knowledge_base') || is_archive('doc_category') || is_archive('doc_tag');
    }
}
