import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            output: 'public/build', // Asegúrate de que la salida sea correcta
            refresh: true,
        }),
    ],
});
