module.exports = {
    env: {
        browser: true,
        es2021: true,
    },
    extends: [
        'eslint:recommended',
        'plugin:vue/recommended',
        'airbnb-base',
    ],
    parserOptions: {
        ecmaVersion: 12,
        parser: '@typescript-eslint/parser',
        sourceType: 'module',
    },
    plugins: [
        'vue',
        '@typescript-eslint',
    ],
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
            node: {
                extensions: ['.js', '.jsx', '.ts', '.tsx', '.vue'],
            },
        },
    },
};
