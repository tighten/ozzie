const colors = require('tailwindcss/colors')

module.exports = {

    content: [
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/ts/**/*.vue',
    ],

    theme: {
        colors: {
            transparent: 'transparent',
            current: 'currentColor',

            black: '#313131',
            'black-light': '#353744',
            'black-lighter': '#393e43',
            'black-lightest': '#475509',

            gray: {
                ...colors.slate,
                '850': '#172033',
                'darkest': '#4b5c69',
                'darker': '#606f7b',
                'dark': '#8795a1',
                DEFAULT: '#dde1e5',
                'light': '#dae1e7',
                'lighter': '#f1f5f8',
                'lightest': '#f8fafc',
            },

            'gray-blue': {
                'darkest': '#4b5f77',
                'darker': '#83909d',
                'dark': '#616f75',
                DEFAULT: '#dce3e7',
                'light': '#e7ebef',
            },

            white: '#ffffff',

            indigo: {
                ...colors.indigo,
                600: '#3f50bb',
                'light': '#4650b6',
                'muted': '#9396ab',
                50: '#EEF2FF',
            },

            frost: '#f4f5f7',
            smoke: '#e7e8e8',
            clouds: '#d1d7da',

            red: '#DC2626',
            orange: '#F59E0B',
            green: '#16A34A',

            'halloween-orange': '#e4730b',
        },
    },

    plugins: [
        require('@tailwindcss/typography'),
    ],
};
