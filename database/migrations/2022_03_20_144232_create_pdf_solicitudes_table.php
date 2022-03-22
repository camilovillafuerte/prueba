<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePdfsolicitudesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pdf_solicitudes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('solicitud_id');
            $table->foreign('solicitud_id')->references('id')->on('solicitudes')->onDelete('cascade')->onUpdate('cascade');
            $table->string('pdfcertificado_matricula')->nullable();
            $table->string('pdfcopia_record')->nullable();
            $table->string('pdfsolicitud_carta')->nullable();
            $table->string('pdfcartas_recomendacion')->nullable();
            $table->string('pdfno_sancion')->nullable();
            $table->string('pdffotos')->nullable();
            $table->string('pdfseguro')->nullable();
            $table->string('pdfexamen_psicometrico')->nullable();
            $table->string('pdfdominio_idioma')->nullable();
            $table->string('pdfdocumentos_udestino')->nullable();
            $table->string('pdfcomprobante_solvencia')->nullable();
            $table->string('pdfcarta_aceptacion')->nullable(); //PDF DE BECAS DE DOCENTES
            $table->string('pdftitulo')->nullable(); //PDF DE BECAS DE DOCENTES
            $table->enum('tipo',['M','B']); // Movilidad, Becas
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pdf_solicitudes');
    }
}
