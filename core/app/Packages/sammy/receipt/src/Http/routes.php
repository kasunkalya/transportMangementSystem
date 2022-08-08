<?php

/**
 * Created by PhpStorm.
 * User: kalya
 * Date: 1/5/2016
 * Time: 10:35 AM
 */
Route::group(['middleware' => ['auth']], function()
{
    Route::group(['prefix' => 'books', 'namespace' => 'Sammy\Books\Http\Controllers'], function(){
        /**
         * GET Routes
         */
     Route::get('add', [
            'as' => 'Books.add', 'uses' => 'BooksController@addView'
        ]);

        Route::get('edit/{id}', [
            'as' => 'Books.edit', 'uses' => 'BooksController@editView'
        ]);

        Route::get('list', [
            'as' => 'Books.list', 'uses' => 'BooksController@listView'
        ]);

        Route::get('json/list', [
            'as' => 'Books.list', 'uses' => 'BooksController@jsonList'
        ]);

        /**
         * POST Routes
         */
       Route::post('add', [
            'as' => 'Books.add', 'uses' => 'BooksController@add'
        ]);

        Route::post('edit/{id}', [
            'as' => 'Books.edit', 'uses' => 'BooksController@edit'
        ]);

        Route::post('delete', [
            'as' => 'Books.delete', 'uses' => 'BooksController@delete'
        ]);
    });
});