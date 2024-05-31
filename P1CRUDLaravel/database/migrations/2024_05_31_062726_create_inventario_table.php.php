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
        Schema::create('inventario', function (Blueprint $table) {
            $table->bigIncrements('id_inventario');
            $table->unsignedBigInteger('id_producto'); 
            $table->unsignedBigInteger('id_categoria'); 
            $table->foreign('id_producto')->references('id_producto')->on('productos'); // Corregido references
            $table->foreign('id_categoria')->references('id_categoria')->on('categorias'); // Corregido references
            $table->datetime('fecha_movimiento')->nullable();
            $table->text('motivo')->nullable();
            $table->text('movimiento')->nullable();
            $table->integer('cantidad')->notNullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventario');
    }
};
