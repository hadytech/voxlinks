<?php

namespace ReviewX\Elementor\Classes;

use ReviewX\Elementor\Traits\Addons;
use ReviewX\Elementor\Traits\Library;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

/**
 * Class Starter
 * @package ReviewX\Elementor\Classes
 */
class Starter
{
    use Addons, Library;

    // instance container
    private static $instance = null;

    // registered elements container
    public $registered_elements;

    // registered extensions container
    public $registered_extensions;

    // additional settings
    public $additional_settings;

    /**
     * Singleton instance
     *
     * @since 3.0.0
     */
    public static function instance()
    {
        if (self::$instance == null) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Constructor of plugin class
     *
     * @since 3.0.0
     */
    private function __construct()
    {
        // elements classmap
        $this->registered_elements = apply_filters('rx/registered_elements', array_get(config('settings'), 'rxelements'));

        // extensions classmap
        $this->registered_extensions = apply_filters('rx/registered_extensions', array_get(config('settings'), 'rxextensions'));

        // additional settings
        $this->additional_settings = apply_filters('rx/additional_settings', [
            'quick_tools' => true,
        ]);

        // register hooks
        $this->register_hooks();
    }

    /**
     * Register Hooks
     *
     * @return void
     */
    protected function register_hooks()
    {
        // Elements
        add_action('elementor/elements/categories_registered', array($this, 'register_widget_categories'));
        add_action('elementor/widgets/widgets_registered', array($this, 'register_elements'));

    }
}
