'use strict';

const backToTop = document.getElementById('backToTop');
if (backToTop) {
    const updateBackToTop = () => backToTop.classList.toggle('show', window.scrollY > 400);
    window.addEventListener('scroll', updateBackToTop, { passive: true });
    updateBackToTop();
    backToTop.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
}

const nav = document.getElementById('mainNav');
if (nav && window.bootstrap) {
    nav.querySelectorAll('a.nav-link').forEach((link) => {
        link.addEventListener('click', () => {
            if (window.innerWidth < 992) {
                bootstrap.Collapse.getOrCreateInstance(nav, { toggle: false }).hide();
            }
        });
    });
}

document.querySelectorAll('input[type="date"]').forEach((input) => {
    if (!input.min) {
        const today = new Date();
        input.min = `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}`;
    }
});
