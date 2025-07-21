<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserController extends Controller
{


public function index()
{
    $users = User::whereDoesntHave('roles', function ($query) {
    $query->where('name', 'admin');
})->select('id', 'name', 'email', 'phone', 'created_at')->get();

    return Inertia::render('Admin/Users/Index', [
        'clientes' => $users,
    ]);
}

}
