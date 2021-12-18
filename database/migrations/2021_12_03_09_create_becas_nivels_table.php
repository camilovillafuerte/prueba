<?php

use App\Models\becas_nivel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBecasNivelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('becas_nivels', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->enum('tipo',['C','P','I','M','D']);
            $table->enum('estado',['A','D']);
           // $table->timestamp('fecha_creacion')->useCurrent();
            $table->timestamp('fecha_creacion')->default(becas_nivel::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('becas_nivels');
    }
}
