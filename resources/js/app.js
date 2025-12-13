// 1. Import Alpine and your components (Your working setup)
import Alpine from 'alpinejs';
import addToCartForm from './components/cart';

// 2. Import Animation Libraries (GSAP + Lenis)
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import Lenis from 'lenis';

// --- ANIMATION SETUP ---

// Register GSAP Plugins
gsap.registerPlugin(ScrollTrigger);

// Initialize Lenis (Smooth Scrolling)
const lenis = new Lenis({
    lerp: 0.1,
    smoothWheel: true,
});

// Sync Lenis with GSAP
lenis.on('scroll', ScrollTrigger.update);

gsap.ticker.add((time) => {
    lenis.raf(time * 1000);
});

gsap.ticker.lagSmoothing(0);

// --- ALPINE SETUP ---

// Make things available globally
window.Alpine = Alpine;
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;

// Register your custom components
Alpine.data('addToCartForm', addToCartForm);

// Start Alpine (Since this works for you, we keep it!)
Alpine.start();
