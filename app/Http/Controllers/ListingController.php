<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    //
    // Show all listing
    public function index() {
        // dd(request()->tag);
        return view('listings.index', [
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->simplePaginate(8),
        ]);
    }

    // Show single listing 
    public function show($id) {
        $singleList = Listing::find($id);

        if($singleList) {
            return view('listings.show', [
                'listing' => $singleList,
            ]);
        } else {
            abort('404');
        }
    }

    // Show create form
    public function create() {
        return view("listings.create");
    }

    // Store Listing Data
    public function store(Request $request) {
        // dd(request()->all());

        $formValue = $request->validate([
            'title' => 'required',
            'company' => ['required', 'unique:listings', 'max:255'], // Set unique field for the listings table 
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if ($request->hasFile('logo')) {
            $formValue['logo'] = $request->file('logo')->store('logos', 'public');
        }
        
        $formValue['user_id'] = auth()->id();
        Listing::create($formValue);

        return redirect("/")->with('message', 'Listing created successfully');
    }
    
    // Show edit form
    public function edit(Listing $listing) {
        // dd($listing);

        return view('listings.edit', ['listing' => $listing]);
    }

    // Update listing
    public function update(Request $request, Listing $listing) {

        // Make sure log in user its owner
        if ($listing->user_id != auth()->id()) {
            abort(403, "Unauthorized Action");
        }

        $formValue = $request->validate([
            'title' => 'required',
            'company' => 'required', // Set unique field for the listings table 
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if ($request->hasFile('logo')) {
            $formValue['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $listing->update($formValue);

        return back()->with('message', 'Updated list successfully');
    }

    public function destroy(Listing $listing) {
        // Make sure log in user its owner
        if ($listing->user_id != auth()->id()) {
            abort(403, "Unauthorized Action");
        }

        $listing->delete();

        return redirect("/")->with('message', "Listing deleted successfully");
    }

    public function manage() {
        return view('listings.manage', [
            'listings' => auth()->user()->listings()->get()
        ]);
    }
}
