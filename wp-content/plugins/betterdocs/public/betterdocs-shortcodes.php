<?php

/**
 * BetterDocs all shortcodes
 *
 * @link       https://wpdeveloper.net
 * @since      1.0.0
 *
 * @package    BetterDocs
 * @subpackage BetterDocs/public
 */

/**
 * Get terms post count including child terms
 */
function betterdocs_get_postcount($term_count = 0, $term_id)
{
	$taxonomy = 'doc_category';
	$args = array(
		'child_of' => $term_id,
	);
	$tax_terms = get_terms($taxonomy, $args);

	if ($tax_terms) {
		foreach ($tax_terms as $tax_term) {
			$term_count += $tax_term->count;
		}
	}

	return $term_count;
}

/**
 * Get the category grid with docs list.
 * *
 * @since      1.0.0
 * *
 * @param int $atts Get attributes for the categories.
 * @param int $content Get content to category.
 */
add_shortcode('betterdocs_category_grid', 'betterdocs_category_grid');
function betterdocs_category_grid($atts, $content = null)
{
    do_action( 'betterdocs_before_shortcode_load' );
	ob_start();
	global $wp_query;

	$column_val = '';
	$masonry_layout = BetterDocs_DB::get_settings('masonry_layout');
	$alphabetic_order = BetterDocs_DB::get_settings('alphabetically_order_post');
	$nested_subcategory = BetterDocs_DB::get_settings('nested_subcategory');
	$column_number = BetterDocs_DB::get_settings('column_number');
	$posts_number = BetterDocs_DB::get_settings('posts_number');
	$post_count = BetterDocs_DB::get_settings('post_count');
	$exploremore_btn = BetterDocs_DB::get_settings('exploremore_btn');
	$exploremore_btn_txt = BetterDocs_DB::get_settings('exploremore_btn_txt');
	$get_args = shortcode_atts(
		array(
			'sidebar_list' => false,
			'post_type' => 'docs',
			'category' => 'doc_category',
			'orderby' => BetterDocs_DB::get_settings('alphabetically_order_post'),
            'order' => BetterDocs_DB::get_settings('docs_order'),
			'post_counter' => true,
			'icon' => true,
			'masonry' => '',
			'column' => '',
			'posts_per_grid' => '',
			'nested_subcategory' => '',
			'terms' => '',
            'kb_slug' => '',
			'multiple_knowledge_base' => false,
			'disable_customizer_style' => false,
            'title_tag' => 'h2'
		),
		$atts
	);

	$taxonomy_objects = BetterDocs_Helper::taxonomy_object($get_args['multiple_knowledge_base'], $get_args['terms'], $get_args['kb_slug']);
	if ($taxonomy_objects && !is_wp_error($taxonomy_objects)) {
		$class = ['betterdocs-categories-wrap category-grid white-bg'];
		if (!is_singular('docs') && !is_tax('doc_category') && !is_tax('doc_tag')) {
			if ($get_args['sidebar_list'] == true) {
				$class[] = 'layout-flex';
			} elseif (isset($get_args['masonry']) && $get_args['masonry'] == true && $get_args['masonry'] != "false") {
                wp_enqueue_script('masonry');
				$class[] = 'layout-masonry';
			} elseif ($masonry_layout == 1 && $nested_subcategory != 1 && $get_args['masonry'] != "false") {
                wp_enqueue_script('masonry');
				$class[] = 'layout-masonry';
			} else {
				$class[] = 'layout-flex';
			}

			if ($get_args['sidebar_list'] == true) {
				$column_val = 1;
			} elseif (isset($get_args['column']) && $get_args['column'] == true && is_numeric($get_args['column'])) {
				$column_val = $get_args['column'];
			} else {
				$column_val = $column_number;
			}
			$class[] = 'docs-col-' . $column_val;
			if ($get_args['disable_customizer_style'] == false) {
				$class[] = 'single-kb';
			}
		}

		echo '<div class="'. implode(' ', $class) .'" data-column="'. esc_html($column_val) .'">';
			$term_list = wp_get_post_terms(get_the_ID(), 'doc_category', array("fields" => "all"));
			// get single page category id
			if (is_single() && !empty($term_list)) {
				$category_id = array_column($term_list, 'term_id');
				$ancestors = get_ancestors($category_id[0], 'doc_category');
				$page_cat = get_the_ID();
			} else {
				$category_id = array();
				$page_cat = '';
				$ancestors = array();
			}
			/**
			 * Get Queried Object - For KB
			 */

			// display category grid by order
			foreach ($taxonomy_objects as $term) {
			    $term_id = $term->term_id;
                $term_slug = $term->slug;
                $count = $term->count;
                $get_term_count = betterdocs_get_postcount($count, $term_id);
                $term_count = apply_filters('betterdocs_postcount', $get_term_count, $get_args['multiple_knowledge_base'], $term_id, $term_slug, $count);
                // $term_count = BetterDocs_Helper::get_postcount($term, $get_args['multiple_knowledge_base']);

				if ($term_count > 0) {
					// set active category class in single page	
					if (is_single() && (in_array($term_id, $category_id) || in_array($term_id, $ancestors))) {
						$wrap_class = 'docs-single-cat-wrap current-category';
						$title_class = 'docs-cat-title-wrap active-title';
					} else {
						$wrap_class = 'docs-single-cat-wrap';
						$title_class = 'docs-cat-title-wrap';
					}

					$cat_icon_id = get_term_meta($term_id, 'doc_category_image-id', true);

					if ($cat_icon_id) {
						$cat_icon_url = wp_get_attachment_image_url($cat_icon_id, 'thumbnail');
						$cat_icon = '<img class="docs-cat-icon" src="' . $cat_icon_url . '" alt="">';
					} else {
						$cat_icon = '<img class="docs-cat-icon" src="' . BETTERDOCS_ADMIN_URL . 'assets/img/betterdocs-cat-icon.svg" alt="">';
					}

					if ($get_args['icon'] == false) {
						$cat_icon = '';
					}

					echo '<div class="'. esc_attr($wrap_class) .'">
						<div class="'. esc_attr($title_class) .'">
							<div class="docs-cat-title-inner">';
								$term_permalink = BetterDocs_Helper::term_permalink('doc_category', $term->slug);

								if ($get_args['sidebar_list'] == true) {
									echo '<div class="docs-cat-title">' . $cat_icon . '<'.$get_args['title_tag'].' class="docs-cat-heading">' . $term->name . '</'.$get_args['title_tag'].'></div>';
								} else {
									echo '<div class="docs-cat-title">' . $cat_icon . '<a href="' . esc_url($term_permalink) . '"><'.$get_args['title_tag'].' class="docs-cat-heading">' . $term->name . '</'.$get_args['title_tag'].'></a></div>';
								}

								if ($post_count == 1 && $get_args['post_counter'] == true) {
									echo '<div class="docs-item-count"><span>' . $term_count . '</span></div>';
								}

								echo '<svg class="cat-list-arrow-down" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-down" class="svg-inline--fa fa-angle-down fa-w-10" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
									<path fill="currentColor" d="M143 352.3L7 216.3c-9.4-9.4-9.4-24.6 0-33.9l22.6-22.6c9.4-9.4 24.6-9.4 33.9 0l96.4 96.4 96.4-96.4c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9l-136 136c-9.2 9.4-24.4 9.4-33.8 0z"></path>
								</svg>
							</div>
						</div>
						<div class="docs-item-container">';
							if (isset($get_args['posts_per_grid']) && $get_args['posts_per_grid'] == true && is_numeric($get_args['posts_per_grid'])) {
								$posts_per_grid = $get_args['posts_per_grid'];
							} else {
								$posts_per_grid = $posts_number;
							}

							$list_args = BetterDocs_Helper::list_query_arg('docs', $get_args['multiple_knowledge_base'], $term_slug, $posts_per_grid, $get_args['orderby'], $get_args['order'], $get_args['kb_slug']);
							$args = apply_filters('betterdocs_articles_args', $list_args, $term->term_id);
							$post_query = new WP_Query($args);

							if ($post_query->have_posts()) :
								echo '<ul>';
								while ($post_query->have_posts()) : $post_query->the_post();
									$attr = ['href="' . get_the_permalink() . '"'];
									if ($page_cat === get_the_ID()) {
										$attr[] = 'class="active"';
									}
									echo '<li>' . BetterDocs_Helper::list_svg() . '<a ' . implode(' ', $attr) . '>' . get_the_title() . '</a></li>';
								endwhile;
								echo '</ul>';
							endif;
							wp_reset_query();

							// Sub category query
							if (($nested_subcategory == 1 || $get_args['nested_subcategory'] == true) && $get_args['nested_subcategory'] != "false") {
								nested_category_list(
									$term_id, 
									$get_args['multiple_knowledge_base'], 
									$category_id, 
									'docs',
                                    $get_args['orderby'],
                                    $get_args['order'],
									$page_cat,
                                    $get_args['kb_slug']
								);
							}

							// Read More Button
							if ($get_args['posts_per_grid'] == '-1' || $posts_number == '-1') {
								echo '';
							} else if ($exploremore_btn == 1 && !is_singular('docs') && BetterDocs_Helper::get_tax() != 'doc_category' && !is_tax('doc_tag')) {
								echo '<a class="docs-cat-link-btn" href="' . $term_permalink . '">' . esc_html($exploremore_btn_txt) . '</a>';
							}
						echo '</div>
					</div>';
                }
			}
		echo '</div>';
	    } else {
		echo '<div class="betterdocs-categories-wrap category-grid">
			<div class="docs-single-cat-wrap">
				<div class="docs-cat-title-wrap">
					<div class="docs-cat-title-inner">
						<div class="docs-cat-title">
							<img class="docs-cat-icon" src="<?php echo BETTERDOCS_ADMIN_URL ?>assets/img/betterdocs-cat-icon.svg" alt="">
                            <'.$get_args['title_tag'].'>'.esc_html__('Uncategorised', 'betterdocs').'</'.$get_args['title_tag'].'>
						</div>
					</div>
				</div>
				<div class="docs-item-container">';
					$args = array(
						'post_type'   => 'docs'
					);
					if (isset($get_args['posts_per_grid']) && $get_args['posts_per_grid'] == true && is_numeric($get_args['posts_per_grid'])) {
						$posts_number = $get_args['posts_per_grid'];
					}
					$args['posts_per_page'] = $posts_number;

					if ($alphabetic_order == 1) {
						$args['orderby'] = 'title';
						$args['order'] = 'ASC';
					}

					$uncategorised_tax_query = '';
					$args['tax_query'] = apply_filters('betterdocs_kb_uncategorised_tax_query', $uncategorised_tax_query, $wp_query);

					$post_query = new WP_Query($args);
					if ($post_query->have_posts()) :
						echo '<ul>';
						while ($post_query->have_posts()) : $post_query->the_post();
							$attr = ['href="' . get_the_permalink() . '"'];
							echo '<li>' . BetterDocs_Helper::list_svg() . '<a ' . implode(' ', $attr) . '>' . get_the_title() . '</a></li>';
						endwhile;
						echo '</ul>';
					endif;
					wp_reset_query();
				echo '</div>
			</div>
		</div>';
		}
        if (
            ($masonry_layout == 1 && $nested_subcategory != 1 && $get_args['masonry'] != "false")
            || (isset($get_args['masonry']) && $get_args['masonry'] == true && $get_args['masonry'] != "false")
        ) {
            $output = betterdocs_generate_output();
            echo '<script>
            jQuery(document).ready(function() {
                let masonryGrid = jQuery(".betterdocs-categories-wrap.layout-masonry");
                let columnPerGrid = jQuery(".betterdocs-categories-wrap.layout-masonry").attr("data-column");
                let masonryItem = jQuery(".betterdocs-categories-wrap.layout-masonry .docs-single-cat-wrap");
                let doc_page_column_space = '.$output['betterdocs_doc_page_column_space'].';
                let total_margin = columnPerGrid * doc_page_column_space;
                if (masonryGrid.length) {
                    masonryItem.css("width", "calc((100% - "+total_margin+"px) / "+parseInt(columnPerGrid)+")");
                    masonryGrid.masonry({
                        itemSelector: ".docs-single-cat-wrap",
                        percentPosition: true,
                        gutter: doc_page_column_space
                    });
                }
            });
            </script>';
        }
		return ob_get_clean();
	}
	
	function nested_category_list($term_id, $multiple_kb, $category_id, $post_type, $orderby, $order, $page_cat, $kb_slug='') {
		$sub_categories = BetterDocs_Helper::child_taxonomy_terms($term_id, $multiple_kb, $orderby, $order, $kb_slug);
		if ($sub_categories) {
			foreach ($sub_categories as $sub_category) {
				if (is_single() && in_array($sub_category->term_id, $category_id)) {
					$subcat_class = 'docs-sub-cat current-sub-cat';
				} else {
					$subcat_class = 'docs-sub-cat';
				}

				echo '<span class="docs-sub-cat-title">
					' . BetterDocs_Helper::arrow_right_svg() . '
					' . BetterDocs_Helper::arrow_down_svg() . '
					<a href="#">' . $sub_category->name . '</a></span>';

				echo '<ul class="' . esc_attr($subcat_class) . '">';
				$sub_args = BetterDocs_Helper::list_query_arg($post_type, $multiple_kb, $sub_category->slug, -1, $orderby, $order, $kb_slug);
				$sub_args = apply_filters('betterdocs_sub_cat_articles_args', $sub_args, $sub_category->term_id);
				$sub_post_query = new WP_Query($sub_args);

				if ($sub_post_query->have_posts()) :
					while ($sub_post_query->have_posts()) : $sub_post_query->the_post();
						$sub_attr = ['href="' . get_the_permalink() . '"'];
						if ($page_cat === get_the_ID()) {
							$sub_attr[] = 'class="active"';
						}
						echo '<li class="sub-list">' . BetterDocs_Helper::list_svg() . '<a ' . implode(' ', $sub_attr) . '>' . get_the_title() . '</a></li>';
					endwhile;
				endif;
				wp_reset_query();
				nested_category_list($sub_category->term_id, $multiple_kb, $category_id, $post_type, $orderby, $order, $page_cat, $kb_slug);
				echo '</ul>';
			}
		}
	}


	/**
	 * Get the category grid with docs list.
	 * *
	 * @since      1.0.0
	 * *
	 * @param int $atts Get attributes for the categories.
	 * @param int $content Get content to category.
	 */
	add_shortcode('betterdocs_category_list', 'betterdocs_category_list');
	function betterdocs_category_list($atts, $content = null)
	{
        do_action( 'betterdocs_before_shortcode_load' );
		ob_start();
		$alphabetic_order = BetterDocs_DB::get_settings('alphabetically_order_post');
		$nested_subcategory = BetterDocs_DB::get_settings('nested_subcategory');
		$get_args = shortcode_atts(
			array(
				'post_type' => 'docs',
				'category' => 'doc_category',
                'orderby' => BetterDocs_DB::get_settings('alphabetically_order_post'),
                'order' => BetterDocs_DB::get_settings('docs_order'),
				'masonry' => '',
				'column' => '',
				'posts_per_page' => '',
				'nested_subcategory' => '',
				'terms' => '',
                'kb_slug' => '',
				'multiple_knowledge_base' => false,
                'title_tag' => 'h2'
			),
			$atts
		);

		$taxonomy_objects = BetterDocs_Helper::taxonomy_object($get_args['multiple_knowledge_base'], $get_args['terms'], $get_args['kb_slug']);

		if ($taxonomy_objects && !is_wp_error($taxonomy_objects)) : ?>
		<div class="betterdocs-categories-wrap category-list">
			<?php
			$term_list = wp_get_post_terms(get_the_ID(), 'doc_category', array("fields" => "all"));

			// get single page category id
			if (is_single() && $term_list) {
				$category_id = array_column($term_list, 'term_id');
				$page_cat = get_the_ID();
			} else {
				$category_id = array();
				$page_cat = '';
			}

			/**
			 * For Multiple KB
			 */
			$q_object = get_queried_object();
			$kb_slug = '';

			if ($q_object instanceof WP_Term) {
				$kb_slug = $q_object->slug;
			}

			// display category grid by order
			foreach ($taxonomy_objects as $term) {
				$term_id = $term->term_id;
				$term_slug = $term->slug;
                $count = $term->count;
                $get_term_count = betterdocs_get_postcount($count, $term_id);
                $term_count = apply_filters('betterdocs_postcount', $get_term_count, $get_args['multiple_knowledge_base'], $term_id, $term_slug, $count);
                if ($term_count > 0) {
                    // set active category class in single page
                    if (is_single() && in_array($term_id, $category_id)) {
                        $wrap_class = 'docs-single-cat-wrap-2 current-category';
                        $title_class = 'active-title';
                    } else {
                        $wrap_class = 'docs-single-cat-wrap-2';
                        $title_class = '';
                    }

                    $term_permalink = BetterDocs_Helper::term_permalink('doc_category', $term_slug);
                    ?>
                    <div class="cat tet <?php echo esc_attr($wrap_class) ?>">
                        <div class="<?php echo esc_attr($title_class) ?>">
                            <div class="docs-cat-title-inner">
                                <?php
                                echo '<div class="docs-cat-title"><a href="' . esc_url($term_permalink) . '"><'.$get_args['title_tag'].' class="docs-cat-heading">' . $term->name . '</'.$get_args['title_tag'].'></a></div>';
                                ?>
                            </div>
                        </div>
                        <div class="docs-item-container">
                            <?php
                            $list_args = BetterDocs_Helper::list_query_arg('docs', $get_args['multiple_knowledge_base'], $term_slug, -1, $get_args['orderby'], $get_args['order'], $kb_slug);
                            $args = apply_filters('betterdocs_articles_args', $list_args, $term->term_id);
                            $post_query = new WP_Query($args);
                            if ($post_query->have_posts()) :

                                echo '<ul>';
                                while ($post_query->have_posts()) : $post_query->the_post();
                                    $attr = ['href="' . get_the_permalink() . '"'];
                                    if ($page_cat === get_the_ID()) {
                                        $attr[] = 'class="active"';
                                    }
                                    echo '<li><a ' . implode(' ', $attr) . '>' . get_the_title() . '</a></li>';
                                endwhile;

                                echo '</ul>';

                            endif;
                            wp_reset_query();

                            // Sub category query
                            if (($nested_subcategory == 1 || $get_args['nested_subcategory'] == true) && $get_args['nested_subcategory'] != "false") {
                                nested_category_list(
                                    $term_id,
                                    $get_args['multiple_knowledge_base'],
                                    $category_id,
                                    'docs',
                                    $get_args['orderby'],
                                    $get_args['order'],
                                    $page_cat
                                );
                            }
                            ?>
                        </div>
                    </div>
                <?php }
			} ?>
		</div>
	<?php
		endif;
		return ob_get_clean();
	}

	/**
	 * Get the category grid with docs list.
	 * *
	 * @since      1.0.0
	 * *
	 * @param int $atts Get attributes for the categories.
	 * @param int $content Get content to category.
	 */
	add_shortcode('betterdocs_category_box', 'betterdocs_category_box');
	function betterdocs_category_box($atts, $content = null)
	{
        do_action( 'betterdocs_before_shortcode_load' );
		ob_start();
		$column_number = BetterDocs_DB::get_settings('column_number');
		$post_count = BetterDocs_DB::get_settings('post_count');
		$count_text_singular = BetterDocs_DB::get_settings('count_text_singular');
		$count_text = BetterDocs_DB::get_settings('count_text');
		$get_args = shortcode_atts(
			array(
				'post_type' => 'docs',
				'category' => 'doc_category',
				'column' => '',
				'nested_subcategory' => '',
				'terms' => '',
                'kb_slug' => '',
				'multiple_knowledge_base' => false,
				'disable_customizer_style' => false,
                'title_tag' => 'h2'
			),
			$atts
		);

		$taxonomy_objects = BetterDocs_Helper::taxonomy_object($get_args['multiple_knowledge_base'], $get_args['terms'], $get_args['kb_slug']);

		if ($taxonomy_objects && !is_wp_error($taxonomy_objects)) :
			$class = ['betterdocs-categories-wrap betterdocs-category-box layout-2 ash-bg'];
			$class[] = 'layout-flex';

			if (isset($get_args['column']) && $get_args['column'] == true && is_numeric($get_args['column'])) {
				$class[] = 'docs-col-' . $get_args['column'];
			} else {
				$class[] = 'docs-col-' . $column_number;
			}

			if ($get_args['disable_customizer_style'] == false) {
				$class[] = 'single-kb';
			}
			?>
			<div class="<?php echo implode(' ', $class) ?>">
				<?php
				// display category grid by order
				foreach ($taxonomy_objects as $term) {
					$term_id = $term->term_id;
					if ($term->count != 0) {

					// set active category class in single page	
					$wrap_class = 'docs-single-cat-wrap';

					$term_permalink = BetterDocs_Helper::term_permalink('doc_category', $term->slug);
					?>
					<a href="<?php echo esc_url($term_permalink) ?>" class="<?php echo esc_attr($wrap_class) ?>">
						<?php
						$cat_icon_id = get_term_meta($term_id, 'doc_category_image-id', true);
						if ($cat_icon_id) {
							echo wp_get_attachment_image($cat_icon_id, 'thumbnail');
						} else {
							echo '<img class="docs-cat-icon" src="' . BETTERDOCS_ADMIN_URL . 'assets/img/betterdocs-cat-icon.svg" alt="">';
						}
						echo '<'.$get_args['title_tag'].' class="docs-cat-title">' . $term->name . '</'.$get_args['title_tag'].'>';
						$cat_desc = get_theme_mod('betterdocs_doc_page_cat_desc');
						if ($cat_desc == true) {
							echo '<p class="cat-description">' . $term->description . '</p>';
						}
						if ($post_count == 1) {
							if ($term->count == 1) {
								echo wp_sprintf('<span>%s %s</span>', $term->count, ($count_text_singular) ? $count_text_singular : __('article', 'betterdocs'));
							} else {
								echo wp_sprintf('<span>%s %s</span>', $term->count, ($count_text) ? $count_text : __('articles', 'betterdocs'));
							}
						}
						?>
					</a>
				<?php
					}
				}
			?>
			</div>
	<?php
		endif;
		return ob_get_clean();
	}

	/**
	 * search form with live dropdown result
	 * *
	 * @since      1.0.0
	 * 
	 */
	add_shortcode('betterdocs_search_form', 'betterdocs_search_form');
	function betterdocs_search_form($atts, $content = null)
	{
        do_action( 'betterdocs_before_shortcode_load' );
		$search_placeholder = BetterDocs_DB::get_settings('search_placeholder');
		ob_start();
		echo '<div class="betterdocs-live-search">';
			if (get_theme_mod('betterdocs_live_search_heading_switch') == true) {
				echo '<div class="betterdocs-search-heading">';
				if (get_theme_mod('betterdocs_live_search_heading')) {
					echo '<h2> ' . esc_html(get_theme_mod('betterdocs_live_search_heading')) . ' </h2>';
				}
				if (get_theme_mod('betterdocs_live_search_heading')) {
					echo '<h3> ' . get_theme_mod('betterdocs_live_search_subheading') . ' </h3>';
				}
				echo '</div>';
			}
			echo '<form id="betterdocs-searchform" class="betterdocs-searchform">
				<svg class="docs-search-icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="38px" viewBox="0 0 50 50" version="1.1">
					<g id="surface1">
						<path style=" " d="M 21 3 C 11.601563 3 4 10.601563 4 20 C 4 29.398438 11.601563 37 21 37 C 24.355469 37 27.460938 36.015625 30.09375 34.34375 L 42.375 46.625 L 46.625 42.375 L 34.5 30.28125 C 36.679688 27.421875 38 23.878906 38 20 C 38 10.601563 30.398438 3 21 3 Z M 21 7 C 28.199219 7 34 12.800781 34 20 C 34 27.199219 28.199219 33 21 33 C 13.800781 33 8 27.199219 8 20 C 8 12.800781 13.800781 7 21 7 Z "></path>
					</g>
				</svg>
				<input type="text" id="betterdocs-search-field" class="betterdocs-search-field" name="s" placeholder="'. $search_placeholder .'" autocomplete="off" value="'.get_search_query().'">
				<input type="hidden" value="Search" class="betterdocs-search-submit">';
                do_action('betterdocs_live_search_field_footer');
				echo '<svg class="docs-search-loader" width="38" height="38" viewBox="0 0 38 38" xmlns="http://www.w3.org/2000/svg" stroke="#444b54">
					<g fill="none" fill-rule="evenodd">
						<g transform="translate(1 1)" stroke-width="2">
							<circle stroke-opacity=".5" cx="18" cy="18" r="18" />
							<path d="M36 18c0-9.94-8.06-18-18-18">
								<animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="1s" repeatCount="indefinite" />
							</path>
						</g>
					</g>
				</svg>
				<svg class="docs-search-close" xmlns="http://www.w3.org/2000/svg" width="38px" viewBox="0 0 128 128">
					<path fill="#fff" d="M64 14A50 50 0 1 0 64 114A50 50 0 1 0 64 14Z" transform="rotate(-45.001 64 64.001)"></path>
					<path class="close-border" d="M64,117c-14.2,0-27.5-5.5-37.5-15.5c-20.7-20.7-20.7-54.3,0-75C36.5,16.5,49.8,11,64,11c14.2,0,27.5,5.5,37.5,15.5c10,10,15.5,23.3,15.5,37.5s-5.5,27.5-15.5,37.5C91.5,111.5,78.2,117,64,117z M64,17c-12.6,0-24.4,4.9-33.2,13.8c-18.3,18.3-18.3,48.1,0,66.5C39.6,106.1,51.4,111,64,111c12.6,0,24.4-4.9,33.2-13.8S111,76.6,111,64s-4.9-24.4-13.8-33.2S76.6,17,64,17z"></path>
					<path class="close-line" d="M53.4,77.6c-0.8,0-1.5-0.3-2.1-0.9c-1.2-1.2-1.2-3.1,0-4.2l21.2-21.2c1.2-1.2,3.1-1.2,4.2,0c1.2,1.2,1.2,3.1,0,4.2L55.5,76.7C54.9,77.3,54.2,77.6,53.4,77.6z"></path>
					<path class="close-line" d="M74.6,77.6c-0.8,0-1.5-0.3-2.1-0.9L51.3,55.5c-1.2-1.2-1.2-3.1,0-4.2c1.2-1.2,3.1-1.2,4.2,0l21.2,21.2c1.2,1.2,1.2,3.1,0,4.2C76.1,77.3,75.4,77.6,74.6,77.6z"></path>
				</svg>
                
			</form>
		</div>';
	return ob_get_clean();
}

