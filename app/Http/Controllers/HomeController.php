<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\LostItem;

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

        $lostItem->save(); // lastly save this model into the db

        return view('home'); // TODO: Return success message
    }
}
