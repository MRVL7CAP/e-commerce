<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequestForm;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('q')) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }

        $products = $query->latest()->paginate(12)->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequestForm $request)
    {

    $payload = $request->validated($request->all());

    $slug = Str::slug($payload->title);
    if (Product::where('slug', $slug)->exists()) {
        $slug .= '-' . time();
    }

    $imagePath = null;
    if ($payload->hasFile('image')) {
        $imagePath = $payload->file('image')->store('products', 'public');
    }

    Product::create([
        'title' => $payload->title,
        'slug' => $slug,
        'description' => $payload->description,
        'category_id' => $payload->category_id,
        'image' => $imagePath,

        'price' => $payload->price,
        'old_price' => $payload->old_price,
        'rating' => $payload->rating,
        'rating_count' => $payload->rating_count ?? 0,
        'is_published' => $payload->has('is_published'),
    ]);

    return redirect()->route('products.index')
        ->with('success', 'product created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
