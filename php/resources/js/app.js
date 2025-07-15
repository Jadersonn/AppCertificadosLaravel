import './bootstrap';
import 'bootstrap';


import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import mask from '@alpinejs/mask'
 
Alpine.plugin(mask)

import './modalTurmas.js';
