// ========================================
// ANNOUNCEMENTS PAGE - OPTIMIZED SCROLL EFFECTS
// Faster, more responsive animations
// ========================================

document.addEventListener('DOMContentLoaded', function() {
    
    // ========================================
    // OPTIMIZED ANNOUNCEMENT CARDS ANIMATION
    // Threshold: 0.05 (triggers earlier)
    // Delay: 50ms (faster stagger)
    // Transition: 0.4s (quicker animation)
    // ========================================
    const cardObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                // Reduced delay from 100ms to 50ms for faster appearance
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, index * 50);
                // Unobserve after animation to improve performance
                cardObserver.unobserve(entry.target);
            }
        });
    }, { 
        threshold: 0.05,  // Triggers when only 5% visible (was 0.1)
        rootMargin: '50px' // Start animation 50px before element enters viewport
    });

    // Apply to all announcement cards
    document.querySelectorAll('.announcement-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)'; // Reduced from 30px for subtler effect
        card.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)'; // Faster transition
        cardObserver.observe(card);
    });

    // ========================================
    // PAGE HEADER ANIMATION
    // Immediate fade-in on page load
    // ========================================
    const pageHeader = document.querySelector('.page-header');
    if (pageHeader) {
        pageHeader.style.opacity = '0';
        pageHeader.style.transform = 'translateY(-20px)';
        
        // Immediate animation without intersection observer
        setTimeout(() => {
            pageHeader.style.transition = 'all 0.5s ease-out';
            pageHeader.style.opacity = '1';
            pageHeader.style.transform = 'translateY(0)';
        }, 50);
    }

    // ========================================
    // FILTER TABS ANIMATION
    // Quick fade-in with minimal delay
    // ========================================
    const filterTabsObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
                filterTabsObserver.unobserve(entry.target);
            }
        });
    }, { 
        threshold: 0.1,
        rootMargin: '30px'
    });

    const filterTabs = document.querySelector('.filter-tabs');
    if (filterTabs) {
        filterTabs.style.opacity = '0';
        filterTabs.style.transform = 'translateY(15px)';
        filterTabs.style.transition = 'all 0.3s ease-out'; // Very fast
        filterTabsObserver.observe(filterTabs);
    }

    // ========================================
    // NOTICE BANNER ANIMATION
    // Slide in from left with reduced delay
    // ========================================
    const bannerObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateX(0)';
                bannerObserver.unobserve(entry.target);
            }
        });
    }, { 
        threshold: 0.1,
        rootMargin: '50px'
    });

    const noticeBanner = document.querySelector('.notice-banner');
    if (noticeBanner) {
        noticeBanner.style.opacity = '0';
        noticeBanner.style.transform = 'translateX(-30px)';
        noticeBanner.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
        bannerObserver.observe(noticeBanner);
    }

    // ========================================
    // QUICK LINKS ANIMATION
    // Staggered fade-in with minimal delay
    // ========================================
    const quickLinksObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0) scale(1)';
                }, index * 40); // Reduced from 60ms to 40ms
                quickLinksObserver.unobserve(entry.target);
            }
        });
    }, { 
        threshold: 0.1,
        rootMargin: '40px'
    });

    document.querySelectorAll('.quick-link-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px) scale(0.95)';
        card.style.transition = 'all 0.35s cubic-bezier(0.4, 0, 0.2, 1)'; // Very fast
        quickLinksObserver.observe(card);
    });

    // ========================================
    // FILTER FUNCTIONALITY
    // Instant filtering with smooth transitions
    // ========================================
    const filterButtons = document.querySelectorAll('.filter-btn');
    const announcementCards = document.querySelectorAll('.announcement-card');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const category = this.getAttribute('data-category');
            
            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Filter cards with optimized animation
            announcementCards.forEach((card, index) => {
                const cardCategory = card.getAttribute('data-category');
                
                if (category === 'all' || cardCategory === category) {
                    // Show card with staggered animation (reduced delay)
                    setTimeout(() => {
                        card.style.display = 'block';
                        setTimeout(() => {
                            card.style.opacity = '1';
                            card.style.transform = 'translateY(0)';
                        }, 10);
                    }, index * 30); // Reduced from 50ms to 30ms
                } else {
                    // Hide card instantly
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(15px)';
                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 200); // Reduced from 300ms
                }
            });
        });
    });

    // ========================================
    // LOAD MORE FUNCTIONALITY
    // Smooth scroll with instant content reveal
    // ========================================
    const loadMoreBtn = document.querySelector('.load-more-btn');
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            // Add loading state
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
            this.disabled = true;
            
            // Simulate loading (replace with actual AJAX call)
            setTimeout(() => {
                this.innerHTML = originalText;
                this.disabled = false;
                
                // Show success message
                const message = document.createElement('div');
                message.textContent = 'No more announcements to load';
                message.style.cssText = 'text-align: center; color: var(--text-light); margin-top: 20px; font-size: 0.95rem;';
                this.parentElement.appendChild(message);
                this.style.display = 'none';
                
                // Auto-remove message after 3 seconds
                setTimeout(() => message.remove(), 3000);
            }, 800); // Reduced from 1500ms
        });
    }

    // ========================================
    // ANNOUNCEMENT BADGE PULSE ANIMATION
    // Draw attention to urgent items
    // ========================================
    const urgentBadges = document.querySelectorAll('.badge-urgent, .badge-important');
    urgentBadges.forEach(badge => {
        badge.style.animation = 'pulse 2s ease-in-out infinite';
    });

    // Add pulse keyframes
    if (!document.querySelector('#badge-pulse-animation')) {
        const style = document.createElement('style');
        style.id = 'badge-pulse-animation';
        style.textContent = `
            @keyframes pulse {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(1.05); }
            }
        `;
        document.head.appendChild(style);
    }

    // ========================================
    // SMOOTH SCROLL FOR ANCHOR LINKS
    // Enhanced user experience
    // ========================================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // ========================================
    // HOVER EFFECTS FOR CARDS
    // Instant visual feedback
    // ========================================
    announcementCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transition = 'all 0.25s ease-out'; // Faster hover response
        });
    });

    // ========================================
    // KEYBOARD ACCESSIBILITY
    // Allow keyboard navigation for filters
    // ========================================
    filterButtons.forEach(button => {
        button.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            }
        });
    });

    // ========================================
    // PERFORMANCE OPTIMIZATION
    // Reduce repaints and reflows
    // ========================================
    
    // Use requestAnimationFrame for smooth animations
    let ticking = false;
    window.addEventListener('scroll', () => {
        if (!ticking) {
            window.requestAnimationFrame(() => {
                // Scroll-based animations go here
                ticking = false;
            });
            ticking = true;
        }
    });

    console.log('✓ Announcements page loaded with optimized scroll effects');
    console.log('✓ Animation delays reduced by 50% for better UX');
    console.log('✓ Intersection observer thresholds optimized');
});
