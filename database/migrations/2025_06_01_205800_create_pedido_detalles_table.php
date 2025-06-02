<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidoDetallesTable extends Migration
{
    public function up()
    {
        Schema::create('pedido_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained('pedidos')->onDelete('cascade');
            $table->string('plato');
            $table->decimal('precio', 8, 2)->default(0.00);
            $table->string('nota_cliente')->nullable();
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('pedido_detalles');
    }
}