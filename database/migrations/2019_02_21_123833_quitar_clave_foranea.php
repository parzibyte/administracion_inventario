<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class QuitarClaveForanea extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articulos', function (Blueprint $table) {
            $table->dropForeign("articulos_responsables_id_foreign");
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
        Schema::table('articulos', function (Blueprint $table) {
            $table->unsignedInteger("responsables_id");
            $table->foreign("responsables_id")
                ->references("id")
                ->on("responsables")
                ->onDelete("restrict")
                ->onUpdate("cascade");
        });
    }
}
