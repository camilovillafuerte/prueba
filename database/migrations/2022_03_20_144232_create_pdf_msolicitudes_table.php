<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePdfMsolicitudesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pdf_msolicitudes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('solicitud_id');
            $table->foreign('solicitud_id')->references('id')->on('solicitud_modalidades')->onDelete('cascade')->onUpdate('cascade');
            $table->string('pdfcertificado_matricula');
            $table->string('pdfcopia_record');
            $table->string('pdfsolicitud_carta');
            $table->string('pdfcartas_recomendacion');
            $table->string('pdfno_sancion');
            $table->string('pdffotos');
            $table->string('pdfseguro');
            $table->string('pdfexamen_psicometrico');
            $table->string('pdfdominio_idioma')->nullable();
            $table->string('pdfdocumentos_udestino');
            $table->string('pdfcomprobante_solvencia');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pdf_msolicitudes');
    }
}
