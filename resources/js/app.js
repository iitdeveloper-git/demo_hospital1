import './bootstrap';
import AOS from 'aos';
import 'aos/dist/aos.css';
import Chart from 'chart.js/auto';
import { gsap } from 'gsap';
import Swiper from 'swiper';
import { Autoplay, Pagination } from 'swiper/modules';

const root = document.documentElement;
const storedTheme = localStorage.getItem('AarogyaCare-theme');
if (storedTheme) root.dataset.theme = storedTheme;

window.addEventListener('load', () => {
    document.querySelector('[data-loader]')?.classList.add('is-hidden');
    AOS.init({ once: true, duration: 650, easing: 'ease-out-cubic' });
    gsap.from('.hero-copy > *', { y: 18, opacity: 0, stagger: 0.08, duration: 0.7, ease: 'power2.out' });
    gsap.from('.home-hero__copy > *', { y: 22, opacity: 0, stagger: 0.09, duration: 0.72, ease: 'power2.out' });
    gsap.to('.medical-float', { y: -12, repeat: -1, yoyo: true, duration: 2.8, ease: 'sine.inOut', stagger: 0.2 });
});

const siteHeader = document.querySelector('[data-site-header]');
window.addEventListener('scroll', () => {
    siteHeader?.classList.toggle('is-scrolled', window.scrollY > 24);
});

const mobileButton = document.querySelector('[data-mobile-menu-button]');
const mobileMenu = document.querySelector('[data-mobile-menu]');
mobileButton?.addEventListener('click', () => {
    const isOpen = mobileMenu?.classList.toggle('is-open') ?? false;
    mobileButton.setAttribute('aria-expanded', String(isOpen));
});

const searchOverlay = document.querySelector('[data-search-overlay]');
document.querySelector('[data-search-toggle]')?.addEventListener('click', () => {
    searchOverlay.hidden = false;
    searchOverlay.querySelector('input')?.focus();
});
document.querySelector('[data-search-close]')?.addEventListener('click', () => {
    searchOverlay.hidden = true;
});
searchOverlay?.addEventListener('click', (event) => {
    if (event.target === searchOverlay) searchOverlay.hidden = true;
});

document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
    button.addEventListener('click', () => {
        root.dataset.theme = root.dataset.theme === 'dark' ? 'light' : 'dark';
        localStorage.setItem('AarogyaCare-theme', root.dataset.theme);
    });
});

const backTop = document.querySelector('[data-back-top]');
window.addEventListener('scroll', () => {
    backTop?.classList.toggle('is-visible', window.scrollY > 500);
});
backTop?.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

const counters = document.querySelectorAll('[data-counter]');
if (counters.length) {
    const counterObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;
            counters.forEach((counter) => {
                const target = Number(counter.dataset.counter);
                const suffix = counter.dataset.suffix ?? '';
                const state = { value: 0 };
                gsap.to(state, {
                    value: target,
                    duration: 1.5,
                    ease: 'power2.out',
                    onUpdate: () => {
                        counter.textContent = `${Math.round(state.value).toLocaleString()}${suffix}`;
                    },
                });
            });
            observer.disconnect();
        });
    }, { threshold: 0.35 });
    const section = document.querySelector('[data-counter-section]');
    if (section) counterObserver.observe(section);
}

if (document.querySelector('.testimonial-swiper')) {
    new Swiper('.testimonial-swiper', {
        modules: [Autoplay, Pagination],
        slidesPerView: 1,
        spaceBetween: 18,
        loop: true,
        autoplay: { delay: 3200, disableOnInteraction: false },
        pagination: { el: '.swiper-pagination', clickable: true },
        breakpoints: {
            720: { slidesPerView: 2 },
            1120: { slidesPerView: 3 },
        },
    });
}

document.querySelectorAll('[data-validate-form]').forEach((form) => {
    form.addEventListener('submit', (event) => {
        if (!form.checkValidity()) {
            event.preventDefault();
            form.reportValidity();
        }
    });
});

const chartCanvas = document.getElementById('flowChart');
if (chartCanvas) {
    const chartData = JSON.parse(chartCanvas.dataset.chart);
    new Chart(chartCanvas, {
        type: 'line',
        data: {
            labels: chartData.labels,
            datasets: [
                { label: 'Admissions', data: chartData.admissions, borderColor: '#0F6FFF', backgroundColor: 'rgba(15,111,255,.12)', tension: .42, fill: true },
                { label: 'Discharges', data: chartData.discharges, borderColor: '#14B8A6', backgroundColor: 'rgba(20,184,166,.1)', tension: .42, fill: true },
            ],
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } },
            scales: { y: { beginAtZero: true } },
        },
    });
}

const table = document.querySelector('[data-smart-table]');
const search = document.querySelector('[data-table-search]');
let page = 0;
const pageSize = 8;

function renderTable() {
    if (!table) return;
    const query = search?.value.toLowerCase() ?? '';
    const rows = [...table.querySelectorAll('tbody tr')];
    const filtered = rows.filter((row) => row.textContent.toLowerCase().includes(query));
    rows.forEach((row) => { row.hidden = true; });
    filtered.slice(page * pageSize, page * pageSize + pageSize).forEach((row) => { row.hidden = false; });
}

search?.addEventListener('input', () => { page = 0; renderTable(); });
document.querySelector('[data-next-page]')?.addEventListener('click', () => { page += 1; renderTable(); });
document.querySelector('[data-prev-page]')?.addEventListener('click', () => { page = Math.max(0, page - 1); renderTable(); });
renderTable();

document.querySelector('[data-export-table]')?.addEventListener('click', () => {
    if (!table) return;
    const rows = [...table.querySelectorAll('tr')].map((row) => [...row.children].map((cell) => `"${cell.textContent.trim()}"`).join(','));
    const blob = new Blob([rows.join('\n')], { type: 'text/csv' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'AarogyaCare-operational-queue.csv';
    link.click();
    URL.revokeObjectURL(link.href);
});

const faqSearch = document.querySelector('[data-faq-search]');
faqSearch?.addEventListener('input', () => {
    const query = faqSearch.value.toLowerCase();
    document.querySelectorAll('[data-faq-item]').forEach((item) => {
        item.hidden = !item.textContent.toLowerCase().includes(query);
    });
});

document.querySelector('[data-newsletter-form]')?.addEventListener('submit', (event) => {
    event.preventDefault();
    const toast = document.createElement('div');
    toast.className = 'toast is-visible';
    toast.setAttribute('role', 'status');
    toast.textContent = 'Subscription received. Health updates will arrive in your inbox.';
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3200);
    event.currentTarget.reset();
});

const lightbox = document.querySelector('[data-gallery-lightbox]');
const lightboxImage = lightbox?.querySelector('img');
document.querySelectorAll('[data-gallery-image]').forEach((button) => {
    button.addEventListener('click', () => {
        if (!lightbox || !lightboxImage) return;
        lightboxImage.src = button.dataset.galleryImage;
        lightbox.hidden = false;
    });
});
document.querySelector('[data-gallery-close]')?.addEventListener('click', () => {
    lightbox.hidden = true;
});
lightbox?.addEventListener('click', (event) => {
    if (event.target === lightbox) lightbox.hidden = true;
});
