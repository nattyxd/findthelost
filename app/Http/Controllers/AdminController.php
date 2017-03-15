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
        LostItem::destroy($id);

        // TODO: Email user telling them that their post was deleted

        return redirect()->action('AdminController@approve')->with('success', 'Item with id"' . $id . '" was deleted successfully!');
    }

    // if a smart user tries to do a post request they may end up here, show them error page
    // rejecting is only allowed through authenticated post routes
    public function incorrectrejectid($id){
        abort(403);
    }
}
