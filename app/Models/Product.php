<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'region_id',
        'name',
        'slug',
        'description',
        'price',
        'discount',
        'is_active',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function featuredImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_featured', true);
    }

    public function inventory()
    {
        return $this->hasOne(Inventory::class);
    }

    public function wishlists()
    {
        return $this->belongsToMany(User::class, 'wishlists');
    }
}
