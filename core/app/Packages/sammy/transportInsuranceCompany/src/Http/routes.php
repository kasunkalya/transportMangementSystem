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
    Route::group(['prefix' => 'transportInsuranceCompany', 'namespace' => 'Sammy\TransportInsuranceCompany\Http\Controllers'], function(){
      /**
       * GET Routes
       */
      Route::get('add', [
        'as' => 'add', 'uses' => 'TransportInsuranceCompanyController@addView'
      ]);
      Route::get('edit/{id}', [
        'as' => 'edit', 'uses' => 'TransportInsuranceCompanyController@editView'
      ]);
      
	   Route::get('view/{id}', [
        'as' => 'view', 'uses' => 'TransportInsuranceCompanyController@viewView'
      ]);
	  
	  
      Route::get('isadd/{name}', [
        'as' => 'edit', 'uses' => 'TransportInsuranceCompanyController@isAddLeasingcompany'
      ]);

      Route::get('list', [
        'as' => 'list', 'uses' => 'TransportInsuranceCompanyController@listView'
      ]);

      Route::get('json/list', [
        'as' => 'TransportRoute.list', 'uses' => 'TransportInsuranceCompanyController@jsonList'
      ]);

      Route::get('api/list', [
        'as' => 'permission.api.list', 'uses' => 'PermissionController@apiList'
      ]);

      /**
       * POST Routes
       */
      Route::post('add', [
        'as' => 'add', 'uses' => 'TransportInsuranceCompanyController@add'
      ]);
      Route::post('edit/{id}', [
        'as' => 'company.edit', 'uses' => 'TransportInsuranceCompanyController@edit'  // Not Implemented Yet
      ]);


      Route::post('delete', [
        'as' => 'company.delete', 'uses' => 'TransportInsuranceCompanyController@delete'
      ]);
    });
});