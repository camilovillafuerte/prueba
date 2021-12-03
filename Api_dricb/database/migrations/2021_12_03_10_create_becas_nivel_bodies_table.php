<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBecasNivelBodiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('becas_nivel_bodies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_becas_nivels');
            $table->foreign('id_becas_nivels')->references('id')->on('becas_nivels')->onDelete('cascade');
            $table->string('nombre');
            $table->string('pais');
            $table->string('idioma');
            $table->string('area_estudio');
            $table->string('fecha_postulacion');
            $table->string('modalidad');
            $table->longText('requisitos'); 
            $table->longText('pdf');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('becas_nivel_bodies');
    }
}
