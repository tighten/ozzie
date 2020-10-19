module.exports = {
    env: {
        node: true,
        es6: true,
    },
    extends: [
        'eslint:recommended',
        'plugin:vue/recommended',
    ],
    rules: {
        'indent': ['error', 2],
        'quotes': ['warn', 'single'],
        'semi': ['warn', 'always'],
        'comma-dangle': ['warn', {
            'arrays': 'always-multiline',
            'objects': 'always-multiline',
            'imports': 'never',
            'exports': 'never',
            'functions': 'never',
        }],
        'vue/max-attributes-per-line': ['error', {
            'singleline': 1,
            'multiline': {
                'max': 1,
                'allowFirstLine': false,
            },
        }],
        'vue/singleline-html-element-content-newline': ['error', {
            'ignoreWhenNoAttributes': true,
            'ignoreWhenEmpty': true,
            'ignores': ['pre', 'textarea'],
        }],
    },
};
