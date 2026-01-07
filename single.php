<?php
/**
 * 单篇文章模板
 *
 * @package Libra_Theme
 */

get_header();
?>

<div class="container">
    <div class="content-area">
        <div class="main-content">
            <?php while (have_posts()):
                the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>
                    <header class="entry-header <?php echo has_post_thumbnail() ? 'has-thumbnail' : ''; ?>" 
                            <?php if ( has_post_thumbnail() ) : ?>
                                style="background-image: url('<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'large' ) ); ?>');"
                            <?php endif; ?>>
                        <div class="entry-header-content">
                            <?php iwlz_theme_breadcrumb(); ?>

                            <h1 class="entry-title">
                                <?php the_title(); ?>
                            </h1>

                            <div class="post-meta">
                                <?php
                                $categories = get_the_category();
                                if ( ! empty( $categories ) ) {
                                    echo '<span class="post-category">';
                                    echo esc_html( $categories[0]->name );
                                    echo '</span>';
                                }
                                ?>

                                <span class="post-author">
                                    <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
                                        <?php the_author(); ?>
                                    </a>
                                </span>

                                <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                                    <?php echo get_the_date(); ?>
                                </time>

                                <span>💬
                                    <?php echo iwlz_theme_get_comments_number(); ?>
                                </span>
                            </div>
                        </div>
                    </header>

                    <div class="entry-content">
                        <?php
                        the_content();

                        wp_link_pages(array(
                            'before' => '<div class="page-links">' . esc_html__('页面:', 'iwlz-theme'),
                            'after' => '</div>',
                        ));
                        ?>
                    </div>

                    <footer class="entry-footer">
                        <?php
                        $tags_list = get_the_tag_list('', ' ');
                        if ($tags_list) {
                            printf('<div class="tags-links">%s</div>', $tags_list);
                        }
                        ?>
                    </footer>

                    <?php
                    // 评论区
                    if (comments_open() || get_comments_number()):
                        comments_template();
                    endif;
                    ?>
                </article>

                <?php
                // 上一篇/下一篇导航
                the_post_navigation(array(
                    'prev_text' => '<span class="nav-subtitle">' . esc_html__('上一篇', 'iwlz-theme') . '</span> <span class="nav-title">%title</span>',
                    'next_text' => '<span class="nav-subtitle">' . esc_html__('下一篇', 'iwlz-theme') . '</span> <span class="nav-title">%title</span>',
                ));
                ?>

            <?php endwhile; ?>
        </div>

        <?php get_sidebar(); ?>
    </div>
</div>

<?php
get_footer();