/**
 * Get the search result from ajax load.
 * *
 * @since      1.0.0
 * 
 */
add_action('wp_ajax_nopriv_betterdocs_get_search_result', 'betterdocs_get_search_result');
add_action('wp_ajax_betterdocs_get_search_result', 'betterdocs_get_search_result');
function betterdocs_get_search_result()
{
	$search_input = isset($_POST['search_input']) ? sanitize_text_field($_POST['search_input']) : '';
    $kb_slug = isset($_POST['kb_slug']) ? sanitize_text_field($_POST['kb_slug']) : '';
	$args = array(
		'post_type'      => 'docs',
		'post_status'      => 'publish',
		'posts_per_page'      => -1,
		'suppress_filters' => false,
		's' => $search_input,
	);
    $tax_query = '';
    $args['tax_query'] = apply_filters('betterdocs_live_search_tax_query', $tax_query, $_POST);
	$loop = new WP_Query($args);
    $output = '<div class="betterdocs-search-result-wrap"><ul class="docs-search-result">';
	if ($loop->have_posts()) :
		while ($loop->have_posts()) : $loop->the_post();
			$imagematcha = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', get_the_content(), $matches);

			if ($matches[1]) {
				$first_img = $matches[1][0];
			} else {
				$first_img = '';
			}

			$terms = get_the_terms(get_the_ID(), 'doc_category');
			$terms_name = array();

			if ($terms) {

				foreach ($terms as $term) {
					$terms_name[] = $term->name;
				}
			}

			$all_terms = join(", ", $terms_name);
			$icon = '';
			$search_result_image = BetterDocs_DB::get_settings('search_result_image');
			if ($search_result_image == 1 && has_post_thumbnail()) {
				$icon = get_the_post_thumbnail();
			} elseif ($search_result_image == 1 && !empty($first_img)) {
				$icon = '<img src="' . $first_img . '" alt="">';
			}
            $output .= '<li>' . $icon . '<a href="' . get_permalink() . '"><span class="betterdocs-search-title">' . get_the_title() . '</span><br><span class="betterdocs-search-category">' . $all_terms . '</span></a></li>';
        endwhile;
	else :
		$output .= '<li>' . BetterDocs_DB::get_settings('search_not_found_text') . '</li>';
	endif;
	$output .= '</ul></div>';
	echo $output;
	wp_reset_postdata();
	die();
}

