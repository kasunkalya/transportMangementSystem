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
    Route::group(['prefix' => 'transportRoute', 'namespace' => 'Sammy\TransportRoute\Http\Controllers'], function(){
      /**
       * GET Routes
       */
      Route::get('add', [
        'as' => 'add', 'uses' => 'TransportRouteController@addView'
      ]);
      Route::get('edit/{id}', [
        'as' => 'edit', 'uses' => 'TransportRouteController@editView'
      ]);
      
      Route::get('view/{id}', [
        'as' => 'edit', 'uses' => 'TransportRouteController@viewView'
      ]);

      Route::get('list', [
        'as' => 'list', 'uses' => 'TransportRouteController@listView'
      ]);

      Route::get('json/list', [
        'as' => 'TransportRoute.list', 'uses' => 'TransportRouteController@jsonList'
      ]);

      Route::get('api/list', [
        'as' => 'permission.api.list', 'uses' => 'PermissionController@apiList'
      ]);

      /**
       * POST Routes
       */
      Route::post('add', [
        'as' => 'add', 'uses' => 'TransportRouteController@add'
      ]);
      Route::post('edit/{id}', [
        'as' => 'Route.edit', 'uses' => 'TransportRouteController@edit' 
      ]);

      Route::post('delete', [
        'as' => 'Route.delete', 'uses' => 'TransportRouteController@delete'
      ]);
    });
});