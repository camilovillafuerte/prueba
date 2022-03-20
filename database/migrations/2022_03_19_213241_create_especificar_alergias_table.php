<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEspecificarAlergiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('especificar_alergias', function (Blueprint $table) {
            $table->id();
            $table->foreign('solicitud_id')->references('id')->on('solicitud_modalidades')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('solicitud_id');
            $table->foreign('alergias_id')->references('id')->on('alergias')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('alergias_id');
            $table->string('especificar_alergia');
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
        Schema::dropIfExists('especificar_alergias');
    }
}
