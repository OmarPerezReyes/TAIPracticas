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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id('id_venta');
            $table->foreignId('id_producto')->constrained('productos');
            $table->foreignId('id_categoria')->constrained('categorias');
            $table->foreignId('id_cliente')->constrained('clientes');
            $table->date('fecha_venta')->notNullable();
            $table->decimal('subtotal', 10, 2)->notNullable();
            $table->decimal('iva', 10, 2)->notNullable();
            $table->decimal('total', 10, 2)->notNullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
