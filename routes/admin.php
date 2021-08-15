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

        Route::group(['prefix' => 'setting', 'middleware' => 'can:setting'], function () {

            Route::get('shipping-methods/{type}', 'SettingsController@edit')->name('edit.shippings.methods');
            Route::put('shipping-methods/{id}', 'SettingsController@update')->name('update.shippings.methods');
        });
        Route::group(['prefix' => 'profile'], function () {
            Route::get('edit', 'ProfileController@edit')->name('edit.profile');
            Route::put('update', 'ProfileController@update')->name('update.profile');
        });
        ################################## categories routes ######################################
        Route::group(['prefix' => 'categories', 'middleware' => 'can:categories'], function () {
            Route::get('/', 'CategoriesController@index')->name('admin.Categories');
            Route::get('create', 'CategoriesController@create')->name('admin.Categories.create');
            Route::post('store', 'CategoriesController@store')->name('admin.Categories.store');
            Route::get('edit/{id}', 'CategoriesController@edit')->name('admin.Categories.edit');
            Route::put('update/{id}', 'CategoriesController@update')->name('admin.Categories.update');
            Route::get('delete/{id}', 'CategoriesController@destroy')->name('admin.Categories.delete');
        });

        ################################## end categories    #######################################

        ################################## brands routes ######################################
        Route::group(['prefix' => 'brands', 'middleware' => 'can:brands'], function () {
            Route::get('/', 'BrandsController@index')->name('admin.brands');
            Route::get('create', 'BrandsController@create')->name('admin.brands.create');
            Route::post('store', 'BrandsController@store')->name('admin.brands.store');
            Route::get('edit/{id}', 'BrandsController@edit')->name('admin.brands.edit');
            Route::post('update/{id}', 'BrandsController@update')->name('admin.brands.update');
            Route::get('delete/{id}', 'BrandsController@destroy')->name('admin.brands.delete');
        });
        ################################## end brands    #######################################

        ################################## Tags routes ######################################
        Route::group(['prefix' => 'tags', 'middleware' => 'can:tags'], function () {
            Route::get('/', 'TagsController@index')->name('admin.tags');
            Route::get('create', 'TagsController@create')->name('admin.tags.create');
            Route::post('store', 'TagsController@store')->name('admin.tags.store');
            Route::get('edit/{id}', 'TagsController@edit')->name('admin.tags.edit');
            Route::post('update/{id}', 'TagsController@update')->name('admin.tags.update');
            Route::get('delete/{id}', 'TagsController@destroy')->name('admin.tags.delete');
        });
        ################################## end brands    #######################################
        ################################## products routes ######################################
        Route::group(['prefix' => 'products', 'middleware' => 'can:products'], function () {
            Route::get('/', 'ProductsController@index')->name('admin.products');
            Route::get('general-information', 'ProductsController@create')->name('admin.products.general.create');
            Route::post('store-general-information', 'ProductsController@store')->name('admin.products.general.store');

            Route::get('price/{id}', 'ProductsController@getPrice')->name('admin.products.price');
            Route::post('price', 'ProductsController@saveProductPrice')->name('admin.products.price.store');

            Route::get('stock/{id}', 'ProductsController@getStock')->name('admin.products.stock');
            Route::post('stock', 'ProductsController@saveProductStock')->name('admin.products.stock.store');
        });
        ################################## end products    #######################################
        ################################## attributes routes ######################################
        Route::group(['prefix' => 'attributes', 'middleware' => 'can:attributes'], function () {
            Route::get('/', 'AttributesController@index')->name('admin.attributes');
            Route::get('create', 'AttributesController@create')->name('admin.attributes.create');
            Route::post('store', 'AttributesController@store')->name('admin.attributes.store');
            Route::get('delete/{id}', 'AttributesController@destroy')->name('admin.attributes.delete');
            Route::get('edit/{id}', 'AttributesController@edit')->name('admin.attributes.edit');
            Route::post('update/{id}', 'AttributesController@update')->name('admin.attributes.update');
        });
        ################################## end attributes    #######################################
        ################################## brands options ######################################
        Route::group(['prefix' => 'options', 'middleware' => 'can:options'], function () {
            Route::get('/', 'OptionsController@index')->name('admin.options');
            Route::get('create', 'OptionsController@create')->name('admin.options.create');
            Route::post('store', 'OptionsController@store')->name('admin.options.store');
            //Route::get('delete/{id}','OptionsController@destroy') -> name('admin.options.delete');
            Route::get('edit/{id}', 'OptionsController@edit')->name('admin.options.edit');
            Route::post('update/{id}', 'OptionsController@update')->name('admin.options.update');
        });
        ################################## end options    #######################################

        ################################## sliders ######################################
        Route::group(['prefix' => 'sliders', 'middleware' => 'can:sliders'], function () {
            Route::get('/', 'SliderController@index')->name('admin.sliders.create');
            Route::post('images', 'SliderController@store')->name('admin.sliders.images.store');
        });
        ################################## end sliders    #######################################
        ################################## roles ######################################
        Route::group(['prefix' => 'roles'], function () {
            Route::get('/', 'RolesController@index')->name('admin.roles.index');
            Route::get('create', 'RolesController@create')->name('admin.roles.create');
            Route::post('store', 'RolesController@store')->name('admin.roles.store');
            Route::get('/edit/{id}', 'RolesController@edit')->name('admin.roles.edit');
            Route::post('update/{id}', 'RolesController@update')->name('admin.roles.update');
        });
        ################################## end roles ######################################

        ######################################admin######################################
        Route::group(['prefix' => 'users', 'middleware' => 'can:users'], function () {
            Route::get('/', 'UsersController@index')->name('admin.users.index');
            Route::get('/create', 'UsersController@create')->name('admin.users.create');
            Route::post('/store', 'UsersController@store')->name('admin.users.store');
        });
        ######################################end admin######################################
    });
//    'middleware' => 'guest:admin'
    Route::group(['prefix' => 'admin', 'namespace' => 'Dashboard', ], function () {

        Route::get('/login', 'LoginController@login')->name('admin.login');
        Route::post('/login', 'LoginController@postLogin')->name('admin.post.login');

    });
});
