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
    return view('index');
});

Route::get('/download/comic/get-list-collect', ['as' => 'getListCollect', 'uses' => 'DownloadComicController@getListCollect']);
Route::post('/download/comic/download-chap', ['as' => 'downloadChap', 'uses' => 'DownloadComicController@downloadChap']);
