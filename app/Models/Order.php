<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Order extends Model
{

    use LogsActivity;

   
    protected static $logAttributes = ['total', 'status', 'payment_method'];
    protected static $logName = 'pedido';
    protected static $logOnlyDirty = true;

    public function getActivitylogOptions(): \Spatie\Activitylog\LogOptions
    {
        return \Spatie\Activitylog\LogOptions::defaults()
            ->logOnly(['status', 'total'])
            ->useLogName('order');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Order was {$eventName}";
    }
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
