<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaArticulosEliminados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulos_eliminados', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->unsignedInteger("responsables_id");
            $table->foreign("responsables_id")
                ->references("id")
                ->on("responsables")
                ->onDelete("restrict")
                ->onUpdate("cascade");
            $table->date("fecha_adquisicion");
            $table->string("codigo", 255);
            $table->string("numero_folio_comprobante", 255)->nullable();
            $table->string("descripcion", 255);
            $table->string("marca", 255);
            $table->string("modelo", 255);
            $table->string("serie", 255);
            $table->string("estado", 255);
            $table->string("observaciones", 255)->nullable();
            $table->unsignedDecimal("costo_adquisicion", 10, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articulos_eliminados');
    }
}
