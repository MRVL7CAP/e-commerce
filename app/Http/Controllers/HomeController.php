<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use FastVolt\Helper\Markdown;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index(Request $request)
    {

        $query = Product::query();

        if ($request->filled('q')) {
            $query->where('title', 'like', '%' . $request->q . '%');
        };
        if ($request->filled('category')) {
            $query->where('category', "=", $request->query('category'));
        };

        $query->where('is_published', true);

        $products = $query->with('category')->latest()->paginate(8)->withQueryString();
        $categories = Category::all();

        return view('homepage', compact('products', 'categories'));
    }

    public function show(Product $product)
    {

        abort_unless($product->is_published, 404);

        $product->load('category');


        $product->content =  (new Markdown())->setContent($product->content)->getHtml();

        return view('products.show', compact('product'));
    }
}
