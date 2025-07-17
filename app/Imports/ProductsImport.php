<?php


namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class ProductsImport implements ToCollection
{
    public Collection $rows;

    public function collection(Collection $collection)
    {
        if ($collection->first() && $collection->first()->filter()->isNotEmpty()) {
            $this->rows = $collection->slice(1)->values(); 
        } else {
            $this->rows = $collection;
        }
    }

    public function getRows(): Collection
    {
        return $this->rows;
    }
}
