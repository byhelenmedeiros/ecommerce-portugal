<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('query', '');

        // Pesquisa simples com LIKE
        $products = Product::where('name', 'like', '%' . $query . '%')->paginate(12);

        return Inertia::render('Shop/Search', [
            'query' => $query,
            'products' => $products,
        ]);
    }
}
