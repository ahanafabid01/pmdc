// ========================================
// RESULTS PAGE - PROFESSIONAL SCROLL EFFECTS
// ========================================

document.addEventListener('DOMContentLoaded', function() {
    
    // Fade-in animation for result cards on scroll
    const resultObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, index * 100);
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.result-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
        resultObserver.observe(card);
    });

    // Search card animation
    const searchCardObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0) scale(1)';
            }
        });
    }, { threshold: 0.1 });

    const searchCard = document.querySelector('.search-card');
    if (searchCard) {
        searchCard.style.opacity = '0';
        searchCard.style.transform = 'translateY(40px) scale(0.95)';
        searchCard.style.transition = 'all 0.8s cubic-bezier(0.4, 0, 0.2, 1)';
        searchCardObserver.observe(searchCard);
    }

    // Notice card animation
    const noticeCard = document.querySelector('.notice-card');
    if (noticeCard) {
        noticeCard.style.opacity = '0';
        noticeCard.style.transform = 'translateX(-30px)';
        noticeCard.style.transition = 'all 0.7s cubic-bezier(0.4, 0, 0.2, 1)';
        
        const noticeObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateX(0)';
                }
            });
        }, { threshold: 0.2 });
        
        noticeObserver.observe(noticeCard);
    }

    // Filter buttons stagger animation
    const filterBtns = document.querySelectorAll('.filter-btn');
    filterBtns.forEach((btn, index) => {
        btn.style.opacity = '0';
        btn.style.transform = 'translateY(-20px)';
        btn.style.transition = 'all 0.5s cubic-bezier(0.4, 0, 0.2, 1)';
        
        setTimeout(() => {
            btn.style.opacity = '1';
            btn.style.transform = 'translateY(0)';
        }, 100 + (index * 100));
    });

    // Enhanced form validation with visual feedback
    const form = document.getElementById('resultSearchForm');
    const inputs = form.querySelectorAll('.form-control');
    
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value.trim() === '') {
                this.style.borderColor = '#e53e3e';
                this.style.background = '#fff5f5';
            } else {
                this.style.borderColor = '#38a169';
                this.style.background = '#f0fff4';
            }
        });
        
        input.addEventListener('focus', function() {
            this.style.borderColor = 'var(--secondary-color)';
            this.style.background = 'var(--white)';
        });
    });

    // Result card hover parallax effect
    document.querySelectorAll('.result-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            const icon = this.querySelector('.result-icon');
            if (icon) {
                icon.style.transform = 'scale(1.1) rotate(5deg)';
                icon.style.transition = 'all 0.3s ease';
            }
        });
        
        card.addEventListener('mouseleave', function() {
            const icon = this.querySelector('.result-icon');
            if (icon) {
                icon.style.transform = 'scale(1) rotate(0deg)';
            }
        });
    });

    // Smooth scroll for filter changes
    const resultsGrid = document.querySelector('.results-grid');
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Smooth scroll to results
            setTimeout(() => {
                resultsGrid.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'nearest' 
                });
            }, 100);
        });
    });

    // Count animation for result meta (number of students)
    const countElements = document.querySelectorAll('.result-meta span');
    countElements.forEach(el => {
        const text = el.textContent;
        const match = text.match(/(\d+)\s+Students/);
        if (match) {
            el.setAttribute('data-count', match[1]);
        }
    });

    // Create scroll progress indicator
    const progressBar = document.createElement('div');
    progressBar.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 0%;
        height: 4px;
        background: linear-gradient(90deg, var(--secondary-color), var(--soft-blue));
        z-index: 99999;
        transition: width 0.1s ease;
    `;
    document.body.appendChild(progressBar);

    window.addEventListener('scroll', () => {
        const windowHeight = window.innerHeight;
        const documentHeight = document.documentElement.scrollHeight - windowHeight;
        const scrolled = (window.pageYOffset / documentHeight) * 100;
        progressBar.style.width = scrolled + '%';
    });

    // Badge pulse animation enhancement
    document.querySelectorAll('.result-badge.new').forEach((badge, index) => {
        badge.style.animationDelay = `${index * 0.2}s`;
    });

    // Add loading skeleton for better UX (can be used when fetching results from API)
    function createLoadingSkeleton() {
        const skeleton = document.createElement('div');
        skeleton.className = 'result-card skeleton';
        skeleton.innerHTML = `
            <div class="skeleton-icon"></div>
            <div class="skeleton-content">
                <div class="skeleton-line skeleton-title"></div>
                <div class="skeleton-line"></div>
                <div class="skeleton-line"></div>
            </div>
        `;
        return skeleton;
    }

    // Enhanced filter with smooth transitions
    const originalFilterLogic = () => {
        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                const filter = this.getAttribute('data-filter');
                const cards = document.querySelectorAll('.result-card');
                
                cards.forEach((card, index) => {
                    const category = card.getAttribute('data-category');
                    
                    if (filter === 'all' || category === filter) {
                        setTimeout(() => {
                            card.style.display = 'flex';
                            setTimeout(() => {
                                card.style.opacity = '1';
                                card.style.transform = 'translateY(0)';
                            }, 50);
                        }, index * 50);
                    } else {
                        card.style.opacity = '0';
                        card.style.transform = 'translateY(20px)';
                        setTimeout(() => {
                            card.style.display = 'none';
                        }, 300);
                    }
                });
            });
        });
    };

    // Initialize tooltips for buttons
    document.querySelectorAll('[title]').forEach(el => {
        el.addEventListener('mouseenter', function() {
            const tooltip = document.createElement('div');
            tooltip.className = 'custom-tooltip';
            tooltip.textContent = this.getAttribute('title');
            tooltip.style.cssText = `
                position: absolute;
                background: var(--primary-color);
                color: var(--white);
                padding: 8px 12px;
                border-radius: 6px;
                font-size: 0.85rem;
                white-space: nowrap;
                z-index: 1000;
                pointer-events: none;
                opacity: 0;
                transition: opacity 0.3s ease;
            `;
            this.appendChild(tooltip);
            setTimeout(() => tooltip.style.opacity = '1', 10);
        });
        
        el.addEventListener('mouseleave', function() {
            const tooltip = this.querySelector('.custom-tooltip');
            if (tooltip) {
                tooltip.style.opacity = '0';
                setTimeout(() => tooltip.remove(), 300);
            }
        });
    });

    // Add keyboard navigation for accessibility
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            // Close any open modals or reset form
            const activeElement = document.activeElement;
            if (activeElement.tagName === 'INPUT') {
                activeElement.blur();
            }
        }
    });

    // Console log for development
    console.log('Results page initialized successfully');
    console.log('Total results displayed:', document.querySelectorAll('.result-card').length);
});
