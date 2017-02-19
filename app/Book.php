<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'isbn',
        'title',
        'publisher',
        'pub_year',
        'image_url_small',
        'image_url_medium',
        'image_url_large',
    ];

    public function authors()
    {
        return $this->belongsToMany('App\Author', 'book_authors')->withTimestamps();
    }
}
