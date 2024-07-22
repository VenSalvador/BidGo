import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';

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
                secure: false, // Set to true if the target is HTTPS
                rewrite: (path) => path.replace(/^\/api/, ''),
            },
        },
    },
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
            ziggy: path.resolve(__dirname, 'vendor/tightenco/ziggy/src/js/route.js'),
        },
    },
    build: {
        rollupOptions: {
            // Customize Rollup options if needed
        },
        assetsInclude: ['**/*.svg', '**/*.png'] // Include additional asset types if needed
    }
});
