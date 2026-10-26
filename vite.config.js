import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        // host: '0.0.0.0', // This allows Vite to be accessible on your network
        // hmr: {
        //     host: 'rana-umair.local', // This tells your phone to look at your laptop for assets
        // },
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});