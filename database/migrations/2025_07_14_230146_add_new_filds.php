<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Logística
            $table->string('sku')->nullable()->unique()->after('slug');
            $table->string('barcode')->nullable()->after('sku');
            $table->json('dimensions')->nullable()->after('weight'); // height, width, depth
            $table->integer('low_stock_threshold')->nullable()->after('stock');
            $table->boolean('shipping_required')->default(true)->after('low_stock_threshold');

            // Destaque e Promoções
            $table->boolean('bestseller')->default(false)->after('highlighted');
            $table->boolean('novidade')->default(false)->after('bestseller');
            $table->date('promo_start')->nullable()->after('discount');
            $table->date('promo_end')->nullable()->after('promo_start');
            $table->integer('featured_order')->nullable()->after('promo_end');

            // Estatísticas
            $table->unsignedInteger('views')->default(0)->after('seo_description');
            $table->unsignedInteger('sales_count')->default(0)->after('views');

            // Internos
            $table->text('admin_notes')->nullable()->after('attributes');
            $table->unsignedBigInteger('created_by')->nullable()->after('admin_notes');
            $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'sku', 'barcode', 'dimensions', 'low_stock_threshold', 'shipping_required',
                'bestseller', 'novidade', 'promo_start', 'promo_end', 'featured_order',
                'views', 'sales_count',
                'admin_notes', 'created_by', 'updated_by'
            ]);
        });
    }
};
