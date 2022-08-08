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
    Route::group(['prefix' => 'transportLorryFule', 'namespace' => 'Sammy\TransportLorryFule\Http\Controllers'], function(){
      /**
       * GET Routes
       */
      Route::get('add', [
        'as' => 'add', 'uses' => 'TransportLorryFuleController@addView'
      ]);
      Route::get('edit/{id}', [
        'as' => 'edit', 'uses' => 'TransportLorryFuleController@editView'
      ]);
	  
      Route::get('view/{id}', [
        'as' => 'view', 'uses' => 'TransportLorryFuleController@viewView'
      ]);
      
      Route::get('list', [
        'as' => 'list', 'uses' => 'TransportLorryFuleController@listView'
      ]);
      Route::get('json/list', [
        'as' => 'lorryRepair.list', 'uses' => 'TransportLorryFuleController@jsonList'
      ]);     
  
      Route::get('addInvoice', [
        'as' => 'addInvoice', 'uses' => 'TransportLorryFuleController@addInvoiceView'
      ]);
      
      Route::get('json/fulesearchlist/{type}/{fromDate}/{toDate}/{lorry}/{serviceValue}', [
        'as' => 'lorryRepair.list', 'uses' => 'TransportLorryFuleController@jsonfulesearchlist'
      ]);  
      
      Route::get('createInvoice/{id}/{customer}', [
        'as' => 'createInvoice', 'uses' => 'TransportLorryFuleController@createInvoice'
      ]);

      Route::get('printpdf/{id}', [ 
          'as' => 'customer.printpdf', 'uses' => 'TransportLorryFuleController@printPDF'
      ]);
      
      Route::get('viewInvoice', [
        'as' => 'viewInvoice', 'uses' => 'TransportLorryFuleController@viewInvoiceView'
      ]);
      
      Route::get('json/fuleInvoicesearchlist/{fromDate}/{toDate}/{serviceValue}', [
        'as' => 'lorryRepair.list', 'uses' => 'TransportLorryFuleController@jsonfuleInvoiceSearchlist'
      ]);  
      
      /**
       * POST Routes
       */
      Route::post('add', [
        'as' => 'add', 'uses' => 'TransportLorryFuleController@add'
      ]);
      Route::post('edit/{id}', [
        'as' => 'lorryRepair.edit', 'uses' => 'TransportLorryFuleController@edit' 
      ]);

      Route::post('delete', [
        'as' => 'lorryRepair.delete', 'uses' => 'TransportLorryFuleController@delete'
      ]);
    });
});