/**
 * feedback form shortcode
 * *
 * @since      1.0.0
 * 
 */
add_shortcode('betterdocs_feedback_form', 'betterdocs_feedback_form');
function betterdocs_feedback_form($atts, $content = null)
{
    do_action( 'betterdocs_before_shortcode_load' );
	$get_args = shortcode_atts(
		array(
			'button_text' => esc_html__('Send', 'betterdocs')
		),
		$atts
	);
	ob_start();
	if (is_user_logged_in()) {
		$userdata = get_userdata(get_current_user_id());
		$name = $userdata->first_name . ' ' . $userdata->last_name;
        $email = $userdata->user_email;
	} else {
		$name = '';
        $email = '';
	}

	?>
	<div class="form-wrapper">
		<div class="response"></div>
		<form id="betterdocs-feedback-form" class="betterdocs-feedback-form" action="" method="post">
			<p><label for="message_name" class="form-name">
					<?php esc_html_e('Name:', 'betterdocs') ?> <span>*</span> <br>
					<input type="text" id="message_name" name="message_name" value="<?php echo esc_html($name) ?>">
				</label>
			</p>
			<p><label for="message_email" class="form-email">
					<?php esc_html_e('Email:', 'betterdocs') ?> <span>*</span> <br>
					<input type="text" id="message_email" name="message_email" value="<?php echo esc_html($email) ?>">
				</label>
			</p>
			<p><label for="message_text" class="form-message">
					<?php esc_html_e('Message:', 'betterdocs') ?> <span>*</span> <br>
					<textarea type="text" id="message_text" name="message_text"></textarea>
				</label>
			</p>
			<div class="feedback-from-button">
				<input type="hidden" name="submitted" value="1">
				<input type="submit" name="submit" class="button" id="feedback_form_submit_btn" value="<?php echo $get_args['button_text'] ?>" />
			</div>
		</form>
	</div>
<?php
	return ob_get_clean();
}

