<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'book_id', 'comment_body'
    ];
    public function user() {
        return $this->belongsTo('App\User');
    }
}
