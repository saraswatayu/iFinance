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
            return redirect('/dashboard?sort=time&dir=desc'); 
        else
            return view('auth.login');
    });
    
    Route::get('/logout', function() {
        Auth::logout();
        return redirect('/');
    });

    Route::get('/dashboard', 'MainController@index');
    Route::get('/dates/{startDate}/{days}', 'MainController@setDates');
    
    Route::post('/account/select/{account}', 'MainController@selectAccount');
    Route::post('/account/add', 'MainController@addAccount');
    Route::post('/account/remove/{account}', 'MainController@removeAccount');
    
    Route::post('/history/{category}', 'MainController@showHistory');
    
    Route::post('/budget/add', 'MainController@addBudget');
    Route::post('/budget/remove/{budget}', 'MainController@removeBudget');
    
    Route::auth();
});