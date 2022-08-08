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
    Route::group(['prefix' => 'transportLorryMaintain', 'namespace' => 'Sammy\TransportLorryMaintain\Http\Controllers'], function(){
      /**
       * GET Routes
       */
      Route::get('add', [
        'as' => 'add', 'uses' => 'TransportLorryMaintainController@addView'
      ]);
      Route::get('edit/{id}', [
        'as' => 'edit', 'uses' => 'TransportLorryMaintainController@editView'
      ]);
	  
      Route::get('list', [
        'as' => 'list', 'uses' => 'TransportLorryMaintainController@listView'
      ]);
      
      Route::get('json/list', [
        'as' => 'TransportLorryMaintain.list', 'uses' => 'TransportLorryMaintainController@jsonList'
      ]);  
      
      Route::get('json/expirelist', [
        'as' => 'TransportLorryMaintain.list', 'uses' => 'TransportLorryMaintainController@jsonexpireList'
      ]);  
      
        Route::get('json/expireExeedlist', [
        'as' => 'TransportLorryMaintain.list', 'uses' => 'TransportLorryMaintainController@jsonexpireExeedList'
      ]);  
      
      Route::get('view/{id}', [
        'as' => 'edit', 'uses' => 'TransportLorryMaintainController@viewView'
      ]);

      /**
       * POST Routes
       */
      Route::post('add', [
        'as' => 'add', 'uses' => 'TransportLorryMaintainController@add'
      ]);
      Route::post('edit/{id}', [
        'as' => 'lorryMaintain.edit', 'uses' => 'TransportLorryMaintainController@edit' 
      ]);

      Route::post('delete', [
        'as' => 'lorryMaintain.delete', 'uses' => 'TransportLorryMaintainController@delete'
      ]);
    });
});