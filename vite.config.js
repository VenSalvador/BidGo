import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
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
    server: {
        proxy: {
          '/api': {
            target: 'https://your-domain.com', // Use a domain name here
            changeOrigin: true,
            secure: true, // Set to true if the target is HTTPS
            rewrite: (path) => path.replace(/^\/api/, ''),
          },
        },
    },
    resolve: {
        alias: {
            '@': '/resources/js',
        },
    },
});
