const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: 'class', // Aseguramos que el modo oscuro esté activado

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                'brand-orange': '#FF8C00', // Nuestro naranja principal
                'brand-orange-darker': '#E26310', // Nuestro naranja para hover
                'dark-bg': '#121212', // Nuestro fondo oscuro
                'dark-card': '#1A1A1A', // Nuestro fondo para tarjetas
            },
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};