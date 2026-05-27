// ========================================
// ACADEMICS PAGE - PROFESSIONAL SCROLL EFFECTS
// ========================================

// Program Search Functionality
function handleSearch() {
    const query = document.getElementById('searchInput');
    if(query && query.value) {
        // In a real app, this would redirect to search_results.php?q=query
        alert(`Searching for programs related to: "${query.value}"`);
    }
}

// Initialize academics page specific features
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    
    // Search on Enter key
    if (searchInput) {
        searchInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                handleSearch();
            }
        });
    }

    // Degree Cards Flip Animation
    const degreeObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.transform = 'rotateY(0deg)';
                    entry.target.style.opacity = '1';
                }, index * 150);
            }
        });
    }, { threshold: 0.2 });

    document.querySelectorAll('.degree-card').forEach(card => {
        card.style.transform = 'rotateY(-90deg)';
        card.style.opacity = '0';
        card.style.transition = 'all 0.8s cubic-bezier(0.4, 0, 0.2, 1)';
        degreeObserver.observe(card);
    });

    // Department Cards Staggered Slide
    const deptObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                const cards = entry.target.querySelectorAll('.dept-card');
                cards.forEach((card, cardIndex) => {
                    setTimeout(() => {
                        card.style.transform = 'translateX(0) scale(1)';
                        card.style.opacity = '1';
                    }, cardIndex * 100);
                });
            }
        });
    }, { threshold: 0.1 });

    const deptGrid = document.querySelector('.dept-grid');
    if (deptGrid) {
        deptGrid.querySelectorAll('.dept-card').forEach(card => {
            card.style.transform = 'translateX(-50px) scale(0.9)';
            card.style.opacity = '0';
            card.style.transition = 'all 0.6s ease';
        });
        deptObserver.observe(deptGrid);
    }

    // Resources Bar Fade-in from Bottom
    const resourcesObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const items = entry.target.querySelectorAll('.resource-item');
                items.forEach((item, index) => {
                    setTimeout(() => {
                        item.style.transform = 'translateY(0)';
                        item.style.opacity = '1';
                    }, index * 100);
                });
            }
        });
    }, { threshold: 0.3 });

    const resourcesBar = document.querySelector('.resources-bar');
    if (resourcesBar) {
        resourcesBar.querySelectorAll('.resource-item').forEach(item => {
            item.style.transform = 'translateY(30px)';
            item.style.opacity = '0';
            item.style.transition = 'all 0.6s ease';
        });
        resourcesObserver.observe(resourcesBar);
    }

    // Online Section Split Animation
    const onlineObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const content = entry.target.querySelector('.online-content');
                const image = entry.target.querySelector('.online-img');
                
                if (content) {
                    content.style.transform = 'translateX(0)';
                    content.style.opacity = '1';
                }
                
                if (image) {
                    setTimeout(() => {
                        image.style.transform = 'translateX(0) scale(1)';
                        image.style.opacity = '1';
                    }, 300);
                }
            }
        });
    }, { threshold: 0.2 });

    const onlineSection = document.querySelector('.online-section');
    if (onlineSection) {
        const content = onlineSection.querySelector('.online-content');
        const image = onlineSection.querySelector('.online-img');
        
        if (content) {
            content.style.transform = 'translateX(-50px)';
            content.style.opacity = '0';
            content.style.transition = 'all 0.8s ease';
        }
        
        if (image) {
            image.style.transform = 'translateX(50px) scale(0.9)';
            image.style.opacity = '0';
            image.style.transition = 'all 0.8s ease';
        }
        
        onlineObserver.observe(onlineSection);
    }
});