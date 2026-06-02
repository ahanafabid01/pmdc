/**
 * main.js — PMDC College Website
 * Phulpur Mohila Degree College
 */

'use strict';

document.addEventListener('DOMContentLoaded', () => {

    /* ── Hero background slider ──────────────────────────── */
    const heroSlides = Array.from(document.querySelectorAll('.hero-slide'));
    const heroPrev = document.querySelector('.hero-slider-prev');
    const heroNext = document.querySelector('.hero-slider-next');
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (heroSlides.length > 1) {
        let currentSlide = 0;

        const showHeroSlide = (nextIndex) => {
            heroSlides[currentSlide].classList.remove('active');
            currentSlide = (nextIndex + heroSlides.length) % heroSlides.length;
            heroSlides[currentSlide].classList.add('active');
        };

        const nextHeroSlide = () => showHeroSlide(currentSlide + 1);
        const prevHeroSlide = () => showHeroSlide(currentSlide - 1);
        let heroTimer = null;

        const restartHeroTimer = () => {
            if (reduceMotion) return;
            clearInterval(heroTimer);
            heroTimer = setInterval(nextHeroSlide, 4500);
        };

        heroNext?.addEventListener('click', () => {
            nextHeroSlide();
            restartHeroTimer();
        });

        heroPrev?.addEventListener('click', () => {
            prevHeroSlide();
            restartHeroTimer();
        });

        restartHeroTimer();
    }

    /* ── Mobile Navigation ───────────────────────────────── */
    const hamburger  = document.getElementById('hamburger');
    const navMenu    = document.getElementById('nav-menu');
    const backdrop   = document.getElementById('navBackdrop');

    /* Inject a panel header into the nav menu (mobile only) */
    function injectPanelHeader() {
        if (document.getElementById('navPanelHeader')) return; // already injected
        const header = document.createElement('div');
        header.id = 'navPanelHeader';
        header.innerHTML = `
            <div class="npm-title">Menu</div>
            <button class="npm-close" id="navPanelClose" aria-label="Close menu">
                <i class="fas fa-times"></i>
            </button>`;
        navMenu.insertBefore(header, navMenu.firstChild);
        document.getElementById('navPanelClose')?.addEventListener('click', closeMenu);
    }

    function openMenu() {
        injectPanelHeader();
        navMenu.classList.add('active');
        backdrop?.classList.add('active');
        hamburger?.classList.add('is-open');
        hamburger?.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden'; // lock scroll
    }
    function closeMenu() {
        navMenu.classList.remove('active');
        backdrop?.classList.remove('active');
        hamburger?.classList.remove('is-open');
        hamburger?.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
        // also close any open dropdowns
        document.querySelectorAll('.nav-has-dropdown.open').forEach(d => d.classList.remove('open'));
    }

    hamburger?.addEventListener('click', () => {
        navMenu.classList.contains('active') ? closeMenu() : openMenu();
    });

    // Close on backdrop click
    backdrop?.addEventListener('click', closeMenu);

    /* ── Dropdown hover management (desktop) ──────────────── */
    document.querySelectorAll('.nav-has-dropdown').forEach(dropdown => {
        let hoverTimer = null;

        dropdown.addEventListener('mouseenter', () => {
            if (window.innerWidth > 900) {
                clearTimeout(hoverTimer);
                dropdown.classList.add('open');
            }
        });
        dropdown.addEventListener('mouseleave', () => {
            if (window.innerWidth > 900) {
                hoverTimer = setTimeout(() => {
                    dropdown.classList.remove('open');
                }, 200);
            }
        });

        // Mobile: click toggle
        dropdown.querySelector('.nav-dropdown-toggle')?.addEventListener('click', function(e) {
            if (window.innerWidth <= 900) {
                e.preventDefault();
                e.stopPropagation();
                dropdown.classList.toggle('open');
            }
        });
    });

    // Close desktop dropdown on outside click
    document.addEventListener('click', e => {
        if (!e.target.closest('.nav-has-dropdown')) {
            document.querySelectorAll('.nav-has-dropdown.open').forEach(d => {
                if (window.innerWidth > 900) d.classList.remove('open');
            });
        }
    });

    // Close menu when any nav link or dropdown item is clicked
    navMenu?.querySelectorAll('.nav-link:not(.nav-dropdown-toggle), .dropdown-item').forEach(link => {
        link.addEventListener('click', closeMenu);
    });

    /* ── Navbar scroll shadow ────────────────────────────── */
    const navbar = document.getElementById('navbar');
    const onScroll = () => {
        navbar?.classList.toggle('scrolled', window.scrollY > 40);
    };
    window.addEventListener('scroll', onScroll, { passive: true });

    /* ── Smooth anchor scroll ────────────────────────────── */
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href === '#') return;
            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                const offset = (navbar?.offsetHeight || 72) + 16;
                window.scrollTo({ top: target.offsetTop - offset, behavior: 'smooth' });
            }
        });
    });

    /* ── Scroll progress bar ─────────────────────────────── */
    const bar = document.createElement('div');
    bar.style.cssText = `
        position:fixed;top:0;left:0;height:3px;width:0;
        background:linear-gradient(90deg,#2563eb,#7c3aed);
        z-index:9999;transition:width .1s linear;
        pointer-events:none;
    `;
    document.body.appendChild(bar);
    window.addEventListener('scroll', () => {
        const max  = document.documentElement.scrollHeight - window.innerHeight;
        bar.style.width = (window.scrollY / max * 100) + '%';
    }, { passive: true });

    /* ── Reveal on scroll (Intersection Observer) ────────── */
    const revealObs = new IntersectionObserver((entries) => {
        entries.forEach((entry, i) => {
            if (entry.isIntersecting) {
                entry.target.style.transitionDelay = (i * 0.06) + 's';
                entry.target.classList.add('visible');
                revealObs.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

    document.querySelectorAll('.reveal').forEach(el => revealObs.observe(el));

    /* ── Counter animation ───────────────────────────────── */
    const ctrObs = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !entry.target.dataset.counted) {
                entry.target.dataset.counted = '1';
                animateCount(entry.target);
                ctrObs.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    document.querySelectorAll('.stat-value').forEach(el => ctrObs.observe(el));

    function animateCount(el) {
        const raw   = el.textContent.trim();
        const num   = parseFloat(raw.replace(/[^\d.]/g, ''));
        const plus  = raw.includes('+');
        const pct   = raw.includes('%');
        if (isNaN(num)) return;

        const dur = 1600, steps = 50, inc = num / steps;
        let cur = 0;
        const tick = setInterval(() => {
            cur = Math.min(cur + inc, num);
            el.textContent = (Number.isInteger(num) ? Math.floor(cur) : cur.toFixed(1))
                           + (plus ? '+' : '')
                           + (pct   ? '%' : '');
            if (cur >= num) clearInterval(tick);
        }, dur / steps);
    }

});

/* ── Modal ───────────────────────────────────────────────── */
const modalOverlay = document.getElementById('modalOverlay');
const modalTitle   = document.getElementById('modalTitle');

function openModal(name) {
    if (modalTitle)   modalTitle.textContent = name;
    modalOverlay?.classList.add('active');
}
function closeModal() {
    modalOverlay?.classList.remove('active');
}

modalOverlay?.addEventListener('click', e => {
    if (e.target === modalOverlay) closeModal();
});
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeModal();
});
