import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
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
            // *******************************************************
            // ¡IMPORTANTE! Asegúrate de tener estos colores definidos
            // Estos son ejemplos, ajústalos a tus colores exactos si son diferentes
            // *******************************************************
            colors: {
                'chamos-marron-oscuro': '#4A2C2A', // Un marrón oscuro para el fondo de la nav
                'chamos-marron-claro': '#7E5752',  // Un marrón más claro para bordes o detalles
                'chamos-amarillo': '#F5A623',      // Un amarillo brillante para el texto principal
                'chamos-beige': '#F5E6CC',         // Un beige suave para texto secundario
                'chamos-verde': '#4CAF50',         // Un verde vibrante para el botón de añadir (ejemplo)
                // Puedes añadir más colores aquí según tu paleta
            },
            // *******************************************************
        },
    },

    plugins: [forms],
};

