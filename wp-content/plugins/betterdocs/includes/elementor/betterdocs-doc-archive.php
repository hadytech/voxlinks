<?php

use ElementorPro\Modules\ThemeBuilder\Documents\Archive;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Betterdocs_Doc_Archive extends Archive
{
    public static function get_properties()
    {
        $properties = parent::get_properties();

        $properties['location'] = 'archive';
        $properties['condition_type'] = 'doc_archive';

        return $properties;
    }

    protected static function get_site_editor_type()
    {
        return 'doc-archive';
    }

    public static function get_title()
    {
        return __('Docs Archive', 'betterdocs');
    }

    protected static function get_editor_panel_categories()
    {
        $categories = [
            'docs-archive' => [
                'title' => __('Docs Archive', 'elementor-pro'),
            ],
        ];
        $categories += parent::get_editor_panel_categories();
        unset($categories['theme-elements-archive']);
        return $categories;
    }

    public static function get_editor_panel_config()
    {
        $config = parent::get_editor_panel_config();
        $config['widgets_settings']['theme-archive-title']['categories'][] = 'docs-archive';
        return $config;
    }

    protected function get_remote_library_config()
    {
        $config = parent::get_remote_library_config();

        $config['category'] = 'Docs Archive';

        return $config;
    }
}
