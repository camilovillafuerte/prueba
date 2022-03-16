<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmAprobadasTable extends Migration
{
    protected $connection = 'pgsql';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sm_aprobadas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('solicitud_id');
            $table->foreign('solicitud_id')->references('id')->on('solicitud_modalidades')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('personal_id');
            $table->foreign('personal_id','constrainfk')->references('idpersonal')->on('esq_datos_personales.personal')->onDelete('cascade')->onUpdate('cascade');
            $table->longText('PDF')->nullable();
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
        Schema::dropIfExists('sm_aprobadas');
    }
}
