var elixir = require('laravel-elixir'),
  Task = elixir.Task,
  gulp = require('gulp'),
  shell = require('gulp-shell');
require('laravel-elixir-vueify');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir.extend("laroute", function() {
  new Task('laroute', function() {
      return gulp.src('').pipe(shell("php artisan laroute:generate"));
    })
    .watch('./app/Http/routes.php');
});

elixir(function(mix) {
  mix.laroute();
  mix.sass('app.scss');

  mix.browserify('app.js');

  mix.version([
    'css/app.css',
    'js/app.js'
  ]);
});
