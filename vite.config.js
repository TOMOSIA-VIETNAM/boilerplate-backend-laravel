import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';

const env = loadEnv(process.env.NODE_ENV, process.cwd(), '');

export default defineConfig({
    server: {
        proxy: {
            '/assets': {
                target: env.APP_URL || 'http://localhost:8000',
                changeOrigin: true,
                secure: false,
            },
        },
    },
    plugins: [
        laravel({
            input: [
                // Admin modules
                'modules/Admin/resources/assets/css/app.css',
                'modules/Admin/resources/assets/js/app.js',
            ],
            refresh: [
                'modules/Admin/resources/**',
            ],
        }),
    ],
    resolve: {
        alias: {
            '$': 'jQuery'
        },
    },
});
