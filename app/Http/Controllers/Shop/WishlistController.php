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
$wishlist = Auth::user()->wishlist()->get();

    if ($request->wantsJson()) {
        return response()->json($wishlist);
    }

    return Inertia::render('Account/Tabs/Wishlist', [
        'wishlist' => $wishlist
    ]);
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
