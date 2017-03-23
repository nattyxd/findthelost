<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Auth;
use App\LostItem;
use App\ItemRequest;
use App\User;
use Session;
use Mail;

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

        // Send an email to let them know their item was successful
        Mail::raw('Your item "' . $itemToApprove->title . '" has been approved and is now public! Log into filo now to view it.', function($m) use($associatedUser) {
            $m->to($associatedUser->email);
            $m->subject('filo : Item Approved!');
        });
        
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
        ItemRequest::where('lost_item_id', '=', $id)->delete(); // delete associated requests too

        // Email user telling them that their post was deleted
        Mail::raw('Your item "' . $itemToDestroy->title . '" was unfortunately not accepted into the filo system.', function($m) use($associatedUser) {
            $m->to($associatedUser->email);
            $m->subject('filo : Item Rejected');
        });

        return redirect()->action('AdminController@approve')->with('success', 'Item with id "' . $id . '" was deleted successfully!');
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
        Mail::raw('Your item request to ' . $requestToApprove->item->title . ' was approved, congratulations! Log into filo now to arrange the collection of the item.', function($m) use ($requestToApprove) {
            $m->to($requestToApprove->user->email);
            $m->subject('filo : Request Approved!');
        });

        // Finally - inform the other users via email that their request was rejected
        $requestsToReject = ItemRequest::where('lost_item_id', $requestToApprove->lost_item_id)->where('id', '!=', $id)->get();
        foreach ($requestsToReject as $requestToReject){
            $this->rejectrequestid($requestToReject);
            Mail::raw('Your item request to ' . $requestToApprove->item->title . ' was rejected.', function($m) use($requestToReject) {
                $m->to($requestToReject->user->email);
                $m->subject('filo : Request Rejected!');
            });
        }
        return redirect()->action('GeneralController@viewid', ['id' => $requestToApprove->lost_item_id])->withSuccess('Successfully approved the selected item request!');
    }

    public function rejectrequestid($LostItem){
        if(is_numeric($LostItem)){
            // called method with a numeric ID, need to perform SQL request
            $requestToReject = ItemRequest::find($LostItem);

            if(!$requestToReject){
                abort(400); // in case they somehow submit an request that doesn't exist
            }

            // Firstly - reject the item in question
            $requestToReject->approved = 0;
            $requestToReject->adminhandled = 1;
            $requestToReject->save();

            Mail::raw('Your item request to ' . $requestToReject->item->title . ' was rejected.', function($m) use($requestToReject) {
                $m->to($requestToReject->user->email);
                $m->subject('filo : Request Rejected!');
            });

            return redirect()->action('GeneralController@viewid', ['id' => $requestToReject->lost_item_id])->withSuccess('Successfully rejected the selected item request!');
        }
        else{
            // called method with a LostItem variable, can modify item without SQL
            $LostItem->approved = 0;
            $LostItem->adminhandled = 1;
            $LostItem->save();
        }
    }

    public function viewrequests(){
        $itemRequests = ItemRequest::where('adminhandled', '!=', '1')->get();
        $lostItemsValueArray = [];
        $lostItemsArray = [];

        // TODO : Inefficient - http://stackoverflow.com/questions/42965257/laravel-eloquent-orm-filtering-results-by-distinct-values-in-another-column
        foreach ($itemRequests as $itemRequest){
            if(!in_array($itemRequest->lost_item_id, $lostItemsValueArray)){
                array_push($lostItemsValueArray, $itemRequest->lost_item_id);
            }
        }

        foreach($lostItemsValueArray as $lostItemValue){
            array_push($lostItemsArray, LostItem::find($lostItemValue));
        }

        return view('admin/itemrequests', ['lostItems' => $lostItemsArray]);
    }

    public function manageusers(){
        $users = User::paginate(15);
        return view ('admin/users', ['users' => $users]);
    }

    public function deleteuserid($id){
        $user = User::find($id);
        $user->delete();
        return redirect()->action('AdminController@manageusers');
    }
}
