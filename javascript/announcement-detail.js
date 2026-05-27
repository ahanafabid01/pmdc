'use strict';

document.addEventListener('DOMContentLoaded', () => {
    const currentUrl = window.location.href;

    const fbBtn = document.getElementById('shareFacebookBtn');
    const waBtn = document.getElementById('shareWhatsappBtn');
    if (fbBtn) {
        fbBtn.href = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(currentUrl)}`;
    }
    if (waBtn) {
        waBtn.href = `https://wa.me/?text=${encodeURIComponent(currentUrl)}`;
    }

    const copyBtn = document.getElementById('copyLinkBtn');
    const toast = document.getElementById('linkToast');

    function showToast() {
        if (!toast) return;
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 1800);
    }

    async function copyLink() {
        try {
            await navigator.clipboard.writeText(currentUrl);
            showToast();
            return;
        } catch (_err) {
            const input = document.createElement('input');
            input.value = currentUrl;
            document.body.appendChild(input);
            input.select();
            document.execCommand('copy');
            document.body.removeChild(input);
            showToast();
        }
    }

    copyBtn?.addEventListener('click', copyLink);

    const heroRows = document.querySelectorAll('.ann-detail-hero .reveal');
    heroRows.forEach((el, i) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(16px)';
        el.style.transition = 'opacity .42s ease, transform .42s ease';
        setTimeout(() => {
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';
        }, 80 + (i * 70));
    });

    const detailNodes = document.querySelectorAll('.detail-animate');
    const detailObs = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            entry.target.classList.add('visible');
            detailObs.unobserve(entry.target);
        });
    }, {
        threshold: 0.08,
        rootMargin: '40px',
    });

    detailNodes.forEach(node => detailObs.observe(node));

    const sidebarCards = document.querySelectorAll('.sidebar-stagger');
    const sideObs = new IntersectionObserver((entries) => {
        entries.forEach((entry, idx) => {
            if (!entry.isIntersecting) return;
            setTimeout(() => entry.target.classList.add('visible'), idx * 90);
            sideObs.unobserve(entry.target);
        });
    }, {
        threshold: 0.12,
        rootMargin: '20px',
    });

    sidebarCards.forEach(card => sideObs.observe(card));
});
