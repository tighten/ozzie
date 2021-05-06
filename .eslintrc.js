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

        indent: ['error', 4], // compatibility with .editorconfig

        'import/no-extraneous-dependencies': 'off', // allow packages in devDependencies

        'max-len': [
            'warn', {
                code: 120,
                ignoreComments: true,
                ignoreTrailingComments: true,
                ignoreUrls: true,
                ignoreTemplateLiterals: true,
                ignoreRegExpLiterals: true,
                ignorePattern: '(class|d)=".+',
            },
        ],

        // Vue 3 ---------------------------------------------------------------

        'vue/html-indent': ['warn', 4],
        'vue/html-closing-bracket-newline': ['warn', {
            multiline: 'never',
        }],

        'vue/max-len': ['warn', {
            code: 120,
            ignoreComments: true,
            ignoreTrailingComments: true,
            ignoreUrls: true,
            ignoreTemplateLiterals: true,
            ignoreRegExpLiterals: true,
            ignoreHTMLAttributeValues: true,
            ignoreHTMLTextContents: true,
        }],

        // Plugin Import ---------------------------------------------------------

        'import/no-unresolved': 'error',
        'import/extensions': ['error', 'never', { vue: 'always' }],
    },

    settings: {
        'import/resolver': {
            typescript: {
                alwaysTryTypes: true,
            },
        },
    },
};
