<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerProfile;
use Illuminate\Support\Facades\Auth;

class CustomerProfileController extends Controller
{
    public function edit()
    {
        $profile = Auth::user()->profile ?? new CustomerProfile(['user_id' => Auth::id()]);
        return inertia('Account/EditProfile', [
            'profile' => $profile,
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
        ]);

        $profile = Auth::user()->profile;
        if ($profile) {
            $profile->update($data);
        } else {
            Auth::user()->profile()->create($data);
        }

        return redirect()->back()->with('success', 'Perfil atualizado com sucesso.');
    }
}
