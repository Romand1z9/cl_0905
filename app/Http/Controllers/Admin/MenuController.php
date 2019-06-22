<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\MenuRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Menu;
use Lang;
use App\Category;
use App\Filter;
use App\Repositories\MenusRepository;
Use App\Repositories\ArticlesRepository;
use App\Repositories\PortfoliosRepository;

class MenuController extends AdminController
{
    protected $m_rep;


    public function __construct(MenusRepository $m_rep, ArticlesRepository $a_rep, PortfoliosRepository $p_rep)
    {
        parent::__construct();

        $this->m_rep = $m_rep;
        $this->a_rep = $a_rep;
        $this->p_rep = $p_rep;

        $this->template = config('settings.theme').'.admin.menus';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('VIEW_ADMIN_MENU'))
        {
            abort(403);
        }

        $this->title = Lang::get('admin.manager_menu');

        $menu = $this->getMenus();

        $this->content = view(config('settings.theme').'.admin.menus_content')->with('menus',$menu)->render();

        return $this->renderOutput();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('EDIT_MENU'))
        {
            abort(403);
        }

        $this->title = Lang::get('admin.new_menu_element');

        $tmp = $this->getMenus()->roots();

        $menus = $tmp->reduce(function($returnMenus, $menu) {

            $returnMenus[$menu->id] = $menu->title;
            return $returnMenus;

        },['0' => Lang::get('admin.parent_menu_item')]);

        $categories = Category::select(['title','alias','parent_id','id'])->get();

        $list = array();
        $list['0'] = Lang::get('admin.not_used');
        $list['parent'] = Lang::get('blog.title');

        foreach($categories as $category)
        {
            if($category->parent_id == 0)
            {
                $list[$category->title] = array();
            }
            else
            {
                $list[$categories->where('id',$category->parent_id)->first()->title][$category->alias] = $category->title;
            }
        }

        $articles = $this->a_rep->get(['id','title','alias']);

        $articles = $articles->reduce(function ($returnArticles, $article)
        {
            $returnArticles[$article->alias] = $article->title;
            return $returnArticles;
        }, []);


        $filters = Filter::select('id','title','alias')->get()->reduce(function ($returnFilters, $filter)
        {
            $returnFilters[$filter->alias] = $filter->title;
            return $returnFilters;
        }, ['parent' => Lang::get('portfolios.title')]);

        $portfolios = $this->p_rep->get(['id','alias','title'])->reduce(function ($returnPortfolios, $portfolio)
        {
            $returnPortfolios[$portfolio->alias] = $portfolio->title;
            return $returnPortfolios;
        }, []);

        $this->content = view(config('settings.theme').'.admin.menus_create_content')->with(
            [
                'menus' => $menus,
                'categories' => $list,
                'articles' => $articles,
                'filters' => $filters,
                'portfolios' => $portfolios
            ]
        )->render();

        return $this->renderOutput();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuRequest $request)
    {
        $result = $this->m_rep->addMenu($request);

        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }

        return redirect('/admin/menus')->with($result);
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
        if(Gate::denies('EDIT_MENU'))
        {
            abort(403);
        }

        $menu = \App\Menu::select(['id', 'title', 'path', 'parent'])->where('id', $id)->first();

        if (empty($menu))
        {
            abort(404);
        }

        $this->title = Lang::get('admin.menu_item_edit').' - '.$menu->title;

        $type = FALSE;
        $option = FALSE;

        //path - http://corporate.loc/articles

        $route = app('router')->getRoutes()->match(app('request')->create($menu->path));

        $aliasRoute = $route->getName();
        $parameters = $route->parameters();

        //dump($aliasRoute);
        //dump($parameters);

        if($aliasRoute == 'articles.index' || $aliasRoute == 'articlesCategory')
        {
            $type = 'blogLink';
            $option = isset($parameters['cat_alias']) ? $parameters['cat_alias'] : 'parent';
        }
        else if($aliasRoute == 'articles.show')
        {
            $type = 'blogLink';
            $option = isset($parameters['alias']) ? $parameters['alias'] : '';

        }
        else if($aliasRoute == 'portfolios.index')
        {
            $type = 'portfolioLink';
            $option = 'parent';

        }
        else if($aliasRoute == 'portfolios.show')
        {
            $type = 'portfolioLink';
            $option = isset($parameters['alias']) ? $parameters['alias'] : '';
        }
        else
        {
            $type = 'customLink';
        }


        //dd($type);
        $tmp = $this->getMenus()->roots();

        //null
        $menus = $tmp->reduce(function($returnMenus, $menu)
        {

            $returnMenus[$menu->id] = $menu->title;
            return $returnMenus;

        },['0' => Lang::get('admin.parent_menu_item')]);

        $categories = Category::select(['title','alias','parent_id','id'])->get();

        $list = array();
        $list['0'] = Lang::get('admin.not_used');
        $list['parent'] = Lang::get('blog.title');

        foreach($categories as $category)
        {
            if($category->parent_id == 0)
            {
                $list[$category->title] = array();
            }
            else
            {
                $list[$categories->where('id',$category->parent_id)->first()->title][$category->alias] = $category->title;
            }
        }

        $articles = $this->a_rep->get(['id','title','alias']);

        $articles = $articles->reduce(function ($returnArticles, $article)
        {
            $returnArticles[$article->alias] = $article->title;
            return $returnArticles;
        }, []);


        $filters = Filter::select('id','title','alias')->get()->reduce(function ($returnFilters, $filter)
        {
            $returnFilters[$filter->alias] = $filter->title;
            return $returnFilters;
        }, ['parent' => Lang::get('portfolios.title')]);

        $portfolios = $this->p_rep->get(['id','alias','title'])->reduce(function ($returnPortfolios, $portfolio)
        {
            $returnPortfolios[$portfolio->alias] = $portfolio->title;
            return $returnPortfolios;
        }, []);

        $this->content = view(config('settings.theme').'.admin.menus_create_content')->with(
         [
             'menu' => $menu,
             'type' => $type,
             'option' => $option,
             'menus' => $menus,
             'categories' => $list,
             'articles'  =>  $articles,
             'filters' => $filters,
             'portfolios' => $portfolios
         ]
        )->render();

        return $this->renderOutput();
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
        if(Gate::denies('EDIT_MENU'))
        {
            abort(403);
        }

        $menu = \App\Menu::select(['id', 'title', 'path', 'parent'])->where('id', $id)->first();

        if (empty($menu))
        {
            abort(404);
        }

        $result = $this->m_rep->updateMenu($request, $menu);

        if(is_array($result) && !empty($result['error']))
        {
            return back()->with($result);
        }

        return redirect('/admin/menus')->with($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Gate::denies('EDIT_MENU'))
        {
            abort(403);
        }

        $menu = \App\Menu::where('id', $id)->first();

        if (empty($menu))
        {
            abort(404);
        }

        $result = $this->m_rep->deleteMenu($menu);

        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }

        return redirect('/admin/menus')->with($result);
    }

    private function getMenus()
    {
        $menu = $this->m_rep->get();

        if($menu->isEmpty()) {
            return FALSE;
        }

        return Menu::make('forMenuPart', function($m) use($menu)
        {
            foreach($menu as $item)
            {
                if($item->parent == 0)
                {
                    $m->add($item->title,$item->path)->id($item->id);
                }
                else
                {
                    if($m->find($item->parent))
                    {
                        $m->find($item->parent)->add($item->title,$item->path)->id($item->id);
                    }
                }
            }

        });

    }

}
