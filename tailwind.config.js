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
            colors: {
                ink: '#1B2430',
                parchment: '#F7F5F0',
                brass: '#C89B5C',
                coral: '#E8542E',
                sage: '#4A7C6F',
                stone: '#8A8378',
            },
            fontFamily: {
                sans: ['Public Sans', ...defaultTheme.fontFamily.sans],
                display: ['Fraunces', ...defaultTheme.fontFamily.serif],
                script: ['Zapfino', 'Tangerine', 'cursive'],
            },
        },
    },

    plugins: [forms],
};
