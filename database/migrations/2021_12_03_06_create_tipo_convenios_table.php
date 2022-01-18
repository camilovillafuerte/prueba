<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoConveniosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('tipo_convenios', function (Blueprint $table) {
            $table->id();
            //$table->string('nombre_tc');
            $table->unsignedBigInteger('nombretc_id');
            $table->foreign('nombretc_id')->references('id')->on('nombre_tipoconvenios')->onDelete('cascade')->onUpdate('cascade');
            $table->longText('descripcion_tc')->nullable();
            $table->unsignedBigInteger('id_convenios');
            $table->unsignedBigInteger('id_convenios_especificos');
            $table->foreign('id_convenios')->references('id')->on('convenios')->onDelete('cascade');
            $table->foreign('id_convenios_especificos')->references('id')->on('convenios_especificos')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipo_convenios');
        // Schema::table('tipo_convenios',function(Blueprint $table){
        //     $table->dropForeign(['id_convenios']);
        //     $table->dropColumn('id_convenios');
        //     $table->dropForeign(['id_convenios_especificos']);
        //     $table->dropColumn('id_convenios_especificos');
        // });
    }
}
