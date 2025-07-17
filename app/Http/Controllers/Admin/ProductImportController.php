<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\ProductsImport;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
  use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class ProductImportController extends Controller
{

public function showImportForm()
{
    return Inertia::render('Admin/Products/Import');
}
    

public function import(Request $request)
{
    Excel::import(new ProductsImport, $request->file('file'));
    return back()->with('success', 'Importação concluída!');
}

public function importPreview(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls,csv',
    ]);

    $import = new ProductsImport();
    Excel::import($import, $request->file('file'));

    $rows = $import->getRows();

    $products = $rows->map(function ($row) {
        return [
            'name'     => $row[0] ?? '',
            'slug'     => Str::slug($row[0] ?? ''),
            'price'    => $row[1] ?? 0,
            'category' => $row[2] ?? '',
        ];
    });

    return Inertia::render('Admin/Products/ImportPreview', [
        'products' => $products,
    ]);
}

public function importConfirm(Request $request)
{
    $validated = $request->validate([
        'products' => 'required|array',
        'products.*.name' => 'required|string',
        'products.*.slug' => 'required|string',
        'products.*.price' => 'required|numeric',
        'products.*.category' => 'nullable|string',
    ]);

    foreach ($validated['products'] as $data) {
        Product::create([
            'name'     => $data['name'],
            'slug'     => $data['slug'],
            'price'    => $data['price'],
            // 'category_id' => lógica para buscar categoria por nome ou criar, se quiser
        ]);
    }

    return redirect()->route('admin.products.index')->with('success', 'Produtos importados com sucesso!');
}


    public function preview(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        $import = new ProductsImport();
        Excel::import($import, $request->file('file'));

        $rows = $import->getRows();

        return Inertia::render('Admin/Products/ImportPreview', [
            'rows' => $rows,
        ]);
    }
}
