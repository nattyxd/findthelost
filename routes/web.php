<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::group(['middleware' => 'web'], function () {

    Route::get('/', function () {
        return view('index');
    });

    Route::get('/lostitems', 'GeneralController@lostitems');
    Route::get('/view/{id}', 'GeneralController@viewid');

    // Login/home routes
    Auth::routes();
    Route::get('/home', 'HomeController@index');
    Route::get('/add', 'HomeController@add');
    Route::post('/add', 'HomeController@submitadd');

    // Admin routes
    Route::group(['prefix' => 'admin'], function () {
        Route::get('invisibleitems', 'AdminController@approve');
        Route::get('invisibleitems/approve/{id}', 'AdminController@incorrectapproveid');
        Route::post('invisibleitems/approve/{id}', 'AdminController@approveid');
        Route::get('invisibleitems/reject/{id}', 'AdminController@incorrectrejectid');
        Route::post('invisibleitems/reject/{id}', 'AdminController@rejectid');
        Route::get('edit/{id}', 'AdminController@editwithid');
    });

});
