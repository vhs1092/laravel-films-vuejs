<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    protected $table = 'films';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    protected $fillable = ['name', 'slug', 'description', 'release_date', 'rating', 'ticket_price', 'country', 'photo', 'user_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function genres()
    {
        return $this->belongsToMany('App\Models\Genre', 'film_genres', 'film_id', 'genre_id');
    }

    /**
     * Film comments
     */
    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }
}
