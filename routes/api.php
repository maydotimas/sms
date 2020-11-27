<?php

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Laravue\Faker;
use \App\Laravue\JsonResponse;
use \App\Laravue\Acl;

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

Route::namespace('Api')->group(function() {
    Route::post('auth/login', 'AuthController@login');
    Route::group(['middleware' => 'auth:sanctum'], function () {
        // Auth routes
        Route::get('auth/user', 'AuthController@user');
        Route::post('auth/logout', 'AuthController@logout');

        Route::get('/user', function (Request $request) {
            return new UserResource($request->user());
        });

        // Api resource routes
        Route::apiResource('roles', 'RoleController')->middleware('permission:' . Acl::PERMISSION_PERMISSION_MANAGE);
        Route::apiResource('users', 'UserController')->middleware('permission:' . Acl::PERMISSION_USER_MANAGE);
        Route::apiResource('permissions', 'PermissionController')->middleware('permission:' . Acl::PERMISSION_PERMISSION_MANAGE);

        // Custom routes
        Route::put('users/{user}', 'UserController@update');
        Route::get('users/{user}/permissions', 'UserController@permissions')->middleware('permission:' . Acl::PERMISSION_PERMISSION_MANAGE);
        Route::put('users/{user}/permissions', 'UserController@updatePermissions')->middleware('permission:' .Acl::PERMISSION_PERMISSION_MANAGE);
        Route::get('roles/{role}/permissions', 'RoleController@permissions')->middleware('permission:' . Acl::PERMISSION_PERMISSION_MANAGE);



    });
});

// All api requests to categories need "manage category" permission
Route::apiResource('categories', 'CategoryController')->middleware('permission:manage category');
// Listing category will require "view category" or "manage category"
Route::get('categories', 'CategoryController@index')->name('categories.index')->middleware('permission:view category|manage category');

Route::apiResource('departments', 'DepartmentController')->middleware('permission:manage department');
Route::get('departments', 'DepartmentController@index')->name('departments.index')->middleware('permission:view department|manage department');

Route::apiResource('gradeLevels', 'GradeLevelController')->middleware('permission:manage gradelevel');
Route::get('gradeLevels', 'GradeLevelController@index')->name('gradeLevels.index')->middleware('permission:view gradelevel|manage gradelevel');

Route::apiResource('sections', 'SectionController')->middleware('permission:manage section');
Route::get('sections', 'SectionController@index')->name('sections.index')->middleware('permission:view section|manage section');

Route::apiResource('subjects', 'SubjectController')->middleware('permission:manage subject');
Route::get('subjects', 'SubjectController@index')->name('subjects.index')->middleware('permission:view subject|permission:manage subject');

Route::apiResource('fees', 'FeeController')->middleware('permission:manage fee');
Route::get('fees', 'FeeController@index')->name('fees.index')->middleware('permission:view fee|permission:manage fee');

Route::apiResource('subFees', 'SubFeeController')->middleware('permission:manage subfee');
Route::get('subFees', 'SubFeeController@index')->name('subfees.index')->middleware('permission:view fee|permission:manage subfee');

Route::apiResource('payment_modes', 'PaymentModeController')->middleware('permission:manage paymentmode');
Route::get('payment_modes', 'PaymentModeController@index')->name('paymentMode.index')->middleware('permission:view paymentmode|permission:manage paymentmode');

Route::apiResource('payment_mode_types', 'PaymentModeTypeController')->middleware('permission:manage paymentmodetype');
Route::get('payment_mode_types', 'PaymentModeTypeController@index')->name('paymentModeType.index')->middleware('permission:view paymentmodetype|permission:manage paymentmodetype');

Route::apiResource('students', 'StudentController')->middleware('permission:manage students');
Route::get('students', 'StudentController@index')->name('students.index')->middleware('permission:view students|permission:manage students');
Route::post('students/upload-avatar', 'StudentController@avatar')->name('students.avatar')->middleware('permission:view students|permission:manage students');

Route::apiResource('parents', 'StudentParentController')->middleware('permission:manage parents');
Route::get('parents', 'StudentParentController@index')->name('parents.index')->middleware('permission:view parents|permission:manage parents');

Route::post('parents/upload-avatar', 'StudentParentController@avatar')->name('parents.avatar')->middleware('permission:view parents|permission:manage parents');
Route::get('studentparents/autocomplete', 'StudentParentController@autocomplete')->name('parents.autocomplete')->middleware('permission:view parents|permission:manage parents');

Route::get('province', 'StudentParentController@index')->name('parents.index')->middleware('permission:view parents|permission:manage parents');
Route::get('city', 'StudentParentController@index')->name('parents.index')->middleware('permission:view parents|permission:manage parents');
Route::get('brgy', 'StudentParentController@index')->name('parents.index')->middleware('permission:view parents|permission:manage parents');

Route::get('province/autocomplete', 'ProvinceController@index');
Route::get('city/autocomplete', 'CityyController@index');
Route::get('barangay/autocomplete', 'BarangayController@index');

