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

Route::group(['middleware' => 'web'], function () {
    Route::get('/', function () {
        if (Auth::check())
            return redirect('/dashboard'); 
        else
            return view('auth.login');
    });

    Route::get('/dashboard', 'MainController@index');
    
    Route::post('/account/select/{account}', 'MainController@select');
    Route::post('/account/add', 'MainController@add');
    Route::post('/account/remove/{account}', 'MainController@remove');
    
    Route::auth();
});