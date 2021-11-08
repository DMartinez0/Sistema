<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 200);
            $table->string('identidad', 200)->nullable(true);
            $table->string('direccion', 100)->nullable(true);
            $table->string('telefono', 25);
            $table->string('email', 50)->nullable(true);;
            $table->string('nacimiento', 25)->nullable(true);
            $table->string('documento', 30)->nullable(true);
            $table->string('registro', 25)->nullable(true);
            $table->string('cliente', 200)->nullable(true);
            $table->string('giro', 100)->nullable(true);
            $table->string('departamento_doc', 35)->nullable(true);
            $table->string('direccion_doc', 100)->nullable(true);
            $table->integer('edo');
            $table->string('comentarios', 250)->nullable(true);

            $table->string('clave', 25)->nullable(true);
            $table->string('tiempo', 25)->nullable(true);
            $table->integer('td')->nullable(true);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
