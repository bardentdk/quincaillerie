<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->integer('price_cents');
            $table->integer('stock_quantity')->default(0);
            $table->string('sku')->unique();
            $table->json('seo_metadata')->nullable();
            $table->boolean('is_active')->default(true);
            
            // La seule et unique définition de la catégorie
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            
            // Note: 'unit' doit être géré par ta migration 2026_02_03_163227_add_unit_to_products_table.php
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
