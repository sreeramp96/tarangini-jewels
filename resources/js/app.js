import './bootstrap';

import Alpine from 'alpinejs';
import addToCartForm from './components/cart';

window.Alpine = Alpine;

Alpine.data('addToCartForm', addToCartForm);

Alpine.start();
