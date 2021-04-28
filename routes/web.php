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
    return view('home');
});


Route::get('/login', 'AuthController@login')->name('login');
Route::post('/postlogin', 'AuthController@postlogin');
Route::get('/logout', 'AuthController@logout');

Route::group(['middleware' => ['auth', 'checkRole:admin']], function() {
    Route::resource('/siswa', 'SiswaController');
    Route::get('/siswa/{id}/profile', 'SiswaController@profile')->name('siswa.profile');
    Route::post('/siswa/{id}/addnilai', 'SiswaController@addnilai')->name('siswa.addnilai');
    Route::get('/siswa/{id}/{idmapel}/deletenilai', 'SiswaController@deletenilai');
});

Route::group(['middleware' => ['auth', 'checkRole:admin,siswa']], function() {
    Route::get('/dashboard', 'DashboardController@index');
});