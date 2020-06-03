<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// List Articles
Route::get('articles','ArticleController@index');

// List Single Article
Route::GET('articles/{id}','ArticleController@show');

// Create New Article
Route::POST('article','ArticleController@store');

// Update Article
Route::PUT('articles','ArticleController@store');

// Delete Article
Route::delete('articles/{id}','ArticleController@destroy');

