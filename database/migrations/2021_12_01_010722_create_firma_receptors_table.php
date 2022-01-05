<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirmaReceptorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firma_receptors', function (Blueprint $table) {
            $table->id();
            $table->String('titulo_academico');
            $table->string('nombre_receptor');
            $table->string('cargo_receptor');
            $table->string('institucion_receptor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('firma_receptors');
    }
}
