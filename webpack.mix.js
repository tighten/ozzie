const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

mix.postCss('resources/css/main.css', 'public/css', [
    tailwindcss('tailwind.js'),
]).browserSync('https://ozzie.test');
