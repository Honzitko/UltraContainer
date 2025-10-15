/**
 * Ultra Container for Elementor - JavaScript
 * Handles advanced interactions and animations
 */

(function($) {
    'use strict';

    // Ultra Container Class
    class UltraContainer {
        constructor() {
            this.init();
            this.bindEvents();
        }

        init() {
            this.containers = document.querySelectorAll('.ultra-container');
            this.setupContainers();
        }

        setupContainers() {
            this.containers.forEach(container => {
                this.setupContainer(container);
            });
        }

        setupContainer(container) {
            // Set up CSS custom properties for dynamic animations
            this.setupCustomProperties(container);
            
            // Set up accessibility features
            this.setupAccessibility(container);
            
            // Set up performance optimizations
            this.setupPerformance(container);
            
            // Set up intersection observer for animations
            this.setupIntersectionObserver(container);
        }

        setupCustomProperties(container) {
            const hoverEnabled = container.getAttribute('data-hover-enabled');
            const animationType = container.getAttribute('data-animation-type');
            
            if (hoverEnabled === 'true') {
                // Set up CSS custom properties for smooth animations
                container.style.setProperty('--ultra-transition-duration', '0.3s');
                
                // Set animation-specific properties
                if (animationType) {
                    switch (animationType) {
                        case 'lift':
                            container.style.setProperty('--ultra-lift-distance', '-10px');
                            break;
                        case 'scale':
                            container.style.setProperty('--ultra-scale-amount', '1.05');
                            break;
                        case 'rotate':
                            container.style.setProperty('--ultra-rotate-amount', '5deg');
                            break;
                        case 'slide':
                            container.style.setProperty('--ultra-slide-distance', '10px');
                            break;
                    }
                }
            }
        }

        setupAccessibility(container) {
            // Add ARIA attributes for button containers
            if (container.classList.contains('ultra-button')) {
                container.setAttribute('role', 'button');
                container.setAttribute('tabindex', '0');
                
                // Add keyboard support
                container.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        container.click();
                    }
                });
            }
        }

        setupPerformance(container) {
            // Optimize for performance
            const hoverEnabled = container.getAttribute('data-hover-enabled');
            
            if (hoverEnabled === 'true') {
                // Add will-change property for better performance
                container.style.willChange = 'transform, box-shadow, background-color, color';
                
                // Remove will-change after animation to prevent memory leaks
                container.addEventListener('transitionend', () => {
                    container.style.willChange = 'auto';
                });
            }
        }

        setupIntersectionObserver(container) {
            // Only set up if animations are enabled
            const hoverEnabled = container.getAttribute('data-hover-enabled');
            if (hoverEnabled !== 'true') return;

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('ultra-in-viewport');
                    } else {
                        entry.target.classList.remove('ultra-in-viewport');
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '50px'
            });

            observer.observe(container);
        }

        bindEvents() {
            // Handle window resize for responsive animations
            window.addEventListener('resize', this.debounce(() => {
                this.handleResize();
            }, 250));

            // Handle reduced motion preference
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                this.disableAnimations();
            }

            // Listen for changes in reduced motion preference
            window.matchMedia('(prefers-reduced-motion: reduce)').addEventListener('change', (e) => {
                if (e.matches) {
                    this.disableAnimations();
                } else {
                    this.enableAnimations();
                }
            });

            // Handle container clicks for button functionality
            document.addEventListener('click', (e) => {
                const container = e.target.closest('.ultra-container.ultra-button');
                if (container) {
                    this.handleContainerClick(container, e);
                }
            });

            // Handle touch events for mobile
            this.setupTouchEvents();
        }

        handleContainerClick(container, event) {
            // Add click animation
            this.addClickAnimation(container);
            
            // Track analytics if needed
            this.trackClick(container);
        }

        addClickAnimation(container) {
            container.classList.add('ultra-clicked');
            
            setTimeout(() => {
                container.classList.remove('ultra-clicked');
            }, 200);
        }

        trackClick(container) {
            // Optional: Add analytics tracking
            if (typeof gtag !== 'undefined') {
                gtag('event', 'click', {
                    'event_category': 'Ultra Container',
                    'event_label': 'Container Click'
                });
            }
        }

        setupTouchEvents() {
            this.containers.forEach(container => {
                let touchStartTime;
                
                container.addEventListener('touchstart', (e) => {
                    touchStartTime = Date.now();
                    container.classList.add('ultra-touch-active');
                }, { passive: true });
                
                container.addEventListener('touchend', (e) => {
                    const touchDuration = Date.now() - touchStartTime;
                    container.classList.remove('ultra-touch-active');
                    
                    // Handle long press
                    if (touchDuration > 500) {
                        container.classList.add('ultra-long-press');
                        setTimeout(() => {
                            container.classList.remove('ultra-long-press');
                        }, 300);
                    }
                }, { passive: true });
                
                container.addEventListener('touchcancel', () => {
                    container.classList.remove('ultra-touch-active', 'ultra-long-press');
                }, { passive: true });
            });
        }

        handleResize() {
            // Recalculate animations for new screen size
            this.containers.forEach(container => {
                this.setupCustomProperties(container);
            });
        }

        disableAnimations() {
            document.body.classList.add('ultra-reduced-motion');
        }

        enableAnimations() {
            document.body.classList.remove('ultra-reduced-motion');
        }

        // Utility function for debouncing
        debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        // Public API methods
        addContainer(container) {
            this.setupContainer(container);
            this.containers = document.querySelectorAll('.ultra-container');
        }

        removeContainer(container) {
            container.classList.remove('ultra-in-viewport', 'ultra-clicked', 'ultra-touch-active', 'ultra-long-press');
        }

        refresh() {
            this.containers = document.querySelectorAll('.ultra-container');
            this.setupContainers();
        }
    }

    // Initialize when DOM is ready
    $(document).ready(function() {
        // Create global instance
        window.ultraContainer = new UltraContainer();
        
        // Handle Elementor frontend rendering
        $(window).on('elementor/frontend/init', function() {
            elementorFrontend.hooks.addAction('frontend/element_ready/ultra-container.default', function($scope) {
                // Re-initialize for dynamically loaded widgets
                window.ultraContainer.refresh();
            });
        });
    });

    // Additional CSS for JavaScript-controlled states
    const additionalCSS = `
        .ultra-container.ultra-clicked {
            transform: scale(0.98);
            transition: transform 0.1s ease-out;
        }
        
        .ultra-container.ultra-touch-active {
            opacity: 0.8;
        }
        
        .ultra-container.ultra-long-press {
            transform: scale(1.02);
            box-shadow: 0 0 20px rgba(0, 124, 186, 0.3);
        }
        
        .ultra-reduced-motion .ultra-container,
        .ultra-reduced-motion .ultra-container * {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
        
        .ultra-reduced-motion .ultra-container:hover {
            transform: none !important;
        }
        
        .ultra-container.ultra-in-viewport {
            opacity: 1;
        }
        
        /* Focus visible for better accessibility */
        .ultra-container.ultra-button:focus-visible {
            outline: 2px solid #007cba;
            outline-offset: 2px;
            box-shadow: 0 0 0 4px rgba(0, 124, 186, 0.2);
        }
    `;

    // Inject additional CSS
    const style = document.createElement('style');
    style.textContent = additionalCSS;
    document.head.appendChild(style);

})(jQuery);
