<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Product;
use App\Policies\ProductPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Category;
use App\Policies\CategoryPolicy;
use App\Models\Region;
use App\Policies\RegionPolicy;
use App\Models\Order;
use App\Policies\OrderPolicy;
use App\Models\OrderItem;
use App\Policies\OrderItemPolicy;
use App\Models\Inventory;
use App\Policies\InventoryPolicy;
use App\Models\ProductImage;
use App\Policies\ProductImagePolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
   protected $policies = [
    Product::class => ProductPolicy::class,
     Category::class      => CategoryPolicy::class,
    Region::class        => RegionPolicy::class,
    Order::class         => OrderPolicy::class,
    OrderItem::class     => OrderItemPolicy::class,
    Inventory::class     => InventoryPolicy::class,
    ProductImage::class  => ProductImagePolicy::class,
];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
