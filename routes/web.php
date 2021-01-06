<?php

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

Route::get('/add-to-cart/{id}', [
        'uses' => 'ProductsController@getAddToCart',
        'as' => 'product.addToCart',
]);
Route::get('/shopping-cart', [
        'uses' => 'ProductsController@getCart',
        'as' => 'product.shoppingCart',
]);
Route::get('/checkout', [
        'uses' => 'ProductsController@getCheckout',
        'as' => 'checkout',
]);
Route::post('/checkout', [
        'uses' => 'ProductsController@postCheckout',
        'as' => 'checkout',
]);

Route::get('/reduce{id}', [
        'uses' => 'ProductsController@getReduceByOne',
        'as' => 'product.reduceByOne',
]);
Route::get('/remove{id}', [
        'uses' => 'ProductsController@getRemoveItem',
        'as' => 'product.remove',
]);


Route::group(['middleware' => 'adminMid'], function () {
    Route::get('admin', 'ProductsController@index')->name('admin');
    Route::get('admin/create','ProductsController@create')->name('adminCreate');
    Route::post('admin','ProductsController@store')->name('adminStore');
    Route::get('/admin/{product}','ProductsController@show')->name('adminShow');
    Route::get('admin/{product}/edit','ProductsController@edit')->name('adminEdit');
    Route::patch('admin/{product}','ProductsController@update')->name('adminUpdate');
    Route::delete('admin/{product}','ProductsController@destroy')->name('adminDestroy');

    Route::get('comenzi','ProductsController@getorders')->name('adminOrders');
});
    Route::get('/', 'ProductsController@index')->name('goHome');
    Route::get('/guest/{product}', 'ProductsController@show')->name('showSelectProduct');
    Route::get('/','ProductsController@sort')->name('sorting');



    Route::get('/detaliiprodus.{format}/{id}','ProductsController@formatSingle')->name('single');

    Route::get('/afisareproduse.{format}','ProductsController@formatAll')->name('all');

Route::get('/login', function () {
    return view('admin.logare');
})->name('logAdmin');

Route::post('/logare', 'UsersController@index')->name('logIn');
Route::get('/logout', 'UsersController@logOut')->name('logOut');
