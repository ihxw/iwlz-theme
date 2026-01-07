<?php
/**
 * 评论模板
 *
 * @package Libra_Theme
 */

if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">
    <?php if (have_comments()): ?>
        <h2 class="comments-title">
            <?php
            $comment_count = get_comments_number();
            if ('1' === $comment_count) {
                printf(
                    esc_html__('1 条评论', 'iwlz-theme')
                );
            } else {
                printf(
                    esc_html(_nx('%1$s 条评论', '%1$s 条评论', $comment_count, 'comments title', 'iwlz-theme')),
                    number_format_i18n($comment_count)
                );
            }
            ?>
        </h2>

        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style' => 'ol',
                'short_ping' => true,
                'avatar_size' => 48,
                'callback' => 'libra_theme_comment',
            ));
            ?>
        </ol>

        <?php
        the_comments_navigation();

        if (!comments_open()):
            ?>
            <p class="no-comments">
                <?php esc_html_e('评论已关闭。', 'iwlz-theme'); ?>
            </p>
            <?php
        endif;

    endif;

    comment_form(array(
        'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title">',
        'title_reply_after' => '</h3>',
        'class_submit' => 'btn btn-primary',
    ));
    ?>
</div>