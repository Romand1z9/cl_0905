<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    public $fillable = [
        'text', 'name', 'email', 'parent_id', 'site', 'article_id', 'created_at', 'updated_at', 'user_id'
    ];
    
    public function article()
    {
        return $this->belongsTo('App\Article');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
