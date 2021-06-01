<?php

namespace ReviewX\Elementor\Traits;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

/**
 * Trait Library
 * @package ReviewX\Elementor\Traits
 */
trait Library
{
    /**
     *  Return array of registered elements.
     *
     * @todo filter output
     */
    public function get_registered_elements()
    {
        return array_keys($this->registered_elements);
    }

    /**
     * Return saved settings
     *
     * @since 3.0.0
     * @param null $element
     * @return array|int|mixed
     */
    public function get_settings($element = null)
    {
        $defaults = array_fill_keys(array_keys(array_merge($this->registered_elements, $this->registered_extensions, $this->additional_settings)), true);
        $elements = get_option('rx_save_settings', $defaults);
        $elements = array_merge($defaults, $elements);

        return (isset($element) ? (isset($elements[$element]) ? $elements[$element] : 0) : array_keys(array_filter($elements)));
    }

    /**
     * Generate safe path
     *
     * @since v3.0.0
     */
    public function safe_path($path)
    {
        $path = str_replace(['//', '\\\\'], ['/', '\\'], $path);

        return str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
    }
}
