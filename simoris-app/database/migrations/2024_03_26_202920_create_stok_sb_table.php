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
            $table->integer('id')->primary();
            $table->integer('id_kecamatan')->nullable()->index('id_kecamatan');
            $table->integer('id_jenis')->nullable()->index('id_jenis');
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
