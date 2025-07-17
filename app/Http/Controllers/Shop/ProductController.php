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
        $query = Product::with('category', 'region')
            ->when($request->name, fn($q) => $q->where('name', 'like', '%' . $request->name . '%'))
            ->when($request->category, fn($q) => $q->where('category_id', $request->category));
        //    ->when($request->region, fn($q) => $q->where('region_id', $request->region));

        return Inertia::render('Shop/Products/ShopIndex', [
            'products' => $query->paginate(12),
            'filters' => [
                'name' => $request->name,
                'category' => $request->category,
               // 'region' => $request->region,
            ],
            'categories' => Category::all(['id', 'name']),
          //  'regions' => Region::all(['id', 'name']),
        ]);
    }

    public function show(Product $product)
    {
        return Inertia::render('Shop/Products/ProductShow', [
            'product' => $product->load('category', 'region'),
        ]);
    }
}