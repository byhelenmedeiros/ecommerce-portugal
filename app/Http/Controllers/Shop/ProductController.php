<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function show($slug)
    {
        $product = Product::with(['category', 'region', 'images'])->where('slug', $slug)->firstOrFail();
        return Inertia::render('Shop/ProductDetails', [
            'product' => $product,
        ]);
    }

    public function index(Request $request)
{
    $query = Product::query()->with(['category', 'subcategory']);

    if ($request->has('cat')) {
        $query->whereHas('category', fn($q) => $q->where('slug', $request->cat));
    }

    if ($request->has('sub')) {
        $query->whereHas('subcategory', fn($q) => $q->where('slug', $request->sub));
    }

    return Inertia::render('Shop/Index', [
        'products' => $query->paginate(12),
    ]);
}

    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = Product::with(['category', 'subcategory'])
            ->where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->paginate(12);

        return Inertia::render('Shop/SearchResults', [
            'products' => $products,
            'query' => $query,
        ]);
    }
    public function filterByCategory($categorySlug)
    {
        $products = Product::with(['category', 'subcategory'])
            ->whereHas('category', fn($q) => $q->where('slug', $categorySlug))
            ->paginate(12);

        return Inertia::render('Shop/CategoryProducts', [
            'products' => $products,
            'categorySlug' => $categorySlug,
        ]);
    }
}
