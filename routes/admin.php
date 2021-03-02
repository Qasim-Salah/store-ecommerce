<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


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
        Route::get('/logout', 'LoginController@logout')->name('admin.logout');

        Route::group(['prefix' => 'setting'], function () {

            Route::get('shipping-methods/{type}', 'SettingsController@editShippingMethods')->name('edit.shippings.methods');
            Route::put('shipping-methods/{id}', 'SettingsController@updateShippingMethods')->name('update.shippings.methods');
        });
        Route::group(['prefix' => 'profile'], function () {
            Route::get('edit', 'ProfileController@edit')->name('edit.profile');
            Route::put('update', 'ProfileController@update')->name('update.profile');
        });
        ################################## categories routes ######################################
        Route::group(['prefix' => 'main_categories'], function () {
            Route::get('/', 'MainCategoriesController@index')->name('admin.mainCategories');
            Route::get('create', 'MainCategoriesController@create')->name('admin.mainCategories.create');
            Route::post('store', 'MainCategoriesController@store')->name('admin.mainCategories.store');
            Route::get('edit/{id}', 'MainCategoriesController@edit')->name('admin.mainCategories.edit');
            Route::post('update/{id}', 'MainCategoriesController@update')->name('admin.mainCategories.update');
            Route::get('delete/{id}', 'MainCategoriesController@destroy')->name('admin.mainCategories.delete');
        });

        ################################## end categories    #######################################

        ################################## sub categories routes ######################################
        Route::group(['prefix' => 'sub_categories'], function () {
            Route::get('/', 'SubCategoriesController@index')->name('admin.subCategories');
            Route::get('create', 'SubCategoriesController@create')->name('admin.subCategories.create');
            Route::post('store', 'SubCategoriesController@store')->name('admin.subCategories.store');
            Route::get('edit/{id}', 'SubCategoriesController@edit')->name('admin.subCategories.edit');
            Route::post('update/{id}', 'SubCategoriesController@update')->name('admin.subCategories.update');
            Route::get('delete/{id}', 'SubCategoriesController@destroy')->name('admin.subCategories.delete');
        });
    });
//    'middleware' => 'guest:admin'
    Route::group(['prefix' => 'admin', 'namespace' => 'Dashboard',], function () {

        Route::get('/login', 'LoginController@login')->name('admin.login');
        Route::post('/login', 'LoginController@postLogin')->name('admin.post.login');

    });
});
