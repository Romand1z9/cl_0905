<?php

namespace App\Repositories;

use Config;

abstract class Repository 
{
    protected $model = FALSE;

    public function get($select = "*", $limit = FALSE, $paginate = FALSE)
    {
        $builder = $this->model->select($select);
        
        if ($limit)
        {
            $builder->take($limit);
        }

        if ($paginate)
        {
            $builder->paginate(Config::get('settings.paginate'));
        }

        return $this->check($builder->get());
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

}
