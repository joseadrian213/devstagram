/** @type {import('tailwindcss').Config} */
//Tailwind tan solo agregar clases de tailwind en donde se lo indicas 
export default {
  
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php"
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}

