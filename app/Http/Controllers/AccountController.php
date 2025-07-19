<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AccountController extends Controller
{
    public function index()
    {
      return Inertia::render('Account/Index', [
    'user' => [
        'id' => Auth::id(),
        'name' => Auth::user()->name,
        'email' => Auth::user()->email,
        'created_at' => Auth::user()->created_at,
        'fiscalAddress' => Auth::user()->fiscalAddress,
        'entregaAddress' => Auth::user()->entregaAddress,
        'phone' => Auth::user()->phone,
        'birth_date' => Auth::user()->birth_date,
        'billing_name' => Auth::user()->billing_name,
        'nif' => Auth::user()->nif,
        'nif_on_invoice' => Auth::user()->nif_on_invoice,
        'orders' => Auth::user()->orders,
        'wishlist' => Auth::user()->wishlist,
    ],

]);

    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'billing_name' => 'nullable|string|max:255',
            'nif' => 'nullable|string|max:9',
            'nif_on_invoice' => 'nullable|boolean',
        ]);

        auth()->user()->update($request->only('name', 'email'));

        return redirect()->back()->with('success', 'Dados atualizados com sucesso.');
    }

    public function destroy()
    {
        auth()->user()->delete();
        return redirect('/')->with('success', 'Conta eliminada com sucesso.');
    }

    //  Dados pessoais em aba separada (SPA)
    public function personalData()
    {
        return Inertia::render('Account/Tabs/DadosPessoais', [
            'user' => Auth::user()
        ]);
    }

    public function updatePersonalData(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
        ]);

        auth()->user()->update($request->only('name', 'email'));

        return redirect()->back()->with('success', 'Dados pessoais atualizados.');
    }
}
