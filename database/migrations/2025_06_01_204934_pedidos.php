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
            $table->unsignedBigInteger('user_id'); // Relación con el usuario que realiza el pedido
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->date('fecha');
            $table->time('hora');
            $table->string('estado');
            $table->string('casino');  
            $table->timestamps(); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
}
