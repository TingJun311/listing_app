<?php

use Illuminate\Support\Facades\Route;
use App\Models;
use App\Models\Listing;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('listings', [
        'listings' => Listing::all(),
    ]);
});

// Single listing 
Route::get("/listings/{id}", function ($id) {
    $singleList = Listing::find($id);

    if($singleList) {
        return view('listing', [
            'listing' => $singleList,
        ]);
    } else {
        abort('404');
    }
});

