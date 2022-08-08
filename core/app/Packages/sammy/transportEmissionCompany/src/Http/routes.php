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
    Route::group(['prefix' => 'transportEmissionCompany', 'namespace' => 'Sammy\TransportEmissionCompany\Http\Controllers'], function(){
      /**
       * GET Routes
       */
      Route::get('add', [
        'as' => 'add', 'uses' => 'TransportEmissionCompanyController@addView'
      ]);
      Route::get('edit/{id}', [
        'as' => 'edit', 'uses' => 'TransportEmissionCompanyController@editView'
      ]);

	   Route::get('view/{id}', [
        'as' => 'view', 'uses' => 'TransportEmissionCompanyController@viewView'
      ]);
	  
      Route::get('list', [
        'as' => 'list', 'uses' => 'TransportEmissionCompanyController@listView'
      ]);

      Route::get('isadd/{name}', [
        'as' => 'edit', 'uses' => 'TransportEmissionCompanyController@isAddLeasingcompany'
      ]);
      
      Route::get('json/list', [
        'as' => 'TransportRoute.list', 'uses' => 'TransportEmissionCompanyController@jsonList'
      ]);

      Route::get('api/list', [
        'as' => 'permission.api.list', 'uses' => 'PermissionController@apiList'
      ]);

      /**
       * POST Routes
       */
      Route::post('add', [
        'as' => 'add', 'uses' => 'TransportEmissionCompanyController@add'
      ]);
      Route::post('edit/{id}', [
        'as' => 'company.edit', 'uses' => 'TransportEmissionCompanyController@edit'  // Not Implemented Yet
      ]);


      Route::post('delete', [
        'as' => 'company.delete', 'uses' => 'TransportEmissionCompanyController@delete'
      ]);
    });
});