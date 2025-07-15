/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            colors: {
                'mailerlite-green': '#58BE72',
                'mailerlite-section': '#D6F2E3',
                'mailerlite-bg': '#FFFFFF',
                'mailerlite-text': '#000000',
            },
        },
    },
    plugins: [],
}
