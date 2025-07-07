/** @type {import('tailwindcss').Config} */
export default {
  content: [
     "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        brown: '#806A46',
        'brown-light': '#A18B6D',
        'brown-dark': '#5C4A2B',
      },
    },
  },
  plugins: [],
}

