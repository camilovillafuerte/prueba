<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuncionalidadUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funcionalidad_usuarios', function (Blueprint $table) {
            $table->id('fusuarios_id');
            $table->unsignedBigInteger('cedula');
            $table->foreign('cedula')->references('cedula')->on('usuarios')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('funcion_id');
            $table->foreign('funcion_id')->references('funcion_id')->on('funcionalidads')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('funcionalidad_usuarios');
        Schema::table('usuarios',function(Blueprint $table){
            $table->dropForeign(['cedula']);
            $table->dropColumn('cedula');
            $table->dropForeign(['funcion_id']);
            $table->dropColumn('funcion_id');
        });
       
    }
}
