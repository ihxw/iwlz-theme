<?php
/**
 * 归档页面模板
 *
 * @package Libra_Theme
 */

get_header();
?>

<div class="container">
    <div class="content-area" style="display:flex;gap:30px;align-items:flex-start;">
        <div class="main-content" style="flex:1;min-width:0;">
            <?php if (have_posts()): ?>
                <ul class="post-list">
                    <?php while (have_posts()):
                        the_post(); ?>
                        <li class="post-item">
                            <div class="post-avatar">
                                <a href="<?php the_permalink(); ?>">
                                    <?php if (has_post_thumbnail()): ?>
                                        <?php the_post_thumbnail('large', array('alt' => get_the_title())); ?>
                                    <?php else: ?>
                                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/screenshot.png"
                                            alt="<?php echo esc_attr(get_the_title()); ?>">
                                    <?php endif; ?>
                                </a>
                                <?php $categories = get_the_category(); if (!empty($categories)): ?>
                                    <a class="post-category-badge" href="<?php echo esc_url(get_category_link($categories[0]->term_id)); ?>">
                                        <?php echo esc_html($categories[0]->name); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="post-content-wrapper">
                                <h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                <div class="post-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 40, '...'); ?></div>
                                <div class="post-meta">
                                    <span><?php echo get_the_date('Y-m-d'); ?></span>
                                </div>
                            </div>
                        </li>
                    <?php endwhile; ?>
                </ul>
                <?php iwlz_theme_pagination(); ?>
            <?php else: ?>
                <div class="card" style="background:var(--bg-secondary);border-radius:12px;padding:40px;text-align:center;">
                    <h2><?php esc_html_e('未找到内容', 'iwlz-theme'); ?></h2>
                    <p><?php esc_html_e('抱歉，没有找到任何内容。', 'iwlz-theme'); ?></p>
                    <?php get_search_form(); ?>
                </div>
            <?php endif; ?>
        </div>
        <?php get_sidebar(); ?>
    </div>
</div>

<?php
get_footer();
