<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function subcategories()
{
    return $this->hasMany(Subcategory::class);
}
public function scopeMenuItems($query)
{
    return $query->where('show_in_menu', true)
                 ->orderBy('menu_order');
}
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }
    public function parent()
{
    return $this->belongsTo(Category::class, 'parent_id');
}

    

}
