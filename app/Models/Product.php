<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{

    use HasFactory;

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

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }


    public static function getTotal()
    {
        $cart = session()->get('cart', []);
        if (!is_array($cart)) {
            return 0;
        }
        $productIds = array_keys($cart);
        $quantities = array_values($cart);

        $products = Product::query()->findMany($productIds, ['price', 'id']);


        $total = 0;

        foreach ($products as $p) {
            $index = array_search($p->id, $productIds);

            if ($index !== false) {
                $total += $p->price * $quantities[$index];
            }
        }

        return $total;
    }
}
