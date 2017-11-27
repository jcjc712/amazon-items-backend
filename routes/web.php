<?php

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
Route::get('/parse', function (){


});
Route::get('/', function () {
    $url = parse_url(getenv("CLEARDB_DATABASE_URL"));
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
