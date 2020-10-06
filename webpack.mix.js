const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

mix.js('resources/js/app.js', 'public/js');
mix.postCss('resources/css/main.css', 'public/css', [
    tailwindcss('tailwind.js'),
]);
mix.combine(['resources/css/markdown.css'], 'public/css/vendor.css');
mix.browserSync('http://ozzie.test:8000');
