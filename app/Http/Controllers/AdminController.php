<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Auth;
use App\LostItem;
use App\ItemRequest;
use Session;

class AdminController extends Controller
{
    /**
     * Create a new AdminController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    // -- Home page of the "approval" page
    public function approve(){
        $unapprovedItems = LostItem::where('approved', '!=', '1')->get();
        return view('admin/approve', ['unapprovedItems' => $unapprovedItems]);
    }

    // approve an item with a specified id TO BECOME PUBLIC
    // this function does NOT approve an ItemRequest, it just
    // makes an item the user has added into the system public
    public function approveid($id){
        $itemToApprove = LostItem::find($id);

        if(!$itemToApprove){
            abort(400); // in case they somehow submit an item that doesn't exist
        }

        $itemToApprove->approved = 1;
        $itemToApprove->save();

        // make the user more trusted, so they don't need admin approval in future
        $associatedUser = $itemToApprove->user;
        $associatedUser->trust = $associatedUser->trust + 100;
        $associatedUser->save();

        // TODO: Email user telling them that it's been approved
        
        $unapprovedItems = LostItem::where('approved', '!=', '1')->get();
        return redirect()->action('AdminController@approve')->with('success','Item with id "' . $id . '" was approved successfully!');
    }
    
    // if a smart user tries to do a post request they may end up here, show them error page
    // approval is only allowed through authenticated post routes
    public function incorrectapproveid($id){
        abort(403);
    }

    // reject an item with a specified id
    public function rejectid($id){
        $itemToDestroy = LostItem::find($id);

        // reduce the user's trust
        $associatedUser = $itemToDestroy->user;
        $associatedUser->trust = $associatedUser->trust - 100;
        $associatedUser->save();

        LostItem::destroy($id); // delete the item

        // TODO: Email user telling them that their post was deleted

        return redirect()->action('AdminController@approve')->with('success', 'Item with id"' . $id . '" was deleted successfully!');
    }

    // if a smart user tries to do a post request they may end up here, show them error page
    // rejecting is only allowed through authenticated post routes
    public function incorrectrejectid($id){
        abort(403);
    }

    public function approverequestid($id){
        $requestToApprove = ItemRequest::find($id);

        if(!$requestToApprove){
            abort(400); // in case they somehow submit an request that doesn't exist
        }

        // Firstly - approve the item in question
        $requestToApprove->approved = 1;
        $requestToApprove->adminhandled = 1;
        $requestToApprove->save();

        // Secondly - Mark the item no longer suitable for public viewing now that it has been approved
        $itemToHide = $requestToApprove->item;
        $itemToHide->approved = 0;
        $itemToHide->save();

        // Thirdly - inform the user via email that their request was accepted
        // TODO - Email

        // Finally - inform the other users that their request was rejected
        $requestsToReject = ItemRequest::where('lost_item_id', $requestToApprove->lost_item_id)->where('id', '!=', $id)->get();
        foreach ($requestsToReject as $requestToReject){
            $requestToReject->approved = 0;
            $requestToReject->adminhandled = 1;
            $requestToReject->save();
            // TODO: Email the users who had the requests rejected
        }
        return redirect()->action('GeneralController@viewid', ['id' => $requestToApprove->lost_item_id])->withSuccess('Successfully approved the selected item request!');
    }

    public function rejectitemid($id){

        // TODO: Email the user that had the request rejected
    }

    // Show the page where admins can edit items
    public function editwithid($id){
        dd("403"); // TODO: Implement
    }

    public function viewrequests(){
        $itemRequests = ItemRequest::all();
        dd($itemRequests);
        return view('admin/itemrequests');
    }
}
