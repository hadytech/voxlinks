<?php

namespace ReviewX\Elementor\Traits;

if (!defined('ABSPATH')) {
    exit();
} // Exit if accessed directly

use \Elementor\Core\Settings\Manager as Settings_Manager;

/**
 * Trait Addons
 * @package ReviewX\Elementor\Traits
 */
trait Addons
{
    /**
     * Add elementor category
     *
     * @since v1.0.0
     * @param $elements_manager
     */
    public function register_widget_categories($elements_manager)
    {
        $elements_manager->add_category(
            'rx-addons-elementor',
            [
                'title' => __('ReviewX Product Data Tabs', 'reviewx'),
                'icon' => 'font',
            ], 1);
    }

    /**
     * Register widgets
     *
     * @since v3.0.0
     * @param $widgets_manager
     */
    public function register_elements($widgets_manager)
    {
        $active_elements = (array) $this->get_settings();

        if (empty($active_elements)) {
            return;
        }

        asort($active_elements);

        foreach ($active_elements as $active_element) {
            if (!isset($this->registered_elements[$active_element])) {
                continue;
            }

            if (isset($this->registered_elements[$active_element]['condition'])) {
                $check = false;

                if(isset($this->registered_elements[$active_element]['condition'][2])) {
                    $check = $this->registered_elements[$active_element]['condition'][2];
                }

                if ($this->registered_elements[$active_element]['condition'][0]($this->registered_elements[$active_element]['condition'][1]) == $check) {
                    continue;
                }
            }

            $widgets_manager->register_widget_type(new $this->registered_elements[$active_element]['class']);
        }
    }

    /**
     * Register extensions
     *
     * @since v3.0.0
     */
    public function register_extensions()
    {
        $active_elements = (array) $this->get_settings();

        // set promotion extension enabled
        array_push($active_elements, 'rx-promotion');

        foreach ($this->registered_extensions as $key => $extension) {
            if (!in_array($key, $active_elements)) {
                continue;
            }

            new $extension['class'];
        }
    }

    /**
     * Register WC hooks
     * @return void
     */
	public function register_wc_hooks()
    {
		if (class_exists( 'WooCommerce' )){
			wc()->frontend_includes();
		}
	}
}
