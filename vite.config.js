import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js'],
            refresh: true,
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
    // Use relative paths to avoid hardcoding HTTP/HTTPS
    base: '/',
    // Ensure HTTPS in production
    server: {
        https: process.env.NODE_ENV === 'production',
    },
});
