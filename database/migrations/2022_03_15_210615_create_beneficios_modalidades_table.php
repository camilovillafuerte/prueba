<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeneficiosModalidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beneficios_modalidades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('solicitud_id');
            $table->foreign('solicitud_id')->references('id')->on('solicitud_modalidades')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('beneficios_id');
            $table->foreign('beneficios_id')->references('id')->on('m_beneficios')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('beneficios_modalidades');
    }
}
