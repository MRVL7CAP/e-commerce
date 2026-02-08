<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'category_id',
        'image',
        'price',
        'old_price',
        'rating',
        'rating_count',
        'is_published',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
