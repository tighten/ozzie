let mix = require('laravel-mix');
let tailwindcss = require('tailwindcss');

mix.postCss('resources/css/main.css', 'public/css', [
        tailwindcss('tailwind.js'),
   ]);
