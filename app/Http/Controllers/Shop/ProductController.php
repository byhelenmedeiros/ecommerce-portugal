<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Inertia\Inertia;
use App\Models\Category;
use App\Models\Region;

class ProductController extends Controller
{
   public function index(Request $request)
{
    $query = Product::with('category')
        ->when($request->name, fn($q) => $q->where('name', 'like', '%' . $request->name . '%'))
        ->when($request->category, fn($q) => $q->where('category_id', $request->category))
     //   ->when($request->region, fn($q) => $q->where('region_id', $request->region))
        ->when($request->min_price, fn($q) => $q->where('price', '>=', $request->min_price))
        ->when($request->max_price, fn($q) => $q->where('price', '<=', $request->max_price))
        ->when($request->sort, function ($q) use ($request) {
            return match ($request->sort) {
                'price_asc'  => $q->orderBy('price', 'asc'),
                'price_desc' => $q->orderBy('price', 'desc'),
                'name_asc'   => $q->orderBy('name', 'asc'),
                'name_desc'  => $q->orderBy('name', 'desc'),
                default      => $q->orderBy('created_at', 'desc'),
            };
        });

    return Inertia::render('Shop/Products/ShopIndex', [
        'products' => $query->paginate(12)->appends(request()->query()),
        'filters' => $request->only(['name', 'category',  'min_price', 'max_price', 'sort']),
        'categories' => Category::all(['id', 'name']),
       
    ]);
}


    public function show(Product $product)
    {
        return Inertia::render('Shop/Products/ProductShow', [
            'product' => $product->load('category'),
        ]);
    }
}