<?php
/**
 * Joe3-style sidebar.
 *
 * @package IWLZ_Theme
 */

$author_id = 0;
if (is_singular()) {
    $author_id = (int) get_post_field('post_author', get_queried_object_id());
}
if (!$author_id) {
    $authors = get_users(array('role__in' => array('administrator', 'editor'), 'number' => 1, 'orderby' => 'post_count', 'order' => 'DESC'));
    $author_id = $authors ? (int) $authors[0]->ID : 1;
}

$author_name = get_the_author_meta('display_name', $author_id) ?: get_bloginfo('name');
$author_description = get_the_author_meta('description', $author_id) ?: get_bloginfo('description');
$author_cover = iwlz_theme_author_cover();
$post_count = count_user_posts($author_id, 'post', true);
$category_count = wp_count_terms(array('taxonomy' => 'category', 'hide_empty' => true));
$comment_count = wp_count_comments()->approved;
?>
<aside class="sidebar" aria-label="<?php esc_attr_e('侧边栏', 'iwlz-theme'); ?>">
    <section class="author-card joe-panel">
        <div class="author-card-cover"<?php echo $author_cover ? ' style="background-image:url(' . esc_url($author_cover) . ')"' : ''; ?>></div>
        <div class="author-card-content">
            <?php echo get_avatar($author_id, 88, '', $author_name, array('class' => 'author-card-avatar')); ?>
            <h2><?php echo esc_html($author_name); ?></h2>
            <p><?php echo esc_html($author_description ?: __('记录技术，也记录生活。', 'iwlz-theme')); ?></p>
            <ul class="author-stats">
                <li><strong><?php echo esc_html(number_format_i18n($post_count)); ?></strong><span><?php esc_html_e('文章', 'iwlz-theme'); ?></span></li>
                <li><strong><?php echo esc_html(number_format_i18n($category_count)); ?></strong><span><?php esc_html_e('分类', 'iwlz-theme'); ?></span></li>
                <li><strong><?php echo esc_html(number_format_i18n($comment_count)); ?></strong><span><?php esc_html_e('评论', 'iwlz-theme'); ?></span></li>
            </ul>
            <div class="author-links">
                <a href="<?php echo esc_url(get_author_posts_url($author_id)); ?>"><?php echo iwlz_theme_icon('user'); ?><span><?php esc_html_e('作者主页', 'iwlz-theme'); ?></span></a>
                <a href="<?php echo esc_url(get_feed_link()); ?>"><?php echo iwlz_theme_icon('rss'); ?><span><?php esc_html_e('RSS', 'iwlz-theme'); ?></span></a>
            </div>
        </div>
    </section>

    <?php if (is_singular('post')) : ?>
        <section class="toc-panel joe-panel" id="toc-panel" hidden>
            <h2 class="panel-title"><?php echo iwlz_theme_icon('book'); ?><span><?php esc_html_e('文章目录', 'iwlz-theme'); ?></span></h2>
            <nav id="post-toc" aria-label="<?php esc_attr_e('文章目录', 'iwlz-theme'); ?>"></nav>
        </section>
    <?php endif; ?>

    <?php
    $popular_posts = new WP_Query(array(
        'posts_per_page' => 5,
        'post_status' => 'publish',
        'ignore_sticky_posts' => true,
        'orderby' => array('comment_count' => 'DESC', 'date' => 'DESC'),
    ));
    ?>
    <?php if ($popular_posts->have_posts()) : ?>
        <section class="ranking-panel joe-panel">
            <h2 class="panel-title"><?php echo iwlz_theme_icon('flame'); ?><span><?php esc_html_e('热门文章', 'iwlz-theme'); ?></span></h2>
            <ol class="ranking-list">
                <?php $rank = 0; ?>
                <?php while ($popular_posts->have_posts()) : $popular_posts->the_post(); $rank++; ?>
                    <li>
                        <span class="ranking-number"><?php echo esc_html($rank); ?></span>
                        <div>
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            <span><?php echo esc_html(get_the_date('Y-m-d')); ?> · <?php echo esc_html(number_format_i18n(get_comments_number())); ?> <?php esc_html_e('评论', 'iwlz-theme'); ?></span>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ol>
        </section>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>

    <?php $tags = get_tags(array('number' => 18, 'orderby' => 'count', 'order' => 'DESC')); ?>
    <?php if ($tags) : ?>
        <section class="tag-panel joe-panel">
            <h2 class="panel-title"><?php echo iwlz_theme_icon('tag'); ?><span><?php esc_html_e('标签', 'iwlz-theme'); ?></span></h2>
            <div class="tag-cloud">
                <?php foreach ($tags as $tag) : ?>
                    <a href="<?php echo esc_url(get_tag_link($tag)); ?>"><?php echo esc_html($tag->name); ?><span><?php echo esc_html(number_format_i18n($tag->count)); ?></span></a>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

    <?php if (is_active_sidebar('sidebar-1')) : ?>
        <?php dynamic_sidebar('sidebar-1'); ?>
    <?php endif; ?>
</aside>
