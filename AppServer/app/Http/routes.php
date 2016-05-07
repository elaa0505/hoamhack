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

Route::get('simulate', [
    'uses' => 'SimulateController@index', 
    'as' => 'simulate.index'] );

Route::get('simulate/{event}', [
    'uses' => 'SimulateController@trigger', 
    'as' => 'simulate.trigger'] );


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

    Route::get('config/get/{var}', [
        'uses' => 'APIConfigController@show', 
        'as' => 'api.config.show'] );

    Route::get('config/set/{var}', [
        'uses' => 'APIConfigController@storeOrUpdate', 
        'as' => 'api.config.storeOrUpdate'] );

});
