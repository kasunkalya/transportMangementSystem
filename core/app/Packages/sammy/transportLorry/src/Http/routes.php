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
    Route::group(['prefix' => 'transportLorry', 'namespace' => 'Sammy\TransportLorry\Http\Controllers'], function(){
      /**
       * GET Routes
       */
      Route::get('add', [
        'as' => 'add', 'uses' => 'TransportLorryController@addView'
      ]);
      
      Route::get('addMilage', [
        'as' => 'add', 'uses' => 'TransportLorryController@milageAddView'
      ]);
      
      Route::get('edit/{id}', [
        'as' => 'edit', 'uses' => 'TransportLorryController@editView'
      ]);
      
      Route::get('pay/{id}', [
        'as' => 'edit', 'uses' => 'TransportLorryController@paymentView'
      ]);
      
      Route::get('view/{id}', [
        'as' => 'edit', 'uses' => 'TransportLorryController@viewView'
      ]);

      Route::get('list', [
        'as' => 'list', 'uses' => 'TransportLorryController@listView'
      ]);

      Route::get('json/list', [
        'as' => 'TransportRoute.list', 'uses' => 'TransportLorryController@jsonList'
      ]);
      
       Route::get('json/lorryexpireList', [
        'as' => 'TransportRoute.list', 'uses' => 'TransportLorryController@jsonLorryexpireList'
      ]);
      
      Route::get('json/modellist/{id}', [
        'as' => 'TransportLorry.modellist', 'uses' => 'TransportLorryController@getModel'
      ]);
      
      Route::get('json/paymentRulelist/{id}', [
        'as' => 'TransportLorry.paymentRulelist', 'uses' => 'TransportLorryController@getRulelist'
      ]);
      
      
      Route::get('summaryView', [
        'as' => 'edit', 'uses' => 'TransportLorryController@summaryView'
      ]);
           
      
       Route::get('summaryDraftView', [
        'as' => 'edit', 'uses' => 'TransportLorryController@summaryDraftView'
      ]);
           

      Route::get('api/list', [
        'as' => 'permission.api.list', 'uses' => 'PermissionController@apiList'
      ]);
      
      Route::get('milagelist', [
        'as' => 'list', 'uses' => 'TransportLorryController@milagelistView'
      ]);

      Route::get('json/milagelist', [
        'as' => 'TransportRoute.list', 'uses' => 'TransportLorryController@jsonmilageList'
      ]);
      Route::get('milageedit/{id}', [
        'as' => 'lorry.edit', 'uses' => 'TransportLorryController@milageeditView' 
      ]);
      
      Route::get('json/milageeditlist/{date}', [
        'as' => 'TransportRoute.list', 'uses' => 'TransportLorryController@jsonmilageeditList'
      ]);
      
       Route::get('json/milageviewlist/{date}', [
        'as' => 'TransportRoute.list', 'uses' => 'TransportLorryController@jsonmilageviewList'
      ]);
       
      Route::get('milageview/{id}', [
        'as' => 'lorry.edit', 'uses' => 'TransportLorryController@milageviewView' 
      ]);
      
      Route::get('json/summaysearchlist/{fromDate}/{toDate}', [
        'as' => 'TransportManagement.list', 'uses' => 'TransportLorryController@jsonsummaySearchList'
      ]);
      
      Route::get('json/summayDaily/{fromDate}/{toDate}', [
        'as' => 'TransportManagement.list', 'uses' => 'TransportLorryController@jsonsummayDate'
      ]);
      
      /**
       * POST Routes
       */
      Route::post('add', [
        'as' => 'add', 'uses' => 'TransportLorryController@add'
      ]);
      Route::post('edit/{id}', [
        'as' => 'lorry.edit', 'uses' => 'TransportLorryController@edit' 
      ]);
      
      Route::post('pay/{id}', [
        'as' => 'lorry.pay', 'uses' => 'TransportLorryController@pay' 
      ]);

      Route::post('delete', [
        'as' => 'lorry.delete', 'uses' => 'TransportLorryController@delete'
      ]);
      
      Route::post('deletemilage', [
        'as' => 'lorry.delete', 'uses' => 'TransportLorryController@deletemilage'
      ]);
      
      Route::post('addMilage', [
        'as' => 'add', 'uses' => 'TransportLorryController@milageAdd'
      ]);
      
      Route::post('milageedit/{id}', [
        'as' => 'add', 'uses' => 'TransportLorryController@milageEdit'
      ]);
      
      
      
      
      
    });
});