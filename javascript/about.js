// ========================================
// ABOUT PAGE - PROFESSIONAL SCROLL EFFECTS
// ========================================

document.addEventListener('DOMContentLoaded', function() {
    
    // Timeline Animation on Scroll
    const timelineObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateX(0)';
                }, index * 150);
            }
        });
    }, { threshold: 0.2 });

    document.querySelectorAll('.history-item').forEach(item => {
        item.style.opacity = '0';
        item.style.transform = item.classList.contains('left') ? 'translateX(-50px)' : 'translateX(50px)';
        item.style.transition = 'all 0.8s cubic-bezier(0.4, 0, 0.2, 1)';
        timelineObserver.observe(item);
    });

    // Team Card Hover Effect with 3D Tilt
    document.querySelectorAll('.team-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) rotateY(5deg)';
            this.style.boxShadow = '0 20px 40px rgba(0,0,0,0.2)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) rotateY(0)';
            this.style.boxShadow = '';
        });
    });

    // President Section Enhanced Effects
    const presidentObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.1 });

    const presidentSection = document.querySelector('.president-section');
    if (presidentSection) {
        presidentObserver.observe(presidentSection);
        
        // Smooth parallax effect
        let ticking = false;
        window.addEventListener('scroll', () => {
            if (!ticking) {
                window.requestAnimationFrame(() => {
                    const scrolled = window.pageYOffset;
                    const sectionTop = presidentSection.offsetTop;
                    const sectionHeight = presidentSection.offsetHeight;
                    
                    if (scrolled > sectionTop - window.innerHeight && scrolled < sectionTop + sectionHeight) {
                        const img = presidentSection.querySelector('.president-img');
                        const frame = presidentSection.querySelector('.president-img-frame');
                        
                        if (img && frame) {
                            const progress = (scrolled - (sectionTop - window.innerHeight)) / (sectionHeight + window.innerHeight);
                            const parallaxSpeed = progress * 30;
                            
                            // Subtle parallax on image only
                            img.style.transform = `translateY(${parallaxSpeed}px) scale(1.05)`;
                        }
                    }
                    ticking = false;
                });
                ticking = true;
            }
        }, { passive: true });
    }

    // MVV Cards Scale on View
    const mvvObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.transform = 'scale(1) rotateY(0)';
                    entry.target.style.opacity = '1';
                }, index * 200);
            }
        });
    }, { threshold: 0.3 });

    document.querySelectorAll('.mvv-card').forEach(card => {
        card.style.transform = 'scale(0.8) rotateY(-10deg)';
        card.style.opacity = '0';
        card.style.transition = 'all 0.8s cubic-bezier(0.34, 1.56, 0.64, 1)';
        mvvObserver.observe(card);
    });
});