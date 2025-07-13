<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Region;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'region')->paginate(15);
        return inertia('Admin/Products/Index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $regions = Region::all();
        return inertia('Admin/Products/Create', compact('categories', 'regions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug',
            'description' => 'required',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'category_id' => 'required|exists:categories,id',
            'region_id' => 'nullable|exists:regions,id',
        ]);

        Product::create($data);
        return redirect()->route('admin.products.index')->with('success', 'Produto criado com sucesso.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $regions = Region::all();
        return inertia('Admin/Products/Edit', compact('product', 'categories', 'regions'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug,' . $product->id,
            'description' => 'required',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'category_id' => 'required|exists:categories,id',
            'region_id' => 'nullable|exists:regions,id',
        ]);

        $product->update($data);
        return redirect()->route('admin.products.index')->with('success', 'Produto atualizado com sucesso.');
    }

    public function destroy(Product $product)
{
    $this->authorize('delete', $product);

    $product->delete();
    return redirect()->route('admin.products.index')->with('success', 'Produto removido com sucesso.');
}

}

