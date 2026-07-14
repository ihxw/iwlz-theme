<?php
/**
 * Single post template.
 *
 * @package IWLZ_Theme
 */

get_header();
?>
<div class="page-shell container">
    <?php iwlz_theme_breadcrumb(); ?>

    <div class="content-grid detail-grid">
        <div class="main-column">
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('article-panel joe-panel'); ?>>
                    <header class="article-header">
                        <?php $categories = get_the_category(); ?>
                        <?php if ($categories) : ?>
                            <a class="article-kicker" href="<?php echo esc_url(get_category_link($categories[0])); ?>">
                                <?php echo iwlz_theme_icon('folder'); ?>
                                <?php echo esc_html($categories[0]->name); ?>
                            </a>
                        <?php endif; ?>
                        <h1><?php the_title(); ?></h1>
                        <ul class="article-meta" aria-label="<?php esc_attr_e('文章信息', 'iwlz-theme'); ?>">
                            <li><?php echo iwlz_theme_icon('user'); ?><?php the_author_posts_link(); ?></li>
                            <li><?php echo iwlz_theme_icon('calendar'); ?><time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('Y-m-d')); ?></time></li>
                            <li><?php echo iwlz_theme_icon('eye'); ?><span><?php echo esc_html(number_format_i18n(iwlz_theme_get_post_views())); ?> <?php esc_html_e('阅读', 'iwlz-theme'); ?></span></li>
                            <li><?php echo iwlz_theme_icon('book'); ?><span><?php echo esc_html(number_format_i18n(iwlz_theme_word_count())); ?> <?php esc_html_e('字', 'iwlz-theme'); ?></span></li>
                            <li><?php echo iwlz_theme_icon('clock'); ?><span><?php echo esc_html(iwlz_theme_reading_time()); ?> <?php esc_html_e('分钟', 'iwlz-theme'); ?></span></li>
                            <li><?php echo iwlz_theme_icon('message'); ?><a href="#comments"><?php echo esc_html(number_format_i18n(get_comments_number())); ?> <?php esc_html_e('评论', 'iwlz-theme'); ?></a></li>
                        </ul>
                    </header>

                    <?php if (has_post_thumbnail()) : ?>
                        <figure class="article-cover"><?php the_post_thumbnail('large', array('alt' => get_the_title())); ?></figure>
                    <?php endif; ?>

                    <div class="entry-content" id="article-content">
                        <?php iwlz_theme_the_content(); ?>
                        <?php
                        wp_link_pages(array(
                            'before' => '<nav class="page-links">' . esc_html__('页面：', 'iwlz-theme'),
                            'after' => '</nav>',
                        ));
                        ?>
                    </div>

                    <footer class="article-footer">
                        <?php $tags = get_the_tags(); ?>
                        <?php if ($tags) : ?>
                            <div class="article-tags">
                                <?php echo iwlz_theme_icon('tag'); ?>
                                <?php foreach ($tags as $tag) : ?>
                                    <a href="<?php echo esc_url(get_tag_link($tag)); ?>">#<?php echo esc_html($tag->name); ?></a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <div class="article-copyright">
                            <strong><?php esc_html_e('本文信息', 'iwlz-theme'); ?></strong>
                            <p><?php esc_html_e('转载请保留原文链接，并尊重作者署名与站点声明。', 'iwlz-theme'); ?></p>
                        </div>
                    </footer>
                </article>

                <?php
                $category_ids = wp_list_pluck(get_the_category(), 'term_id');
                $related_args = array(
                    'posts_per_page' => 3,
                    'post__not_in' => array(get_the_ID()),
                    'ignore_sticky_posts' => true,
                );
                $related = null;
                if ($category_ids) {
                    $related_args['category__in'] = $category_ids;
                    $related = new WP_Query($related_args);
                } else {
                    $tag_ids = wp_list_pluck((array) get_the_tags(), 'term_id');
                    if ($tag_ids) {
                        $related_args['tag__in'] = $tag_ids;
                        $related = new WP_Query($related_args);
                    }
                }
                ?>
                <?php if ($related && $related->have_posts()) : ?>
                    <section class="related-panel joe-panel">
                        <h2 class="panel-title"><?php echo iwlz_theme_icon('book'); ?><span><?php esc_html_e('相关文章', 'iwlz-theme'); ?></span></h2>
                        <div class="related-grid">
                            <?php while ($related->have_posts()) : $related->the_post(); ?>
                                <article class="related-card">
                                    <a class="related-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <?php the_post_thumbnail('iwlz-related', array('alt' => '', 'loading' => 'lazy')); ?>
                                        <?php else : ?>
                                            <span><?php echo esc_html(iwlz_theme_site_initial()); ?></span>
                                        <?php endif; ?>
                                    </a>
                                    <div>
                                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                        <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('Y-m-d')); ?></time>
                                    </div>
                                </article>
                            <?php endwhile; ?>
                        </div>
                    </section>
                <?php endif; ?>
                <?php if ($related) : ?>
                    <?php wp_reset_postdata(); ?>
                <?php endif; ?>

                <?php
                the_post_navigation(array(
                    'prev_text' => '<span>' . esc_html__('上一篇', 'iwlz-theme') . '</span><strong>%title</strong>',
                    'next_text' => '<span>' . esc_html__('下一篇', 'iwlz-theme') . '</span><strong>%title</strong>',
                ));
                ?>

                <?php if (comments_open() || get_comments_number()) : ?>
                    <?php comments_template(); ?>
                <?php endif; ?>
            <?php endwhile; ?>
        </div>

        <?php get_sidebar(); ?>
    </div>

    <button class="mobile-toc-trigger" id="mobile-toc-trigger" type="button" hidden
        aria-label="<?php esc_attr_e('打开文章目录', 'iwlz-theme'); ?>" aria-controls="mobile-toc-dialog" aria-expanded="false">
        <?php echo iwlz_theme_icon('book'); ?>
    </button>
    <div class="mobile-toc-dialog" id="mobile-toc-dialog" aria-hidden="true" hidden inert>
        <button class="mobile-toc-mask" id="mobile-toc-mask" type="button" aria-label="<?php esc_attr_e('关闭文章目录', 'iwlz-theme'); ?>"></button>
        <section class="mobile-toc-sheet" role="dialog" aria-modal="true" aria-labelledby="mobile-toc-title">
            <header>
                <h2 id="mobile-toc-title"><?php echo iwlz_theme_icon('book'); ?><?php esc_html_e('文章目录', 'iwlz-theme'); ?></h2>
                <button class="icon-button" id="mobile-toc-close" type="button" aria-label="<?php esc_attr_e('关闭文章目录', 'iwlz-theme'); ?>">
                    <?php echo iwlz_theme_icon('x'); ?>
                </button>
            </header>
            <nav id="mobile-post-toc" aria-label="<?php esc_attr_e('移动端文章目录', 'iwlz-theme'); ?>"></nav>
        </section>
    </div>
</div>
<?php
get_footer();
