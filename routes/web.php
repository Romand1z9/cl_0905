<?php

Route::resource('/', 'IndexController', ['only' => ['index']]);

Route::resource('portfolios', 'PortfolioController', ['parameters' => ['portfolios' => 'alias']]);

Route::resource('articles', 'ArticleController', ['parameters' => ['articles' => 'alias']]);

Route::get('articles/cat/{cat_alias?}', ['uses'=>'ArticleController@index','as'=>'articlesCat']);