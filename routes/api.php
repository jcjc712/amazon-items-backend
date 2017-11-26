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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
/*Use third parties to make search in different platforms like amazon advertisement*/
Route::get('search', 'ThirdPartyItemsController@index');
Route::get('search/{id}', 'ThirdPartyItemsController@show');

/*Show and search the user`s wish list*/
Route::get('wishlist', 'WishlistController@index');

/*Add or delete a product in user`s wish list*/
Route::post('wishlist', 'WishlistController@store');

/*Show a specific item*/
Route::get('wishlist/{item}', 'WishlistController@show');

/*List of filter*/
Route::get('filter', 'FilterController@index');