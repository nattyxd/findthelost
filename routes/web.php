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

    Route::get('/lostitems', function(Request $request){

        // Determine the order of the items
        if ($request->has('order')) {
            if($request->input('order') == "newest"){
                // sort newest to oldest
                $order = "desc";
            }
            else if($request->input('order') == "oldest"){
                // sort oldest to newest
                $order = "asc";
            }
            else{
                //unknown value, sort newest to oldest
                $order = "desc";
            }
        }
        else{
            $order = "desc";
        }
        
        // Determine the categories to display
        if($request->has('category')){
            if (in_array($request->input('category'), array('pets','electronics', 'jewellery'), true )) {
                $category = $request->input('category');
            }
            else{
                $category = "all";
            }
        }
        else{
                $category = "all";
            }

        // Determine the city to lookup
        if($request->has('city')){
            if($request->input('city') == "all"){

            }
            $city = $request->input('city');
        }
        else{
            $city = "all";
        }
        
        // Determine whether to show lost/found items, or both
        if($request->has('lostorfound')){
            if(in_array($request->input('lostorfound'), array('0', '1'), true)){
                $lostorfound = $request->input('lostorfound');
            }
            else{
                $lostorfound = "all";
            }
        }
        else{
            $lostorfound = "all";
        }
        $lostItems = App\LostItem::
        when($city !== "all", function($q) use ($city) {
            return $q->where('city', '=', $city);
        })
        ->when($lostorfound !== "all", function ($q) use ($lostorfound) {
            return $q->where('lostitem', '=', $lostorfound);
        })
        ->when($category !== "all", function($q) use ($category) {
            return $q->where('category', '=', $category);
        })

        ->orderBy('created_at', $order)
        ->get();

        // Begin selecting DB entries based off of the criteria

        return view('lostitems', ['lostItems' => $lostItems, 'request', $request]);
    });

    // Login/home routes
    Auth::routes();
    Route::get('/home', 'HomeController@index');
    Route::get('/add', 'HomeController@add');
    Route::post('/add', 'HomeController@submitadd');

    // Admin routes
    Route::get('/approveitems', 'AdminController@approve');

});
