import Alpine from 'alpinejs';
import Collapse from '@alpinejs/collapse';
import AOS from 'aos';
import Swiper from 'swiper/bundle';
import Swal from 'sweetalert2';

window.Swal = Swal;

// ─── Alpine.js ────────────────────────────────────
Alpine.plugin(Collapse);
window.Alpine = Alpine;
Alpine.start();

// ─── AOS (Animate On Scroll) ───────────────────────
AOS.init({
    duration: 700,
    easing: 'ease-out-cubic',
    once: true,
    offset: 60,
});

// ─── Expose Swiper globally ────────────────────────
window.Swiper = Swiper;


// ─── Back to top ─────────────────────────────────
const backToTop = document.getElementById('back-to-top');
if (backToTop) {
    window.addEventListener('scroll', () => {
        backToTop.classList.toggle('show', window.scrollY > 400);
    }, { passive: true });
}

// ─── Active nav link ──────────────────────────────
const currentPath = window.location.pathname;
document.querySelectorAll('.nav-link').forEach(link => {
    if (link.getAttribute('href') === currentPath) {
        link.classList.add('active');
    }
});

// ─── Custom Cursor ────────────────────────────────
(function () {
    const cursor = document.createElement('div');
    cursor.id = 'custom-cursor';
    document.body.appendChild(cursor);

    let x = 0, y = 0;

    document.addEventListener('mousemove', e => {
        x = e.clientX; y = e.clientY;
        cursor.style.transform = `translate(calc(${x}px - 50%), calc(${y}px - 50%))`;
    });

    document.addEventListener('mousedown', () => cursor.classList.add('cursor-click'));
    document.addEventListener('mouseup',   () => cursor.classList.remove('cursor-click'));

    document.querySelectorAll('a, button, input, textarea, select, [role="button"]').forEach(el => {
        el.addEventListener('mouseenter', () => cursor.classList.add('cursor-hover'));
        el.addEventListener('mouseleave', () => cursor.classList.remove('cursor-hover'));
    });
})();

