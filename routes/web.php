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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/boutique', 'ProductController@index')->name('products.index');
Route::get('/boutique/{slug}/{id}', 'ProductController@show')->name('products.show');
Route::get('/search', 'ProductController@search')->name('products.search');
Auth::routes();

Route::group([ 'middleware' => ['auth']], function(){
    Route::post('/panier/ajouter', 'CartController@store')->name('cart.store');
    Route::patch('/panier/{rowId}', 'CartController@update')->name('cart.update');
    Route::get('/panier', 'CartController@index')->name('cart.index');
    Route::delete('/panier/{rowId}', 'CartController@destroy')->name('cart.destroy');
    Route::post('/coupon', 'CartController@storeCoupon')->name('cart.store.coupon');
    Route::delete('/coupon', 'CartController@destroyCoupon')->name('cart.destroy.coupon');

});
/*paiement*/
Route::group([ 'middleware' => ['auth']], function(){
Route::get('/paiement', 'checkoutController@index')->name('checkout.index');
Route::post('/paiement', 'checkoutController@store')->name('checkout.store');
Route::get('/merci', 'checkoutController@thankYou')->name('checkout.thankYou');
});
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
    
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
