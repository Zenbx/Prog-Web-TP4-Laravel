import defaultTheme from 'tailwindcss/defaultTheme'
import forms from '@tailwindcss/forms'

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
        primary: '#1A73E8', // 🔵 Couleur principale (boutons, liens, accents)
        secondary: '#F9A825', // 🟡 Couleur d’accent
        background: '#F5F7FA', // 🎨 Fond doux (utilisé dans le layout)
        text: '#333333', // ⚫ Couleur du texte par défaut
      },
      fontFamily: {
        sans: ['Poppins', ...defaultTheme.fontFamily.sans], // 🎯 Police du design Figma
      },
      boxShadow: {
        soft: '0 4px 12px rgba(0,0,0,0.1)', // ☁️ Ombre douce pour les cartes et boutons
      },
      borderRadius: {
        xl: '1rem',
        '2xl': '1.5rem',
      },
    },
  },

  plugins: [forms],
}
