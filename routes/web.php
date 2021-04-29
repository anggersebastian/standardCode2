<?php

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'karyawan', 'as' => 'karyawan'], function () {
    Route::get('', 'KaryawanController@index')->name('karyawan.index');
    Route::get('/create', 'KaryawanController@formKaryawan')->name('karyawan.form');
    Route::post('/create/{id?}', 'KaryawanController@storeData')->name('karyawan.storeData');
    Route::get('/edit/{id?}', 'KaryawanController@formKaryawan')->name('karyawan.edit');
    Route::delete('/{id?}','KaryawanController@destroy')->name('karyawan.destroy');
    
});