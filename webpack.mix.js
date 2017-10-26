const { mix } = require('laravel-mix');

mix.js('assets/js/main.js', 'assets/js/main.min.js')
    .sass('assets/css/main.scss', 'assets/css/main.min.css');
