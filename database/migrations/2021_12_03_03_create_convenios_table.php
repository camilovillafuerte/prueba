<?php

use App\Models\convenios;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConveniosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('convenios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('femisor_id');
            $table->foreign('femisor_id')->references('id')->on('firmas')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('freceptor_id');
            $table->foreign('freceptor_id')->references('id')->on('firmas')->onDelete('cascade')->onUpdate('cascade');
            $table->string('titulo_convenio');
            $table->timestamp('f_creaciondoc')->default(convenios::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->enum('estado',['A','D']);
            $table->enum('tipo_documento',['P','G','A']); //Guardado, Plantilla, Aprobado
            $table->longText('PDF')->nullable();
            $table->time('fecha_firma')->nullable();
            $table->time('fecha_fin')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){

        Schema::dropIfExists('convenios');
    }
}

