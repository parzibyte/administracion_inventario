<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarClaveForaneaAreasArticulosEliminados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articulos_eliminados', function (Blueprint $table) {
            $table->unsignedInteger("areas_id");
            $table->foreign("areas_id")
                ->references("id")
                ->on("areas")
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
        Schema::table('articulos_eliminados', function (Blueprint $table) {
            $table->dropForeign("articulos_eliminados_areas_id_foreign");
            $table->dropColumn(["areas_id"]);
        });
    }
}
