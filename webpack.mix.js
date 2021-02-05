const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

mix.js('resources/js/app.js', 'public/js')
  .postCss('resources/css/main.css', 'public/css', [
    tailwindcss('tailwind.js'),
  ])
  .webpackConfig({
    output: {chunkFilename: 'js/[name].js?id=[chunkhash]'},
  })
  .version()
  .sourceMaps()
  .combine(['resources/css/markdown.css'], 'public/css/vendor.css')
  .browserSync('https://ozzie.test');
