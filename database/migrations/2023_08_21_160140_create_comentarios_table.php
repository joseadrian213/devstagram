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
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');#Lo que hace contrained es buscar la tabla autyomaticamente para realizar la realicion en este caso con la tabla que trae por defecto laravel que es user 
            $table->foreignId('post_id')->constrained()->onDelete('cascade');#El onDelete se utiliza para que una vez eliminada la publicacion con la que estan relacionados los comentarios se eliminen tambien los comentarios con los que se encuentra relacionado   
            $table->string('comentario'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comentarios');
    }
};
