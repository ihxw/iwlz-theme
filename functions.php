<?php
/**
 * Theme functions and definitions.
 *
 * @package IWLZ_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

function iwlz_theme_setup()
{
    load_theme_textdomain('iwlz-theme', get_template_directory() . '/languages');

    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds');
    add_theme_support('align-wide');
    add_theme_support('editor-styles');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));
    add_theme_support('custom-background', array('default-color' => 'f5f5f5'));
    add_theme_support('custom-logo', array(
        'height' => 48,
        'width' => 180,
        'flex-height' => true,
        'flex-width' => true,
    ));

    add_image_size('iwlz-card', 460, 300, true);
    add_image_size('iwlz-related', 320, 200, true);

    register_nav_menus(array(
        'primary' => __('主导航菜单', 'iwlz-theme'),
    ));

    add_editor_style('style.css');
}
add_action('after_setup_theme', 'iwlz_theme_setup');

function iwlz_theme_content_width()
{
    $GLOBALS['content_width'] = apply_filters('iwlz_theme_content_width', 860);
}
add_action('after_setup_theme', 'iwlz_theme_content_width', 0);

function iwlz_theme_widgets_init()
{
    register_sidebar(array(
        'name' => __('侧边栏', 'iwlz-theme'),
        'id' => 'sidebar-1',
        'description' => __('显示在 Joe3 风格侧边栏底部。', 'iwlz-theme'),
        'before_widget' => '<section id="%1$s" class="widget joe-panel %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
}
add_action('widgets_init', 'iwlz_theme_widgets_init');

function iwlz_theme_scripts()
{
    $version = wp_get_theme()->get('Version');
    $script_dependencies = array();

    wp_enqueue_style('iwlz-theme-style', get_stylesheet_uri(), array(), $version);

    $queried_post = is_singular() ? get_queried_object() : null;
    $has_code = $queried_post instanceof WP_Post
        && (stripos($queried_post->post_content, '<pre') !== false || stripos($queried_post->post_content, '<code') !== false);

    if ($has_code) {
        $prism_uri = get_template_directory_uri() . '/assets/vendor/prism/';
        $prism_version = '1.30.0';

        wp_enqueue_script('iwlz-prism', $prism_uri . 'prism.js', array(), $prism_version, true);
        wp_add_inline_script('iwlz-prism', 'window.Prism=window.Prism||{};window.Prism.manual=true;', 'before');
        wp_enqueue_script('iwlz-prism-markup-templating', $prism_uri . 'components/prism-markup-templating.min.js', array('iwlz-prism'), $prism_version, true);
        wp_enqueue_script('iwlz-prism-php', $prism_uri . 'components/prism-php.min.js', array('iwlz-prism-markup-templating'), $prism_version, true);
        wp_enqueue_script('iwlz-prism-bash', $prism_uri . 'components/prism-bash.min.js', array('iwlz-prism'), $prism_version, true);
        wp_enqueue_script('iwlz-prism-json', $prism_uri . 'components/prism-json.min.js', array('iwlz-prism'), $prism_version, true);
        wp_enqueue_script('iwlz-prism-python', $prism_uri . 'components/prism-python.min.js', array('iwlz-prism'), $prism_version, true);
        wp_enqueue_script('iwlz-prism-sql', $prism_uri . 'components/prism-sql.min.js', array('iwlz-prism'), $prism_version, true);
        wp_enqueue_script('iwlz-prism-yaml', $prism_uri . 'components/prism-yaml.min.js', array('iwlz-prism'), $prism_version, true);
        wp_enqueue_script('iwlz-prism-docker', $prism_uri . 'components/prism-docker.min.js', array('iwlz-prism-bash'), $prism_version, true);

        $script_dependencies = array(
            'iwlz-prism-php',
            'iwlz-prism-json',
            'iwlz-prism-python',
            'iwlz-prism-sql',
            'iwlz-prism-yaml',
            'iwlz-prism-docker',
        );
    }

    wp_enqueue_script(
        'iwlz-theme-app',
        get_template_directory_uri() . '/js/theme.js',
        $script_dependencies,
        $version,
        true
    );
    wp_localize_script('iwlz-theme-app', 'iwlzThemeL10n', array(
        'darkMode' => __('切换深色模式', 'iwlz-theme'),
        'lightMode' => __('切换浅色模式', 'iwlz-theme'),
        'expandSubmenu' => __('展开子菜单', 'iwlz-theme'),
        'collapseSubmenu' => __('收起子菜单', 'iwlz-theme'),
        'copyCode' => __('复制代码', 'iwlz-theme'),
        'copied' => __('已复制', 'iwlz-theme'),
        'copyFailed' => __('复制失败，请手动选择代码', 'iwlz-theme'),
    ));

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    $light = get_theme_mod('accent_color', '#fb6c28');
    $dark = get_theme_mod('accent_color_dark', '#9999ff');
    wp_add_inline_style(
        'iwlz-theme-style',
        ':root{--accent-color:' . esc_attr($light) . ';}' .
        '[data-theme="dark"]{--accent-color:' . esc_attr($dark) . ';}'
    );
}
add_action('wp_enqueue_scripts', 'iwlz_theme_scripts');

function iwlz_theme_excerpt_length()
{
    return 42;
}
add_filter('excerpt_length', 'iwlz_theme_excerpt_length', 999);

function iwlz_theme_excerpt_more()
{
    return '...';
}
add_filter('excerpt_more', 'iwlz_theme_excerpt_more');

/**
 * Return clean list copy, including a useful fallback for migrated editor data.
 */
