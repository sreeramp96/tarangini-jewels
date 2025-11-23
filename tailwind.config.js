import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.js",
    ],

    // theme: {
    //     extend: {
    //         fontFamily: {
    //             sans: ["Figtree", ...defaultTheme.fontFamily.sans],
    //         },
    //         colors: {
    //             // Add your custom colors here
    //             'brand-green': '#01402E',       // Your primary dark green
    //             'brand-green-dark': '#00261C', // Darker green
    //             'brand-black': '#000D08',      // Very dark near-black
    //             'brand-olive': '#B2BF80',      // Muted olive green
    //             'brand-lime': '#E9F2A2',       // Light lime/yellow accent
    //             'brand-gold': '#d4af37',       // Keep your existing gold
    //             'off-white-yellow': '#faefde', // Soft off-white with yellow tint
    //         },
    //     },
    // },

    theme: {
        extend: {
            colors: {
                "brand-green": "#01402E",
                "brand-green-dark": "#00261C",
                "brand-black": "#000D08",
                "brand-olive": "#B2BF80",
                "brand-lime": "#E9F2A2",
                "brand-gold": "#d4af37",
            },
            fontFamily: {
                sans: ["Newsreader", ...defaultTheme.fontFamily.serif],
            },
            // 1. Define the Gradient Background
            backgroundImage: {
                "gold-gradient":
                    "linear-gradient(90deg, #d4af37, #f9e6b3, #d4af37)",
            },
            // 2. Define Animation Keyframes
            keyframes: {
                shimmer: {
                    "0%": { backgroundPosition: "0% center" },
                    "100%": { backgroundPosition: "200% center" },
                },
            },
            // 3. Register the Animation
            animation: {
                shimmer: "shimmer 5s linear infinite",
            },
            // 4. Custom Shadows for "Glow" and "Text readability"
            boxShadow: {
                glow: "0 0 25px rgba(212, 175, 55, 0.45)", // Gold glow
            },
            dropShadow: {
                "text-readable": "0 2px 4px rgba(0,0,0,0.5)", // Text shadow
            },
        },
    },

    plugins: [forms],
};
