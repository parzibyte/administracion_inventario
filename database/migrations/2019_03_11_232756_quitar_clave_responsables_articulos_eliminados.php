<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class QuitarClaveResponsablesArticulosEliminados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articulos_eliminados', function (Blueprint $table) {
            $table->dropForeign("articulos_eliminados_responsables_id_foreign");
            $table->dropColumn(["responsables_id"]);
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
            $table->unsignedInteger("responsables_id");
            $table->foreign("responsables_id")
                ->references("id")
                ->on("responsables")
                ->onDelete("restrict")
                ->onUpdate("cascade");
        });
    }
}
