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
Route::post('app/create_role','RoleController@addRole');
Route::get('app/get_roles','RoleController@getRole');
Route::post('app/disable_role','RoleController@disableRole');
// END CODES FOR ROLES ROUTE

// CODES FOR USER ROUTEs
Route::post('app/create_user','AdminController@addUser');
Route::get('app/get_users','AdminController@getUser');
Route::post('app/edit_user','AdminController@editUser');
// END CODES FOR ROLES ROUTE

// CODES FOR PARTY ROUTE
Route::post('app/create_party','PartyController@addParty');
Route::get('app/get_parties','PartyController@getParty');
Route::post('app/disable_party','PartyController@disableParty');
// END CODES FOR PARTY ROUTE

// CODES FOR LGA, WARD AND PU ROUTE
Route::get('app/get_lga','LgaController@getLga');
Route::get('app/get_ward/{lga_id}','WardController@getWard');
Route::get('app/get_pus/{ward_id}/{lga_id}','PUController@getPU');
// END CODES FOR LGA, WARD AND PU ROUTE

// CODES FOR RESULT
Route::post('app/create_result','ResultController@addResult');
Route::get('app/get_result','ResultController@index');
// END CODES FOR RESULT