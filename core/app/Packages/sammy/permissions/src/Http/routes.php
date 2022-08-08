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
    Route::group(['prefix' => 'permission', 'namespace' => 'Sammy\Permissions\Http\Controllers'], function(){
      /**
       * GET Routes
       */
      Route::get('add', [
        'as' => 'add', 'uses' => 'PermissionController@addView'
      ]);
      Route::get('edit/{id}', [
        'as' => 'menu.edit', 'uses' => 'PermissionController@editView'  
      ]);

      Route::get('list', [
        'as' => 'permission.list', 'uses' => 'PermissionController@listView'
      ]);

      Route::get('json/list', [
        'as' => 'permission.list', 'uses' => 'PermissionController@jsonList'
      ]);

      Route::get('api/list', [
        'as' => 'permission.api.list', 'uses' => 'PermissionController@apiList'
      ]);

      /**
       * POST Routes
       */
      Route::post('add', [
        'as' => 'add', 'uses' => 'PermissionController@add'
      ]);
      Route::post('edit/{id}', [
        'as' => 'menu.edit', 'uses' => 'PermissionController@edit'  // Not Implemented Yet
      ]);

      Route::post('status', [
        'as' => 'permission.status', 'uses' => 'PermissionController@status'
      ]);

      Route::post('delete', [
        'as' => 'permission.delete', 'uses' => 'PermissionController@delete'
      ]);
    });
});