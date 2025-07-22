<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\Traits\LogsActivity;
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
     * Get the options for activity logging.
     *
     * @return \Spatie\Activitylog\LogOptions
     */
    public function getActivitylogOptions(): \Spatie\Activitylog\LogOptions
    {
        return \Spatie\Activitylog\LogOptions::defaults()
            ->logOnly(['email', 'name'])
            ->logOnlyDirty();
    }

  use LogsActivity;

    protected static $logAttributes = ['name', 'email', 'phone'];
    protected static $logName = 'cliente';
    protected static $logOnlyDirty = true;

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Cliente {$this->name} foi {$eventName}";
    }
  

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
    'newsletter' => 'boolean',
    'lgpd_consent' => 'boolean', 
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
public function wishlist()
{
    return $this->belongsToMany(Product::class, 'wishlists');
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
public function tags()
{
    return $this->belongsToMany(Tag::class);
}

public function customerTags()
{
    return $this->belongsToMany(CustomerTag::class);
}



}
