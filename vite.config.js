import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import fs from 'fs';
import path from 'path';
import tailwindcss from "@tailwindcss/vite";

const themeFilePath = path.resolve(__dirname, 'theme.json');
const activeTheme = fs.existsSync(themeFilePath) ? JSON.parse(fs.readFileSync(themeFilePath, 'utf8')).name : 'anchor';

export default defineConfig({
    plugins: [
        react(),
        tailwindcss(),
        laravel({
            input: [
                `resources/themes/${activeTheme}/assets/css/app.css`,
                `resources/themes/${activeTheme}/assets/js/app.js`,
                'resources/js/app.jsx',
                'resources/css/filament/admin/theme.css',
            ],
            refresh: [
                `resources/themes/${activeTheme}/**/*`,
                'resources/views/**',
                'resources/js/**',
            ],
        }),
    ],
    resolve: {
        alias: {
            '@': '/resources/js',
        },
    },
});
