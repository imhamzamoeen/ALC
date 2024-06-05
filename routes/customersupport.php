<?php

use Illuminate\Support\Facades\Route;
use App\Classes\Enums\UserTypesEnum;

/*
|--------------------------------------------------------------------------
| Customer Support Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your cusromer support for admin. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::group(['middleware' => ['userType:'.UserTypesEnum::CustomerSupport.'auth:sanctum', 'verified']], function (){
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/','DashboardController@index');


});