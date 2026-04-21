<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sku')->unique();
            $table->string('category');
            $table->string('image')->default('📦');
            $table->decimal('price', 10, 2);
            $table->integer('stock')->default(0);
            $table->integer('reorder_level')->default(10);
            $table->timestamps();

            $table->index('name');
            $table->index('category');
            $table->index('stock');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
