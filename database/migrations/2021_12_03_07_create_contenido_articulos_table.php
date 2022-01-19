<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContenidoArticulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contenido_articulos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_contenidos');
            $table->unsignedBigInteger('id_articulos');
            $table->foreign('id_contenidos')->references('id')->on('contenidos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_articulos')->references('id')->on('articulos')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contenido_articulos');
        // Schema::table('contenido_articulos',function(Blueprint $table){
        //     $table->dropForeign(['id_contenidos']);
        //     $table->dropColumn('id_contenidos');
        //     $table->dropForeign(['id_articulos']);
        //     $table->dropColumn('id_articulos');
        // });
    }
}