/**
 * Submit form via ajax
 * *
 * @since      1.0.0
 * 
 */
add_action('wp_ajax_nopriv_betterdocs_feedback_form_submit', 'betterdocs_feedback_form_submit');
add_action('wp_ajax_betterdocs_feedback_form_submit', 'betterdocs_feedback_form_submit');

function betterdocs_feedback_form_submit()
{
	check_ajax_referer( 'betterdocs_submit_data', 'security' );
	$postID = isset($_POST['postID']) ? $_POST['postID'] : '';
	$article = get_the_title($postID);
	$name = isset($_POST['message_name']) ? sanitize_text_field($_POST['message_name']) : '';
	$email = isset($_POST['message_email']) ? sanitize_email($_POST['message_email']) : '';
	$message_text = isset($_POST['message_text']) ? sanitize_textarea_field($_POST['message_text']) : '';
	$message = <<<EOD
	Name : {$name} <br>
	Docs : {$article}
	{$message_text}
EOD;

	//response messages
	$missing_name = esc_html__('Please enter your name.', 'betterdocs');
	$email_invalid   = esc_html__('Enter a valid email address.', 'betterdocs');
	$missing_message = esc_html__('Please write your message.', 'betterdocs');
	$message_unsent  = esc_html__('Message was not sent. Try Again.', 'betterdocs');
	$message_sent    = esc_html__('Thanks! Your message has been sent.', 'betterdocs');

	//php mailer variables
	$to = BetterDocs_DB::get_settings('email_address');
	if (empty($to)) {
		$to = get_option('admin_email');
	}

	$subject = wp_sprintf(__('Feedback message from %s', 'betterdocs'), get_bloginfo('name'));
	$headers = 'From: ' . $email . "\r\n" .
		'Reply-To: ' . $email . "\r\n";
	$response = array();

	//validate presence of name
	if (empty($name)) {
		$response['nameStatus'] = 'error';
		$response['nameMessage'] = $missing_name;
	}

	//validate email
	if (empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$response['emailStatus'] = 'error';
		$response['emailMessage'] = $email_invalid;
	}

	//validate presence of message
	if (empty($message_text)) {
		$response['messageStatus'] = 'error';
		$response['messageMessage'] = $missing_message;
	}

	if (!empty($name) && !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($message_text)) {
		$sent = wp_mail($to, $subject, strip_tags($message), $headers);
		if ($sent) {
			$response['sentStatus'] = 'success';
			$response['sentMessage'] = $message_sent;
		} else {
			$response['sentStatus'] = 'error';
			$response['sentMessage'] = $message_unsent;
		}
	}
	echo json_encode($response);
	die();
}

