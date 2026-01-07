<?php
/**
 * 搜索结果模板
 *
 * @package Libra_Theme
 */

get_header();
?>

<div class="container">
    <div class="content-area">
        <div class="main-content">
            <?php if (have_posts()): ?>

                <!-- 搜索结果提示 - 低调显示 -->
                <div class="search-results-info">
                    <span class="search-label">搜索:</span>
                    <span class="search-query"><?php echo get_search_query(); ?></span>
                    <span class="search-count">(找到 <?php echo $wp_query->found_posts; ?> 个结果)</span>
                </div>

                <ul class="post-list">
                    <?php while (have_posts()):
                        the_post(); ?>
                        <li class="post-item">
                            <div class="post-avatar">
                                <?php if (has_post_thumbnail()): ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('thumbnail', array('alt' => get_the_title())); ?>
                                    </a>
                                <?php else: ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='150' height='150'%3E%3Crect fill='%23e5e5e7' width='150' height='150'/%3E%3Ctext fill='%23999' font-family='sans-serif' font-size='14' x='50%25' y='50%25' text-anchor='middle' dy='.3em'%3E无图片%3C/text%3E%3C/svg%3E"
                                            alt="<?php echo esc_attr(get_the_title()); ?>">
                                    </a>
                                <?php endif; ?>
                            </div>

                            <div class="post-content-wrapper">
                                <h2 class="post-title">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h2>

                                <div class="post-meta">
                                    <?php
                                    $categories = get_the_category();
                                    if (!empty($categories)) {
                                        echo '<span class="post-category">';
                                        echo esc_html($categories[0]->name);
                                        echo '</span>';
                                    }
                                    ?>

                                    <span class="post-author">
                                        <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                            <?php the_author(); ?>
                                        </a>
                                    </span>

                                    <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                        <?php echo get_the_date(); ?>
                                    </time>
                                </div>

                                <div class="post-excerpt">
                                    <?php the_excerpt(); ?>
                                </div>
                            </div>
                        </li>
                    <?php endwhile; ?>
                </ul>

                <?php iwlz_theme_pagination(); ?>

            <?php else: ?>
                <div class="card">
                    <h2><?php esc_html_e('未找到内容', 'iwlz-theme'); ?></h2>
                    <p><?php esc_html_e('抱歉，没有找到与您的搜索相关的内容。请尝试其他关键词。', 'iwlz-theme'); ?></p>
                    <?php get_search_form(); ?>
                </div>
            <?php endif; ?>
        </div>

        <?php get_sidebar(); ?>
    </div>
</div>

<?php
get_footer();
