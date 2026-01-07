/**
 * 移动端搜索按钮交互
 */
(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        const searchForm = document.querySelector('.header-search-form');
        const searchField = document.querySelector('.header-search-field');

        if (!searchForm || !searchField) return;

        // 检测是否为移动设备
        function isMobile() {
            return window.innerWidth <= 768;
        }

        // 切换搜索框显示
        function toggleSearch(e) {
            if (!isMobile()) return;

            // 如果点击的是搜索按钮区域（伪元素）
            const rect = searchForm.getBoundingClientRect();
            const clickX = e.clientX - rect.left;
            const clickY = e.clientY - rect.top;

            // 检查是否点击了右侧的按钮区域
            if (clickX > rect.width - 40 && clickY > 0 && clickY < rect.height) {
                if (!searchForm.classList.contains('active')) {
                    e.preventDefault();
                    searchForm.classList.add('active');
                    setTimeout(() => searchField.focus(), 100);
                } else if (searchField.value.trim() === '') {
                    // 如果输入框为空，关闭搜索框
                    searchForm.classList.remove('active');
                }
            }
        }

        // 点击外部关闭搜索框
        function closeSearch(e) {
            if (!isMobile()) return;

            if (!searchForm.contains(e.target) && searchForm.classList.contains('active')) {
                searchForm.classList.remove('active');
            }
        }

        // 添加事件监听
        searchForm.addEventListener('click', toggleSearch);
        document.addEventListener('click', closeSearch);

        // 窗口大小改变时重置
        let resizeTimer;
        window.addEventListener('resize', function () {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function () {
                if (!isMobile() && searchForm.classList.contains('active')) {
                    searchForm.classList.remove('active');
                }
            }, 250);
        });
    });
})();
