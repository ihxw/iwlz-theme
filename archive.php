<?php
/**
 * Archive template.
 *
 * @package IWLZ_Theme
 */

get_header();

get_template_part('template-parts/feed', null, array(
    'title' => wp_strip_all_tags(get_the_archive_title()),
    'description' => get_the_archive_description(),
));

get_footer();
