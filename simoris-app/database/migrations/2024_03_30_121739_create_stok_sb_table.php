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
            $table->foreignId('kecamatan_id')->nullable();
            $table->foreignId('jenis_semen_id')->nullable();
            $table->integer('jumlah');
            $table->integer('used');
            $table->date('periode');
            $table->string('status');
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
