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
            $table->foreignId('data_sapi_id')->nullable();
            $table->foreignId('jenis_semen_id')->nullable();
            $table->date('tgl_ib')->nullable();
            $table->date('tgl_cek')->nullable();
            $table->boolean('status_bunting')->nullable()->default(0);
            $table->foreignId('id_peternak')->nullable()->constrained('individuals');
            $table->foreignId('id_mantri')->nullable()->constrained('individuals');
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
