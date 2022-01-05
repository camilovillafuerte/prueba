<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirmaEmisorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firma_emisors', function (Blueprint $table) {
            $table->id();
            $table->String('titulo_academico');
            $table->string('nombre_emisor');
            $table->string('cargo_emisor');
            $table->string('institucion_emisor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('firma_emisors');
    }
}
