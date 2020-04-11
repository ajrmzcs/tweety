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

    Route::post('/profiles/{user}/follow', 'FollowController@store')->name('follow');

    Route::middleware('can:edit,user')->group(function () {
        Route::get('/profiles/{user}/edit', 'ProfileController@edit');
        Route::patch('/profiles/{user}', 'ProfileController@update');
    });

    Route::get('profiles/{user}', 'ProfileController@show')->name('profile');

    // Invokable controller
    Route::get('/explore', 'ExploreController')->name('explore');
});

Auth::routes();
