const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');
const webpack = require('webpack');

mix.ts('resources/ts/app.ts', 'public/js').vue({ version: 3, options: {} });
mix.webpackConfig({
    output: {
        chunkFilename: 'js/[name].js?id=[chunkhash]',
    },
    plugins: [
        new webpack.DefinePlugin(
            {
                __VUE_OPTIONS_API__: true,
                __VUE_PROD_DEVTOOLS__: false,
            },
        ),
    ],
});
mix.version();
mix.sourceMaps();
mix.postCss('resources/css/main.css', 'public/css', [
    tailwindcss('tailwind.js'),
]);
mix.combine(['resources/css/markdown.css'], 'public/css/vendor.css');
mix.browserSync('http://127.0.0.1:8000');
