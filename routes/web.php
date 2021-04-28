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
Route::get('karyawan/{karyawan}/edit', 'KaryawanController@edit')->name('karyawan.edit');
// Route::post('karyawan', 'KaryawanController@store')->name('karyawan.store');
Route::post('karyawan/{karyawan}', 'KaryawanController@storeData')->name('karyawan.storeData');
// Route::patch('karyawan/{karyawan}', 'KaryawanController@update')->name('karyawan.update');
Route::delete('karyawan/{karyawan}','KaryawanController@destroy')->name('karyawan.destroy');