function iwlz_theme_get_excerpt($post_id = 0, $words = 42)
{
    $post_id = $post_id ?: get_the_ID();
    $excerpt = get_the_excerpt($post_id);
    $text = trim(wp_strip_all_tags(html_entity_decode($excerpt, ENT_QUOTES, get_bloginfo('charset'))));

    if (iwlz_theme_is_migrated_editor_data($text)) {
        $text = trim(wp_strip_all_tags(strip_shortcodes(get_post_field('post_content', $post_id))));
    }

    if ($text === '' || iwlz_theme_is_migrated_editor_data($text)) {
        return __('点击查看文章详情与完整内容。', 'iwlz-theme');
    }

    return wp_trim_words($text, $words, '...');
}

function iwlz_theme_is_migrated_editor_data($text)
{
    $text = trim(html_entity_decode((string) $text, ENT_QUOTES, get_bloginfo('charset')));
    if (!preg_match('/^\[\s*\{\s*["“]?source["”]?\s*:/iu', $text)) {
        return false;
    }

    $decoded = json_decode($text, true);
    if (json_last_error() === JSON_ERROR_NONE) {
        return isset($decoded[0]) && is_array($decoded[0]) && array_key_exists('source', $decoded[0]);
    }

    // WordPress may have already truncated the migrated JSON excerpt.
    return true;
}

function iwlz_theme_site_initial()
{
    $name = trim(get_bloginfo('name'));
    if ($name === '') {
        return 'W';
    }

    return function_exists('mb_substr') ? mb_substr($name, 0, 1, 'UTF-8') : substr($name, 0, 1);
}

function iwlz_theme_get_post_views($post_id = 0)
{
    $post_id = $post_id ?: get_the_ID();
    return (int) get_post_meta($post_id, 'post_views', true);
}

/**
 * Count one view per browser every 12 hours instead of on every wp_head call.
 */
function iwlz_theme_track_post_view()
{
    if (!is_singular('post') || is_preview() || is_admin()) {
        return;
    }

    $post_id = get_queried_object_id();
    $cookie_name = 'iwlz_viewed_' . $post_id;
    if (isset($_COOKIE[$cookie_name])) {
        return;
    }

    update_post_meta($post_id, 'post_views', iwlz_theme_get_post_views($post_id) + 1);
    setcookie($cookie_name, '1', time() + (12 * HOUR_IN_SECONDS), COOKIEPATH ?: '/', COOKIE_DOMAIN, is_ssl(), true);
    $_COOKIE[$cookie_name] = '1';
}
add_action('template_redirect', 'iwlz_theme_track_post_view');

function iwlz_theme_reading_time($post_id = 0)
{
    $post_id = $post_id ?: get_the_ID();
    $content = wp_strip_all_tags(strip_shortcodes(get_post_field('post_content', $post_id)));
    $length = function_exists('mb_strlen') ? mb_strlen($content, 'UTF-8') : strlen($content);

    return max(1, (int) ceil($length / 500));
}

function iwlz_theme_word_count($post_id = 0)
{
    $post_id = $post_id ?: get_the_ID();
    $content = wp_strip_all_tags(strip_shortcodes(get_post_field('post_content', $post_id)));
    $content = preg_replace('/\s+/u', '', $content);

    return function_exists('mb_strlen') ? mb_strlen($content, 'UTF-8') : strlen($content);
}

/**
 * Render migrated content without letting unmatched wrapper tags escape the article.
 */
function iwlz_theme_the_content()
{
    $content = apply_filters('the_content', get_the_content());
    echo force_balance_tags($content);
}

function iwlz_theme_pagination()
{
    global $wp_query;

    $links = paginate_links(array(
        'current' => max(1, get_query_var('paged')),
        'total' => max(1, (int) $wp_query->max_num_pages),
        'prev_text' => iwlz_theme_icon('chevron-left') . '<span class="screen-reader-text">' . esc_html__('上一页', 'iwlz-theme') . '</span>',
        'next_text' => iwlz_theme_icon('chevron-right') . '<span class="screen-reader-text">' . esc_html__('下一页', 'iwlz-theme') . '</span>',
        'type' => 'list',
        'mid_size' => 1,
        'end_size' => 1,
    ));

    if ($links) {
        // paginate_links() escapes URLs and labels; the label contains our trusted SVG icon.
        echo '<nav class="pagination" aria-label="' . esc_attr__('分页导航', 'iwlz-theme') . '">' . $links . '</nav>';
    }
}

