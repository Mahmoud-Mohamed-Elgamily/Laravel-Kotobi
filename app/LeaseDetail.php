<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaseDetail extends Model
{
    use SoftDeletes;

    public function book()
    {
        return $this->belongsTo('App\Book');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    //
}
