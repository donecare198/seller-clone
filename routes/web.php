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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/home', 'HomeController@index');

Route::get('/redirect','LoginController@redirect');

Route::get('/callback','LoginController@callback');

Route::get('/logout','LoginController@logout');

Route::group(['prefix'=>'api'],function(){
   Route::get('/me','ApiController@me');
   
   Route::get('/loadConfig','ApiController@loadConfig');
   
   Route::post('/install','ApiController@install');
   
   Route::get('/getViplikeID','ApiController@getViplikeID');
   
   Route::get('/updateClone','agentApiController@updateClone');
   
   Route::get('/testSub','agentApiController@testSub');
   
   Route::get('/DoVipLike2','agentApiController@DoVipLike2');
   
   Route::get('/DoVipLike3','agentApiController@DoVipLike3');
   
   Route::post('/DoResult','agentApiController@DoResult');
   
   Route::get('/testLikePage','agentApiController@testLikePage');
   
   Route::get('/history','ApiController@history');
   
   Route::post('/naptien','TransactionController@naptien');
   
   Route::post('/addTransaction','TransactionController@addTransaction');
   
   Route::get('/getTransaction','TransactionController@getTransaction');
   
});



   
/////api agent
Route::get('/getViplikeID','agentApiController@ViplikeID');
Route::get('/upClone','agentApiController@upClone');
Route::get('/updateClone','agentApiController@updateClone');