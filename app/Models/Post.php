<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'website_id',
        'title',
        'content',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function (Post $post) {

        });
    }
}
