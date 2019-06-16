<?php

namespace App\Repositories;

use Config;

abstract class Repository 
{
    protected $model = FALSE;

    public function get($select = "*", $limit = FALSE, $paginate = FALSE, $where = FALSE, $order_by = FALSE)
    {
        $builder = $this->model->select($select);

        if ($where)
        {
            $builder->where($where);
        }

        if ($order_by)
        {
            $builder->orderBy($order_by, 'desc');
        }

        if ($limit)
        {
            $builder->take($limit);
        }

        if ($paginate)
        {
            return $this->check($builder->paginate(Config::get('settings.paginate')));
        }

        return $this->check($builder->get());
    }

    public function one($alias)
    {
        $result = $this->model->where('alias', $alias)->first();

        return $result ? $result : FALSE;
    }

    protected function check($result)
    {
        if($result->isEmpty())
        {
            return FALSE;
        }

        $result->transform(function($item,$key)
        {
            if(is_string($item->img) && is_object(json_decode($item->img)) && (json_last_error() == JSON_ERROR_NONE))
            {
                $item->img = json_decode($item->img);
            }

            return $item;
        });

        return $result;
    }

    public function transliterate($string)
    {
        $str = mb_strtolower($string, 'UTF-8');

        $leter_array =  [
            'a' => 'а',
            'b' => 'б',
            'v' => 'в',
            'g' => 'г',
            'd' => 'д',
            'e' => 'е,э',
            'jo' => 'ё',
            'zh' => 'ж',
            'z' => 'з',
            'i' => 'и',
            'j' => 'й',
            'k' => 'к',
            'l' => 'л',
            'm' => 'м',
            'n' => 'н',
            'o' => 'о',
            'p' => 'п',
            'r' => 'р',
            's' => 'с',
            't' => 'т',
            'u' => 'у',
            'f' => 'ф',
            'kh' => 'х',
            'ts' => 'ц',
            'ch' => 'ч',
            'sh' => 'ш',
            'shch' => 'щ',
            '' => 'ъ',
            'y' => 'ы',
            '' => 'ь',
            'yu' => 'ю',
            'ya' => 'я',
        ];

        foreach($leter_array as $leter => $cirylic)
        {
            $cirylic = explode(',',$cirylic);
            $str = str_replace($cirylic,$leter, $str);
        }

        $str = preg_replace('/(\s|[^A-Za-z0-9\-])+/','-',$str);

        $str = trim($str,'-');

        return $str;
    }

}
