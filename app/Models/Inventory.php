<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        'product_id',
        'qty',
        'alert_threshold',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
