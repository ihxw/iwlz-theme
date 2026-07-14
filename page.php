<?php
/**
 * Page template.
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
                <article id="post-<?php the_ID(); ?>" <?php post_class('article-panel page-panel joe-panel'); ?>>
                    <header class="article-header">
                        <span class="article-kicker"><?php echo iwlz_theme_icon('book'); ?><?php esc_html_e('页面', 'iwlz-theme'); ?></span>
                        <h1><?php the_title(); ?></h1>
                        <?php if (get_the_modified_date()) : ?>
                            <p class="page-updated"><?php echo iwlz_theme_icon('calendar'); ?><?php printf(esc_html__('更新于 %s', 'iwlz-theme'), esc_html(get_the_modified_date('Y-m-d'))); ?></p>
                        <?php endif; ?>
                    </header>
                    <?php if (has_post_thumbnail()) : ?>
                        <figure class="article-cover"><?php the_post_thumbnail('large', array('alt' => get_the_title())); ?></figure>
                    <?php endif; ?>
                    <div class="entry-content" id="article-content">
                        <?php iwlz_theme_the_content(); ?>
                        <?php wp_link_pages(array('before' => '<nav class="page-links">' . esc_html__('页面：', 'iwlz-theme'), 'after' => '</nav>')); ?>
                    </div>
                </article>
                <?php if (comments_open() || get_comments_number()) : ?>
                    <?php comments_template(); ?>
                <?php endif; ?>
            <?php endwhile; ?>
        </div>
        <?php get_sidebar(); ?>
    </div>
</div>
<?php
get_footer();
