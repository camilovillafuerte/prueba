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
            $table->string('cedula_usuario');
            $table->string('titulo_convenio');
            //$table->current_timestamp('f_creaciondoc')->default();
            // $table->timestamp('f_creaciondoc')->useCurrent();
            $table->timestamp('f_creaciondoc')->default(convenios::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->enum('estado',['A','D']);
            $table->enum('tipo_documento',['P','G','A']); //Guardado, Plantilla, Aprobado 
            $table->longText('PDF')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('convenios');
    }
}

