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
    Route::group(['prefix' => 'transportLeasingCompany', 'namespace' => 'Sammy\TransportLeasingCompany\Http\Controllers'], function(){
      /**
       * GET Routes
       */
      Route::get('add', [
        'as' => 'add', 'uses' => 'TransportLeasingCompanyController@addView'
      ]);
      Route::get('edit/{id}', [
        'as' => 'edit', 'uses' => 'TransportLeasingCompanyController@editView'
      ]);     
      Route::get('view/{id}', [
        'as' => 'edit', 'uses' => 'TransportLeasingCompanyController@viewView'
      ]);
      Route::get('isadd/{name}', [
        'as' => 'edit', 'uses' => 'TransportLeasingCompanyController@isAddLeasingcompany'
      ]);

      Route::get('list', [
        'as' => 'list', 'uses' => 'TransportLeasingCompanyController@listView'
      ]);

      Route::get('json/list', [
        'as' => 'TransportRoute.list', 'uses' => 'TransportLeasingCompanyController@jsonList'
      ]);

      Route::get('api/list', [
        'as' => 'permission.api.list', 'uses' => 'PermissionController@apiList'
      ]);

      /**
       * POST Routes
       */
      Route::post('add', [
        'as' => 'add', 'uses' => 'TransportLeasingCompanyController@add'
      ]);
      Route::post('edit/{id}', [
        'as' => 'company.edit', 'uses' => 'TransportLeasingCompanyController@edit'  // Not Implemented Yet
      ]);


      Route::post('delete', [
        'as' => 'company.delete', 'uses' => 'TransportLeasingCompanyController@delete'
      ]);
    });
});