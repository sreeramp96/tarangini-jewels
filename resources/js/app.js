// 1. Import Alpine and your components (Your working setup)
import Alpine from 'alpinejs';
import addToCartForm from './components/cart';
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import Lenis from 'lenis';

gsap.registerPlugin(ScrollTrigger);

const lenis = new Lenis({
    lerp: 0.1,
    smoothWheel: true,
    autoRaf: true
});

lenis.on('scroll', ScrollTrigger.update);

gsap.ticker.add((time) => {
    lenis.raf(time * 1000);
});

gsap.ticker.lagSmoothing(0);

window.Alpine = Alpine;
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;

Alpine.data('addToCartForm', addToCartForm);

Alpine.start();
