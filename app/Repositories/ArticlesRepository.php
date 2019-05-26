<?php

namespace App\Repositories;

use App\Article; 

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

}
