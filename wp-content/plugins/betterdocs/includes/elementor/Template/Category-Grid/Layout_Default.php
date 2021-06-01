<?php

/**
 * Template Name: Default
 *
 */

echo '<article class="el-betterdocs-category-grid-post" data-id="' . get_the_ID() . '">
    <div class="el-betterdocs-cg-inner">';
        if ($settings['show_header'] === 'true') {
            echo '<div class="el-betterdocs-cg-header">
                <div class="el-betterdocs-cg-header-inner">';
                    if ($settings['show_icon']) {

                        $cat_icon_id = get_term_meta($term->term_id, 'doc_category_image-id', true);
                        if ($cat_icon_id) {
                            $cat_icon = wp_get_attachment_image($cat_icon_id, 'thumbnail', ['alt' => esc_attr(get_post_meta($cat_icon_id, '_wp_attachment_image_alt', true))]);
                        } else {
                            $cat_icon = '<img src="' . BETTERDOCS_ADMIN_URL . 'assets/img/betterdocs-cat-icon.svg" alt="betterdocs-category-grid-icon">';
                        }

                        echo '<div class="el-betterdocs-cat-icon">' . $cat_icon . '</div>';
                    }
                    if ($settings['show_title']) {
                        echo '<' . BetterDocs_Elementor::elbd_validate_html_tag($settings['title_tag']) . ' class="el-betterdocs-cat-title">' . $term->name . '</' . BetterDocs_Elementor::elbd_validate_html_tag($settings['title_tag']) . '>';
                    }
                    if ($settings['show_count']) {
                        $get_term_count = betterdocs_get_postcount($term->count, $term->term_id);
                        $term_count = apply_filters('betterdocs_postcount', $get_term_count, $default_multiple_kb, $term->term_id, $term->slug, $term->count);
                        echo '<div class="el-betterdocs-item-count">' . $term_count . '</div>';
                    }
                echo '</div>
            </div>';
        }

        if ($settings['show_list'] === 'true') {
            echo '<div class="el-betterdocs-cg-body">';
            $multiple_kb = BetterDocs_Elementor::get_betterdocs_multiple_kb_status();
            if ($multiple_kb == true) {
                $taxes = array('knowledge_base', 'doc_category');

                foreach ($taxes as $tax) {
                    $kterms = get_terms($tax);

                    if (!is_wp_error($kterms)) {
                        foreach ($kterms as $kterm) {
                            $tax_map[$tax][$kterm->slug] = $kterm->term_taxonomy_id;
                        }
                    }    
                }

                $args = array(
                    'post_type' => 'docs',
                    'post_status' => 'publish',
                    'posts_per_page' => $settings['post_per_page'],
                    'tax_query' => array(
                        'relation' => 'AND',
                        array(
                            'taxonomy' => 'doc_category',
                            'field' => 'term_taxonomy_id',
                            'operator' => 'IN',
                            'terms' => array($tax_map['doc_category'][$term->slug]),
                            'include_children' => false,
                        ),
                    ),
                );

                $object = get_queried_object();
                if (empty($settings['selected_knowledge_base']) && is_tax('knowledge_base')) {
                    $kb_term = $object->slug;
                } else {
                    $kb_term = $settings['selected_knowledge_base'];
                }

                if($kb_term){
                    $args['tax_query'][] = array(
                        'taxonomy' => 'knowledge_base',
                        'field' => 'term_taxonomy_id',
                        'terms' => array($tax_map['knowledge_base'][$kb_term]),
                        'operator' => 'IN',
                        'include_children' => false,
                    );
                }

            } else {
                $args = array(
                    'post_type' => 'docs',
                    'post_status' => 'publish',
                    'posts_per_page' => $settings['post_per_page'],
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'doc_category',
                            'field' => 'slug',
                            'terms' => $term->slug,
                            'operator' => 'AND',
                            'include_children' => false,
                        ),
                    ),
                );
            }

            if($settings['post_orderby'] == 'betterdocs_order') {
                $args = apply_filters('betterdocs_articles_args', $args, $term->term_id);
            } else {
                $args['orderby'] = $settings['post_orderby'];
                $args['order'] = $settings['post_order'];
            }

            $query = new \WP_Query($args);

            if ($query->have_posts()) {
                echo '<ul>';
                while ($query->have_posts()) {
                    $query->the_post();
                    $attr = ['href="' . get_the_permalink() . '"'];

                    echo '<li>';
                    if (isset($settings['list_icon']['value']['url']) && !empty($settings['list_icon']['value']['url'])) {
                        echo '<img class="el-betterdocs-cg-post-list-icon" src="' . $settings['list_icon']['value']['url'] . '" />';
                    } else {
                        echo '<i class="' . $settings['list_icon']['value'] . ' el-betterdocs-cg-post-list-icon"></i>';
                    }
                    echo '<a ' . implode(' ', $attr) . '>' . get_the_title() . '</a>
                    </li>';
                }
                echo '</ul>';
            }
            wp_reset_query();

            // Nested category query
            if ($settings['nested_subcategory'] === 'true') {
                $BetterDocs_Elementor = new BetterDocs_Elementor();
                echo $BetterDocs_Elementor->nested_subcategory($term->term_id, $settings, $multiple_kb);
            }
            echo '</div>';
        }

        echo '<div class="el-betterdocs-cg-footer">';
            if ($settings['show_button']) {
                $term_permalink = BetterDocs_Helper::term_permalink('doc_category', $term->slug);

                echo '<a class="el-betterdocs-cg-button" href="' . $term_permalink . '">';

                if ($settings['icon_position'] === 'before') {
                    if (isset($settings['button_icon']['value']['url']) && !empty($settings['button_icon']['value']['url'])) {
                        echo '<img class="el-betterdocs-cg-button-icon el-betterdocs-cg-button-icon-left" src="' . $settings['button_icon']['value']['url'] . '" />';
                    } else {
                        echo '<i class="' . $settings['button_icon']['value'] . ' el-betterdocs-cg-button-icon el-betterdocs-cg-button-icon-left"></i>';
                    }
                }

                echo $settings['button_text'];

                if ($settings['icon_position'] === 'after') {
                    if (isset($settings['button_icon']['value']['url']) && !empty($settings['button_icon']['value']['url'])) {
                        echo '<img class="el-betterdocs-cg-button-icon el-betterdocs-cg-button-icon-right" src="' . $settings['button_icon']['value']['url'] . '" />';
                    } else {
                        echo '<i class="' . $settings['button_icon']['value'] . ' el-betterdocs-cg-button-icon el-betterdocs-cg-button-icon-right"></i>';
                    }
                }

                echo '</a>';
            }
        echo '</div>';
    echo '</div>';
echo '</article>';
