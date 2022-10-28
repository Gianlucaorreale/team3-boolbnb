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


Auth::routes();

Route::middleware('auth')->prefix('admin')->namespace('Admin')->name('admin.')->group(function (){
    Route::get('/', 'HomeController@index')->name('home');
    Route::resource('apartments', 'ApartmentController');
    Route::get('apartments/{apartment}/messages', 'MessageController@index')->name('apartments.messages.index');
    Route::get('/{any}', function () {
        abort('404');
    })->where('any', '.*');
});
Route::get('/{any?}', 'Guest\HomeController@index')->name('guest.home')->where('any', '.*');
