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


Route::get('clock', [
    'uses' => 'ClockController@index', 
    'as' => 'clock.index'] );


Route::group( ['prefix' => 'slack'], function()
{
    Route::get('', [
        'uses' => 'SlackController@index', 
        'as' => 'slack.index'] );

    Route::get('send', [
        'uses' => 'SlackController@send', 
        'as' => 'slack.send'] );
});


Route::group( ['prefix' => 'api'], function()
{
    Route::get('config', [
        'uses' => 'APIConfigController@index', 
        'as' => 'api.config.index'] );
});
