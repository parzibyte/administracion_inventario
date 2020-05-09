<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearAdjuntosDeArticulos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adjuntos_articulos', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string("ruta", 255);
            $table->enum("tipo", ["REGISTRO", "BAJA"]);
            $table->unsignedInteger("articulos_id");
            $table->foreign("articulos_id")
                ->references("id")
                ->on("articulos")
                ->onDelete("cascade")
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
        Schema::dropIfExists('adjuntos_articulos');
    }
}
