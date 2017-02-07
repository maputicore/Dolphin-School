<?php

Route::group([
    'domain' => 'teacher.' . env('DOMAIN'),
    'namespace' => 'Teacher',
], function () {
    Route::group(['middleware' => 'auth:teacher'], function () {
        Route::get('/', 'LessonsController@index');
        Route::post('/lesson', 'LessonsController@store');
        Route::get('/lesson/create/', 'LessonsController@create');
        Route::get('/lesson/{id}/', 'LessonsController@show');
        Route::get('/lesson/{id}/edit', 'LessonsController@edit');
        Route::post('/lesson/{id}/update', 'LessonsController@update');

        Route::resource('/students', 'StudentsController');
        // Route::resource('/lessons', 'LessonsController');
        Route::get('/chat', function () {
            return view('student.videochat');
        });
        Route::group(['prefix' => 'settings'], function () {
            Route::get('/profile', 'TeacherController@show');
            Route::post('/profile', 'TeacherController@update');
        });
    });

    Route::group([
        'namespace' => 'Auth'
    ], function() {
        // Authentication Routes...
        Route::get('login', 'LoginController@showLoginForm');
        Route::post('login', 'LoginController@login');
        Route::post('logout', 'LoginController@logout');

        // Password Reset Routes...
        // Route::get('password/reset/{token?}', 'PasswordController@showResetForm');
        // Route::post('password/email', 'PasswordController@sendResetLinkEmail');
        // Route::post('password/reset', 'PasswordController@reset');
    });
});

Route::group([
    'domain' => env('DOMAIN'),
    'namespace' => 'Student',
], function () {
    Route::group(['middleware' => 'auth:student'], function () {
        Route::get('/', 'LessonController@index');
        Route::get('/lesson/{id}/', 'LessonController@show');
        // Route::resource('/students', 'StudentsController');
        // Route::resource('/lessons', 'LessonsController');
        Route::post('/lesson/{id}/register', 'LessonController@register');
        Route::delete('/lesson/{id}/cancel', 'LessonController@cancel');
        Route::get('/chat', function () {
            return view('student.videochat');
        });
        Route::group(['prefix' => 'settings'], function () {
            Route::get('/profile', 'StudentController@show');
            Route::post('/profile', 'StudentController@update');
            Route::get('/password', 'StudentController@showPassword');
            Route::post('/password', 'StudentController@updatePassword');
        });
    });

    Route::group([
        'namespace' => 'Auth'
    ], function() {
        // Authentication Routes...
        Route::get('login', 'LoginController@showLoginForm');
        Route::post('login', 'LoginController@login');
        Route::post('logout', 'LoginController@logout');

        // Registration Routes...
        Route::middleware('guest:student')->group(function () {
            Route::get('register', 'RegisterController@showRegistrationForm');
            Route::post('register', 'RegisterController@register');
        });

        // Password Reset Routes...
        // Route::get('password/reset/{token?}', 'PasswordController@showResetForm');
        // Route::post('password/email', 'PasswordController@sendResetLinkEmail');
        // Route::post('password/reset', 'PasswordController@reset');
    });
});

Route::group([
    'namespace' => 'Student',
], function () {
    Route::group(['middleware' => 'auth:student'], function () {
        Route::get('/', 'LessonController@index');
        Route::get('/lesson/{id}/', 'LessonController@show');
        // Route::resource('/students', 'StudentsController');
        // Route::resource('/lessons', 'LessonsController');
        Route::post('/lesson/{id}/register', 'LessonController@register');
        Route::delete('/lesson/{id}/cancel', 'LessonController@cancel');
        Route::get('/chat', function () {
            return view('student.videochat');
        });
        Route::group(['prefix' => 'settings'], function () {
            Route::get('/profile', 'StudentController@show');
            Route::post('/profile', 'StudentController@update');
            Route::get('/password', 'StudentController@showPassword');
            Route::post('/password', 'StudentController@updatePassword');
        });
    });

    Route::group([
        'namespace' => 'Auth'
    ], function() {
        // Authentication Routes...
        Route::get('login', 'LoginController@showLoginForm');
        Route::post('login', 'LoginController@login');
        Route::post('logout', 'LoginController@logout');

        // Registration Routes...
        Route::middleware('guest:student')->group(function () {
            Route::get('register', 'RegisterController@showRegistrationForm');
            Route::post('register', 'RegisterController@register');
        });

        // Password Reset Routes...
        // Route::get('password/reset/{token?}', 'PasswordController@showResetForm');
        // Route::post('password/email', 'PasswordController@sendResetLinkEmail');
        // Route::post('password/reset', 'PasswordController@reset');
    });
});

Route::get('/test', function () {
    return view('index')->with('env', app()->environment());
});

Route::get('/auth/{service}', 'Common\Auth\SocialController@redirectToProvider');
Route::get('/auth/{service}/callback', 'Common\Auth\SocialController@handleProviderCallback');

// Route::group([
//     'namespace' => 'Teacher',
// ], function () {
//     Route::group(['middleware' => 'auth:teacher'], function () {
//         Route::get('/', 'HomeController@index');
//         Route::resource('/students', 'StudentsController');
//         Route::resource('/lessons', 'LessonsController');
//     });

//     Route::group([
//         'namespace' => 'Auth'
//     ], function() {
//         // Authentication Routes...
//         Route::get('login', 'LoginController@showLoginForm');
//         Route::post('login', 'LoginController@login');
//         Route::post('logout', 'LoginController@logout');

//         // Password Reset Routes...
//         // Route::get('password/reset/{token?}', 'PasswordController@showResetForm');
//         // Route::post('password/email', 'PasswordController@sendResetLinkEmail');
//         // Route::post('password/reset', 'PasswordController@reset');
//     });
// });
