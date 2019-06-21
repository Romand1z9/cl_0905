<?php

namespace App\Repositories;

use App\Menu;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;

class MenusRepository extends Repository
{
    public function __construct(Menu $menu)
    {
        $this->model = $menu;
    }

    public function addMenu($request)
    {
        if(Gate::denies('save', $this->model))
        {
            abort(403);
        }

        $data = $request->only('type','title','parent');

        if(empty($data))
        {
            return ['error' => Lang::get('errors.data_empty')];
        }

        switch($data['type'])
        {
            case 'customLink':
                $data['path'] = $request->input('custom_link');
                break;

            case 'blogLink':
                if($request->input('category_alias'))
                {
                    if($request->input('category_alias') == 'parent')
                    {
                        $data['path'] = route('articles.index');
                    }
                    else
                    {
                        $data['path'] = route('articlesCategory', ['cat_alias' => $request->input('category_alias')]);
                    }
                }
                else if($request->input('article_alias'))
                {
                    $data['path'] = route('articles.show',['alias' => $request->input('article_alias')]);
                }
                break;

            case 'portfolioLink':
                if($request->input('filter_alias'))
                {
                    if($request->input('filter_alias') == 'parent')
                    {
                        $data['path'] = route('portfolios.index');
                    }
                }
                else if($request->input('portfolio_alias'))
                {
                    $data['path'] = route('portfolios.show',['alias' => $request->input('portfolio_alias')]);
                }
                break;
        }

        unset($data['type']);

        if($this->model->fill($data)->save())
        {
            return ['status' => Lang::get('admin.menu_item_link_added')];
        }
    }

    public function updateMenu($request, $menu)
    {
        if(Gate::denies('save', $this->model)) {
            abort(403);
        }

        $data = $request->only('type','title','parent');

        if(empty($data))
        {
            return ['error' => Lang::get('errors.data_empty')];
        }

        switch($data['type'])
        {

            case 'customLink':
                $data['path'] = $request->input('custom_link');
                break;

            case 'blogLink' :

                if($request->input('category_alias'))
                {
                    if($request->input('category_alias') == 'parent')
                    {
                        $data['path'] = route('articles.index');
                    }
                    else
                    {
                        $data['path'] = route('articlesCat',['cat_alias'=>$request->input('category_alias')]);
                    }
                }
                else if($request->input('article_alias'))
                {
                    $data['path'] = route('articles.show',['alias' => $request->input('article_alias')]);
                }

                break;

            case 'portfolioLink' :
                if($request->input('filter_alias'))
                {
                    if($request->input('filter_alias') == 'parent')
                    {
                        $data['path'] = route('portfolios.index');
                    }
                }
                else if($request->input('portfolio_alias'))
                {
                    $data['path'] = route('portfolios.show',['alias' => $request->input('portfolio_alias')]);
                }
                break;

        }

        unset($data['type']);

        if($menu->fill($data)->update())
        {
            return ['status' => Lang::get('admin.menu_item_link_is_updated')];
        }
    }

    public function deleteMenu ($menu)
    {
        if(Gate::denies('save', $this->model))
        {
            abort(403);
        }

        if($menu->delete())
        {
            return ['status' => Lang::get('admin.menu_item_is_deleted')];
        }
    }

}
