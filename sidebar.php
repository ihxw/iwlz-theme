<?php
$author_id = get_the_author_meta('ID') ?: 1;
$author_avatar = get_avatar_url($author_id, array('size' => 96));
$author_name = get_the_author_meta('display_name', $author_id) ?: get_bloginfo('name');
$author_desc = get_the_author_meta('description', $author_id) ?: get_bloginfo('description');
$post_count = wp_count_posts()->publish;
$tag_count = wp_count_terms(array('taxonomy' => 'post_tag', 'hide_empty' => false));
$comment_count = wp_count_comments()->approved;
$cat_count = wp_count_terms(array('taxonomy' => 'category', 'hide_empty' => false));
?>

<aside class="sidebar">
    <div class="author-card">
        <img class="author-card-bg" src="<?php echo esc_url(get_template_directory_uri()); ?>/screenshot.png" alt="">
        <div class="author-card-body">
            <img class="author-card-avatar" src="<?php echo esc_url($author_avatar); ?>" alt="<?php echo esc_attr($author_name); ?>">
            <h3 class="author-card-name"><?php echo esc_html($author_name); ?></h3>
            <p class="author-card-desc"><?php echo esc_html($author_desc ?: '走过多少流年才相遇'); ?></p>
            <div class="author-card-stats">
                <div class="author-card-stat">
                    <span class="author-card-stat-value"><?php echo $post_count; ?></span>
                    <span class="author-card-stat-label">文章</span>
                </div>
                <div class="author-card-stat">
                    <span class="author-card-stat-value"><?php echo $cat_count; ?></span>
                    <span class="author-card-stat-label">分类</span>
                </div>
                <div class="author-card-stat">
                    <span class="author-card-stat-value"><?php echo $comment_count; ?></span>
                    <span class="author-card-stat-label">评论</span>
                </div>
            </div>
        </div>
    </div>

    <?php if (is_active_sidebar('sidebar-1')) : ?>
        <?php dynamic_sidebar('sidebar-1'); ?>
    <?php endif; ?>
</aside>