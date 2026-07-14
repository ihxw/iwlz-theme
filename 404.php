<?php
/**
 * 404 template.
 *
 * @package IWLZ_Theme
 */

get_header();
?>
<div class="error-page container">
    <section class="error-panel joe-panel">
        <span class="error-code">404</span>
        <h1><?php esc_html_e('页面走丢了', 'iwlz-theme'); ?></h1>
        <p><?php esc_html_e('你访问的地址不存在，可能已经移动或删除。', 'iwlz-theme'); ?></p>
        <?php get_search_form(); ?>
        <a class="button" href="<?php echo esc_url(home_url('/')); ?>"><?php echo iwlz_theme_icon('home'); ?><?php esc_html_e('返回首页', 'iwlz-theme'); ?></a>
    </section>
</div>
<?php
get_footer();
