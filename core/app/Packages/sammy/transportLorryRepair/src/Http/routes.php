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
    Route::group(['prefix' => 'transportLorryRepair', 'namespace' => 'Sammy\TransportLorryRepair\Http\Controllers'], function(){
      /**
       * GET Routes
       */
      Route::get('add', [
        'as' => 'add', 'uses' => 'TransportLorryRepairController@addView'
      ]);
      Route::get('edit/{id}', [
        'as' => 'edit', 'uses' => 'TransportLorryRepairController@editView'
      ]);
	  
      Route::get('view/{id}', [
        'as' => 'view', 'uses' => 'TransportLorryRepairController@viewView'
      ]);
      
      Route::get('list', [
        'as' => 'list', 'uses' => 'TransportLorryRepairController@listView'
      ]);
      Route::get('json/list', [
        'as' => 'lorryRepair.list', 'uses' => 'TransportLorryRepairController@jsonList'
      ]);     
  

      /**
       * POST Routes
       */
      Route::post('add', [
        'as' => 'add', 'uses' => 'TransportLorryRepairController@add'
      ]);
      Route::post('edit/{id}', [
        'as' => 'lorryRepair.edit', 'uses' => 'TransportLorryRepairController@edit' 
      ]);

      Route::post('delete', [
        'as' => 'lorryRepair.delete', 'uses' => 'TransportLorryRepairController@delete'
      ]);
    });
});