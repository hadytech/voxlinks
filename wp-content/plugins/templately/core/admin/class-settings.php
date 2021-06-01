<?php
/**
 * Settings Class
 *
 * @package Templately
 */

namespace Templately\Admin;

defined('ABSPATH') or exit;

use Templately\Helper;
use Elementor\User;

class Settings {
    public static function init() {
        static::admin_menu();
    }

    public static function display() {
        Helper::views('core/admin/views/settings');
    }

    public static function admin_menu() {
        // TOOD: Role Management
        \add_menu_page(
            'Templately',
            'Templately',
            'delete_posts',
            'templately',
            array(__CLASS__, 'display'),
            TEMPLATELY_ASSETS . 'images/logo-icon.svg',
            '58.7'
        );
    }
}
