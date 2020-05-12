<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function categories()
    {
        return $this->hasMany('App\Category');
    }

    public function rate()
    {
        return $this->hasMany('App\Rate');
    }
}
