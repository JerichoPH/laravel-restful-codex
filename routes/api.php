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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// article
Route::group(['prefix' => 'article', 'namespace' => 'Api\V1'], function () {
    Route::get('/', 'ArticleController@index')->name('api.article.index');  // article index page
    Route::post('/', 'ArticleController@index')->name('api.article.store');  // article create
    Route::get('/{id}/', 'ArticleController@show')->name('api.article.show');  // article detail page
    Route::get('/{id}/edit/', 'ArticleController@edit')->name('api.article.edit');  // article edit page
    Route::put('/{id}/', 'ArticleController@index')->name('api.article.update');  // article modify
    Route::delete('/{id}/}', 'ArticleController@index')->name('api.article.destroy');  // article delete
});

