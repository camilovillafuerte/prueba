<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSAprobadasTable extends Migration
{
    protected $connection = 'pgsql';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_aprobadas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('solicitud_id');
            $table->foreign('solicitud_id')->references('id')->on('solicitudes')->onDelete('cascade')->onUpdate('cascade');
            $table->longText('pdf')->nullable();
            $table->timestamp('fecha_creacion');
            $table->enum('tipo',['M','B']); // Movilidad, Becas
            $table->enum('estado',['F','S']); // F= Finalizado , S= Subir Documento


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('s_aprobadas');
    }
}
