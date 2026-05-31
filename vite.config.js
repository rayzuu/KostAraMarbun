import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({

    server: {

        host: '0.0.0.0',

        hmr: {
            host: 'localhost',
        },

    },

    plugins: [

        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/landing.css',
                'resources/css/admin.css',
                'resources/css/payment.css',
                'resources/js/app.js',
                'resources/js/admin.js',
                'resources/js/bootstrap.js',
                'resources/js/payment.js',
                'resources/js/room.js',
            ],
            refresh: true,
        }),

    ],

});