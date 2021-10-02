<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\passportAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//add this middleware to ensure that every request is authenticated
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//routes/api.php
Route::post('register', [passportAuthController::class, 'registerUserExample']);
Route::post('login', [passportAuthController::class, 'loginUserExample']);

Route::middleware('auth:api')->group(function () {
    Route::get('user', [passportAuthController::class, 'authenticatedUserDetails']);
});

Route::put('editprofile', [passportAuthController::class, 'editProfileExample']);

Route::post('changepassword', [passportAuthController::class, 'changePasswordExample']);

Route::get('booklisting', [passportAuthController::class, 'bookListingExample']);

Route::get('bookdetails/{id}', [passportAuthController::class, 'bookDetailsExample']);

Route::get('validation', [passportAuthController::class, 'validationExample']);

Route::post('addcart', [passportAuthController::class, 'addCartExample']);

Route::get('viewcart/{id}', [passportAuthController::class, 'viewCartExample']);

Route::post('updatecart', [passportAuthController::class, 'updateCartExample']);

Route::post('removecart', [passportAuthController::class, 'removeCartExample']);

Route::get('checkout', [passportAuthController::class, 'getCheckoutExample']);

Route::post('placeorder', [passportAuthController::class, 'placeOrderExample']);