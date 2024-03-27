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
        Schema::create('laporan_ib', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('id_sapi')->nullable()->index('id_sapi');
            $table->integer('kode_pejantan')->nullable();
            $table->integer('kode_pembuatan')->nullable();
            $table->boolean('status_bunting')->nullable()->default(false);
            $table->integer('id_peternak')->nullable()->index('id_peternak');
            $table->integer('id_mantri')->nullable()->index('id_mantri');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laporan_ib');
    }
};
