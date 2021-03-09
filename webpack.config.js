/* eslint-disable @typescript-eslint/no-var-requires */
const path = require('path');
const webpack = require('webpack');

module.exports = {
    resolve: {
        roots: ['.'],
        alias: {
            '@': path.resolve('resources/ts'),
        },
    },
    output: { chunkFilename: 'js/[name].js?id=[chunkhash]' },
    plugins: [
        new webpack.DefinePlugin({
            __VUE_OPTIONS_API__: true,
            __VUE_PROD_DEVTOOLS__: false,
        }),
    ],
};
