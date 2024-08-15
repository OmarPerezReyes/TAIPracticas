<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailsOrderTable extends Migration
{
    public function up()
    {
        Schema::create('details_order', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('price', 15, 3); // El precio del producto en el momento de la compra
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('details_order');
    }
}