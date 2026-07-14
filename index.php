<?php
/**
 * Main blog template.
 *
 * @package IWLZ_Theme
 */

get_header();

get_template_part('template-parts/feed', null, array(
    'title' => __('最新文章', 'iwlz-theme'),
    'notice' => get_theme_mod('iwlz_notice_text', ''),
    'notice_url' => get_theme_mod('iwlz_notice_url', ''),
));

get_footer();