/**
 * Social Share Shortcode
 * *
 * @since      1.0.0
 * 
 */
add_shortcode('betterdocs_social_share', 'betterdocs_social_share');
function betterdocs_social_share($atts, $content = null)
{
    do_action( 'betterdocs_before_shortcode_load' );
	$get_args = shortcode_atts(
		array(
			'title' => esc_html__('Share This Article :', 'betterdocs'),
			'facebook_sharing' => '1',
			'twitter_sharing' => '1',
			'linkedin_sharing' => '1',
			'pinterest_sharing' => '1'
		),
		$atts
	);
	$thumbnail = '';
	if (function_exists('has_post_thumbnail')) {
		if (has_post_thumbnail()) {
			$thumbnail = wp_get_attachment_url(get_post_thumbnail_id());
		}
	}

	?>
	<div class="betterdocs-social-share">
		<div class="betterdocs-social-share-heading">
			<?php 
				if ($get_args['title']) :
					echo '<h5>' . esc_html($get_args['title']) . '</h5>';
				endif;
			?>
		</div>
		<ul class="betterdocs-social-share-links">
			<?php if ($get_args['facebook_sharing'] == true) : ?>
				<li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="_blank"><img src="<?php echo BETTERDOCS_URL ?>public/img/facebook.svg" alt=""></a></li>
			<?php endif; ?>

			<?php if ($get_args['twitter_sharing'] == true) : ?>
				<li><a href="https://twitter.com/home?status=<?php the_permalink(); ?>" target="_blank"><img src="<?php echo BETTERDOCS_URL ?>public/img/twitter.svg" alt=""></a></li>
			<?php endif; ?>

			<?php if ($get_args['linkedin_sharing'] == true) : ?>
				<li><a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=&summary=&source=" target="_blank"><img src="<?php echo BETTERDOCS_URL ?>public/img/linkedin.svg" alt=""></a></li>
			<?php endif; ?>

			<?php if ($get_args['pinterest_sharing'] == true) : ?>
				<li><a href="https://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php echo $thumbnail; ?>&description=" target="_blank"><img src="<?php echo BETTERDOCS_URL ?>public/img/pinterest.svg" alt=""></a></li>
			<?php endif; ?>
		</ul>
	</div> <!-- Social Share end-->
<?php }

