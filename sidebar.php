<?php
/**
 * 侧边栏模板
 *
 * @package Libra_Theme
 */

if (!is_active_sidebar('sidebar-1')) {
    return;
}
?>

<aside class="sidebar">
    <!-- 动态小工具区域 -->
    <?php dynamic_sidebar('sidebar-1'); ?>
</aside>