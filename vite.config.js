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
    css: {
        preprocessorOptions: {
          css: {
            // Add any CSS preprocessor options here if needed
          }
        }
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
            input: {
                main: path.resolve(__dirname, 'resources/js/app.js'),
            },
        },
        assetsInclude: ['**/*.svg', '**/*.png'] // Include additional asset types if needed
    }
});
