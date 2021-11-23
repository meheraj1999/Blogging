<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = "id";
    protected $table = 'categories';
    protected $fillable = [
        'name',
        'image',
        
       
    ];

    public function posts()
    {
        return $this->belongsToMany('App\Post')->withTimestamps();
    }
}
