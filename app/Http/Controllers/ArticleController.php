<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Config;

use App\Repositories\PortfoliosRepository;
use App\Repositories\ArticlesRepository;
use App\Repositories\CommentsRepository;

class ArticleController extends AppController
{
    public function __construct(PortfoliosRepository $portfolio, ArticlesRepository $articles, CommentsRepository $comments)
    {
        parent::__construct(new \App\Repositories\MenusRepository(new \App\Menu()));

        $this->p_rep = $portfolio;
        $this->a_rep = $articles;
        $this->c_rep = $comments;
        
        $this->bar = 'right';
        $this->template = env('THEME').'.articles';
    }

    public function index($alias = FALSE)
    {
        $articles_items = $this->getArticles($alias);
        $portfolio_items = $this->getPortfolio();
        $comments = $this->getComments(Config::get('settings.articles_comments_count'));

        $articles = view(env('THEME').'.articles_content')->with('articles', $articles_items)->render();
        $this->vars['articles'] = $articles;

        $this->contentRightBar = view(env('THEME').'.articles_sidebar')->with(['portfolios' => $portfolio_items, 'comments' => $comments])->render();

        $this->sidebar = 'right';

        $this->title = ($alias && isset($articles_items[0])) ? $articles_items[0]->category->title : 'Articles Page';
        $this->keywords = ($alias && isset($articles_items[0])) ? $articles_items[0]->category->title : 'Articles Page';
        $this->meta_description = ($alias && isset($articles_items[0])) ? $articles_items[0]->category->title : 'Articles Page';

        return $this->renderOutput();
    }

    public function show($alias = FALSE)
    {
        $article = $this->a_rep->one($alias, ['comments']);

        if ($article)
        {
            $this->title = $article->title;
            $this->keywords = $article->title;
            $this->meta_description =$article->title;
        }
        $portfolio_items = $this->getPortfolio();
        $comments = $this->getComments(Config::get('settings.articles_comments_count'));

        $content = view(env('THEME').'.article_content')->with('article', $article)->render();
        $this->vars['articles'] = $content;

        $this->contentRightBar = view(env('THEME').'.articles_sidebar')->with(['portfolios' => $portfolio_items, 'comments' => $comments])->render();
        $this->sidebar = 'right';

        return $this->renderOutput();
    }

    public function getPortfolio()
    {
        $portfolio = $this->p_rep->get('*', Config::get('settings.articles_portfolio_count'));
        
        if($portfolio->isEmpty()) 
        {
            return FALSE;
	}
	
    	return $portfolio;
    }

    public function getArticles($category_alias = FALSE)
    {
        $where = [];

        if ($category_alias)
        {
            $category_id = Category::where('alias', $category_alias)->first()->id;

            if ($category_id)
            {
                $where['category_id'] = $category_id;
            }
        }

        $articles = $this->a_rep->get(['id','title', 'alias', 'desc', 'img', 'created_at','user_id','category_id'], FALSE, TRUE, $where);

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

    public function getComments($take) {

        $comments = $this->c_rep->get(['text','name','email','site','article_id','user_id'],$take, FALSE, FALSE, 'created_at');

        if($comments) {
            $comments->load('article','user');
        }

        return $comments;
    }

}
