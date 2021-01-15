module.exports = {

  future: {
    removeDeprecatedGapUtilities: true,
    purgeLayersByDefault: true,
  },

  purge: {
    content: [
      './storage/framework/views/*.php',
      './resources/views/**/*.blade.php',
      './resources/js/**/*.vue',
    ]
  },

  theme: {
    colors:{
      'transparent': 'transparent',

      'black': '#313131',
      'black-light': '#353744',
      'black-lighter': '#393e43',
      'black-lightest': '#475509',

      'grey-darkest': '#4b5c69',
      'grey-darker': '#606f7b',
      'grey-dark': '#8795a1',
      'grey': '#dde1e5',
      'grey-light': '#dae1e7',
      'grey-lighter': '#f1f5f8',
      'grey-lightest': '#f8fafc',

      'grey-blue-darkest': '#4b5f77',
      'grey-blue-darker': '#83909d',
      'grey-blue-dark': '#616f75',
      'grey-blue': '#dce3e7',
      'grey-blue-light': '#e7ebef',

      'white': '#ffffff',

      'indigo': '#3f50bb',
      'indigo-light': '#4650b6',
      'indigo-muted': '#9396ab',

      'frost': '#f4f5f7',
      'smoke': '#e7e8e8',
      'clouds': '#d1d7da',

      'halloween-orange': '#e4730b',
    },
    extend: {},
  },
  variants: {},
  plugins: [],
};
