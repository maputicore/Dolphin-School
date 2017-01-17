const elixir = require('laravel-elixir');
// var browserify = require('laravel-elixir-browserify-official');
elixir(mix => {
    mix.sass('app.scss')
       .webpack('teacher/index.jsx', 'public/js/teacher.js');
});
