import { fileURLToPath, URL } from "url";
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    resolve:{
        alias:{
            "@": fileURLToPath(new URL("./resources/ts", import.meta.url)),
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/ts/app.ts',
            ],
            refresh: true,
            valetTls: 'ozzie.test',
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
