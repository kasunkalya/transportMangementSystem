<?php
/**
 * PERMISSIONS MANAGEMENT ROUTES
 *
 * @version 1.0.0
 * @author Kasun Kalya <kasun.kalya@gmail.com>
 * @copyright 2015 Kasun Kalya
 */

/**
 * USER AUTHENTICATION MIDDLEWARE
 */
Route::group(['middleware' => ['auth']], function()
{
    Route::group(['prefix' => 'transportChargin', 'namespace' => 'Sammy\TransportChargin\Http\Controllers'], function(){
      /**
       * GET Routes
       */

      Route::get('add', [
        'as' => 'add', 'uses' => 'TransportCharginController@addView'
      ]);
      Route::get('edit/{id}', [
        'as' => 'edit', 'uses' => 'TransportCharginController@editView'
      ]);

      Route::get('list', [
        'as' => 'list', 'uses' => 'TransportCharginController@listView'
      ]);

      Route::get('json/list', [
        'as' => 'TransportRoute.list', 'uses' => 'TransportCharginController@jsonList'
      ]);


      /**
       * POST Routes
       */
      Route::post('add', [
        'as' => 'add', 'uses' => 'TransportCharginController@add'
      ]);
      Route::post('edit/{id}', [
        'as' => 'Chargin.edit', 'uses' => 'TransportCharginController@edit'  // Not Implemented Yet
      ]);
      Route::post('delete', [
        'as' => 'Chargin.delete', 'uses' => 'TransportCharginController@delete'
      ]);
    });
});