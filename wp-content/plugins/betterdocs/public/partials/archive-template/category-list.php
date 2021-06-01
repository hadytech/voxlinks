<?php

/**
 * Template archive docs
 *
 * @link       https://wpdeveloper.net
 * @since      1.0.0
 *
 * @package    BetterDocs
 * @subpackage BetterDocs/public
 */

get_header();

echo '<div class="betterdocs-wraper betterdocs-main-wraper">';
	$live_search = BetterDocs_DB::get_settings('live_search');
	if ($live_search == 1) {
		echo '<div class="betterdocs-search-form-wrap">'. do_shortcode('[betterdocs_search_form]') .'</div>';
	}

	echo '<div class="betterdocs-archive-wrap betterdocs-archive-main betterdocs-category-list">';
        $output = betterdocs_generate_output();
		$shortcode = do_shortcode('[betterdocs_category_grid title_tag="'.BetterDocs_Helper::html_tag($output['betterdocs_category_title_tag']).'"]');
		echo apply_filters('betterdocs_category_list_shortcode', $shortcode);
	echo '</div>
</div>';

get_footer();
