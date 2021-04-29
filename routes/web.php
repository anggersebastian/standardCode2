<?php

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

Route::get('karyawan', 'KaryawanController@index')->name('karyawan.index');
Route::get('karyawan/create', 'KaryawanController@formKaryawan')->name('karyawan.form');
Route::get('karyawan/edit/{id?}', 'KaryawanController@formKaryawan')->name('karyawan.edit');
Route::post('karyawan/create/{id?}', 'KaryawanController@storeData')->name('karyawan.storeData');
Route::delete('karyawan/{id?}','KaryawanController@destroy')->name('karyawan.destroy');

// Route::group(['prefix' => 'karyawan', 'as' => 'karyawan', 'namespace' => 'karyawan'], function () {
//     Route::get('/', 'KaryawanController@index')->name('karyawan.index');
//     Route::get('/create', 'KaryawanController@formKaryawan')->name('karyawan.form');
//     Route::post('/create/{id?}', 'KaryawanController@storeData')->name('karyawan.storeData');
//     Route::delete('/{id?}','KaryawanController@destroy')->name('karyawan.destroy');
//     Route::get('/edit/{id?}', 'KaryawanController@formKaryawan')->name('karyawan.edit');
// });