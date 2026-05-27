/**
 * main.js — PMDC College Website
 * Phulpur Mohila Degree College
 */

'use strict';

document.addEventListener('DOMContentLoaded', () => {

    /* ── Mobile Navigation ───────────────────────────────── */
    const hamburger   = document.getElementById('hamburger');
    const hamburgerIcon = document.getElementById('hamburgerIcon');
    const navMenu     = document.getElementById('nav-menu');

    function openMenu() {
        navMenu.classList.add('active');
        if (hamburgerIcon) { hamburgerIcon.className = 'fas fa-times'; }
        hamburger?.setAttribute('aria-expanded', 'true');
    }
    function closeMenu() {
        navMenu.classList.remove('active');
        if (hamburgerIcon) { hamburgerIcon.className = 'fas fa-bars'; }
        hamburger?.setAttribute('aria-expanded', 'false');
    }

    hamburger?.addEventListener('click', () => {
        navMenu.classList.contains('active') ? closeMenu() : openMenu();
    });

    // Close when a nav link is clicked
    navMenu?.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', closeMenu);
    });

    // Close on outside click
    document.addEventListener('click', e => {
        if (navMenu?.classList.contains('active') &&
            !navMenu.contains(e.target) &&
            e.target !== hamburger) {
            closeMenu();
        }
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