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
    Route::group(['prefix' => 'transportLogSheet', 'namespace' => 'Sammy\TransportLogSheet\Http\Controllers'], function(){
      /**
       * GET Routes
       */
      Route::get('add', [
        'as' => 'add', 'uses' => 'TransportLogSheetController@addView'
      ]);
      Route::get('edit/{id}', [
        'as' => 'edit', 'uses' => 'TransportLogSheetController@editView'
      ]);
	  
      Route::get('view/{id}', [
        'as' => 'view', 'uses' => 'TransportLogSheetController@viewView'
      ]);
      
      Route::get('list', [
        'as' => 'list', 'uses' => 'TransportLogSheetController@listView'
      ]);
      Route::get('json/list', [
        'as' => 'lorryRepair.list', 'uses' => 'TransportLogSheetController@jsonList'
      ]);    
      
      Route::get('json/logsheetlist/{lorry}/{trip}', [
        'as' => 'lorryRepair.list', 'uses' => 'TransportLogSheetController@jsongetlogsheetlist'
      ]);  
      
      
      /**
       * POST Routes
       */
      Route::post('add', [
        'as' => 'add', 'uses' => 'TransportLogSheetController@add'
      ]);
      Route::post('edit/{id}', [
        'as' => 'lorryRepair.edit', 'uses' => 'TransportLogSheetController@edit' 
      ]);

      Route::post('delete', [
        'as' => 'lorryRepair.delete', 'uses' => 'TransportLogSheetController@delete'
      ]);
    });
});