/**
 * 主题切换功能 - 支持系统主题自动检测
 */
(function () {
    'use strict';

    // 检测系统主题偏好
    function getSystemTheme() {
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            return 'dark';
        }
        return 'light';
    }

    // 获取保存的主题或使用系统主题
    const savedTheme = localStorage.getItem('iwlz-theme');
    const initialTheme = savedTheme || getSystemTheme();

    // 应用主题
    function applyTheme(theme) {
        document.documentElement.setAttribute('data-theme', theme);
        localStorage.setItem('iwlz-theme', theme);

        // 更新侧边栏主题切换器的激活状态（如果存在）
        const themeOptions = document.querySelectorAll('.theme-option');
        themeOptions.forEach(option => {
            if (option.dataset.theme === theme) {
                option.classList.add('active');
            } else {
                option.classList.remove('active');
            }
        });
    }

    // 切换主题
    function toggleTheme() {
        const currentTheme = document.documentElement.getAttribute('data-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        applyTheme(newTheme);
    }

    // 页面加载时应用主题
    applyTheme(initialTheme);

    // 等待 DOM 加载完成
    document.addEventListener('DOMContentLoaded', function () {
        // Header 主题切换按钮
        const themeToggleBtn = document.getElementById('theme-toggle');
        if (themeToggleBtn) {
            themeToggleBtn.addEventListener('click', toggleTheme);
        }

        // 侧边栏主题切换器（如果存在）
        const themeOptions = document.querySelectorAll('.theme-option');
        themeOptions.forEach(option => {
            option.addEventListener('click', function () {
                const theme = this.dataset.theme;
                applyTheme(theme);
            });
        });

        // 键盘快捷键支持 (Ctrl/Cmd + K 切换主题)
        document.addEventListener('keydown', function (e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                toggleTheme();
            }
        });
    });

    // 监听系统主题变化（仅在用户未手动设置主题时）
    if (window.matchMedia) {
        const darkModeQuery = window.matchMedia('(prefers-color-scheme: dark)');
        darkModeQuery.addListener(function (e) {
            // 只有在用户没有手动设置过主题时才自动切换
            if (!localStorage.getItem('iwlz-theme')) {
                applyTheme(e.matches ? 'dark' : 'light');
            }
        });
    }
})();
