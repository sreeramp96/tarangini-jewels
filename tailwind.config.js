import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],
    theme: {
        extend: {
            colors: {
                brand: {
                    dark: '#1B211A',    // The Dark Green/Black (Text & Footer)
                    primary: '#628141', // Olive Green (Buttons/Accents)
                    secondary: '#8BAE66', // Lighter Green
                    gold: '#EBD5AB',    // The Beige/Gold (Highlights)
                    light: '#FDFDFB',   // A clean off-white for the background
                }
            },
            fontFamily: {
                // Tanishq uses serif fonts for elegance.
                // If you haven't loaded a Google Font, we default to standard serifs.
                serif: ['Playfair Display', 'Merriweather', 'serif'],
                sans: ['Figtree', 'sans-serif'],
            },
        },
    },
    plugins: [],
};
