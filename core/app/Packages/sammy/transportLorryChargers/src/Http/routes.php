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
    Route::group(['prefix' => 'transportLorryChargers', 'namespace' => 'Sammy\TransportLorryChargers\Http\Controllers'], function(){
      /**
       * GET Routes
       */
      Route::get('add', [
        'as' => 'add', 'uses' => 'TransportLorryChargersController@addView'
      ]);
      Route::get('edit/{id}', [
        'as' => 'edit', 'uses' => 'TransportLorryChargersController@editView'
      ]);
      
      Route::get('view/{id}', [
        'as' => 'view', 'uses' => 'TransportLorryChargersController@viewView'
      ]);
      
	  
      Route::get('list', [
        'as' => 'list', 'uses' => 'TransportLorryChargersController@listView'
      ]);
      Route::get('json/list', [
        'as' => 'lorryRepair.list', 'uses' => 'TransportLorryChargersController@jsonList'
      ]);     
  
      Route::get('isadd/{lorry}/{route}/{chargingType}/{chargers}', [
        'as' => 'edit', 'uses' => 'TransportLorryChargersController@isAddRule'
      ]);

      
      Route::get('json/categorylist/{id}', [
        'as' => 'TransportLorry.modellist', 'uses' => 'TransportLorryChargersController@getCategory'
      ]);
          
        
      /**
       * POST Routes
       */
      Route::post('add', [
        'as' => 'add', 'uses' => 'TransportLorryChargersController@add'
      ]);
      Route::post('edit/{id}', [
        'as' => 'lorryRepair.edit', 'uses' => 'TransportLorryChargersController@edit' 
      ]);

      Route::post('delete', [
        'as' => 'lorryRepair.delete', 'uses' => 'TransportLorryChargersController@delete'
      ]);
    });
});