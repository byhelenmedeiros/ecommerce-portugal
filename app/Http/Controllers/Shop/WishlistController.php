<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    public function index()
    {
        $items = Wishlist::with('product')->where('user_id', Auth::id())->get();
        return inertia('Shop/Wishlist', compact('items'));
    }
}
