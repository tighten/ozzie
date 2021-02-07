const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

// mix.js('resources/js/app.js', 'public/js').vue({ version: 3 });
mix.ts('resources/ts/app.ts', 'public/js').vue({ version: 3, options: {} });
mix.webpackConfig({
  output: {
    chunkFilename: 'js/[name].js?id=[chunkhash]',
  },
});

mix.postCss('resources/css/main.css', 'public/css', [
  tailwindcss('tailwind.js'),
]);
mix.combine(['resources/css/markdown.css'], 'public/css/vendor.css');
mix.browserSync('http://127.0.0.1:8000');
