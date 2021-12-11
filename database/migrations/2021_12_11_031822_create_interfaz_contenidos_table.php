<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterfazContenidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interfaz_contenidos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_interfaz');
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->longText('descripcion')->nullable();
            $table->foreign('id_interfaz')->references('id')->on('interfazs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interfaz_contenidos');
        Schema::table('interfaz_contenidos',function(Blueprint $table){
        $table->dropForeign(['id_interfaz']);
        $table->dropColumn('id_interfaz');
    });
    }
}

