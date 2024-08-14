<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentMethodsTable extends Migration
{
    public function up()
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Seed default payment methods
        DB::table('payment_methods')->insert([
            ['name' => 'Tarjeta de Crédito'],
            ['name' => 'Tarjeta de Débito'],
            ['name' => 'Efectivo'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('payment_methods');
    }
}
