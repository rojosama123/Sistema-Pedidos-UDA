<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class pedidos extends Migration
{
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('menu');
            $table->date('fecha');
            $table->time('hora');
            $table->text('nota_cliente')->nullable();
            $table->string('estado');
            $table->string('casino');   
        });
    }

    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
}
