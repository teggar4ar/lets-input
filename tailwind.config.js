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
            colors: {
                tajurhalang: {
                    green: {
                        DEFAULT: '#008751',
                        dark: '#006d41',
                    },
                    yellow: {
                        DEFAULT: '#FFDE00',
                        dark: '#e6c800',
                    },
                },
            },
        },
    },

    plugins: [forms],
};
