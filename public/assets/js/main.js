/**
 * ADONIS CHEMICAL LIMITED - MAIN SCRIPTS
 */

document.addEventListener('DOMContentLoaded', () => {
    // 1. Header scroll effect
    const header = document.getElementById('main-site-header');
    if (header) {
        const updateHeader = () => {
            if (window.scrollY > 40) {
                header.classList.add('header-scrolled');
                header.classList.remove('header-transparent');
            } else {
                if (header.dataset.transparent === 'true') {
                    header.classList.remove('header-scrolled');
                    header.classList.add('header-transparent');
                }
            }
        };
        window.addEventListener('scroll', updateHeader);
        updateHeader();
    }

    // 2. Mobile Menu Drawer Toggle
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenuDrawer = document.getElementById('mobile-menu-drawer');
    const mobileMenuClose = document.getElementById('mobile-menu-close');
    const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');

    if (mobileMenuBtn && mobileMenuDrawer) {
        const openMenu = () => {
            mobileMenuDrawer.classList.remove('translate-x-full');
            if (mobileMenuOverlay) mobileMenuOverlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        };

        const closeMenu = () => {
            mobileMenuDrawer.classList.add('translate-x-full');
            if (mobileMenuOverlay) mobileMenuOverlay.classList.add('hidden');
            document.body.style.overflow = '';
        };

        mobileMenuBtn.addEventListener('click', openMenu);
        if (mobileMenuClose) mobileMenuClose.addEventListener('click', closeMenu);
        if (mobileMenuOverlay) mobileMenuOverlay.addEventListener('click', closeMenu);
    }

    // 3. Animated Counter Numbers using IntersectionObserver
    const counters = document.querySelectorAll('.counter-value');
    if (counters.length > 0) {
        const counterObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const target = parseInt(el.getAttribute('data-target') || el.innerText.replace(/\D/g, ''), 10);
                    if (!isNaN(target)) {
                        let current = 0;
                        const duration = 1800; // ms
                        const stepTime = 20;
                        const steps = duration / stepTime;
                        const increment = target / steps;

                        const timer = setInterval(() => {
                            current += increment;
                            if (current >= target) {
                                current = target;
                                clearInterval(timer);
                            }
                            el.innerText = Math.floor(current).toLocaleString();
                        }, stepTime);
                    }
                    observer.unobserve(el);
                }
            });
        }, { threshold: 0.2 });

        counters.forEach(counter => counterObserver.observe(counter));
    }

    // 4. Toast Notification Auto-dismiss
    const toastAlerts = document.querySelectorAll('.toast-alert');
    toastAlerts.forEach(toast => {
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(-10px)';
            setTimeout(() => toast.remove(), 400);
        }, 6000);
    });
});

// Global modal helper for product inquiries
window.openInquiryModal = function(productId = '', productName = '') {
    const modal = document.getElementById('product-inquiry-modal');
    if (!modal) return;

    const idInput = modal.querySelector('input[name="product_id"]');
    const nameInput = modal.querySelector('input[name="product_name"]');
    const displayTitle = document.getElementById('inquiry-modal-product-title');

    if (idInput) idInput.value = productId;
    if (nameInput) nameInput.value = productName;
    if (displayTitle) {
        displayTitle.innerText = productName ? `Inquiry for: ${productName}` : 'Product Information Inquiry';
    }

    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
};

window.closeInquiryModal = function() {
    const modal = document.getElementById('product-inquiry-modal');
    if (!modal) return;
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
};
