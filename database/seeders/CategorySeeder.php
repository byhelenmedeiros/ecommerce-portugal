<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Vinhos', 'slug' => 'vinhos'],
            ['name' => 'Queijos', 'slug' => 'queijos'],
            ['name' => 'Azeites', 'slug' => 'azeites'],
            ['name' => 'Doces', 'slug' => 'doces'],
            ['name' => 'Artesanato', 'slug' => 'artesanato'],
            ['name' => 'Cestas Regionais', 'slug' => 'cestas-regionais'],
            ['name' => 'Sabores do Norte', 'slug' => 'sabores-do-norte'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
