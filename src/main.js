/**
 * Main entry point for Vite build
 * Includes Tailwind CSS and Alpine.js
 */

// Import Tailwind CSS
import './styles.css';

// Import Alpine.js
import Alpine from 'alpinejs';

// Initialize Alpine.js
window.Alpine = Alpine;
Alpine.start();

// Mobile Navigation Toggle
document.addEventListener('DOMContentLoaded', function() {
    const hamburgerMenu = document.querySelector('.hamburger-menu');
    const body = document.body;

    console.log('Mobile menu init - hamburger found:', !!hamburgerMenu);

    if (hamburgerMenu) {
        hamburgerMenu.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            console.log('Hamburger clicked');
            body.classList.toggle('nav-active');
            const isExpanded = body.classList.contains('nav-active');
            hamburgerMenu.setAttribute('aria-expanded', isExpanded);

            console.log('Menu state:', isExpanded ? 'open' : 'closed');
        });

        // Add visual feedback
        hamburgerMenu.addEventListener('touchstart', function() {
            this.style.transform = 'scale(0.95)';
        });

        hamburgerMenu.addEventListener('touchend', function() {
            this.style.transform = '';
        });
    } else {
        console.error('Hamburger menu not found!');
    }

    // Close menu when clicking nav links
    const navLinks = document.querySelectorAll('.main-navigation a');
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            if (body.classList.contains('nav-active')) {
                body.classList.remove('nav-active');
                if (hamburgerMenu) {
                    hamburgerMenu.setAttribute('aria-expanded', 'false');
                }
            }
        });
    });

    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
        if (!hamburgerMenu.contains(e.target) && !e.target.closest('.main-navigation')) {
            if (body.classList.contains('nav-active')) {
                body.classList.remove('nav-active');
                if (hamburgerMenu) {
                    hamburgerMenu.setAttribute('aria-expanded', 'false');
                }
            }
        }
    });

    // Scroll-Reveal Animations
    const animatedElements = document.querySelectorAll('.anim-reveal, .anim-slide-left, .anim-slide-right, .anim-fade-in');

    if (animatedElements.length > 0) {
        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1
        });

        animatedElements.forEach(element => {
            observer.observe(element);
        });
    }
});
