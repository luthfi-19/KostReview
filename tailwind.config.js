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
                navy: '#1E3A8A',
                pink: '#EC4899',

                wa: {
                    bg:       '#111B21',
                    darker:   '#0B141A',
                    card:     '#1F2C34',
                    hover:    '#263740',
                    border:   '#2A3942',
                    text:     '#E9EDEF',
                    muted:    '#8696A0',
                    green:    '#00A884',
                    blue:     '#53BDEB',
                    red:      '#EA4B5A',
                    yellow:   '#F5BD33',
                },
            },
            boxShadow: {
                'card': '0 1px 3px rgba(0,0,0,0.3), 0 1px 2px rgba(0,0,0,0.2)',
                'card-hover': '0 4px 12px rgba(0,0,0,0.4)',
            },
        },
    },

    plugins: [forms],
};
