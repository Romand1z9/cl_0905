<?php

Route::resource('/', 'IndexController', ['only' => ['index']]);

Route::resource('portfolios', 'PortfolioController', ['parameters' => ['portfolios' => 'alias']]);