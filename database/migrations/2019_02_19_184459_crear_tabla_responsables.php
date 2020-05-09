<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaResponsables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responsables', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("areas_id");
            $table->foreign("areas_id")
                ->references("id")
                ->on("areas")
                ->onDelete("cascade")
                ->onUpdate("cascade");
            $table->timestamps();
            $table->string("nombre", 255);
            $table->string("direccion", 255);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('responsables');

    }
}
