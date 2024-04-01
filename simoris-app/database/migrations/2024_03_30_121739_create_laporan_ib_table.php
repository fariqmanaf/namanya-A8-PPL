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
            $table->id();
            $table->integer('data_sapi_id')->index('id_sapi');
            $table->integer('kode_pejantan')->nullable();
            $table->integer('kode_pembuatan')->nullable();
            $table->boolean('status_bunting')->nullable()->default(false);
            $table->foreignId('individuals_id')->index('id_user');
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
