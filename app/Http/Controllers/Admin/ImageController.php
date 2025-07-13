<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\ProductImage;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'image' => 'required|image|max:2048',
        ]);

        $path = $request->file('image')->store('products', 'public');

        $image = ProductImage::create([
            'product_id' => $request->product_id,
            'path' => $path,
            'is_featured' => $request->boolean('is_featured'),
        ]);

        return response()->json(['image' => $image], 201);
    }

    public function destroy(ProductImage $image)
    {
        Storage::disk('public')->delete($image->path);
        $image->delete();

        return response()->json(['message' => 'Imagem removida com sucesso.']);
    }
}
