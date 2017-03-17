<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Auth;
use App\LostItem;
use App\ItemRequest;
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

    /*
     *  viewid - Decides whether or not a user has the rights to view details regarding a lost item, and if they do
     *           have rights, it will determine which requests should be made visible to the user, and return a view
     *           with the appropriate requests
     *
     *  @param  integer $id The ID of the item that the user desires to view
     *  @return View, array($request) returns the view item /403 page, with an array of requests as an optional parameter
     */
    public function viewid($id){
        $itemToView = LostItem::find($id); // Select the item's model
        $userRequestsForItem = ItemRequest::where('user_id', '=', Auth::user()->id)->where('lost_item_id', '=', $itemToView->id);

        if(is_null($itemToView)){
            // Return 403 to prevent item ID bruteforces/prevent null pointers
            abort(403);
        }

        // Item exists - run checks to see which requests should be returned
        if(!is_null(Auth::user())){
            // Certain users may have special permissions to view the page, regardless of publicity
            if(Auth::user()->userlevel == 1){
                // admins get special permission, return with all requests for the item shown
                dd("You have admin rights");
            }
            elseif($itemToView->user_id == Auth::user()->id){
                // the user attempting to view is the owner, they can view requests but NOT accept/reject them
                dd("You are the owner of this item");
            }
            elseif($userRequestsForItem->count() > 0){
                // User has special permission to view because they have made a request for the item
                dd("You have special permission to view the item because you made a request for this item");
            }
        }

        // No special conditions met - public items can still be viewed in readonly
        if($itemToView->approved === 1){
            return view('viewitem', ['itemToView' => $itemToView, 'request' => null]);
        }  
        abort(403); // unauthorised request
    }
}
?>