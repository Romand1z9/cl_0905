<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\SlidersRepository;
use App\Repositories\PortfoliosRepository;
use App\Repositories\ArticlesRepository;

use Config;

class IndexController extends AppController
{

    public function __construct(SlidersRepository $slider, PortfoliosRepository $portfolio, ArticlesRepository $articles)
    {
        parent::__construct(new \App\Repositories\MenusRepository(new \App\Menu()));

        $this->s_rep = $slider;
        $this->p_rep = $portfolio;
        $this->a_rep = $articles;
        
        $this->bar = 'right';
        $this->template = env('THEME').'.index';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->title = 'Home Page';
        $this->keywords = 'Home Page';
        $this->meta_description = 'Home Page';

        $slides = $this->getSlides();        
        $slider = view(env('THEME').'.slider')->with('slides', $slides)->render();
        
        $portfolio_items = $this->getPortfolio();
        $portfolio = view(env('THEME').'.content')->with('portfolios', $portfolio_items)->render();

        $articles = $this->getArticles();
        $this->contentRightBar = view(env('THEME').'.index_sidebar')->with('articles', $articles)->render();

        $this->sidebar = 'right';
        
        $this->vars['slider'] = $slider;
        $this->vars['portfolio'] = $portfolio;

        return $this->renderOutput();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    public function getSlides()
    {
        $slides = $this->s_rep->get('*', 4);
        
        if($slides->isEmpty()) 
        {
            return FALSE;
	}
		
        $slides->transform(function($item,$key) 
        {
            $item->img = Config::get('settings.slider_path').'/'.$item->img;
            return $item;

        });
    	
    	return $slides;
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
        $articles = $this->a_rep->get(['title', 'alias', 'img', 'created_at'], Config::get('settings.home_articles_count'));
        
        if($articles->isEmpty()) 
        {
            return FALSE;
	}
	
    	return $articles;
    }

}
