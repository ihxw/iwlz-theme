(function () {
    'use strict';

    function getSystemTheme() {
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            return 'dark';
        }
        return 'light';
    }

    const savedTheme = localStorage.getItem('iwlz-theme');
    const initialTheme = savedTheme || getSystemTheme();

    function applyTheme(theme) {
        document.documentElement.setAttribute('data-theme', theme);
        localStorage.setItem('iwlz-theme', theme);
        const sunIcon = document.querySelector('.sun-icon');
        const moonIcon = document.querySelector('.moon-icon');
        if (sunIcon && moonIcon) {
            if (theme === 'dark') {
                sunIcon.style.display = 'none';
                moonIcon.style.display = 'block';
            } else {
                sunIcon.style.display = 'block';
                moonIcon.style.display = 'none';
            }
        }
    }

    function toggleTheme() {
        const currentTheme = document.documentElement.getAttribute('data-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        applyTheme(newTheme);
    }

    applyTheme(initialTheme);

    document.addEventListener('DOMContentLoaded', function () {
        const themeToggleBtn = document.getElementById('theme-toggle');
        if (themeToggleBtn) {
            themeToggleBtn.addEventListener('click', toggleTheme);
        }

        if (window.matchMedia) {
            const darkModeQuery = window.matchMedia('(prefers-color-scheme: dark)');
            darkModeQuery.addListener(function (e) {
                if (!localStorage.getItem('iwlz-theme')) {
                    applyTheme(e.matches ? 'dark' : 'light');
                }
            });
        }

        // Search toggle
        const searchToggle = document.getElementById('header-search-toggle');
        const searchWrapper = document.getElementById('header-search-form-wrapper');
        if (searchToggle && searchWrapper) {
            searchToggle.addEventListener('click', function () {
                const isVisible = searchWrapper.style.display !== 'none';
                searchWrapper.style.display = isVisible ? 'none' : 'block';
                if (!isVisible) {
                    setTimeout(function () {
                        searchWrapper.querySelector('input').focus();
                    }, 100);
                }
            });
            document.addEventListener('click', function (e) {
                if (!searchToggle.contains(e.target) && !searchWrapper.contains(e.target)) {
                    searchWrapper.style.display = 'none';
                }
            });
        }

        // Back to top
        var backToTopBtn = document.getElementById('back-to-top');
        if (!backToTopBtn) {
            backToTopBtn = document.createElement('button');
            backToTopBtn.id = 'back-to-top';
            backToTopBtn.className = 'back-to-top';
            backToTopBtn.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 19V5M5 12l7-7 7 7"/></svg>';
            document.body.appendChild(backToTopBtn);
        }

        window.addEventListener('scroll', function () {
            if (window.scrollY > 400) {
                backToTopBtn.classList.add('visible');
            } else {
                backToTopBtn.classList.remove('visible');
            }
        });

        backToTopBtn.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Card entrance animation
        var cards = document.querySelectorAll('.post-item');
        if (cards.length) {
            var observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-in');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });
            cards.forEach(function (card) { observer.observe(card); });
        }
    });
})();
