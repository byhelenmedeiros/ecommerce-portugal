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
    'short_description',
    'long_description',
    'price',
    'discount',
    'category_id',
    'region_id',
    'weight',
    'stock',
    'is_visible',
    'highlighted',
    'condition',
    'launch_date',
    'seo_title',
    'seo_description',
    'tags',
    'attributes',
    'created_at',
    'updated_at',

];

protected $casts = [
    'tags' => 'array',
    'attributes' => 'array',
    'launch_date' => 'date',
    'is_visible' => 'boolean',
    'highlighted' => 'boolean',
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

public function addImages($images)
{
    foreach ($images as $image) {
        $this->images()->create([
            'path' => $image->store('products', 'public'),
            'is_featured' => false,
        ]); 
    }
}
public function files()
{
    return $this->hasMany(ProductFile::class);
}


    
}
