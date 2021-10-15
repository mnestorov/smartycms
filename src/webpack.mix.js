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
mix.setPublicPath('resources/assets/dist');

mix.autoload({
	jquery: ['$', 'window.jQuery', 'jQuery']
});

mix.copyDirectory('resources/assets/src/images', 'resources/assets/dist/images');

mix.less('resources/assets/src/less/admin.less', '../dist/css/admin.css')
	.less('resources/assets/src/less/login.less', '../dist/css/login.css')
	.options({
		processCssUrls: false
	});

mix.js([
	'resources/assets/src/js/admin.js',
	'resources/assets/src/js/global.js',
], 'resources/assets/dist/js/admin.js');