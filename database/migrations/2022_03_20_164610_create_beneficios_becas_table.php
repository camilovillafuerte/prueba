<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeneficiosBecasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beneficios_becas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('naturaleza_id');
            $table->foreign('naturaleza_id')->references('id')->on('natu_intercambios')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('beneficios_becas');
    }
}
