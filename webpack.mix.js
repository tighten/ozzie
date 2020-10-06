const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

mix.js('resources/js/app.js', 'public/js');
mix.copy('resources/css/markdown.css', 'public/css');
mix.postCss('resources/css/main.css', 'public/css', [
    tailwindcss('tailwind.js'),
]);

mix.browserSync('http://ozzie.test:8000');
