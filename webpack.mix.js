// webpack.mix.js

const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sourceMaps()
    .options({
        processCssUrls: false
    });

// Отключаем уведомления
mix.disableNotifications();