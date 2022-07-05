<?php

use App\Models\Listing;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

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

// Common Resource Routes:
// index - Show all listings
// show - Show single listing
// create - Show form to create new listing
// store - Store new listing
// edit - Show form to edit listing
// update - Update listing
// destroy - Delete listing 

// Get all listing from the controller
Route::get('/', [ListingController::class, 'index']);

// Show create form
Route::get('/listings/create', [ListingController::class, 'create']);

// Store listing Data
Route::post("/listings", [ListingController::class, 'store']);

// Show Edit Form
Route::get("/listings/{listing}/edit", [ListingController::class, 'edit']);

// Edit Submit to update 
Route::put('/listings/{listing}', [ListingController::class, 'update']);

// Delete listing
Route::delete('/listings/{listing}', [ListingController::class, 'destroy']);

// Register user
Route::get('/register', [UserController::class, 'create']);

// Get single listing from the controller
Route::get("/listings/{id}", [ListingController::class, 'show']);

