// ========================================
// CONTACT PAGE - PROFESSIONAL SCROLL EFFECTS
// ========================================

// Form Submission Handler
function handleFormSubmit(e) {
    e.preventDefault();
    
    // Simulate backend processing delay
    const submitBtn = e.target.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerText;
    
    submitBtn.innerText = "Sending...";
    submitBtn.disabled = true;

    setTimeout(() => {
        // Show success message
        const successMessage = document.getElementById('successMessage');
        if (successMessage) {
            successMessage.style.display = 'block';
            successMessage.style.animation = 'slideInDown 0.5s ease';
        }
        
        // Reset form
        const contactForm = document.getElementById('contactForm');
        if (contactForm) {
            contactForm.reset();
        }
        
        // Reset button
        submitBtn.innerText = originalText;
        submitBtn.disabled = false;

        // Hide message after 5 seconds
        setTimeout(() => {
            if (successMessage) {
                successMessage.style.animation = 'slideOutUp 0.5s ease';
                setTimeout(() => {
                    successMessage.style.display = 'none';
                }, 500);
            }
        }, 5000);

    }, 1500);
}

// Professional Scroll Effects
document.addEventListener('DOMContentLoaded', function() {
    
    // Contact Grid Split Animation
    const contactObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const infoCol = entry.target.querySelector('.contact-info-col');
                const formWrapper = entry.target.querySelector('.form-wrapper');
                
                if (infoCol) {
                    setTimeout(() => {
                        infoCol.style.transform = 'translateX(0)';
                        infoCol.style.opacity = '1';
                    }, 100);
                }
                
                if (formWrapper) {
                    setTimeout(() => {
                        formWrapper.style.transform = 'translateX(0)';
                        formWrapper.style.opacity = '1';
                    }, 300);
                }
            }
        });
    }, { threshold: 0.1 });

    const contactGrid = document.querySelector('.contact-grid');
    if (contactGrid) {
        const infoCol = contactGrid.querySelector('.contact-info-col');
        const formWrapper = contactGrid.querySelector('.form-wrapper');
        
        if (infoCol) {
            infoCol.style.transform = 'translateX(-50px)';
            infoCol.style.opacity = '0';
            infoCol.style.transition = 'all 0.8s ease';
        }
        
        if (formWrapper) {
            formWrapper.style.transform = 'translateX(50px)';
            formWrapper.style.opacity = '0';
            formWrapper.style.transition = 'all 0.8s ease';
        }
        
        contactObserver.observe(contactGrid);
    }

    // Info Items Staggered Animation
    const infoObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const items = entry.target.querySelectorAll('.info-item');
                items.forEach((item, index) => {
                    setTimeout(() => {
                        item.style.transform = 'translateY(0)';
                        item.style.opacity = '1';
                    }, index * 150);
                });
            }
        });
    }, { threshold: 0.2 });

    const infoCard = document.querySelector('.info-card');
    if (infoCard) {
        infoCard.querySelectorAll('.info-item').forEach(item => {
            item.style.transform = 'translateY(20px)';
            item.style.opacity = '0';
            item.style.transition = 'all 0.6s ease';
        });
        infoObserver.observe(infoCard);
    }

    // Form Input Focus Effects
    const formInputs = document.querySelectorAll('.form-control');
    formInputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.style.transform = 'scale(1.02)';
            this.style.borderColor = 'var(--secondary-color)';
            this.style.boxShadow = '0 0 0 3px rgba(212, 165, 116, 0.1)';
        });
        
        input.addEventListener('blur', function() {
            this.style.transform = 'scale(1)';
            this.style.borderColor = '';
            this.style.boxShadow = '';
        });
    });

    // Department List Hover Effect
    const deptItems = document.querySelectorAll('.dept-list-item');
    deptItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(10px)';
            this.style.backgroundColor = 'rgba(212, 165, 116, 0.05)';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
            this.style.backgroundColor = '';
        });
    });

    // Map Fade-in Animation
    const mapObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });

    const mapSection = document.querySelector('.map-section');
    if (mapSection) {
        mapSection.style.opacity = '0';
        mapSection.style.transform = 'translateY(50px)';
        mapSection.style.transition = 'all 1s ease';
        mapObserver.observe(mapSection);
    }

    // Add transition to department items
    deptItems.forEach(item => {
        item.style.transition = 'all 0.3s ease';
    });
});