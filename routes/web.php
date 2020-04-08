<?php

//use Illuminate\Support\Facades\DB;
//
//DB::listen(function($query) { var_dump($query->sql, $query->bindings); });

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function() {
    Route::get('/tweets', 'TweetController@index')->name('home');
    Route::post('/tweets', 'TweetController@store');
});

Route::get('profiles/{user}', 'ProfileController@show')->name('profile');

Auth::routes();
