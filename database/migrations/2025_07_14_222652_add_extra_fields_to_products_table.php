<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Descrições
            $table->text('short_description')->nullable()->after('description');
            $table->longText('long_description')->nullable()->after('short_description');

            // Logística
            $table->decimal('weight', 8, 2)->nullable()->after('price');
            $table->integer('stock')->default(0)->after('weight');

            // Visibilidade e estado
            $table->boolean('is_visible')->default(true)->after('stock');
            $table->boolean('highlighted')->default(false)->after('is_visible');
            $table->enum('condition', ['novo', 'usado'])->default('novo')->after('highlighted');
            $table->date('launch_date')->nullable()->after('condition');

            // SEO e tags
            $table->string('seo_title')->nullable()->after('launch_date');
            $table->text('seo_description')->nullable()->after('seo_title');
            $table->json('tags')->nullable()->after('seo_description');

            // Atributos personalizados
            $table->json('attributes')->nullable()->after('tags');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'short_description',
                'long_description',
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
            ]);
        });
    }
};
