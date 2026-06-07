/**
 * portal.js — Shared sidebar/mobile menu logic for Students & Grades pages
 * Uses .open on sidebar + .active on overlay (matches styles.css)
 */
(function () {
    'use strict';

    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const toggle  = document.getElementById('menuToggle');
    const close   = document.getElementById('closeSidebar');

    if (!sidebar) return;

    function openSidebar() {
        sidebar.classList.add('open');
        if (overlay) overlay.classList.add('active');
    }

    function closeSidebarFn() {
        sidebar.classList.remove('open');
        if (overlay) overlay.classList.remove('active');
    }

    if (toggle)  toggle.addEventListener('click', openSidebar);
    if (close)   close.addEventListener('click', closeSidebarFn);
    if (overlay) overlay.addEventListener('click', closeSidebarFn);

    // Close on resize back to desktop
    window.addEventListener('resize', () => {
        if (window.innerWidth > 768) closeSidebarFn();
    });
}());

// Teacher-specific functionality

// Handle quick action buttons
document.querySelectorAll('.action-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const action = this.textContent.trim();
        console.log(`Action clicked: ${action}`);
        // Handle action (would integrate with backend)
    });
});

// Handle attendance taking
document.querySelectorAll('.btn-small').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.stopPropagation();
        const action = this.textContent.trim();
        console.log(`Class action: ${action}`);
        // Handle class action
    });
});

// Handle assignment reviews
document.querySelectorAll('.btn-review').forEach(btn => {
    btn.addEventListener('click', function() {
        const assignmentName = this.closest('.review-item').querySelector('h4').textContent;
        console.log(`Review assignment: ${assignmentName}`);
        // Open review interface
    });
});

// Handle student query replies
document.querySelectorAll('.btn-reply').forEach(btn => {
    btn.addEventListener('click', function() {
        if (this.classList.contains('replied')) {
            return;
        }
        const studentName = this.closest('.query-item').querySelector('.query-student h4').textContent;
        console.log(`Reply to: ${studentName}`);
        // Open reply interface
    });
});

// Handle quick action cards
document.querySelectorAll('.action-card').forEach(card => {
    card.addEventListener('click', function() {
        const action = this.querySelector('span').textContent;
        console.log(`Quick action: ${action}`);
        // Handle quick action
    });
});

// Animation on scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

document.querySelectorAll('.card, .stat-card').forEach(card => {
    card.style.opacity = '0';
    card.style.transform = 'translateY(20px)';
    card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    observer.observe(card);
});

// Handle window resize
let resizeTimer;
window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
        if (window.innerWidth > 992) {
            const sb = document.getElementById('sidebar');
            if (sb) sb.classList.remove('active');
        }
    }, 250);
});

// Initialize tooltips for class status
document.querySelectorAll('.class-status').forEach(status => {
    status.title = status.textContent.trim();
});

console.log('Teacher Portal initialized successfully');
