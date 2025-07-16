<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',
            'description' => 'required|string',
            'short_description' => 'nullable|string',
            'long_description' => 'nullable|string',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'category_id' => 'required|exists:categories,id',
            'region_id' => 'nullable|exists:regions,id',

            // Logística
            'weight' => 'nullable|numeric',
            'stock' => 'nullable|integer',

            // Visibilidade e estado
            'is_visible' => 'nullable|boolean',
            'highlighted' => 'nullable|boolean',
            'condition' => 'nullable|in:novo,usado',
            'launch_date' => 'nullable|date',

            // SEO e tags
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string',
            'tags' => 'nullable|array',

            // Atributos personalizados
            'attributes' => 'nullable|array',

            // Imagens
            'images.*' => 'nullable|image|max:2048',
            'status' => 'required|in:rascunho,publicado,esgotado',

        ]);


        $data['tags'] = $request->tags ? array_values($request->tags) : [];
        $data['attributes'] = $request->attributes ?? [];

        $product = Product::create($data);

        // Upload de imagens
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $product->images()->create(['path' => $path]);
            }
        }

        if ($request->hasFile('files')) {
    foreach ($request->file('files') as $file) {
        $path = $file->store('product_files', 'public');
        $product->files()->create([
            'name' => $file->getClientOriginalName(),
            'path' => $path,
            'extension' => $file->getClientOriginalExtension(),
        ]);
    }
}


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
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,' . $product->id,
            'description' => 'required|string',
            'short_description' => 'nullable|string',
            'long_description' => 'nullable|string',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'category_id' => 'required|exists:categories,id',
            'region_id' => 'nullable|exists:regions,id',
            'weight' => 'nullable|numeric',
            'stock' => 'nullable|integer',
            'is_visible' => 'nullable|boolean',
            'highlighted' => 'nullable|boolean',
            'condition' => 'nullable|in:novo,usado',
            'launch_date' => 'nullable|date',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string',
            'tags' => 'nullable|array',
            'attributes' => 'nullable|array',
            'images.*' => 'nullable|image|max:2048',

            'ean' => 'nullable|string|max:50',
            'sku' => 'nullable|string|max:50',
            'brand' => 'nullable|string|max:100',
            'unit' => 'nullable|string|max:50',
            'min_order_quantity' => 'nullable|integer|min:1',
            'max_order_quantity' => 'nullable|integer|min:1',
            'shipping_time' => 'nullable|string|max:100',
            'expiration_date' => 'nullable|date',
            'visibility_start' => 'nullable|date',
            'visibility_end' => 'nullable|date',
            'views' => 'nullable|integer',
            'sales' => 'nullable|integer',
            'rating' => 'nullable|numeric|min:0|max:5',
            'review_count' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'created_by' => 'nullable|integer|exists:users,id',
        ]);

        $data['tags'] = $request->tags ? array_values($request->tags) : [];
        $data['attributes'] = $request->attributes ?? [];

        $product->update($data);

        // Imagens novas
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $product->images()->create(['path' => $path]);
            }
        }
        if ($request->hasFile('files')) {
    foreach ($request->file('files') as $file) {
        $path = $file->store('product_files', 'public');
        $product->files()->create([
            'name' => $file->getClientOriginalName(),
            'path' => $path,
            'extension' => $file->getClientOriginalExtension(),
        ]);
    }
}


        return redirect()->route('admin.products.index')->with('success', 'Produto atualizado com sucesso.');
    }

    public function destroy(Product $product)
    {
        // Apaga imagens
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
        }

        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produto removido com sucesso.');
    }
    //controller pra exxibir detalhes do produto
    public function show(Product $product)
    {
        return inertia('Admin/Products/Show', compact('product'));
    }



}
