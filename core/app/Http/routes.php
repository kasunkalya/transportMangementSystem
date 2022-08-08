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

/**
 * USER AUTHENTICATION MIDDLEWARE
 */
Route::group(['middleware' => ['auth']], function()
{
    Route::get('/', [
      'as' => 'index', 'uses' => 'WelcomeController@index'
    ]);

});

Route::get('user/login', [
  'as' => 'user.login', 'uses' => 'AuthController@loginView'
]);

Route::post('user/login', [
  'as' => 'user.login', 'uses' => 'AuthController@login'
]);

Route::get('user/logout', [
  'as' => 'user.logout', 'uses' => 'AuthController@logout'
]);

Route::get('test/test', 'WelcomeController@pending'); //This is test controller to test data...
Route::get('pdf-create/{id}/{layout}','PdfController@create');

/////////////////////////////////////////////////////////
//$arr = [['id'=>1],['id'=>2],['id'=>5],['id'=>8]];
