<?php
/**
 * IWLZ Theme functions and definitions
 *
 * @package Libra_Theme
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * 设置主题
 */
function iwlz_theme_setup()
{
    // 加载翻译文件
    load_theme_textdomain('iwlz-theme', get_template_directory() . '/languages');

    // 添加默认的文章和评论 RSS feed 链接到头部
    add_theme_support('automatic-feed-links');

    // 让 WordPress 管理文档标题
    add_theme_support('title-tag');

    // 启用文章缩略图支持
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(1200, 675, true);

    // 注册导航菜单
    register_nav_menus(array(
        'primary' => __('主导航菜单', 'iwlz-theme'),
    ));

    // 切换到 HTML5 标记
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // 添加自定义背景支持
    add_theme_support('custom-background', array(
        'default-color' => 'f5f5f7',
    ));

    // 添加自定义 Logo 支持
    add_theme_support('custom-logo', array(
        'height' => 60,
        'width' => 200,
        'flex-height' => true,
        'flex-width' => true,
    ));

    // 添加编辑器样式
    add_editor_style();
}
add_action('after_setup_theme', 'iwlz_theme_setup');

/**
 * 设置内容宽度
 */
function iwlz_theme_content_width()
{
    $GLOBALS['content_width'] = apply_filters('iwlz_theme_content_width', 960);
}
add_action('after_setup_theme', 'iwlz_theme_content_width', 0);

/**
 * 注册小工具区域
 */
function iwlz_theme_widgets_init()
{
    register_sidebar(array(
        'name' => __('侧边栏', 'iwlz-theme'),
        'id' => 'sidebar-1',
        'description' => __('在侧边栏显示小工具', 'iwlz-theme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'iwlz_theme_widgets_init');

/**
 * 加载脚本和样式
 */
function iwlz_theme_scripts()
{
    // 获取主题版本号
    $theme_version = wp_get_theme()->get('Version');

    // 主样式表
    wp_enqueue_style('iwlz-theme-style', get_stylesheet_uri(), array(), $theme_version);

    // 主题切换脚本
    wp_enqueue_script('iwlz-theme-switcher', get_template_directory_uri() . '/js/theme-switcher.js', array(), $theme_version, true);

    // 移动端搜索脚本
    wp_enqueue_script('iwlz-mobile-search', get_template_directory_uri() . '/js/mobile-search.js', array(), $theme_version, true);

    // 评论回复脚本
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'iwlz_theme_scripts');

/**
 * 自定义摘要长度
 */
function iwlz_theme_excerpt_length($length)
{
    return 60;
}
add_filter('excerpt_length', 'iwlz_theme_excerpt_length', 999);

/**
 * 自定义摘要省略号
 */
function iwlz_theme_excerpt_more($more)
{
    return '...';
}
add_filter('excerpt_more', 'iwlz_theme_excerpt_more');

/**
 * 获取文章作者头像
 */
function iwlz_theme_get_avatar_url($author_id)
{
    $avatar_url = get_avatar_url($author_id, array('size' => 96));
    return $avatar_url;
}

/**
 * 获取文章评论数
 */
function iwlz_theme_get_comments_number()
{
    $num_comments = get_comments_number();
    if ($num_comments == 0) {
        return '0';
    } elseif ($num_comments > 999) {
        return '999+';
    } else {
        return $num_comments;
    }
}

/**
 * 自定义分页
 */
function iwlz_theme_pagination()
{
    global $wp_query;

    $big = 999999999; // 需要一个不太可能的整数

    $paginate_links = paginate_links(array(
        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages,
        'prev_text' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10 12L6 8L10 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        'next_text' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        'type' => 'list',
        'mid_size' => 2,
        'end_size' => 1,
        'show_all' => false,
    ));

    if ($paginate_links) {
        echo '<nav class="pagination" role="navigation" aria-label="分页导航">';
        echo $paginate_links;
        echo '</nav>';
    }
}


/**
 * 面包屑导航
 */
function iwlz_theme_breadcrumb()
{
    if (is_front_page()) {
        return;
    }

    echo '<nav class="breadcrumb">';
    echo '<a href="' . home_url('/') . '">首页</a>';

    if (is_category() || is_single()) {
        echo ' / ';
        the_category(', ');
        if (is_single()) {
            echo ' / ';
            the_title();
        }
    } elseif (is_page()) {
        echo ' / ';
        the_title();
    } elseif (is_search()) {
        echo ' / 搜索结果: ';
        the_search_query();
    } elseif (is_404()) {
        echo ' / 404 错误';
    }

    echo '</nav>';
}

/**
 * 添加主题自定义器设置
 */
function iwlz_theme_customize_register($wp_customize)
{
    // 添加主题颜色设置
    $wp_customize->add_setting('accent_color', array(
        'default' => '#6419e6',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'accent_color', array(
        'label' => __('主题色', 'iwlz-theme'),
        'section' => 'colors',
        'settings' => 'accent_color',
    )));
}
add_action('customize_register', 'iwlz_theme_customize_register');

/**
 * 输出自定义颜色 CSS
 */
function iwlz_theme_customize_css()
{
    $accent_color = get_theme_mod('accent_color', '#6419e6');
    ?>
    <style type="text/css">
        :root {
            --accent-color:
                <?php echo esc_attr($accent_color); ?>
            ;
        }
    </style>
    <?php
}
add_action('wp_head', 'iwlz_theme_customize_css');

/**
 * 添加默认小工具
 */
function iwlz_theme_default_widgets()
{
    // 检查是否已经设置过小工具
    if (get_option('iwlz_theme_widgets_set')) {
        return;
    }

    // 搜索小工具
    $search_widget = array(
        'title' => '搜索',
    );

    // 最新文章小工具
    $recent_posts_widget = array(
        'title' => '最新文章',
        'number' => 5,
    );

    // 分类小工具
    $categories_widget = array(
        'title' => '分类',
    );

    // 标记为已设置
    update_option('iwlz_theme_widgets_set', true);
}
add_action('after_switch_theme', 'iwlz_theme_default_widgets');

/**
 * 自定义评论列表
 */
function iwlz_theme_comment($comment, $args, $depth)
{
    $GLOBALS['comment'] = $comment;
    ?>
    <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
        <article class="comment-body">
            <div class="comment-author vcard">
                <?php echo get_avatar($comment, 48); ?>
                <b class="fn"><?php echo get_comment_author_link(); ?></b>
            </div>
            <div class="comment-meta">
                <time datetime="<?php comment_time('c'); ?>">
                    <?php printf(__('%s 前', 'iwlz-theme'), human_time_diff(get_comment_time('U'), current_time('timestamp'))); ?>
                </time>
            </div>
            <div class="comment-content">
                <?php comment_text(); ?>
            </div>
            <div class="reply">
                <?php comment_reply_link(array_merge($args, array(
                    'depth' => $depth,
                    'max_depth' => $args['max_depth'],
                ))); ?>
            </div>
        </article>
        <?php
}

/**
 * 翻译 WordPress 核心小组件标题
 */
function iwlz_theme_translate_widget_title($title)
{
    // 如果标题为空,直接返回
    if (empty($title)) {
        return $title;
    }

    // 定义翻译映射
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
        'RSS' => 'RSS',
        'Text' => '文本',
    );

    // 如果标题在翻译映射中,返回翻译
    if (isset($translations[$title])) {
        return $translations[$title];
    }

    return $title;
}
add_filter('widget_title', 'iwlz_theme_translate_widget_title');
