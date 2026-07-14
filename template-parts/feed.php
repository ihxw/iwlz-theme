<?php
/**
 * Shared list layout for home, archives and search.
 *
 * @package IWLZ_Theme
 */

$title = $args['title'] ?? __('最新文章', 'iwlz-theme');
$description = $args['description'] ?? '';
$notice = $args['notice'] ?? '';
$notice_url = $args['notice_url'] ?? '';
?>
<div class="page-shell container">
    <?php if (!is_front_page()) : ?>
        <?php iwlz_theme_breadcrumb(); ?>
    <?php endif; ?>

    <div class="content-grid">
        <div class="main-column">
            <section class="feed-panel joe-panel">
                <header class="feed-header">
                    <div>
                        <h1><?php echo esc_html($title); ?></h1>
                        <?php if ($description) : ?>
                            <div class="feed-description"><?php echo wp_kses_post($description); ?></div>
                        <?php endif; ?>
                    </div>
                    <?php if ($notice) : ?>
                        <div class="feed-notice">
                            <?php echo iwlz_theme_icon('message'); ?>
                            <?php if ($notice_url) : ?>
                                <a href="<?php echo esc_url($notice_url); ?>"><?php echo esc_html($notice); ?></a>
                            <?php else : ?>
                                <span><?php echo esc_html($notice); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </header>

                <?php if (have_posts()) : ?>
                    <ul class="post-list">
                        <?php while (have_posts()) : the_post(); ?>
                            <?php get_template_part('template-parts/post-card'); ?>
                        <?php endwhile; ?>
                    </ul>
                <?php else : ?>
                    <div class="empty-state">
                        <span class="empty-state-icon"><?php echo iwlz_theme_icon('search'); ?></span>
                        <h2><?php esc_html_e('这里暂时没有内容', 'iwlz-theme'); ?></h2>
                        <p><?php esc_html_e('换个关键词，或返回首页看看最新文章。', 'iwlz-theme'); ?></p>
                        <a class="button" href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('返回首页', 'iwlz-theme'); ?></a>
                    </div>
                <?php endif; ?>
            </section>

            <?php iwlz_theme_pagination(); ?>
        </div>

        <?php get_sidebar(); ?>
    </div>
</div>
