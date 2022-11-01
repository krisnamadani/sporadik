<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data', function (Blueprint $table) {
            $table->dropColumn('hasil_pekerjaan_yang_diterima');
            $table->dropColumn('no_seri_sertipikat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data', function (Blueprint $table) {
            $table->string('hasil_pekerjaan_yang_diterima');
            $table->string('no_seri_sertipikat');
        });
    }
};
