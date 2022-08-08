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
    Route::group(['prefix' => 'transportSupplier', 'namespace' => 'Sammy\TransportSupplier\Http\Controllers'], function(){
      /**
       * GET Routes
       */

      Route::get('add', [
        'as' => 'add', 'uses' => 'TransportSupplierController@addView'
      ]);
      Route::get('edit/{id}', [
        'as' => 'edit', 'uses' => 'TransportSupplierController@editView'
      ]);
      
      Route::get('view/{id}', [
        'as' => 'view', 'uses' => 'TransportSupplierController@viewView'
      ]);

      Route::get('list', [
        'as' => 'list', 'uses' => 'TransportSupplierController@listView'
      ]);

      Route::get('json/list', [
        'as' => 'Chargin.list', 'uses' => 'TransportSupplierController@jsonList'
      ]);


      /**
       * POST Routes
       */
      Route::post('add', [
        'as' => 'add', 'uses' => 'TransportSupplierController@add'
      ]);
      Route::post('edit/{id}', [
        'as' => 'Customer.edit', 'uses' => 'TransportSupplierController@edit'  // Not Implemented Yet
      ]);
      Route::post('delete', [
        'as' => 'Customer.delete', 'uses' => 'TransportSupplierController@delete'
      ]);
    });
});