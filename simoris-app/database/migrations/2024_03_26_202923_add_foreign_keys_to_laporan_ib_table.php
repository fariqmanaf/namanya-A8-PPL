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
        Schema::table('laporan_ib', function (Blueprint $table) {
            $table->foreign(['id_sapi'], 'laporan_ib_ibfk_1')->references(['id'])->on('data_sapi')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_peternak'], 'laporan_ib_ibfk_2')->references(['id'])->on('individuals')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_mantri'], 'laporan_ib_ibfk_3')->references(['id'])->on('individuals')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('laporan_ib', function (Blueprint $table) {
            $table->dropForeign('laporan_ib_ibfk_1');
            $table->dropForeign('laporan_ib_ibfk_2');
            $table->dropForeign('laporan_ib_ibfk_3');
        });
    }
};
