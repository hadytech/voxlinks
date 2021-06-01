<?php

use Elementor\Controls_Manager;
use ElementorPro\Modules\ThemeBuilder\Documents\Single_Base;
use ElementorPro\Plugin;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Working with elementor plugin
 *
 *
 * @since      1.3.0
 * @package    BetterDocs
 * @subpackage BetterDocs/elementor
 * @author     WPDeveloper <support@wpdeveloper.net>
 */
class BetterDocs_Single_Docs extends Single_Base
{
    public static function get_properties()
    {
        $properties = parent::get_properties();

        $properties['location'] = 'single';
        $properties['condition_type'] = 'docs';

        return $properties;
    }

    protected static function get_site_editor_type()
    {
        return 'docs';
    }

    public static function get_title()
    {
        return __('Single Doc', 'betterdocs');
    }

    public static function get_editor_panel_config()
    {
        $config = parent::get_editor_panel_config();
        $config['widgets_settings']['betterdocs-elements'] = [
            'show_in_panel' => true,
        ];

        return $config;
    }

    public function get_depended_widget()
    {
        return Plugin::elementor()->widgets_manager->get_widget_types('betterdocs-content');
    }

    public function get_container_attributes()
    {
        $attributes = parent::get_container_attributes();

        $attributes['class'] .= ' betterdocs';

        return $attributes;
    }

    public function filter_body_classes($body_classes)
    {
        $body_classes = parent::filter_body_classes($body_classes);

        if (get_the_ID() === $this->get_main_id() || Plugin::elementor()->preview->is_preview_mode($this->get_main_id())) {
            $body_classes[] = 'betterdocs-elementor-single';
        }

        return $body_classes;
    }

    public function before_get_content()
    {
        parent::before_get_content();

        do_action('betterdocs_before_single_product');
    }

    public function after_get_content()
    {
        parent::after_get_content();

        do_action('betterdocs_after_single_product');
    }

    public function print_content()
    {
        if (post_password_required()) {
            echo get_the_password_form();
            return;
        }

        parent::print_content();
    }

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }

    protected static function get_editor_panel_categories()
    {
        $categories = [
            // Move to top as active.
            'betterdocs-elements' => [
                'title'  => __('BetterDocs', 'betterdocs'),
                'active' => true,
            ],
        ];

        $categories += parent::get_editor_panel_categories();
        unset($categories['theme-elements-single']);
        return $categories;
    }

    protected function _register_controls()
    {
        parent::_register_controls();

        $this->update_control(
            'preview_type',
            [
                'type'    => Controls_Manager::HIDDEN,
                'default' => 'single/docs',
            ]
        );

        $latest_posts = get_posts([
            'posts_per_page' => 1,
            'post_type'      => 'docs',
        ]);

        if (!empty($latest_posts)) {
            $this->update_control(
                'preview_id',
                [
                    'default' => $latest_posts[0]->ID,
                ]
            );
        }
    }

    protected function get_remote_library_config()
    {
        $config = parent::get_remote_library_config();

        $config['category'] = 'Single Docs';

        return $config;
    }
}
