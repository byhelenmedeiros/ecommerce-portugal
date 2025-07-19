<?php
namespace App\Http\Controllers\Shop;


use App\Models\Product; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Http\Controllers\Controller;

class WishlistController extends Controller
{
public function index(Request $request)
{
    $wishlist = Auth::user()->wishlist()->with('images')->get();

    return response()->json([
        'ok' => true,
        'data' => $wishlist
    ]);
}


/**
 * Get the image URL for a product.
 *
 * @param  \App\Models\Product  $product
 * @return string
 */
public function getImageUrl(Product $product)
{
    return $product->featuredImage
        ? asset('storage/' . $product->featuredImage->path)
        : 'https://via.placeholder.com/400x300?text=Sem+Imagem';
}


public function store(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id'
    ]);

    Auth::user()->wishlist()->syncWithoutDetaching([$request->product_id]);

    return response()->json(['success' => true]);
}

public function destroy(Product $product)
{
    Auth::user()->wishlist()->detach($product->id);

    return response()->json(['success' => true]);
}

}
