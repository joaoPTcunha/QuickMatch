/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
        "./resources/**/*.js",
    ],
    theme: {
        extend: {},
    },
    darkMode: 'class', // Adicionando suporte ao dark mode usando a classe 'dark'
    plugins: [],
};