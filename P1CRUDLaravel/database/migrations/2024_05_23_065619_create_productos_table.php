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
        Schema::create('productos', function (Blueprint $table) {
            $table->bigIncrements('id_producto');
            $table->string('nombre', 100)->notNullable();
            $table->unsignedBigInteger('id_categoria'); // Cambiado a unsignedBigInteger
            $table->foreign('id_categoria')->references('id_categoria')->on('categorias'); // Corregido references
            $table->decimal('pv', 10, 2)->notNullable(); // Precio de Venta
            $table->decimal('pc', 10, 2)->notNullable(); // Precio de Compra
            $table->date('fecha_compra')->nullable();
            $table->string('colores', 100)->nullable();
            $table->string('descripcion_corta', 255)->nullable();
            $table->text('descripcion_larga')->nullable();
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
