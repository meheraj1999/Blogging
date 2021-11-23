<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model

{
    protected $primaryKey = "id";
    protected $table = 'posts';
    public $timestamps = false;
    protected $fillable = [
        'title',
        'image',
        'body',
        'category_id',
     
        
       
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category')->withTimestamps();
    }
    public function tags()
    {
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }
}
