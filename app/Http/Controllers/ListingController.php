<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    //Get All List Items.
    public function index()
    {
        return view('listings.index', [
            "listings" => Listing::latest()->filter(request(['tag', 'search']))->paginate(5)
        ]);
    }

    //Get A Single List Item.
    public function show(Listing $listing)
    {
        return view('listings.show', [
            'listing' => $listing
        ]);
    }

    //Show A Form To Create List Item.
    public function create()
    {
        return view('listings.create');
    }

    //Save The List Item To Database.
    public function store(Request $request)
    {
        $formField = $request->validate([
            'title' => 'required',
            'tags' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'email' => ['required', 'email'],
            'website' => 'required',
            'description' => 'required'
        ]);


        if ($request->hasFile('logo')) {
            $formField['logo'] = $request->File('logo')->store('logos', 'public');
        }

        $formField['user_id'] = auth()->user()->id;

        Listing::create($formField);

        return redirect('/')->with("message", "Item Created Successfully");
    }

    //Edit Item
    public function edit(Listing $listing)
    {
        return view('listings.edit', [
            'listing' => $listing
        ]);
    }

    //Update Item
    public function update(Request $request, Listing $listing)
    {

        if ($listing->user_id != auth()->user()->id) {
            abort(403, 'Unauthorized Access');
        }

        $formField = $request->validate([
            'title' => 'required',
            'tags' => 'required',
            'company' => 'required',
            'location' => 'required',
            'email' => ['required', 'email'],
            'website' => 'required',
            'description' => 'required'
        ]);


        if ($request->hasFile('logo')) {
            $formField['logo'] = $request->File('logo')->store('logos', 'public');
        }

        $listing->update($formField);

        return redirect("/listings/$listing->id")->with("message", "Item updated Successfully");
    }

    //Delete a listing item
    public function destroy(Listing $listing)
    {
        if ($listing->user_id != auth()->user()->id) {
            abort(403, 'Unauthorized Access');
        }
        $listing->delete();
        return back()->with("message", "Item deleted Successfully");
    }

    public function manage()
    {
        return view('listings.manage', [
            'listings' => auth()->user()->listings()->get()
        ]);
    }
}
