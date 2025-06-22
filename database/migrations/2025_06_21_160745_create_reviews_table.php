<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('comentario');
            $table->unsignedTinyInteger('calificacion'); // 1 a 5
            $table->string('casino')->nullable(); // Casino relacionado, si aplica
            $table->timestamps();
        });
    }
};
