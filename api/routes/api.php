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

Route::resource('posts', PostController::class)->only([
    'store', 'destroy', 'update'
])->middleware('auth:api');

Route::resource('posts', PostController::class)->only([
    'index', 'show'
]);

Route::get('posts/{post}/comments','CommentController@show');
Route::post('posts/{post}/comments','CommentController@store')->middleware('auth:api');
Route::patch('posts/{post}/comments/{id}','CommentController@update')->middleware('auth:api');
Route::delete('posts/{post}/comments/{id}','CommentController@destroy')->middleware('auth:api');

Route::prefix('/')->group( function(){
    Route::post('login','UserController@index');
    Route::post('register','UserController@store');
    Route::post('logout','UserController@destroy');
});
