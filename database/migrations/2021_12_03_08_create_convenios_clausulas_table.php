<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConveniosClausulasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('convenios_clausulas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_convenios');
            $table->unsignedBigInteger('id_clausulas');
            $table->unsignedBigInteger('id_contenidos');
            $table->foreign('id_convenios')->references('id')->on('convenios')->onDelete('cascade');
            $table->foreign('id_clausulas')->references('id')->on('clausulas')->onDelete('cascade');
            $table->foreign('id_contenidos')->references('id')->on('contenidos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('convenios_clausulas');
    //     Schema::table('convenios_clausulas',function(Blueprint $table){
    //         $table->dropForeign(['id_convenios']);
    //         $table->dropColumn('id_convenios');
    //         $table->dropForeign(['id_clausulas']);
    //         $table->dropColumn('id_clausulas');
    //         $table->dropForeign(['id_contenidos']);
    //         $table->dropColumn('id_contenidos');
    //     });
     }
}
