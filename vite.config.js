import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'modules/Admin/resources/assets/scss/app.scss',
                'modules/Admin/resources/assets/js/app.js',
            ],

            refresh: true,
        }),
        vue(),
    ],
});
