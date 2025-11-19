const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss'); // Añadimos esto

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        tailwindcss('./tailwind.config.js'), // Apunta a nuestro config
    ]);