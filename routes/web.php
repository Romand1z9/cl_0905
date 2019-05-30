<?php

Route::resource('/', 'IndexController', ['only' => ['index']]);

Route::resource('portfolios', 'PortfolioController', ['parameters' => ['portfolios' => 'alias']]);

Route::resource('articles', 'ArticleController', ['parameters' => ['articles' => 'alias']]);

Route::get('articles/category/{alias?}', ['uses'=>'ArticleController@index','as'=>'articlesCategory']);

Route::resource('comment','CommentController',['only'=>['store']]);