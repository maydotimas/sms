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

Route::get('/php', function () {
    return phpinfo();
});

Route::group(['middleware' => 'web'], function () {
    Route::get(env('LARAVUE_PATH'), 'LaravueController@index')->where('any', '.*')->name('laravue');
});

Route::get('token', function () {
//    $key = "IUGB0JbyAoiWzHKgrcwaHw8oGYoqQdbA";
//    $secret = "3eNCCPpJiulCNz8aX9FEe0VC7FacJwZJjzGtA0JbQ3IzeYPQJn1kJZALHy9nHJfT";
        $key = "H2D5mqGenZxwcwMlfp7GGOweeiVlSVbV";
    $secret = "AEbPwXDeoRxPsqIH3zJ6uOzhWD9gwzDdyAyKCuHINATL4MRqCwGLkx0REVsa6JNM";
    echo base64_encode("{$key}:{$secret}");
});
