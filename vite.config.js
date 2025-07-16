import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js'],
            refresh: true,
            // Ensure assets are served from the correct domain
            publicDirectory: 'public',
            buildDirectory: 'build',
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    // Use relative paths or HTTPS for production
    base: process.env.NODE_ENV === 'production' ? 'https://mailerlite-etsy-integration.onrender.com' : '/',
});
