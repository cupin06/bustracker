<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/gps/store', ['uses' => 'GpsController@store', 'as' => 'gps.store']);
Route::get('/gps/', ['uses' => 'GpsController@index', 'as' => 'gps.index']);
Route::get('/gps/last', ['uses' => 'GpsController@getLastData', 'as' => 'gps.last']);
Route::get('/gps/polling', ['uses' => 'GpsController@polingGPSData', 'as' => 'gps.polling']);
