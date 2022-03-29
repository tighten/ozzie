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

            gray: {
                ...colors.slate,
                '850': '#172033',
            },

            white: '#ffffff',

            indigo: {
                ...colors.indigo,
            },

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
