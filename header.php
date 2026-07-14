<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <script>
        (function () {
            try {
                var saved = localStorage.getItem('iwlz-theme');
                var dark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                document.documentElement.dataset.theme = saved || (dark ? 'dark' : 'light');
                document.documentElement.classList.add('js');
            } catch (e) {
                document.documentElement.dataset.theme = 'light';
            }
        }());
    </script>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="site-wrapper">
    <header class="site-header" id="site-header">
        <div class="header-inner container">
            <button class="icon-button mobile-menu-toggle" id="mobile-menu-toggle" type="button"
                aria-label="<?php esc_attr_e('打开导航', 'iwlz-theme'); ?>" aria-controls="mobile-drawer" aria-expanded="false">
                <?php echo iwlz_theme_icon('menu'); ?>
            </button>

            <div class="site-branding">
                <?php if (has_custom_logo()) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <a class="site-brand" href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                        <span class="site-brand-mark"><?php echo esc_html(iwlz_theme_site_initial()); ?></span>
                        <span class="site-brand-name"><?php bloginfo('name'); ?></span>
                    </a>
                <?php endif; ?>
            </div>

            <nav class="desktop-navigation" aria-label="<?php esc_attr_e('主导航', 'iwlz-theme'); ?>">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_class' => 'primary-menu',
                    'container' => false,
                    'fallback_cb' => 'iwlz_theme_menu_fallback',
                    'depth' => 2,
                ));
                ?>
            </nav>

            <div class="header-actions">
                <button class="icon-button" id="search-toggle" type="button"
                    aria-label="<?php esc_attr_e('搜索', 'iwlz-theme'); ?>" aria-controls="search-panel" aria-expanded="false">
                    <?php echo iwlz_theme_icon('search'); ?>
                </button>
                <button class="icon-button theme-toggle" id="theme-toggle" type="button"
                    aria-label="<?php esc_attr_e('切换深色模式', 'iwlz-theme'); ?>" aria-pressed="false">
                    <span class="theme-icon theme-icon-sun"><?php echo iwlz_theme_icon('sun'); ?></span>
                    <span class="theme-icon theme-icon-moon"><?php echo iwlz_theme_icon('moon'); ?></span>
                </button>
            </div>
        </div>

        <div class="search-panel" id="search-panel" hidden>
            <div class="search-panel-inner container">
                <?php get_search_form(); ?>
                <button class="icon-button search-close" id="search-close" type="button" aria-label="<?php esc_attr_e('关闭搜索', 'iwlz-theme'); ?>">
                    <?php echo iwlz_theme_icon('x'); ?>
                </button>
            </div>
        </div>
    </header>

    <aside class="mobile-drawer" id="mobile-drawer" aria-hidden="true" inert>
        <div class="mobile-drawer-header">
            <a class="mobile-drawer-brand" href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
            <button class="icon-button" id="mobile-menu-close" type="button" aria-label="<?php esc_attr_e('关闭导航', 'iwlz-theme'); ?>">
                <?php echo iwlz_theme_icon('x'); ?>
            </button>
        </div>
        <p class="mobile-drawer-description"><?php bloginfo('description'); ?></p>
        <nav class="mobile-navigation" aria-label="<?php esc_attr_e('移动导航', 'iwlz-theme'); ?>">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_class' => 'mobile-menu',
                'container' => false,
                'fallback_cb' => 'iwlz_theme_menu_fallback',
                'depth' => 2,
            ));
            ?>
        </nav>
        <div class="mobile-drawer-links">
            <a href="<?php echo esc_url(get_feed_link()); ?>"><?php echo iwlz_theme_icon('rss'); ?><?php esc_html_e('订阅', 'iwlz-theme'); ?></a>
            <a href="<?php echo esc_url(wp_login_url()); ?>"><?php echo iwlz_theme_icon('user'); ?><?php esc_html_e('登录', 'iwlz-theme'); ?></a>
        </div>
    </aside>
    <button class="drawer-mask" id="drawer-mask" type="button" aria-label="<?php esc_attr_e('关闭导航', 'iwlz-theme'); ?>" hidden></button>

    <main class="site-content" id="content">
