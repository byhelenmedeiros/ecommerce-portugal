<?php   


namespace App\Http\Controllers;

use App\Models\Category;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $menuCategories = Category::menuItems()->take(7)->get();

        return Inertia::render('Shop/Home', [
            'menuCategories' => $menuCategories,
        ]);
    }
}
