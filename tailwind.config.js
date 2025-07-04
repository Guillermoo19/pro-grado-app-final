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
                        sans: ['Figtree', 'sans-serif'],
                    },
                    colors: {
                        // Colores de Chamos Burguer
                        'chamos-marron-oscuro': '#4A2C2A', // Un marrón oscuro para fondos o texto principal
                        'chamos-marron-claro': '#7B5B5B', // Un marrón más claro para detalles o bordes
                        'chamos-amarillo': '#FFD700',      // Amarillo dorado para acentos, botones, texto resaltado
                        'chamos-beige': '#F5F5DC',         // Un beige suave para fondos claros o texto secundario
                        'chamos-rojo': '#DC143C',          // Rojo para errores o alertas
                    },
                },
            },

            plugins: [require('@tailwindcss/forms')],
        };
        