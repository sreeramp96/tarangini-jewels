import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Add your custom colors here
                'brand-green': '#01402E',       // Your primary dark green
                'brand-green-dark': '#00261C', // Darker green
                'brand-black': '#000D08',      // Very dark near-black
                'brand-olive': '#B2BF80',      // Muted olive green
                'brand-lime': '#E9F2A2',       // Light lime/yellow accent
                'brand-gold': '#d4af37',       // Keep your existing gold
                'off-white-yellow': '#faefde', // Soft off-white with yellow tint
            },
        },
    },

    plugins: [forms],
};
