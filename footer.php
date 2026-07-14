    </main>

    <footer class="site-footer">
        <div class="container footer-inner">
            <p>
                &copy; <?php echo esc_html(wp_date('Y')); ?>
                <a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
                <span class="footer-separator">/</span>
                <?php esc_html_e('基于 WordPress', 'iwlz-theme'); ?>
            </p>
            <?php $footer_text = get_theme_mod('iwlz_footer_text', ''); ?>
            <?php if ($footer_text) : ?>
                <p><?php echo esc_html($footer_text); ?></p>
            <?php endif; ?>
        </div>
    </footer>

    <div class="floating-actions" aria-label="<?php esc_attr_e('页面工具', 'iwlz-theme'); ?>">
        <button class="floating-button" id="back-to-top" type="button" aria-label="<?php esc_attr_e('返回顶部', 'iwlz-theme'); ?>">
            <?php echo iwlz_theme_icon('arrow-up'); ?>
        </button>
    </div>
</div>

<?php wp_footer(); ?>
</body>
</html>
