<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductFile extends Model
{
    protected $fillable = ['name', 'path', 'extension'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
