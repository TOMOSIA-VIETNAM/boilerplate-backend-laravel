import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
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
