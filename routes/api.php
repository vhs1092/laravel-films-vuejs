<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::prefix('auth')->group(function () {
    // Registration Routes...
    Route::post('register', 'RegisterController@register');

    // JWT Routes
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});



Route::group(['middleware' => ['auth:api'], 'namespace' => 'Api'], function () {
    

    Route::get('/films/get_data', 'FilmController@get_data');
    Route::get('/films/comments', 'FilmController@get_film_comments');
    Route::get('/films/genres', 'FilmController@get_genres');
    Route::resource('/films', 'FilmController');
   
   
    Route::resource('/genre', 'GenreController');

    Route::resource('/comments', 'CommentController');

});


