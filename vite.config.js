import { defineConfig } from 'vite'
import laravel,{refreshPaths} from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel.default({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: [
                ...refreshPaths,
                'app/Livewire/**',
                'app/Http/Livewire/**',
                'app/Forms/Components/**',
                'app/Tables/Columns/**',
            ],
        }),
    ],
})
