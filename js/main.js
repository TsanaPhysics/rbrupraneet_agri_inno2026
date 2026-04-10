// ===== Main JavaScript File =====
// Import all modules
import { initSmoothScrolling, initNavbarActiveState, initNavbarScroll } from './navigation.js';
import { initActivityToggle, initScrollAnimations, initCounterAnimation, initParallax } from './activities.js';

// Initialize all functions when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    console.log('🌾 RBRU-Praneet Digital Agri-Innovation Center - Website Loaded');

    // Initialize navigation
    initSmoothScrolling();
    const updateActiveNav = initNavbarActiveState();
    initNavbarScroll();

    // Initialize activities and animations
    initActivityToggle();
    initScrollAnimations();
    initCounterAnimation();
    initParallax();

    // Initial nav update
    updateActiveNav();
});
