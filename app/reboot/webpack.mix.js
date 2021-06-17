const mix = require('laravel-mix');

mix.js('resources/js/web.js', 'public/js').vue();
mix.js('resources/js/app.js', 'public/js').vue();
//mix.sass('resources/sass/web.scss', 'public/css');
//mix.sass('resources/sass/app.scss', 'public/css');

mix.options({
    hmrOptions: {
        host: 'localhost',
        port: process.env.MIX_HMR
    },
});
