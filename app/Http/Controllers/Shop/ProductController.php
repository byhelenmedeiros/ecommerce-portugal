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
}
