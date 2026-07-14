<?php $search_field_id = wp_unique_id('site-search-field-'); ?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <label class="screen-reader-text" for="<?php echo esc_attr($search_field_id); ?>"><?php echo esc_html_x('搜索：', 'label', 'iwlz-theme'); ?></label>
    <span class="search-form-icon"><?php echo iwlz_theme_icon('search'); ?></span>
    <input id="<?php echo esc_attr($search_field_id); ?>" type="search" class="search-field"
        placeholder="<?php echo esc_attr_x('输入关键词，按回车搜索', 'placeholder', 'iwlz-theme'); ?>"
        value="<?php echo esc_attr(get_search_query()); ?>" name="s" autocomplete="off">
    <button class="search-submit" type="submit"><?php esc_html_e('搜索', 'iwlz-theme'); ?></button>
</form>
