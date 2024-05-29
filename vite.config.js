import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    base: '/proyectos/2024/juanmaguerrero/tecno/public/build', // Especifica la ruta base para tus assets
    server: {
        port: 8080, // Puerto que deseas utilizar para el servidor de desarrollo
        proxy: {
            '/': {
                target: 'http://localhost/tecno/public/', // Ruta base para el servidor de desarrollo
                changeOrigin: true,
                rewrite: path => path.replace(/^\/public/, ''),
            },
        },
    },
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true,
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
});
