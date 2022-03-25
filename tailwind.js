module.exports = {

    mode: 'jit',

    purge: {
        content: [
            './storage/framework/views/*.php',
            './resources/views/**/*.blade.php',
            './resources/ts/**/*.vue',
        ],
    },

    theme: {
        colors: {
            transparent: 'transparent',

            black: '#313131',
            'black-light': '#353744',
            'black-lighter': '#393e43',
            'black-lightest': '#475509',

            'gray-darkest': '#4b5c69',
            'gray-darker': '#606f7b',
            'gray-dark': '#8795a1',
            gray: '#dde1e5',
            'gray-light': '#dae1e7',
            'gray-lighter': '#f1f5f8',
            'gray-lightest': '#f8fafc',

            'gray-blue-darkest': '#4b5f77',
            'gray-blue-darker': '#83909d',
            'gray-blue-dark': '#616f75',

            'gray-blue': '#dce3e7',
            'gray-blue-light': '#e7ebef',

            white: '#ffffff',

            indigo: '#3f50bb',
            'indigo-light': '#4650b6',
            'indigo-muted': '#9396ab',
            'indigo-hover': '#EEF2FF',

            frost: '#f4f5f7',
            smoke: '#e7e8e8',
            clouds: '#d1d7da',

            red: '#DC2626',
            orange: '#F59E0B',
            green: '#16A34A',

            'halloween-orange': '#e4730b',
        },
        extend: {},
    },
    variants: {
        extend: {
            // ...
            borderColor: ['hover'],
        },
    },
    plugins: [],
};
