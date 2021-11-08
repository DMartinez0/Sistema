<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorteDeCajasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corte_de_cajas', function (Blueprint $table) {
            $table->id();
            $table->string('aperturaT', 25)->nullable(true);
            $table->timestamp('apertura', $precision = 0);
            $table->string('cierreT', 25)->nullable(true);
            $table->timestamp('cierre', $precision = 0)->nullable(true);
            $table->integer('ordenes')->nullable(true);
            $table->integer('productos')->nullable(true);
            $table->integer('clientes')->nullable(true);
            $table->double('efectivo_inicial', 8, 4)->nullable(true);
            $table->double('efectivo_final', 8, 4)->nullable(true);
            $table->double('total_efectivo', 8, 4)->nullable(true);
            $table->double('total_tarjeta', 8, 4)->nullable(true);
            $table->double('total_btc', 8, 4)->nullable(true);
            $table->double('total_venta', 8, 4)->nullable(true);
            $table->double('propina_efectivo', 8, 4)->nullable(true);
            $table->double('propina_no_efectivo', 8, 4)->nullable(true);
            $table->double('gastos', 8, 4)->nullable(true);
            $table->double('remesas', 8, 4)->nullable(true);
            $table->double('abonos', 8, 4)->nullable(true);
            $table->double('diferencia', 8, 4)->nullable(true);
            $table->integer('numero_caja')->nullable(true);
            $table->integer('edo')->nullable(true);
            // $table->string('usuario', 25);
            // $table->string('usuario_corte', 25)->nullable(true);

            $table->unsignedBigInteger('usuario')->nullable(true); // categoria
            $table->foreign('usuario')
                    ->references('id')
                    ->on('users');

            $table->unsignedBigInteger('usuario_corte')->nullable(true); // categoria
            $table->foreign('usuario_corte')
                    ->references('id')
                    ->on('users');


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
        Schema::dropIfExists('corte_de_cajas');
    }
}
