<?php
Route::group(['domain' => 'teacher.' . env('DOMAIN')], function () {
    Route::get('/', function () {
        return view('teacher.index')->with('env', app()->environment());
    });
});
