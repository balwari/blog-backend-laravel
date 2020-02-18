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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(['middleware' => 'auth:api'], function (){
    Route::get("/","Home@index");
    Route::post("addpost", "Home@addPost");
    Route::post("getpost", "Home@getPost");
    Route::post("updatepost", "Home@updatePost");
    Route::post("deletepost", "Home@deletePost");
    Route::post("paginateData", "Home@paginateData");
    Route::post("customers", "Home@customers");
    Route::post("deleteUser", "Home@deleteUser");
    Route::get("count", "Home@count");
    Route::post('adduser', 'Api\\AuthController@register');
    Route::post('updateUser', 'Home@updateUser');
    Route::post('blockUser', 'Home@blockUser');
    Route::post('unblockUser', 'Home@unblockUser');
});



Route::post('/register', 'Api\\AuthController@register');
Route::post('/login', 'Api\\AuthController@login');
Route::post('/adminlogin', 'Api\\AuthController@login');
				