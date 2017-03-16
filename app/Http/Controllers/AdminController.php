<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Auth;
use App\LostItem;
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

    // approve an item with a specified id
    public function approveid($id){
        $itemToApprove = LostItem::find($id);
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

    // Show the page where admins can edit items
    public function editwithid($id){
        dd("403"); // TODO: Implement
    }
}
