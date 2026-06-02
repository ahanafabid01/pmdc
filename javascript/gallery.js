/**
 * gallery.js — PMDC Public Gallery (Professional Edition)
 * Features: Year filter, Load More, Lightbox with dots/swipe/keyboard
 */
(function () {
    'use strict';

    /* ── State ─────────────────────────────────────────────── */
    let lbPhotos    = [];
    let lbIndex     = 0;
    let touchStartX = 0;
    let touchStartY = 0;

    /* ── Tiny selector helpers ──────────────────────────────── */
    const $  = id  => document.getElementById(id);
    const $$ = sel => document.querySelectorAll(sel);

    /* ══════════════════════════════════════════════════════════
       YEAR FILTER
    ══════════════════════════════════════════════════════════ */
    function initFilter() {
        $$('.gallery-filter-scroll .filter-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                $$('.gallery-filter-scroll .filter-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                filterByYear(btn.dataset.year);
            });
        });
    }

    function filterByYear(year) {
        $$('.gallery-year-section').forEach(sec => {
            const match = (year === 'all' || sec.dataset.yearSection === year);
            sec.style.display = match ? '' : 'none';
        });
    }

    /* ══════════════════════════════════════════════════════════
       LOAD MORE
    ══════════════════════════════════════════════════════════ */
    window.galleryLoadMore = function (year) {
        const grid   = $('grid-' + year);
        const lmWrap = $('loadmore-' + year);
        if (!grid) return;

        const extras = grid.querySelectorAll('[data-extra="1"]');
        let count = 0;
        extras.forEach(el => {
            if (count < 24) {
                el.removeAttribute('data-extra');
                el.style.display = '';
                setTimeout(() => revealThumb(el), count * 45);
                count++;
            }
        });

        if (grid.querySelectorAll('[data-extra="1"]').length === 0 && lmWrap) {
            lmWrap.style.display = 'none';
        }
    };

    /* ══════════════════════════════════════════════════════════
       LIGHTBOX
    ══════════════════════════════════════════════════════════ */
    function buildPhotoList(yearSection) {
        return Array.from(yearSection.querySelectorAll('.gallery-thumb:not([style*="display:none"])'))
            .map(t => ({
                src   : t.dataset.src,
                title : t.dataset.title,
                date  : t.dataset.date,
            }));
    }

    function openLightbox(yearSection, clickedThumb) {
        lbPhotos = buildPhotoList(yearSection);
        const thumbs = Array.from(yearSection.querySelectorAll('.gallery-thumb:not([style*="display:none"])'));
        lbIndex = thumbs.indexOf(clickedThumb);
        if (lbIndex < 0) lbIndex = 0;

        buildDots();
        $('galleryLightbox').classList.add('open');
        document.body.style.overflow = 'hidden';
        showPhoto(lbIndex);
    }

    function closeLightbox() {
        $('galleryLightbox').classList.remove('open');
        document.body.style.overflow = '';
        // Defer clearing src so fade-out completes
        setTimeout(() => { $('glbImg').src = ''; }, 240);
    }

    function showPhoto(idx) {
        if (idx < 0 || idx >= lbPhotos.length) return;
        lbIndex = idx;
        const photo = lbPhotos[idx];
        const img   = $('glbImg');
        const spin  = $('glbSpinner');

        // Fade out
        img.classList.add('loading');
        img.classList.remove('loaded');
        spin.classList.add('show');

        const loader    = new Image();
        loader.onload   = () => finishLoad(img, spin, photo.src, photo.title);
        loader.onerror  = () => finishLoad(img, spin, photo.src, photo.title);
        loader.src      = photo.src;

        $('glbTitle').textContent = photo.title || '';
        $('glbDate').textContent  = photo.date  || '';
        $('glbCounter').textContent = (idx + 1) + ' / ' + lbPhotos.length;

        $('glbPrev').disabled = idx === 0;
        $('glbNext').disabled = idx === lbPhotos.length - 1;

        updateDots(idx);
    }

    function finishLoad(imgEl, spinEl, src, alt) {
        imgEl.src = src;
        imgEl.alt = alt || '';
        imgEl.classList.remove('loading');
        imgEl.classList.add('loaded');
        spinEl.classList.remove('show');
    }

    function buildDots() {
        const dotsEl = $('glbDots');
        dotsEl.innerHTML = '';
        // Only show dots if ≤ 30 photos; beyond that it's too cluttered
        if (lbPhotos.length > 30) { dotsEl.style.display = 'none'; return; }
        dotsEl.style.display = 'flex';
        lbPhotos.forEach((_, i) => {
            const d = document.createElement('span');
            d.className = 'glb-dot' + (i === lbIndex ? ' active' : '');
            d.addEventListener('click', () => showPhoto(i));
            dotsEl.appendChild(d);
        });
    }

    function updateDots(idx) {
        $$('#glbDots .glb-dot').forEach((d, i) => {
            d.classList.toggle('active', i === idx);
        });
    }

    function initLightbox() {
        // Click on thumb
        document.addEventListener('click', e => {
            const thumb = e.target.closest('.gallery-thumb');
            if (!thumb) return;
            const yearSec = thumb.closest('.gallery-year-section');
            openLightbox(yearSec, thumb);
        });

        // Keyboard: Enter / Space to open focused thumb
        document.addEventListener('keydown', e => {
            const lb = $('galleryLightbox');
            if (!lb.classList.contains('open')) {
                if ((e.key === 'Enter' || e.key === ' ') && document.activeElement?.classList.contains('gallery-thumb')) {
                    e.preventDefault();
                    document.activeElement.click();
                }
                return;
            }
            switch (e.key) {
                case 'ArrowLeft':  e.preventDefault(); showPhoto(lbIndex - 1); break;
                case 'ArrowRight': e.preventDefault(); showPhoto(lbIndex + 1); break;
                case 'Escape':     closeLightbox(); break;
            }
        });

        // Controls
        $('glbPrev').addEventListener('click',    () => showPhoto(lbIndex - 1));
        $('glbNext').addEventListener('click',    () => showPhoto(lbIndex + 1));
        $('glbClose').addEventListener('click',   closeLightbox);
        $('glbOverlay').addEventListener('click', closeLightbox);

        // Touch swipe
        const stage = $('glbImgWrap');
        stage.addEventListener('touchstart', e => {
            touchStartX = e.changedTouches[0].clientX;
            touchStartY = e.changedTouches[0].clientY;
        }, { passive: true });
        stage.addEventListener('touchend', e => {
            const dx = e.changedTouches[0].clientX - touchStartX;
            const dy = e.changedTouches[0].clientY - touchStartY;
            if (Math.abs(dx) > Math.abs(dy) && Math.abs(dx) > 48) {
                dx < 0 ? showPhoto(lbIndex + 1) : showPhoto(lbIndex - 1);
            }
        }, { passive: true });
    }

    /* ══════════════════════════════════════════════════════════
       SCROLL ANIMATIONS
    ══════════════════════════════════════════════════════════ */
    function revealThumb(el) {
        if (!el) return;
        if (!window.IntersectionObserver) {
            el.classList.add('visible');
            return;
        }
        const obs = new IntersectionObserver(entries => {
            entries.forEach(en => {
                if (en.isIntersecting) {
                    en.target.classList.add('visible');
                    obs.unobserve(en.target);
                }
            });
        }, { threshold: 0.05, rootMargin: '0px 0px -40px 0px' });
        obs.observe(el);
    }

    function initScrollAnimations() {
        // Stagger thumbnails per row (groups of 4)
        $$('.gallery-thumb:not([data-extra])').forEach((el, i) => {
            const delay = (i % 4) * 60;
            el.style.transitionDelay = delay + 'ms';
            revealThumb(el);
        });

        // Year section headers via .reveal
        if (window.IntersectionObserver) {
            const hObs = new IntersectionObserver(entries => {
                entries.forEach(en => {
                    if (en.isIntersecting) {
                        en.target.classList.add('visible');
                        hObs.unobserve(en.target);
                    }
                });
            }, { threshold: 0.2 });
            $$('.gallery-year-section .reveal').forEach(el => hObs.observe(el));
        }
    }

    /* ── Init ──────────────────────────────────────────────── */
    document.addEventListener('DOMContentLoaded', () => {
        initFilter();
        initLightbox();
        initScrollAnimations();
    });

})();
