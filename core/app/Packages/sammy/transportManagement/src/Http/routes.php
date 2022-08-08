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
    Route::group(['prefix' => 'transportManagement', 'namespace' => 'Sammy\TransportManagement\Http\Controllers'], function(){
      /**
       * GET Routes
       */

        Route::get('add', [
          'as' => 'add', 'uses' => 'TransportManagementController@addView'
        ]);
        Route::get('edit/{id}', [
          'as' => 'edit', 'uses' => 'TransportManagementController@editView'
        ]);
	  
        Route::get('view/{id}', [
        'as' => 'view', 'uses' => 'TransportManagementController@viewView'
        ]);

        Route::get('list', [
          'as' => 'list', 'uses' => 'TransportManagementController@listView'
        ]);

      Route::get('json/list', [
        'as' => 'TransportManagement.list', 'uses' => 'TransportManagementController@jsonList'
      ]);
      
      Route::get('json/logsheetyransportlist/{logsheet}/{request}', [
        'as' => 'TransportManagement.list', 'uses' => 'TransportManagementController@jsonlogsheetList'
      ]);

      Route::get('json/customer/{id}', [
        'as' => 'TransportManagement.customerlist', 'uses' => 'TransportManagementController@getCustomer'
      ]);
     
      Route::get('json/getChargingRules/{lorry}/{route}/{chargingType}/{subCategoryValue}', [
        'as' => 'TransportManagement.chargingRules', 'uses' => 'TransportManagementController@getChargingType'
      ]);
      
       Route::get('json/getRutingRules/{route}', [
        'as' => 'TransportManagement.chargingRules', 'uses' => 'TransportManagementController@getRoutingType'
      ]);
      
      
      Route::get('json/dailylist', [
        'as' => 'TransportManagement.dailylist', 'uses' => 'TransportManagementController@jsonDailylist'
      ]);
      
      Route::get('json/contactperson/{id}', [
        'as' => 'TransportManagement.list', 'uses' => 'TransportManagementController@contactpersonList'
      ]);
      
      Route::get('addDriver', [
        'as' => 'addDriver', 'uses' => 'TransportManagementController@addDriverView'
      ]);
      
      Route::get('json/searchlist/{type}/{fromDate}/{toDate}/{lorry}/{invoiceNumber}', [
        'as' => 'TransportManagement.list', 'uses' => 'TransportManagementController@jsonSearchList'
      ]);

      Route::get('addDriverHelper/{id}/{driver}/{helper}', [
        'as' => 'addDriverHelper', 'uses' => 'TransportManagementController@addDriver'
      ]);
      
      Route::get('editDriver', [
        'as' => 'editDriver', 'uses' => 'TransportManagementController@editDriverView'
      ]);
      Route::get('json/editsearchlist/{type}/{fromDate}/{toDate}/{lorry}/{invoiceNumber}', [
        'as' => 'TransportManagement.list', 'uses' => 'TransportManagementController@jsonEditSearchList'
      ]);
        
      Route::get('addInvoice', [
        'as' => 'addInvoice', 'uses' => 'TransportManagementController@addInvoiceView'
      ]);
      Route::get('json/tripsearchlist/{type}/{fromDate}/{toDate}/{lorry}/{invoiceNumber}/{customer}/{route}', [
        'as' => 'TransportManagement.list', 'uses' => 'TransportManagementController@jsontripsearchlist'
      ]);  
      
      Route::get('createInvoice/{id}/{vat}/{customer}/{contact}/{routeValue}/{company}', [
        'as' => 'createInvoice', 'uses' => 'TransportManagementController@createInvoice'
      ]);
        
      Route::get('printpdf/{id}', [ 
          'as' => 'customer.printpdf', 'uses' => 'TransportManagementController@printPDF'
      ]);
      
      Route::get('viewInvoice', [
        'as' => 'addInvoice', 'uses' => 'TransportManagementController@viewInvoiceView'
      ]);
        
       Route::get('json/invoicesearchlist', [
        'as' => 'TransportManagement.list', 'uses' => 'TransportManagementController@jsoninvoicesearchlist'
      ]); 
	  
	    /*Route::get('json/invoicesearchlist/{type}/{fromDate}/{toDate}/{lorry}/{invoiceNumber}/{customer}/{route}', [
        'as' => 'TransportManagement.list', 'uses' => 'TransportManagementController@jsoninvoicesearchlist'
      ]); */
      
      Route::get('addInvoiceList', [
        'as' => 'addInvoice', 'uses' => 'TransportManagementController@addInvoiceListView'
      ]);
        
      Route::get('json/tripInvoicelist/{type}/{fromDate}/{toDate}/{lorry}/{invoiceNumber}/{customer}/{route}', [
        'as' => 'TransportManagement.list', 'uses' => 'TransportManagementController@jsonInvoicListesearchlist'
      ]);   
      
       Route::get('createInvoiceList/{id}/{customer}/{contact}/{routeValue}/{company}', [
        'as' => 'createInvoice', 'uses' => 'TransportManagementController@createInvoiceList'
      ]);
       
      Route::get('printpdfList/{id}', [ 
          'as' => 'customer.printpdf', 'uses' => 'TransportManagementController@printPDFList'
      ]);
       
      
       Route::get('viewInvoiceList', [
        'as' => 'addInvoice', 'uses' => 'TransportManagementController@viewInvoiceListView'
      ]);
       
          Route::get('json/invoiceListsearchlist', [
        'as' => 'TransportManagement.list', 'uses' => 'TransportManagementController@jsoninvoiceListsearchlist'
      ]); 
      
      
      
      /**
       * POST Routes
       */
      Route::post('add', [
        'as' => 'add', 'uses' => 'TransportManagementController@add'
      ]);
      Route::post('edit/{id}', [
        'as' => 'transport.edit', 'uses' => 'TransportManagementController@edit'  // Not Implemented Yet
      ]);

      Route::post('status', [
        'as' => 'transport.status', 'uses' => 'PermissionController@status'
      ]);

      Route::post('delete', [
        'as' => 'transport.delete', 'uses' => 'TransportManagementController@delete'
      ]);
      
    
       
    });
});