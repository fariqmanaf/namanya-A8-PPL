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
        Schema::table('total_ib', function (Blueprint $table) {
            $table->foreign(['id_laporan'], 'total_ib_ibfk_1')->references(['id'])->on('laporan_ib')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_semen'], 'total_ib_ibfk_2')->references(['id'])->on('jenis_semen')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('total_ib', function (Blueprint $table) {
            $table->dropForeign('total_ib_ibfk_1');
            $table->dropForeign('total_ib_ibfk_2');
        });
    }
};
