<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;

use App\Repositories\PortfoliosRepository;
use App\Repositories\ArticlesRepository;

class ArticleController extends AppController
{
    public function __construct(PortfoliosRepository $portfolio, ArticlesRepository $articles)
    {
        parent::__construct(new \App\Repositories\MenusRepository(new \App\Menu()));

        $this->p_rep = $portfolio;
        $this->a_rep = $articles;
        
        $this->bar = 'right';
        $this->template = env('THEME').'.articles';
    }

    public function index()
    {
        $this->title = 'Articles Page';
        $this->keywords = 'Articles Page';
        $this->meta_description = 'Articles Page';
        

        $articles_items = $this->getArticles();
        $articles = view(env('THEME').'.articles_content')->with('articles', $articles_items)->render();
        $this->vars['articles'] = $articles;

        $this->contentRightBar = view(env('THEME').'.index_sidebar')->with('articles', $articles_items)->render();

        $this->sidebar = 'right';

        //dd($articles);
        

        return $this->renderOutput();
    }

    public function show(Request $request)
    {
       // dd($request->all());
    }

    public function getPortfolio()
    {
        $portfolio = $this->p_rep->get('*', Config::get('settings.home_portfolio_count'));
        
        if($portfolio->isEmpty()) 
        {
            return FALSE;
	}
	
    	return $portfolio;
    }

    public function getArticles()
    {
        $articles = $this->a_rep->get(['id','title', 'alias', 'desc', 'img', 'created_at','user_id','category_id'], FALSE, TRUE);

        if($articles->isEmpty()) 
        {
            return FALSE;
        }
        
        if ($articles)
        {
            $articles->load('user', 'category', 'comments');
        }

    	return $articles;
    }

}
