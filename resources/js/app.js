import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
window.addEventListener('scroll', function(){

    const navbar = document.querySelector('.navbar-custom');

    if(window.scrollY > 50){

        navbar.classList.add('navbar-scrolled');

    }else{

        navbar.classList.remove('navbar-scrolled');

    }

});