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
            $table->longText('nombre')->nullable();
            $table->string('pais')->nullable();
            $table->string('idioma')->nullable();
            $table->longText('area_estudio')->nullable();
            $table->string('fecha_postulacion')->nullable();
            $table->longText('modalidad')->nullable();
            $table->longText('requisitos')->nullable(); 
            $table->longtext('reconocimiento_titulo')->nullable();
            $table->longText('pdf')->nullable();
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
        Schema::dropIfExists('becas_nivel_bodies');
    }
}
