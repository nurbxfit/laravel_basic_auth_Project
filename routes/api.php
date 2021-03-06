<?php

use Illuminate\Http\Request;
use App\Http\Middleware\CORS;

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

Route::middleware(CORS::class)->options('login',function(){

});
Route::middleware(CORS::class)->post('login','API\UserController@login');

Route::post('register','API\UserController@register');

Route::group(['middleware'=>'auth:api'],
    function(){
        Route::post('details','API\UserController@details');
        Route::get('logout','API\UserController@logout');
    }

);


