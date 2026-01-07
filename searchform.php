<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <label>
        <span class="screen-reader-text">
            <?php echo esc_html_x('搜索:', 'label', 'iwlz-theme'); ?>
        </span>
        <input type="search" class="search-field"
            placeholder="<?php echo esc_attr_x('搜索...', 'placeholder', 'iwlz-theme'); ?>"
            value="<?php echo get_search_query(); ?>" name="s" />
    </label>
    <button type="submit" class="search-submit">
        <?php echo esc_html_x('搜索', 'submit button', 'iwlz-theme'); ?>
    </button>
</form>