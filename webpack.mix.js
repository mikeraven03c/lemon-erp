const mix = require('laravel-mix');
const {readFile, writeFile, promises: fsPromises} = require('fs');

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

// mix.js('resources/js/app.js', 'public/js')
//     .vue()
//     .sass('resources/sass/app.scss', 'public/css');

mix
.sass('resources/sass/app.scss', 'public/css')
.copy('ui/dist/spa/index.html', 'resources/views/app.blade.php')
.copyDirectory('ui/dist/spa', 'public').after(webpackStats=> {
  console.log('reading files')
  readFile('resources/views/app.blade.php', 'utf-8', function (err, contents) {
    if (err) {
      console.log(err);
      return;
    }

    const csrfFile = '<head><meta name="csrf-token" content="{{ csrf_token() }}">'
    const replaced = contents.replace(/<head>/g,  csrfFile);

    writeFile('resources/views/app.blade.php', replaced, 'utf-8', function (err) {
      console.log(err);
    });
  });
});
