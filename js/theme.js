(function () {
    'use strict';

    var root = document.documentElement;
    var labels = window.iwlzThemeL10n || {
        darkMode: '切换深色模式',
        lightMode: '切换浅色模式',
        expandSubmenu: '展开子菜单',
        collapseSubmenu: '收起子菜单',
        copyCode: '复制代码',
        copied: '已复制',
        copyFailed: '复制失败，请手动选择代码'
    };
    var themeToggle = document.getElementById('theme-toggle');
    var colorScheme = window.matchMedia ? window.matchMedia('(prefers-color-scheme: dark)') : null;

    function setTheme(theme, persist) {
        root.dataset.theme = theme;
        if (persist) {
            localStorage.setItem('iwlz-theme', theme);
        }
        if (themeToggle) {
            var isDark = theme === 'dark';
            themeToggle.setAttribute('aria-pressed', String(isDark));
            themeToggle.setAttribute('aria-label', isDark ? labels.lightMode : labels.darkMode);
        }
    }

    if (themeToggle) {
        themeToggle.addEventListener('click', function () {
            setTheme(root.dataset.theme === 'dark' ? 'light' : 'dark', true);
        });
    }

    if (colorScheme) {
        colorScheme.addEventListener('change', function (event) {
            if (!localStorage.getItem('iwlz-theme')) {
                setTheme(event.matches ? 'dark' : 'light', false);
            }
        });
    }
    setTheme(root.dataset.theme || 'light', false);

    var searchPanel = document.getElementById('search-panel');
    var searchToggle = document.getElementById('search-toggle');
    var searchClose = document.getElementById('search-close');

    function setSearch(open) {
        if (!searchPanel || !searchToggle) return;
        searchPanel.hidden = !open;
        searchToggle.setAttribute('aria-expanded', String(open));
        document.body.classList.toggle('search-open', open);
        if (open) {
            window.setTimeout(function () {
                var field = searchPanel.querySelector('.search-field');
                if (field) field.focus();
            }, 50);
        }
    }

    if (searchToggle) searchToggle.addEventListener('click', function () { setSearch(searchPanel.hidden); });
    if (searchClose) searchClose.addEventListener('click', function () { setSearch(false); });

    var drawer = document.getElementById('mobile-drawer');
    var drawerToggle = document.getElementById('mobile-menu-toggle');
    var drawerClose = document.getElementById('mobile-menu-close');
    var drawerMask = document.getElementById('drawer-mask');

    function setDrawer(open) {
        if (!drawer || !drawerToggle || !drawerMask) return;
        drawer.classList.toggle('is-open', open);
        drawer.setAttribute('aria-hidden', String(!open));
        drawerToggle.setAttribute('aria-expanded', String(open));
        drawerMask.hidden = !open;
        document.body.classList.toggle('drawer-open', open);
        if (open) {
            drawer.removeAttribute('inert');
            if (drawerClose) drawerClose.focus();
        } else {
            drawer.setAttribute('inert', '');
            if (drawer.contains(document.activeElement)) drawerToggle.focus();
        }
    }

    if (drawerToggle) drawerToggle.addEventListener('click', function () { setDrawer(true); });
    if (drawerClose) drawerClose.addEventListener('click', function () { setDrawer(false); });
    if (drawerMask) drawerMask.addEventListener('click', function () { setDrawer(false); });

    function trapFocus(container, event) {
        var focusable = Array.prototype.slice.call(container.querySelectorAll(
            'a[href], button:not([disabled]), input:not([disabled]), textarea:not([disabled]), select:not([disabled]), [tabindex]:not([tabindex="-1"])'
        )).filter(function (element) {
            return element.offsetParent !== null && !element.hasAttribute('inert');
        });
        if (!focusable.length) return;

        var first = focusable[0];
        var last = focusable[focusable.length - 1];
        if (event.shiftKey && document.activeElement === first) {
            event.preventDefault();
            last.focus();
        } else if (!event.shiftKey && document.activeElement === last) {
            event.preventDefault();
            first.focus();
        }
    }

    document.querySelectorAll('.mobile-menu .menu-item-has-children').forEach(function (item) {
        var submenu = item.querySelector(':scope > .sub-menu');
        if (!submenu) return;
        var button = document.createElement('button');
        button.type = 'button';
        button.className = 'submenu-toggle';
        button.setAttribute('aria-label', labels.expandSubmenu);
        button.setAttribute('aria-expanded', 'false');
        button.innerHTML = '<svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>';
        item.insertBefore(button, submenu);
        button.addEventListener('click', function () {
            var open = item.classList.toggle('submenu-open');
            button.setAttribute('aria-expanded', String(open));
            button.setAttribute('aria-label', open ? labels.collapseSubmenu : labels.expandSubmenu);
        });
    });

    document.addEventListener('keydown', function (event) {
        var tocIsOpen = mobileTocDialog && !mobileTocDialog.hidden;
        var drawerIsOpen = drawer && drawer.classList.contains('is-open');
        if (event.key === 'Tab') {
            if (tocIsOpen) {
                trapFocus(mobileTocDialog.querySelector('.mobile-toc-sheet'), event);
            } else if (drawerIsOpen) {
                trapFocus(drawer, event);
            }
        }
        if (event.key === 'Escape') {
            setSearch(false);
            setDrawer(false);
        }
        if ((event.ctrlKey || event.metaKey) && event.key.toLowerCase() === 'k') {
            event.preventDefault();
            if (tocIsOpen || drawerIsOpen) return;
            setSearch(true);
        }
    });

    var backToTop = document.getElementById('back-to-top');
    if (backToTop) {
        function syncBackToTop() {
            backToTop.classList.toggle('is-visible', window.scrollY > 500);
        }
        window.addEventListener('scroll', syncBackToTop, { passive: true });
        syncBackToTop();
        backToTop.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    var reducedMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (!reducedMotion && 'IntersectionObserver' in window) {
        var revealObserver = new IntersectionObserver(function (entries, observer) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-revealed');
                    observer.unobserve(entry.target);
                }
            });
        }, { rootMargin: '0px 0px -40px', threshold: 0.05 });
        document.querySelectorAll('.post-list-item').forEach(function (item) {
            item.classList.add('can-reveal');
            revealObserver.observe(item);
        });
    }

    function codeIcon(name) {
        if (name === 'check') return '<svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m20 6-11 11-5-5"/></svg>';
        return '<svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="14" height="14" x="8" y="8" rx="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg>';
    }

    document.querySelectorAll('.entry-content pre').forEach(function (pre) {
        if (pre.parentElement.classList.contains('code-block')) return;
        var code = pre.querySelector('code');
        var className = code ? code.className : '';
        var match = className.match(/(?:language|lang)-([\w-]+)/i);
        var language = match ? match[1].toUpperCase() : 'CODE';
        var wrapper = document.createElement('div');
        wrapper.className = 'code-block';
        var toolbar = document.createElement('div');
        toolbar.className = 'code-toolbar';
        toolbar.innerHTML = '<span>' + language + '</span>';
        var button = document.createElement('button');
        button.type = 'button';
        button.className = 'code-copy';
        button.title = labels.copyCode;
        button.setAttribute('aria-label', labels.copyCode);
        button.innerHTML = codeIcon('copy');
        toolbar.appendChild(button);
        pre.parentNode.insertBefore(wrapper, pre);
        wrapper.appendChild(toolbar);
        wrapper.appendChild(pre);
        if (window.Prism && code) window.Prism.highlightElement(code);
        button.addEventListener('click', function () {
            var value = code ? code.textContent : pre.textContent;

            function legacyCopy() {
                return new Promise(function (resolve, reject) {
                    var area = document.createElement('textarea');
                    area.value = value;
                    area.style.position = 'fixed';
                    area.style.opacity = '0';
                    document.body.appendChild(area);
                    area.select();
                    try {
                        document.execCommand('copy') ? resolve() : reject(new Error('copy failed'));
                    } catch (error) {
                        reject(error);
                    }
                    area.remove();
                });
            }

            var copy = navigator.clipboard && window.isSecureContext
                ? navigator.clipboard.writeText(value).catch(legacyCopy)
                : legacyCopy();
            copy.then(function () {
                button.innerHTML = codeIcon('check');
                button.title = labels.copied;
                button.setAttribute('aria-label', labels.copied);
                window.setTimeout(function () {
                    button.innerHTML = codeIcon('copy');
                    button.title = labels.copyCode;
                    button.setAttribute('aria-label', labels.copyCode);
                }, 1600);
            }).catch(function () {
                button.title = labels.copyFailed;
                button.setAttribute('aria-label', labels.copyFailed);
                window.setTimeout(function () {
                    button.title = labels.copyCode;
                    button.setAttribute('aria-label', labels.copyCode);
                }, 2400);
            });
        });
    });

    var article = document.getElementById('article-content');
    var tocPanel = document.getElementById('toc-panel');
    var toc = document.getElementById('post-toc');
    var mobileToc = document.getElementById('mobile-post-toc');
    var mobileTocTrigger = document.getElementById('mobile-toc-trigger');
    var mobileTocDialog = document.getElementById('mobile-toc-dialog');
    var mobileTocClose = document.getElementById('mobile-toc-close');
    var mobileTocMask = document.getElementById('mobile-toc-mask');

    function setMobileToc(open) {
        if (!mobileTocDialog || !mobileTocTrigger) return;
        mobileTocDialog.hidden = !open;
        mobileTocDialog.setAttribute('aria-hidden', String(!open));
        mobileTocTrigger.setAttribute('aria-expanded', String(open));
        document.body.classList.toggle('mobile-toc-open', open);
        if (open) {
            mobileTocDialog.removeAttribute('inert');
            if (mobileTocClose) mobileTocClose.focus();
        } else {
            mobileTocDialog.setAttribute('inert', '');
            if (mobileTocDialog.contains(document.activeElement)) mobileTocTrigger.focus();
        }
    }

    if (mobileTocTrigger) mobileTocTrigger.addEventListener('click', function () { setMobileToc(true); });
    if (mobileTocClose) mobileTocClose.addEventListener('click', function () { setMobileToc(false); });
    if (mobileTocMask) mobileTocMask.addEventListener('click', function () { setMobileToc(false); });

    if (article && tocPanel && toc) {
        var headings = Array.prototype.slice.call(article.querySelectorAll('h1, h2, h3, h4, h5, h6'))
            .filter(function (heading) { return heading.textContent.trim().length > 0; });
        if (headings.length > 1) {
            function buildTocList() {
                var list = document.createElement('ol');
                headings.forEach(function (heading, index) {
                    if (!heading.id) heading.id = 'section-' + (index + 1);
                    var item = document.createElement('li');
                    item.className = 'toc-level-' + heading.tagName.substring(1);
                    var link = document.createElement('a');
                    link.href = '#' + heading.id;
                    link.textContent = heading.textContent;
                    item.appendChild(link);
                    list.appendChild(item);
                });
                return list;
            }

            toc.appendChild(buildTocList());
            tocPanel.hidden = false;
            if (mobileToc && mobileTocTrigger) {
                mobileToc.appendChild(buildTocList());
                mobileTocTrigger.hidden = false;
                mobileToc.querySelectorAll('a').forEach(function (link) {
                    link.addEventListener('click', function () { setMobileToc(false); });
                });
            }

            if ('IntersectionObserver' in window) {
                var tocLinks = document.querySelectorAll('#post-toc a, #mobile-post-toc a');
                var tocObserver = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (!entry.isIntersecting) return;
                        tocLinks.forEach(function (link) {
                            link.classList.toggle('is-active', link.getAttribute('href') === '#' + entry.target.id);
                        });
                    });
                }, { rootMargin: '-100px 0px -65% 0px' });
                headings.forEach(function (heading) { tocObserver.observe(heading); });
            }
        }
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') setMobileToc(false);
    });
}());
