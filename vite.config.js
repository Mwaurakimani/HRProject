import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    resolve:{
        alias:{
            '@': '/resources/js',
            '@PortalComponent': '/resources/js/Pages/Portal/Components',
            '@Components': '/resources/js/Components',
        },
        extensions: ['.js', '.vue', '.json', '.css', '.scss', '.sass']
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
    server: {
        watch: {
            usePolling: false
        },
    },

});