function iwlz_theme_breadcrumb()
{
    if (is_front_page()) {
        return;
    }

    echo '<nav class="breadcrumb" aria-label="' . esc_attr__('面包屑', 'iwlz-theme') . '">';
    echo '<a href="' . esc_url(home_url('/')) . '">' . iwlz_theme_icon('home') . '<span>' . esc_html__('首页', 'iwlz-theme') . '</span></a>';

    if (is_single()) {
        $categories = get_the_category();
        if ($categories) {
            echo '<span>/</span><a href="' . esc_url(get_category_link($categories[0])) . '">' . esc_html($categories[0]->name) . '</a>';
        }
    } elseif (is_category() || is_tag() || is_archive()) {
        echo '<span>/</span><span>' . esc_html(wp_strip_all_tags(get_the_archive_title())) . '</span>';
    } elseif (is_page()) {
        echo '<span>/</span><span>' . esc_html(get_the_title()) . '</span>';
    } elseif (is_search()) {
        echo '<span>/</span><span>' . esc_html__('搜索结果', 'iwlz-theme') . '</span>';
    }

    echo '</nav>';
}

function iwlz_theme_menu_fallback($args = array())
{
    $class = is_object($args) && isset($args->menu_class)
        ? $args->menu_class
        : (isset($args['menu_class']) ? $args['menu_class'] : 'primary-menu');
    echo '<ul class="' . esc_attr($class) . '">';
    echo '<li class="menu-item ' . (is_front_page() ? 'current-menu-item' : '') . '"><a href="' . esc_url(home_url('/')) . '">' . esc_html__('首页', 'iwlz-theme') . '</a></li>';

    $categories = get_categories(array('number' => 5, 'orderby' => 'count', 'order' => 'DESC'));
    foreach ($categories as $category) {
        echo '<li class="menu-item"><a href="' . esc_url(get_category_link($category)) . '">' . esc_html($category->name) . '</a></li>';
    }

    echo '</ul>';
}

function iwlz_theme_author_cover()
{
    $custom = get_theme_mod('iwlz_author_background', '');
    if ($custom) {
        return $custom;
    }

    $posts = get_posts(array(
        'numberposts' => 1,
        'meta_key' => '_thumbnail_id',
        'post_status' => 'publish',
    ));

    if ($posts) {
        return get_the_post_thumbnail_url($posts[0]->ID, 'large');
    }

    return '';
}

function iwlz_theme_default_thumbnail()
{
    return get_theme_mod('iwlz_default_thumbnail', '');
}

