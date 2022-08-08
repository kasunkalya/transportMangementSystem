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
    Route::group(['prefix' => 'transportDocument', 'namespace' => 'Sammy\TransportDocument\Http\Controllers'], function(){
      /**
       * GET Routes
       */

      Route::get('add', [
        'as' => 'add', 'uses' => 'TransportDocumentController@addView'
      ]);
      Route::get('edit/{id}', [
        'as' => 'edit', 'uses' => 'TransportDocumentController@editView'
      ]);
      
      Route::get('view/{id}', [
        'as' => 'view', 'uses' => 'TransportDocumentController@viewView'
      ]);

      Route::get('list', [
        'as' => 'list', 'uses' => 'TransportDocumentController@listView'
      ]);

      Route::get('json/list', [
        'as' => 'Chargin.list', 'uses' => 'TransportDocumentController@jsonList'
      ]);
	  

	  Route::get('pdf', [
        'as' => 'pdf', 'uses' => 'TransportDocumentController@createPDF'
      ]);
	  
	  
      /**
       * POST Routes
       */
      Route::post('add', [
        'as' => 'add', 'uses' => 'TransportDocumentController@add'
      ]);
      Route::post('edit/{id}', [
        'as' => 'Customer.edit', 'uses' => 'TransportDocumentController@edit'  // Not Implemented Yet
      ]);
      Route::post('delete', [
        'as' => 'Customer.delete', 'uses' => 'TransportDocumentController@delete'
      ]);
	  
	  
	  
	  
    });
});