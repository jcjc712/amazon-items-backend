<?php

use Illuminate\Http\Request;

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
/*SignUp*/
Route::post('/user/signup', 'Auth\RegisterController@signup');
Route::post('/user/activation', 'Auth\RegisterController@activateUser');//->name('user.activate');
/*LogOut*/
Route::middleware('auth:api')->post('/user/logout', 'Auth\LogoutController@logoutDevice');
/*ChangePass*/
Route::middleware('auth:api')->post('/user/update-account', 'Auth\AccountController@changeData');
/*Reset password*/
Route::post('/password/email', 'Auth\ForgotPasswordController@getResetToken');
Route::post('/password/reset', 'Auth\ResetPasswordController@reset');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
/*Use third parties to make search in different platforms like amazon advertisement*/
Route::get('search', 'ThirdPartyItemsController@index');
Route::get('search/{id}', 'ThirdPartyItemsController@show');

/*Show and search the user`s wish list*/
Route::middleware('auth:api')->get('wishlist', 'WishlistController@index');

/*Add or delete a product in user`s wish list*/
Route::middleware('auth:api')->post('wishlist', 'WishlistController@store');

/*Show a specific item*/
Route::get('wishlist/{item}', 'WishlistController@show');

/*List of filter*/
Route::get('filter', 'FilterController@index');


Route::get('usermail', function (){
    return env('MAIL_USERNAME');
});