<?php

use Illuminate\Support\Facades\Auth;
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

//Route::get('/', function () {
//    return view('layouts.site');
//});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

#########start-authentication########ي
//Route::group(['prefix' => 'frontend', 'namespace' => 'Frontend\Auth'], function () {
//
//    Route::get('/login', 'LoginController@showLoginForm')->name('frontend.show_login_form');
//
//    Route::post('login', 'LoginController@login')->name('frontend.login');
//    Route::post('logout', 'LoginController@logout')->name('frontend.logout');
//    Route::get('register', 'RegisterController@showRegistrationForm')->name('frontend.show_register_form');
//    Route::post('register', 'RegisterController@register')->name('frontend.register');
//    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
//    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
//    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
//    Route::post('password/reset', 'ResetPasswordController@reset')->name('password.update');
//    Route::get('email/verify', 'VerificationController@show')->name('verification.notice');
//    Route::get('/email/verify/{id}/{hash}', 'VerificationController@verify')->name('verification.verify');
//    Route::post('email/resend', 'VerificationController@resend')->name('verification.resend');
//});

###########end-authentication#########
