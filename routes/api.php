<?php
use App\User;
use App\Models\Apartment;
use App\Models\Service;
use App\Models\Sponsor;
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
Route::get('/apartments','Api\ApartmentController@index');
Route::get('/apartments/{descriptive_title}', 'Api\ApartmentController@show');
Route::post('/apartments/email', 'Api\ApartmentController@sendEmail');
Route::get('/services', 'Api\ServiceController@index');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
