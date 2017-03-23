<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\LostItem;
use App\ItemRequest;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
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

    public function add(){
        return view('add');
    }

    /**
     *
     * Validate the user's input, and then add the new item to the db
     * @return void
     */
    public function submitadd(Request $request){
        // Ensure valid input has been provided
        $this->validate($request, [
            'category' => 'required', Rule::in(['pets', 'electronics', 'jewellery']),
            'title' => 'required|min:5|max:255',
            'description' => 'required|min:5|max:255',
            'lostitem' => 'required', Rule::in(['I have lost this item'], 'I have found this item'),
            'addressline1' => 'required|min:5|max:255',
            'addressline2' => 'max:255', // don't need to require line 2
            'addressline3' => 'max:255', // don't need an addressline3 necessarily
            'city' => 'required|max:255', // city must be given for sorting
            'postcode' => 'required|max:255|regex:/[A-Z]{1,2}[0-9][0-9A-Z]?\s?[0-9][A-Z]{2}/i', // use regex to validate postcode
            'photo' => 'required|mimes:jpeg,bmp,png|max:1024', // max 1mb, must be jpg, bmp, or png
        ]);

        // Validation passed
        $lostItem = new LostItem;
        $path = $request->file('photo')->store('public/lost_item_photos');

        $parseURL = explode("/", $path);
        unset($parseURL[0]);
        $parseURL = implode("/", $parseURL);
        $parseURL = "storage/" . $parseURL;
        // dd($parseURL);

        // Set flag to correct value
        $boolFlag = ($request->input('lostitem') == "I have lost this item");

        // Sanitise the input
        $category = htmlspecialchars( $request->input('category'), ENT_QUOTES); // sanitize category
        $title = htmlspecialchars( $request->input('title'), ENT_QUOTES); // sanitize title
        $description = htmlspecialchars( $request->input('description'), ENT_QUOTES); // sanitize description
        // boolflag does not need sanitising
        // reunited does not need sanitising
        $addressline1 = htmlspecialchars( $request->input('addressline1'), ENT_QUOTES); // sanitize addressline1
        $addressline2 = htmlspecialchars( $request->input('addressline2'), ENT_QUOTES); // sanitize addressline2
        $addressline3 = htmlspecialchars( $request->input('addressline3'), ENT_QUOTES); // sanitize addressline3
        // image_url generated dynamically - does not need sanitising
        $city = htmlspecialchars( $request->input('city'), ENT_QUOTES); // sanitize city
        $postcode = htmlspecialchars( $request->input('postcode'), ENT_QUOTES); // sanitize postcode
        

        // Setup Model to insert
        $lostItem->category = $category;
        $lostItem->title = $title;
        $lostItem->description = $description;
        $lostItem->lostitem = $boolFlag; // true for lost item, false for found item
        $lostItem->reunited = false;
        $lostItem->addressline1 = $addressline1;
        $lostItem->addressline2 = $addressline2;
        $lostItem->addressline3 = $addressline3;
        $lostItem->image_url = $parseURL;
        $lostItem->city = $city;
        $lostItem->approved = null;
        $lostItem->postcode = $postcode;
        $lostItem->approved = 0;
        $lostItem->user()->associate(Auth::user()->id);

        if($lostItem->user->trust >= 200){
            // the user is trusted and an admin does not need to authorise them adding items
            $lostItem->approved = 1;
        }
        else{
            // user isn't trusted yet
            $lostItem->approved = 0;
        }
        $lostItem->save(); // lastly save this model into the db
        return redirect()->action('GeneralController@viewid', array($lostItem->id));
    }

    public function edit($id){
        $out = $this->isSubmitterOrAdmin($id);
        if($out['authenticated']){
            return view('edit', ['itemToEdit' => $out['item']]);
        }
        abort(403); // malicious requests get shown the permission denied error
    }

    public function submitedit($id, Request $request){
        // Laravel should automatically filter out malicious requests - but we are paranoid and will check they are authenticated anyway
        $out = $this->isSubmitterOrAdmin($id);
        if(!$out['authenticated']){
            abort(403); // malicious requests get shown the permission denied error
        }

        // Now we know the user is legit, we can begin modifying their item
        // Ensure valid input has been provided
        $this->validate($request, [
            'category' => 'required', Rule::in(['pets', 'electronics', 'jewellery']),
            'title' => 'required|min:5|max:255',
            'description' => 'required|min:5|max:255',
            'lostitem' => 'required', Rule::in(['I have lost this item'], 'I have found this item'),
            'addressline1' => 'required|min:5|max:255',
            'addressline2' => 'max:255', // don't need to require line 2
            'addressline3' => 'max:255', // don't need an addressline3 necessarily
            'city' => 'required|max:255', // city must be given for sorting
            'postcode' => 'required|max:255|regex:/[A-Z]{1,2}[0-9][0-9A-Z]?\s?[0-9][A-Z]{2}/i', // use regex to validate postcode
            'photo' => 'mimes:jpeg,bmp,png|max:1024', // max 1mb, must be jpg, bmp, or png
        ]);

        // Validation passed
        $lostItem = LostItem::find($id);
        if($request->file('photo')){
            // only want to store a new photo if one has actually been set
            $path = $request->file('photo')->store('public/lost_item_photos');

            $parseURL = explode("/", $path);
            unset($parseURL[0]);
            $parseURL = implode("/", $parseURL);
            $parseURL = "storage/" . $parseURL;
            $lostItem->image_url = $parseURL;
        }

        // Set flag to correct value
        $boolFlag = ($request->input('lostitem') == "I have lost this item");

        // Sanitise the input
        $category = htmlspecialchars( $request->input('category'), ENT_QUOTES); // sanitize category
        $title = htmlspecialchars( $request->input('title'), ENT_QUOTES); // sanitize title
        $description = htmlspecialchars( $request->input('description'), ENT_QUOTES); // sanitize description
        // boolflag does not need sanitising
        // reunited does not need sanitising
        $addressline1 = htmlspecialchars( $request->input('addressline1'), ENT_QUOTES); // sanitize addressline1
        $addressline2 = htmlspecialchars( $request->input('addressline2'), ENT_QUOTES); // sanitize addressline2
        $addressline3 = htmlspecialchars( $request->input('addressline3'), ENT_QUOTES); // sanitize addressline3
        // image_url generated dynamically - does not need sanitising
        $city = htmlspecialchars( $request->input('city'), ENT_QUOTES); // sanitize city
        $postcode = htmlspecialchars( $request->input('postcode'), ENT_QUOTES); // sanitize postcode

        // Setup Model to insert
        $lostItem->category = $category;
        $lostItem->title = $title;
        $lostItem->description = $description;
        $lostItem->lostitem = $boolFlag; // true for lost item, false for found item
        $lostItem->reunited = false;
        $lostItem->addressline1 = $addressline1;
        $lostItem->addressline2 = $addressline2;
        $lostItem->addressline3 = $addressline3;
        $lostItem->city = $city;
        $lostItem->postcode = $postcode;

        $lostItem->save(); // lastly save this model into the db
        return redirect()->action('GeneralController@viewid', array($lostItem->id));
    }

    public function submititemrequest($id, Request $request){
        // Ensure the user has permission to submit a request for the item before doing anything else
        $itemInQuestion = LostItem::find($id);
        if(!is_null($itemInQuestion)){ // Need to ensure the item actually exists
            if($itemInQuestion->approved == 1 && $itemInQuestion->user_id !== Auth::user()->id){ // ensure item is approved & owner not submitting request
                // Do a quick check to make sure that the user doesn't already have a request
                $userRequestsForItem = ItemRequest::where('user_id', '=', Auth::user()->id)->where('lost_item_id', '=', $itemInQuestion->id);
                if($userRequestsForItem->count() > 0){
                    abort(403); // users can only have 1 request per item
                }

                // item is public, and submitter is not the owner, and no request exists: continue with submission procedure
                $itemRequest = new ItemRequest;

                // Ensure valid input has been provided
                $this->validate($request, [
                    'reason' => 'required|min:5|max:255',
                    'photo' => 'mimes:jpeg,bmp,png|max:1024', // max 1mb, must be jpg, bmp, or png
                ]);

                // Validation passed
                if($request->file('photo')){
                    // only want to store a new photo if one has actually been set
                    $path = $request->file('photo')->store('public/lost_item_photos');

                    $parseURL = explode("/", $path);
                    unset($parseURL[0]);
                    $parseURL = implode("/", $parseURL);
                    $parseURL = "storage/" . $parseURL;
                    $itemRequest->image_url = $parseURL;
                }

                // Sanitise the input
                $reason = htmlspecialchars( $request->input('reason'), ENT_QUOTES); // sanitize reason

                // Start saving the model
                $itemRequest->user_id = Auth::user()->id;
                $itemRequest->lost_item_id = $itemInQuestion->id;
                $itemRequest->approved = 0;
                $itemRequest->adminhandled = 0;
                $itemRequest->reason = $reason;

                $itemRequest->save();
                return redirect()->action('GeneralController@viewid', array($itemInQuestion->id));
            }
            else{
                abort(403); // no permission to submit a request
            }
            dd($itemInQuestion);
        }

        // Ensure valid input has been provided
        $this->validate($request, [
            'category' => 'required', Rule::in(['pets', 'electronics', 'jewellery']),
            'title' => 'required|min:5|max:255',
            'description' => 'required|min:5|max:255',
            'lostitem' => 'required', Rule::in(['I have lost this item'], 'I have found this item'),
            'addressline1' => 'required|min:5|max:255',
            'addressline2' => 'max:255', // don't need to require line 2
            'addressline3' => 'max:255', // don't need an addressline3 necessarily
            'city' => 'required|max:255', // city must be given for sorting
            'postcode' => 'required|max:255|regex:/[A-Z]{1,2}[0-9][0-9A-Z]?\s?[0-9][A-Z]{2}/i', // use regex to validate postcode
            'photo' => 'required|mimes:jpeg,bmp,png|max:1024', // max 1mb, must be jpg, bmp, or png
        ]);
    }

    // return true if the user submitted an item, or is admin, false otherwise
    public function isSubmitterOrAdmin($id){
        $itemInQuestion = LostItem::find($id);
        if(is_null($itemInQuestion)){
            // if the item doesn't exist, the request should immediately be rejected in order to avoid nullrefence exceptions
            $out['authenticated'] = false;
            return $out;
        }
        if(!is_null(Auth::user())){
            if(Auth::user()->userlevel == 1 || $itemInQuestion->user_id == Auth::user()->id){
                $out['authenticated'] = true;
                $out['item'] = $itemInQuestion;
                return $out;
            }
        }
        $out['authenticated'] = false;
        return $out;
    }

    public function myitems(){
        $myItems = LostItem::where('user_id', '=', Auth::user()->id)->get();
        return view('myitems', ['myItems' => $myItems]);
    }

    public function myaccount(){
        return view('myaccount', ['user' => Auth::user()]);
    }
}