function iwlz_theme_customize_register($wp_customize)
{
    $wp_customize->add_section('iwlz_joe3_options', array(
        'title' => __('Joe3 主题设置', 'iwlz-theme'),
        'priority' => 35,
    ));

    $wp_customize->add_setting('accent_color', array(
        'default' => '#fb6c28',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'accent_color', array(
        'label' => __('浅色模式主题色', 'iwlz-theme'),
        'section' => 'colors',
    )));

    $wp_customize->add_setting('accent_color_dark', array(
        'default' => '#9999ff',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'accent_color_dark', array(
        'label' => __('深色模式主题色', 'iwlz-theme'),
        'section' => 'colors',
    )));

    $wp_customize->add_setting('iwlz_notice_text', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('iwlz_notice_text', array(
        'label' => __('首页公告', 'iwlz-theme'),
        'section' => 'iwlz_joe3_options',
        'type' => 'text',
    ));

    $wp_customize->add_setting('iwlz_notice_url', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('iwlz_notice_url', array(
        'label' => __('公告链接', 'iwlz-theme'),
        'section' => 'iwlz_joe3_options',
        'type' => 'url',
    ));

    $wp_customize->add_setting('iwlz_author_background', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'iwlz_author_background', array(
        'label' => __('作者卡背景图', 'iwlz-theme'),
        'section' => 'iwlz_joe3_options',
    )));

    $wp_customize->add_setting('iwlz_default_thumbnail', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'iwlz_default_thumbnail', array(
        'label' => __('默认文章封面', 'iwlz-theme'),
        'section' => 'iwlz_joe3_options',
    )));

    $wp_customize->add_setting('iwlz_footer_text', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('iwlz_footer_text', array(
        'label' => __('页脚补充文字', 'iwlz-theme'),
        'section' => 'iwlz_joe3_options',
        'type' => 'text',
    ));
}
add_action('customize_register', 'iwlz_theme_customize_register');

function iwlz_theme_comment($comment, $args, $depth)
{
    ?>
    <li <?php comment_class('comment-item'); ?> id="comment-<?php comment_ID(); ?>">
        <article class="comment-body">
            <div class="comment-avatar"><?php echo get_avatar($comment, 48); ?></div>
            <div class="comment-main">
                <header class="comment-header">
                    <strong class="comment-author"><?php echo wp_kses_post(get_comment_author_link()); ?></strong>
                    <time datetime="<?php comment_time('c'); ?>">
                        <?php echo esc_html(human_time_diff(get_comment_time('U'), current_time('timestamp'))) . esc_html__('前', 'iwlz-theme'); ?>
                    </time>
                </header>
                <div class="comment-content"><?php comment_text(); ?></div>
                <div class="reply">
                    <?php
                    comment_reply_link(array_merge($args, array(
                        'depth' => $depth,
                        'max_depth' => $args['max_depth'],
                        'reply_text' => __('回复', 'iwlz-theme'),
                    )));
                    ?>
                </div>
            </div>
        </article>
    <?php
}

function iwlz_theme_translate_widget_title($title)
{
    $translations = array(
        'Recent Posts' => '最新文章',
        'Recent Comments' => '最近评论',
        'Archives' => '归档',
        'Categories' => '分类',
        'Meta' => '功能',
        'Search' => '搜索',
        'Pages' => '页面',
        'Calendar' => '日历',
        'Tag Cloud' => '标签云',
        'Navigation Menu' => '导航菜单',
        'Custom Menu' => '自定义菜单',
    );

    return $translations[$title] ?? $title;
}
add_filter('widget_title', 'iwlz_theme_translate_widget_title');

/**
 * Small Lucide icon subset used by the theme.
 */
function iwlz_theme_icon($name, $class = '')
{
    $paths = array(
        'home' => '<path d="m3 11 9-8 9 8"/><path d="M5 10v10h14V10"/><path d="M9 20v-6h6v6"/>',
        'menu' => '<path d="M4 6h16M4 12h16M4 18h16"/>',
        'x' => '<path d="m18 6-12 12M6 6l12 12"/>',
        'search' => '<circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>',
        'sun' => '<circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.42 1.42M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.42-1.42M17.66 6.34l1.41-1.41"/>',
        'moon' => '<path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>',
        'calendar' => '<path d="M8 2v4M16 2v4M3 10h18"/><rect width="18" height="18" x="3" y="4" rx="2"/>',
        'eye' => '<path d="M2.06 12.35a1 1 0 0 1 0-.7C3.6 7.6 7.5 5 12 5s8.4 2.6 9.94 6.65a1 1 0 0 1 0 .7C20.4 16.4 16.5 19 12 19s-8.4-2.6-9.94-6.65Z"/><circle cx="12" cy="12" r="3"/>',
        'message' => '<path d="M21 15a4 4 0 0 1-4 4H8l-5 3V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4z"/>',
        'folder' => '<path d="M3 5h6l2 2h10v12H3z"/>',
        'tag' => '<path d="M12.586 2.586A2 2 0 0 0 11.172 2H4a2 2 0 0 0-2 2v7.172a2 2 0 0 0 .586 1.414l8.704 8.704a2.426 2.426 0 0 0 3.42 0l6.58-6.58a2.426 2.426 0 0 0 0-3.42z"/><circle cx="7.5" cy="7.5" r=".5" fill="currentColor"/>',
        'clock' => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
        'flame' => '<path d="M12 22c4.4 0 7-3.1 7-7.2 0-3.2-1.7-6.2-5.1-8.8.1 2.2-.8 3.8-2.1 4.8.1-3.2-1.8-6.1-4.2-8.8.2 3.8-2.6 6.4-2.6 10.5C5 17.8 8.1 22 12 22Z"/>',
        'book' => '<path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20V4H6.5A2.5 2.5 0 0 0 4 6.5z"/><path d="M4 6.5v13"/>',
        'rss' => '<path d="M4 11a9 9 0 0 1 9 9M4 4a16 16 0 0 1 16 16"/><circle cx="5" cy="19" r="1"/>',
        'user' => '<circle cx="12" cy="8" r="4"/><path d="M4 22a8 8 0 0 1 16 0"/>',
        'arrow-up' => '<path d="m18 15-6-6-6 6"/>',
        'chevron-left' => '<path d="m15 18-6-6 6-6"/>',
        'chevron-right' => '<path d="m9 18 6-6-6-6"/>',
        'copy' => '<rect width="14" height="14" x="8" y="8" rx="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/>',
        'check' => '<path d="m20 6-11 11-5-5"/>',
    );

    if (!isset($paths[$name])) {
        return '';
    }

    return '<svg class="icon ' . esc_attr($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $paths[$name] . '</svg>';
}
