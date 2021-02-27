<?php

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function () {

    Route::group(['prefix' => 'admin', 'namespace' => 'Dashboard', 'middleware' => 'auth:admin'], function () {

        Route::get('/', 'DashboardController@index')->name('admin.dashboard');
        Route::group(['prefix' => 'setting'], function () {

            Route::get('/shipping-methods/{type}', 'SettingsController@editShippingMethods')->name('edit.shippings.methods');
            Route::put('/shipping-methods/{id}', 'SettingsController@updateShippingMethods')->name('update.shippings.methods');
        });
    });
//    'middleware' => 'guest:admin'
    Route::group(['prefix' => 'admin', 'namespace' => 'Dashboard', ], function () {

        Route::get('/login', 'LoginController@login')->name('admin.login');
        Route::post('/login', 'LoginController@postLogin')->name('admin.post.login');

    });
});
