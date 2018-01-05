<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'body',
        'url',
        'commentable_id', //id of the respective commented project
        'commentable_type',
        'user_id'
    ];

    public function commentable()
    {
        return $this->morphTo();
    }

    // Return the user associated with this comment
    public function user()
    {
        return $this->hasOne('\App\User', 'id', 'user_id');
    }
}
