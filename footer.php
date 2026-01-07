</main>

<footer class="site-footer">
    <div class="container">
        <div class="site-info">
            <p>
                &copy;
                <?php echo date('Y'); ?>
                <a href="<?php echo esc_url(home_url('/')); ?>">
                    <?php bloginfo('name'); ?>
                </a>
                <?php
                printf(
                    esc_html__(' | Powered by %s', 'iwlz-theme'),
                    '<a href="https://iwlz.de/">IWLZ</a>'
                );
                ?>
            </p>
        </div>
    </div>
</footer>
</div>

<?php wp_footer(); ?>

</body>

</html>