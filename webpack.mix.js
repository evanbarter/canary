const mix = require("laravel-mix");

require("laravel-mix-tailwind");
require('laravel-mix-bundle-analyzer');

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

mix.js("resources/js/app.js", "public/js/app.js")
    .js("resources/js/sort.js", "public/js/sort.js")
    .js("resources/js/night.js", "public/js/night.js")
    .sass("resources/sass/app.scss", "public/css/app.css")
    .tailwind("./tailwind.config.js")
    .sourceMaps();

if (mix.inProduction()) {
    mix.version();
} else {
    mix.bundleAnalyzer();
}
