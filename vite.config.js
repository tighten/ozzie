import { fileURLToPath, URL } from 'url';
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import dotenv from 'dotenv';
import { basename } from 'path'

export default defineConfig(({ mode }) => {
    // Default valet hostname guess is repo.test, but you can override
    // this by setting the VALET_DOMAIN environment variable in a .env file
    const envConfig = dotenv.config({
        path: './.env' ?? `./.env.${mode}`,
    });

    const envAppUrl = new URL(
        envConfig?.parsed?.APP_URL ??
            `http://${ basename(__dirname)}.test`
    );

    return {
        resolve: {
            alias: {
                '@': fileURLToPath(new URL('./resources/ts', import.meta.url)),
            },
        },
        plugins: [
            laravel({
                input: ['resources/ts/app.ts'],
                refresh: true,
                valetTls: envAppUrl.hostname,
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
    };
});
