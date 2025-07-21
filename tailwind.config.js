// tailwind.config.js
export default {
  content: ["./resources/**/*.blade.php", "./resources/**/*.js", "./resources/**/*.vue"],
  theme: {
    extend: {
      colors: {
        brown: {
          500: '#8B4513',
        },
        beige: {
          500: '#F5F5DC',
        },
      },
      fontFamily: {
        anton: ['Anton', 'sans-serif'],
        poppins: ['Poppins', 'sans-serif'],
      },
    },
  },
  plugins: [],
}