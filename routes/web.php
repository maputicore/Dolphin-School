<?php
Route::group(['domain' => 'teacher.' . env('DOMAIN')], function () {
    Route::get('/', function () {
        return view('teacher.index')->with('env', app()->environment());
    });
});

Route::group(['namespace' => 'Teacher', 'prefix' => 'admin'], function () {
    Route::get('/', 'SessionsController@index');
});
