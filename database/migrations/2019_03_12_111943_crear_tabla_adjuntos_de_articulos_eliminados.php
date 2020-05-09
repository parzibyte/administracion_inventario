<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaAdjuntosDeArticulosEliminados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adjuntos_articulos_eliminados', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string("ruta", 255);
            $table->unsignedInteger("articulos_eliminados_id");
            $table->foreign("articulos_eliminados_id")
                ->references("id")
                ->on("articulos_eliminados")
                ->onDelete("restrict")
                ->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adjuntos_articulos_eliminados');
    }
}
