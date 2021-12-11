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
            $table->id();
            $table->unsignedBigInteger('id_interfazs');
            $table->foreign('id_interfazs')->references('id')->on('interfazs')->onDelete('cascade');
            $table->string('nombre');
            $table->longText('descripcion')->nullable();
            $table->longText('urlimagen')->nullable();
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
        Schema::dropIfExists('interfaz_contenidos');
        Schema::table('interfaz_contenidos',function(Blueprint $table){
        $table->dropForeign(['id_interfazs']);
        $table->dropColumn('id_interfazs');
    });
    }
}

