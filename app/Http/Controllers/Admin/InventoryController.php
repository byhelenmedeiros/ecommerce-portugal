<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;

class InventoryController extends Controller
{
    public function index()
    {
        return Inventory::with('product')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:0',
            'alert_threshold' => 'nullable|integer|min:0',
        ]);

        $inventory = Inventory::create($data);
        return response()->json($inventory, 201);
    }

    public function show(Inventory $inventory)
    {
        return $inventory->load('product');
    }

    public function update(Request $request, Inventory $inventory)
    {
        $data = $request->validate([
            'qty' => 'required|integer|min:0',
            'alert_threshold' => 'nullable|integer|min:0',
        ]);

        $inventory->update($data);
        return response()->json($inventory);
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();
        return response()->json(['message' => 'Inventário removido com sucesso.']);
    }
}
