// ===== Activities Module =====

// Activity Cards Toggle
export function initActivityToggle() {
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

    // Add hover effect to activity cards
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
}

// Scroll Animations
export function initScrollAnimations() {
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
}

// Counter Animation for Stats
export function initCounterAnimation() {
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
}

// Parallax Effect for Hero
export function initParallax() {
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const heroVisual = document.querySelector('.hero-visual');

        if (heroVisual) {
            heroVisual.style.transform = `translateY(${scrolled * 0.3}px)`;
        }
    });
}
