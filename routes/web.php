<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

Route::post('login', 'AuthController@login');

Route::group(['middleware' => 'api.auth'], function() {
    Route::group(['prefix' => 'analytics'], function () {
        Route::get('counts', 'AnalyticsController@counts');
        Route::get('countries/top', 'AnalyticsController@topCountries');
        Route::get('statistics/monthly', 'AnalyticsController@monthlyStatistics');
    });
    Route::group(['prefix' => 'reportings'], function () {
        Route::get('', 'ReportingController@list');
        Route::get('{id}', 'ReportingController@read');
        Route::delete('{id}', 'ReportingController@delete');
        Route::post('{id}/approve', 'ReportingController@approve');
    });
    Route::group(['prefix' => 'users'], function () {
        Route::get('', 'UserController@list');
        Route::get('search', 'UserController@search');
        Route::get('{id}', 'UserController@read');
        Route::delete('{id}/block', 'UserController@block');
        Route::post('{id}/unblock', 'UserController@unblock');
    });
    Route::group(['prefix' => 'posts'], function () {
        Route::get('', 'PostController@list');
        Route::get('search', 'PostController@search');
        Route::get('{id}', 'PostController@read');
        Route::delete('{id}', 'PostController@delete');
    });
    Route::group(['prefix' => 'comments'], function () {
        Route::get('', 'CommentController@list');
        Route::get('search', 'CommentController@search');
        Route::get('{id}', 'CommentController@read');
        Route::delete('{id}', 'CommentController@delete');
    });
    Route::put('admins/password', 'AdminController@passwordUpdate');
    Route::post('mails/send', 'MailController@send');
    Route::post('socket/auth', 'SocketController@auth');
    Route::get('auth/check', 'AuthController@check');
});