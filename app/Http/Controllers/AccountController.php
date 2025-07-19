<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class AccountController extends Controller
{
    public function index()
    {
        $user = auth()->user()->load('customerProfile'); 

        return Inertia::render('Account/Index', [
            'user' => $user,
        ]);
    }
}
