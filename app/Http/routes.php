<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::auth();

Route::get('/', 'ContactsController@index')->name('index');
Route::get('/favorite', 'ContactsController@favorite')->name('favorite');
Route::get('/create', 'ContactsController@create')->name('create');
Route::post('/', 'ContactsController@store')->name('store');
Route::get('/{id}', 'ContactsController@show')->name('show');
Route::get('/{id}/edit', 'ContactsController@edit')->name('edit');
Route::put('/{id}', 'ContactsController@update')->name('update');
Route::delete('/{id}', 'ContactsController@destroy')->name('delete');
Route::post('/changeFavorite', 'ContactsController@changeFavorite')->name('changeFavorite');