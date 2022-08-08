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
    Route::group(['prefix' => 'transportEmployee', 'namespace' => 'Sammy\TransportEmployee\Http\Controllers'], function(){
      /**
       * GET Routes
       */
      Route::get('add', [
        'as' => 'add', 'uses' => 'TransportEmployeeController@addView'
      ]);
      Route::get('edit/{id}', [
        'as' => 'edit', 'uses' => 'TransportEmployeeController@editView'
      ]);

	  Route::get('view/{id}', [
        'as' => 'view', 'uses' => 'TransportEmployeeController@viewView'
      ]);
	  
      Route::get('list', [
        'as' => 'list', 'uses' => 'TransportEmployeeController@listView'
      ]);

      Route::get('json/list', [
        'as' => 'TransportRoute.list', 'uses' => 'TransportEmployeeController@jsonList'
      ]);

      Route::get('api/list', [
        'as' => 'permission.api.list', 'uses' => 'PermissionController@apiList'
      ]);

      /**
       * POST Routes
       */
      Route::post('add', [
        'as' => 'add', 'uses' => 'TransportEmployeeController@add'
      ]);
      Route::post('edit/{id}', [
        'as' => 'Employee.edit', 'uses' => 'TransportEmployeeController@edit'  // Not Implemented Yet
      ]);

      Route::post('delete', [
        'as' => 'Employee.delete', 'uses' => 'TransportEmployeeController@delete'
      ]);
    });
});