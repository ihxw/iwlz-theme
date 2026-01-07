<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <div class="site-wrapper">
        <header class="site-header">
            <div class="container">
                <nav class="main-navigation">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_class' => 'primary-menu',
                        'container' => false,
                        'fallback_cb' => false,
                        'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    ));
                    ?>

                    <div class="header-search">
                        <form role="search" method="get" class="header-search-form"
                            action="<?php echo esc_url(home_url('/')); ?>">
                            <input type="search" class="header-search-field"
                                placeholder="<?php echo esc_attr_x('搜索...', 'placeholder', 'iwlz-theme'); ?>"
                                value="<?php echo get_search_query(); ?>" name="s" />
                        </form>
                    </div>

                    <button class="theme-toggle" id="theme-toggle"
                        aria-label="<?php echo esc_attr__('切换主题', 'iwlz-theme'); ?>">
                        <span class="theme-toggle-icon">🌓</span>
                    </button>
                </nav>
            </div>
        </header>

        <main class="site-content">