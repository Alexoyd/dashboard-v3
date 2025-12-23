import fs from 'fs';
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        port: 3306,
        host: 'localhost',
    	https: {
            key: fs.readFileSync('/home/alexquest/ssl.key'),
            cert: fs.readFileSync('/home/alexquest/ssl.cert'),
        }
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
