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

Route::get('/', 'SiteController@home');
Route::get('/about', 'SiteController@about');


Route::get('/login', 'AuthController@login')->name('login');
Route::post('/postlogin', 'AuthController@postlogin');
Route::get('/logout', 'AuthController@logout');

Route::group(['middleware' => ['auth', 'checkRole:admin']], function() {
    Route::get('/siswa/exportexcel', 'SiswaController@exportExcel');
    Route::get('/siswa/exportpdf', 'SiswaController@exportPdf');
    Route::get('/siswa/export', 'SiswaController@export');
    Route::resource('/siswa', 'SiswaController');
    Route::get('/siswa/{siswa}/delete', 'SiswaController@delete');
    Route::get('/siswa/{siswa}/profile', 'SiswaController@profile')->name('siswa.profile');
    Route::post('/siswa/{siswa}/addnilai', 'SiswaController@addnilai')->name('siswa.addnilai');
    Route::get('/siswa/{siswa}/{idmapel}/deletenilai', 'SiswaController@deletenilai');
    Route::get('/guru/{id}/profile', 'GuruController@profile');
});

Route::group(['middleware' => ['auth', 'checkRole:admin,siswa']], function() {
    Route::get('/dashboard', 'DashboardController@index');
});