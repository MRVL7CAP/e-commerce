<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {

        $query = Product::query();

        if ($request->filled('q')) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }
        if ($request->filled('category')) {
            $query->where('category', "=", $request->query('category'));
        };

        $products = $query->with('category')->latest()->paginate(8)->withQueryString();

        $categories = Category::all();
        return view('Homepage', compact('products', 'categories'));
    }

    public function show(Product $product) {
        $product::query()->with('category');
    }
}
