<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
  protected $fillable = [
    'name',
    'email',
    'password',
    'phone',
    'phone_alt', 
    'birth_date',
    'billing_name',
    'nif',
    'nif_on_invoice',
];

        
  

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
       'email_verified_at' => 'datetime',
    'password' => 'hashed',
    'nif_on_invoice' => 'boolean', 
    ];

    public function profile()
{
    return $this->hasOne(CustomerProfile::class);
}

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
   public function wishlists()
{
    return $this->belongsToMany(Product::class, 'wishlists')->withTimestamps();
}

public function addresses()
{
    return $this->hasMany(Address::class);
}

public function fiscalAddress()
{
    return $this->hasOne(Address::class)->where('type', 'fiscal');
}

public function entregaAddress()
{
    return $this->hasOne(Address::class)->where('type', 'entrega');
}


}
