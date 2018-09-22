<?php

namespace App\Models\Comment;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{   
    protected $table = 'comments';

    protected $fillable = ['name', 'comment', 'film_id', 'user_id'];

    /**
     * Film associated
     */
    public function film()
    {
        return $this->belongsTo('App\Models\Film');
    }

    /**
     * User who send comment
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
