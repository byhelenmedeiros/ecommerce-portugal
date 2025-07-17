<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;

class ProductsImport implements ToModel
{
    public function model(array $row)
    {
        return new Product([
            'name'        => $row[0],
            'slug'        => Str::slug($row[0]),
            'price'       => $row[1],
            'stock'       => $row[2],
            'category_id' => $row[3],
        ]);
    }
}