add_shortcode('betterdocs_toc', 'betterdocs_toc');
function betterdocs_toc($atts, $content = null)
{
    do_action( 'betterdocs_before_shortcode_load' );
	$get_args = shortcode_atts(
		array(
			'post_type' => 'docs',
			'post_id' => get_the_ID(),
			'htags' => '1,2,3,4,5,6',
			'hierarchy' => '',
			'list_number' => '',
			'collapsible_on_mobile' => '',
		),
		$atts
	);

	$get_post = get_post($get_args['post_id']);
	$post_content = $get_post->post_content;

	$toc = BetterDocs_Public::betterdocs_toc(
		$post_content,
		$get_args['htags'],
		$get_args['hierarchy'],
		$get_args['list_number'],
		$get_args['collapsible_on_mobile']
	);

	return $toc;
}

add_shortcode('betterdocs_post_content', 'betterdocs_post_content');
function betterdocs_post_content($atts, $content = null)
{
    do_action( 'betterdocs_before_shortcode_load' );
	$get_args = shortcode_atts(
		array(
			'post_id' => get_the_ID(),
			'htags' => 'h1,h2,h3,h4,h5,h6',
			'enable_toc' => '',
			'toc_hierarchy' => '',
			'list_number' => '',
			'display_toc_on_top' => '',
			'collapsible_toc_mobile' => ''
		),
		$atts
	);

	$get_post = get_post($get_args['post_id']);
	$post_content = $get_post->post_content;
	$the_content = BetterDocs_Public::betterdocs_the_content(
		$post_content,
		$get_args['htags'],
		$get_args['enable_toc']
	);
	
	return $the_content;
}