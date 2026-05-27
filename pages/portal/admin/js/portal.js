// Admin Portal JavaScript

// Reuse base portal functionality
if (typeof window.initPortal === 'undefined') {
    const sidebar = document.getElementById('sidebar');
    const menuToggle = document.getElementById('menuToggle');
    const closeSidebar = document.getElementById('closeSidebar');
    const navItems = document.querySelectorAll('.nav-item');

    if (menuToggle) {
        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });
    }

    if (closeSidebar) {
        closeSidebar.addEventListener('click', () => {
            sidebar.classList.remove('active');
        });
    }

    navItems.forEach(item => {
        item.addEventListener('click', (e) => {
            navItems.forEach(nav => nav.classList.remove('active'));
            item.classList.add('active');
            
            if (window.innerWidth <= 992) {
                sidebar.classList.remove('active');
            }
        });
    });

    document.addEventListener('click', (e) => {
        if (window.innerWidth <= 992) {
            if (!sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
                sidebar.classList.remove('active');
            }
        }
    });

    window.initPortal = true;
}

// Admin-specific functionality

// Handle approval buttons
document.querySelectorAll('.btn-approve, .btn-reject').forEach(btn => {
    btn.addEventListener('click', function() {
        const approvalItem = this.closest('.approval-item');
        const requestType = approvalItem.querySelector('h4').textContent;
        const requester = approvalItem.querySelector('p').textContent;
        const action = this.classList.contains('btn-approve') ? 'approve' : 'reject';
        
        console.log(`${action} request: ${requestType} from ${requester}`);
        
        // Animate removal
        approvalItem.style.opacity = '0';
        approvalItem.style.transform = 'translateX(-20px)';
        setTimeout(() => {
            approvalItem.style.display = 'none';
        }, 300);
    });
});

// Handle quick action cards
document.querySelectorAll('.action-card').forEach(card => {
    card.addEventListener('click', function() {
        const action = this.querySelector('span').textContent;
        console.log(`Admin action: ${action}`);
        // Handle admin action
    });
});

// Filter select handler
const filterSelects = document.querySelectorAll('.filter-select');
filterSelects.forEach(select => {
    select.addEventListener('change', function() {
        console.log(`Filter changed to: ${this.value}`);
        // Handle filter change - would normally fetch filtered data
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
            sidebar.classList.remove('active');
        }
    }, 250);
});

// Simulate real-time updates (for demo)
function updateSystemMetrics() {
    const metrics = document.querySelectorAll('.metric-fill');
    metrics.forEach(metric => {
        const currentWidth = parseInt(metric.style.width);
        const randomChange = Math.floor(Math.random() * 5) - 2;
        const newWidth = Math.max(0, Math.min(100, currentWidth + randomChange));
        metric.style.width = newWidth + '%';
        
        // Update color based on usage
        if (newWidth > 80) {
            metric.style.background = '#e53e3e';
        } else if (newWidth > 60) {
            metric.style.background = '#d69e2e';
        } else {
            metric.style.background = '#38a169';
        }
    });
}

// Update metrics every 30 seconds (for demo)
setInterval(updateSystemMetrics, 30000);

console.log('Admin Portal initialized successfully');
