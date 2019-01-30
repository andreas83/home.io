const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.browserSync({
    proxy: '192.168.0.3',
    ui: {
       port: 8080,
        weinre: {
        port: 9090
    }
}
});

mix.js('resources/js/app.js', 'public/js')
   .js('resources/js/vueapp.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css');
