<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title', 'slug', 'content', 'author',
    ];

    public function Author()
    {
        return $this->belongsTo(User::class, 'author', 'id');
    }
}
