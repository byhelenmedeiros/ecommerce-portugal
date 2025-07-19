<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AddressController extends Controller
{

public function show()
{
    $user = Auth::user();

   return Inertia::render('Account/Tabs/Morada', [
    'fiscal' => $user->addresses()->where('type', 'fiscal')->first() ?? (object) [],
    'entrega' => $user->addresses()->where('type', 'entrega')->first() ?? (object) [],
]);



}


    public function edit()
    {
        $user = Auth::user();

       return Inertia::render('Account/Tabs/Morada', [
    'fiscal' => Auth::user()->fiscalAddress, 
    'entrega' => Auth::user()->entregaAddress,
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
            'door' => 'nullable|string|max:50',
            'floor' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:100',
            'district' => 'nullable|string|max:100',
            
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
   public function destroyEntrega()
{
    $user = Auth::user();
    $address = $user->addresses()->where('type', 'entrega')->first();
    if (!$address) {
        return redirect()->back()->with('error', 'Morada de entrega não encontrada.');
    }

    if ($address) {
        $address->delete();
    }

    return redirect()->back()->with('success', 'Morada de entrega removida com sucesso.');
}
    public function destroyFiscal()
    {
     $user = Auth::user();
     $address = $user->addresses()->where('type', 'fiscal')->first();
     if (!$address) {
          return redirect()->back()->with('error', 'Morada fiscal não encontrada.');
     }
    
     if ($address) {
          $address->delete();
     }
    
     return redirect()->back()->with('success', 'Morada fiscal removida com sucesso.');
    }

}
