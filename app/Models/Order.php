<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
   protected $fillable = [
    'user_id',
    'fiscal_address_id',
    'entrega_address_id',
    'status',
    'subtotal',
    'shipping_cost',
    'discount',
    'total',
    'payment_method',
    'shipping_method',
    'admin_note',
    'payment_proof',
];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
   
}
