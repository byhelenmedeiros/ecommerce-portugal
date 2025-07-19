<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
  public function index(Request $request)
{
    $query = Product::query()->with('category');

    if ($request->filled('name')) {
        $query->where('name', 'like', '%' . $request->name . '%');
    }

    if ($request->filled('category')) {
        $query->where('category_id', $request->category);
    }

    if ($request->filled('min_price')) {
        $query->where('final_price', '>=', $request->min_price);
    }

    if ($request->filled('max_price')) {
        $query->where('final_price', '<=', $request->max_price);
    }

    if ($request->boolean('in_stock') && !$request->boolean('out_of_stock')) {
        $query->where('stock', '>', 0);
    }

    if ($request->boolean('out_of_stock') && !$request->boolean('in_stock')) {
        $query->where('stock', '<=', 0);
    }

    if ($request->filled('sort')) {
        match ($request->sort) {
            'price_asc' => $query->orderBy('final_price', 'asc'),
            'price_desc' => $query->orderBy('final_price', 'desc'),
            'name_asc' => $query->orderBy('name', 'asc'),
            'name_desc' => $query->orderBy('name', 'desc'),
            default => null,
        };
    }

    $products = $query->paginate(12);
    $categories = Category::orderBy('name')->get();

    return Inertia::render('Shop/Products/ShopIndex', [
        'products' => $products,
        'categories' => $categories,
        'filters' => $request->only([
            'name', 'category', 'min_price', 'max_price', 'sort', 'in_stock', 'out_of_stock'
        ]),
         'auth' => [
        'user' => Auth::user(),
    ]
    ]);
}



    public function show(Product $product)
    {
        return Inertia::render('Shop/Products/ProductShow', [
            'product' => $product->load('category'),
        ]);
    }
}