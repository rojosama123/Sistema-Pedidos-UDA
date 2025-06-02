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
