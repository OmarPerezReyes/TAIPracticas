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
            $table->string('product_name');
            $table->integer('category_id');
            $table->integer('supplier_id');
            $table->string('product_code')->nullable();
            $table->integer('product_garage'); // Cambiado a integer para cantidad
            $table->string('product_image')->nullable();
            $table->text('short_description')->nullable(); // Descripción corta
            $table->text('long_description')->nullable();  // Descripción larga
            $table->date('buying_date')->nullable();
            $table->date('expire_date')->nullable(); // Cambiado a date para fecha
            $table->decimal('buying_price', 15, 3)->nullable(); // Cambiado a decimal
            $table->decimal('selling_price', 15, 3)->nullable(); // Cambiado a decimal
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
