<?php

namespace Database\Seeders;

use App\Models\Subcategory;
use App\Models\Category;

class SubcategorySeeder extends \Illuminate\Database\Seeder
{
    public function run(): void
    {
        $vinhos = Category::where('slug', 'vinhos')->first();

        Subcategory::create([
            'name' => 'Vinho Tinto',
            'slug' => 'vinho-tinto',
            'category_id' => $vinhos->id,
        ]);

        Subcategory::create([
            'name' => 'Vinho Branco',
            'slug' => 'vinho-branco',
            'category_id' => $vinhos->id,
        ]);
    }
}
