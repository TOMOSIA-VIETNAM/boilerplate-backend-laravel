import defaultTheme from 'tailwindcss/defaultTheme';


const modulePath = `${__dirname}/modules/Admin/resources/`


/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './modules/Admin/resources/**/*.blade.php',
        './modules/Admin/resources/**/*.js',
        './modules/Admin/resources/**/**/*.vue',
        './modules/Candidate/resources/**/*.blade.php',
        './modules/Candidate/resources/**/*.js',
        './modules/Candidate/resources/**/**/*.vue',
        './modules/Company/resources/**/*.blade.php',
        './modules/Company/resources/**/*.js',
        './modules/Company/resources/**/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                'sans-jp': ["Noto Sans JP", "Noto Sans", "sans-serif", ...defaultTheme.fontFamily.sans],
              },
              colors: {
                'brand-secondary': '#0b185c',
                'table-gray': '#f5f6fa'
              },
        },
    },
    plugins: [],
};
