<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->unsignedInteger('qty')->default(0);
            $table->unsignedInteger('alert_threshold')->default(5);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('inventories');
    }
};