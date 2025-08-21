const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            // Añadimos la sección de colores personalizados
            colors: {
                // Colores para la marca "Los Chamos"
                'chamos-amarillo': '#E1A900',
                'chamos-marron-oscuro': '#452100',
                'chamos-beige': '#EDE6D4',
                'chamos-marron-claro': '#a85b30',
                // Colores para el fondo
                'fondo-bienvenida': '#6D321F',
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
