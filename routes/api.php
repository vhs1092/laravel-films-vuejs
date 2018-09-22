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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['api'], 'namespace' => 'Api'], function () {
    

    Route::get('/films/comments', 'FilmController@get_film_comments');
    Route::get('/films/genres', 'FilmController@get_genres');
    Route::resource('/films', 'FilmController');
   
   
    Route::resource('/genre', 'GenreController');

    Route::resource('/comments', 'CommentController');

});

