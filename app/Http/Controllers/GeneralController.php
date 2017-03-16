<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Auth;
use App\LostItem;
use Session;

class GeneralController extends Controller
{
    /**
     * Create a new AdminController instance.
     *
     * @return void
     */
    public function __construct()
    {
        // no middleware is required for this controller (yet)
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function lostitems(Request $request)
    {
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
        $lostItems = LostItem::
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
        ->where('approved', '=', '1')
        ->get();

        // Begin selecting DB entries based off of the criteria

        return view('lostitems', ['lostItems' => $lostItems, 'request', $request]);
    }

    public function viewid($id){
        $itemToView = LostItem::find($id);
        if(!is_null($itemToView) && $itemToView->approved === 1)
        {
            return view('viewitem', ['itemToView' => $itemToView]);
        }
        else
        {
            if(is_null($itemToView)){
                // non malicious requests to items that don't exist should result in being returned back
                abort(403); // return 403 - shouldn't return 404 as we don't want to reveal the IDs of existing items
            }
            else{
                if(1 == 1){
                    // TODO: Check if user has special permission to view item, e.g. they own it, or have requested it
                    dd("You have special permission to view the item");
                }
                else{
                    abort(403); // Malicious request: item is not approved, or has been resolved (and is therefore private!)
                }
            }
        }
    }
}
?>