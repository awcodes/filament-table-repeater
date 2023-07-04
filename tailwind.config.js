const prefix = require('./vendor/filament/filament/tailwind.config.preset')

/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./resources/views/**/*.blade.php", "./src/**/*.php"],
  darkMode: "class",
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
  ],
};
