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
    Route::group(['prefix' => 'transportCompany', 'namespace' => 'Sammy\TransportCompany\Http\Controllers'], function(){
      /**
       * GET Routes
       */
      Route::get('add', [
        'as' => 'add', 'uses' => 'TransportCompanyController@addView'
      ]);
      Route::get('edit/{id}', [
        'as' => 'edit', 'uses' => 'TransportCompanyController@editView'
      ]);
      
      Route::get('view/{id}', [
        'as' => 'edit', 'uses' => 'TransportCompanyController@viewView'
      ]);

      Route::get('list', [
        'as' => 'list', 'uses' => 'TransportCompanyController@listView'
      ]);

      Route::get('json/list', [
        'as' => 'TransportRoute.list', 'uses' => 'TransportCompanyController@jsonList'
      ]);

      Route::get('api/list', [
        'as' => 'permission.api.list', 'uses' => 'PermissionController@apiList'
      ]);

      /**
       * POST Routes
       */
      Route::post('add', [
        'as' => 'add', 'uses' => 'TransportCompanyController@add'
      ]);
      Route::post('edit/{id}', [
        'as' => 'company.edit', 'uses' => 'TransportCompanyController@edit'  // Not Implemented Yet
      ]);


      Route::post('delete', [
        'as' => 'company.delete', 'uses' => 'TransportCompanyController@delete'
      ]);
    });
});