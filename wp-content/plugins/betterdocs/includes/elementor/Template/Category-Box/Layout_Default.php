<?php
/**
 * Template Name: Default
 *
 */


$term_permalink = BetterDocs_Helper::term_permalink('doc_category', $term->slug);

echo '<a href="' . $term_permalink . '" class="el-betterdocs-category-box-post">
    <div class="el-betterdocs-cb-inner">';

    if ($settings['show_icon']) {
        $cat_icon_id = get_term_meta($term->term_id, 'doc_category_image-id', true);

        if ($cat_icon_id) {
            $cat_icon = wp_get_attachment_image($cat_icon_id, 'thumbnail', ['alt' => esc_attr(get_post_meta($cat_icon_id, '_wp_attachment_image_alt', true))]);
        } else {
            $cat_icon = '<img src="' . BETTERDOCS_ADMIN_URL . 'assets/img/betterdocs-cat-icon.svg" alt="betterdocs-category-box-icon">';
        }

        echo '<div class="el-betterdocs-cb-cat-icon">' . $cat_icon . '</div>';
    }

    if ($settings['show_title']) {
        echo '<' . BetterDocs_Elementor::elbd_validate_html_tag($settings['title_tag']) . ' class="el-betterdocs-cb-cat-title">' . $term->name . '</' . BetterDocs_Elementor::elbd_validate_html_tag($settings['title_tag']) . '>';
    }

    if ($settings['show_count']) {
        $get_term_count = betterdocs_get_postcount($term->count, $term->term_id);
        $term_count = apply_filters('betterdocs_postcount', $get_term_count, $default_multiple_kb, $term->term_id, $term->slug, $term->count);
        if($term_count == 1) {
            printf('<div class="el-betterdocs-cb-cat-count"><span class="count-prefix">%s</span>%s<span class="count-suffix">%s</span></div>', $settings['count_prefix'], $term_count, $settings['count_suffix_singular']);
        } else {
            printf('<div class="el-betterdocs-cb-cat-count"><span class="count-prefix">%s</span>%s<span class="count-suffix">%s</span></div>', $settings['count_prefix'], $term_count, $settings['count_suffix']);
        }
        
    }

    echo '</div>
</a>';
