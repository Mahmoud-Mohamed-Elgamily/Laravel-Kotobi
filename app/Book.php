<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function rate()
    {
        return $this->hasMany('App\Rate');
    }
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
    
}
