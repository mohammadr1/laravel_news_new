<?php

namespace App\Models;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'on_titr',
        'title',
        'slug',
        'subtitle',
        'content_type',
        'image',
        'body',
        'meta_description',
        'author_id',
        'published_at',
        'category_id',
        // 'tags',
        'short_link',
        'position',
        'status',
        'views',
    ];

    const CONTENT_TYPES = [
        'یادداشت'         => 'یادداشت',
        'گفتگوی تفصیلی'   => 'گفتگوی تفصیلی',
        'مصاحبه'          => 'مصاحبه',
        'بازنشر'          => 'بازنشر',
        'پوششی'           => 'پوششی',
        'دریافتی'         => 'دریافتی',
        'گزارش'           => 'گزارش',
        'گزارش تصویری'    => 'گزارش تصویری',
        'میزگرد'          => 'میزگرد',
        'فیلم'            => 'فیلم',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        // 'tags' => 'array',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
        public function category()
        {
            return $this->belongsTo(\App\Models\Category::class);
        }
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'news_tag');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($news) {
            do {
                $code = Str::random(6);
            } while (News::where('short_link', $code)->exists());

            $news->short_link = $code;
        });
    }
}
