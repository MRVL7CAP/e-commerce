<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
