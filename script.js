// ===== Smooth Scrolling =====
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
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

// ===== Navbar Active State =====
const navLinks = document.querySelectorAll('.nav-link');
const sections = document.querySelectorAll('section[id]');

function updateActiveNav() {
    const scrollY = window.pageYOffset;
    
    sections.forEach(section => {
        const sectionHeight = section.offsetHeight;
        const sectionTop = section.offsetTop - 100;
        const sectionId = section.getAttribute('id');
        
        if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === `#${sectionId}`) {
                    link.classList.add('active');
                }
            });
        }
    });
}

window.addEventListener('scroll', updateActiveNav);

// ===== Navbar Premium Interactivity =====
const navbar = document.querySelector('.navbar');
const mobileToggle = document.querySelector('.mobile-toggle');
const navLinksContainer = document.querySelector('.nav-links');

window.addEventListener('scroll', () => {
    if (window.scrollY > 40) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});

if (mobileToggle) {
    mobileToggle.addEventListener('click', () => {
        mobileToggle.classList.toggle('active');
        navLinksContainer.classList.toggle('active');
    });
}

// ===== Activity Cards Toggle =====
const activityCards = document.querySelectorAll('.activity-card');

activityCards.forEach(card => {
    const toggleBtn = card.querySelector('.activity-toggle');
    const toggleText = toggleBtn.querySelector('.toggle-text');
    
    toggleBtn.addEventListener('click', () => {
        // Close other cards
        activityCards.forEach(otherCard => {
            if (otherCard !== card && otherCard.classList.contains('active')) {
                otherCard.classList.remove('active');
                const otherToggleText = otherCard.querySelector('.toggle-text');
                otherToggleText.textContent = 'รายละเอียด';
            }
        });
        
        // Toggle current card
        card.classList.toggle('active');
        
        if (card.classList.contains('active')) {
            toggleText.textContent = 'ปิด';
        } else {
            toggleText.textContent = 'รายละเอียด';
        }
    });
});

// ===== Scroll Animations =====
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// Observe all cards and sections
const animatedElements = document.querySelectorAll('.about-card, .activity-card, .stat-item');
animatedElements.forEach(element => {
    element.style.opacity = '0';
    element.style.transform = 'translateY(30px)';
    element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    observer.observe(element);
});

// ===== Counter Animation for Stats =====
const statNumbers = document.querySelectorAll('.stat-number');

function animateCounter(element) {
    const target = parseInt(element.textContent);
    let current = 0;
    const increment = target / 50;
    const duration = 1000;
    const stepTime = duration / 50;
    
    const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
            element.textContent = target;
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(current);
        }
    }, stepTime);
}

const statsObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const statNumber = entry.target.querySelector('.stat-number');
            animateCounter(statNumber);
            statsObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.5 });

document.querySelectorAll('.stat-item').forEach(stat => {
    statsObserver.observe(stat);
});

// ===== Parallax Effect for Hero =====
window.addEventListener('scroll', () => {
    const scrolled = window.pageYOffset;
    const heroVisual = document.querySelector('.hero-visual');
    
    if (heroVisual) {
        heroVisual.style.transform = `translateY(${scrolled * 0.3}px)`;
    }
});

// ===== Add hover effect to activity cards =====
activityCards.forEach(card => {
    card.addEventListener('mouseenter', () => {
        const icon = card.querySelector('.activity-icon');
        icon.style.transform = 'scale(1.2) rotate(10deg)';
        icon.style.transition = 'transform 0.3s ease';
    });
    
    card.addEventListener('mouseleave', () => {
        const icon = card.querySelector('.activity-icon');
        icon.style.transform = 'scale(1) rotate(0deg)';
    });
});

// ===== Initialize =====
document.addEventListener('DOMContentLoaded', () => {
    console.log('🌾 RBRU-Praneet Digital Agri-Innovation Center - Website Loaded');
    updateActiveNav();
});
