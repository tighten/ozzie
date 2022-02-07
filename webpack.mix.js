/* eslint-disable @typescript-eslint/no-var-requires */
const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

mix.ts('resources/ts/app.ts', 'public/js').vue({ version: 3, options: {} })
    .webpackConfig(require('./webpack.config.js'))
    .version()
    .sourceMaps(false)
    .postCss('resources/css/main.css', 'public/css', [
        tailwindcss(),
    ])
    .combine(['resources/css/markdown.css'], 'public/css/vendor.css')
    .browserSync({
        proxy: 'https://ozzie.test/',
        notify: false,
        open: false,
        logLevel: 'info',
        logPrefix: 'Ozzie',
        logFileChanges: true,
    });
