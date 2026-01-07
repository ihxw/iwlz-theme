<?php
/**
 * 404 错误页面模板
 *
 * @package Libra_Theme
 */

get_header();
?>

<div class="container">
    <div class="content-area">
        <div class="main-content">
            <div class="card" style="text-align: center; padding: 4rem 2rem;">
                <h1 style="font-size: 6rem; margin-bottom: 1rem;">404</h1>
                <h2>
                    <?php esc_html_e('页面未找到', 'iwlz-theme'); ?>
                </h2>
                <p style="margin: 2rem 0;">
                    <?php esc_html_e('抱歉，您访问的页面不存在或已被删除。', 'iwlz-theme'); ?>
                </p>

                <div style="max-width: 400px; margin: 2rem auto;">
                    <?php get_search_form(); ?>
                </div>

                <p style="margin-top: 2rem;">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
                        <?php esc_html_e('返回首页', 'iwlz-theme'); ?>
                    </a>
                </p>
            </div>
        </div>

        <?php get_sidebar(); ?>
    </div>
</div>

<?php
get_footer();
