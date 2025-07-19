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
'user' => Auth::user()->load('fiscalAddress', 'entregaAddress'),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
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
