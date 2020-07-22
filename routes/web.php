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

Route::group(['middleware' => 'web'], function () {
    Route::get(env('LARAVUE_PATH'), 'LaravueController@index')->where('any', '.*')->name('laravue');
});

Route::get('token', function () {
    $key = "ExtbG0QSRP0Vexb0hYSpdFOoWCRVkVMq";
    $secret = "bgGn9QkdLLBWVOYR8FRYNA0BNRzNLpXwRKBTgT7Ro7csSnPsA9lO1Pi2L440qATF";
    echo base64_encode("{$key}:{$secret}");
});
