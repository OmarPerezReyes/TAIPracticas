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
        Schema::create('inventarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_producto')->constrained('productos');
            $table->foreignId('id_categoria')->constrained('categorias');
            $table->date('fecha_entrada')->nullable();
            $table->date('fecha_salida')->nullable();
            $table->text('motivo')->nullable();
            $table->enum('movimiento', ['Entrada', 'Salida']);
            $table->integer('cantidad')->notNullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventarios');
    }
};
