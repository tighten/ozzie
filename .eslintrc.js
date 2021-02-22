/* eslint-disable @typescript-eslint/no-var-requires */
const path = require('path');

module.exports = {
    env: {
        browser: true,
        es2021: true,
    },
    parser: 'vue-eslint-parser',
    extends: [
        'airbnb-base',
        'plugin:@typescript-eslint/recommended',
        'plugin:vue/vue3-recommended',
        'plugin:import/errors',
        'plugin:import/warnings',
        'plugin:import/typescript',
    ],
    parserOptions: {
        parser: '@typescript-eslint/parser',
        ecmaVersion: 2020,
        sourceType: 'module',
    },
    rules: {

        // ESLint -----------------------------------------------------------------

        indent: ['error', 4],

        'global-require': 'off',
        'import/no-extraneous-dependencies': 'off',
        'import/extensions': 'off',
        'object-shorthand': 'off',
        'max-len': [
            'error', {
                code: 120,
                ignoreComments: true,
                ignoreTrailingComments: true,
                ignoreUrls: true,
                ignoreStrings: true,
                ignoreTemplateLiterals: false,
                ignoreRegExpLiterals: false,
                ignorePattern: 'class=".+"',
            },
        ],

        // TypeScript -------------------------------------------------------------

        'no-shadow': 'off',
        '@typescript-eslint/no-shadow': 'error',

        'no-unused-vars': 'off',
        '@typescript-eslint/no-unused-vars-experimental': 'error',
        '@typescript-eslint/no-unused-vars': 'off',

        'no-empty-function': 'off',
        '@typescript-eslint/no-empty-function': [
            'error', {
                allow: ['private-constructors'],
            },
        ],

        'no-redeclare': 'off',
        '@typescript-eslint/no-redeclare': 'error',

        // Classes ----------------------------------------------------------------

        'class-methods-use-this': 'off',
        'no-useless-constructor': 'off',
        '@typescript-eslint/no-useless-constructor': 'error',

        'max-classes-per-file': 'warn',
        'lines-between-class-members': 'off',
        'no-underscore-dangle': 'off',

        // Vue 3 ---------------------------------------------------------------

        'vue/no-multiple-template-root': 'off',

        'vue/html-indent': ['error', 4, {
            attribute: 1,
            baseIndent: 1,
            closeBracket: 0,
            alignAttributesVertically: true,
            ignores: [],
        }],

        'vue/html-closing-bracket-newline': ['error', {
            multiline: 'never',
        }],

        'vue/max-len': ['error', {
            code: 120,
            ignoreComments: true,
            ignoreTrailingComments: true,
            ignoreUrls: true,
            ignoreStrings: true,
            ignoreTemplateLiterals: true,
            ignoreRegExpLiterals: true,
            ignoreHTMLAttributeValues: true,
            ignoreHTMLTextContents: false,
        }],
    },

    settings: {
        'import/resolver': {
            webpack: {
                config: path.join(__dirname, 'webpack.config.js'),
            },
        },
    },
};
