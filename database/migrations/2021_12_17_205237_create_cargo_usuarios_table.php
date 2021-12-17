<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCargoUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cargo_usuarios', function (Blueprint $table) {
            $table->id('cargou_id');
            $table->unsignedBigInteger('cedula');
            $table->foreign('cedula')->references('cedula')->on('usuarios')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('cargos_id');
            $table->foreign('cargos_id')->references('cargos_id')->on('cargos')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cargo_usuarios');
        Schema::table('usuarios',function(Blueprint $table){
            $table->dropForeign(['cedula']);
            $table->dropColumn('cedula');
            $table->dropForeign(['cargo_id']);
            $table->dropColumn('cargo_id');
        });
    }
}
