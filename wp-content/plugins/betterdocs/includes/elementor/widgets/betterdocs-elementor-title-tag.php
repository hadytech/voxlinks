<?php

use ElementorPro\Modules\Woocommerce\Tags\Base_Tag;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class BetterDocs_Elementor_Title_Tag extends Base_Tag {
    public function get_name () {
        return 'betterdocs-title-tag';
    }

    public function get_title () {
        return __('Doc Title', 'betterdocs');
    }

    public function render () {
        if (get_post_type(get_the_ID()) != 'docs') {
            return;
        }
        echo get_the_title();
    }
}
