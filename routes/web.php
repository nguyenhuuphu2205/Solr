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


Route::get('/','SolrController@trangchu');

Route::get('search','SolrController@search');
Route::get('thongke/{nam}/{thang}','SolrController@thongke');


