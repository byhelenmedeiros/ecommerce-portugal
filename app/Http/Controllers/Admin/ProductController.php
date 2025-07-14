<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Region;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category', 'region');

        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->region_id) {
            $query->where('region_id', $request->region_id);
        }
        
    if ($request->filled('sort')) {
        $query->orderBy($request->sort, $request->input('direction', 'asc'));
    }


        $products = Product::with('category', 'region')
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->when($request->category_id, fn($q) => $q->where('category_id', $request->category_id))
            ->when($request->region_id, fn($q) => $q->where('region_id', $request->region_id))
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

      return inertia('Admin/Products/Index', [
        'products' => $products,
        'filters' => $request->only(['search', 'category_id', 'region_id']),
        'categories' => Category::all(),
        'regions' => Region::all(),
        'sortField' => $request->sort,
        'sortDirection' => $request->direction
    ]);
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

        $product = Product::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $product->images()->create(['path' => $path]);
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
