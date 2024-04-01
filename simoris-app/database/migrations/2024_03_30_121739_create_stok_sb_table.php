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
        Schema::create('stok_sb', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kecamatan_id')->index('id_kecamatan');
            $table->integer('jenis_semen_id')->index('id_jenis');
            $table->integer('jumlah')->nullable();
            $table->integer('used')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stok_sb');
    }
};
