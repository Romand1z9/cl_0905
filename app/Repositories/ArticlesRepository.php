<?php

namespace App\Repositories;

use App\Article;
use Illuminate\Support\Facades\Gate;
use Config;
use Image;
use Lang;

class ArticlesRepository extends Repository
{
    public function __construct(Article $article)
    {
        $this->model = $article;
    }

    public function one($alias, $attributes = [])
    {
        $article = parent::one($alias);

        if ($article)
        {
            $article->img = json_decode($article->img);
        }

        if ($article && !empty($attributes))
        {
            $article->load('comments');
            $article->comments->load('user');
        }

        return $article;
    }

    public function addArticle($request)
    {
        if(Gate::denies('save', $this->model))
        {
            abort(403);
        }

        $data = $request->except('_token','image');

        if(empty($data))
        {
            return array('error' => Lang::get('errors.data_empty'));
        }

        if(empty($data['alias']))
        {
            $data['alias'] = $this->transliterate($data['title']);
        }

        if($this->one($data['alias'],FALSE)) {
            $request->merge(array('alias' => $data['alias']));
            $request->flash();

            return ['error' => Lang::get('errors.alias_exists')];
        }

        if($request->hasFile('image'))
        {
            $image = $request->file('image');

            if($image->isValid())
            {
                $str = str_random(8);

                $obj = new \stdClass;

                $obj->mini = $str.'_mini.jpg';
                $obj->max = $str.'_max.jpg';
                $obj->path = $str.'.jpg';

                $img = Image::make($image);

                $img->fit(Config::get('settings.image')['width'],
                    Config::get('settings.image')['height'])->save(public_path().'/'.env('THEME').'/images/articles/'.$obj->path);

                $img->fit(Config::get('settings.articles_img')['max']['width'],
                    Config::get('settings.articles_img')['max']['height'])->save(public_path().'/'.env('THEME').'/images/articles/'.$obj->max);

                $img->fit(Config::get('settings.articles_img')['mini']['width'],
                    Config::get('settings.articles_img')['mini']['height'])->save(public_path().'/'.env('THEME').'/images/articles/'.$obj->mini);

                $data['img'] = json_encode($obj);
            }

        }

        $this->model->fill($data);

        if($request->user()->articles()->save($this->model))
        {
            return ['status' => Lang::get('admin.material_is_added')];
        }


    }

}
