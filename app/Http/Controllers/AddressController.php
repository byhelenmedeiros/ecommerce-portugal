<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AddressController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        return Inertia::render('Account/Tabs/Morada', [
            'fiscal' => $user->fiscalAddress,
            'entrega' => $user->entregaAddress,
        ]);
    }

    public function updateFiscal(Request $request)
    {
        return $this->saveAddress($request, 'fiscal');
    }

    public function updateEntrega(Request $request)
    {
        return $this->saveAddress($request, 'entrega');
    }

    private function saveAddress(Request $request, string $type)
    {
        $data = $request->validate([
            'address' => 'required|string|max:255',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
        ]);

        $user = Auth::user();

        $address = $user->addresses()->where('type', $type)->first();

        if ($address) {
            $address->update($data);
        } else {
            $user->addresses()->create(array_merge($data, ['type' => $type]));
        }

        return redirect()->back()->with('success', 'Morada ' . $type . ' atualizada com sucesso.');
    }
}
