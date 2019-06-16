<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ArticleRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ArticlesRepository;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;
use App\Category;

class ArticleController extends AdminController
{

    public function __construct(ArticlesRepository $a_rep)
    {
        parent::__construct();

        $this->a_rep = $a_rep;

        $this->template = env('THEME').'.admin.articles';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('VIEW_ADMIN_ARTICLES'))
        {
            abort(403);
        }

        $this->title = Lang::get('admin.articles_list');

        $articles = $this->getArticles();
        $this->content = view(env('THEME').'.admin.articles_content')->with('articles',$articles)->render();

        return $this->renderOutput();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('save', new \App\Article))
        {
            abort(403);
        }

        $this->title = Lang::get('admin.add_new_material');

        $categories = Category::select(['title','alias','parent_id','id'])->get();

        $lists = array();

        foreach($categories as $category)
        {
            if($category->parent_id == 0)
            {
                $lists[$category->title] = array();
            }
            else
            {
                $lists[$categories->where('id',$category->parent_id)->first()->title][$category->id] = $category->title;
            }
        }

        $this->content = view(env('THEME').'.admin.articles_create_content')->with('categories', $lists)->render();

        return $this->renderOutput();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        $result = $this->a_rep->addArticle($request);

        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }

        return redirect('/admin')->with($result);
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

    public function getArticles()
    {
        return $this->a_rep->get();
    }

}
