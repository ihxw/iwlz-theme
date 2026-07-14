<?php
/**
 * Comments template.
 *
 * @package IWLZ_Theme
 */

if (post_password_required()) {
    return;
}
?>
<section id="comments" class="comments-area joe-panel">
    <header class="comments-header">
        <h2 class="panel-title">
            <?php echo iwlz_theme_icon('message'); ?>
            <span>
                <?php
                printf(
                    esc_html(_n('%s 条评论', '%s 条评论', get_comments_number(), 'iwlz-theme')),
                    esc_html(number_format_i18n(get_comments_number()))
                );
                ?>
            </span>
        </h2>
        <p><?php esc_html_e('欢迎留下你的想法。', 'iwlz-theme'); ?></p>
    </header>

    <?php if (have_comments()) : ?>
        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style' => 'ol',
                'short_ping' => true,
                'avatar_size' => 48,
                'callback' => 'iwlz_theme_comment',
            ));
            ?>
        </ol>

        <?php the_comments_navigation(); ?>
    <?php endif; ?>

    <?php if (!comments_open() && get_comments_number()) : ?>
        <p class="no-comments"><?php esc_html_e('评论已关闭。', 'iwlz-theme'); ?></p>
    <?php endif; ?>

    <?php
    comment_form(array(
        'title_reply' => __('发表评论', 'iwlz-theme'),
        'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title">',
        'title_reply_after' => '</h3>',
        'label_submit' => __('提交评论', 'iwlz-theme'),
        'class_submit' => 'submit button',
        'comment_notes_before' => '<p class="comment-notes">' . esc_html__('电子邮箱不会被公开，必填项已标注。', 'iwlz-theme') . '</p>',
    ));
    ?>
</section>