Route::apiResource('schoolYear', 'SchoolYearController')->middleware('permission:manage schoolyear');
Route::get('schoolYear', 'SchoolYearController@index')->name('schoolYears.index')->middleware('permission:view schoolyear|manage schoolyear');

Route::apiResource('reservation', 'ReservationController')->middleware('permission:manage reservation');
Route::get('reservation', 'ReservationController@index')->name('reservation.index')->middleware('permission:view reservation|manage reservation');
Route::post('reservations/upload-receipt', 'ReservationController@receipt')->name('reservation.receipt')->middleware('permission:view reservation|permission:manage reservation');

Route::apiResource('enrollment', 'EnrollmentController')->middleware('permission:manage enrollment');
Route::get('enrollment', 'EnrollmentController@index')->name('enrollment.index')->middleware('permission:view enrollment|manage enrollment');
Route::post('enrollments/upload-receipt', 'EnrollmentController@receipt')->name('enrollment.receipt')->middleware('permission:view enrollment|permission:manage enrollment');

// Fake APIs
Route::get('/table/list', function () {
    $rowsNumber = mt_rand(20, 30);
    $data = [];
    for ($rowIndex = 0; $rowIndex < $rowsNumber; $rowIndex++) {
        $row = [
            'author' => Faker::randomString(mt_rand(5, 10)),
            'display_time' => Faker::randomDateTime()->format('Y-m-d H:i:s'),
            'id' => mt_rand(100000, 100000000),
            'pageviews' => mt_rand(100, 10000),
            'status' => Faker::randomInArray(['deleted', 'published', 'draft']),
            'title' => Faker::randomString(mt_rand(20, 50)),
        ];

        $data[] = $row;
    }

    return response()->json(new JsonResponse(['items' => $data]));
});

Route::get('/orders', function () {
    $rowsNumber = 8;
    $data = [];
    for ($rowIndex = 0; $rowIndex < $rowsNumber; $rowIndex++) {
        $row = [
            'order_no' => 'LARAVUE' . mt_rand(1000000, 9999999),
            'price' => mt_rand(10000, 999999),
            'status' => Faker::randomInArray(['success', 'pending']),
        ];

        $data[] = $row;
    }

    return response()->json(new JsonResponse(['items' => $data]));
});

Route::get('/articles', function () {
    $rowsNumber = 10;
    $data = [];
    for ($rowIndex = 0; $rowIndex < $rowsNumber; $rowIndex++) {
        $row = [
            'id' => mt_rand(100, 10000),
            'display_time' => Faker::randomDateTime()->format('Y-m-d H:i:s'),
            'title' => Faker::randomString(mt_rand(20, 50)),
            'author' => Faker::randomString(mt_rand(5, 10)),
            'comment_disabled' => Faker::randomBoolean(),
            'content' => Faker::randomString(mt_rand(100, 300)),
            'content_short' => Faker::randomString(mt_rand(30, 50)),
            'status' => Faker::randomInArray(['deleted', 'published', 'draft']),
            'forecast' => mt_rand(100, 9999) / 100,
            'image_uri' => 'https://via.placeholder.com/400x300',
            'importance' => mt_rand(1, 3),
            'pageviews' => mt_rand(10000, 999999),
            'reviewer' => Faker::randomString(mt_rand(5, 10)),
            'timestamp' => Faker::randomDateTime()->getTimestamp(),
            'type' => Faker::randomInArray(['US', 'VI', 'JA']),

        ];

        $data[] = $row;
    }

    return response()->json(new JsonResponse(['items' => $data, 'total' => mt_rand(1000, 10000)]));
});

Route::get('articles/{id}', function ($id) {
    $article = [
        'id' => $id,
        'display_time' => Faker::randomDateTime()->format('Y-m-d H:i:s'),
        'title' => Faker::randomString(mt_rand(20, 50)),
        'author' => Faker::randomString(mt_rand(5, 10)),
        'comment_disabled' => Faker::randomBoolean(),
        'content' => Faker::randomString(mt_rand(100, 300)),
        'content_short' => Faker::randomString(mt_rand(30, 50)),
        'status' => Faker::randomInArray(['deleted', 'published', 'draft']),
        'forecast' => mt_rand(100, 9999) / 100,
        'image_uri' => 'https://via.placeholder.com/400x300',
        'importance' => mt_rand(1, 3),
        'pageviews' => mt_rand(10000, 999999),
        'reviewer' => Faker::randomString(mt_rand(5, 10)),
        'timestamp' => Faker::randomDateTime()->getTimestamp(),
        'type' => Faker::randomInArray(['US', 'VI', 'JA']),

    ];

    return response()->json(new JsonResponse($article));
});

Route::get('articles/{id}/pageviews', function ($id) {
    $pageviews = [
        'PC' => mt_rand(10000, 999999),
        'Mobile' => mt_rand(10000, 999999),
        'iOS' => mt_rand(10000, 999999),
        'android' => mt_rand(10000, 999999),
    ];
    $data = [];
    foreach ($pageviews as $device => $pageview) {
        $data[] = [
            'key' => $device,
            'pv' => $pageview,
        ];
    }

    return response()->json(new JsonResponse(['pvData' => $data]));
});
