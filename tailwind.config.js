import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: '#0F0004',
                'on-primary': '#FFFFFF',
                'primary-container': '#4F0C2A',
                'on-primary-container': '#F797B6',
                secondary: '#7B535F',
                'on-secondary': '#FFFFFF',
                'secondary-container': '#FFD1DD',
                'on-secondary-container': '#5E3A45',
                background: '#FFF8F8',
                'on-background': '#211A1B',
                surface: '#FFF8F8',
                'on-surface': '#211A1B',
                'surface-variant': '#F5DDE2',
                'on-surface-variant': '#534347',
            },
            boxShadow: {
                'material': '0px 14px 34px 0px rgba(0, 0, 0, 0.08)',
            }
        },
    },
    plugins: [],
};
