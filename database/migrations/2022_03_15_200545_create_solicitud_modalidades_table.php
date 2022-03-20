<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudModalidadesTable extends Migration
{
    protected $connection = 'pgsql';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitud_modalidades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('personal_id');
            $table->foreign('personal_id','constrainfk')->references('idpersonal')->on('esq_datos_personales.personal')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('universidad_id');
            $table->foreign('universidad_id')->references('iduniversidad')->on('esq_datos_personales.p_universidad')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('escuela_id');
            $table->foreign('escuela_id')->references('idescuela')->on('esq_inscripciones.escuela')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('naturaleza_id');
            $table->foreign('naturaleza_id')->references('id')->on('natu_intercambios')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('modalidad1_id');
            $table->foreign('modalidad1_id')->references('id')->on('modalidades')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('modalidad2_id');
            $table->foreign('modalidad2_id')->references('id')->on('modalidades')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('becas_id');
            $table->foreign('becas_id')->references('id')->on('becas_apoyos')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('montos_id');
            $table->foreign('montos_id')->references('id')->on('m_montos')->onDelete('cascade')->onUpdate('cascade');
            $table->string('carrera_destino');
            $table->string('semestre_cursar');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->timestamp('fcreacion_solicitud');
            $table->longText('PDF')->nullable();
            $table->enum('estado_solicitud',['A','P','R']); //Aprobado, Pendiente, Rechazado
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
        Schema::dropIfExists('solicitud_modalidades');
    }
}
