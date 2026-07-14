<?php
/**
 * Search results template.
 *
 * @package IWLZ_Theme
 */

get_header();

global $wp_query;
get_template_part('template-parts/feed', null, array(
    'title' => sprintf(__('“%s”的搜索结果', 'iwlz-theme'), get_search_query()),
    'description' => sprintf(_n('找到 %s 篇文章', '找到 %s 篇文章', $wp_query->found_posts, 'iwlz-theme'), number_format_i18n($wp_query->found_posts)),
));

get_footer();
