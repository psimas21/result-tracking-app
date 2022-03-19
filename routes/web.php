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

Route::get('/', function () {
    return view('welcome');
});

Route::any('/{any}', function () {
    return view('welcome');
});

// CODES FOR ROLES ROUTE
Route::post('app/create_role','AdminController@addRole');
Route::get('app/get_roles','AdminController@getRole');
Route::post('app/disable_role','AdminController@disableRole');
// END CODES FOR ROLES ROUTE

// CODES FOR ROLES ROUTE
Route::post('app/create_user','AdminController@addUser');
Route::get('app/get_users','AdminController@getUser');
// END CODES FOR ROLES ROUTE
