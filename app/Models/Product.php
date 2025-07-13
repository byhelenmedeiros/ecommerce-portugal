<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
   protected $fillable = [
    'name',
    'slug',
    'description',
    'price',
    'discount',
    'is_active',
    'category_id',
    'subcategory_id',
    'region_id',
];
    use HasFactory;

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
    public function subcategory()
{
    return $this->belongsTo(Subcategory::class);
}

    
}
