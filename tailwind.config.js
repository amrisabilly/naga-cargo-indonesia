/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
            fontFamily: {
                plusJakartaSans: ["Plus Jakarta Sans", "sans-serif"],
            },
            colors: {
                primary: "#3986a3",
                "blue-transparent": "rgba(16, 102, 129, 0.2)", 
            },
        },
  },
  plugins: [],
}