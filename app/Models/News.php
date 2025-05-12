<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'image',
        'body',
        'meta_description',
        'author_id',
        'published_at',
        'tags',
        'position',
        'status',
        'views',
    ];


    protected $casts = [
        'published_at' => 'datetime',
        'tags' => 'array',
    ];

    // public function category()
    // {
    //     return $this->belongsTo(Category::class);
    // }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // public function tags()
    // {
    //     return $this->belongsToMany(Tag::class);
    // }
}
