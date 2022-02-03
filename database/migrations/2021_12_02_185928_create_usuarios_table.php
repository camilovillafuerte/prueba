<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    /**
     * @return void
     */
    public function up()
    {    Schema::create('usuarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('personal_id');
            $table->foreign('personal_id')->references('id')->on('personal')->onDelete('cascade')->onUpdate('cascade');
            $table->string('cedula');
            $table->string('nombres');
            $table->string('apellidos');
            $table->enum('genero',['M','F']);
            $table->string('telefono');
            $table->string('correo');
            $table->string('contrasena');
            $table->string('token')->nullable();
            $table->longText('foto')->nullable();
            $table->enum('estado',['A','D']);
        });
    }
    /**
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
