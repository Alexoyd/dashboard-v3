import './bootstrap';

// Force le thème sombre partout
document.documentElement.classList.add('dark');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
