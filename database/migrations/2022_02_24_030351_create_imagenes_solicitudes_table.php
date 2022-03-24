<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagenesSolicitudesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imagenes_solicitudes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('imagenescon_id');
            $table->foreign('imagenescon_id')->references('id')->on('imagenes_convenios')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('estado',['A','D']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('imagenes_solicitudes');
    }
}
