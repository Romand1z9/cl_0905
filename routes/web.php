<?php

Route::resource('/', 'IndexController', ['only' => ['index']]);

Route::resource('portfolios', 'PortfolioController', ['parameters' => ['portfolios' => 'alias']]);

Route::resource('articles', 'ArticleController', ['parameters' => ['articles' => 'alias']]);

Route::get('articles/category/{alias?}', ['uses'=>'ArticleController@index','as'=>'articlesCategory'])->where('alias','[\w-]+');

Route::resource('comment','CommentController',['only'=>['store']]);

Route::match(['get','post'],'/contacts',['uses'=>'ContactsController@index','as'=>'contacts']);

Route::get('login', ['uses' => 'Auth\LoginController@showLoginForm', 'as' => 'login']);

Route::post('login','Auth\LoginController@login');

Route::get('logout','Auth\LoginController@logout');

// Admin

Route::group(['prefix' => 'admin','middleware'=> 'auth'], function()
{
    Route::get('/',['uses' => 'Admin\IndexController@index','as' => 'adminIndex']);

    Route::resource('articles','Admin\ArticleController');

    Route::resource('menus','Admin\MenuController');

    Route::resource('users','Admin\UserController');

    Route::resource('permissions','Admin\PermissionController');

});
