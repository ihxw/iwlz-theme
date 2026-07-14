<?php
/**
 * Shared post list item.
 *
 * @package IWLZ_Theme
 */

$categories = get_the_category();
$default_thumbnail = iwlz_theme_default_thumbnail();
?>
<li <?php post_class('post-list-item'); ?>>
    <article class="post-card">
        <a class="post-card-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('iwlz-card', array('alt' => '', 'loading' => 'lazy')); ?>
            <?php elseif ($default_thumbnail) : ?>
                <img src="<?php echo esc_url($default_thumbnail); ?>" alt="" loading="lazy">
            <?php else : ?>
                <span class="post-card-placeholder">
                    <span class="post-card-placeholder-mark"><?php echo esc_html(iwlz_theme_site_initial()); ?></span>
                    <span class="post-card-placeholder-name"><?php bloginfo('name'); ?></span>
                </span>
            <?php endif; ?>
            <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('Y-m-d')); ?></time>
        </a>

        <div class="post-card-content">
            <h2 class="post-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <a class="post-card-excerpt" href="<?php the_permalink(); ?>">
                <?php echo esc_html(iwlz_theme_get_excerpt(get_the_ID())); ?>
            </a>
            <div class="post-card-footer">
                <ul class="post-card-meta" aria-label="<?php esc_attr_e('文章信息', 'iwlz-theme'); ?>">
                    <li><?php echo iwlz_theme_icon('calendar'); ?><span><?php echo esc_html(get_the_date('Y-m-d')); ?></span></li>
                    <li><?php echo iwlz_theme_icon('eye'); ?><span><?php echo esc_html(number_format_i18n(iwlz_theme_get_post_views())); ?></span></li>
                    <li><?php echo iwlz_theme_icon('message'); ?><span><?php echo esc_html(number_format_i18n(get_comments_number())); ?></span></li>
                </ul>
                <?php if ($categories) : ?>
                    <ul class="post-card-categories" aria-label="<?php esc_attr_e('文章分类', 'iwlz-theme'); ?>">
                        <?php foreach (array_slice($categories, 0, 2) as $category) : ?>
                            <li>
                                <a href="<?php echo esc_url(get_category_link($category)); ?>">
                                    <?php echo iwlz_theme_icon('folder'); ?>
                                    <span><?php echo esc_html($category->name); ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </article>
</li>
