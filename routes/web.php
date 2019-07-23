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


Route::redirect('/index', '/index/fr');
Route::get('/index/{language}', 'dashbordController@choiceLang');

Route::redirect('/dashbord', '/dashbord/fr');

Route::get('/add', 'dashbordController@add');
Route::post('/addQuestion', 'dashbordController@addQuestion');

Route::get('/dashbord/{id}/delete', 'dashbordController@delete');

Route::get('/dashbord/{id}/edit', 'dashbordController@edit');
Route::patch('/dashbord/{id}/update', 'dashbordController@update');

Route::post('/select', 'dashbordController@select');

Route::any('/analysis', 'dashbordController@analysis');

Route::get('/insertViewSatisfied', 'dashbordController@insertSatisfied');
Route::get('/insertALittleSatisfied', 'dashbordController@insertALittleSatisfied');
Route::get('/insertUnsatisfied', 'dashbordController@insertUnsatisfied');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashbord/{language}','HomeController@dashbord');

Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');