<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


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



// Listings Routes 

//Show All List Items
Route::get('/', [ListingController::class, 'index']);

//Create List Item
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');

//Create List Item
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');

//Edit List Item
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

//Update List Item
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

//Manage List Items
Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth');

//Delete List Item
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');

//Show A List Item
Route::get('/listings/{listing}', [ListingController::class, 'show']);



//User Routes

//Route To Show Login Page.
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

//Route To Show Sign Up Page.
Route::get('/register', [UserController::class, 'register'])->middleware('guest');

//Save A User.
Route::post('/users', [UserController::class, 'store']);

//Login A User.
Route::post('/users/authenticate', [UserController::class, 'authenticate']);

//User Logout 
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');
