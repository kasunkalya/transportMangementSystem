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
    Route::group(['prefix' => 'transportCustomer', 'namespace' => 'Sammy\TransportCustomer\Http\Controllers'], function(){
      /**
       * GET Routes
       */

      Route::get('add', [
        'as' => 'add', 'uses' => 'TransportCustomerController@addView'
      ]);
      Route::get('edit/{id}', [
        'as' => 'edit', 'uses' => 'TransportCustomerController@editView'
      ]);
      
      Route::get('view/{id}', [
        'as' => 'view', 'uses' => 'TransportCustomerController@viewView'
      ]);

      Route::get('list', [
        'as' => 'list', 'uses' => 'TransportCustomerController@listView'
      ]);

      Route::get('json/list', [
        'as' => 'Chargin.list', 'uses' => 'TransportCustomerController@jsonList'
      ]);


      /**
       * POST Routes
       */
      Route::post('add', [
        'as' => 'add', 'uses' => 'TransportCustomerController@add'
      ]);
      Route::post('edit/{id}', [
        'as' => 'Customer.edit', 'uses' => 'TransportCustomerController@edit'  // Not Implemented Yet
      ]);
      Route::post('delete', [
        'as' => 'Customer.delete', 'uses' => 'TransportCustomerController@delete'
      ]);
    });
});