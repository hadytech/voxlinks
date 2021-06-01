<?php

namespace ElementorPro\Modules\Woocommerce\Conditions;

use ElementorPro\Modules\ThemeBuilder as ThemeBuilder;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class Docs_Page extends ThemeBuilder\Conditions\Condition_Base
{

	public static function get_type()
	{
		return 'archive';
	}

	public function get_name()
	{
		return 'docs_page';
	}

	public static function get_priority()
	{
		return 40;
	}

	public function get_label()
	{
		return __('Docs Page', 'elementor-pro');
	}

	public function check($args)
	{
		return is_post_type_archive('docs');
	}
}
