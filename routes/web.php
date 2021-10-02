<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\usersideController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

//verification notice
Route::get('/email/verify', function () {
    return view('auth.verify');
})->name('verification.notice');

//verify the email
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/users/home')->with('sucess', 'Your email is verified!');
})->middleware(['auth', 'signed'])->name('verification.verify');

//send email again if mail is not found or deleted by mistake
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

//admin routes
Route::prefix('admin')->group(function () {
    Route::group(['middleware' => ['protectedPages']], function () {
        Route::view('/dashboard', 'admin.dashboard');

        Route::resource('/user', 'App\Http\Controllers\adminController');

        Route::resource('/book', 'App\Http\Controllers\bookController');

        Route::get('/orderMaster', [checkoutController::class, 'index']);

        Route::get('/orderDetails', [checkoutController::class, 'orderDetails']);

        Route::get('/changePassword', 'App\Http\Controllers\ChangePasswordController@index');

        Route::post('/changePassword', 'App\Http\Controllers\ChangePasswordController@store')->name('change.password');

        //  Route::get('/file-export', [CheckoutController::class, 'fileExport'])->name('file-export');
    });
});

Route::view('/nonAccessable', 'users.nonAccessable');

Route::prefix('users')->group(function () {
    // Route::get('/home', 'App\Http\Controllers\usersideController@home');
    Route::get('/home', [usersideController::class, 'home'])->name('user.home');
    Route::view('/about', 'users.about');

    Route::view('/contact', 'users.contact');

    Route::view('/thankyou', 'users.thankYou');

    Route::get('/changePassword', 'App\Http\Controllers\usersideController@index');
    Route::post('/changePassword', 'App\Http\Controllers\usersideController@store')->name('change.password');

    Route::get('/bookListing', 'App\Http\Controllers\usersideController@bookListing')->name('users.bookListing');
    Route::get('/bookdetails/{id}', 'App\Http\Controllers\usersideController@bookdetails');

    Route::group(['middleware' => ['protectedCart', 'verified']], function () {
        Route::get('/cart', [CartController::class, 'cartList'])->name('cart.list');
        Route::post('/cart', [CartController::class, 'addToCart'])->name('cart.store');
        Route::post('/update-cart', [CartController::class, 'updateCart'])->name('cart.update');
        Route::post('/remove', [CartController::class, 'removeCart'])->name('cart.remove');
        Route::post('/clear', [CartController::class, 'clearAllCart'])->name('cart.clear');

        //profile route
        Route::get('/profile', 'App\Http\Controllers\usersideController@showProfile')->name('profile.show');
        Route::get('/profile/{id}', 'App\Http\Controllers\usersideController@editProfile')->name('profile.edit');
        Route::patch('/profile/{id}', 'App\Http\Controllers\usersideController@updateProfile')->name('profile.update');
        Route::get('/orderListing', 'App\Http\Controllers\checkoutController@orderListing')->name('order.listing');
        Route::post('/ordercancel', 'App\Http\Controllers\checkoutController@orderCancel')->name('order.cancel');
        Route::get('/pdf', [CheckoutController::class, 'createPDF']);
    });

    Route::get('/checkout', 'App\Http\Controllers\CheckoutController@getCheckout')->name('checkout.index');
    Route::post('/checkout/order', 'App\Http\Controllers\CheckoutController@placeOrder')->name('checkout.place.order');
});

    // Route::group(['middleware' => ['protectedPages']], function () {
    // Route::view('/admin/dashboard', 'admin.dashboard');
    // Route::resource('/admin/user', 'App\Http\Controllers\adminController');
    // Route::resource('/admin/book', 'App\Http\Controllers\bookController');

    // });
//Middleware for user can not access admin pages

//Route for changePassword of Admin
// Route::get('/admin/changePassword', 'App\Http\Controllers\ChangePasswordController@index');

// Route::post('/admin/changePassword', 'App\Http\Controllers\ChangePasswordController@store')->name('change.password');
//nonaccessable page redirection route

//before go on to the cart page ,user should be logged in

//Route::resource('/admin/user', 'App\Http\Controllers\adminController');
//Route::get('/admin/changePassword', 'App\Http\Controllers\ChangePasswordController@index');
//Route::post('/admin/changePassword', 'App\Http\Controllers\ChangePasswordController@index');
//Route::post('/admin/changePassword', 'App\Http\Controllers\ChangePasswordController@store')->name('change.password');

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Route::resource('/admin/book', 'App\Http\Controllers\bookController');

//userSide
//home ,about and contact us page route

// Route::view('/users/home', 'users.home');
//Route::view('/users/about','users.about');
//Route::view('/users/contact','users.contact');
//Route::get('/users/home', 'App\Http\Controllers\usersideController@home');
// Route::get('/users/changePassword', 'App\Http\Controllers\usersideController@index');
// Route::post('/users/changePassword', 'App\Http\Controllers\usersideController@store')->name('change.password');
//Route::resource('/users/profile', 'App\Http\Controllers\profileController');
// Route::get('/users/bookListing', 'App\Http\Controllers\usersideController@bookListing')->name('users.bookListing');
// Route::get('/users/bookdetails/{id}', 'App\Http\Controllers\usersideController@bookdetails');
//Route::post('/users/add-cart-process/{id}', 'App\Http\Controllers\usersideController@addTocartProcess');
// Route::get('/users/cart', 'App\Http\Controllers\usersideController@cartListing');
//Route::get('/users/remove-cart/{id}', 'App\Http\Controllers\usersideController@removeCart');
//Route::post('/users/update-cart/{id}', 'App\Http\Controllers\usersideController@updateCart');
//Route::post('/users/place-order', 'App\Http\Controllers\usersideController@placeOrder');
// Route::get('/users/thank-you',function(){
//     Echo "Your Order Placed Successfully";
// });
// Route::get('/users/about', function () {
//     return view('users.about');
// });
// Route::get('/users/cart/{id}/{book}/{price}','App\Http\Controllers\usersideController@store1')->name('users.cartListing');
// //Route::get('/users/cart/{id}/{book}/{price}', 'App\Http\Controllers\usersideController@cartListing');

//Cart Routes
//Route::get('/', [ProductController::class, 'productList'])->name('products.list');
// Route::get('cart', [CartController::class, 'cartList'])->name('cart.list');
// Route::post('cart', [CartController::class, 'addToCart'])->name('cart.store');
// Route::post('update-cart', [CartController::class, 'updateCart'])->name('cart.update');
// Route::post('remove', [CartController::class, 'removeCart'])->name('cart.remove');
// Route::post('clear', [CartController::class, 'clearAllCart'])->name('cart.clear');
